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
                initializeDatatable($(this),index)
            })
        }
        var table;
        function initializeDatatable(table_div,index){
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
                scrollY:  ($(window).height() - 350),
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
                url: `{{route('user.client.company.edit')}}/` + id,
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

        function setDataAndShowEdit(data) {
            let client_company = data?.client_company;
            $('#manage-form').data('id', client_company.id);

            $('#c_contact_key').val(client_company.c_contact_key);
            $('#name').val(client_company.name);
            $('#email').val(client_company.email);
            $('#url').val(client_company.url);
            $('#description').val(client_company.description);
            $('#status').val(client_company.status);
            if (client_company.logo) {
                var isValidUrl = client_company.logo.match(/^(https?:\/\/|\/|\.\/)/);
                if (isValidUrl) {
                    $logoUrl.val(client_company.logo);
                    $defaultImage = client_company.logo;
                    updateImage(client_company.logo)
                } else {
                    $logoUrl.val(`{{asset('assets/images/clients/companies/logos/')}}/` + client_company.logo);
                    $defaultImage = `{{asset('assets/images/clients/companies/logos/')}}/` + client_company.logo;
                    updateImage(`{{asset('assets/images/clients/companies/logos/')}}/` + client_company.logo)
                }
                $imageDisplay.attr('alt', client_company.name);
                $imageDiv.show();
            }
            $('#manage-form').attr('action', `{{route('user.client.company.update')}}/` + client_company.id);
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
                AjaxRequestPromise(`{{ route("user.client.company.store") }}`, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {id,client_contact, logo, name,email,url,description,status} = response.data;
                            const logoUrl = isValidUrl(logo) ? logo : (logo ? `{{ asset('assets/images/clients/companies/logos') }}/${logo}` : '{{ asset("assets/images/no-image-available.png") }}');
                            const index = table.rows().count() + 1;
                            const columns = `
                                <td class="align-middle text-center text-nowrap"></td>
                                <td class="align-middle text-center text-nowrap">${index}</td>
                                <td class="align-middle text-center text-nowrap">${client_contact?.name}</td>
                                <td class="align-middle text-center text-nowrap">
                                    ${logoUrl ? `<object data="${logoUrl}" class="avatar avatar-sm me-3" title="${name}">
                                        <img src="${logoUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">
                                    </object>`
                                : null}
                                </td>
                                <td class="align-middle text-center text-nowrap">${name}</td>
                                <td class="align-middle text-center text-nowrap">${email}</td>
                                <td class="align-middle text-center text-nowrap">${url}</td>
                                <td class="align-middle text-center text-nowrap">${description??""}</td>
                                <td class="align-middle text-center text-nowrap">
                                    <input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? 'checked' : ''} data-bs-toggle="toggle">
                                </td>
                                <td class="align-middle text-center table-actions">
                                    <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                        `;
                            table.row.add($('<tr>', {id: `tr-${id}`}).append(columns)).draw(false);
                            $('#manage-form')[0].reset();
                            $('#image-display').attr('src', null);
                            $('#formContainer').removeClass('open')
                        }
                    })
                    .catch(error => console.error('An error occurred while updating the record.',error));
            } else {
                const url = $(this).attr('action');
                AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {id,client_contact, logo, name,email,url,description,status} = response.data;
                            const logoUrl = isValidUrl(logo) ? logo : (logo ? `{{ asset('assets/images/clients/companies/logos') }}/${logo}` : `{{ asset("assets/images/no-image-available.png") }}`);
                            const index = table.row($('#tr-' + id)).index();
                            const rowData = table.row(index).data();
                            // Column 2: Contact Name
                            if (decodeHtml(rowData[2]) !== client_contact?.name) {
                                table.cell(index, 2).data(client_contact?.name).draw();
                            }
                            // Column 3: Image
                            const imageHtml = logoUrl ? `<object data="${logoUrl}" class="avatar avatar-sm me-3" title="${name}"><img src="${logoUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}"></object>` : '';
                            if (decodeHtml(rowData[3]) !== imageHtml) {
                                table.cell(index, 3).data(logoUrl ? `<object data="${logoUrl}" class="avatar avatar-sm me-3" title="${name}">
                                                            <img src="${logoUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">
                                                        </object>` : '').draw();
                            }
                            // Column 4: Name
                            if (decodeHtml(rowData[4]) !== name) {
                                table.cell(index, 4).data(name).draw();
                            }

                            // Column 5: Email
                            if (decodeHtml(rowData[5]) !== email) {
                                table.cell(index, 5).data(email).draw();
                            }

                            // Column 6: URL
                            if (decodeHtml(rowData[6]) !== url) {
                                table.cell(index, 6).data(url).draw();
                            }

                            // Column 7: Description
                            if (decodeHtml(rowData[7]) !== description) {
                                table.cell(index, 7).data(description).draw();
                            }

                            // Column 8: Status
                            const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`;
                            if (decodeHtml(rowData[8]) !== statusHtml) {
                                table.cell(index, 8).data(statusHtml).draw();
                            }
                            $('#manage-form')[0].reset();
                            $('#image-display').attr('src', null);
                            $('#formContainer').removeClass('open');
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
            AjaxRequestPromise(`{{ route('user.client.company.change.status') }}/${rowId}?status=${status}`, null, 'GET', {useToastr: true})
                .then(response => {
                    const rowIndex = table.row($('#tr-' + rowId)).index();
                    const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${rowId}" ${status ? "checked" : ""} data-bs-toggle="toggle">`;
                    table.cell(rowIndex, 8).data(statusHtml).draw();
                })
                .catch(() => {
                    statusCheckbox.prop('checked', !status);
                });
        });
    });
</script>

