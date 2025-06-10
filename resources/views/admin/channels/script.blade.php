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
                order: [[1, 'desc']],
                responsive: false,
                scrollX: true,
                scrollY: ($(window).height() - 200),
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
                    end: 2
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
                url: `{{ route('admin.channels.edit', ':id') }}`.replace(':id', id),
                type: 'GET',
                success: function (data) {
                    setDataAndShowEdit(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });
        function setDataAndShowEdit(data) {
            const channel = data?.channel;
            if (!channel) {
                toastr.error('Data is missing.')
                return false;
            }

            $('#manage-form').data('id', channel.id);

            $('#name').val(channel.name);
            $('#slug').val(channel.slug);
            $('#url').val(channel.url);
            $('#description').val(channel.description);
            $('#meta_title').val(channel.meta_title);
            $('#meta_description').val(channel.meta_description);
            $('#meta_keywords').val(channel.meta_keywords);

            $('#language').val(channel.language).trigger('change');
            $('#timezone').val(channel.timezone).trigger('change');
            $('#status').val(channel.status ? '1' : '0').trigger('change');

            $('#manage-form').attr('action', `{{ route('admin.channels.update', ':id') }}`.replace(':id', channel.id));
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
                AjaxRequestPromise(`{{ route("admin.channels.store") }}`, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {
                                id,
                                name,
                                slug,
                                url,
                                description,
                                language,
                                timezone,
                                status,
                                creator,
                                owner,
                                meta_title,
                                meta_description,
                                meta_keywords,
                                // last_activity_at
                            } = response.data;
                            const index = table.rows().count() + 1;
                            // let last_activity_at_formatted = formatDate2(last_activity_at);
                            const columns = `
                                <td class="align-middle text-center text-nowrap"></td>
                                <td class="align-middle text-center text-nowrap">${index}</td>
                                <td class="align-middle text-center text-nowrap">${name}</td>
                                <td class="align-middle text-center text-nowrap">${slug}</td>
                                <td class="align-middle text-center text-nowrap">${url}</td>
                                <td class="align-middle text-center text-nowrap">
                                    ${response.data.logo ? `<img src="{{asset('assets/images/channel-logos/')}}/${response.data.logo}" style="max-height: 30px;">` : ''}
                                </td>
                                <td class="align-middle text-center text-nowrap">
                                    ${response.data.favicon ? `<img src="{{asset('assets/images/channel-favicons/')}}/${response.data.favicon}" style="max-height: 30px;">` : ''}
                                </td>
                                <td class="align-middle text-center text-nowrap">${description ? strLimit(description, 50) : '---'}</td>
                                <td class="align-middle text-center text-nowrap">${language}</td>
                                <td class="align-middle text-center text-nowrap">${timezone}</td>
                                <td class="align-middle text-center text-nowrap">${meta_title ? strLimit(meta_title, 20) : '---'}</td>
                                <td class="align-middle text-center text-nowrap">${meta_description ? strLimit(meta_description, 30) : '---'}</td>
                                <td class="align-middle text-center text-nowrap">${meta_keywords ? strLimit(meta_keywords, 30) : '---'}</td>
                                // <td class="align-middle text-center text-nowrap">${last_activity_at_formatted}</td>
                                <td class="align-middle text-center text-nowrap">
                                    <input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status ? 'checked' : ''} data-bs-toggle="toggle">
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
                            $('#formContainer').removeClass('open')
                        }
                    })
                    .catch(error => console.error('An error occurred while updating the record.', error));
            } else {
                const url = $(this).attr('action');
                formData.append('_method', 'PUT');
                AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {
                                id,
                                name,
                                slug,
                                url,
                                description,
                                language,
                                timezone,
                                status,
                                creator,
                                owner,
                                meta_title,
                                meta_description,
                                meta_keywords,
                                logo,
                                favicon,
                                // last_activity_at
                            } = response.data;
                            const index = table.row($('#tr-' + id)).index();
                            // let last_activity_at_formatted = formatDate2(last_activity_at);

                            const rowData = table.row(index).data();

                            // Column 2: Name
                            if (decodeHtml(rowData[2]) !== name) {
                                table.cell(index, 2).data(name).draw();
                            }
                            // Column 3: slug
                            if (decodeHtml(rowData[3]) !== slug) {
                                table.cell(index, 3).data(slug).draw();
                            }
                            // Column 4: url
                            if (decodeHtml(rowData[4]) !== url) {
                                table.cell(index, 4).data(url).draw();
                            }
                            // Column 5: logo
                            const logoHtml = logo ? `<img src="{{asset('assets/images/channel-logos/')}}/${logo}" style="max-height: 30px;">` : '';
                            if (decodeHtml(rowData[5]) !== logoHtml) {
                                table.cell(index, 5).data(logoHtml).draw();
                            }
                            // Column 6: logo
                            const favHtml = favicon ? `<img src="{{asset('assets/images/channel-favicons/')}}/${favicon}" style="max-height: 30px;">` : '';
                            if (decodeHtml(rowData[6]) !== favHtml) {
                                table.cell(index, 6).data(favHtml).draw();
                            }
                            // Column 7: description
                            if (decodeHtml(rowData[7]) !== description) {
                                table.cell(index, 7).data(description).draw();
                            }
                            // Column 8: language
                            if (decodeHtml(rowData[8]) !== language) {
                                table.cell(index, 8).data(language).draw();
                            }
                            // Column 9: timezone
                            if (decodeHtml(rowData[9]) !== timezone) {
                                table.cell(index, 9).data(timezone).draw();
                            }
                            // Column 10: meta title
                            if (decodeHtml(rowData[10]) !== meta_title) {
                                table.cell(index, 10).data(meta_title).draw();
                            }
                            // Column 11: meta description
                            if (decodeHtml(rowData[11]) !== meta_description) {
                                table.cell(index, 11).data(meta_description).draw();
                            }
                            // Column 12: meta keywords
                            if (decodeHtml(rowData[12]) !== meta_keywords) {
                                table.cell(index, 12).data(meta_keywords).draw();
                            }
                            // Column 13: Status
                            const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`;
                            if (decodeHtml(rowData[13]) !== statusHtml) {
                                table.cell(index, 13).data(statusHtml).draw();
                            }

                            $('#manage-form')[0].reset();
                            $('#formContainer').removeClass('open')
                        }
                    })
                    .catch(error => console.log(error));
            }
        });
        function strLimit(string, limit = 100, end = '...') {
            if (!string) return '---';
            return string.length > limit ? string.substring(0, limit) + end : string;
        }
        /** Change Status*/
        $('tbody').on('change', '.change-status', function () {
            const statusCheckbox = $(this);
            const status = +statusCheckbox.is(':checked');
            const rowId = statusCheckbox.data('id');
            AjaxRequestPromise(`{{ route('admin.channels.change.status') }}/${rowId}?status=${status}`, null, 'GET', {useToastr: true})
                .then(response => {
                    const rowIndex = table.row($('#tr-' + rowId)).index();
                    const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${rowId}" ${status ? "checked" : ""} data-bs-toggle="toggle">`;
                    table.cell(rowIndex, table.column($('th:contains("STATUS")')).index()).data(statusHtml).draw();
                })
                .catch(() => {
                    statusCheckbox.prop('checked', !status);
                });
        });

        /** Delete Record */
        $(document).on('click', '.deleteBtn', function () {
            const id = $(this).data('id');
            AjaxDeleteRequestPromise(`{{ route("admin.channels.destroy", "") }}/${id}`, null, 'DELETE', {
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

        function formatDate2(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {month: 'long', day: 'numeric', year: 'numeric'});
        }
    });
</script>
