<script>
    $(document).ready(function () {

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
        const dataTables = [];

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
            })
            // datatable.buttons().container().appendTo(`#right-icon-${index}`);
            return datatable;
        }

        {{--    /** Create Record */--}}
        {{--    $('#create-form').on('submit', function (e) {--}}
        {{--        e.preventDefault();--}}
        {{--        AjaxRequestPromise('{{ route("company.store") }}', new FormData(this), 'POST', {useToastr: true})--}}
        {{--            .then(response => {--}}
        {{--                if (response?.data) {--}}
        {{--                    const {id, logo, name, special_key, url, status} = response.data;--}}
        {{--                    $('#create-modal').modal('hide');--}}
        {{--                    const logoUrl = isValidUrl(logo) ? logo : `{{ asset('assets/images/company-logos/') }}/${logo}`;--}}
        {{--                    const columns = [--}}
        {{--                        id,--}}
        {{--                        `<img src="${logoUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">`,--}}
        {{--                        special_key,--}}
        {{--                        name,--}}
        {{--                        url,--}}
        {{--                        `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`,--}}
        {{--                        `<a href="javascript:void(0)" data-id="${id}" class="text-secondary editBtn" title="Edit company"><i class="fas fa-edit"></i></a>&nbsp;<a href="javascript:void(0)" class="text-secondary deleteBtn" data-id="${id}" title="Delete company"><i class="fas fa-trash"></i></a>`--}}
        {{--                    ];--}}
        {{--                    table.row.add($('<tr>', {id: `tr-${id}`}).append(columns.map(col => $('<td>').html(col)))).draw();--}}
        {{--                    $('#create-form')[0].reset();--}}
        {{--                }--}}
        {{--            })--}}
        {{--            .catch(error => console.log(error));--}}
        {{--    });--}}

        {{--    function setDataAndShowEditModel(data) {--}}
        {{--        $('#edit_name').val(data.name);--}}
        {{--        $('#edit_url').val(data.url);--}}
        {{--        $('#edit_email').val(data.email);--}}
        {{--        $('#edit_description').val(data.description);--}}
        {{--        $('#edit_status').val(data.status);--}}
        {{--        if (data.logo) {--}}
        {{--            var isValidUrl = data.logo.match(/^(https?:\/\/|\/|\.\/)/);--}}
        {{--            if (isValidUrl) {--}}
        {{--                $('#company-logo').attr('src', data.logo);--}}
        {{--            } else {--}}
        {{--                $('#company-logo').attr('src', `{{asset('assets/images/company-logos/')}}/` + data.logo);--}}
        {{--            }--}}
        {{--            $('#company-logo').attr('alt', data.name);--}}
        {{--            $('#company-logo').show();--}}
        {{--        }--}}

        {{--        $('#update-form').attr('action', `{{route('company.update')}}/` + data.id);--}}
        {{--        $('#edit-modal').modal('show');--}}
        {{--    }--}}

        {{--    /** Edit */--}}
        {{--    $(document).on('click', '.editBtn', function () {--}}
        {{--        const id = $(this).data('id');--}}
        {{--        if (!id) {--}}
        {{--            Swal.fire({--}}
        {{--                title: 'Error!',--}}
        {{--                text: 'Record not found. Do you want to reload the page?',--}}
        {{--                icon: 'error',--}}
        {{--                showCancelButton: true,--}}
        {{--                confirmButtonText: 'Reload',--}}
        {{--                cancelButtonText: 'Cancel'--}}
        {{--            }).then((result) => {--}}
        {{--                if (result.isConfirmed) {--}}
        {{--                    location.reload();--}}
        {{--                }--}}
        {{--            });--}}
        {{--        }--}}
        {{--        $('#update-form')[0].reset();--}}
        {{--        $.ajax({--}}
        {{--            url: `{{route('company.edit')}}/` + id,--}}
        {{--            type: 'GET',--}}
        {{--            success: function (data) {--}}
        {{--                setDataAndShowEditModel(data);--}}
        {{--            },--}}
        {{--            error: function () {--}}
        {{--                alert('Error fetching company data.');--}}
        {{--            }--}}
        {{--        });--}}
        {{--    });--}}

        {{--    /** Update Record */--}}
        {{--    $('#update-form').on('submit', function (e) {--}}
        {{--        e.preventDefault();--}}
        {{--        const url = $(this).attr('action');--}}
        {{--        AjaxRequestPromise(url, new FormData(this), 'POST', {useToastr: true})--}}
        {{--            .then(response => {--}}
        {{--                if (response?.data) {--}}
        {{--                    const {id, logo, name, special_key, url, status} = response.data;--}}
        {{--                    $('#edit-modal').modal('hide');--}}
        {{--                    const logoUrl = isValidUrl(logo) ? logo : `{{ asset('assets/images/company-logos/') }}/${logo}`;--}}
        {{--                    const columns = [--}}
        {{--                        id,--}}
        {{--                        `<img src="${logoUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">`,--}}
        {{--                        special_key,--}}
        {{--                        name,--}}
        {{--                        url,--}}
        {{--                        `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`,--}}
        {{--                        `<a href="javascript:void(0)" data-id="${id}" class="text-secondary editBtn" title="Edit company"><i class="fas fa-edit"></i></a>&nbsp;<a href="javascript:void(0)" class="text-secondary deleteBtn" data-id="${id}" title="Delete company"><i class="fas fa-trash"></i></a>`--}}
        {{--                    ];--}}
        {{--                    table.row($('#tr-' + id)).data(columns).draw();--}}
        {{--                }--}}
        {{--            })--}}
        {{--            .catch(error => console.error('An error occurred while updating the record.',error));--}}
        {{--    });--}}

        {{--    /** Change Status*/--}}
        {{--    $('.change-status').on('change', function () {--}}
        {{--        AjaxRequestPromise(`{{ route('company.change.status') }}/${$(this).data('id')}?status=${+$(this).is(':checked')}`, null, 'GET', {useToastr: true})--}}
        {{--            .then(response => {--}}
        {{--            })--}}
        {{--            .catch(() => alert('An error occurred'));--}}
        {{--    });--}}
        {{--    /** Delete Record */--}}
        {{--    $(document).on('click', '.deleteBtn', function () {--}}
        {{--        const id = $(this).data('id');--}}
        {{--        AjaxDeleteRequestPromise(`{{ route("company.delete", "") }}/${id}`, null, 'DELETE', {--}}
        {{--            useDeleteSwal: true,--}}
        {{--            useToastr: true,--}}
        {{--        })--}}
        {{--            .then(response => {--}}
        {{--                table.row(`#tr-${id}`).remove().draw();--}}
        {{--            })--}}
        {{--            .catch(error => {--}}
        {{--                Swal.fire('Error!', 'An error occurred while deleting the record.', 'error');--}}
        {{--                console.error('Error deleting record:', error);--}}
        {{--            });--}}
        {{--    });--}}
        {{--    @if (session()->get('edit_company') !== null)--}}
        {{--    const data = @json(session()->get('edit_company'));--}}
        {{--    setDataAndShowEditModel(data);--}}
        {{--    @endif--}}
        {{--    @php session()->forget('edit_company') @endphp--}}

        /** Edit */
        $(document).on('click', '.editBtn', function (e) {
            e.preventDefault();
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
                url: `{{route('invoice.edit')}}/` + id,
                type: 'GET',
                success: function (response) {
                    setDataAndShowEdit(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });

        function updateTotalAmount() {
            const amount = parseFloat($('#amount').val());
            const taxAmount = parseFloat($('#tax_amount').val()) || 0;
            const totalAmount = amount + taxAmount;

            $('#total_amount').val(totalAmount.toFixed(2));
        }
        $('.all-tab').on('click', function () {
            dataTables[0].column('th:contains("AGENT")').search('').draw();
        });

        $('.my-tab').on('click', function () {
            const currentUser = '{{ auth()->user()->name }}';
            dataTables[0].column('th:contains("AGENT")').search(currentUser, true, false).draw();
        });
        function setDataAndShowEdit(data) {
            const invoice = data?.invoice;

            $('#manage-form').data('id', invoice.id);
            $('#brand_key').val(invoice.brand_key).trigger('change.select2');
            $('#team_key').val(invoice.team_key).trigger('change');
            $('#type').val(invoice.type).trigger('change');

            $('#customer_contact_name').val(invoice.customer_contact?.name).prop('readonly', true);
            $('#customer_contact_email').val(invoice.customer_contact?.email).prop('readonly', true);
            $('#customer_contact_phone').val(invoice.customer_contact?.phone).prop('readonly', true);
            $('#cus_contact_key').val(invoice.customer_contact?.special_key).trigger('change');
            $('#agent_id').val(invoice.agent_id).trigger('change');
            $('#due_date').val(invoice.due_date);
            $('#currency').val(invoice.currency);
            $('#amount').val(invoice.amount);
            $('#total_amount').val(invoice.total_amount);
            $('#description').val(invoice.description);
            $('#status').val(invoice.status);

            $('#taxable').prop('checked', invoice.taxable);
            if (invoice.taxable) {
                $('#tax-fields').slideDown();
                $('#tax_type').val(invoice.tax_type);
                $('#tax_value').val(invoice.tax_value);
                $('#tax_amount').val((parseFloat(invoice.tax_amount) || 0).toFixed(2));
            } else {
                $('#tax-fields').slideUp();
                $('#tax_type').val('');
                $('#tax_value').val('');
                $('#tax_amount').val(0);
            }

            updateTotalAmount();
            getMerchants(invoice.brand_key, invoice, invoice.currency);
            $('#manage-form').attr('action', `{{route('invoice.update')}}/` + invoice.id);
            $('#formContainer').addClass('open');
        }

        const decodeHtml = (html) => {
            const txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        };

        /** Manage Record */
        $('#manage-form').on('submit', function (e) {
            e.preventDefault();
            const dataId = $('#manage-form').data('id');
            const formData = new FormData(this);
            let table = dataTables[0];
            @php
                $baseUrl = '';
                if (app()->environment('production')) {
                    $baseUrl = url('');
                } elseif (app()->environment('development')) {
                    $baseUrl = url('');
                } else {
                    $baseUrl = url('');
                }
            @endphp
            let basePath = `{{$baseUrl}}`;
            if (!dataId) {
                AjaxRequestPromise(`{{ route("invoice.store") }}`, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {
                                id,
                                invoice_number,
                                invoice_key,
                                brand,
                                team,
                                customer_contact,
                                agent,
                                amount,
                                tax_type,
                                tax_value,
                                tax_amount,
                                total_amount,
                                currency,
                                status,
                                due_date,
                                date
                            } = response.data;
                            const index = table.rows().count() + 1;
                            const columns = `
                        <td class="align-middle text-center text-nowrap"></td>
                        <td class="align-middle text-center text-nowrap">${index}</td>
                        <td class="align-middle text-center text-nowrap text-sm invoice-cell">
                                                    <span class="invoice-number">${invoice_number}</span><br>
                            <span class="invoice-key view-transactions text-primary"
                                                          title="Show transaction logs"
                                                          style="cursor: pointer;" data-invoice-key="${invoice_key}"><b style="font-weight: 600;">${invoice_key}</b></span>
                        </td>
                        <td class="align-middle text-center text-nowrap">${brand?.name}</td>
                        <td class="align-middle text-center text-nowrap">${team?.name}</td>
                        <td class="align-middle text-center text-nowrap">${customer_contact?.name}</td>
                        <td class="align-middle text-center text-nowrap">${agent?.name}</td>
                        <td class="align-middle space-between text-nowrap" style="text-align: left;">
                            <div style="display: flex; justify-content: space-between; gap: 10px;">
                                <span style="width: 120px;">Amount:</span>
                                <span>${currency} ${parseFloat(amount).toFixed(2)}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; gap: 10px;">
                                <span style="width: 120px;">Tax:</span>
                                <span>${tax_type === 'percentage' ? '%' : (tax_type === 'fixed' ? currency : '')} ${tax_value ?? 0}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; gap: 10px;">
                                <span style="width: 120px;">Tax Amount:</span>
                                <span>${currency} ${parseFloat(tax_amount).toFixed(2)}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; gap: 10px;">
                                <span style="width: 120px;">Total Amount:</span>
                                <span>${currency} ${parseFloat(total_amount).toFixed(2)}</span>
                            </div>
                        </td>
                        <td class="align-middle text-center text-nowrap">
                            ${status == 0 ? '<span class="badge bg-warning text-dark">Due</span>' : status == 1 ? '<span class="badge bg-success">Paid</span>' : status == 2 ? '<span class="badge bg-danger">Refund</span>' : status == 3 ? '<span class="badge bg-danger">Charge Back</span>' : ''}
                        </td>
                        <td class="align-middle text-center text-nowrap">${due_date}</td>
                        <td class="align-middle text-center text-nowrap">${date}</td>
                        <td class="align-middle text-center table-actions">
                        <button type="button" class="btn btn-sm btn-primary copyBtn"
                                                            data-id="${id}"
                                                            data-invoice-key="${invoice_key}"
                                                            data-invoice-url="${basePath}/invoice?InvoiceID=${invoice_key}"
                                                            title="Copy Invoice Url"><i
                                                            class="fas fa-copy"></i></button>
                            ${status == 0 ? '<br><button type="button" class="btn btn-sm btn-primary editBtn mt-2" data-id="' + id + '" title="Edit"><i class = "fas fa-edit" > </i></button>' : ''}
                        </td>`;

                            table.row.add($('<tr>', {id: `tr-${id}`}).append(columns)).draw(false);

                            $('#manage-form')[0].reset();
                            $('#formContainer').removeClass('open');
                        }
                    })
                    .catch(error => console.log('An error occurred while updating the record.', error));
            } else {
                const url = $(this).attr('action');
                AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {
                                id,
                                invoice_number,
                                invoice_key,
                                brand,
                                team,
                                customer_contact,
                                creator,
                                creator_type,
                                agent,
                                amount, tax_type, tax_value,
                                tax_amount, total_amount, currency,
                                status,
                                due_date,
                                date,
                                payment_attachments
                            } = response.data;
                            const index = table.row($('#tr-' + id)).index();
                            const rowData = table.row(index).data();
                            let totalAttachments = 0;
                            if (payment_attachments && payment_attachments.length > 0) {
                                totalAttachments = payment_attachments.reduce((count, payment) => {
                                    try {
                                        const attachments = JSON.parse(payment.attachments);
                                        return count + (attachments ? attachments.length : 0);
                                    } catch (e) {
                                        return count;
                                    }
                                }, 0);
                            }
                            // Update columns in the table dynamically
                            // Column 3: Invoice Number & Invoice Key
                            if (decodeHtml(rowData[2]) !== `${invoice_number}<br>${invoice_key}`) {
                                table.cell(index, 2).data(`
                                    <span class="invoice-number">${invoice_number}</span><br>
                            <span class="invoice-key view-transactions text-primary"
                                                          title="Show transaction logs"
                                                          style="cursor: pointer;" data-invoice-key="${invoice_key}"><b style="font-weight: 600;">${invoice_key}</b></span>
                                `).draw();
                            }

                            // Column 4: Brand
                            if (decodeHtml(rowData[3]) !== brand?.name) {
                                table.cell(index, 3).data(brand?.name).draw();
                            }
                            // if (decodeHtml(rowData[3]) !== `${brand ? `<a href="">${brand.name}</a><br> ${brand.brand_key}` : '---'}`) {
                            //     table.cell(index, 3).data(`${brand ? `<a href="">${brand.name}</a><br> ${brand.brand_key}` : '---'}`).draw();
                            // }

                            // Column 5: Team
                            if (decodeHtml(rowData[4]) !== team?.name) {
                                table.cell(index, 4).data(team?.name).draw();
                            }
                            // if (decodeHtml(rowData[4]) !== `${team ? `<a href="">${team.name}</a><br> ${team.team_key}` : '---'}`) {
                            //     table.cell(index, 4).data(`${team ? `<a href="">${team.name}</a><br> ${team.team_key}` : '---'}`).draw();
                            // }

                            // Column 6: Customer Contact
                            if (decodeHtml(rowData[5]) !== customer_contact?.name) {
                                table.cell(index, 5).data(customer_contact?.name).draw();
                            }
                            // if (decodeHtml(rowData[5]) !== `${customer_contact ? `<a href="/user/contact/edit/${customer_contact.id}">${customer_contact.name}</a>` : '---'}`) {
                            //     table.cell(index, 5).data(`${customer_contact ? `<a href="/user/contact/edit/${customer_contact.id}">${customer_contact.name}</a>` : '---'}`).draw();
                            // }

                            // Column 7: Agent
                            if (decodeHtml(rowData[6]) !== agent?.name) {
                                table.cell(index, 6).data(agent?.name).draw();
                            }
                            // if (decodeHtml(rowData[6]) !== `${agent ? `<a href="">${agent.name}</a>` : '---'}`) {
                            //     table.cell(index, 6).data(`${agent ? `<a href="">${agent.name}</a>` : '---'}`).draw();
                            // }

                            // Column 8: Amount
                            const newContent = `
                                <div style="display: flex; justify-content: space-between; gap: 10px;">
                                    <span style="width: 120px;">Amount:</span>
                                    <span>${currency} ${parseFloat(amount).toFixed(2)}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; gap: 10px;">
                                    <span style="width: 120px;">Tax:</span>
                                    <span>${tax_type === 'percentage' ? '%' : (tax_type === 'fixed' ? currency : '')} ${tax_value ?? 0}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; gap: 10px;">
                                    <span style="width: 120px;">Tax Amount:</span>
                                    <span>${currency} ${parseFloat(tax_amount).toFixed(2)}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; gap: 10px;">
                                    <span style="width: 120px;">Total Amount:</span>
                                    <span>${currency} ${parseFloat(total_amount).toFixed(2)}</span>
                                </div>`;
                            // Column 8: Amount
                            if (decodeHtml(rowData[7]) !== newContent) {
                                table.cell(index, 7).data(newContent).draw();
                            }
                            // Column 9: Status

                            const statusHtml = status == 0 ? '<span class="badge bg-warning text-dark">Due</span>' : status == 1 ? '<span class="badge bg-success">Paid</span>' : status == 2 ? '<span class="badge bg-danger">Refund</span>' : status == 3 ? '<span class="badge bg-danger">Charge Back</span>' : '';
                            if (decodeHtml(rowData[8]) !== statusHtml) {
                                table.cell(index, 8).data(statusHtml).draw();
                            }

                            // Column 10: Due Date
                            if (decodeHtml(rowData[9]) !== due_date) {
                                table.cell(index, 9).data(due_date).draw();
                            }

                            // Column 11: Date
                            if (decodeHtml(rowData[10]) !== date) {
                                table.cell(index, 10).data(date).draw();
                            }

                            // Column 12: Actions

                            let actionsHtml = '';
                            if (brand) {
                                actionsHtml += `<button type="button" class="btn btn-sm btn-primary copyBtn" data-id="${id}" data-invoice-key="${invoice_key}" data-invoice-url="${basePath}/invoice?InvoiceID=${invoice_key}" title="Copy Invoice Url"><i class="fas fa-copy" aria-hidden="true"></i></button> `;
                            }
                            if (payment_attachments && payment_attachments.length > 0) {
                                actionsHtml += `<button type="button" class="btn btn-sm btn-primary view-payment-proofs" data-invoice-key="${invoice_key}" title="View Payment Proofs"><i class="fas fa-paperclip" aria-hidden="true"></i>  ${totalAttachments}  </button> `;
                            }
                            if (status == 0 && (agent?.id == {{auth()->user()->id}} || creator?.id == {{auth()->user()->id}} || team && team.lead_id == {{auth()->user()->id}}) && creator_type != 'App\\Models\\Admin') {
                                actionsHtml += `<br><button type="button" class="btn btn-sm btn-primary editBtn mt-2" data-id="${id}" title="Edit"><i class="fas fa-edit" aria-hidden="true"></i></button>`;
                            }
                            if (normalizeHtml(decodeHtml(rowData[11])) !== normalizeHtml(actionsHtml)) {
                                table.cell(index, 11).data(actionsHtml).draw();
                            }
                            $('#manage-form')[0].reset();
                            $('#formContainer').removeClass('open')
                        }
                    })
                    .catch(error => console.log(error));
            }
        });
        function normalizeHtml(html) {
            return html
                .replace(/\s+/g, ' ')
                .replace(/>\s+</g, '><')
                .trim();
        }

        $(document).on('click', '.view-transactions', function () {
            let invoice_key = $(this).data('invoice-key');

            $.ajax({
                url: `{{ route('payment-transaction-logs') }}`,
                type: 'GET',
                data: {invoice_key: invoice_key},
                beforeSend: function () {
                    $('#transactionLogs').html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');
                },
                success: function (response) {
                    if (response.status === 'success' && response.logs.length > 0) {
                        let rows = '';
                        response.logs.forEach((log, index) => {
                            let formattedDate = new Date(log.created_at).toLocaleString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: '2-digit',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit',
                                hour12: true
                            });
                            rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${log.merchant ?? ""}</td>
                            <td>${log.last_4 ?? ""}</td>
                            <td>${log.transaction_id ?? ""}</td>
                            <td>${log.amount ?? ""}</td>
                            <td>${log.status == 'success' ? log?.response_message ?? "" : log?.error_message ?? ""}</td>
                            <td>${log.status == 'success' ? '<span class="text-success">Paid</span>' : '<span class="text-danger">Not Paid</span>'}</td>
                            <td>${formattedDate}</td>
                        </tr>`;
                        });
                        $('#transactionLogs').html(rows);
                    } else {
                        $('#transactionLogs').html('<tr><td colspan="12" class="text-center">No transactions found</td></tr>');
                    }
                    $('#transactionModal').modal('show');
                },
                error: function () {
                    $('#transactionLogs').html('<tr><td colspan="12" class="text-center text-danger">Error fetching data</td></tr>');
                }
            });
        });

        $(document).on('click', '.view-payment-proofs', function () {
            const $this = $(this);
            const invoice_key = $this.data('invoice-key');
            const $modalInvoiceId = $('#modalInvoiceId');
            const $tableBody = $('#paymentProofsTbody');

            $modalInvoiceId.text(invoice_key);

            $.ajax({
                url: `{{ route('invoice.payment_proofs') }}`,
                type: 'GET',
                data: {invoice_key: invoice_key},
                beforeSend: function () {
                    $tableBody.html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');
                },
                success: function (response) {
                    $tableBody.empty();

                    if (response.status === 'success' && response.payment_attachments.length > 0) {
                        let hasValidAttachments = false;

                        $.each(response.payment_attachments, function (parentIndex, payment_attachment) {
                            try {
                                const attachments = JSON.parse(payment_attachment.attachments);
                                if (attachments && attachments.length > 0) {
                                    hasValidAttachments = true;

                                    $.each(attachments, function (index, attachment) {
                                        const filePath = attachment.file_path.replace(/\\/g, '/');
                                        const fileUrl = `{{asset('/')}}${filePath}`;
                                        const fileType = attachment.extension || filePath.split('.').pop();
                                        const fileName = attachment.original_name || attachment.file_name;
                                        const createdAt = attachment.created_at || payment_attachment.created_at;
                                        const $row = $('<tr>').html(`
                                            <td class="align-middle text-center">${attachment.id}</td>
                                            <td class="align-middle text-center">${fileName}</td>
                                            <td class="align-middle text-center">${fileType}</td>
                                            <td class="align-middle text-center">
                                                <button class="btn btn-sm btn-outline-primary view-file-btn"
                                                        data-url="${fileUrl}"
                                                        data-name="${fileName}"
                                                        data-type="${fileType}">
                                                    <i class="fas fa-eye"></i> View
                                                </button>
                                            </td>
                                            <td class="align-middle text-center">${new Date(createdAt).toLocaleString()}</td>
                                            <td class="align-middle text-center">
                                                <a href="${fileUrl}" download="${fileName}" class="btn btn-sm btn-outline-primary download-btn">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </td>
                                        `);
                                        $tableBody.append($row);
                                    });
                                }
                            } catch (e) {
                                console.error('Error parsing attachments:', e);
                                $tableBody.append(`
                            <tr>
                                <td colspan="6" class="text-center text-danger">
                                    Error loading attachments for payment ${parentIndex + 1}
                                </td>
                            </tr>
                        `);
                            }
                        });

                        if (!hasValidAttachments) {
                            $tableBody.html('<tr><td colspan="6" class="text-center">No valid attachments found.</td></tr>');
                        }
                    } else {
                        $tableBody.html('<tr><td colspan="6" class="text-center">No payment attachments found.</td></tr>');
                    }
                    $('#paymentProofModal').modal('show');
                },
                error: function () {
                    $tableBody.html('<tr><td colspan="6" class="text-center text-danger">Error fetching data</td></tr>');
                }
            });
        });

        $(document).on('click', '.view-file-btn', function () {
            const url = $(this).data('url');
            const type = $(this).data('type');
            const fileName = $(this).data('name');
            previewFile(url, type, fileName);
        });

        function previewFile(url, type, fileName) {
            const $pdfFrame = $('#pdfPreview');
            const $imgPreview = $('#imagePreview');
            const $previewFileName = $('#previewFileName');
            // const fileName = url.split('/').pop();

            $previewFileName.text(fileName);
            if (type === 'pdf') {
                $pdfFrame.attr('src', `${url}#toolbar=0`).show();
                $imgPreview.hide();
            } else {
                $imgPreview.attr('src', url).show();
                $pdfFrame.hide();
            }
            $('#filePreviewModal').modal('show');
        }

        $(document).on('click', '.download-btn', function (e) {
            if (this.hostname !== window.location.hostname) {
                e.preventDefault();
                const url = $(this).attr('href');
                const fileName = $(this).attr('download');
                fetch(url)
                    .then(response => response.blob())
                    .then(blob => {
                        const blobUrl = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = blobUrl;
                        a.download = fileName;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        window.URL.revokeObjectURL(blobUrl);
                    })
                    .catch(error => {
                        console.error('Download error:', error);
                        alert('Download failed. Please try again.');
                    });
            }
        });

        $(document).on('click', '.copyBtn', async function () {
            try {
                let invoiceUrl = $(this).data('invoice-url');
                if (navigator.clipboard) {
                    await navigator.clipboard.writeText(invoiceUrl);
                    toastr.success('Invoice URL copied to clipboard!', 'Success');
                } else {
                    const textarea = document.createElement('textarea');
                    textarea.value = invoiceUrl;
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);
                    toastr.success('Invoice URL copied to clipboard!', 'Success');
                }
            } catch (err) {
                toastr.error('Failed to copy. Please try again.', 'Error');
                console.error('Clipboard copy failed:', err);
            }
        });
        {{--const groupedMerchants = @json($groupedMerchants);--}}
        {{--$('#brand_key').on('change', function () {--}}
        {{--    const selectedBrand = $(this).val();--}}
        {{--    const merchantTypesContainer = $('#merchant-types-container');--}}
        {{--    merchantTypesContainer.empty();--}}
        {{--    if (selectedBrand) {--}}
        {{--        const merchant_types = groupedMerchants[selectedBrand];--}}
        {{--        Object.keys(merchant_types).forEach(type => {--}}
        {{--            const checkboxId = `${type}_checkbox`;--}}
        {{--            const checkboxHtml = `--}}
        {{--                        <div class="payment-gateway-card" data-type="${type}">--}}
        {{--                            <div class="form-check">--}}
        {{--                                <input class="form-check-input merchant-type-checkbox" type="checkbox" id="${checkboxId}" value="${type}">--}}
        {{--                                <label class="form-check-label" for="${checkboxId}">--}}
        {{--                                    <i class="${getIconForType(type)} me-2"></i> ${type.charAt(0).toUpperCase() + type.slice(1)}--}}
        {{--                                </label>--}}
        {{--                            </div>--}}
        {{--                            <div id="merchant_${type}" class="merchant-dropdown"></div>--}}
        {{--                        </div>--}}
        {{--                    `;--}}
        {{--            merchantTypesContainer.append(checkboxHtml);--}}
        {{--        });--}}

        {{--        $('.payment-gateway-card .merchant-type-checkbox').on('change', function () {--}}
        {{--            const type = $(this).val();--}}
        {{--            const merchantDropdown = $(`#merchant_${type}`);--}}
        {{--            if ($(this).is(':checked')) {--}}
        {{--                const dropdownHtml = `--}}
        {{--                            <div class="form-group mb-3">--}}
        {{--                                <label for="merchant_select_${type}" class="form-label">Select Merchant</label>--}}
        {{--                                <select class="form-control form-select" id="merchant_select_${type}" name="merchants[${type}]" title="Please select a ${type} merchant" required>--}}
        {{--                                    <option value="" selected disabled>Please select a ${type} merchant</option>--}}
        {{--                                    ${merchant_types[type].map(merchant => `--}}
        {{--                                        <option value="${merchant.id}">${merchant.name}</option>--}}
        {{--                                    `).join('')}--}}
        {{--                                </select>--}}
        {{--                            </div>--}}
        {{--                        `;--}}
        {{--                merchantDropdown.html(dropdownHtml);--}}
        {{--            } else {--}}
        {{--                merchantDropdown.empty();--}}
        {{--            }--}}
        {{--        });--}}
        {{--    }--}}
        {{--});--}}

        /**Api Hit */
        $('#brand_key,#currency').on('change', function () {
            /**Required*/
            invoice = null;
            getMerchants($('#brand_key').val(), invoice, $("#currency").val());
        });

        function getMerchants(brand, invoice = null, currency = 'USD') {
            const selectedBrand = brand;
            const merchantTypesContainer = $('#merchant-types-container');
            merchantTypesContainer.empty();
            if (selectedBrand) {
                AjaxRequestPromise(`{{ route('user.client.account.by.brand') }}/${selectedBrand}/${currency}`, null, 'GET',)
                    .then(response => {
                        if (response.data) {
                            let merchant_types = response.data;
                            if (currency === 'GBP') {
                                merchant_types = Object.keys(merchant_types)
                                    .filter(type => ['stripe', 'paypal'].includes(type.toLowerCase()))
                                    .reduce((obj, key) => {
                                        obj[key] = merchant_types[key];
                                        return obj;
                                    }, {});
                            }
                            if (Object.keys(merchant_types).length === 0) {
                                merchantTypesContainer.html(`<p class="text-muted">Try selecting a different brand or changing currency as no payment gateway is available.</p>`);
                                return;
                            }
                            Object.keys(merchant_types).forEach(type => {
                                const safeType = type.replace(/\s+/g, '_');
                                const checkboxId = `${safeType}_checkbox`;
                                const displayName = type === "edp" ? "EasyPay Direct" :
                                    type === "bank transfer" ? "Bank Transfer" :
                                        type.charAt(0).toUpperCase() + type.slice(1);
                                const checkboxHtml = `
                                <div class="payment-gateway-card" data-type="${type}">
                                    <div class="form-check">
                                        <input class="form-check-input merchant-type-checkbox" type="checkbox" id="${checkboxId}" value="${type}">
                                        <label class="form-check-label" for="${checkboxId}">
                                            <i class="${getIconForType(type)} me-2"></i> ${displayName}
                                        </label>
                                    </div>
                                    <div id="merchant_${safeType}" class="merchant-dropdown"></div>
                                </div>
                            `;
                                merchantTypesContainer.append(checkboxHtml);

                                if (invoice && invoice.merchant_types && invoice.merchant_types[type]) {
                                    setTimeout(() => {
                                        $(`#${checkboxId}`).prop('checked', true).trigger('change');
                                    }, 50);
                                }
                            });

                            $('.payment-gateway-card .merchant-type-checkbox').on('change', function () {
                                const type = $(this).val();
                                const safeType = type.replace(/\s+/g, '_');
                                const merchantDropdown = $(`#merchant_${safeType}`);
                                if ($(this).is(':checked')) {
                                    const dropdownHtml = `
                                    <div class="form-group mb-3">
                                        <label for="merchant_select_${safeType}" class="form-label">Select Merchant</label>
                                        <select class="form-control form-select" id="merchant_select_${safeType}" name="merchants[${type}]" title="Please select a ${type} merchant" required>
                                            <option value="" selected disabled>Please select a ${type} merchant</option>
                                            ${merchant_types[type].map(merchant => `
                                                <option value="${merchant.id}">${merchant.name} ( Limit : ${merchant.limit} ) </option>
                                            `).join('')}
                                        </select>
                                    </div>
                                `;
                                    merchantDropdown.html(dropdownHtml);
                                    if (invoice && invoice.merchant_types && invoice.merchant_types[type]) {
                                        setTimeout(() => {
                                            $(`#merchant_select_${safeType}`).val(invoice.merchant_types[type]).trigger('change');
                                        }, 100);
                                    }
                                } else {
                                    merchantDropdown.empty();
                                }
                            });
                        } else {
                            console.error('Failed to fetch merchant data:', response.message);
                        }
                    }).catch((error) => {
                    console.log(error);
                });
            }
        }
        function getIconForType(type) {
            switch (type) {
                case 'authorize':
                case 'edp' :
                    return 'fas fa-credit-card';
                case 'stripe':
                    return 'fab fa-stripe';
                case 'paypal':
                    return 'fab fa-paypal';
                case 'bank transfer':
                    return 'fas fa-university';
                default:
                    return 'fas fa-question-circle';
            }
        }
    });
</script>
