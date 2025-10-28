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
            const skipCols = [
                0,
                getColumnIndex(table_div, 'CREATED DATE'),
                getColumnIndex(table_div, 'LAST ACTIVITY'),
                getColumnIndex(table_div, 'STATUS'),
                getColumnIndex(table_div, 'ACTION'),
            ].filter(i => i !== null && i !== undefined).filter((value, index, self) => self.indexOf(value) === index);

            let datatable = table_div.DataTable({
                dom:
                // "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'>>" +
                    "<'row'<'col-sm-12 col-md-1'B><'col-sm-12 col-md-5'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
                buttons: [
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-columns"></i> Columns',
                        className: 'btn btn-secondary btn-sm',
                        postfixButtons: ['colvisRestore'],
                        columns: function (idx, data, node) {
                            const header = $(table_div).find('thead th').eq(idx);
                            const headerText = header.text().trim().toLowerCase();
                            if (
                                header.hasClass('no-col-vis') ||
                                header.hasClass('select-checkbox') ||
                                headerText.includes('action') ||
                                headerText.includes('select')
                            ) {
                                return false;
                            }

                            return true;
                        }
                    },
                    ...exportButtons // keep your existing export buttons
                ],
                order: [[getColumnIndex(table_div, 'CREATED DATE'), 'desc']],
                responsive: false,
                autoWidth: true,
                scrollX: true,
                scrollY: ($(window).height() - 350),
                scrollCollapse: true,
                paging: true,
                pageLength: 100,
                lengthMenu: [[10, 25, 50, 100, -1], ['10 Rows', '25 Rows', '50 Rows', '100 Rows', 'Show All']],
                columnDefs: [
                    {
                        orderable: false,
                        targets: 0,
                        className: 'select-checkbox',
                        render: DataTable.render.select(),
                    },
                    {
                        targets: getColumnIndex(table_div, 'CREATED DATE'),
                        type: 'date',
                        render: function (data, type, row) {
                            if (type === 'sort') {
                                return $(this).data('order') || data;
                            }
                            return data;
                        }
                    },
                    {
                        targets: '_all',
                        render: function (data, type, row, meta) {
                            if (skipCols.includes(meta.col)) return data;
                            if (!data) return '';
                            if (type !== 'display') return data;

                            const maxLength = 15;
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = data;

                            function truncateTextNodes(node) {
                                node.childNodes.forEach(child => {
                                    if (child.nodeType === Node.TEXT_NODE) {
                                        const txt = child.textContent;
                                        if (txt && txt.trim().length > maxLength) {
                                            child.textContent = txt.substring(0, maxLength) + '...';
                                        }
                                    } else if (child.nodeType === Node.ELEMENT_NODE) {
                                        truncateTextNodes(child);
                                    }
                                });
                            }

                            truncateTextNodes(tempDiv);
                            return tempDiv.innerHTML;
                        },

                        createdCell: function (td, cellData, rowData, row, col) {
                            if (skipCols.includes(col) || !cellData) {
                                td.innerHTML = cellData || '';
                                return;
                            }
                            const temp = document.createElement('div');
                            temp.innerHTML = cellData;
                            const fullText = (temp.textContent || temp.innerText || '').trim();
                            const tooltipDiv = document.createElement('div');
                            tooltipDiv.classList.add('truncate-cell');
                            tooltipDiv.innerHTML = td.innerHTML;
                            td.innerHTML = '';
                            td.appendChild(tooltipDiv);
                            if (fullText.length > 15) {
                                tooltipDiv.setAttribute('title', fullText);
                                tooltipDiv.setAttribute('data-bs-toggle', 'tooltip');
                                tooltipDiv.setAttribute('data-bs-placement', 'top');
                            }
                            new bootstrap.Tooltip(tooltipDiv);
                        }
                    },

                    {width: '10%', targets: 0},  // checkbox or icon column
                    {width: '30%', targets: 1},  // NAME
                    {width: '10%', targets: 2},  // BRAND
                    {width: '15%', targets: 3},  // TEAM
                    {width: '7%', targets: 4},  // CREATED DATE
                    {width: '5%', targets: 5},  // LEAD STATUS
                    {width: '6%', targets: 6},  // COUNTRY
                    {width: '5%', targets: 7},  // MESSAGE (usually longer)
                    {width: '5%', targets: 8},  // STATUS
                    {width: '7%', targets: 9},  // ACTION buttons
                ],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
                fixedColumns: {
                    start: 0,
                    end: 1
                },
            });
            datatable.columns.adjust().draw();
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
                url: `{{route('admin.lead.edit')}}/` + id,
                type: 'GET',
                success: function (response) {
                    setDataAndShowEdit(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });

        function setDataAndShowEdit(data) {
            let lead = data?.lead;
            $('#manage-form').data('id', lead.id);

            $('#brand_key').val(lead.brand_key).trigger('change');
            $('#team_key').val(lead.team_key).trigger('change');
            $('#name').val(lead.name)
            $('#email').val(lead.email);
            $('#phone').val(lead.phone);
            $('#lead_status_id').val(lead.lead_status_id).trigger('change');
            $('#note').val(lead.note);
            $('#status').val(lead.status);

            $('#manage-form').attr('action', `{{route('admin.lead.update')}}/` + lead.id);
            $('#formContainer').addClass('open')
        }

        const decodeHtml = (html) => {
            const txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        };

        /** Create Manage Record */
        $('#manage-form').on('submit', function (e) {
            e.preventDefault();
            var dataId = $('#manage-form').data('id');
            var formData = new FormData(this);
            let table = dataTables[0];
            if (!dataId) {
                AjaxRequestPromise(`{{ route("admin.lead.store") }}`, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {
                                id,
                                brand,
                                team,
                                customer_contact,
                                name,
                                country,
                                lead_status,
                                note,
                                created_at,
                                date,
                                status
                            } = Object.fromEntries(
                                Object.entries(response.data).map(([key, value]) => [key, value === null ? '' : value])
                            );

                            const index = table.rows().count() + 1;
                            const converted = lead_status != 'Converted' && !customer_contact;
                            const columns = `
                                <td class="align-middle text-left text-nowrap"></td>
                                <td class="align-middle text-left text-nowrap">${customer_contact ? `<a href="/admin/customer/contact/edit/${customer_contact.id}" data-bs-toggle="tooltip" data-bs-placement="top" title="${customer_contact.name}">${customer_contact.name}</a>` : name}</td>
                                <td class="align-middle text-left text-nowrap">
                                    ${brand ? `<a href="{{route('admin.brand.index')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="${brand.name}">${makeAcronym(brand.name)}</a>` : ''}
                                </td>
                                <td class="align-middle text-left text-nowrap">${team ? `<a href="{{route('admin.team.index')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="${team.name}">${team.name}</a>` : ''}</td>
                                <td class="align-middle text-left text-nowrap" data-order="${created_at}">${date}</td>
                                <td class="align-middle text-left text-nowrap">${lead_status ? lead_status?.name : ""}</td>
                                <td class="align-middle text-left text-nowrap">${country}</td>
                                <td class="align-middle text-left text-nowrap">${note}</td>
                                <td class="align-middle text-left text-nowrap">
                                    <input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? 'checked' : ''} data-bs-toggle="toggle">
                                </td>
                                <td class="align-middle text-left table-actions">
                                    <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success ${converted ? 'convertBtn' : 'disabled'} " ${converted ? `data-id="${id}"` : ''}
.                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Convert to Customer">
                                        <i class="fas fa-user-check"></i>
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
                AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {
                                id,
                                brand,
                                team,
                                customer_contact,
                                name,
                                country,
                                lead_status,
                                note,
                                date,
                                status
                            } = Object.fromEntries(
                                Object.entries(response.data).map(([key, value]) => [key, value === null ? '' : value])
                            );

                            const index = table.row($('#tr-' + id)).index();
                            const rowData = table.row(index).data();

                            // Column 2: Name
                            if (decodeHtml(rowData[1]) !== `${customer_contact ? `<a href="${getEditRoute('{{ route('admin.customer.contact.edit', ':id') }}', customer_contact.id)}" data-bs-toggle="tooltip" data-bs-placement="top" title="${customer_contact.name}">${customer_contact.name}</a>` : name}`) {
                                table.cell(index, 1).data(`${customer_contact ? `<a href="${getEditRoute('{{ route('admin.customer.contact.edit', ':id') }}', customer_contact.id)}" data-bs-toggle="tooltip" data-bs-placement="top" title="${customer_contact.name}">${customer_contact.name}</a>` : name}`).draw();
                            }
                            // Column 3: Brand
                            if (decodeHtml(rowData[2]) !== `${brand ? `<a href="{{route('admin.brand.index')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="${brand.name}">${brand.name}</a>` : ''}`) {
                                table.cell(index, 2).data(`${brand ? `<a href="{{route('admin.brand.index')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="${brand.name}">${makeAcronym(brand.name)}</a>` : ''}`).draw();
                            }

                            // Column 4: Team
                            if (decodeHtml(rowData[3]) !== `${team ? `<a href="{{route('admin.team.index')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="${team.name}">${team.name}</a>` : ''}`) {
                                table.cell(index, 3).data(`${team ? `<a href="{{route('admin.team.index')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="${team.name}">${team.name}</a>` : ''}`).draw();
                            }

                            // Column 5: Created Date
                            if (decodeHtml(rowData[4]) !== date) {
                                table.cell(index, 4).data(date).draw();
                            }

                            // Column 6: Lead Status
                            if (decodeHtml(rowData[5]) !== lead_status.name) {
                                table.cell(index, 5).data(lead_status.name).draw();
                            }

                            // Column 7: Country
                            if (decodeHtml(rowData[6]) !== country) {
                                table.cell(index, 6).data(country).draw();
                            }

                            // Column 8: Note
                            if (decodeHtml(rowData[7]) !== note) {
                                table.cell(index, 7).data(note).draw();
                            }

                            // Column 9: Status
                            const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`;
                            if (decodeHtml(rowData[8]) !== statusHtml) {
                                table.cell(index, 8).data(statusHtml).draw();
                            }
                            // Column 10: Actions - Update Convert Button
                            const actionsCell = table.cell(index, 9);
                            const currentActions = $(actionsCell.node());

                            const convertBtn = currentActions.find('.btn-success');
                            const isConvertible = lead_status.name == 'Converted' && customer_contact;

                            if (convertBtn.length) {
                                if (isConvertible) {
                                    convertBtn.removeClass('convertBtn')
                                        .addClass('disabled')
                                        .removeAttr('data-id')
                                        .prop('disabled', true);
                                } else {
                                    convertBtn.removeClass('disabled')
                                        .addClass('convertBtn')
                                        .attr('data-id', id)
                                        .prop('disabled', false);
                                }

                                table.cell(index, 9).data(currentActions.html()).draw();
                            } else {
                                const converted = lead_status.name != 'Converted' && !customer_contact;
                                const actionsHtml = `
                                    <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success ${converted ? 'convertBtn' : 'disabled'} " ${converted ? `data-id="${id}"` : ''}
                                             data-bs-toggle="tooltip" data-bs-placement="top" title="Convert to Customer">
                                        <i class="fas fa-user-check"></i>
                                    </button>
                                `;
                                table.cell(index, 9).data(actionsHtml).draw();
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
            let table = dataTables[0];
            AjaxRequestPromise(`{{ route('admin.lead.change.status') }}/${rowId}?status=${status}`, null, 'GET', {useToastr: true})
                .then(response => {
                    const rowIndex = table.row($('#tr-' + rowId)).index();
                    const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${rowId}" ${status ? "checked" : ""} data-bs-toggle="toggle">`;
                    table.cell(rowIndex, 8).data(statusHtml).draw();
                })
                .catch(() => {
                    statusCheckbox.prop('checked', !status);
                });
        });
        /** Delete Record */
        $(document).on('click', '.deleteBtn', function () {
            const id = $(this).data('id');
            let table = dataTables[0];
            console.log('Deleting record with ID:', id);
            AjaxDeleteRequestPromise(`{{ route("admin.lead.delete", "") }}/${id}`, null, 'DELETE', {
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

        /** Convert Lead to Customer */
        $(document).on('click', '.convertBtn', function (e) {
            e.preventDefault();

            const $btn = $(this);
            const leadId = $btn.data('id');

            if (!leadId) {
                toastr.error('Invalid lead ID.');
                return;
            }

            const url = `{{ route('admin.lead.convert', '') }}/${leadId}`;

            convertLeadToCustomer(url, $btn);
        });

        function convertLeadToCustomer(url, $btn) {
            $btn.prop('disabled', true).addClass('disabled');
            let table = dataTables[0];
            AjaxRequestPromise(url, null, 'POST', {useToastr: false})
                .then(res => {
                    if (res?.success) {
                        toastr.success(res?.message || 'Lead converted successfully.');
                        const lead = res.data;
                        const customer_contact = lead.customer_contact;
                        const brand = lead.brand;
                        const lead_status = lead.lead_status;
                        $(`#tr-${lead.id} .convertBtn`).removeClass('convertBtn').addClass('disabled').removeAttr('data-id');
                        const index = table.row($('#tr-' + lead.id)).index();
                        const rowData = table.row(index).data();
                        if (decodeHtml(rowData[1]) !== `${customer_contact ? `<a href="${getEditRoute('{{ route('admin.customer.contact.edit', ':id') }}', customer_contact.id)}" data-bs-toggle="tooltip" data-bs-placement="top" title="${customer_contact.name}">${customer_contact.name}</a>` : lead.name}`) {
                            table.cell(index, 1).data(`${customer_contact ? `<a href="${getEditRoute('{{ route('admin.customer.contact.edit', ':id') }}', customer_contact.id)}" data-bs-toggle="tooltip" data-bs-placement="top" title="${customer_contact.name}">${customer_contact.name}</a>` : lead.name}`).draw();
                        }
                        if (decodeHtml(rowData[2]) !== `${brand ? `<a href="{{route('admin.brand.index')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="${brand.name}">${brand.name}</a>` : brand.name}`) {
                            table.cell(index, 2).data(`${brand ? `<a href="{{route('admin.brand.index')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="${brand.name}">${brand.name}</a>` : brand.name}`).draw();
                        }
                        if (decodeHtml(rowData[5]) !== 'Converted') {
                            table.cell(index, 5).data(lead_status.name).draw();
                        }
                    } else {
                        $btn.prop('disabled', false).removeClass('disabled');
                    }
                })
                .catch(err => {
                    $btn.prop('disabled', false).removeClass('disabled');
                });
        }
        function makeAcronym(text) {
            if (!text) return "";
            const words = text.trim().split(/\s+/);
            let acronym = words.map(word => word.charAt(0).toUpperCase()).join('');
            const lastWord = words[words.length - 1];
            if (lastWord.toLowerCase().endsWith('s')) {
                acronym += 's';
            }
            return acronym;
        }
        function getEditRoute(route, id) {
            if (!route || !id) return '#';
            return route.replace(':id', id);
        }

        $('#dateRangePicker').daterangepicker({
            timePicker: true,
            timePicker24Hour: false,
            timePickerIncrement: 1,
            locale: {
                format: 'YYYY-MM-DD h:mm:ss A',
            },
            startDate: moment().startOf('month').startOf('day'),
            endDate: moment().endOf('month').endOf('day'),
            ranges: {
                'Today': [moment().startOf('day'), moment().endOf('day')],
                'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
                'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('day')],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
            }
        });

        $('#teamSelect, #brandSelect').change(function () {
            filterRecords();
        });
        $('#dateRangePicker').on('apply.daterangepicker', function () {
            filterRecords();
        });
        @if(isset($actual_dates['start_date']) && isset($actual_dates['end_date']))
        let actualStart = moment("{{ $actual_dates['start_date'] }}", "YYYY-MM-DD h:mm:ss A");
        let actualEnd = moment("{{ $actual_dates['end_date'] }}", "YYYY-MM-DD h:mm:ss A");
        $('#dateRangePicker').data('daterangepicker').setStartDate(actualStart);
        $('#dateRangePicker').data('daterangepicker').setEndDate(actualEnd);
        @endif
        function filterRecords() {
            const teamKey = $('#teamSelect').val();
            const brandKey = $('#brandSelect').val();
            const dates = $('#dateRangePicker').data('daterangepicker');

            let table = dataTables[0];
            table.clear().draw();

            AjaxRequestPromise(`{{ route("admin.lead.index") }}`, {
                team_key: teamKey,
                brand_key: brandKey,
                start_date: dates.startDate.format('YYYY-MM-DD h:mm:ss A'),
                end_date: dates.endDate.format('YYYY-MM-DD h:mm:ss A'),
            }, 'GET', {useToastr: false})
                .then(response => {
                    if (response && response.success && response.data) {
                        if (response.actual_dates) {
                            const actualStart = moment(response.actual_dates.start_date, 'YYYY-MM-DD h:mm:ss A');
                            const actualEnd = moment(response.actual_dates.end_date, 'YYYY-MM-DD h:mm:ss A');
                            $('#dateRangePicker').data('daterangepicker').setStartDate(actualStart);
                            $('#dateRangePicker').data('daterangepicker').setEndDate(actualEnd);
                            if (response.actual_dates.start_date !== dates.startDate.format('YYYY-MM-DD h:mm:ss A') ||
                                response.actual_dates.end_date !== dates.endDate.format('YYYY-MM-DD h:mm:ss A')) {
                                toastr.info('Date range adjusted to show available records');
                            }
                        }
                        if (response?.data) {
                            response.data.forEach(function (lead, index) {
                                const sanitizedLead = Object.fromEntries(
                                    Object.entries(lead).map(([key, value]) => [key, value === null ? '' : value])
                                );
                                const {
                                    id,
                                    brand,
                                    team,
                                    customer_contact,
                                    name,
                                    country,
                                    lead_status,
                                    note,
                                    date,
                                    created_at,
                                    status
                                } = sanitizedLead;
                                const converted = lead_status != 'Converted' && !customer_contact;
                                const columns = `
                                <td class="align-middle text-left text-nowrap"></td>
                                <td class="align-middle text-left text-nowrap">${customer_contact ? `<a href="/admin/customer/contact/edit/${customer_contact.id}" data-bs-toggle="tooltip" data-bs-placement="top" title="${customer_contact.name}">${customer_contact.name}</a>` : name}</td>
                                <td class="align-middle text-left text-nowrap">
                                    ${brand ? `<a href="{{route('admin.brand.index')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="${brand.name}">${makeAcronym(brand.name)}</a>` : ''}
                                </td>
                                <td class="align-middle text-left text-nowrap">${team ? `<a href="{{route('admin.team.index')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="${team.name}">${team.name}</a>` : ''}</td>
                                <td class="align-middle text-left text-nowrap" data-order="${created_at}">${date}</td>
                                <td class="align-middle text-left text-nowrap">${lead_status ? lead_status?.name : ""}</td>
                                <td class="align-middle text-left text-nowrap">${country}</td>
                                <td class="align-middle text-left text-nowrap">${note}</td>
                                <td class="align-middle text-left text-nowrap">
                                    <input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? 'checked' : ''} data-bs-toggle="toggle">
                                </td>
                                <td class="align-middle text-left table-actions">
                                    <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success ${converted ? 'convertBtn' : 'disabled'} " ${converted ? `data-id="${id}"` : ''}
.                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Convert to Customer">
                                        <i class="fas fa-user-check"></i>
                                    </button>
                                </td>
                                `;
                                table.row.add($('<tr>', {id: `tr-${id}`}).append(columns)).draw(false);
                            })
                        }
                    }
                })

                .catch(error => console.error('An error occurred while updating the record.', error))
        }

        $('#dateRangePicker').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(
                picker.startDate.format('YYYY-MM-DD h:mm:ss A') + ' - ' +
                picker.endDate.format('YYYY-MM-DD h:mm:ss A')
            );
        });
    });
</script>
