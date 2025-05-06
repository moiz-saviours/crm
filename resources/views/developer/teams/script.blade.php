<script>
    $(document).ready(function () {

        function decodeHtmlEntities(str) {
            return str ? $('<div>').html(str).text() : str;
        }

        const formatBody = (type) => (data, row, column, node) => {
            if (type !== 'print' && ($(node).find('object').length > 0 || $(node).find('img').length > 0)) {
                return $(node).find('object').attr('data') || $(node).find('object img').attr('src') || $(node).find('img').attr('src') || '';
            }
            if ($(node).find('.status-toggle').length > 0) {
                return $(node).find('.status-toggle:checked').length > 0 ? 'Active' : 'Inactive';
            }

            return decodeHtmlEntities(data);
        };

        const exportButtons = ['copy', 'excel', 'csv', 'pdf', 'print'].map(type => ({
            extend: type,
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
        if ($('#teamsTable').length) {
            var table = $('#teamsTable').DataTable({
                dom:
                    "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'>>" +
                    "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
                buttons: exportButtons,
                order: [[0, 'asc']],
                responsive: true,
                scrollX: true,
            });
        }

        /** Change Status*/
        $('.change-status').on('change', function () {
            AjaxRequestPromise(`{{ route('developer.team.change.status') }}/${$(this).data('id')}?status=${+$(this).is(':checked')}`, null, 'GET', {useToastr: true})
                .then(response => {
                })
                .catch(() => alert('An error occurred'));
        });
        /** Delete Record */
        $(document).on('click', '.deleteBtn', function () {
            const id = $(this).data('id');
            AjaxDeleteRequestPromise(`{{ route("developer.team.delete", "") }}/${id}`, null, 'DELETE', {
                useDeleteSwal: true,
                useToastr: true,
            })
                .then(response => {
                    table.row(`#tr-${id}`).remove().draw();
                })
                .catch(error => {
                    Swal.fire('Error!', 'An error occurred while deleting the record.', 'error');
                    console.error('Error deleting record:', error);
                });
        });

        $('#select-all-brands').change(function () {
            const isChecked = this.checked;
            $('.brand-checkbox').prop('checked', isChecked);
            $('#select-all-label').text(isChecked ? 'Unselect All' : 'Select All');
        });

        $('.brand-checkbox').change(function () {
            if ($('.brand-checkbox:checked').length === $('.brand-checkbox').length) {
                $('#select-all-brands').prop('checked', true);
                $('#select-all-label').text('Unselect All');
            } else {
                $('#select-all-brands').prop('checked', false);
                $('#select-all-label').text('Select All');
            }
        });

        $('.select-user-checkbox').each(function() {
            var checkbox = $(this);
            checkbox.siblings('.checkmark-overlay').toggle(checkbox.is(':checked'));
        });

        $('.select-user-checkbox').on('change', function() {
            $(this).siblings('.checkmark-overlay').toggle($(this).is(':checked'));
        });

        $('.user-image').on('click', function() {
            const checkbox = $(this).closest('.image-checkbox-container').find('.select-user-checkbox');
            checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
        });

    });
</script>
