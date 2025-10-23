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
        var dataTables = [];

        if ($('.initTable').length) {
            $('.initTable').each(function (index) {
                dataTables[index] = initializeDatatable($(this), index);
            });
        }

        function getColumnIndex(table, headerText) {
            const headers = table.find('thead th');
            for (let i = 0; i < headers.length; i++) {
                if ($(headers[i]).text().trim().toLowerCase() === headerText.toLowerCase()) {
                    return i;
                }
            }
            return 0;
        }
        function initializeDatatable(table_div, index) {
            const skipCols = [
                0,
                getColumnIndex(table_div, 'CREATED DATE'),
                getColumnIndex(table_div, 'LAST ACTIVITY'),
                getColumnIndex(table_div, 'STATUS'),
                getColumnIndex(table_div, 'ACTION'),
            ].filter(i => i !== null && i !== undefined).filter((value, index, self) => self.indexOf(value) === index);
            let datatable = table_div.DataTable({
                dom:
                // "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'>>" +
                    "<'row'<'col-sm-12 col-md-1'B><'col-sm-12 col-md-5'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
                buttons: [
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-columns"></i> Columns',
                        className: 'btn btn-secondary btn-sm',
                        postfixButtons: ['colvisRestore'],
                        columns: function (idx, data, node) {
                            const header = $(table_div).find('thead th').eq(idx);
                            const headerText = header.text().trim().toLowerCase();
                            if (
                                header.hasClass('no-col-vis') ||
                                header.hasClass('select-checkbox') ||
                                headerText.includes('action') ||
                                headerText.includes('select')
                            ) {
                                return false;
                            }

                            return true;
                        }
                    },
                    ...exportButtons // keep your existing export buttons
                ],
                order: [[getColumnIndex(table_div, 'CREATED DATE'), 'desc']],
                responsive: false,
                scrollX: true,
                scrollY: ($(window).height() - 350),
                scrollCollapse: true,
                paging: true,
                pageLength: 100,
                lengthMenu: [[10, 25, 50, 100, -1], ['10 Rows', '25 Rows', '50 Rows', '100 Rows', 'Show All']],
                columnDefs: [
                    {
                        orderable: false,
                        targets: 0,
                        className: 'select-checkbox',
                        render: DataTable.render.select(),
                    },
                    {
                        targets: getColumnIndex(table_div, 'CREATED DATE'),
                        type: 'date',
                        render: function (data, type, row) {
                            if (type === 'sort') {
                                return $(this).data('order') || data;
                            }
                            return data;
                        }
                    },
                    {
                        targets: '_all',
                        render: function (data, type, row, meta) {
                            if (skipCols.includes(meta.col)) return data;
                            if (!data) return '';
                            if (type !== 'display') {
                                return data;
                            }
                            const maxLength = 15;
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = data;

                            function truncateTextNodes(node) {
                                node.childNodes.forEach(child => {
                                    if (child.nodeType === Node.TEXT_NODE) {
                                        const txt = child.textContent;
                                        if (txt && txt.trim().length > maxLength) {
                                            child.textContent = txt.substring(0, maxLength) + '...';
                                        }
                                    } else if (child.nodeType === Node.ELEMENT_NODE) {
                                        truncateTextNodes(child);
                                    }
                                });
                            }

                            truncateTextNodes(tempDiv);
                            return tempDiv.innerHTML;
                        },

                        createdCell: function (td, cellData, rowData, row, col) {
                            if (skipCols.includes(col)) {
                                td.removeAttribute('title');
                                return;
                            }

                            if (!cellData) {
                                td.removeAttribute('title');
                                return;
                            }
                            const temp = document.createElement('div');
                            temp.innerHTML = cellData;
                            const fullText = (temp.textContent || temp.innerText || '').trim();
                            if (fullText.length > 15) {
                                td.setAttribute('title', fullText);
                            } else {
                                td.removeAttribute('title');
                            }
                        }
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
            datatable.columns.adjust().draw();
            datatable.buttons().container().appendTo(`#right-icon-${index}`);
            return datatable;
        }
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
                url: `{{route('admin.invoice.edit')}}/` + id,
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
            $('#manage-form').attr('action', `{{route('admin.invoice.update')}}/` + invoice.id);
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
            var dataId = $('#manage-form').data('id');
            var formData = new FormData(this);
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
                AjaxRequestPromise(`{{ route("admin.invoice.store") }}`, formData, 'POST', {useToastr: true})
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
                                created_at,
                                date,
                            } = response.data;
                            const index = table.rows().count() + 1;
                            const columns = `
                        <td class="align-middle text-center text-nowrap"></td>` +
                                // <td class="align-middle text-center text-nowrap">${index}</td>
                                // <td class="align-middle space-between text-nowrap" style="text-align: left;">
                                //     <div style="display:flex;justify-content:space-between;gap:10px;">
                                //         <span>Authorize : </span>
                                //         <span>0-0</span>
                                //     </div>
                                //     <div style="display:flex;justify-content:space-between;gap:10px;">
                                //         <span>Edp : </span>
                                //         <span>0-0</span>
                                //     </div>
                                //     <div style="display:flex;justify-content:space-between;gap:10px;">
                                //         <span>Stripe : </span>
                                //         <span>0-0</span>
                                //     </div>
                                //     <div style="display:flex;justify-content:space-between;gap:10px;">
                                //         <span>Paypal : </span>
                                //         <span>0-0</span>
                                //     </div>
                                // </td>
                                `<td class="align-middle text-center text-nowrap text-sm invoice-cell">
                            <span class="invoice-number">${invoice_number}</span><br>
                            <span class="invoice-key view-transactions text-primary"
                                                          data-bs-toggle="tooltip" data-bs-placement="top" title="Show transaction logs"
                                                          style="cursor: pointer;" data-invoice-key="${invoice_key}"><b style="font-weight: 600;">${invoice_key}</b></span>
                        </td>
                        <td class="align-middle text-center text-nowrap">
                            ${brand ? `<a href="{{route('admin.brand.index')}}?search=${brand.name}">${brand.name}</a>` : '---'}
                        </td>
                        <td class="align-middle text-center text-nowrap">${team ? `<a href="{{route('admin.team.index')}}?search=${team.name}">${team.name}</a>` : '---'}</td>
                        <td class="align-middle text-center text-nowrap">${customer_contact ? `<a href="{{route('admin.customer.contact.index')}}?search=${customer_contact.name}">${customer_contact.name}</a>` : '---'}</td>
                        <td class="align-middle text-center text-nowrap">${agent ? `<a href="{{route('admin.employee.index')}}?search=${agent.name}">${agent.name}</a>` : '---'}</td>
                        <td class="align-middle space-between text-nowrap" style="text-align: left;">` +
                                // <div style="display: flex; justify-content: space-between; gap: 10px;">
                                //     <span style="width: 120px;">Amount:</span>
                                //     <span>${currency} ${parseFloat(amount).toFixed(2)}</span>
                                // </div>
                                // <div style="display: flex; justify-content: space-between; gap: 10px;">
                                //     <span style="width: 120px;">Tax:</span>
                                //     <span>${tax_type === 'percentage' ? '%' : (tax_type === 'fixed' ? currency : '')} ${tax_value ?? 0}</span>
                                // </div>
                                // <div style="display: flex; justify-content: space-between; gap: 10px;">
                                //     <span style="width: 120px;">Tax Amount:</span>
                                //     <span>${currency} ${parseFloat(tax_amount).toFixed(2)}</span>
                                // </div>
                                `<div style="display: flex; justify-content: space-between; gap: 10px;">
                                <span>${currency} ${parseFloat(total_amount).toFixed(2)}</span>
                            </div>
                        </td>
                        <td class="align-middle text-center text-nowrap">
                            ${status == 0 ? '<span class="badge bg-warning text-dark">Due</span>' : status == 1 ? '<span class="badge bg-success">Paid</span>' : status == 2 ? '<span class="badge bg-danger">Refund</span>' : status == 3 ? '<span class="badge bg-danger">Charge Back</span>' : ''}
                        </td>
                        <td class="align-middle text-center text-nowrap">${due_date}</td>
                        <td class="align-middle text-center text-nowrap" data-order="${created_at}">${date}</td>
                        <td class="align-middle text-center table-actions">
                        <button type="button" class="btn btn-sm btn-primary copyBtn"
                                                            data-id="${id}"
                                                            data-invoice-key="${invoice_key}"
                                                            data-invoice-url="${basePath}/invoice?InvoiceID=${invoice_key}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Copy Invoice Url"><i
                                                            class="fas fa-copy"></i></button>
                            ${status != 1 ? '<br><button type="button" class="btn btn-sm btn-primary editBtn mt-2" data-id="' + id + '" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class = "fas fa-edit" aria-hidden="true"> </i></button> ' +
                                    '<button type="button" class="btn btn-sm btn-danger deleteBtn mt-2" data-id="' + id + '" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fas fa-trash" aria-hidden="true"></i></button>'
                                    : ''}
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
                                agent,
                                amount, tax_type, tax_value,
                                tax_amount, total_amount, currency,
                                status,
                                due_date,
                                date,
                                created_at,
                                payment_attachments,
                                gateway_counts,
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
                            // const gatewayCountsHtml = `
                            //     ${(gateway_counts.m.includes('authorize') || gateway_counts.s.authorize > 0 || gateway_counts.f.authorize > 0) ? `
                            //     <div style="display:flex;justify-content:space-between;gap:10px;">
                            //         <span>Authorize : </span>
                            //         <span>${gateway_counts.s.authorize}-<span class="text-danger">${gateway_counts.f.authorize}</span></span>
                            //     </div>` : ''}
                            //     ${(gateway_counts.m.includes('edp') || gateway_counts.s.edp > 0 || gateway_counts.f.edp > 0) ? `
                            //     <div style="display:flex;justify-content:space-between;gap:10px;">
                            //         <span>Edp : </span>
                            //         <span>${gateway_counts.s.edp}-<span class="text-danger">${gateway_counts.f.edp}</span></span>
                            //     </div>` : ''}
                            //     ${(gateway_counts.m.includes('stripe') || gateway_counts.s.stripe > 0 || gateway_counts.f.stripe > 0) ? `
                            //     <div style="display:flex;justify-content:space-between;gap:10px;">
                            //         <span>Stripe : </span>
                            //         <span>${gateway_counts.s.stripe}-<span class="text-danger">${gateway_counts.f.stripe}</span></span>
                            //     </div>` : ''}
                            //     ${(gateway_counts.m.includes('paypal') || gateway_counts.s.paypal > 0 || gateway_counts.f.paypal > 0) ? `
                            //     <div style="display:flex;justify-content:space-between;gap:10px;">
                            //         <span>Paypal : </span>
                            //         <span>${gateway_counts.s.paypal}-<span class="text-danger">${gateway_counts.f.paypal}</span></span>
                            //     </div>` : ''}
                            // `;
                            // if (decodeHtml(rowData[2]) !== gatewayCountsHtml) {
                            //     table.cell(index, 2).data(gatewayCountsHtml).draw();
                            // }
                            // Update columns in the table dynamically
                            // Column 3: Invoice Number & Invoice Key
                            if (decodeHtml(rowData[1]) !== `${invoice_number}<br>${invoice_key}`) {
                                table.cell(index, 1).data(`
                                    <span class="invoice-number">${invoice_number}</span><br>
                            <span class="invoice-key view-transactions text-primary"
                                                          data-bs-toggle="tooltip" data-bs-placement="top" title="Show transaction logs"
                                                          style="cursor: pointer;" data-invoice-key="${invoice_key}"><b style="font-weight: 600;">${invoice_key}</b></span>
                                `).draw();
                            }

                            // Column 4: Brand
                            if (decodeHtml(rowData[2]) !== `${brand ? `<a href="{{route('admin.brand.index')}}?search=${brand.name}">${brand.name}</a>` : '---'}`) {
                                table.cell(index, 2).data(`${brand ? `<a href="{{route('admin.brand.index')}}?search=${brand.name}">${brand.name}</a>` : '---'}`).draw();
                            }

                            // Column 5: Team
                            if (decodeHtml(rowData[3]) !== `${team ? `<a href="{{route('admin.team.index')}}?search=${team.name}">${team.name}</a>` : '---'}`) {
                                table.cell(index, 3).data(`${team ? `<a href="{{route('admin.team.index')}}?search=${team.name}">${team.name}</a>` : '---'}`).draw();
                            }

                            // Column 6: Customer Contact
                            if (decodeHtml(rowData[4]) !== `${customer_contact ? `<a href="{{route('admin.customer.contact.index')}}?search=${customer_contact.name}">${customer_contact.name}</a>` : '---'}`) {
                                table.cell(index, 4).data(`${customer_contact ? `<a href="{{route('admin.customer.contact.index')}}?search=${customer_contact.name}">${customer_contact.name}</a>` : '---'}`).draw();
                            }
                            // Column 7: Agent
                            if (decodeHtml(rowData[5]) !== `${agent ? `<a href="{{route('admin.employee.index')}}?search=${agent.name}">${agent.name}</a>` : '---'}`) {
                                table.cell(index, 5).data(`${agent ? `<a href="{{route('admin.employee.index')}}?search=${agent.name}">${agent.name}</a>` : '---'}`).draw();
                            }

                            const newContent = `` +
                                // <div style="display: flex; justify-content: space-between; gap: 10px;">
                                //     <span style="width: 120px;">Amount:</span>
                                //     <span>${currency} ${parseFloat(amount).toFixed(2)}</span>
                                // </div>
                                // <div style="display: flex; justify-content: space-between; gap: 10px;">
                                //     <span style="width: 120px;">Tax:</span>
                                //     <span>${tax_type === 'percentage' ? '%' : (tax_type === 'fixed' ? currency : '')} ${tax_value ?? 0}</span>
                                // </div>
                                // <div style="display: flex; justify-content: space-between; gap: 10px;">
                                //     <span style="width: 120px;">Tax Amount:</span>
                                //     <span>${currency} ${parseFloat(tax_amount).toFixed(2)}</span>
                                // </div>
                                `<div style="display: flex; justify-content: space-between; gap: 10px;">
                                    <span>${currency} ${parseFloat(total_amount).toFixed(2)}</span>
                                </div>`;
                            // Column 8: Amount
                            if (decodeHtml(rowData[6]) !== newContent) {
                                table.cell(index, 6).data(newContent).draw();
                            }

                            // Column 9: Status

                            const statusHtml = status == 0 ? '<span class="badge bg-warning text-dark">Due</span>' : status == 1 ? '<span class="badge bg-success">Paid</span>' : status == 2 ? '<span class="badge bg-danger">Refund</span>' : status == 3 ? '<span class="badge bg-danger">Charge Back</span>' : '';
                            if (decodeHtml(rowData[7]) !== statusHtml) {
                                table.cell(index, 7).data(statusHtml).draw();
                            }

                            // Column 10: Due Date
                            if (decodeHtml(rowData[8]) !== due_date) {
                                table.cell(index, 8).data(due_date).draw();
                            }
                            // Column 11: Date
                            if (decodeHtml(rowData[9]) !== date) {
                                table.cell(index, 9).data(date).draw();

                                const cell = table.cell(index, 9);
                                const cellNode = cell.node();
                                $(cellNode)
                                    .data('order', created_at)
                                    .html(date);

                                table.draw();
                            }
                            // Column 12: Actions
                            let actionsHtml = '';
                            if (brand) {
                                actionsHtml += `<button type="button" class="btn btn-sm btn-primary copyBtn" data-id="${id}" data-invoice-key="${invoice_key}" data-invoice-url="${basePath}/invoice?InvoiceID=${invoice_key}" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy Invoice Url"><i class="fas fa-copy" aria-hidden="true"></i></button> `;
                            }
                            if (payment_attachments && payment_attachments.length > 0) {
                                actionsHtml += `<button type="button" class="btn btn-sm btn-primary view-payment-proofs" data-invoice-key="${invoice_key}" data-bs-toggle="tooltip" data-bs-placement="top" title="View Payment Proofs"><i class="fas fa-paperclip" aria-hidden="true"></i>  ${totalAttachments}  </button> `;
                            } else {
                                actionsHtml += `<button type="button" class="btn btn-sm btn-primary disabled" data-bs-toggle="tooltip" data-bs-placement="top" title="View Payment Proofs"><i class="fas fa-paperclip"></i>0</button> `;
                            }
                            if (status != 1) {
                                actionsHtml += `<br><button type="button" class="btn btn-sm btn-primary editBtn mt-2" data-id="${id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fas fa-edit" aria-hidden="true"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger deleteBtn mt-2" data-id="${id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="fas fa-trash" aria-hidden="true"></i></button>`;
                            }
                            if (normalizeHtml(decodeHtml(rowData[10])) !== normalizeHtml(actionsHtml)) {
                                table.cell(index, 10).data(actionsHtml).draw();
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

        /** Delete Record */
        $(document).on('click', '.deleteBtn', function () {
            const id = $(this).data('id');
            let table = dataTables[0];
            AjaxDeleteRequestPromise(`{{ route("admin.invoice.delete", "") }}/${id}`, null, 'DELETE', {
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
        $(document).on('click', '.view-transactions', function () {
            let invoice_key = $(this).data('invoice-key');

            $.ajax({
                url: `{{ route('admin.payment-transaction-logs') }}`,
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
                            let responseMessage = '';
                            if (log.status === 'success') {
                                responseMessage = log.response_message || '---';
                            } else {
                                responseMessage = log.error_message || '---';
                            }
                            let paymentStatus = log.status === 'success' ?
                                '<span class="badge bg-success">Paid</span>' :
                                '<span class="badge bg-danger">Not Paid</span>';
                            rows += `
                        <tr>
                            <td class="align-middle">${index + 1}</td>
                            <td class="align-middle">${log.merchant ?? "---"}</td>
                            <td class="align-middle">${log.last_4 ?? "---"}</td>
                            <td class="align-middle">${log.transaction_id ?? "---"}</td>
                            <td class="align-middle">$${parseFloat(log.amount || 0).toFixed(2)}</td>
                            <td class="align-middle">${responseMessage}</td>
                            <td class="align-middle">${log.response_code_message || "---"}</td>
                            <td class="align-middle">${log.avs_message || "---"}</td>
                            <td class="align-middle">${log.cvv_message || "---"}</td>
                            <td class="align-middle">${log.cavv_message || "---"}</td>
                            <td class="align-middle">${paymentStatus}</td>
                            <td class="align-middle">${formattedDate}</td>
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
                url: `{{ route('admin.invoice.payment_proofs') }}`,
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
        {{--                                <select class="form-control form-select" id="merchant_select_${type}" name="merchants[${type}]" data-bs-toggle="tooltip" data-bs-placement="top" title="Please select a ${type} merchant" required>--}}
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
                AjaxRequestPromise(`{{ route('admin.client.account.by.brand') }}/${selectedBrand}/${currency}`, null, 'GET',)
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
                                        <select class="form-control form-select" id="merchant_select_${safeType}" name="merchants[${type}]" data-bs-toggle="tooltip" data-bs-placement="top" title="Please select a ${type} merchant" required>
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

        $('#dateRangePicker').daterangepicker({
            timePicker: true,
            timePicker24Hour: false,
            timePickerIncrement: 1,
            locale: {
                format: 'YYYY-MM-DD h:mm:ss A',
            },
            startDate: moment().startOf('month').startOf('day'),
            endDate: moment().endOf('month').endOf('day'),
            ranges: {
                'Today': [moment().startOf('day'), moment().endOf('day')],
                'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
                'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('day')],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
            }
        });

        $('#teamSelect, #brandSelect').change(function () {
            filterInvoices();
        });
        $('#dateRangePicker').on('apply.daterangepicker', function () {
            filterInvoices();
        });
        @if(isset($actual_dates['start_date']) && isset($actual_dates['end_date']))
        let actualStart = moment("{{ $actual_dates['start_date'] }}", "YYYY-MM-DD h:mm:ss A");
        let actualEnd = moment("{{ $actual_dates['end_date'] }}", "YYYY-MM-DD h:mm:ss A");

        $('#dateRangePicker').data('daterangepicker').setStartDate(actualStart);
        $('#dateRangePicker').data('daterangepicker').setEndDate(actualEnd);
        @endif
        function filterInvoices() {
            const teamKey = $('#teamSelect').val();
            const brandKey = $('#brandSelect').val();
            const dates = $('#dateRangePicker').data('daterangepicker');

            let table = dataTables[0];
            table.clear().draw(); // Clear existing rows

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

            AjaxRequestPromise(`{{ route("admin.invoice.filter") }}`, {
                team_key: teamKey,
                brand_key: brandKey,
                start_date: dates.startDate.format('YYYY-MM-DD h:mm:ss A'),
                end_date: dates.endDate.format('YYYY-MM-DD h:mm:ss A'),
            }, 'GET', {useToastr: false})
                .then(response => {
                    if (response && response.success && response.data) {
                        if (response.actual_dates) {
                            const actualStart = moment(response.actual_dates.start_date, 'YYYY-MM-DD h:mm:ss A');
                            const actualEnd = moment(response.actual_dates.end_date, 'YYYY-MM-DD h:mm:ss A');
                            $('#dateRangePicker').data('daterangepicker').setStartDate(actualStart);
                            $('#dateRangePicker').data('daterangepicker').setEndDate(actualEnd);
                            if (response.actual_dates.start_date !== dates.startDate.format('YYYY-MM-DD h:mm:ss A') ||
                                response.actual_dates.end_date !== dates.endDate.format('YYYY-MM-DD h:mm:ss A')) {
                                toastr.info('Date range adjusted to show available records');
                            }
                        }
                        response.data.forEach(function (invoice, index) {
                            const {
                                id,
                                invoice_number,
                                invoice_key,
                                brand,
                                team,
                                customer_contact,
                                agent,
                                amount, tax_type, tax_value,
                                tax_amount, total_amount,
                                currency,
                                status,
                                due_date,
                                date,
                                created_at,
                                payment_attachments,
                                gateway_counts,
                            } = invoice;
                            index++;
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
                            // const gatewayCountsHtml = `
                            //     ${(gateway_counts.m.includes('authorize') || gateway_counts.s.authorize > 0 || gateway_counts.f.authorize > 0) ? `
                            //     <div style="display:flex;justify-content:space-between;gap:10px;">
                            //         <span>Authorize : </span>
                            //         <span>${gateway_counts.s.authorize}-<span class="text-danger">${gateway_counts.f.authorize}</span></span>
                            //     </div>` : ''}
                            //     ${(gateway_counts.m.includes('edp') || gateway_counts.s.edp > 0 || gateway_counts.f.edp > 0) ? `
                            //     <div style="display:flex;justify-content:space-between;gap:10px;">
                            //         <span>Edp : </span>
                            //         <span>${gateway_counts.s.edp}-<span class="text-danger">${gateway_counts.f.edp}</span></span>
                            //     </div>` : ''}
                            //     ${(gateway_counts.m.includes('stripe') || gateway_counts.s.stripe > 0 || gateway_counts.f.stripe > 0) ? `
                            //     <div style="display:flex;justify-content:space-between;gap:10px;">
                            //         <span>Stripe : </span>
                            //         <span>${gateway_counts.s.stripe}-<span class="text-danger">${gateway_counts.f.stripe}</span></span>
                            //     </div>` : ''}
                            //     ${(gateway_counts.m.includes('paypal') || gateway_counts.s.paypal > 0 || gateway_counts.f.paypal > 0) ? `
                            //     <div style="display:flex;justify-content:space-between;gap:10px;">
                            //         <span>Paypal : </span>
                            //         <span>${gateway_counts.s.paypal}-<span class="text-danger">${gateway_counts.f.paypal}</span></span>
                            //     </div>` : ''}
                            // `;
                            const columns = `
                        <td class="align-middle text-center text-nowrap"></td>` +
                                // <td class="align-middle text-center text-nowrap">${index}</td>
                                // <td class="align-middle text-center text-nowrap">${gatewayCountsHtml}</td>
                                `<td class="align-middle text-center text-nowrap text-sm invoice-cell">
                            <span class="invoice-number">${invoice_number}</span><br>
                            <span class="invoice-key view-transactions text-primary"
                                                          title="Show transaction logs"
                                                          style="cursor: pointer;" data-invoice-key="${invoice_key}"><b style="font-weight: 600;">${invoice_key}</b></span>
                        </td>
                        <td class="align-middle text-center text-nowrap">
                            ${brand ? `<a href="{{route('admin.brand.index')}}?search=${brand.name}">${brand.name}</a>` : '---'}
                        </td>
                        <td class="align-middle text-center text-nowrap">${team ? `<a href="{{route('admin.team.index')}}?search=${team.name}">${team.name}</a>` : '---'}</td>
                        <td class="align-middle text-center text-nowrap">${customer_contact ? `<a href="{{route('admin.customer.contact.index')}}?search=${customer_contact.name}">${customer_contact.name}</a>` : '---'}</td>
                        <td class="align-middle text-center text-nowrap">${agent ? `<a href="{{route('admin.employee.index')}}?search=${agent.name}">${agent.name}</a>` : '---'}</td>
                        <td class="align-middle space-between text-nowrap" style="text-align: left;">` +
                                // <div style="display: flex; justify-content: space-between; gap: 10px;">
                                //     <span style="width: 120px;">Amount:</span>
                                //     <span>${currency} ${parseFloat(amount).toFixed(2)}</span>
                                // </div>
                                // <div style="display: flex; justify-content: space-between; gap: 10px;">
                                //     <span style="width: 120px;">Tax:</span>
                                //     <span>${tax_type === 'percentage' ? '%' : (tax_type === 'fixed' ? currency : '')} ${tax_value ?? 0}</span>
                                // </div>
                                // <div style="display: flex; justify-content: space-between; gap: 10px;">
                                //     <span style="width: 120px;">Tax Amount:</span>
                                //     <span>${currency} ${parseFloat(tax_amount).toFixed(2)}</span>
                                // </div>
                                `<div style="display: flex; justify-content: space-between; gap: 10px;">
                                <span>${currency} ${parseFloat(total_amount).toFixed(2)}</span>
                            </div>
                        </td>
                        <td class="align-middle text-center text-nowrap">
                            ${status == 0 ? '<span class="badge bg-warning text-dark">Due</span>' : status == 1 ? '<span class="badge bg-success">Paid</span>' : status == 2 ? '<span class="badge bg-danger">Refund</span>' : status == 3 ? '<span class="badge bg-danger">Charge Back</span>' : ''}
                        </td>
                        <td class="align-middle text-center text-nowrap">${due_date}</td>
                        <td class="align-middle text-center text-nowrap" data-order="${created_at}">${date}</td>
                        <td class="align-middle text-center table-actions">
                        <button type="button" class="btn btn-sm btn-primary copyBtn"
                                                            data-id="${id}"
                                                            data-invoice-key="${invoice_key}"
                                                            data-invoice-url="${basePath}/invoice?InvoiceID=${invoice_key}"
                                                            title="Copy Invoice Url"><i
                                                            class="fas fa-copy"></i></button>
                            ${payment_attachments && payment_attachments.length > 0 ? `<button type="button" class="btn btn-sm btn-primary view-payment-proofs" data-invoice-key="${invoice_key}" title="View Payment Proofs"><i class="fas fa-paperclip" aria-hidden="true"></i>  ${totalAttachments}  </button> ` : '<button type="button" class="btn btn-sm btn-primary disabled" data-bs-toggle="tooltip" data-bs-placement="top" title="View Payment Proofs"><i class="fas fa-paperclip"></i>0</button>'}
                            ${status != 1 ? '<br><button type="button" class="btn btn-sm btn-primary editBtn mt-2" data-id="' + id + '" title="Edit"><i class = "fas fa-edit" aria-hidden="true"> </i></button> ' +
                                    '<button type="button" class="btn btn-sm btn-danger deleteBtn mt-2" data-id="' + id + '" title="Delete"><i class="fas fa-trash" aria-hidden="true"></i></button>'
                                    : ''}
                        </td>`;
                            table.row.add($('<tr>', {id: `tr-${id}`}).append(columns)).draw(false);
                        })
                    }
                })

                .catch(error => console.error('An error occurred while updating the record.', error))
        }

        $('#dateRangePicker').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(
                picker.startDate.format('YYYY-MM-DD h:mm:ss A') + ' - ' +
                picker.endDate.format('YYYY-MM-DD h:mm:ss A')
            );
        });
    });
</script>
