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
                    end: 0
                },
            });
            datatable.buttons().container().appendTo(`#right-icon-${index}`);
            return datatable;

        }

        /** Edit */
        {{--$(document).on('click', '.editBtn', function () {--}}
        {{--    const id = $(this).data('id');--}}
        {{--    if (!id) {--}}
        {{--        Swal.fire({--}}
        {{--            title: 'Error!',--}}
        {{--            text: 'Record not found. Do you want to reload the page?',--}}
        {{--            icon: 'error',--}}
        {{--            showCancelButton: true,--}}
        {{--            confirmButtonText: 'Reload',--}}
        {{--            cancelButtonText: 'Cancel'--}}
        {{--        }).then((result) => {--}}
        {{--            if (result.isConfirmed) {--}}
        {{--                location.reload();--}}
        {{--            }--}}
        {{--        });--}}
        {{--    }--}}
        {{--    $('#manage-form')[0].reset();--}}
        {{--    $.ajax({--}}
        {{--        url: `{{route('admin.payment.edit')}}/` + id,--}}
        {{--        type: 'GET',--}}
        {{--        success: function (response) {--}}
        {{--            setDataAndShowEdit(response);--}}
        {{--        },--}}
        {{--        error: function () {--}}
        {{--            console.log(jqXHR, textStatus, errorThrown);--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}

        function setDataAndShowEdit(data) {
            let payment = data.payment;
            $('#manage-form').data('id', payment.id);

            $('#brand_key').val(payment.brand_key).trigger('change');
            $('#team_key').val(payment.team_key).trigger('change');
            $('#agent_id').val(payment.agent_id).trigger('change');
            $('#payment_type').val(payment.payment_type).trigger('change');
            $('#address').val(payment.address);
            $('#customer_contact_name').val(payment.customer_contact?.name);
            $('#customer_contact_email').val(payment.customer_contact?.email);
            $('#customer_contact_phone').val(payment.customer_contact?.phone);
            $('#cus_contact_key').val(payment.customer_contact?.special_key).trigger('change');
            $('#currency').val(payment.currency);
            $('#amount').val(payment.amount);
            $('#description').val(payment.description);
            $('#payment_method').val(payment.payment_method);
            if (payment.payment_date) {
                let formattedDate = payment.payment_date.split(' ')[0];
                $('#payment_date').val(formattedDate);
            }
            $('#transaction_id').val(payment.transaction_id);

            $('#manage-form').attr('action', `{{route('admin.payment.update')}}/` + payment.id);
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
            let table = dataTables[0];
            if (!dataId) {
                AjaxRequestPromise(`{{ route("admin.payment.store") }}`, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {
                                id,
                                invoice,
                                payment_gateway,
                                payment_method,
                                transaction_id,
                                brand,
                                team,
                                agent,
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
                        <td class="align-middle text-center text-nowrap">${brand?.name ?? "---"}</td>
                        <td class="align-middle text-center text-nowrap">${team?.name ?? "---"}</td>
                        <td class="align-middle text-center text-nowrap">${agent?.name ?? "---"}</td>
                        <td class="align-middle text-center text-nowrap">${customer_contact?.name ?? "---"}</td>
                        <td class="align-middle text-center text-nowrap">${currency} ${parseFloat(amount ?? "0.00").toFixed(2)}</td>
                        <td class="align-middle text-center text-nowrap">${statusBadge}</td>
                        <td class="align-middle text-center text-nowrap">${payment_date_formatted}</td>
                        <td class="align-middle text-center text-nowrap">${created_at_formatted}</td>
                        `;

                            // <td class="align-middle text-center table-actions">
                            //     <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
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
            } else {
                // Update Existing Record
                const url = $(this).attr('action');
                AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {
                                id,
                                invoice,
                                payment_gateway,
                                payment_method,
                                transaction_id,
                                brand,
                                team,
                                agent,
                                customer_contact,
                                currency,
                                amount,
                                status,
                                payment_date_formatted,
                                created_at_formatted
                            } = response.data;

                            const index = table.row($(`#tr-${id}`)).index();
                            const rowData = table.row(index).data();
                            const statusBadge = getStatusBadge(status);

                            // Column 3: Invoice Number & Invoice Key
                            if (decodeHtml(rowData[2]) !== `${invoice?.invoice_number}<br>${invoice?.invoice_key}`) {
                                table.cell(index, 2).data(`
                                    <span class="invoice-number">${invoice?.invoice_number}</span><br>
                                    <span class="invoice-key">${invoice?.invoice_key}</span>
                                `).draw();
                            }
                            // Column 4: Payment Gateway / Method
                            if (decodeHtml(rowData[3]) !== (payment_gateway?.name ?? ucwords(payment_method))) {
                                table.cell(index, 3).data(payment_gateway?.name ?? ucwords(payment_method)).draw();
                            }

                            // Column 5: Payment Gateway Descriptor
                            if (decodeHtml(rowData[4]) !== (payment_gateway?.descriptor ?? "---")) {
                                table.cell(index, 4).data(payment_gateway?.descriptor ?? "---").draw();
                            }

                            // Column 6: Transaction ID
                            if (decodeHtml(rowData[5]) !== transaction_id) {
                                table.cell(index, 5).data(transaction_id ?? "---").draw();
                            }

                            // Column 7: Brand Name
                            if (decodeHtml(rowData[6]) !== brand?.name) {
                                table.cell(index, 6).data(brand?.name ?? "---").draw();
                            }

                            // Column 8: Team Name
                            if (decodeHtml(rowData[7]) !== team?.name) {
                                table.cell(index, 7).data(team?.name ?? "---").draw();
                            }

                            // Column 9: Agent Name
                            if (decodeHtml(rowData[8]) !== agent?.name) {
                                table.cell(index, 8).data(agent?.name ?? "---").draw();
                            }

                            // Column 10: Customer Name
                            if (decodeHtml(rowData[9]) !== customer_contact?.name) {
                                table.cell(index, 9).data(customer_contact?.name ?? "---").draw();
                            }

                            // Column 11: Amount
                            if (decodeHtml(rowData[10]) !== `${currency} ${parseFloat(amount ?? "0.00").toFixed(2)}`) {
                                table.cell(index, 10).data(`$${amount ?? "0.00"}`).draw();
                            }

                            // Column 12: Status
                            if (decodeHtml(rowData[11]) !== statusBadge) {
                                table.cell(index, 11).data(statusBadge).draw();
                            }

                            // Column 13: Created At
                            if (decodeHtml(rowData[12]) !== payment_date_formatted) {
                                table.cell(index, 12).data(payment_date_formatted).draw();
                            }

                            // Column 13: Created At
                            if (decodeHtml(rowData[13]) !== created_at_formatted) {
                                table.cell(index, 13).data(created_at_formatted).draw();
                            }

                            $('#manage-form')[0].reset();
                            $('#formContainer').removeClass('open');
                        }
                    })
                    .catch(error => console.error('An error occurred while updating the record.', error));
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

        $('#dateRangePicker').daterangepicker({
            timePicker: true,
            timePicker24Hour: false,
            timePickerIncrement: 1,
            locale: {
                format: 'YYYY-MM-DD h:mm:ss A',
            },
            startDate: moment().startOf('month').startOf('day'),    // First moment of first day of month
            endDate: moment().endOf('month').endOf('day'),         // Last moment of last day of month
            ranges: {
                'Today': [
                    moment().startOf('day').set({hour: 0, minute: 0}), // 12:00 AM
                    moment().endOf('day').set({hour: 23, minute: 59, second: 59})  // 11:59:59 PM
                ],
                'Yesterday': [
                    moment().subtract(1, 'days').startOf('day').set({hour: 0, minute: 0}), // 12:00 AM
                    moment().subtract(1, 'days').endOf('day').set({hour: 23, minute: 59, second: 59})   // 11:59:59 PM
                ],
                'Last 7 Days': [
                    moment().subtract(6, 'days').startOf('day').set({hour: 0, minute: 0}), // 12:00 AM
                    moment().endOf('day').set({hour: 23, minute: 59, second: 59})                       // 11:59:59 PM
                ],
                'Last 30 Days': [
                    moment().subtract(29, 'days').startOf('day').set({hour: 0, minute: 0}), // 12:00 AM
                    moment().endOf('day').set({hour: 23, minute: 59, second: 59})                        // 11:59:59 PM
                ],
                'This Month': [
                    moment().startOf('month').set({hour: 0, minute: 0}), // 12:00 AM
                    moment().endOf('month').set({hour: 23, minute: 59, second: 59})  // 11:59:59 PM
                ],
                'Last Month': [
                    moment().subtract(1, 'month').startOf('month').set({hour: 0, minute: 0}), // 12:00 AM
                    moment().subtract(1, 'month').endOf('month').set({hour: 23, minute: 59, second: 59})   // 11:59:59 PM
                ],
                'Current Quarter': [
                    moment().startOf('quarter').set({hour: 0, minute: 0}), // 12:00 AM
                    moment().endOf('quarter').set({hour: 23, minute: 59, second: 59})   // 11:59:59 PM
                ],
                'Last Quarter': [
                    moment().subtract(1, 'quarter').startOf('quarter').set({hour: 0, minute: 0}), // 12:00 AM
                    moment().subtract(1, 'quarter').endOf('quarter').set({hour: 23, minute: 59, second: 59})   // 11:59:59 PM
                ],
                'This Year': [
                    moment().startOf('year').set({hour: 0, minute: 0}), // 12:00 AM
                    moment().endOf('day').set({hour: 23, minute: 59, second: 59})    // 11:59:59 PM
                ],
                'Last Year': [
                    moment().subtract(1, 'year').startOf('year').set({hour: 0, minute: 0}), // 12:00 AM
                    moment().subtract(1, 'year').endOf('year').set({hour: 23, minute: 59, second: 59})   // 11:59:59 PM
                ],
            }
        });
        $('#teamSelect, #brandSelect,#dateTypeSelect').change(function () {
            filterPayments();
        });
        $('#dateRangePicker').on('apply.daterangepicker', function (ev, picker) {
            filterPayments();
        });

        function filterPayments() {
            const teamKey = $('#teamSelect').val();
            const brandKey = $('#brandSelect').val();
            const dateTypeSelect = $('#dateTypeSelect').val();
            const dates = $('#dateRangePicker').data('daterangepicker');
            let table = dataTables[0];
            table.clear().draw();
            AjaxRequestPromise(`{{ route("admin.payment.filter") }}`, {
                team_key: teamKey,
                brand_key: brandKey,
                start_date: dates.startDate.format('YYYY-MM-DD h:mm:ss A'),
                end_date: dates.endDate.format('YYYY-MM-DD h:mm:ss A'),
                date_type: dateTypeSelect,
            }, 'GET', {useToastr: false})
                .then(response => {
                    if (response && response.success && response.data) {
                        response.data.forEach(function (payment, index) {
                            const {
                                id,
                                invoice,
                                payment_gateway,
                                payment_method,
                                transaction_id,
                                brand,
                                team,
                                agent,
                                customer_contact,
                                currency,
                                amount,
                                status,
                                payment_date_formatted,
                                created_at_formatted
                            } = payment;
                            index++;
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
                                <td class="align-middle text-center text-nowrap">${brand?.name ?? "---"}</td>
                                <td class="align-middle text-center text-nowrap">${team?.name ?? "---"}</td>
                                <td class="align-middle text-center text-nowrap">${agent?.name ?? "---"}</td>
                                <td class="align-middle text-center text-nowrap">${customer_contact?.name ?? "---"}</td>
                                <td class="align-middle text-center text-nowrap">${currency} ${parseFloat(amount ?? "0.00").toFixed(2)}</td>
                                <td class="align-middle text-center text-nowrap">${statusBadge}</td>
                                <td class="align-middle text-center text-nowrap">${payment_date_formatted}</td>
                                <td class="align-middle text-center text-nowrap">${created_at_formatted}</td>
                            `;
                            table.row.add($('<tr>', {id: `tr-${id}`}).append(columns)).draw(false);
                        });
                    }
                })
                .catch(error => console.error('An error occurred while updating the record.', error))
        }

        $('#dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(
                picker.startDate.format('YYYY-MM-DD h:mm:ss A') + ' - ' +
                picker.endDate.format('YYYY-MM-DD h:mm:ss A')
            );
        });
        $('#dateRangePicker').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>
