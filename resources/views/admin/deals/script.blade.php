<script>
    $(document).ready(function () {
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
                getColumnIndex(table_div, 'CLOSE DATE'),
                getColumnIndex(table_div, 'STATUS'),
                getColumnIndex(table_div, 'ACTION'),
            ].filter(i => i !== null && i !== undefined).filter((value, index, self) => self.indexOf(value) === index);

            let datatable = table_div.DataTable({
                dom: "<'row'<'col-sm-12 col-md-1'B><'col-sm-12 col-md-5'l><'col-sm-12 col-md-6'f>>" +
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
                ],
                order: [[getColumnIndex(table_div, 'CLOSE DATE'), 'desc']],
                responsive: false,
                autoWidth: true,
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
                        targets: getColumnIndex(table_div, 'CLOSE DATE'),
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
                            if (type !== 'display') return data;

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
                            if (skipCols.includes(col) || !cellData) {
                                td.innerHTML = cellData || '';
                                return;
                            }
                            const temp = document.createElement('div');
                            temp.innerHTML = cellData;
                            const fullText = (temp.textContent || temp.innerText || '').trim();
                            const tooltipDiv = document.createElement('div');
                            tooltipDiv.classList.add('truncate-cell');
                            tooltipDiv.innerHTML = td.innerHTML;
                            td.innerHTML = '';
                            td.appendChild(tooltipDiv);
                            if (fullText.length > 15) {
                                tooltipDiv.setAttribute('title', fullText);
                                tooltipDiv.setAttribute('data-bs-toggle', 'tooltip');
                                tooltipDiv.setAttribute('data-bs-placement', 'top');
                            }
                            new bootstrap.Tooltip(tooltipDiv);
                        }
                    },
                    {width: '10%', targets: 0},  // checkbox column
                    {width: '20%', targets: 1},  // DEAL NAME
                    {width: '15%', targets: 2},  // COMPANY
                    {width: '15%', targets: 3},  // CONTACT
                    {width: '12%', targets: 4},  // DEAL STAGE
                    {width: '8%', targets: 5},   // AMOUNT
                    {width: '8%', targets: 6},   // CLOSE DATE
                    {width: '7%', targets: 7},   // PRIORITY
                    {width: '5%', targets: 8},   // STATUS
                    {width: '10%', targets: 9},  // ACTION buttons
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

        dataTables[0].on('draw', function () {
            const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"], [title]');
            tooltipElements.forEach(el => {
                new bootstrap.Tooltip(el);
            });
        });

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
                url: `{{route('admin.deal.edit')}}/` + id,
                type: 'GET',
                success: function (response) {
                    console.log(response);

                    setDataAndShowEdit(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });

        function setDataAndShowEdit(data) {
            let deal = data?.deal;
            $('#manage-form').data('id', deal.id);

            $('#cus_company_key').val(deal.cus_company_key).trigger('change');
            $('#cus_contact_key').val(deal.cus_contact_key).trigger('change');
            $('#name').val(deal.name);
            $('#deal_stage').val(deal.deal_stage).trigger('change');
            $('#amount').val(deal.amount);
            
            // Easiest fix - just split on 'T' and take first part
            $('#start_date').val(deal.start_date?.split('T')[0] || '');
            $('#close_date').val(deal.close_date?.split('T')[0] || '');
            $('#contact_start_date').val(deal.contact_start_date?.split('T')[0] || '');
            $('#company_start_date').val(deal.company_start_date?.split('T')[0] || '');
            
            $('#deal_type').val(deal.deal_type);
            $('#priority').val(deal.priority).trigger('change');
            $('#services').val(deal.services).trigger('change');
            $('#is_contact_start_date').prop('checked', deal.is_contact_start_date);
            $('#contact_start_date').toggle(deal.is_contact_start_date);
            $('#is_company_start_date').prop('checked', deal.is_company_start_date);
            $('#company_start_date').toggle(deal.is_company_start_date);
            $('#status').val(deal.status ? '1' : '0');

            $('#manage-form').attr('action', `{{route('admin.deal.update')}}/` + deal.id);
            $('#formContainer').addClass('open');
        }

        /** Create Manage Record */
        $('#manage-form').on('submit', function (e) {
            e.preventDefault();
            var dataId = $('#manage-form').data('id');
            var formData = new FormData(this);
            let table = dataTables[0];
            
            if (!dataId) {
                AjaxRequestPromise(`{{ route("admin.deal.store") }}`, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {
                                id,
                                company,
                                contact,
                                name,
                                deal_stage,
                                amount,
                                close_date,
                                priority,
                                date,
                                status
                            } = Object.fromEntries(
                                Object.entries(response.data).map(([key, value]) => [key, value === null ? '' : value])
                            );

                            const index = table.rows().count() + 1;
                            const columns = `
                                <td class="align-middle text-left text-nowrap"></td>
                                <td class="align-middle text-left text-nowrap">
                                    <a href="{{route('admin.deal.edit', '') }}/${id}" data-bs-toggle="tooltip" data-bs-placement="top" title="${name}">${name}</a>
                                </td>
                                <td class="align-middle text-left text-nowrap">${company ? company.name : 'N/A'}</td>
                                <td class="align-middle text-left text-nowrap">${contact ? contact.name : 'N/A'}</td>
                                <td class="align-middle text-left text-nowrap">${deal_stage}</td>
                                <td class="align-middle text-left text-nowrap">$${amount}</td>
                                <td class="align-middle text-left text-nowrap" data-order="${close_date}">${close_date ? new Date(close_date).toLocaleDateString() : 'N/A'}</td>
                                <td class="align-middle text-left text-nowrap"><span class="badge bg-secondary">${priority ? priority.charAt(0).toUpperCase() + priority.slice(1) : 'N/A'}</span></td>
                                <td class="align-middle text-left text-nowrap">
                                    <span class="badge bg-${status == 1 ? 'success' : 'danger'}">
                                        ${status == 1 ? 'Active' : 'Inactive'}
                                    </span>
                                </td>
                                <td class="align-middle text-left table-actions">
                                    <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            `;
                            table.row.add($('<tr>', {id: `tr-${id}`}).append(columns)).draw(false);
                            $('#manage-form')[0].reset();
                            $('#formContainer').removeClass('open');
                        }
                    })
                    .catch(error => console.error('An error occurred while creating the record.', error));
            } else {
                const url = $(this).attr('action');
                AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {
                                id,
                                company,
                                contact,
                                name,
                                deal_stage_name,
                                amount,
                                close_date,
                                priority,
                                date,
                                status
                            } = Object.fromEntries(
                                Object.entries(response.data).map(([key, value]) => [key, value === null ? '' : value])
                            );

                            const index = table.row($('#tr-' + id)).index();
                            
                            // Update table cells
                            table.cell(index, 1).data(`<a href="{{route('admin.deal.edit', '') }}/${id}" data-bs-toggle="tooltip" data-bs-placement="top" title="${name}">${name}</a>`).draw();
                            table.cell(index, 2).data(company ? company.name : 'N/A').draw();
                            table.cell(index, 3).data(contact ? contact.name : 'N/A').draw();
                            table.cell(index, 4).data(deal_stage_name).draw();
                            table.cell(index, 5).data(`$${amount}`).draw();
                            table.cell(index, 6).data(close_date ? new Date(close_date).toLocaleDateString() : 'N/A').draw();
                            table.cell(index, 7).data(priority ? priority.charAt(0).toUpperCase() + priority.slice(1) : 'N/A').draw();
                            
                            const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`;
                            table.cell(index, 8).data(statusHtml).draw();

                            $('#manage-form')[0].reset();
                            $('#formContainer').removeClass('open');
                        }
                    })
                    .catch(error => console.log(error));
            }
        });

        /** Delete Record */
        $(document).on('click', '.deleteBtn', function () {
            const id = $(this).data('id');
            let table = dataTables[0];
            console.log('Deleting record with ID:', id);
            AjaxDeleteRequestPromise(`{{ route("admin.deal.destroy", "") }}/${id}`, null, 'DELETE', {
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

        // Toggle contact start date field
        $('#is_contact_start_date').on('change', function () {
            $('#contact_start_date').toggle($(this).is(':checked'));
        });

        // Toggle company start date field
        $('#is_company_start_date').on('change', function () {
            $('#company_start_date').toggle($(this).is(':checked'));
        });

        // Initialize searchable selects
        $('.searchable').select2({
            placeholder: "Please select an option",
            allowClear: true
        });
    });
</script>