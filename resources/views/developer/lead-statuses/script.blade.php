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
        if ($('#leadStatusTable').length) {
            var table = $('#leadStatusTable').DataTable({
                dom:
                    "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'>>" +
                    "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
                buttons: exportButtons,
                order: [[0, 'desc']],
                responsive: true,
                scrollX: true,
            });
        }
        /** Create Record */
        $('#create-form').on('submit', function (e) {
            e.preventDefault();
            AjaxRequestPromise('{{ route("developer.lead-status.store") }}', new FormData(this), 'POST', {useToastr: true})
                .then(response => {
                    if (response?.data) {
                        const {id, name, color, description, status} = response.data;
                        const newRow = `
                            <tr id="tr-${id}">
                                <td class="align-middle text-center">${id}</td>
                                <td class="align-middle text-center">${name}</td>
                                <td class="align-middle text-center">
                                    <span class="status-color" style="background-color: ${color};"></span>
                                </td>
                                <td class="align-middle text-center">${description}</td>
                                <td class="align-middle text-center text-nowrap">
                                    <input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">
                                </td>
                                <td class="align-middle text-center table-actions">
                                    <a href="javascript:void(0)" data-id="${id}" class="text-secondary editBtn" title="Edit Record">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="text-secondary deleteBtn" data-id="${id}" title="Delete Record">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>`;
                        table.row.add($(newRow)).draw();

                        $('#create-form')[0].reset();
                    }
                })
                .catch(error => console.log(error));
        });

        function setDataAndShowEditModel(data) {
            $('#edit_name').val(data.name);
            $('#edit_color').val(data.color);
            $('#edit_description').val(data.description);
            $('#edit_status').val(data.status);

            $('#update-form').attr('action', `{{route('developer.lead-status.update')}}/` + data.id);
            $('#edit-modal').modal('show');
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
            $('#update-form')[0].reset();
            $.ajax({
                url: `{{route('developer.lead-status.edit')}}/` + id,
                type: 'GET',
                success: function (data) {
                    setDataAndShowEditModel(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });

        /** Update Record */
        $('#update-form').on('submit', function (e) {
            e.preventDefault();
            const url = $(this).attr('action');
            AjaxRequestPromise(url, new FormData(this), 'POST', {useToastr: true})
                .then(response => {
                    if (response?.data) {
                        const {id, name, color, description, status} = response.data;
                        const columns = [
                            id,
                            name,
                            `<span class="status-color" style="background-color: ${color};"></span>`, // Update color on edit
                            description,
                            `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`,
                            `<a href="javascript:void(0)" data-id="${id}" class="text-secondary editBtn" title="Edit Record"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" class="text-secondary deleteBtn" data-id="${id}" title="Delete Record"><i class="fas fa-trash"></i></a>`
                        ];
                        table.row($('#tr-' + id)).data(columns).draw();
                    }
                })
                .catch(error => console.error('An error occurred while updating the record.',error));
        });

        /** Change Status*/
        $('.change-status').on('change', function () {
            AjaxRequestPromise(`{{ route('developer.lead-status.change.status') }}/${$(this).data('id')}?status=${+$(this).is(':checked')}`, null, 'GET', {useToastr: true})
                .then(response => {
                })
                .catch(() => alert('An error occurred'));
        });
        /** Delete Record */
        $(document).on('click', '.deleteBtn', function () {
            const id = $(this).data('id');
            AjaxDeleteRequestPromise(`{{ route("developer.lead-status.delete", "") }}/${id}`, null, 'DELETE', {
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
    });
</script>
