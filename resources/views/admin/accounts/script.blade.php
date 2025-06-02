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
                order: [[1, 'asc']],
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
                    start: 2,
                    end: 1
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
                url: `{{route('admin.account.edit')}}/` + id,
                type: 'GET',
                success: function (data) {
                    setDataAndShowEdit(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });
        /** Change Password Btn */
        $(document).on('click', '.changePwdBtn', function () {
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
            $('.manage-form').trigger('reset');

            $('#manage-form-2').data('id', id);
            $('#manage-form-2').attr('action', `{{route('admin.account.update.password')}}/` + id);
            $('#formContainerChangePassword').addClass('open');
        });

        var $defaultImage;
        const $imageInput = $('#image'), $imageUrl = $('#image_url'), $imageDisplay = $('#image-display'),
            $imageDiv = $('#image-div');

        const updateImage = (src) => {
            $imageDisplay.attr('src', src || $defaultImage);
            $imageDiv.toggle(!!src)
        };
        $imageInput.on('change', function () {
            const file = this.files[0];
            if (file) {
                updateImage(URL.createObjectURL(file));
                $imageUrl.val(null);
            } else {
                updateImage($imageUrl.val());
            }
        });
        $imageUrl.on('input', function () {
            if (!$imageInput.val()) updateImage($(this).val());
        });
        updateImage();

        function setDataAndShowEdit(data) {
            $('#manage-form').data('id', data.id);

            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#designation').val(data.designation);
            $('#gender').val(data.gender);
            $('#phone_number').val(data.phone_number);
            $('#address').val(data.address);
            $('#status').val(data.status);
            if (data.image) {
                var isValidUrl = data.image.match(/^(https?:\/\/|\/|\.\/)/);
                if (isValidUrl) {
                    $imageUrl.val(data.image);
                    $defaultImage = data.image;
                    updateImage(data.image)
                } else {
                    $imageUrl.val(`{{asset('assets/images/admins/')}}/` + data.image);
                    $defaultImage = `{{asset('assets/images/admins/')}}/` + data.image;
                    updateImage(`{{asset('assets/images/admins/')}}/` + data.image)
                }
                $imageDisplay.attr('alt', data.name);
                $imageDiv.show();
            }
            $('#manage-form').attr('action', `{{route('admin.account.update')}}/` + data.id);
            $('#formContainer').addClass('open')
        }

        /** Manage Record */
        $('#manage-form').on('submit', function (e) {
            e.preventDefault();
            var dataId = $('#manage-form').data('id');
            var formData = new FormData(this);
            if (!dataId) {
                AjaxRequestPromise(`{{ route("admin.account.store") }}`, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {id, image, name, email, designation, status} = response.data;
                            const imageUrl = isValidUrl(image) ? image : (image ? `{{ asset('assets/images/admins/') }}/${image}` : '{{ asset("assets/images/no-image-available.png") }}');
                            const index = table.rows().count() + 1;
                            const columns = `
                                <td class="align-middle text-center text-nowrap"></td>
                                <td class="align-middle text-center text-nowrap">${index}</td>
                                <td class="align-middle text-center text-nowrap">
                                    ${imageUrl ? `<object data="${imageUrl}" class="avatar avatar-sm me-3" title="${name}">
                                        <img src="${imageUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">
                                    </object>`
                                : null}
                                </td>
                                <td class="align-middle text-center text-nowrap">${name}</td>
                                <td class="align-middle text-center text-nowrap">${email}</td>
                                <td class="align-middle text-center text-nowrap">${designation}</td>
                                <td class="align-middle text-center text-nowrap">
                                    <input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? 'checked' : ''} data-bs-toggle="toggle">
                                </td>
                                <td class="align-middle text-center table-actions">
                                    <button type="button" class="btn btn-sm btn-primary changePwdBtn"
                                            data-id="${id}" title="Change Password"><i
                                            class="fas fa-key"></i></button>
                                    <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${id}" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                        `;
                            table.row.add($('<tr>', {id: `tr-${id}`}).append(columns)).draw(false);
                            $('#manage-form')[0].reset();
                            $('#image-display').attr('src', null);
                            // $('#formContainer').removeClass('open')
                        }
                    })
                    .catch(error => console.error('An error occurred while updating the record.',error));
            } else {
                const url = $(this).attr('action');
                AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {id, image, name, email, designation, status} = response.data;
                            const imageUrl = isValidUrl(image) ? image : (image ? `{{ asset('assets/images/admins/') }}/${image}` : `{{ asset("assets/images/no-image-available.png") }}`);
                            const index = table.row($('#tr-' + id)).index();
                            const rowData = table.row(index).data();
                            // Column 2: Image
                            if (rowData[2] !== (imageUrl ? `<object data="${imageUrl}" class="avatar avatar-sm me-3" title="${name}">
                                                <img src="${imageUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">
                                            </object>` : '')) {
                                table.cell(index, 2).data(imageUrl ? `<object data="${imageUrl}" class="avatar avatar-sm me-3" title="${name}">
                                                            <img src="${imageUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">
                                                        </object>` : '').draw();
                            }
                            // Column 3: Name
                            if (rowData[3] !== name) {
                                table.cell(index, 3).data(name).draw();
                            }
                            // Column 4: Email
                            if (rowData[4] !== email) {
                                table.cell(index, 4).data(email).draw();
                            }
                            // Column 5: Designation
                            if (rowData[5] !== designation) {
                                table.cell(index, 5).data(designation).draw();
                            }
                            // Column 6: Status
                            const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`;
                            if (rowData[6] !== statusHtml) {
                                table.cell(index, 6).data(statusHtml).draw();
                            }
                            //
                            // const columns = [
                            //     null,
                            //     index,
                            //     imageUrl ? `<object data="${imageUrl}" class="avatar avatar-sm me-3" title="${name}">
                            //                 <img src="${imageUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">
                            //             </object>` : '',
                            //     name,
                            //     email,
                            //     designation,
                            //     `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`,
                            //     ` <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" title="Edit">
                            //                 <i class="fas fa-edit"></i>
                            //             </button>
                            //             <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${id}" title="Delete">
                            //                 <i class="fas fa-trash"></i>
                            //             </button>`
                            // ];
                            // table.row($('#tr-' + id)).data(columns).draw();
                            $('#manage-form')[0].reset();
                            $('#image-display').attr('src', null);
                            // $('#formContainer').removeClass('open')
                        }
                    })
                    .catch(error => console.log(error));
            }
        });
        /** Manage Passowrd */
        $('#manage-form-2').on('submit', function (e) {
            e.preventDefault();
            var dataId = $(this).data('id');
            var formData = new FormData(this);
            if (dataId) {
                const url = $(this).attr('action');
                AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            $(this)[0].reset();
                        }
                    })
                    .catch(error => console.log(error));
            }
        });

        /** Change Status*/
        $('tbody').on('change', '.change-status', function () {
            const statusCheckbox = $(this);
            const status = +statusCheckbox.is(':checked');
            const rowId = statusCheckbox.data('id');
            AjaxRequestPromise(`{{ route('admin.account.change.status') }}/${rowId}?status=${status}`, null, 'GET', {useToastr: true})
                .then(response => {
                    const rowIndex = table.row($('#tr-' + rowId)).index();
                    const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${rowId}" ${status ? "checked" : ""} data-bs-toggle="toggle">`;
                    table.cell(rowIndex, 6).data(statusHtml).draw();
                })
                .catch(() => {
                    statusCheckbox.prop('checked', !status);
                });
        });
        /** Delete Record */
        $(document).on('click', '.deleteBtn', function () {
            const id = $(this).data('id');
            AjaxDeleteRequestPromise(`{{ route("admin.account.delete", "") }}/${id}`, null, 'DELETE', {
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
    });
</script>

<script>
    $(document).ready(function () {
        $('.generatePassword').click(function () {
            const form = $(this).closest('form');
            const passwordInput = form.find('input[name="password"]').length ? form.find('input[name="password"]') : form.find('input[name="change_password"]');
            if (passwordInput.length) {
                passwordInput.val(generateRandomPassword(12)).trigger('change');
            } else {
                console.error('No password input field found');
            }
        });
    });
</script>
