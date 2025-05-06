<script>
    $(document).ready(function () {
        /** Valid Url */
        function isValidUrl(url) {
            try {
                new URL(url);
                return true;
            } catch (_) {
                return false;
            }
        }

        function decodeHtmlEntities(str) {
            return str ? $('<div>').html(str).text() : str;
        }

        const formatBody = (type) => (data, row, column, node) => {
            if (type === 'print') {
                if ($(node).find('img').length > 0) {
                    const src = $(node).find('img').attr('src');
                    return `<img src="${src}" style="max-width: 100px; max-height: 100px;" />`;
                }
            } else if (type !== 'print' && ($(node).find('object').length > 0 || $(node).find('img').length > 0)) {
                return $(node).find('object').attr('data') || $(node).find('object img').attr('src') || $(node).find('img').attr('src') || '';
            }
            if ($(node).find('.status-toggle').length > 0) {
                return $(node).find('.status-toggle:checked').length > 0 ? 'Active' : 'Inactive';
            }
            if ($(node).find('.invoice-cell').length > 0) {
                const invoiceNumber = $(node).find('.invoice-number').text().trim();
                const invoiceKey = $(node).find('.invoice-key').text().trim();
                return invoiceNumber + '\n' + invoiceKey;
            }
            return decodeHtmlEntities(data);
        };
        const exportButtons = [
            // 'copy', 'excel', 'csv'
            // , 'pdf'
            // , 'print'
        ].map(type => ({
            extend: type,
            text: type == "copy"
                ? '<i class="fas fa-copy"></i>'
                : (type == "excel"
                    ? '<i class="fas fa-file-excel"></i>'
                    : (type == "csv"
                        ? '<i class="fas fa-file-csv"></i>'
                        : (type == "pdf"
                            ? '<i class="fas fa-file-pdf"></i>'
                            : (type == "print"
                                ? '<i class="fas fa-print"></i>'
                                : "")))),
            orientation: type === 'pdf' ? 'landscape' : undefined,
            exportOptions: {
                columns: function (index, node, column) {
                    const columnHeader = column.textContent.trim().toLowerCase();
                    return columnHeader !== 'action' && !$(node).find('.table-actions').length && !$(node).find('i.fas.fa-edit').length && !$(node).find('i.fas.fa-trash').length && !$(node).find('.deleteBtn').length && !$(node).find('.editBtn').length;
                },
                format: {body: formatBody(type)}
            }
        }));

        var dataTables = [];

        /** Initializing Datatable */
        if ($('.initTable').length) {
            $('.initTable').each(function (index) {
                dataTables[index] = initializeDatatable($(this), index)
            })
        }

        function initializeDatatable(table_div, index) {
            let datatable = table_div.DataTable({
                dom:
                // "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'>>" +
                    "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
                buttons: exportButtons,
                order: [[1, 'desc']],
                responsive: false,
                scrollX: true,
                scrollY: ($(window).height() - 350),
                scrollCollapse: true,
                paging: true,
                columnDefs: [
                    {
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 0
                    },
                ],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
                fixedColumns: {
                    start: 0,
                    end: 1
                },
            });
            datatable.buttons().container().appendTo(`#right-icon-${index}`);
            return datatable;
        }

        /** Edit */
        $(document).on('click', '.editBtn', function () {
            const id = $(this).data('id');
            if (!id) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Record not found. Do you want to reload the page?',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonText: 'Reload',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            }
            $('#manage-form')[0].reset();
            $.ajax({
                url: `{{route('admin.client.contact.edit')}}/` + id,
                type: 'GET',
                success: function (data) {
                    setDataAndShowEdit(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });

        const decodeHtml = (html) => {
            const txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        };

        function setDataAndShowEdit(data) {
            let client_contact = data?.client_contact;
            $('#manage-form').data('id', client_contact.id);

            $('#brands').val(data.assign_brand_keys);
            if (Array.isArray(data.assign_brand_keys) && data.assign_brand_keys.length === $('#brands option').length) {
                $('#select-all-brands').prop('checked', true);
                $('#select-all-label').text('Unselect All');
            } else {
                $('#select-all-brands').prop('checked', false);
                $('#select-all-label').text('Select All');
            }

            $('#name').val(client_contact.name);
            $('#email').val(client_contact.email);
            $('#phone').val(client_contact.phone);
            $('#address').val(client_contact.address);
            $('#city').val(client_contact.city);
            $('#state').val(client_contact.state);
            $('#country').val(client_contact.country);
            $('#zipcode').val(client_contact.zipcode);
            $('#status').val(client_contact.status);

            $('#manage-form').attr('action', `{{route('admin.client.contact.update')}}/` + client_contact.id);
            $('#formContainer').addClass('open')
        }

        /** Manage Record */
        $('#manage-form').on('submit', function (e) {
            e.preventDefault();
            let dataId = $('#manage-form').data('id');
            let formData = new FormData(this);
            let table = dataTables[0];
            if (!dataId) {
                AjaxRequestPromise(`{{ route("admin.client.contact.store") }}`, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {id, name, email, phone, address, city, state, status} = response.data;
                            const index = table.rows().count() + 1;
                            const columns = `
                                    <td class="align-middle text-center text-nowrap"></td>
                                    <td class="align-middle text-center text-nowrap">${index}</td>

                                    <td class="align-middle text-center text-nowrap">${name}</td>
                                    <td class="align-middle text-center text-nowrap">${email}</td>
                                    <td class="align-middle text-center text-nowrap">${phone}</td>
                                    <td class="align-middle text-center text-nowrap">${address}</td>
                                    <td class="align-middle text-center text-nowrap">${city}</td>
                                    <td class="align-middle text-center text-nowrap">${state}</td>

                                    <td class="align-middle text-center text-nowrap">
                                        <input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? 'checked' : ''} data-bs-toggle="toggle">
                                    </td>
                                    <td class="align-middle text-center table-actions">
                                        <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${id}" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                            `;
                            table.row.add($('<tr>', {id: `tr-${id}`}).append(columns)).draw(false);
                            $('#manage-form')[0].reset();

                            $('#formContainer').removeClass('open')
                        }
                    })
                    .catch(error => console.log('An error occurred while updating the record.'));
            } else {
                const url = $(this).attr('action');
                AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {id, name, email, phone, address, city, state, status} = response.data;
                            const index = table.row($('#tr-' + id)).index();
                            const rowData = table.row(index).data();
                            // Column 2: Name
                            if (decodeHtml(rowData[2]) !== name) {
                                table.cell(index, 2).data(name).draw();
                            }
                            /** Column 3: email */
                            if (decodeHtml(rowData[3]) !== email) {
                                table.cell(index, 3).data(email).draw();
                            }
                            // Column 4: phone
                            if (decodeHtml(rowData[4]) !== phone) {
                                table.cell(index, 4).data(phone).draw();
                            }
                            // Column 5: address
                            if (decodeHtml(rowData[5]) !== address) {
                                table.cell(index, 5).data(address).draw();
                            }
                            // Column 6: city
                            if (decodeHtml(rowData[6]) !== city) {
                                table.cell(index, 6).data(city).draw();
                            }
                            // Column 7: state
                            if (decodeHtml(rowData[7]) !== state) {
                                table.cell(index, 7).data(state).draw();
                            }

                            // Column 8: Status
                            const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`;
                            if (decodeHtml(rowData[8]) !== statusHtml) {
                                table.cell(index, 8).data(statusHtml).draw();
                            }

                            $('#manage-form')[0].reset();
                            $('#formContainer').removeClass('open')
                        }
                    })
                    .catch(error => console.log(error));
            }
        });
        /** Change Status*/
        $('tbody').on('change', '.change-status', function () {
            const statusCheckbox = $(this);
            const status = +statusCheckbox.is(':checked');
            const rowId = statusCheckbox.data('id');
            let table = dataTables[0];
            AjaxRequestPromise(`{{ route('admin.client.contact.change.status') }}/${rowId}?status=${status}`, null, 'GET', {useToastr: true})
                .then(response => {
                    const rowIndex = table.row($('#tr-' + rowId)).index();
                    const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${rowId}" ${status ? "checked" : ""} data-bs-toggle="toggle">`;
                    table.cell(rowIndex, table.column($('th:contains("STATUS")')).index()).data(statusHtml).draw();
                })
                .catch(() => {
                    statusCheckbox.prop('checked', !status);
                });
        });
        {{--/** Change Status*/--}}
        {{--$('tbody').on('change', '.change-status', function () {--}}
        {{--    const statusCheckbox = $(this);--}}
        {{--    const status = +statusCheckbox.is(':checked');--}}
        {{--    const rowId = statusCheckbox.data('id');--}}
        {{--    const table = dataTables[0];--}}
        {{--    if (!status) {--}}
        {{--        Swal.fire({--}}
        {{--            title: 'Confirm Status Change',--}}
        {{--            text: 'Turning this contact OFF will also deactivate all related companies and their accounts. Are you sure?',--}}
        {{--            icon: 'warning',--}}
        {{--            showCancelButton: true,--}}
        {{--            confirmButtonText: 'Yes, deactivate',--}}
        {{--            cancelButtonText: 'No, keep active',--}}
        {{--        }).then((result) => {--}}
        {{--            if (result.isConfirmed) {--}}
        {{--                processStatusChange();--}}
        {{--            } else {--}}
        {{--                statusCheckbox.prop('checked', !status);--}}
        {{--                toastr.info('Phew! The status remained unchanged.');--}}
        {{--            }--}}
        {{--        });--}}
        {{--    } else {--}}
        {{--        processStatusChange();--}}
        {{--    }--}}
        {{--    function processStatusChange() {--}}
        {{--        AjaxRequestPromise(`{{ route('admin.client.contact.change.status') }}/${rowId}?status=${status}`, null, 'GET', {useToastr: true})--}}
        {{--            .then(() => {--}}
        {{--                const rowIndex = table.row($('#tr-' + rowId)).index();--}}
        {{--                const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${rowId}" ${status ? "checked" : ""} data-bs-toggle="toggle">`;--}}
        {{--                table.cell(rowIndex, table.column($('th:contains("STATUS")')).index()).data(statusHtml).draw();--}}
        {{--            })--}}
        {{--            .catch(() => {--}}
        {{--                statusCheckbox.prop('checked', !status);--}}
        {{--            });--}}
        {{--    }--}}

        {{--});--}}
        /** Delete Record */
        $(document).on('click', '.deleteBtn', function () {
            const id = $(this).data('id');
            let table = dataTables[0];
            AjaxDeleteRequestPromise(`{{ route("admin.client.contact.delete", "") }}/${id}`, null, 'DELETE', {
                useDeleteSwal: true,
                useToastr: true,
            })
                .then(response => {
                    table.row(`#tr-${id}`).remove().draw();
                })
                .catch(error => {
                    if (error.isConfirmed === false) {
                        Swal.fire({
                            title: 'Action Canceled',
                            text: error?.message || 'The deletion has been canceled.',
                            icon: 'info',
                            confirmButtonText: 'OK'
                        });
                        console.error('Record deletion was canceled:', error?.message);
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while deleting the record.',
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                        console.error('An error occurred while deleting the record:', error);
                    }
                });
        });
    });
</script>
