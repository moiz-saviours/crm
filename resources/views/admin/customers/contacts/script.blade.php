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
                order: [[getColumnIndex(table_div, 'LAST ACTIVITY'), 'asc']],
                responsive: false,
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
                        targets: getColumnIndex(table_div, 'LAST ACTIVITY'),
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
                            if ([0, 7, 8, 9, 10].includes(meta.col)) return data;
                            if (!data) return '';

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
                            if ([0, 7, 8, 9,10].includes(col)) {
                                td.removeAttribute('title');
                                return;
                            }

                            if (!cellData) {
                                td.removeAttribute('title');
                                return;
                            }
                            const temp = document.createElement('div');
                            temp.innerHTML = cellData;
                            const fullText = (temp.textContent || temp.innerText || '').trim();
                            if (fullText.length > 15) {
                                td.setAttribute('title', fullText);
                            } else {
                                td.removeAttribute('title');
                            }
                        }
                    },
                    {width: '6%', targets: 0},  // checkbox or icon column
                    {width: '15%', targets: 1},  // NAME
                    {width: '11%', targets: 2},  // BRAND
                    {width: '11%', targets: 3},  // TEAM
                    {width: '13%', targets: 4},  // EMAIL
                    {width: '8%', targets: 5},  // PHONE
                    {width: '9%', targets: 6},  // CONTACT OWNER
                    {width: '8%', targets: 7},  // LAST ACTIVITY
                    {width: '8%', targets: 8},  // CREATED AT
                    {width: '6%', targets: 9},  // STATUS
                    {width: '5%', targets: 10},  // ACTION buttons
                ],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
                fixedColumns: {
                    start: 0,
                    end: 0
                },
            });
            table.columns.adjust().draw();
            table.buttons().container().appendTo(`#right-icon-${index}`);
        }
        $(function () {
            $('[data-bs-toggle="tooltip"], [title]').tooltip();
        });

        function getColumnIndex(table, headerText) {
            const headers = table.find('thead th');
            for (let i = 0; i < headers.length; i++) {
                if ($(headers[i]).text().trim().toLowerCase() === headerText.toLowerCase()) {
                    return i;
                }
            }
            return 1;
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
                url: `{{route('admin.customer.contact.edit')}}/` + id,
                type: 'GET',
                success: function (data) {
                    setDataAndShowEdit(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
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
            let customer_contact = data?.customer_contact;
            $('#manage-form').data('id', customer_contact.id);
            $('#brand_key').val(customer_contact.brand_key);
            $('#team_key').val(customer_contact.team_key);
            $('#name').val(customer_contact.name);
            $('#email').val(customer_contact.email);
            $('#phone').val(customer_contact.phone);
            $('#address').val(customer_contact.address);
            $('#city').val(customer_contact.city);
            $('#state').val(customer_contact.state);
            $('#country').val(customer_contact.country);
            $('#zipcode').val(customer_contact.zipcode);
            $('#status').val(customer_contact.status);

            $('#manage-form').attr('action', `{{route('admin.customer.contact.update')}}/` + customer_contact.id);
            $('#formContainer').addClass('open')
        }

        /** Manage Record */
        $('#manage-form').on('submit', function (e) {
            e.preventDefault();
            var dataId = $('#manage-form').data('id');
            var formData = new FormData(this);
            if (!dataId) {
                AjaxRequestPromise(`{{ route("admin.customer.contact.store") }}`, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {
                                id,
                                brand,
                                team,
                                company,
                                name,
                                email,
                                phone,
                                status,
                                last_activity,
                                created_at,
                                contact_owner
                            } = response.data;
                            const index = table.rows().count() + 1;
                            const columns = `
                                    <td class="align-middle text-center text-nowrap">${team ? `<a href="{{route('admin.team.index')}}">${team.name}</a>` : '---'}</td>
                                    <td class="align-middle text-center text-nowrap"></td>
                                    <td class="align-middle text-center text-nowrap">${brand ? `<a href="{{route('admin.brand.index')}}">${brand.name}</a>` : '---'}</td>
                                    <td class="align-middle text-center text-nowrap"><a href="{{route('admin.customer.contact.edit')}}/${id}" title="${company ? company.name : 'No associated company'}" >${name}</a></td>
                                    <td class="align-middle text-center text-nowrap">${email}</td>
                                    <td class="align-middle text-center text-nowrap">${phone ?? ""}</td>
                                    <td class="align-middle text-center text-nowrap">${last_activity ?? ""}</td>
                                    <td class="align-middle text-center text-nowrap">${created_at ?? ""}</td>
                                    <td class="align-middle text-center text-nowrap">${contact_owner ?? ""}</td>
                                    <td class="align-middle text-center text-nowrap">
                                        <input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? 'checked' : ''} data-bs-toggle="toggle">
                                    </td>
                                    <td class="align-middle text-center table-actions">
                                        <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${id}" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                            `;

                            // <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" title="Edit">
                            //     <i class="fas fa-edit"></i>
                            // </button>
                            table.row.add($('<tr>', {id: `tr-${id}`}).append(columns)).draw(false);
                            $('#manage-form')[0].reset();

                            $('#formContainer').removeClass('open')
                        }
                    })
                    .catch(error => console.log('An error occurred while updating the record.', error));
            } else {
                const url = $(this).attr('action');
                AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                    .then(response => {
                        if (response?.data) {
                            const {
                                id,
                                brand,
                                team,
                                company,
                                name,
                                email,
                                phone,
                                address,
                                city,
                                state,
                                status
                            } = response.data;
                            const index = table.row($('#tr-' + id)).index();
                            const rowData = table.row(index).data();

                            // Column 2: Brand
                            if (decodeHtml(rowData[2]) !== `${brand ? `<a href="{{route('admin.brand.index')}}">${brand.name}</a>` : '---'}`) {
                                table.cell(index, 2).data(`${brand ? `<a href="{{route('admin.brand.index')}}">${brand.name}</a>` : '---'}`).draw();
                            }

                            // Column 3: Team
                            if (decodeHtml(rowData[3]) !== `${team ? `<a href="{{route('admin.team.index')}}">${team.name}</a>` : '---'}`) {
                                table.cell(index, 3).data(`${team ? `<a href="{{route('admin.team.index')}}">${team.name}</a>` : '---'}`).draw();
                            }

                            // Column 4: name
                            if (decodeHtml(rowData[4]) !== `<a href="{{route('admin.customer.contact.index')}}" title="${company ? company.name : 'No associated company'}" >${name}</a>`) {
                                table.cell(index, 4).data(name).draw();
                            }
                            // Column 5: email
                            if (decodeHtml(rowData[5]) !== email) {
                                table.cell(index, 5).data(email).draw();
                            }
                            // Column 6: phone
                            if (decodeHtml(rowData[6]) !== phone) {
                                table.cell(index, 6).data(phone).draw();
                            }

                            // Column 10: Status
                            const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${status == 1 ? "checked" : ""} data-bs-toggle="toggle">`;
                            if (decodeHtml(rowData[12]) !== statusHtml) {
                                table.cell(index, 12).data(statusHtml).draw();
                            }

                            $('#manage-form')[0].reset();
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
            AjaxRequestPromise(`{{ route('admin.customer.contact.change.status') }}/${rowId}?status=${status}`, null, 'GET', {useToastr: true})
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
            AjaxDeleteRequestPromise(`{{ route("admin.customer.contact.delete", "") }}/${id}`, null, 'DELETE', {
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
