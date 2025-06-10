<script>
    $(document).ready(function () {

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
        // if ($('#companiesTable').length) {
        //     var table = $('#companiesTable').DataTable({
        //         dom:
        //             "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'>>" +
        //             "<'row'<'col-sm-12 col-md-php6'l><'col-sm-12 col-md-6'f>>" +
        //             "<'row'<'col-sm-12'tr>>" +
        //             "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
        //         buttons: exportButtons,
        //         order: [[0, 'asc']],
        //         responsive: true,
        //         scrollX: true,
        //     });
        // }
        if ($('.initTable').length) {
            $('.initTable').each(function (index) {
                initializeDatatable($(this),index)
            })
        }
        function initializeDatatable(table_div,index){
            var table = table_div.DataTable({
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
                    start: 0,
                },
            });
            table.buttons().container().appendTo(`#right-icon-${index}`);
        }

    {{--    /** Create Record */--}}
    {{--    $('#create-form').on('submit', function (e) {--}}
    {{--        e.preventDefault();--}}
    {{--        AjaxRequestPromise('{{ route("company.store") }}', new FormData(this), 'POST', {useToastr: true})--}}
    {{--            .then(response => {--}}
    {{--                if (response?.data) {--}}
    {{--                    const {id, logo, name, special_key, url, status} = response.data;--}}
    {{--                    $('#create-modal').modal('hide');--}}
    {{--                    const logoUrl = isValidUrl(logo) ? logo : `{{ asset('assets/images/company-logos/') }}/${logo}`;--}}
    {{--                    const columns = [--}}
    {{--                        id,--}}
    {{--                        `<img src="${logoUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">`,--}}
    {{--                        special_key,--}}
    {{--                        name,--}}
    {{--                        url,--}}
    {{--                        `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`,--}}
    {{--                        `<a href="javascript:void(0)" data-id="${id}" class="text-secondary editBtn" title="Edit company"><i class="fas fa-edit"></i></a>&nbsp;<a href="javascript:void(0)" class="text-secondary deleteBtn" data-id="${id}" title="Delete company"><i class="fas fa-trash"></i></a>`--}}
    {{--                    ];--}}
    {{--                    table.row.add($('<tr>', {id: `tr-${id}`}).append(columns.map(col => $('<td>').html(col)))).draw();--}}
    {{--                    $('#create-form')[0].reset();--}}
    {{--                }--}}
    {{--            })--}}
    {{--            .catch(error => console.log(error));--}}
    {{--    });--}}

    {{--    function setDataAndShowEditModel(data) {--}}
    {{--        $('#edit_name').val(data.name);--}}
    {{--        $('#edit_url').val(data.url);--}}
    {{--        $('#edit_email').val(data.email);--}}
    {{--        $('#edit_description').val(data.description);--}}
    {{--        $('#edit_status').val(data.status);--}}
    {{--        if (data.logo) {--}}
    {{--            var isValidUrl = data.logo.match(/^(https?:\/\/|\/|\.\/)/);--}}
    {{--            if (isValidUrl) {--}}
    {{--                $('#company-logo').attr('src', data.logo);--}}
    {{--            } else {--}}
    {{--                $('#company-logo').attr('src', `{{asset('assets/images/company-logos/')}}/` + data.logo);--}}
    {{--            }--}}
    {{--            $('#company-logo').attr('alt', data.name);--}}
    {{--            $('#company-logo').show();--}}
    {{--        }--}}

    {{--        $('#update-form').attr('action', `{{route('company.update')}}/` + data.id);--}}
    {{--        $('#edit-modal').modal('show');--}}
    {{--    }--}}

    {{--    /** Edit */--}}
    {{--    $(document).on('click', '.editBtn', function () {--}}
    {{--        const id = $(this).data('id');--}}
    {{--        if (!id) {--}}
    {{--            Swal.fire({--}}
    {{--                title: 'Error!',--}}
    {{--                text: 'Record not found. Do you want to reload the page?',--}}
    {{--                icon: 'error',--}}
    {{--                showCancelButton: true,--}}
    {{--                confirmButtonText: 'Reload',--}}
    {{--                cancelButtonText: 'Cancel'--}}
    {{--            }).then((result) => {--}}
    {{--                if (result.isConfirmed) {--}}
    {{--                    location.reload();--}}
    {{--                }--}}
    {{--            });--}}
    {{--        }--}}
    {{--        $('#update-form')[0].reset();--}}
    {{--        $.ajax({--}}
    {{--            url: `{{route('company.edit')}}/` + id,--}}
    {{--            type: 'GET',--}}
    {{--            success: function (data) {--}}
    {{--                setDataAndShowEditModel(data);--}}
    {{--            },--}}
    {{--            error: function () {--}}
    {{--                alert('Error fetching company data.');--}}
    {{--            }--}}
    {{--        });--}}
    {{--    });--}}

    {{--    /** Update Record */--}}
    {{--    $('#update-form').on('submit', function (e) {--}}
    {{--        e.preventDefault();--}}
    {{--        const url = $(this).attr('action');--}}
    {{--        AjaxRequestPromise(url, new FormData(this), 'POST', {useToastr: true})--}}
    {{--            .then(response => {--}}
    {{--                if (response?.data) {--}}
    {{--                    const {id, logo, name, special_key, url, status} = response.data;--}}
    {{--                    $('#edit-modal').modal('hide');--}}
    {{--                    const logoUrl = isValidUrl(logo) ? logo : `{{ asset('assets/images/company-logos/') }}/${logo}`;--}}
    {{--                    const columns = [--}}
    {{--                        id,--}}
    {{--                        `<img src="${logoUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">`,--}}
    {{--                        special_key,--}}
    {{--                        name,--}}
    {{--                        url,--}}
    {{--                        `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`,--}}
    {{--                        `<a href="javascript:void(0)" data-id="${id}" class="text-secondary editBtn" title="Edit company"><i class="fas fa-edit"></i></a>&nbsp;<a href="javascript:void(0)" class="text-secondary deleteBtn" data-id="${id}" title="Delete company"><i class="fas fa-trash"></i></a>`--}}
    {{--                    ];--}}
    {{--                    table.row($('#tr-' + id)).data(columns).draw();--}}
    {{--                }--}}
    {{--            })--}}
    {{--            .catch(error => console.error('An error occurred while updating the record.',error));--}}
    {{--    });--}}

    {{--    /** Change Status*/--}}
    {{--    $('.change-status').on('change', function () {--}}
    {{--        AjaxRequestPromise(`{{ route('company.change.status') }}/${$(this).data('id')}?status=${+$(this).is(':checked')}`, null, 'GET', {useToastr: true})--}}
    {{--            .then(response => {--}}
    {{--            })--}}
    {{--            .catch(() => alert('An error occurred'));--}}
    {{--    });--}}
    {{--    /** Delete Record */--}}
    {{--    $(document).on('click', '.deleteBtn', function () {--}}
    {{--        const id = $(this).data('id');--}}
    {{--        AjaxDeleteRequestPromise(`{{ route("company.delete", "") }}/${id}`, null, 'DELETE', {--}}
    {{--            useDeleteSwal: true,--}}
    {{--            useToastr: true,--}}
    {{--        })--}}
    {{--            .then(response => {--}}
    {{--                table.row(`#tr-${id}`).remove().draw();--}}
    {{--            })--}}
    {{--            .catch(error => {--}}
    {{--                Swal.fire('Error!', 'An error occurred while deleting the record.', 'error');--}}
    {{--                console.error('Error deleting record:', error);--}}
    {{--            });--}}
    {{--    });--}}
    {{--    @if (session()->get('edit_company') !== null)--}}
    {{--    const data = @json(session()->get('edit_company'));--}}
    {{--    setDataAndShowEditModel(data);--}}
    {{--    @endif--}}
    {{--    @php session()->forget('edit_company') @endphp--}}
    });
</script>
