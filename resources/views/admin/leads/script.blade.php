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

        /** Initializing Datatable */
        if ($('.initTable').length) {
            $('.initTable').each(function (index) {
                initializeDatatable($(this), index)
            })
        }
        var table;

        function initializeDatatable(table_div, index) {
            table = table_div.DataTable({
                dom:
                // "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'>>" +
                    "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
                buttons: exportButtons,
                order: [[1, 'desc']],
                responsive: false,
                scrollX: true,
                scrollY:  ($(window).height() - 350),
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
            table.buttons().container().appendTo(`#right-icon-${index}`);
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
                url: `{{route('admin.lead.edit')}}/` + id,
                type: 'GET',
                success: function (response) {
                    setDataAndShowEdit(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });

        function setDataAndShowEdit(data) {
            let lead = data?.lead;
            $('#manage-form').data('id', lead.id);

            $('#brand_key').val(lead.brand_key).trigger('change');
            $('#team_key').val(lead.team_key).trigger('change');
            $('#name').val(lead.name)
            $('#email').val(lead.email);
            $('#phone').val(lead.phone);
            $('#lead_status_id').val(lead.lead_status_id).trigger('change');
            $('#note').val(lead.note);
            $('#status').val(lead.status);

            $('#manage-form').attr('action', `{{route('admin.lead.update')}}/` + lead.id);
            $('#formContainer').addClass('open')
        }

        const decodeHtml = (html) => {
            const txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        };

        /** Create Manage Record */
        $('#manage-form').on('submit', function (e) {
            e.preventDefault();
            var dataId = $('#manage-form').data('id');
            var formData = new FormData(this);
            if (!dataId) {
                AjaxRequestPromise(`{{ route("admin.lead.store") }}`, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {
                                id,
                                brand,
                                team,
                                customer_contact,
                                name,
                                email,
                                phone,
                                address,
                                city,
                                state,
                                zipcode,
                                country,
                                lead_status,
                                note,
                                date,
                                status
                            } = Object.fromEntries(
                                Object.entries(response.data).map(([key, value]) => [key, value === null ? '' : value])
                            );

                            const index = table.rows().count() + 1;
                            const columns = `
                                <td class="align-middle text-center text-nowrap"></td>
                                <td class="align-middle text-center text-nowrap">${index}</td>
                                <td class="align-middle text-center text-nowrap">
                                    ${brand ? `<a href="{{route('admin.brand.index')}}">${brand.name}</a><br> ${brand.brand_key}` : '---'}
                                </td>
                                <td class="align-middle text-center text-nowrap">${team ? `<a href="{{route('admin.team.index')}}">${team.name}</a><br> ${team.team_key}` : '---'}</td>
                                <td class="align-middle text-center text-nowrap">${customer_contact ? `<a href="/admin/contact/edit/${customer_contact.id}">${customer_contact.name}</a>` : '---'}</td>
                                <td class="align-middle text-center text-nowrap">${name}</td>
                                <td class="align-middle text-center text-nowrap">${email}</td>
                                <td class="align-middle text-center text-nowrap">${phone}</td>
                                <td class="align-middle text-center text-nowrap">${address}</td>
                                <td class="align-middle text-center text-nowrap">${city}</td>
                                <td class="align-middle text-center text-nowrap">${state}</td>
                                <td class="align-middle text-center text-nowrap">${zipcode}</td>
                                <td class="align-middle text-center text-nowrap">${country}</td>
                                <td class="align-middle text-center text-nowrap">${lead_status ? lead_status?.name : ""}</td>
                                <td class="align-middle text-center text-nowrap">${note}</td>
                                <td class="align-middle text-center text-nowrap">${date}</td>
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
                    .catch(error => console.error('An error occurred while updating the record.',error));
            } else {
                const url = $(this).attr('action');
                AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {
                                id,
                                brand,
                                team,
                                customer_contact,
                                name,
                                email,
                                phone,
                                address,
                                city,
                                state,
                                zipcode,
                                country,
                                lead_status,
                                note,
                                date,
                                status
                            } = Object.fromEntries(
                                Object.entries(response.data).map(([key, value]) => [key, value === null ? '' : value])
                            );

                            const index = table.row($('#tr-' + id)).index();
                            const rowData = table.row(index).data();

                            // Column 3: Brand
                            if (decodeHtml(rowData[2]) !== `${brand ? `<a href="{{route('admin.brand.index')}}">${brand.name}</a><br> ${brand.brand_key}` : '---'}`) {
                                table.cell(index, 2).data(`${brand ? `<a href="{{route('admin.brand.index')}}">${brand.name}</a><br> ${brand.brand_key}` : '---'}`).draw();
                            }

                            // Column 4: Team
                            if (decodeHtml(rowData[3]) !== `${team ? `<a href="{{route('admin.team.index')}}">${team.name}</a><br> ${team.team_key}` : '---'}`) {
                                table.cell(index, 3).data(`${team ? `<a href="{{route('admin.team.index')}}">${team.name}</a><br> ${team.team_key}` : '---'}`).draw();
                            }

                            // Column 5: Customer Contact
                            if (decodeHtml(rowData[4]) !== `${customer_contact ? `<a href="/admin/contact/edit/${customer_contact.id}">${customer_contact.name}</a>` : '---'}`) {
                                table.cell(index, 4).data(`${customer_contact ? `<a href="/admin/contact/edit/${customer_contact.id}">${customer_contact.name}</a>` : '---'}`).draw();
                            }

                            // Column 6: Name
                            if (decodeHtml(rowData[5]) !== name) {
                                table.cell(index, 5).data(name).draw();
                            }

                            // Column 7: Email
                            if (decodeHtml(rowData[6]) !== email) {
                                table.cell(index, 6).data(email).draw();
                            }

                            // Column 8: Phone
                            if (decodeHtml(rowData[7]) !== phone) {
                                table.cell(index, 7).data(phone).draw();
                            }

                            // Column 9: Address
                            if (decodeHtml(rowData[8]) !== address) {
                                table.cell(index, 8).data(address).draw();
                            }

                            // Column 10: City
                            if (decodeHtml(rowData[9]) !== city) {
                                table.cell(index, 9).data(city).draw();
                            }

                            // Column 11: State
                            if (decodeHtml(rowData[10]) !== state) {
                                table.cell(index, 10).data(state).draw();
                            }

                            // Column 12: Zipcode
                            if (decodeHtml(rowData[11]) !== zipcode) {
                                table.cell(index, 11).data(zipcode).draw();
                            }

                            // Column 13: Country
                            if (decodeHtml(rowData[12]) !== country) {
                                table.cell(index, 12).data(country).draw();
                            }

                            // Column 14: Lead Status
                            if (decodeHtml(rowData[13]) !== lead_status.name) {
                                table.cell(index, 13).data(lead_status.name).draw();
                            }

                            // Column 15: Note
                            if (decodeHtml(rowData[14]) !== note) {
                                table.cell(index, 14).data(note).draw();
                            }

                            // Column 16: Created Date
                            if (decodeHtml(rowData[15]) !== date) {
                                table.cell(index, 15).data(date).draw();
                            }

                            // Column 17: Status
                            const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`;
                            if (decodeHtml(rowData[16]) !== statusHtml) {
                                table.cell(index, 16).data(statusHtml).draw();
                            }
                            $('#manage-form')[0].reset();
                            $('#image-display').attr('src', null);
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
            AjaxRequestPromise(`{{ route('admin.lead.change.status') }}/${rowId}?status=${status}`, null, 'GET', {useToastr: true})
                .then(response => {
                    const rowIndex = table.row($('#tr-' + rowId)).index();
                    const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${rowId}" ${status ? "checked" : ""} data-bs-toggle="toggle">`;
                    table.cell(rowIndex, 16).data(statusHtml).draw();
                })
                .catch(() => {
                    statusCheckbox.prop('checked', !status);
                });
        });
        /** Delete Record */
        $(document).on('click', '.deleteBtn', function () {
            const id = $(this).data('id');
            console.log('Deleting record with ID:', id);
            AjaxDeleteRequestPromise(`{{ route("admin.lead.delete", "") }}/${id}`, null, 'DELETE', {
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

        /** Convert Lead to Customer */
        $(document).on('click', '.convertBtn', function (e) {
            e.preventDefault();

            const $btn = $(this);
            const leadId = $btn.data('id');

            if (!leadId) {
                toastr.error('Invalid lead ID.');
                return;
            }

            const url = `{{ route('admin.lead.convert', '') }}/${leadId}`;

            convertLeadToCustomer(leadId, url, $btn);
        });

        function convertLeadToCustomer(leadId, url, $btn) {
            $btn.prop('disabled', true).addClass('disabled');

            AjaxRequestPromise(url, null, 'POST', { useToastr: false })
                .then(res => {
                    if (res?.success) {
                        toastr.success(res?.message || 'Lead converted successfully.');

                        $(`#tr-${leadId} .convertBtn`).remove();

                        $(`#tr-${leadId} td[data-field="leadStatus"]`).text('Converted');

                        const customer_contact = res.data;
                        const contactTd = `
            <td class="align-middle text-center text-nowrap">
                ${customer_contact ? `<a href="/admin/contact/edit/${customer_contact.id}">${customer_contact.name}</a>` : '---'}
            </td>
        `;
                        $(`#tr-${leadId} td[data-field="customer_contact"]`).replaceWith(contactTd);

                    } else {
                        toastr.error(res?.message || 'Conversion failed.');
                        $btn.prop('disabled', false).removeClass('disabled');
                    }
                })
                .catch(err => {
                    const msg = err?.message || 'Something went wrong!';
                    toastr.error(msg);
                    $btn.prop('disabled', false).removeClass('disabled');
                });
        }

    });
</script>
