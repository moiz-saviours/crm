class SalesKpiDashboard {
    constructor() {
        this.dataTables = [];
        this.employeesData = {};
        this.initDateRangePicker();
        this.initEventListeners();
        this.initializeDataTables();
        setTimeout(() => this.loadInitialData(), 100);
    }

    initDateRangePicker() {
        $('#dateRangePicker').daterangepicker({
            locale: {format: 'YYYY-MM-DD'},
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Current Quarter': [moment().startOf('quarter'), moment().endOf('quarter')],
                'Last Quarter': [moment().subtract(1, 'quarter').startOf('quarter'), moment().subtract(1, 'quarter').endOf('quarter')],
                'This Year': [moment().startOf('year'), moment()],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
            }
        });
    }

    initEventListeners() {
        $('#refreshData').click(() => this.refreshData());
        $('#generateSelectedStatements').click(() => this.generateSelectedPdfs());
        $('#dateRangePicker, #teamSelect, #brandSelect').on('change', () => this.refreshData());
        $('#downloadPdfBtn').click(() => this.downloadPdf());
        $('#resetColumns').click(() => this.resetColumn());
        $('[data-dismiss="modal"]').click(() => $('#pdfStatementModal')?.modal('hide'));
    }

    initializeDataTables() {
        $('.initTable').each((index, table) => {
            this.dataTables[index] = this.createDataTable($(table), index);
        });
    }

    createDataTable(table, index) {
        const tableId = table.attr('id') || `datatable_${index}`;
        const storageKey = `datatable_order_${tableId}`;
        const savedOrder = JSON.parse(localStorage.getItem(storageKey)) || undefined;

        const datatable = table.DataTable({
            dom: "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-2'B><'col-sm-12 col-md-8'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
            buttons: ['showSelected'],
            rowId: 'id',
            order: [[1, 'asc']],
            responsive: false,
            scrollX: true,
            scrollY: ($(window).height() - 350),
            scrollCollapse: true,
            paging: true,
            pageLength: 25,
            colReorder: {
                order: savedOrder,
                realtime: true,
                fixedColumnsLeft: 1,
                columns: ':not(:first-child)'
            },
            columnDefs: [{
                orderable: false,
                targets: 0,
                className: 'select-checkbox',
                render: DataTable.render.select(),
            }],
            fixedColumns: {start: 1},
            select: {style: 'os', selector: 'td:first-child'},
            lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            createdRow: (row, data) => {
                if (data?.is_lead) {
                    $(row).addClass('table-primary');
                }
                $(row).attr('data-id', data[0]);
            }
        });
        datatable.on('column-reorder', function (e, settings, details) {
            const order = datatable.colReorder.order();
            localStorage.setItem(storageKey, JSON.stringify(order));
            console.log('Saved column order for ' + tableId + ':', order);
        });
        datatable.on('select', function (e, dt, type, indexes) {
            if (type === 'row') {
                const rowData = datatable.rows(indexes).data().toArray();
                rowData.forEach(row => {
                });
            }
        });
        // datatable.columns.adjust().draw()
        return datatable;
    }

    async loadInitialData() {
        const startDate = moment().startOf('month').format('YYYY-MM-DD');
        const endDate = moment().endOf('month').format('YYYY-MM-DD');
        await this.fetchData(startDate, endDate, 'all', 'all');
    }

    async refreshData() {
        const {startDate, endDate} = this.getSelectedDateRange();
        const teamKey = $('#teamSelect').val();
        const brandKey = $('#brandSelect').val();
        await this.fetchData(startDate, endDate, teamKey, brandKey);
    }

    getSelectedDateRange() {
        const picker = $('#dateRangePicker').data('daterangepicker');
        return {
            startDate: picker.startDate.format('YYYY-MM-DD'),
            endDate: picker.endDate.format('YYYY-MM-DD')
        };
    }

    async fetchData(startDate, endDate, teamKey, brandKey) {
        try {
            const response = await AjaxRequestPromise(
                window.SalesKpiConfig.routes.update,
                {start_date: startDate, end_date: endDate, team_key: teamKey, brand_key: brandKey},
                'GET'
            );

            if (response.success) {
                this.employeesData = {};
                const table = this.dataTables[0];
                table.clear();

                response.data.forEach((employee, index) => {
                    this.processEmployeeData(employee, index, table);
                });
            }
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    processEmployeeData(employee, index, table) {
        this.employeesData[employee.id] = this.transformEmployeeData(employee);
        table.row.add(this.createTableRowData(employee, index)).draw(false);
    }

    transformEmployeeData(employee) {
        const target = parseFloat(employee.target || 0);
        const achieved = parseFloat(employee.achieved || 0);
        const percentage = target > 0 ? employee.achieved_percentage : 0;
        const overachieved = parseFloat(employee.above_target);

        return {
            id: employee.id,
            name: employee.name,
            isLead: employee.is_lead,
            target: target,
            achieved: achieved,
            percentage: percentage.toFixed(2),
            overachieved: overachieved,
            individualCommission: {
                base: parseFloat(employee?.commission?.base || 0),
                over: parseFloat(employee?.commission?.above || 0)
            },
            teamCommission: {
                base: parseFloat(employee?.teamsData?.commission?.base || 0),
                over: parseFloat(employee?.teamsData?.commission?.above || 0)
            },
            wireSpiffs: {
                previous: {
                    amountUSD: parseFloat(employee?.wire?.previous?.wire_amount || 0),
                    percentage: parseFloat(employee?.wire?.previous?.percentage || 0),
                    wire1x: parseFloat(employee?.wire?.previous?.wire1x || 0),
                    wire2x: parseFloat(employee?.wire?.previous?.wire2x || 0),
                    wire3x: parseFloat(employee?.wire?.previous?.wire3x || 0),
                    commission: parseFloat(employee?.wire?.previous?.commission || 0),
                },
                current: {
                    amountUSD: parseFloat(employee?.wire?.current?.wire_amount || 0),
                    percentage: parseFloat(employee?.wire?.current?.percentage || 0),
                    wire1x: parseFloat(employee?.wire?.current?.wire1x || 0),
                    wire2x: parseFloat(employee?.wire?.current?.wire2x || 0),
                    wire3x: parseFloat(employee?.wire?.current?.wire3x || 0),
                    commission: parseFloat(employee?.wire?.current?.commission || 0),
                },
                sixtyDays: {
                    amountUSD: parseFloat(employee?.wire?.sixtyDays?.wire_amount || 0),
                    percentage: parseFloat(employee?.wire?.sixtyDays?.percentage || 0),
                    wire1x: parseFloat(employee?.wire?.sixtyDays?.wire1x || 0),
                    wire2x: parseFloat(employee?.wire?.sixtyDays?.wire2x || 0),
                    wire3x: parseFloat(employee?.wire?.sixtyDays?.wire3x || 0),
                    commission: parseFloat(employee?.wire?.sixtyDays?.commission || 0),
                },
            },
            aboveTargetSpiffs: {
                individualAboveTarget2x: parseFloat(employee?.above_target2x || 0),
                individualAboveTarget2_5x: parseFloat(employee?.above_target2_5x || 0),
                individualAboveTarget3x: parseFloat(employee?.above_target3x || 0),
                team: parseFloat(employee?.total_bonus || 0)
            },
            leadBonus: employee.is_lead ? parseFloat(employee.lead_bonus || 0) : 0,
            total: employee.total_amount
        };
    }

    createTableRowData(employee, index) {
        const data = this.transformEmployeeData(employee);
        const isLead = data.isLead;

        return [
            data.id,
            index + 1,
            this.formatTeamNames(employee.teams),
            this.createNameCell(data.name, isLead),
            this.formatCurrency(data.target),
            this.formatCurrency(data.achieved),
            this.createPercentageCell(data.percentage),
            this.createAmountCell(data.overachieved),
            this.createPercentageCell(data.overachieved > 0 ? data.percentage : 0),
            this.createAmountCell(data.individualCommission.base),
            this.createAmountCell(data.individualCommission.over),
            this.createAmountCell(data.teamCommission.base),
            this.createAmountCell(data.teamCommission.over),
            this.formatCurrency(data.wireSpiffs.previous.commission),
            this.formatCurrency(data.wireSpiffs.sixtyDays.commission),
            this.formatCurrency(data.wireSpiffs.current.amountUSD),
            this.createPercentageCell(data.wireSpiffs?.current?.percentage || 0),
            this.formatCurrency(data.wireSpiffs?.current?.wire1x || 0),
            this.formatCurrency(data.wireSpiffs?.current?.wire2x || 0),
            this.formatCurrency(data.wireSpiffs?.current?.wire3x || 0),
            this.formatCurrency(data.aboveTargetSpiffs.individualAboveTarget2x),
            this.formatCurrency(data.aboveTargetSpiffs.individualAboveTarget2_5x),
            this.formatCurrency(data.aboveTargetSpiffs.individualAboveTarget3x),
            this.formatCurrency(data.leadBonus),
            this.createTotalDisplayCell(data.total, data.wireSpiffs.current.commission)
        ];
    }

    // Helper methods
    formatTeamNames(teams) {
        if (Array.isArray(teams)) {
            return teams.map(t => t.name).join(', ');
        }
        if (teams && typeof teams === 'object') {
            return Object.values(teams).map(t => t.name).join(', ');
        }
        return '---';
    }

    createNameCell(name, isLead) {
        const leadBadge = isLead ? '<span class="badge ml-2" style="color: var(--bs-primary);">Lead</span>' : '';
        return `<div class="d-flex flex-column"><span>${name} ${leadBadge}</span></div>`;
    }

    createPercentageCell(value) {
        const isPositive = parseFloat(value) >= 85;
        return `<span class="${isPositive ? 'positive' : 'negative'}">${value}%</span>`;
    }

    createAmountCell(value) {
        const isPositive = parseFloat(value) > 0;
        return `<span class="${isPositive ? 'positive' : 'negative'}">${
            parseFloat(value || 0).toLocaleString('en-US', {
                style: 'decimal',
                minimumFractionDigits: 2
            })
        }</span>`;
    }

    formatCurrency(value, symbol = "") {
        return `${symbol} ${parseFloat(value || 0).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })}`;
    }

    createTotalDisplayCell(total, spiff) {
        return `<div class="total-display">
      <div class="total-amount total-line">Total = ${this.formatCurrency(total / 2)}</div>
      <div class="total-divider"></div>
      <div class="bonus-amount spiff-line">+ Spiff = ${this.formatCurrency(spiff)}</div>
    </div>`;
    }

    // PDF Generation
    async generateSelectedPdfs() {
        const selectedIds = this.getSelectedEmployeeIds();

        if (selectedIds.length === 0) {
            this.showAlert('Please select at least one employee');
            return;
        }

        const selectedEmployees = selectedIds.map(id => ({
            id: id,
            name: this.employeesData[id].name,
            data: this.employeesData[id]
        }));

        const pdfHtml = this.generateCombinedPdfHtml(selectedEmployees);
        this.showPdfModal(selectedEmployees.length, pdfHtml);
    }

    getSelectedEmployeeIds() {
        return this.dataTables[0].rows({selected: true}).nodes().toArray().map(row => $(row).attr('data-id'));
    }

    showAlert(message) {
        alert(message);
    }

    showPdfModal(count, htmlContent) {
        $('#pdfStatementModalLabel').text(`Employee Commission Statements (${count})`);
        $('#pdfStatementFrame').attr('srcdoc', htmlContent);
        $('#pdfStatementModal').modal('show');
    }

    downloadPdf() {
        const frame = document.getElementById('pdfStatementFrame');
        frame.contentWindow.print();
    }

    resetColumn() {
        const tableInstance = this.dataTables[0];
        if (!tableInstance) return;
        tableInstance.colReorder.reset();
        const tableElement = $(tableInstance.table().node());
        const tableId = tableElement.attr('id') || `datatable_0`;
        const storageKey = `datatable_order_${tableId}`;
        localStorage.removeItem(storageKey);
        const defaultOrder = tableInstance.colReorder.order();
        localStorage.setItem(storageKey, JSON.stringify(defaultOrder));
    }

    generateCombinedPdfHtml(employees) {
        const {startDate, endDate} = this.getSelectedDateRange();
        let employeeSections = '';

        employees.forEach((employee, index) => {
            const data = employee.data;
            const pageBreakStyle = index < employees.length - 1 ? 'page-break-after: always;' : '';
            employeeSections += `
                            <div class="employee-statement" style="${pageBreakStyle} margin-bottom: 0px;">
                                <div class="header">
                                    <div><h2 style="margin-block: auto;">Sales Commission Statement</h2></div>
                                    <div class="statement-title">
                                        <div class="period">${startDate} - ${endDate}</div>
                                    </div>
                                </div>

                                <div class="employee-info">
                                    <div class="info-row">
                                        <div class="d-flex col-md-4">
                                            <div class="info-label">Employee Name:</div>
                                            <div>${employee.name}</div>
                                        </div>
                                        <div class="d-flex col-md-4">
                                            <div class="info-label">Position:</div>
                                            <div>${data.isLead ? 'Lead' : 'Member'}</div>
                                        </div>
                                        <div class="d-flex col-md-4">
                                            <div class="info-label">Statement Date:</div>
                                            <div>${new Date().toLocaleDateString()}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="performance-summary">
                                    <div class="metric-card">
                                        <div>Monthly Target ($)</div>
                                        <div class="metric-value">${data.target.toLocaleString()}</div>
                                    </div>
                                    <div class="metric-card">
                                        <div>Achieved ($)</div>
                                        <div class="metric-value positive">${data.achieved.toLocaleString()}</div>
                                    </div>
                                    <div class="metric-card">
                                        <div>Achievement %</div>
                                        <div class="metric-value positive">${data.percentage}%</div>
                                    </div>
                                    <div class="metric-card">
                                        <div>Overachievement ($)</div>
                                        <div class="metric-value positive">${data.overachieved.toLocaleString()}</div>
                                    </div>
                                </div>

                                <div class="section-title">Commission Breakdown</div>
                                <table class="earnings-table">
                                    <tr>
                                        <th>Component</th>
                                        <th>Calculation</th>
                                        <th>Amount (₨)</th>
                                    </tr>
                                    <tr>
                                        <td>Individual Commission (Base)</td>
                                        <td>${this.formatCurrency(data.target, "$")} × 4%</td>
                                        <td>${this.formatCurrency(data.individualCommission.base)}</td>
                                    </tr>
                                    <tr>
                                        <td>Individual Commission (Overachieved)</td>
                                        <td>${this.formatCurrency(data.overachieved, "$")} × 6%</td>
                                        <td>${this.formatCurrency(data.individualCommission.over)}</td>
                                    </tr>
                                    ${data.isLead ? `
                                    <tr>
                                        <td>Team Commission (Base)</td>
                                        <td>${this.formatCurrency(data.teamCommission.base / 2, "$")} × 2%</td>
                                        <td>${this.formatCurrency(data.teamCommission.base)}</td>
                                    </tr>
                                    <tr>
                                        <td>Team Commission (Overachieved)</td>
                                        <td>${this.formatCurrency(data.teamCommission.over / 4, "$")}  × 4%</td>
                                        <td>${this.formatCurrency(data.teamCommission.over)}</td>
                                    </tr>
                                    ` : ''}
                                    <tr class="total-row">
                                        <td colspan="2">Subtotal - Commissions</td>
                                        <td>${this.formatCurrency(data.individualCommission.base + data.individualCommission.over +
                (data.isLead ? data.teamCommission.base + data.teamCommission.over : 0))}</td>
                                    </tr>
                                </table>

                                <div class="section-title">SPIFF Earnings</div>
                                <table class="earnings-table">
                                    <tr>
                                        <th>Component</th>
                                        <th>Calculation</th>
                                        <th>Amount (₨)</th>
                                    </tr>
                                    <tr>
                                        <td>Wire SPIFF - Current Period</td>
                                        <td>Calculated based on current wires</td>
                                        <td>${this.formatCurrency(data.wireSpiffs.current.commission)}</td>
                                    </tr>
                                    <tr>
                                        <td>Above Target SPIFF (Individual)</td>
                                        <td>Calculated based on individual performance</td>
                                        <td>${this.formatCurrency(data.aboveTargetSpiffs.individualAboveTarget2x)}</td>
                                    </tr>
                                    ${data.isLead ? `
                                    <tr>
                                        <td>Above Target SPIFF (Team Lead)</td>
                                        <td>Calculated based on team performance</td>
                                        <td>${this.formatCurrency(data.leadBonus)}</td>
                                    </tr>
                                    ` : ''}
                                    <tr class="total-row">
                                        <td colspan="2">Subtotal - SPIFFs</td>
                                        <td>${this.formatCurrency(data.wireSpiffs.current.commission +
                (data.aboveTargetSpiffs.individualAboveTarget2x ? data.aboveTargetSpiffs.individualAboveTarget2x : (data.aboveTargetSpiffs.individualAboveTarget2_5x ? data.aboveTargetSpiffs.individualAboveTarget2_5x : (data.aboveTargetSpiffs.individualAboveTarget3x ? data.aboveTargetSpiffs.individualAboveTarget3x : 0))) +
                (data.isLead ? data.leadBonus : 0))}</td>
                                    </tr>
                                </table>

                                <div class="section-title">Total Earnings Summary</div>
                                <table class="earnings-table">
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount (₨)</th>
                                    </tr>
                                    <tr>
                                        <td>Total Commissions</td>
                                        <td>${this.formatCurrency(data.individualCommission.base + data.individualCommission.over +
                (data.isLead ? data.teamCommission.base + data.teamCommission.over : 0))}</td>
                                    </tr>
                                    <tr>
                                        <td>Total SPIFFs</td>
                                        <td>${this.formatCurrency(data.wireSpiffs.current.commission +
                (data.aboveTargetSpiffs.individualAboveTarget2x ? data.aboveTargetSpiffs.individualAboveTarget2x : (data.aboveTargetSpiffs.individualAboveTarget2_5x ? data.aboveTargetSpiffs.individualAboveTarget2_5x : (data.aboveTargetSpiffs.individualAboveTarget3x ? data.aboveTargetSpiffs.individualAboveTarget3x : 0))) +
                (data.isLead ? data.leadBonus : 0))}</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td>Gross Payable Amount</td>
                                        <td>${this.formatCurrency(data.total)}</td>
                                    </tr>
                                    <tr class="total-row" style="background-color: #d5f5e3;">
                                        <td>Net Payable Amount</td>
                                        <td>${this.formatCurrency(data.total / 2)}</td>
                                    </tr>
                                </table>

                                <div class="footer">
                                    <div style="margin-top: 0px;">
                                        <div class="signature-line">Authorized Signature</div>
                                    </div>
                                    <div>Generated on: ${new Date().toLocaleDateString()}</div>
                                </div>
                            </div>
                        `;
        });

        return `
                        <!DOCTYPE html>
                        <html>
                        <head>
                            <style>
                                body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; font-size: 9pt;}
                                .statement-container { width: 100%; max-width: 700px; margin: 0 auto; padding: 10px; }
                                .header {display: flex;justify-content: space-between;border-bottom: 2px solid #2c3e50;padding-bottom: 20px;margin-bottom: 20px;flex-direction: column;align-content: space-around;flex-wrap: wrap;align-items: center;}
                                .statement-title h1 { color: #2c3e50; margin: 0; font-size: 13pt; }
                                .period { font-size: 9pt; color: #7f8c8d; }
                                .employee-info { background-color: #f8f9fa; padding: 10px; border-radius: 5px; margin-bottom: 10px; }
                                .info-row { display: flex;justify-content: space-between;text-align: center; }
                                .info-row > div{ display: flex}
                                .info-label { font-weight: bold; width: 150px; color: #2c3e50; }
                                .performance-summary { display: flex; justify-content: space-between; margin-bottom: 5px; }
                                .metric-card { flex: 1; padding: 5px; border-radius: 5px; background-color: #f8f9fa; margin: 0 8px; text-align: center; font-size: 12px;}
                                .metric-value { font-size: 8pt; font-weight: bold; margin: 1px 0; }
                                .positive { color: #27ae60; }
                                .negative { color: #e74c3c; }
                                .progress-bar { height: 10px; background-color: #ecf0f1; border-radius: 5px; margin-top: 5px; overflow: hidden; }
                                .progress-fill { height: 100%; background-color: #3498db; }
                                .section-title { background-color: #2c3e50; color: white; padding: 8px 15px; margin: 10px 0 5px 0; border-radius: 5px; font-size: 10pt; }
                                .earnings-table { width: 100%; border-collapse: collapse; margin-bottom: 15px;font-size: 8pt; }
                                .earnings-table td:last-child,.earnings-table th:last-child {text-align: right;}
                                .earnings-table th { background-color: #34495e; color: white; padding: 8px 10px; text-align: left; }
                                .earnings-table td { padding: 5px; border-bottom: 1px solid #ddd; }
                                .earnings-table tr:nth-child(even) { background-color: #f8f9fa; }
                                .total-row { font-weight: bold; background-color: #eaf2f8 !important; }
                                .footer { margin-top: 0px; padding-top: 20px; border-top: 1px solid #ddd; text-align: center; font-size: 8pt; color: #7f8c8d; }
                                .signature-line { margin-top: 50px; border-top: 1px solid #2c3e50; width: 250px; text-align: center; padding-top: 5px; }
                                .employee-statement:last-child { page-break-after: auto; }
                                @media print {
                                body {
                                    padding: 0;
                                    margin: 0;
                                }
                                .statement-container {
                                    padding: 0;
                                    margin: 0;
                                }
                                .employee-statement {
                                    page-break-after: always;
                                    margin: 0;
                                    padding: 1cm;
                                }
                                .employee-statement:last-child {
                                    page-break-after: auto;
                                }
                            </style>
                        </head>
                        <body>
                            <div class="statement-container">
                                ${employeeSections}
                            </div>
                        </body>
                        </html>
                    `;
    }
}

// Initialize the dashboard when DOM is ready
$(document).ready(() => {
    window.salesKpiDashboard = new SalesKpiDashboard();
});
