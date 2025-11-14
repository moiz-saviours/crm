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
            const tableId = table_div.attr('id');
            const orderKey = tableId + '_columnOrder';
            const lengthKey = tableId + '_pageLength';
            const visibilityKey = tableId + '_columnVisibility';

            let savedVisibility;
            try {
                const visibility = localStorage.getItem(visibilityKey);
                savedVisibility = visibility ? JSON.parse(visibility) : undefined;
                if (!Array.isArray(savedVisibility)) throw new Error('Invalid column visibility');
            } catch (e) {
                localStorage.removeItem(visibilityKey);
                savedVisibility = undefined;
            }

            let columnOrder;
            try {
                const savedOrder = localStorage.getItem(orderKey);
                columnOrder = savedOrder ? JSON.parse(savedOrder) : undefined;
                if (!Array.isArray(columnOrder)) throw new Error('Invalid column order');
            } catch (e) {
                localStorage.removeItem(orderKey);
                columnOrder = undefined;
            }

            let pageLength = 10; // default
            try {
                const savedLength = localStorage.getItem(lengthKey);
                const parsedLength = parseInt(savedLength);
                if (!isNaN(parsedLength) && parsedLength > 0) pageLength = parsedLength;
                else throw new Error('Invalid page length');
            } catch (e) {
                console.warn('Invalid page length in localStorage, resetting.');
                localStorage.removeItem(lengthKey);
            }

            let datatable = table_div.DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.deal.index') }}",
                    data: function(d) {
                        d.start_date = $('#start_date_filter').val();
                        d.end_date = $('#end_date_filter').val();
                    }
                },
                columns: [
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        visible: savedVisibility ? savedVisibility[0] : true,
                        render: (data, type, row) => `<input type="checkbox" class="row-checkbox" data-id="${row.id}">`
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        visible: savedVisibility ? savedVisibility[1] : true,
                        render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
                    },
                    { data: 'name', name: 'name', visible: savedVisibility ? savedVisibility[2] : true },
                    { data: 'company', name: 'company.name', orderable: false, searchable: false, visible: savedVisibility ? savedVisibility[3] : true },
                    { data: 'contact', name: 'contact.name', orderable: false, searchable: false, visible: savedVisibility ? savedVisibility[4] : true },
                    { data: 'deal_stage', name: 'deal_stage', orderable: false, searchable: false, visible: savedVisibility ? savedVisibility[5] : true },
                    { data: 'amount', name: 'amount', visible: savedVisibility ? savedVisibility[6] : true },
                    { data: 'close_date', name: 'close_date', visible: savedVisibility ? savedVisibility[7] : true },
                    { data: 'priority', name: 'priority', orderable: false, visible: savedVisibility ? savedVisibility[8] : true },
                    { data: 'status', name: 'status', orderable: false, visible: savedVisibility ? savedVisibility[9] : true },
                    { data: 'action', name: 'action', orderable: false, searchable: false, visible: savedVisibility ? savedVisibility[10] : true }
                ],

                dom: 'Blfrtip',
                buttons: [
                    { extend: 'colvis', columns: ':not(:first-child):not(:last-child)' }
                ],
                order: [[7, 'desc']],
                colReorder: { order: columnOrder },
                pageLength: pageLength
            });

            // Save column order safely
            datatable.on('column-reorder', function () {
                const order = datatable.colReorder.order();
                if (order && order.length) localStorage.setItem(orderKey, JSON.stringify(order));
                else localStorage.removeItem(orderKey);
            });

            // Save selected page length safely
            datatable.on('length.dt', function (e, settings, len) {
                if (len && !isNaN(len)) localStorage.setItem(lengthKey, len);
            });

            datatable.on('column-visibility.dt', function (e, settings, column, state) {
                const visibility = datatable.columns().visible().toArray();
                localStorage.setItem(visibilityKey, JSON.stringify(visibility));
            });


            datatable.columns.adjust();
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

        $('#manage-form').on('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const dataId = $('#manage-form').data('id');
            let table = dataTables[0];
            const url = dataId
                ? $(this).attr('action') // Update URL
                : `{{ route("admin.deal.store") }}`; // Create URL

            AjaxRequestPromise(url, formData, 'POST', { useToastr: true })
                .then(response => {
                    if (response?.data) {
                        // Reload the datatable instead of manually updating rows
                        table.ajax.reload(null, false); // false = keep current paging
                        $('#manage-form')[0].reset();
                        $('#formContainer').removeClass('open');
                    }
                })
                .catch(error => console.error('An error occurred while saving the record.', error));
        });


        /** Delete Record */
        $(document).on('click', '.deleteBtn', function () {
            const id = $(this).data('id');
            let table = dataTables[0];

            AjaxDeleteRequestPromise(`{{ route("admin.deal.destroy", "") }}/${id}`, null, 'DELETE', {
                useDeleteSwal: true,
                useToastr: true,
            })
            .then(response => {
                // Reload the datatable instead of removing row manually
                table.ajax.reload(null, false); // false = keep current page
            })
            .catch(error => {
                if (error.isConfirmed === false) {
                    Swal.fire({
                        title: 'Action Canceled',
                        text: error?.message || 'The deletion has been canceled.',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                    console.warn('Record deletion was canceled:', error?.message);
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

        // Select / deselect all row checkboxes
        $(document).on('change', '#select-all', function () {
            const checked = $(this).is(':checked');
            $('.row-checkbox').prop('checked', checked);
        });

        // Keep header checkbox synced when individual row is checked/unchecked
        $(document).on('change', '.row-checkbox', function () {
            const allChecked = $('.row-checkbox').length === $('.row-checkbox:checked').length;
            $('#select-all').prop('checked', allChecked);
        });

    });
</script>