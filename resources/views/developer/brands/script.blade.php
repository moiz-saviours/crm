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

        /** Initializing Datatable */
        var table = $('#brandsTable').DataTable({
            dom:
                "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'>>" +
                "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
            buttons: [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function (data, row, column, node) {
                                if (column === 1) {
                                    var img = $(node).find('img');
                                    return img.attr('src') || '';  // Export the image URL for export
                                }
                                // For status column (index 5), return 'Active' or 'Inactive'
                                if (column === 5) {
                                    return $(node).find('input:checked').length > 0 ? 'Active' : 'Inactive';
                                }
                                return data;  // Default: return data for other columns
                            }
                        }
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function (data, row, column, node) {
                                // Similar rendering logic for Excel
                                if (column === 1) {
                                    var img = $(node).find('img');
                                    return img.attr('src') || '';  // Export the image URL for export
                                }
                                if (column === 5) {
                                    return $(node).find('input:checked').length > 0 ? 'Active' : 'Inactive';
                                }
                                return data;  // Default: return data for other columns
                            }
                        }
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function (data, row, column, node) {
                                if (column === 1) {
                                    var img = $(node).find('img');
                                    return img.attr('src') || '';  // Export the image URL for export
                                }
                                if (column === 5) {
                                    return $(node).find('input:checked').length > 0 ? 'Active' : 'Inactive';
                                }
                                return data;
                            }
                        }
                    }
                },
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function (data, row, column, node) {
                                if (column === 1) {
                                    var img = $(node).find('img');
                                    return img.attr('src') || '';  // Export the image URL for export
                                }
                                if (column === 5) {
                                    return $(node).find('input:checked').length > 0 ? 'Active' : 'Inactive';
                                }
                                return data;
                            }
                        }
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function (data, row, column, node) {
                                if (column === 1) {
                                    var img = $(node).find('img');
                                    return img.attr('src') || '';  // Export the image URL for export
                                }
                                if (column === 5) {
                                    return $(node).find('input:checked').length > 0 ? 'Active' : 'Inactive';
                                }
                                return data;
                            }
                        }
                    }
                }
            ],
            order: [[1, 'asc']],
            responsive: true,
            scrollX: true,
        });

        /** Create Record */
        $('#create-form').on('submit', function (e) {
            e.preventDefault();
            AjaxRequestPromise('{{ route("developer.brand.store") }}', new FormData(this), 'POST', {useToastr: true})
                .then(response => {
                    if (response?.data) {
                        const {id, logo, name, brand_key, url, status} = response.data;
                        $('#create-modal').modal('hide');
                        const logoUrl = isValidUrl(logo) ? logo : `{{ asset('assets/images/brand-logos/') }}/${logo}`;
                        const columns = [
                            id,
                            `<img src="${logoUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">`,
                            brand_key,
                            name,
                            url,
                            `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`,
                            `<a href="javascript:void(0)" data-id="${id}" class="text-secondary editBtn" title="Edit Brand"><i class="fas fa-edit"></i></a>&nbsp;<a href="javascript:void(0)" class="text-secondary deleteBtn" data-id="${id}" title="Delete Brand"><i class="fas fa-trash"></i></a>`
                        ];
                        table.row.add($('<tr>', {id: `tr-${id}`}).append(columns.map(col => $('<td>').html(col)))).draw();
                        $('#create-form')[0].reset();
                    }
                })
                .catch(error => console.log(error));
        });

        function setDataAndShowEditModel(data) {
            $('#edit_name').val(data.name);
            $('#edit_url').val(data.url);
            $('#edit_email').val(data.email);
            $('#edit_description').val(data.description);
            $('#edit_status').val(data.status);
            if (data.logo) {
                var isValidUrl = data.logo.match(/^(https?:\/\/|\/|\.\/)/);
                if (isValidUrl) {
                    $('#brand-logo').attr('src', data.logo);
                } else {
                    $('#brand-logo').attr('src', `{{asset('assets/images/brand-logos/')}}/` + data.logo);
                }
                $('#brand-logo').attr('alt', data.name);
                $('#brand-logo').show();
            }

            $('#update-form').attr('action', `{{route('developer.brand.update')}}/` + data.id);
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
                url: `{{route('developer.brand.edit')}}/` + id,
                type: 'GET',
                success: function (data) {
                    setDataAndShowEditModel(data);
                },
                error: function () {
                    alert('Error fetching brand data.');
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
                        const {id, logo, name, brand_key, url, status} = response.data;
                        $('#edit-modal').modal('hide');
                        const logoUrl = isValidUrl(logo) ? logo : `{{ asset('assets/images/brand-logos/') }}/${logo}`;
                        const columns = [
                            id,
                            `<img src="${logoUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">`,
                            brand_key,
                            name,
                            url,
                            `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`,
                            `<a href="javascript:void(0)" data-id="${id}" class="text-secondary editBtn" title="Edit Brand"><i class="fas fa-edit"></i></a>&nbsp;<a href="javascript:void(0)" class="text-secondary deleteBtn" data-id="${id}" title="Delete Brand"><i class="fas fa-trash"></i></a>`
                        ];
                        table.row($('#tr-' + id)).data(columns).draw();
                    }
                })
                .catch(error => console.error('An error occurred while updating the record.',error));
        });

        /** Change Status*/
        $('.change-status').on('change', function () {
            AjaxRequestPromise(`{{ route('developer.brand.change.status') }}/${$(this).data('id')}?status=${+$(this).is(':checked')}`, null, 'GET', {useToastr: true})
                .then(response => {
                })
                .catch(() => alert('An error occurred'));
        });
        /** Delete Record */
        $(document).on('click', '.deleteBtn', function () {
            const id = $(this).data('id');
            AjaxDeleteRequestPromise(`{{ route("developer.brand.delete", "") }}/${id}`, null, 'DELETE', {
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
        @if (session()->get('edit_brand') !== null)
        const data = @json(session()->get('edit_brand'));
        setDataAndShowEditModel(data);
        @endif
        @php session()->forget('edit_brand') @endphp
    });
</script>
