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

        const exportButtons = ['copy', 'excel', 'csv', 'pdf', 'print'].map(type => ({
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
            // if ($('#companiesTable').length) {
            //     var table = $('#companiesTable').DataTable({
            //         dom:
            //             "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'>>" +
            //             "<'row'<'col-sm-12 col-md-php6'l><'col-sm-12 col-md-6'f>>" +
            //             "<'row'<'col-sm-12'tr>>" +
            //             "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
            //         buttons: exportButtons,
            //         order: [[0, 'asc']],
            //         responsive: true,
            //         scrollX: true,
            //     });
            // }
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
                    end: 0
                },
            });
            // datatable.buttons().container().appendTo(`#right-icon-${index}`);
            return datatable;
        }

        const formContainer = $('#formContainer');
        if ($("#createBtn").hasClass("void")) {
            formContainer.removeClass("open");
        }
        $('.all-tab').on('click', function () {
            dataTables[0].column('th:contains("AGENT")').search('').draw();
        });

        $('.my-tab').on('click', function () {
            const currentUser = '{{ auth()->user()->name }}';
            dataTables[0].column('th:contains("AGENT")').search(currentUser, true, false).draw();
        });

        /** Manage Record */
        $('#manage-form').on('submit', function (e) {
            e.preventDefault();
            var dataId = $('#manage-form').data('id');
            var formData = new FormData(this);
            let table = dataTables[0];

            if (!dataId) {
                // Add New Record
                AjaxRequestPromise(`{{ route("user.payment.store") }}`, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {
                                id,
                                invoice,
                                payment_gateway,
                                payment_method,
                                transaction_id,
                                customer_contact,
                                currency,
                                amount,
                                status,
                                payment_date_formatted,
                                created_at_formatted
                            } = response.data;

                            const index = table.rows().count() + 1;
                            const statusBadge = getStatusBadge(status); // Function to get status HTML

                            const columns = `
                        <td class="align-middle text-center text-nowrap"></td>
                        <td class="align-middle text-center text-nowrap">${index}</td>
                        <td class="align-middle text-center text-nowrap">
                            <span class="invoice-number">${invoice?.invoice_number ?? "---"}</span><br>
                            <span class="invoice-key">${invoice?.invoice_key ?? "---"}</span>
                        </td>
                        <td class="align-middle text-center text-nowrap">${payment_gateway?.name ?? ucwords(payment_method)}</td>
                        <td class="align-middle text-center text-nowrap">${payment_gateway?.descriptor ?? "---"}</td>
                        <td class="align-middle text-center text-nowrap">${transaction_id ?? "---"}</td>
                        <td class="align-middle text-center text-nowrap">${customer_contact?.name ?? "---"}</td>
                        <td class="align-middle text-center text-nowrap">${currency} ${parseFloat(amount ?? "0.00").toFixed(2)}</td>
                        <td class="align-middle text-center text-nowrap">${statusBadge}</td>
                        <td class="align-middle text-center text-nowrap">${payment_date_formatted}</td>
                        <td class="align-middle text-center text-nowrap">${created_at_formatted}</td>
                        `;

                            // <td class="align-middle text-center table-actions">
                            //     <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" title="Edit">
                            //         <i class="fas fa-edit"></i>
                            //     </button>
                            // </td>
                            table.row.add($('<tr>', {id: `tr-${id}`}).append(columns)).draw(false);
                            if (response.unpaid_invoices) {
                                updateInvoices(response.unpaid_invoices);
                            }
                            $('#manage-form')[0].reset();
                            $('#formContainer').removeClass('open');
                        }
                    })
                    .catch(error => console.error('An error occurred while adding the record.', error));
            }
        });

        function updateInvoices(invoices) {
            const $select = $('#invoice_key');
            $select.empty();
            $select.append(`<option value="">Create New Invoice</option>`);

            invoices.forEach(invoice => {
                const invoiceNumber = invoice.invoice_number ?? '---';
                const invoiceKey = invoice.invoice_key ?? '---';
                const customerName = invoice.customer_contact?.name ?? '---';
                const customerKey = invoice.customer_contact?.special_key ?? '';
                const currency = invoice.currency ?? 'USD';
                const totalAmount = invoice.total_amount ?? '0.00';
                const formattedDate = invoice.formatted_date ?? '---';

                const option = `<option
                    value="${invoiceKey}"
                    data-brand="${invoice.brand_key}"
                    data-team="${invoice.team_key}"
                    data-agent="${invoice.agent_id}"
                    data-amount="${totalAmount}"
                    data-customer="${customerKey}"
                >
                    ${invoiceNumber} - ${invoiceKey} - ${customerName} - ${currency} ${totalAmount} - ${formattedDate}
                </option>`;

                $select.append(option);
            });

            // Utility: Get date suffix (st, nd, rd, th)
            function getDaySuffix(day) {
                if (day >= 11 && day <= 13) return 'th';
                switch (day % 10) {
                    case 1:
                        return 'st';
                    case 2:
                        return 'nd';
                    case 3:
                        return 'rd';
                    default:
                        return 'th';
                }
            }
        }

        function ucwords(str) {
            if (!str) return '';
            return str
                .toLowerCase()
                .replace(/\b[a-z]/g, function (char) {
                    return char.toUpperCase();
                });
        }

        function getStatusBadge(status) {
            if (status == 0) return '<span class="badge bg-warning text-dark">Due</span>';
            if (status == 1) return '<span class="badge bg-success">Paid</span>';
            if (status == 2) return '<span class="badge bg-danger">Refund</span>';
            return '<span class="badge bg-secondary">Unknown</span>';
        }
    });
</script>
