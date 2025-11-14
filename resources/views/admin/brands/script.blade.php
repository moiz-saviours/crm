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
        //
        // /** Initializing Datatable */
        // var table = $('#brandsTable').DataTable({
        //     dom:
        //         "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'>>" +
        //         "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
        //         "<'row'<'col-sm-12'tr>>" +
        //         "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
        //     buttons: [
        //         {
        //             extend: 'copy',
        //             exportOptions: {
        //                 columns: ':visible',
        //                 format: {
        //                     body: function (data, row, column, node) {
        //                         if (column === 1) {
        //                             var img = $(node).find('img');
        //                             return img.attr('src') || '';  // Export the image URL for export
        //                         }
        //                         // For status column (index 5), return 'Active' or 'Inactive'
        //                         if (column === 5) {
        //                             return $(node).find('input:checked').length > 0 ? 'Active' : 'Inactive';
        //                         }
        //                         return data;  // Default: return data for other columns
        //                     }
        //                 }
        //             }
        //         },
        //         {
        //             extend: 'excel',
        //             exportOptions: {
        //                 columns: ':visible',
        //                 format: {
        //                     body: function (data, row, column, node) {
        //                         // Similar rendering logic for Excel
        //                         if (column === 1) {
        //                             var img = $(node).find('img');
        //                             return img.attr('src') || '';  // Export the image URL for export
        //                         }
        //                         if (column === 5) {
        //                             return $(node).find('input:checked').length > 0 ? 'Active' : 'Inactive';
        //                         }
        //                         return data;  // Default: return data for other columns
        //                     }
        //                 }
        //             }
        //         },
        //         {
        //             extend: 'csv',
        //             exportOptions: {
        //                 columns: ':visible',
        //                 format: {
        //                     body: function (data, row, column, node) {
        //                         if (column === 1) {
        //                             var img = $(node).find('img');
        //                             return img.attr('src') || '';  // Export the image URL for export
        //                         }
        //                         if (column === 5) {
        //                             return $(node).find('input:checked').length > 0 ? 'Active' : 'Inactive';
        //                         }
        //                         return data;
        //                     }
        //                 }
        //             }
        //         },
        //         {
        //             extend: 'pdf',
        //             orientation: 'landscape',
        //             exportOptions: {
        //                 columns: ':visible',
        //                 format: {
        //                     body: function (data, row, column, node) {
        //                         if (column === 1) {
        //                             var img = $(node).find('img');
        //                             return img.attr('src') || '';  // Export the image URL for export
        //                         }
        //                         if (column === 5) {
        //                             return $(node).find('input:checked').length > 0 ? 'Active' : 'Inactive';
        //                         }
        //                         return data;
        //                     }
        //                 }
        //             }
        //         },
        //         {
        //             extend: 'print',
        //             exportOptions: {
        //                 columns: ':visible',
        //                 format: {
        //                     body: function (data, row, column, node) {
        //                         if (column === 1) {
        //                             var img = $(node).find('img');
        //                             return img.attr('src') || '';  // Export the image URL for export
        //                         }
        //                         if (column === 5) {
        //                             return $(node).find('input:checked').length > 0 ? 'Active' : 'Inactive';
        //                         }
        //                         return data;
        //                     }
        //                 }
        //             }
        //         }
        //     ],
        //     order: [[1, 'asc']],
        //     responsive: true,
        //     scrollX: true,
        // });

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
        const formContainer = $('#formContainer');
        $('.open-form-btn').click(function () {
            $(this).hasClass('void') ? $(this).attr('title', "You don't have access to create a record.").tooltip({placement: 'bottom'}).tooltip('show') : (formContainer.addClass('open'));
        });

        {{--/** Create Record */--}}
        {{--$('form').on('submit', function (e) {--}}
        {{--    var dataId = $('#manage-form').data('id');--}}
        {{--    if(dataId){--}}
        {{--        return false;--}}
        {{--    }--}}
        {{--    e.preventDefault();--}}
        {{--    AjaxRequestPromise('{{ route("admin.brand.store") }}', new FormData(this), 'POST', {useToastr: true})--}}
        {{--        .then(response => {--}}
        {{--            if (response?.data) {--}}
        {{--                const {id, logo, name, brand_key, url, status} = response.data;--}}
        {{--                $('#create-modal').modal('hide');--}}
        {{--                const logoUrl = isValidUrl(logo) ? logo : `{{ asset('assets/images/brand-logos/') }}/${logo}`;--}}
        {{--                const index = table.rows().count() + 1;--}}
        {{--                const columns = `--}}
        {{--                        <td class="align-middle text-center text-nowrap"></td>--}}
        {{--                        <td class="align-middle text-center text-nowrap">${index}</td>--}}
        {{--                        <td class="align-middle text-center text-nowrap">--}}
        {{--                            <object data="${logoUrl}" class="avatar avatar-sm me-3"  title="${name}">--}}
        {{--                                <img src="${logoUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">--}}
        {{--                            </object>--}}
        {{--                        </td>--}}
        {{--                        <td class="align-middle text-center text-nowrap">${brand_key}</td>--}}
        {{--                        <td class="align-middle text-center text-nowrap">${name}</td>--}}
        {{--                        <td class="align-middle text-center text-nowrap">${url}</td>--}}
        {{--                        <td class="align-middle text-center text-nowrap">--}}
        {{--                            <input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status === 1 ? 'checked' : ''} data-bs-toggle="toggle">--}}
        {{--                        </td>--}}
        {{--                        <td class="align-middle text-center table-actions">--}}
        {{--                            <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" title="Edit">--}}
        {{--                                <i class="fas fa-edit"></i>--}}
        {{--                            </button>--}}
        {{--                            <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${id}" title="Delete">--}}
        {{--                                <i class="fas fa-trash"></i>--}}
        {{--                            </button>--}}
        {{--                        </td>--}}
        {{--                `;--}}
        {{--                table.row.add($('<tr>', {id: `tr-${id}`}).append(columns)).draw(false);--}}
        {{--                $('form')[0].reset();--}}
        {{--                $('#formContainer').removeClass('open')--}}

        {{--            }--}}
        {{--        })--}}
        {{--        .catch(error => console.log(error));--}}
        {{--});--}}

        {{--function setDataAndShowEditModel(data) {--}}
        {{--    $('#manage-form').data('id', data.id);--}}

        {{--    $('#name').val(data.name);--}}
        {{--    $('#url').val(data.url);--}}
        {{--    $('#email').val(data.email);--}}
        {{--    $('#description').val(data.description);--}}
        {{--    $('#status').val(data.status);--}}
        {{--    if (data.logo) {--}}
        {{--        var isValidUrl = data.logo.match(/^(https?:\/\/|\/|\.\/)/);--}}
        {{--        if (isValidUrl) {--}}
        {{--            $('#logo_url').attr('src', data.logo);--}}
        {{--            $('#brand-logo').attr('src', data.logo);--}}
        {{--        } else {--}}
        {{--            $('#logo_url').val(`{{asset('assets/images/brand-logos/')}}/` + data.logo);--}}

        {{--            $('#brand-logo').attr('src', `{{asset('assets/images/brand-logos/')}}/` + data.logo);--}}
        {{--        }--}}
        {{--        $('#logo_url').attr('alt', data.name);--}}
        {{--        $('#brand-logo').attr('alt', data.name);--}}
        {{--        $('#brand-logo').show();--}}
        {{--    }--}}

        {{--    $('form').attr('action', `{{route('admin.brand.update')}}/` + data.id);--}}
        {{--    // $('#edit-modal').modal('show');--}}
        {{--}--}}

        {{--/** Edit */--}}
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
        {{--    $('form')[0].reset();--}}
        {{--    $.ajax({--}}
        {{--        url: `{{route('admin.brand.edit')}}/` + id,--}}
        {{--        type: 'GET',--}}
        {{--        success: function (data) {--}}
        {{--            setDataAndShowEditModel(data);--}}
        {{--        },--}}
        {{--        error: function () {--}}
        {{--            alert('Error fetching brand data.');--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}

        {{--/** Update Record */--}}
        {{--$('form').on('submit', function (e) {--}}
        {{--    var dataId = $('#manage-form').data('id');--}}
        {{--    if(!dataId){--}}
        {{--        return false;--}}
        {{--    }--}}
        {{--    const url = $(this).attr('action');--}}
        {{--    AjaxRequestPromise(url, new FormData(this), 'POST', {useToastr: true})--}}
        {{--        .then(response => {--}}
        {{--            if (response?.data) {--}}
        {{--                const {id, logo, name, brand_key, url, status} = response.data;--}}
        {{--                $('#edit-modal').modal('hide');--}}
        {{--                const logoUrl = isValidUrl(logo) ? logo : `{{ asset('assets/images/brand-logos/') }}/${logo}`;--}}
        {{--                const index = table.row($('#tr-' + id)).index();--}}
        {{--                const columns = [--}}
        {{--                    null,--}}
        {{--                    index,--}}
        {{--                    `<object data="${logoUrl}" class="avatar avatar-sm me-3"  title="${name}">--}}
        {{--                                <img src="${logoUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">--}}
        {{--                            </object>`,--}}
        {{--                    brand_key,--}}
        {{--                    name,--}}
        {{--                    url,--}}
        {{--                    `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`,--}}
        {{--                    ` <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" title="Edit">--}}
        {{--                                <i class="fas fa-edit"></i>--}}
        {{--                            </button>--}}
        {{--                            <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${id}" title="Delete">--}}
        {{--                                <i class="fas fa-trash"></i>--}}
        {{--                            </button>`--}}
        {{--                ];--}}
        {{--                table.row($('#tr-' + id)).data(columns).draw();--}}
        {{--                $('form')[0].reset();--}}
        {{--                $('#formContainer').removeClass('open')--}}
        {{--            }--}}
        {{--        })--}}
        {{--        .catch(error => console.error('An error occurred while updating the record.',error));--}}
        {{--});--}}

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
                url: `{{route('admin.brand.edit')}}/` + id,
                type: 'GET',
                success: function (data) {
                    setDataAndShowEdit(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });

        var $defaultImage;
        const $imageInput = $('#image'), $logoUrl = $('#logo_url'), $imageDisplay = $('#image-display'),
            $imageDiv = $('#image-div');

        const updateImage = (src) => {
            $imageDisplay.attr('src', src || $defaultImage);
            $imageDiv.toggle(!!src)
        };
        $imageInput.on('change', function () {
            const file = this.files[0];
            if (file) {
                updateImage(URL.createObjectURL(file));
                $logoUrl.val(null);
            } else {
                updateImage($logoUrl.val());
            }
        });
        $logoUrl.on('input', function () {
            if (!$imageInput.val()) updateImage($(this).val());
        });
        updateImage();
        function updateParentCheckboxes() {
            $('.multi-hierarchy-tree input[type="checkbox"]').each(function () {
                let $this = $(this);

                if ($this.attr('name') === 'client_accounts[]') {
                    let companyCheckbox = $this.closest('ul').prev('label').find('input[type="checkbox"]');

                    if ($this.closest('ul').find('input[type="checkbox"][name="client_accounts[]"]').length === $this.closest('ul').find('input[type="checkbox"][name="client_accounts[]"]:not(:checked)').length) {
                        companyCheckbox.prop('checked', false);
                    } else {
                        companyCheckbox.prop('checked', true);
                    }
                }

                // Check if it's a client company
                if ($this.attr('name') === 'client_companies[]') {
                    let contactCheckbox = $this.closest('ul').prev('label').find('input[type="checkbox"]');

                    if ($this.closest('ul').find('input[type="checkbox"][name="client_companies[]"]').length === $this.closest('ul').find('input[type="checkbox"][name="client_companies[]"]:not(:checked)').length) {
                        contactCheckbox.prop('checked', false);
                    } else {
                        contactCheckbox.prop('checked', true);
                    }
                }
            });
        }
        function setDataAndShowEdit(data) {

            $('#manage-form').data('id', data.id);

            $('#brand_key').val(data.brand_key);
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#description').val(data.description);
            $('#url').val(data.url);
            $('#status').val(data.status);
            if (data.logo) {
                var isValidUrl = data.logo.match(/^(https?:\/\/|\/|\.\/)/);
                if (isValidUrl) {
                    // $logoUrl.val(data.logo);
                    $defaultImage = data.logo;
                    updateImage(data.logo)
                } else {
                    // $logoUrl.val(`{{asset('assets/images/brand-logos/')}}/` + data.logo);
                    $defaultImage = `{{asset('assets/images/brand-logos/')}}/` + data.logo;
                    updateImage(`{{asset('assets/images/brand-logos/')}}/` + data.logo)
                }
                $imageDisplay.attr('alt', data.name);
                $imageDiv.show();
            }

            data.client_contacts.forEach(function (data) {
                $('#client_contact_' + data.id).prop('checked', true);
            });

            data.client_companies.forEach(function (data) {
                $('#client_company_' + data.id).prop('checked', true);
            });

            data.client_accounts.forEach(function (data) {
                $('#client_account_' + data.id).prop('checked', true);
            });
            updateParentCheckboxes();
            $('#manage-form').attr('action', `{{route('admin.brand.update')}}/` + data.id);
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
            if (!dataId) {
                AjaxRequestPromise(`{{ route("admin.brand.store") }}`, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {id, logo, brand_key, name, email, description, url, status} = response.data;
                            const logoUrl = isValidUrl(logo) ? logo : (logo ? `{{ asset('assets/images/brand-logos/') }}/${logo}` : '{{ asset("assets/images/no-image-available.png") }}');
                            const index = table.rows().count() + 1;
                            const scriptTag = `<script src="{{ asset('assets/js/wl-script.js') }}?token=${response.data.script_token}"><\/script>`;

                            const columns = `
                                <td class="align-middle text-center text-nowrap"></td>
                                <td class="align-middle text-center text-nowrap">${index}</td>
                                <td class="align-middle text-center text-nowrap">
                                    ${logoUrl ? `<object data="${logoUrl}" class="avatar avatar-sm me-3" title="${name}">
                                        <img src="${logoUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">
                                    </object>`
                                : null}
                                </td>
                                <td class="align-middle text-center text-nowrap">${brand_key}</td>
                                <td class="align-middle text-center text-nowrap">${name}</td>
                                <td class="align-middle text-center text-nowrap">${url}</td>
                                <td class="align-middle text-center text-nowrap">
                                    <input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? 'checked' : ''} data-bs-toggle="toggle">
                                </td>
                                <td class="align-middle text-center table-actions">

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
                            $('#formContainer').removeClass('open')
                        }
                    })
                    .catch(error => console.error('An error occurred while updating the record.', error));
            } else {
                const url = $(this).attr('action');
                AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {id, logo, name, url, status} = response.data;
                            const logoUrl = isValidUrl(logo) ? logo : (logo ? `{{ asset('assets/images/brand-logos/') }}/${logo}` : `{{ asset("assets/images/no-image-available.png") }}`);
                            const index = table.row($('#tr-' + id)).index();
                            const rowData = table.row(index).data();
                            // Column 2: Image
                            const imageHtml = logoUrl ? `<object data="${logoUrl}" class="avatar avatar-sm me-3" title="${name}"><img src="${logoUrl}" alt="${name}" class="avatar avatar-sm me-3"  title="${name}"></object>` : '';
                            if (decodeHtml(rowData[2]) !== imageHtml) {
                                table.cell(index, 2).data(logoUrl ? `<object data="${logoUrl}" class="avatar avatar-sm me-3" title="${name}">
                                                            <img src="${logoUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">
                                                        </object>` : '').draw();
                            }
                            // Column 3: Name
                            if (decodeHtml(rowData[4]) !== name) {
                                table.cell(index, 4).data(name).draw();
                            }

                            // Column 5: Url
                            if (decodeHtml(rowData[5]) !== url) {
                                table.cell(index, 5).data(url).draw();
                            }

                            // Column 7: Status
                            const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`;
                            if (decodeHtml(rowData[6]) !== statusHtml) {
                                table.cell(index, 6).data(statusHtml).draw();
                            }
                            $('#manage-form')[0].reset();
                            $('#image-display').attr('src', null);
                            $('#formContainer').removeClass('open')
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
            AjaxRequestPromise(`{{ route('admin.brand.change.status') }}/${rowId}?status=${status}`, null, 'GET', {useToastr: true})
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
        /** Delete Record */
        $(document).on('click', '.deleteBtn', function () {
            const id = $(this).data('id');
            AjaxDeleteRequestPromise(`{{ route("admin.brand.delete", "") }}/${id}`, null, 'DELETE', {
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

        // $(document).on('click', '.copyScriptBtn', function () {
        //     const script = $(this).data('script');
        //
        //     navigator.clipboard.writeText(script).then(function () {
        //         toastr.success("Script copied to clipboard!");
        //     }, function (err) {
        //         toastr.error("Failed to copy script.");
        //     });
        // });
    });
</script>

