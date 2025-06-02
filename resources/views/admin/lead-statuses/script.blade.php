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
        //'copy', 'excel', 'csv', 'pdf', 'print'
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
    const formContainer = $('#formContainer');
    $('.open-form-btn').click(function () {
        $(this).hasClass('void') ? $(this).attr('title', "You don't have access to create a record.").tooltip({placement: 'bottom'}).tooltip('show') : (formContainer.addClass('open'));
    });
        /** Create Record */
        {{--$('#manage-form').on('submit', function (e){--}}
        {{--    var dataId = $('#manage-form').data('id');--}}
        {{--    if(dataId){--}}
        {{--        return false;--}}
        {{--    }--}}
        {{--    e.preventDefault();--}}
        {{--    AjaxRequestPromise('{{ route("admin.lead-status.store") }}', new FormData(this), 'POST', {useToastr: true})--}}
        {{--        .then(response => {--}}
        {{--            if (response?.data) {--}}
        {{--                const {id, name, color, description, status} = response.data;--}}
        {{--                const index = table.rows().count() + 1;--}}
        {{--                const columns = `--}}
        {{--                        <td class="align-middle text-center"></td>--}}
        {{--                        <td class="align-middle text-center">${index}</td>--}}
        {{--                        <td class="align-middle text-center">${name}</td>--}}
        {{--                        <td class="align-middle text-center">--}}
        {{--                            <span class="status-color" style="background-color: ${color};"></span>--}}
        {{--                        </td>--}}
        {{--                        <td class="align-middle text-center">${description}</td>--}}
        {{--                        <td class="align-middle text-center text-nowrap">--}}
        {{--                            <input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">--}}
        {{--                        </td>--}}
        {{--                        <td class="align-middle text-center table-actions">--}}
        {{--                            <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" title="Edit">--}}
        {{--                                <i class="fas fa-edit"></i>--}}
        {{--                            </button>--}}
        {{--                            <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${id}" title="Delete">--}}
        {{--                                <i class="fas fa-trash"></i>--}}
        {{--                            </button>--}}
        {{--                        </td>--}}
        {{--                    `;--}}
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
        {{--    $('#color').val(data.color);--}}
        {{--    $('#description').val(data.description);--}}
        {{--    $('#status').val(data.status);--}}

        {{--    $('form').attr('action', `{{route('admin.lead-status.update')}}/` + data.id);--}}
        {{--    $('#formContainer').addClass('open')--}}
        {{--    // $('#edit-modal').modal('show');--}}
        {{--}--}}

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
        {{--    $('form')[0].reset();--}}

        {{--    $.ajax({--}}
        {{--        url: `{{route('admin.lead-status.edit')}}/` + id,--}}
        {{--        type: 'GET',--}}
        {{--        success: function (data) {--}}
        {{--            setDataAndShowEditModel(data);--}}
        {{--        },--}}
        {{--        error: function () {--}}
        {{--            console.log(jqXHR, textStatus, errorThrown);--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}

        /** Update Record */

        // $('form').on('submit', function (e) {
        //     var dataId = $('#manage-form').data('id');
        //     if(!dataId){
        //         return false;
        //     }
        //     const url = $(this).attr('action');
        //     AjaxRequestPromise(url, new FormData(this), 'POST', {useToastr: true})
        //         .then(response => {
        //             if (response?.data) {
        //                 const {id, name, color, description, status} = response.data;
        //                 const index = table.row($('#tr-' + id)).index();
        //                 const columns = [
        //                     null,
        //                     index,
        //                     name,
        //                     `<span class="status-color" style="background-color: ${color};"></span>`, // Update color on edit
        //                     description,
        //                     `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`,
        //                     ` <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" title="Edit">
        //                                 <i class="fas fa-edit"></i>
        //                             </button>
        //                             <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${id}" title="Delete">
        //                                 <i class="fas fa-trash"></i>
        //                             </button>`
        //                 ];
        //                 table.row($('#tr-' + id)).data(columns).draw();
        //                 $('form')[0].reset();
        //                 $('#formContainer').removeClass('open')
        //             }
        //         })
        //         .catch(error => console.error('An error occurred while updating the record.',error));
        // });

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
                url: `{{route('admin.lead-status.edit')}}/` + id,
                type: 'GET',
                success: function (data) {
                    setDataAndShowEdit(data);
                },
                error: function () {
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });

        const decodeHtml = (html) => {
            const txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        };

        function setDataAndShowEdit(data) {
            $('#manage-form').data('id', data.id);

            $('#name').val(data.name);
            $('#color').val(data.color);
            $('#description').val(data.description);
            $('#status').val(data.status);

            $('#manage-form').attr('action', `{{route('admin.lead-status.update')}}/` + data.id);
            $('#formContainer').addClass('open')
        }

        {{--$('#manage-form').on('submit', function (e) {--}}
        {{--    e.preventDefault();--}}
        {{--    var dataId = $('#manage-form').data('id');--}}
        {{--    var formData = new FormData(this);--}}
        {{--    if (!dataId) {--}}
        {{--        AjaxRequestPromise(`{{ route("admin.lead-status.store") }}`, formData, 'POST', {useToastr: true})--}}
        {{--            .then(response => {--}}
        {{--                if (response?.data) {--}}
        {{--                    const {id, name, color, description, status} = response.data;--}}
        {{--                    const index = table.rows().count() + 1;--}}
        {{--                    const columns = `--}}
        {{--                        <td class="align-middle text-center text-nowrap"></td>--}}
        {{--                        <td class="align-middle text-center text-nowrap">${index}</td>--}}

        {{--                        <td class="align-middle text-center text-nowrap">${name}</td>--}}
        {{--                        <td class="align-middle text-center">--}}
        {{--                            <span class="status-color" style="background-color: ${color};"></span>--}}
        {{--                                            </td>--}}
        {{--                        <td class="align-middle text-center text-nowrap">${description}</td>--}}
        {{--                        <td class="align-middle text-center text-nowrap">--}}
        {{--                            <input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? 'checked' : ''} data-bs-toggle="toggle">--}}
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
        {{--                    table.row.add($('<tr>', {id: `tr-${id}`}).append(columns)).draw();--}}
        {{--                    $('#manage-form')[0].reset();--}}
        {{--                    $('#formContainer').removeClass('open')--}}
        {{--                }--}}
        {{--            })--}}
        {{--            .catch(error => console.error('An error occurred while updating the record.',error));--}}
        {{--    } else {--}}
        {{--        const url = $(this).attr('action');--}}
        {{--        AjaxRequestPromise(url, formData, 'POST', {useToastr: true})--}}
        {{--            .then(response => {--}}
        {{--                if (response?.data) {--}}
        {{--                    const {id, name, color, description, status} = response.data;--}}
        {{--                    const index = table.row($('#tr-' + id)).index();--}}
        {{--                    const rowData = table.row(index).data();--}}
        {{--                    // Column 2: name--}}
        {{--                    if (decodeHtml(rowData[2]) !== name) {--}}
        {{--                        table.cell(index, 2).data(name).draw();--}}
        {{--                    }--}}
        {{--                    // Column 3: Name--}}
        {{--                    if (decodeHtml(rowData[3]) !== color) {--}}
        {{--                        const colorHtml = `<span class="status-color" style="background-color: ${color};"></span>`;--}}
        {{--                        table.cell(index, 3).data(colorHtml).draw();--}}
        {{--                    }--}}
        {{--                    // Column 4: description--}}
        {{--                    if (decodeHtml(rowData[4]) !== description) {--}}
        {{--                        table.cell(index, 4).data(description).draw();--}}
        {{--                    }--}}

        {{--                    // Column 5: Status--}}
        {{--                    const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`;--}}
        {{--                    if (decodeHtml(rowData[5]) !== statusHtml) {--}}
        {{--                        table.cell(index, 5).data(statusHtml).draw();--}}
        {{--                    }--}}
        {{--                    $('#manage-form')[0].reset();--}}
        {{--                    $('#formContainer').removeClass('open')--}}
        {{--                }--}}
        {{--            })--}}
        {{--            .catch(error => console.log(error));--}}
        {{--    }--}}
        {{--});--}}
        $('#manage-form').on('submit', function (e) {
            e.preventDefault();
            var dataId = $('#manage-form').data('id');
            var formData = new FormData(this);
            if (!dataId) {
                AjaxRequestPromise(`{{ route("admin.lead-status.store") }}`, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {id, name, color, description, status} = response.data;
                            const index = table.rows().count() + 1;
                            const columns = `
                        <td class="align-middle text-center text-nowrap"></td>
                        <td class="align-middle text-center text-nowrap">${index}</td>

                        <td class="align-middle text-center text-nowrap">${name}</td>
                        <td class="align-middle text-center">
                            <span class="status-color" style="background-color: ${color};"></span>
                        </td>
                        <td class="align-middle text-center text-nowrap">${description}</td>
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

                            $('#formContainer').removeClass('open');
                        }
                    })
                    .catch(error => console.error('An error occurred while updating the record.',error));
            } else {
                const url = $(this).attr('action');
                AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {id, name, color, description, status} = response.data;
                            const index = table.row($('#tr-' + id)).index();
                            const rowData = table.row(index).data();
                            // Column 2: name
                            if (decodeHtml(rowData[2]) !== name) {
                                table.cell(index, 2).data(name).draw(false);
                            }
                            // Column 3: Color
                            if (decodeHtml(rowData[3]) !== color) {
                                const colorHtml = `<span class="status-color" style="background-color: ${color};"></span>`;
                                table.cell(index, 3).data(colorHtml).draw();
                            }
                            // Column 4: description
                            if (decodeHtml(rowData[4]) !== description) {
                                table.cell(index, 4).data(description).draw();
                            }

                            // Column 5: Status
                            const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`;
                            if (decodeHtml(rowData[5]) !== statusHtml) {
                                table.cell(index, 5).data(statusHtml).draw();
                            }
                            $('#manage-form')[0].reset();
                            $('#manage-form').data('id', null);
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
            AjaxRequestPromise(`{{ route('admin.lead-status.change.status') }}/${rowId}?status=${status}`, null, 'GET', {useToastr: true})
                .then(response => {
                    const rowIndex = table.row($('#tr-' + rowId)).index();
                    const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${rowId}" ${status ? "checked" : ""} data-bs-toggle="toggle">`;
                    table.cell(rowIndex, 5).data(statusHtml).draw();
                })
                .catch(() => {
                    statusCheckbox.prop('checked', !status);
                });
        });
        /** Delete Record */
        $(document).on('click', '.deleteBtn', function () {
            const id = $(this).data('id');
            AjaxDeleteRequestPromise(`{{ route("admin.lead-status.delete", "") }}/${id}`, null, 'DELETE', {
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
