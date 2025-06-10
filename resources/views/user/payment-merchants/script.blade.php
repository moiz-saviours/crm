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
                scrollY:  ($(window).height() - 200),
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
                    end: 3
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
                url: `{{route('user.client.account.edit')}}/` + id,
                type: 'GET',
                success: function (data) {
                    setDataAndShowEdit(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });
        function setDataAndShowEdit(data) {
            const client_account = data?.client_account;
            if (!client_account) {
                toastr.error('Client account data is missing.')
                return false;
            }

            $('#manage-form').data('id', client_account.id);

            $('#client_contact')
                .val(client_account.c_contact_key)
                .data('company_key', client_account.c_company_key) // Store the company key temporarily
                .trigger('change');
            $('#name').val(client_account.name);
            $('#descriptor').val(client_account.descriptor);
            $('#vendor_name').val(client_account.vendor_name);
            $('#email').val(client_account.email);
            $('#payment_method').val(client_account.payment_method);
            $('#limit').val(client_account.limit);
            $('#capacity').val(client_account.capacity);
            $('#environment').val(client_account.environment);
            $('#status').val(client_account.status);

            $('#manage-form').attr('action', `{{route('user.client.account.update')}}/` + client_account.id);
            $('#formContainer').addClass('open')
        }
        const decodeHtml = (html) => {
            const txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        };

        /** Manage Record */
        $('#manage-form').on('submit', function (e) {
            e.preventDefault();
            var dataId = $('#manage-form').data('id');
            var formData = new FormData(this);
            if (!dataId) {
                AjaxRequestPromise(`{{ route("user.client.account.store") }}`, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {
                                id,
                                client_contact,
                                client_company,
                                name,
                                descriptor,
                                payment_method,
                                email,
                                limit,
                                capacity,
                                environment,
                                status
                            } = response.data;
                            const index = table.rows().count() + 1;
                            const columns = `
                                <td class="align-middle text-center text-nowrap"></td>
                                <td class="align-middle text-center text-nowrap">${index}</td>
                                <td class="align-middle text-center text-nowrap">${client_contact ? client_contact.name : '---'}</td>
                                <td class="align-middle text-center text-nowrap">${client_company ? client_company.name : '---'}</td>
                                <td class="align-middle text-center text-nowrap">${name}</td>
                                <td class="align-middle text-center text-nowrap">${descriptor}</td>
                                <td class="align-middle text-center text-nowrap">${payment_method.toUpperCase()}</td>
                                <td class="align-middle text-center text-nowrap">${email}</td>
                                <td class="align-middle text-center text-nowrap">${limit}</td>
                                <td class="align-middle text-center text-nowrap">${capacity}</td>
                                <td class="align-middle text-center text-nowrap">0</td>
                                <td class="align-middle text-center text-nowrap">${environment}</td>
                                 <td class="align-middle text-center text-nowrap">
                                        <input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == "active" ? 'checked' : ''} data-bs-toggle="toggle">
                                    </td>
                                <td class="align-middle text-center table-actions">
                                    <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" title="Edit">
                                        <i class="fas fa-edit"></i>
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
                                client_contact,
                                client_company,
                                name,
                                descriptor,
                                payment_method,
                                email,
                                limit,
                                capacity,
                                current_month_usage,
                                environment,
                                status
                            } = response.data;
                            const index = table.row($('#tr-' + id)).index();
                            const rowData = table.row(index).data();

                            // Column 2: Client Contact
                            if (decodeHtml(rowData[2]) !== `${client_contact ? client_contact.name : '---'}`) {
                                table.cell(index, 2).data(`${client_contact ? client_contact.name : '---'}`).draw();
                            }
                            // Column 3: Client Company
                            if (decodeHtml(rowData[3]) !== `${client_company ? client_company.name : '---'}`) {
                                table.cell(index, 3).data(`${client_company ? client_company.name : '---'}`).draw();
                            }
                            // Column 4: Name
                            if (decodeHtml(rowData[4]) !== name) {
                                table.cell(index, 4).data(name).draw();
                            }
                            // Column 5: descriptor
                            if (decodeHtml(rowData[5]) !== descriptor) {
                                table.cell(index, 5).data(descriptor).draw();
                            }
                            // Column 6: Vendor name
                            if (decodeHtml(rowData[6]) !== payment_method.toUpperCase()) {
                                table.cell(index, 6).data(payment_method).draw();
                            }
                            // Column 7: email
                            if (decodeHtml(rowData[7]) !== email) {
                                table.cell(index, 7).data(email).draw();
                            }
                            // Column 8: login_id
                            if (decodeHtml(rowData[8]) !== limit) {
                                table.cell(index, 8).data(limit).draw();
                            }
                            // Column 9: transaction_key
                            if (decodeHtml(rowData[9]) !== capacity) {
                                table.cell(index, 9).data(capacity).draw();
                            }
                            // Column 10: limit
                            if (decodeHtml(rowData[10]) !== current_month_usage) {
                                table.cell(index, 10).data(current_month_usage).draw();
                            }
                            // Column 11: capacity
                            if (decodeHtml(rowData[11]) !== environment) {
                                table.cell(index, 11).data(environment).draw();
                            }
                            // Column 12: Status
                            const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == "active" ? "checked" : ""} data-bs-toggle="toggle">`;
                            if (decodeHtml(rowData[12]) !== statusHtml) {
                                table.cell(index, 14).data(statusHtml).draw();
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
            const status = statusCheckbox.is(':checked') ? 'active' : 'inactive';
            const rowId = statusCheckbox.data('id');
            AjaxRequestPromise(`{{ route('user.client.account.change.status') }}/${rowId}?status=${status}`, null, 'GET', {useToastr: true})
                .then(response => {
                    const rowIndex = table.row($('#tr-' + rowId)).index();
                    const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${rowId}" ${status == 'active' ? "checked" : ""} data-bs-toggle="toggle">`;
                    table.cell(rowIndex, table.column($('th:contains("STATUS")')).index()).data(statusHtml).draw();
                })
                .catch((error) => {
                    console.log(error);
                    statusCheckbox.prop('checked', !$(this).prop('checked'));
                });
        });

    });
</script>
