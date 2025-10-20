@extends('admin.layouts.app')
@section('title','Sales Kpi')
@section('datatable', true)

@section('content')
    @push('style')
        <style>
            .tabl_tr:nth-child(odd) {
                background-color: #98a3b0;
                color: #fff;
            }

            .tabl_tr:nth-child(even) {
                background-color: #fff;
                color: #000 !important;
            }

            /*New KPI Style*/
            .kpi-header {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                padding: 12px 10px;
                margin-top: -90px;
                gap: 12px;
            }

            .kpi-heading {
                font-size: 16px;
                color: #000;
                font-weight: 500;
            }

            .main-date-input {
                border: solid #ccc;
                border-width: 0px 0px 1px;
                background: transparent;
                font-size: 15px;
                min-width: 147px;
            }

        </style>
        <style>
            .move-col {
                min-width: 80px;
            }

            .group-header {
                cursor: pointer;
                background-color: #e9ecef !important;
                position: relative;
            }

            .group-header:hover {
                background-color: #d1d7dc !important;
            }

            .toggle-icon {
                margin-left: 5px;
                display: inline-block;
                transition: transform 0.3s;
            }

            .collapsed .toggle-icon {
                transform: rotate(-90deg);
            }

            .collapsed-group {
                display: none;
            }

            tr.selected .negative, tr.selected .positive {
                color: white;
            }

            .positive {
                color: #28a745;
                font-weight: bold;
            }

            .negative {
                color: #dc3545;
                font-weight: bold;
            }

            .total-display {
                display: flex;
                flex-direction: column;
                gap: 4px; /* Space between lines */
            }

            .total-amount {
                font-weight: 600;
                font-size: 1.05em;
            }

            .total-line, .spiff-line {
                white-space: nowrap;
                line-height: 1.3;
            }

            .total-divider {
                border-top: 1px dashed #000;
                width: 100%;
                margin: 3px 0;
            }

            .bonus-amount {
                color: var(--bs-success);
                font-size: 0.95em;
            }

        </style>
    @endpush

    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <!-- Page title and information -->
                <h1 class="page-title mb-2 all-data">Sales KPI</h1>
                <p>Welcome to Sales Kpi.</p>
                {{--                <!-- END : Page title and information -->--}}
                {{--                <button class="start-tour-btn my-btn tour-dashboard2-alldata" data-bs-toggle="tooltip" data-bs-placement="top" title="Take a Tour" data-tour="dashboard2"> <i class="fas fa-exclamation-circle custom-dot"></i> </button>--}}
            </div>
        </div>
        <div class="content__boxed">
            <div class="content__wrap">
                <!-- KPI content start -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="kpi-header">
                                <h2 class="kpi-heading"></h2>
                                <div class="form-group">
                                    <label for="teamSelect">Select Team:</label>
                                    <select id="teamSelect" name="teamSelect" class="form-control">
                                        <option value="all">All Teams</option>
                                        @foreach($teams as $team)
                                            <option value="{{ $team->team_key }}">{{ $team->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group tour-brand-select">
                                    <label for="brandSelect">Select Brand:</label>
                                    <select id="brandSelect" name="brandSelect" class="form-control">
                                        <option value="all">All Brands</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->brand_key }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="dateRangePicker">Select Date Range:</label>
                                    <input type="text" id="dateRangePicker" name="dateRangePicker"
                                           class="form-control dateRangePicker"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 ">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">

                                <div class="mb-3">
                                    <button id="generateSelectedStatements" class="btn btn-primary">
                                        <i class="fas fa-file-pdf"></i> Generate PDF for Selected
                                    </button>
                                </div>
                                <div>
                                    <button id="resetColumns" class="btn btn-secondary ml-2">
                                        <i class="fas fa-sync-alt"></i> Reset Columns
                                    </button>
                                    <button id="refreshData" class="btn btn-secondary ml-2">
                                        <i class="fas fa-sync-alt"></i> Refresh
                                    </button>
                                </div>
                            </div>
                            <table class="table table-bordered monthly-sales-record-table initTable new_tbl"
                                   id="salesKpiTable1">
                                <thead>
                                <!-- Row 1: Top-Level Groups -->
                                <tr class="monthly-sales-record-table-row">
                                    <th rowspan="3"
                                        class="align-middle text-center text-nowrap table-headings"></th>
                                    <th rowspan="3"
                                        class="align-middle text-center text-nowrap move-col table-headings">S.No
                                    </th>
                                    <th rowspan="3"
                                        class="align-middle text-center text-nowrap move-col table-headings">Team
                                    </th>
                                    <th rowspan="3"
                                        class="align-middle text-center text-nowrap move-col table-headings">Name
                                    </th>

                                    <!-- Sales Targets Group -->
                                    <th colspan="3"
                                        class="align-middle text-center text-nowrap move-col table-headings group-header">
                                        Sales Targets
                                    </th>

                                    <!-- Overachievement Group -->
                                    <th colspan="2"
                                        class="align-middle text-center text-nowrap move-col table-headings group-header">
                                        Overachievement
                                    </th>

                                    <!-- Multiplier Group -->
                                    <th colspan="4"
                                        class="align-middle text-center text-nowrap move-col table-headings group-header">
                                        Commission Multiplier
                                    </th>

                                    <!-- Wire SPIFF Group -->
                                    <th colspan="7"
                                        class="align-middle text-center text-nowrap move-col table-headings group-header">
                                        Wire SPIFF
                                    </th>

                                    <!-- Above Target SPIFF Group -->
                                    <th colspan="3"
                                        class="align-middle text-center text-nowrap move-col table-headings group-header">
                                        Above Target SPIFF
                                    </th>

                                    <!-- Lead Bonus Group -->
                                    <th colspan="1"
                                        class="align-middle text-center text-nowrap move-col table-headings group-header">
                                        Lead Bonus
                                    </th>

                                    <th rowspan="3"
                                        class="align-middle text-center text-nowrap move-col table-headings">Total (₨)
                                    </th>
                                </tr>

                                <!-- Row 2: Mid-Level Groups -->
                                <tr class="monthly-sales-record-table-row">
                                    <!-- Sales Targets Subgroups -->
                                    <th class="align-middle text-center text-nowrap move-col table-headings">Target
                                    </th>
                                    <th colspan="2"
                                        class="align-middle text-center text-nowrap move-col table-headings">Achieved
                                    </th>

                                    <!-- Overachievement Subgroups -->
                                    <th colspan="2"
                                        class="align-middle text-center text-nowrap move-col table-headings">Above
                                        Target
                                    </th>

                                    <!-- Multiplier Subgroups -->
                                    <th colspan="2"
                                        class="align-middle text-center text-nowrap move-col table-headings">Individual
                                    </th>
                                    <th colspan="2"
                                        class="align-middle text-center text-nowrap move-col table-headings">Team
                                    </th>

                                    <!-- Wire SPIFF Subgroups -->
                                    <th colspan="2"
                                        class="align-middle text-center text-nowrap move-col table-headings">Previous
                                        Wires
                                    </th>
                                    <th colspan="2"
                                        class="align-middle text-center text-nowrap move-col table-headings">Current
                                        Period
                                    </th>
                                    <th colspan="3"
                                        class="align-middle text-center text-nowrap move-col table-headings">Multipliers
                                    </th>

                                    <!-- Above Target SPIFF Subgroups -->
                                    <th colspan="3"
                                        class="align-middle text-center text-nowrap move-col table-headings">Multipliers
                                    </th>

                                    <!-- Lead Bonus -->
                                    <th colspan="1"
                                        class="align-middle text-center text-nowrap move-col table-headings">Multipliers
                                    </th>
                                </tr>

                                <!-- Row 3: Column Headers -->
                                <tr class="monthly-sales-record-table-row">
                                    <!-- Sales Targets: Targets -->
                                    <th class="align-middle text-center text-nowrap table-headings">$</th>

                                    <!-- Sales Targets: Achieved -->
                                    <th class="align-middle text-center text-nowrap table-headings">$</th>
                                    <th class="align-middle text-center text-nowrap table-headings">%</th>

                                    <!-- Overachievement: Amount -->
                                    <th class="align-middle text-center text-nowrap table-headings">$</th>
                                    <th class="align-middle text-center text-nowrap table-headings">%</th>

                                    <!-- Multiplier: Individual -->
                                    <th class="align-middle text-center text-nowrap table-headings">4x Rs</th>
                                    <th class="align-middle text-center text-nowrap table-headings">6x Rs</th>

                                    <!-- Multiplier: Team -->
                                    <th class="align-middle text-center text-nowrap table-headings">2x Rs</th>
                                    <th class="align-middle text-center text-nowrap table-headings">4x Rs</th>

                                    <!-- Wire SPIFF: Previous Wires -->
                                    <th class="align-middle text-center text-nowrap table-headings">Prev Rs</th>
                                    <th class="align-middle text-center text-nowrap table-headings">60 Days Rs
                                    </th>

                                    <!-- Wire SPIFF: Current Period -->
                                    <th class="align-middle text-center text-nowrap table-headings">Wire
                                        Spiff $
                                    </th>
                                    <th class="align-middle text-center text-nowrap table-headings">Wire %</th>

                                    <!-- Wire SPIFF: Multipliers -->
                                    <th class="align-middle text-center text-nowrap table-headings">1x Rs</th>
                                    <th class="align-middle text-center text-nowrap table-headings">2x Rs</th>
                                    <th class="align-middle text-center text-nowrap table-headings">3x Rs</th>

                                    <!-- Above Target SPIFF: Multipliers -->
                                    <th class="align-middle text-center text-nowrap table-headings">2x Rs</th>
                                    <th class="align-middle text-center text-nowrap table-headings">2.5x Rs</th>
                                    <th class="align-middle text-center text-nowrap table-headings">3x Rs</th>

                                    <!-- Lead Bonus -->
                                    <th class="align-middle text-center text-nowrap table-headings">3x Rs</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--                                <!-- Employee 1: Lead -->--}}
                                {{--                                <tr class="monthly-sales-record-table-row">--}}
                                {{--                                    <td class="align-middle text-center text-nowrap"></td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap">1</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap">Alpha</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap">--}}
                                {{--                                        <div class="d-flex flex-column">--}}
                                {{--                                            <span>Alex (Lead)</span>--}}
                                {{--                                            <button class="btn btn-sm btn-primary generate-statement-btn mt-1"--}}
                                {{--                                                    data-employee-id="1"--}}
                                {{--                                                    data-employee-name="Alex (Lead)"--}}
                                {{--                                                    data-employee-data='{"target":10000,"achieved":28000,"percentage":280,"overachieved":18000,"individualCommission":{"base":40000,"over":108000},"teamCommission":{"base":20000,"over":40000},"wireSpiffs":{"previous":14000,"current":12000},"aboveTargetSpiffs":{"individual":36000,"team":121500},"leadBonus":66000,"total":458300}'>--}}
                                {{--                                                Generate Statement--}}
                                {{--                                            </button>--}}
                                {{--                                        </div>--}}
                                {{--                                    </td>--}}

                                {{--                                    <!-- Sales Targets -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap input-cell">10,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap input-cell">28,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell positive">280%</td>--}}

                                {{--                                    <!-- Overachievement -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell positive">18,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell positive">180%</td>--}}

                                {{--                                    <!-- Multiplier: Individual -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">--}}
                                {{--                                        40,000--}}
                                {{--                                    </td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">--}}
                                {{--                                        108,000--}}
                                {{--                                    </td>--}}

                                {{--                                    <!-- Multiplier: Team -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">--}}
                                {{--                                        20,000--}}
                                {{--                                    </td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">--}}
                                {{--                                        40,000--}}
                                {{--                                    </td>--}}

                                {{--                                    <!-- Wire SPIFF -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell bg-green-100">10,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell bg-green-100">4,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell">12,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell">43%</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell ">5,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell ">14,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell">0</td>--}}

                                {{--                                    <!-- Above Target SPIFF -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">--}}
                                {{--                                        36,000--}}
                                {{--                                    </td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">0</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">0</td>--}}

                                {{--                                    <!-- Lead Bonus -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">--}}
                                {{--                                        66,000--}}
                                {{--                                    </td>--}}

                                {{--                                    <!-- Total -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell">343,000</td>--}}
                                {{--                                </tr>--}}

                                {{--                                <!-- Employee 2: Team Member -->--}}
                                {{--                                <tr class="monthly-sales-record-table-row">--}}
                                {{--                                    <td class="align-middle text-center text-nowrap"></td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap">2</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap">Alpha</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap">Sarah</td>--}}

                                {{--                                    <!-- Sales Targets -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap input-cell">8,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap input-cell">15,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell positive">188%</td>--}}

                                {{--                                    <!-- Overachievement -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell positive">7,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell positive">88%</td>--}}

                                {{--                                    <!-- Multiplier: Individual -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">--}}
                                {{--                                        24,000--}}
                                {{--                                    </td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">--}}
                                {{--                                        42,000--}}
                                {{--                                    </td>--}}

                                {{--                                    <!-- Multiplier: Team -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">0</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">0</td>--}}

                                {{--                                    <!-- Wire SPIFF -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell bg-green-100">4,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell bg-green-100">3,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell">9,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell">60%</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell">3,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell">9,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell">0</td>--}}

                                {{--                                    <!-- Above Target SPIFF -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">--}}
                                {{--                                        14,000--}}
                                {{--                                    </td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">0</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">0</td>--}}

                                {{--                                    <!-- Lead Bonus (N/A for non-leads) -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">0</td>--}}

                                {{--                                    <!-- Total -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell">87,000</td>--}}
                                {{--                                </tr>--}}

                                {{--                                <!-- Employee 3: Team Member -->--}}
                                {{--                                <tr class="monthly-sales-record-table-row">--}}
                                {{--                                    <td class="align-middle text-center text-nowrap"></td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap">3</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap">Alpha</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap">John</td>--}}

                                {{--                                    <!-- Sales Targets -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap input-cell">12,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap input-cell">9,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell negative bg-red-100">75%--}}
                                {{--                                    </td>--}}

                                {{--                                    <!-- Overachievement -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell negative bg-red-100">--}}
                                {{--                                        -3,000--}}
                                {{--                                    </td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell negative bg-red-100">--}}
                                {{--                                        -25%--}}
                                {{--                                    </td>--}}

                                {{--                                    <!-- Multiplier: Individual -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">0</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">0</td>--}}

                                {{--                                    <!-- Multiplier: Team -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">0</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">0</td>--}}

                                {{--                                    <!-- Wire SPIFF -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell bg-green-100">3,500</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell bg-green-100">4,500</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell">4,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell">33%</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell">0</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell">4,000</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell">0</td>--}}

                                {{--                                    <!-- Above Target SPIFF (Not achieved) -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">0</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">0</td>--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">0</td>--}}

                                {{--                                    <!-- Lead Bonus (N/A) -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap multiplier-cell bg-green-100">0</td>--}}

                                {{--                                    <!-- Total -->--}}
                                {{--                                    <td class="align-middle text-center text-nowrap calc-cell ">4,500</td>--}}
                                {{--                                </tr>--}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
    <!-- PDF Statement Modal -->
    <div class="modal fade" id="pdfStatementModal" tabindex="-1" role="dialog" aria-labelledby="pdfStatementModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfStatementModalLabel">Employee Commission Statement</h5>
                    <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="pdfStatementFrame" style="width: 100%; height: 80vh; border: none;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="downloadPdfBtn">Download PDF</button>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <!-- Date Range Picker -->
        <script src="{{asset('assets/js/moment.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/daterangepicker/daterangepicker.min.js')}}"></script>
        <script>
            window.SalesKpiConfig = {
                routes: {
                    update: "{{ route('admin.sales.kpi.update') }}"
                },
                csrfToken: "{{ csrf_token() }}"
            };
        </script>
        <script src="{{asset('assets/js/sales-kpi.js')}}"></script>
        {{--            <script>--}}

        {{--                $(document).ready(function () {--}}
        {{--                    var dataTables = [];--}}
        {{--                    var employeesData = {};--}}

        {{--                    /** Initializing Datatable */--}}
        {{--                    if ($('.initTable').length) {--}}
        {{--                        $('.initTable').each(function (index) {--}}
        {{--                            dataTables[index] = initializeDatatable($(this), index)--}}
        {{--                        })--}}
        {{--                    }--}}

        {{--                    function initializeDatatable(table_div, index) {--}}
        {{--                        const tableId = table_div.attr('id') || 'datatable_' + index;--}}
        {{--                        const storageKey = 'datatable_order_' + tableId;--}}
        {{--                        let savedOrder = localStorage.getItem(storageKey);--}}
        {{--                        if (savedOrder) {--}}
        {{--                            savedOrder = JSON.parse(savedOrder);--}}
        {{--                        }--}}
        {{--                        let datatable = table_div.DataTable({--}}
        {{--                            dom:--}}
        {{--                                "<'row'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-2'B><'col-sm-12 col-md-8'f>>" +--}}
        {{--                                "<'row'<'col-sm-12'tr>>" +--}}
        {{--                                "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",--}}
        {{--                            buttons: [--}}
        {{--                                'showSelected'--}}
        {{--                            ],--}}
        {{--                            rowId:'id',--}}
        {{--                            order: [[1, 'asc']],--}}
        {{--                            responsive: false,--}}
        {{--                            scrollX: true,--}}
        {{--                            scrollY: ($(window).height() - 350),--}}
        {{--                            scrollCollapse: true,--}}
        {{--                            paging: true,--}}
        {{--                            pageLength: 25,--}}
        {{--                            colReorder: {--}}
        {{--                                order: savedOrder || undefined,--}}
        {{--                                realtime: true,--}}
        {{--                                fixedColumnsLeft: 1,--}}
        {{--                                columns: ':not(:first-child)'--}}
        {{--                            },--}}
        {{--                            columnDefs: [--}}
        {{--                                {--}}
        {{--                                    orderable: false,--}}
        {{--                                    targets: 0,--}}
        {{--                                    className: 'select-checkbox',--}}
        {{--                                    render: DataTable.render.select(),--}}
        {{--                                }--}}
        {{--                            ],--}}
        {{--                            fixedColumns: {--}}
        {{--                                start: 1,--}}
        {{--                            },--}}
        {{--                            select: {--}}
        {{--                                style: 'os',--}}
        {{--                                selector: 'td:first-child',--}}
        {{--                            },--}}
        {{--                            lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],--}}
        {{--                            createdRow: function(row, data, dataIndex) {--}}
        {{--                                $(row).attr('data-id', data[0]);--}}
        {{--                            }                        });--}}
        {{--                        datatable.on('column-reorder', function (e, settings, details) {--}}
        {{--                            const order = datatable.colReorder.order();--}}
        {{--                            localStorage.setItem(storageKey, JSON.stringify(order));--}}
        {{--                            console.log('Saved column order for ' + tableId + ':', order);--}}
        {{--                        });--}}
        {{--                        datatable.on('select', function(e, dt, type, indexes) {--}}
        {{--                            if (type === 'row') {--}}
        {{--                                const rowData = datatable.rows(indexes).data().toArray();--}}
        {{--                                rowData.forEach(row => {--}}
        {{--                                    // You can access the ID here: row.id--}}
        {{--                                    console.log('Selected row ID:', row.id);--}}
        {{--                                });--}}
        {{--                            }--}}
        {{--                        });--}}
        {{--                        datatable.columns.adjust().draw()--}}
        {{--                        return datatable;--}}
        {{--                    }--}}
        {{--                    $('.modal').on('shown.bs.modal', function () {--}}
        {{--                        let table = dataTables[0];--}}
        {{--                        if (table.length) {--}}
        {{--                            let datatable = table.DataTable();--}}
        {{--                            if (datatable) {--}}
        {{--                                datatable.columns.adjust().draw();--}}
        {{--                            }--}}
        {{--                        }--}}
        {{--                    });--}}
        {{--                    $('#dateRangePicker').daterangepicker({--}}
        {{--                        locale: {--}}
        {{--                            format: 'YYYY-MM-DD'--}}
        {{--                        },--}}
        {{--                        startDate: moment().startOf('month'), // Default start date (beginning of current month)--}}
        {{--                        endDate: moment().endOf('month'), // Default end date (end of current month)--}}
        {{--                        ranges: {--}}
        {{--                            'Today': [moment(), moment()],--}}
        {{--                            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],--}}
        {{--                            'Last 7 Days': [moment().subtract(6, 'days'), moment()],--}}
        {{--                            'Last 30 Days': [moment().subtract(29, 'days'), moment()],--}}
        {{--                            'This Month': [moment().startOf('month'), moment().endOf('month')],--}}
        {{--                            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],--}}
        {{--                            'Current Quarter': [moment().startOf('quarter'), moment().endOf('quarter')],--}}
        {{--                            'Last Quarter': [moment().subtract(1, 'quarter').startOf('quarter'), moment().subtract(1, 'quarter').endOf('quarter')],--}}
        {{--                            'This Year': [moment().startOf('year'), moment()],--}}
        {{--                            'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],--}}
        {{--                        }--}}
        {{--                    });--}}
        {{--                    const startDate = moment().startOf('month').format('YYYY-MM-DD');--}}
        {{--                    const endDate = moment().endOf('month').format('YYYY-MM-DD');--}}
        {{--                    const teamKey = 'all';--}}
        {{--                    const brandKey = 'all';--}}

        {{--                    // Refresh button--}}
        {{--                    $('#refreshData').click(function () {--}}
        {{--                        const startDate = $('#dateRangePicker').data('daterangepicker').startDate.format('YYYY-MM-DD');--}}
        {{--                        const endDate = $('#dateRangePicker').data('daterangepicker').endDate.format('YYYY-MM-DD');--}}
        {{--                        const teamKey = $('#teamSelect').val();--}}
        {{--                        const brandKey = $('#brandSelect').val();--}}
        {{--                        fetchData(startDate, endDate, teamKey, brandKey);--}}
        {{--                    });--}}
        {{--                    fetchData(startDate, endDate, teamKey, brandKey);--}}
        {{--                    $('#dateRangePicker').on('cancel.daterangepicker', function () {--}}
        {{--                        fetchData('', '', '', '');--}}
        {{--                    });--}}
        {{--                    $('#dateRangePicker, #teamSelect, #brandSelect').on('change', function () {--}}
        {{--                        const startDate = $('#dateRangePicker').data('daterangepicker').startDate.format('YYYY-MM-DD');--}}
        {{--                        const endDate = $('#dateRangePicker').data('daterangepicker').endDate.format('YYYY-MM-DD');--}}
        {{--                        const teamKey = $('#teamSelect').val();--}}
        {{--                        const brandKey = $('#brandSelect').val();--}}
        {{--                        fetchData(startDate, endDate, teamKey, brandKey);--}}
        {{--                    });--}}

        {{--                    function fetchData(startDate, endDate, teamKey = 'all', brandKey = 'all') {--}}
        {{--                        let url = `{{ route("admin.sales.kpi.update") }}`;--}}
        {{--                        let params = {};--}}
        {{--                        if (startDate && endDate) {--}}
        {{--                            params.start_date = startDate;--}}
        {{--                            params.end_date = endDate;--}}
        {{--                        }--}}
        {{--                        if (teamKey) {--}}
        {{--                            params.team_key = teamKey;--}}
        {{--                        }--}}
        {{--                        if (brandKey) {--}}
        {{--                            params.brand_key = brandKey;--}}
        {{--                        }--}}
        {{--                        if (startDate && endDate) {--}}
        {{--                            let table = dataTables[0];--}}
        {{--                            AjaxRequestPromise(url, params, 'GET')--}}
        {{--                                .then(response => {--}}
        {{--                                    if (response.success) {--}}
        {{--                                        let sales_kpi_table = dataTables.filter(dt => dt.table().node().id === 'salesKpiTable1')[0];--}}
        {{--                                        sales_kpi_table.clear().draw();--}}
        {{--                                        employeesData = {};--}}
        {{--                                        response.employees.forEach((employee, index) => {--}}
        {{--                                            employeesData[employee.id] = employee;--}}
        {{--                                            const target = parseFloat(employee.target || 0);--}}
        {{--                                            const achieved = parseFloat(employee.achieved || 0);--}}
        {{--                                            const achieved_percentage = employee.achieved_percentage;--}}
        {{--                                            const percentage = target > 0 ? achieved_percentage : 0;--}}
        {{--                                            const overachieved = parseFloat(employee.above_target);--}}
        {{--                                            const aboveTargetPercentage = parseFloat(employee.above_target_percentage || 0);--}}

        {{--                                            // Calculate commissions and bonuses based on your business logic--}}
        {{--                                            const individualCommissionBase = parseFloat(employee?.commission?.base || 0);--}}
        {{--                                            const individualCommissionOver = parseFloat(employee?.commission?.above || 0);--}}

        {{--                                            const teamCommissionBase = parseFloat(employee?.teamsData?.commission?.base || 0);--}}
        {{--                                            const teamCommissionOver = parseFloat(employee.teamsData?.commission?.above || 0);--}}

        {{--                                            // Wire SPIFF calculations--}}
        {{--                                            const wireSpiffCurrentAmount = parseFloat(employee?.wire?.current?.wire_amount || 0) || 0;--}}
        {{--                                            const wireSpiffCurrentPercentage = employee?.wire?.current?.percentage || 0;--}}
        {{--                                            const wireSpiffCurrent1x = parseFloat(employee?.wire?.current?.wire1x || 0) || 0;--}}
        {{--                                            const wireSpiffCurrent2x = parseFloat(employee?.wire?.current?.wire2x || 0) || 0;--}}
        {{--                                            const wireSpiffCurrent3x = parseFloat(employee?.wire?.current?.wire3x || 0) || 0;--}}
        {{--                                            const wireSpiffCurrent = parseFloat(employee?.wire?.current?.commission || 0) || 0;--}}
        {{--                                            const wireSpiffPrevious = parseFloat(employee?.wire?.previous?.commission || 0) || 0;--}}
        {{--                                            const wireSpiffSixtyDays = parseFloat(employee?.wire?.sixtyDays?.commission || 0) || 0;--}}

        {{--                                            // Above Target SPIFF--}}
        {{--                                            const above_target2x = parseFloat(employee?.above_target2x || 0);--}}
        {{--                                            const above_target2_5x = parseFloat(employee?.above_target2_5x || 0);--}}
        {{--                                            const above_target3x = parseFloat(employee?.above_target3x || 0);--}}
        {{--                                            const aboveTargetSpiffTeam = parseFloat(employee?.total_bonus || 0);--}}
        {{--                                            console.log(`Above Target SPIFFs for ${employee.name}:`, {--}}
        {{--                                                above_target2x,--}}
        {{--                                                above_target2_5x,--}}
        {{--                                                above_target3x,--}}
        {{--                                                overachieved--}}
        {{--                                            });--}}
        {{--                                            // Lead Bonus--}}
        {{--                                            const leadBonus = employee.is_lead ? parseFloat(employee.lead_bonus || 0) : 0;--}}

        {{--                                            // Total calculation--}}
        {{--                                            const total = employee.total_amount;--}}

        {{--                                            // Store employee data for PDF generation--}}
        {{--                                            employeesData[employee.id] = {--}}
        {{--                                                name: employee.name,--}}
        {{--                                                is_lead: employee.is_lead,--}}
        {{--                                                target: target,--}}
        {{--                                                achieved: achieved,--}}
        {{--                                                percentage: percentage.toFixed(2),--}}
        {{--                                                overachieved: overachieved,--}}
        {{--                                                individualCommission: {--}}
        {{--                                                    base: individualCommissionBase,--}}
        {{--                                                    over: individualCommissionOver--}}
        {{--                                                },--}}
        {{--                                                teamCommission: {--}}
        {{--                                                    base: teamCommissionBase,--}}
        {{--                                                    over: teamCommissionOver--}}
        {{--                                                },--}}
        {{--                                                wireSpiffs: {--}}
        {{--                                                    previous: wireSpiffPrevious,--}}
        {{--                                                    current: wireSpiffCurrent,--}}
        {{--                                                    sixtyDays: wireSpiffSixtyDays,--}}
        {{--                                                },--}}
        {{--                                                aboveTargetSpiffs: {--}}
        {{--                                                    individual_above_target2x: above_target2x,--}}
        {{--                                                    individual_above_target2_5x: above_target2_5x,--}}
        {{--                                                    individual_above_target3x: above_target3x,--}}
        {{--                                                    team: aboveTargetSpiffTeam--}}
        {{--                                                },--}}
        {{--                                                leadBonus: leadBonus,--}}
        {{--                                                total: total--}}
        {{--                                            };--}}

        {{--                                            // Add row to the table--}}
        {{--                                            table.row.add([--}}
        {{--                                                `<input type="checkbox" class="employee-checkbox" data-employee-id="${employee.id}">`,--}}
        {{--                                                index + 1,--}}
        {{--                                                Array.isArray(employee.teams) ? employee.teams.map(t => t.name).join(', ') : (employee.teams && typeof employee.teams === 'object' ? Object.values(employee.teams).map(t => t.name).join(', ') : '---'),--}}
        {{--                                                `<div class="d-flex flex-column">--}}
        {{--                                                    <span>${employee.name} ${employee?.teamsData?.is_lead ? '<span class="badge ml-2" style="color: var(--bs-primary);">Lead</span>' : ''}</span>--}}
        {{--                                                </div>`,--}}
        {{--                                                // Sales Targets--}}
        {{--                                                formatCurrency(target),--}}
        {{--                                                formatCurrency(achieved),--}}
        {{--                                                `<span class="${percentage >= 85 ? 'positive' : 'negative'}">${percentage.toFixed(2)}%</span>`,--}}
        {{--                                                // Overachievement--}}
        {{--                                                `<span class="${overachieved > 0 ? 'positive' : 'negative'}">${overachieved.toLocaleString('en-US', {--}}
        {{--                                                    style: 'decimal',--}}
        {{--                                                    minimumFractionDigits: 2--}}
        {{--                                                })}</span>`,--}}
        {{--                                                `<span class="${overachieved > 0 ? 'positive' : 'negative'}">${aboveTargetPercentage.toFixed(2)}%</span>`,--}}
        {{--                                                // Multiplier: Individual--}}
        {{--                                                `<span class="${individualCommissionBase > 0 ? 'positive' : 'negative'}">${individualCommissionBase.toLocaleString('en-US', {--}}
        {{--                                                    style: 'decimal',--}}
        {{--                                                    minimumFractionDigits: 2--}}
        {{--                                                })}</span>`,--}}
        {{--                                                `<span class="${individualCommissionOver > 0 ? 'positive' : 'negative'}">${individualCommissionOver.toLocaleString('en-US', {--}}
        {{--                                                    style: 'decimal',--}}
        {{--                                                    minimumFractionDigits: 2--}}
        {{--                                                })}</span>`,--}}
        {{--                                                // Multiplier: Team--}}
        {{--                                                `<span class="${teamCommissionBase > 0 ? 'positive' : 'negative'}">${teamCommissionBase.toLocaleString('en-US', {--}}
        {{--                                                    style: 'decimal',--}}
        {{--                                                    minimumFractionDigits: 2--}}
        {{--                                                })}</span>`,--}}
        {{--                                                `<span class="${teamCommissionOver > 0 ? 'positive' : 'negative'}">${teamCommissionOver.toLocaleString('en-US', {--}}
        {{--                                                    style: 'decimal',--}}
        {{--                                                    minimumFractionDigits: 2--}}
        {{--                                                })}</span>`,--}}
        {{--                                                // Wire SPIFF: Previous Wires--}}
        {{--                                                formatCurrency(wireSpiffPrevious),--}}
        {{--                                                // Wire SPIFF: 60 Days Wires--}}
        {{--                                                formatCurrency(wireSpiffSixtyDays),--}}
        {{--                                                // Wire SPIFF: Current Period--}}
        {{--                                                formatCurrency(wireSpiffCurrentAmount),--}}
        {{--                                                `<span class="${wireSpiffCurrentPercentage > 0 ? 'positive' : 'negative'}">${wireSpiffCurrentPercentage.toFixed(2)}%</span>`, // Wire % - placeholder--}}
        {{--                                                // Wire SPIFF: Multipliers--}}
        {{--                                                formatCurrency(wireSpiffCurrent1x),--}}
        {{--                                                formatCurrency(wireSpiffCurrent2x),--}}
        {{--                                                formatCurrency(wireSpiffCurrent3x),--}}
        {{--                                                // Above Target SPIFF: Multipliers--}}
        {{--                                                formatCurrency(above_target2x),--}}
        {{--                                                formatCurrency(above_target2_5x),--}}
        {{--                                                formatCurrency(above_target3x),--}}
        {{--                                                // Lead Bonus--}}
        {{--                                                formatCurrency(leadBonus),--}}
        {{--                                                // Total--}}
        {{--                                                `<div class="total-display">--}}
        {{--                                                    <div class="total-amount total-line">Total = ${formatCurrency(total/2)}</div>--}}
        {{--                                                    <div class="total-divider"></div>--}}
        {{--                                                    <div class="bonus-amount spiff-line">+ Spiff = ${formatCurrency(wireSpiffCurrent)}</div>--}}
        {{--                                                </div>`--}}
        {{--                                            ]).draw(false);--}}
        {{--                                        });--}}
        {{--                                    }--}}
        {{--                                })--}}
        {{--                                .catch(error => {--}}
        {{--                                    console.log(error);--}}
        {{--                                    // setTimeout(() => location.reload(), 5000);--}}
        {{--                                });--}}
        {{--                        }--}}
        {{--                    }--}}

        {{--                    function formatCurrency(value, symbol = "") {--}}
        {{--                        return symbol + ' ' + parseFloat(value || 0).toLocaleString('en-US', {--}}
        {{--                            minimumFractionDigits: 2,--}}
        {{--                            maximumFractionDigits: 2--}}
        {{--                        });--}}
        {{--                    }--}}
        {{--                });--}}
        {{--            </script>--}}
        {{--            <script>--}}
        {{--                // Select/Deselect all functionality--}}
        {{--                $('#selectAllCheckbox').on('change', function () {--}}
        {{--                    $('.employee-checkbox').prop('checked', $(this).prop('checked'));--}}
        {{--                });--}}

        {{--                // Generate PDF for selected employees--}}
        {{--                $('#generateSelectedStatements').on('click', function () {--}}
        {{--                    const selectedEmployees = [];--}}

        {{--                    $('.employee-checkbox:checked').each(function () {--}}
        {{--                        const row = $(this).closest('tr');--}}
        {{--                        const employeeName = row.find('td:nth-child(4)').text().trim();--}}
        {{--                        const employeeData = row.find('.generate-statement-btn').data('employee-data');--}}

        {{--                        if (employeeData) {--}}
        {{--                            selectedEmployees.push({--}}
        {{--                                name: employeeName,--}}
        {{--                                data: employeeData--}}
        {{--                            });--}}
        {{--                        }--}}
        {{--                    });--}}

        {{--                    if (selectedEmployees.length === 0) {--}}
        {{--                        alert('Please select at least one employee');--}}
        {{--                        return;--}}
        {{--                    }--}}

        {{--                    // Generate combined PDF for all selected employees--}}
        {{--                    const pdfHtml = generateCombinedPdfHtml(selectedEmployees);--}}

        {{--                    // Open the modal--}}
        {{--                    $('#pdfStatementModalLabel').text(`Employee Commission Statements (${selectedEmployees.length})`);--}}
        {{--                    $('#pdfStatementFrame').attr('srcdoc', pdfHtml);--}}
        {{--                    $('#pdfStatementModal').modal('show');--}}
        {{--                });--}}

        {{--                // Function to generate combined PDF for multiple employees--}}
        {{--                function generateCombinedPdfHtml(employees) {--}}
        {{--                    let employeeSections = '';--}}

        {{--                    employees.forEach((employee, index) => {--}}
        {{--                        const data = employee.data;--}}
        {{--                        employeeSections += `--}}
        {{--                <div class="employee-statement" style="page-break-after: always; margin-bottom: 50px;">--}}
        {{--                    <div class="header">--}}
        {{--                        <div>--}}
        {{--                            <h2>Sales Commission Statement</h2>--}}
        {{--                        </div>--}}
        {{--                        <div class="statement-title">--}}
        {{--                            <h1>Monthly Earnings Report</h1>--}}
        {{--                            <div class="period">${new Date().toLocaleString('default', {month: 'long', year: 'numeric'})}</div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <div class="employee-info">--}}
        {{--                        <div class="info-row">--}}
        {{--                            <div class="info-label">Employee Name:</div>--}}
        {{--                            <div>${employee.name}</div>--}}
        {{--                        </div>--}}
        {{--                        <div class="info-row">--}}
        {{--                            <div class="info-label">Position:</div>--}}
        {{--                            <div>${employee.name.includes('(Lead)') ? 'Team Lead' : 'Team Member'}</div>--}}
        {{--                        </div>--}}
        {{--                        <div class="info-row">--}}
        {{--                            <div class="info-label">Statement Date:</div>--}}
        {{--                            <div>${new Date().toLocaleDateString()}</div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <!-- Rest of the employee's statement sections (same as before) -->--}}
        {{--                    <!-- Performance Summary -->--}}
        {{--                    <div class="performance-summary">--}}
        {{--                        <div class="metric-card">--}}
        {{--                            <div>Monthly Target ($)</div>--}}
        {{--                            <div class="metric-value">${data.target.toLocaleString()}</div>--}}
        {{--                        </div>--}}
        {{--                        <div class="metric-card">--}}
        {{--                            <div>Achieved ($)</div>--}}
        {{--                            <div class="metric-value positive">${data.achieved.toLocaleString()}</div>--}}
        {{--                        </div>--}}
        {{--                        <div class="metric-card">--}}
        {{--                            <div>Achievement %</div>--}}
        {{--                            <div class="metric-value positive">${data.percentage}%</div>--}}
        {{--                            <div class="progress-bar">--}}
        {{--                                <div class="progress-fill" style="width: ${Math.min(data.percentage, 100)}%"></div>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                        <div class="metric-card">--}}
        {{--                            <div>Overachievement ($)</div>--}}
        {{--                            <div class="metric-value positive">${data.overachieved.toLocaleString()}</div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}

        {{--                    <!-- Commission Breakdown -->--}}
        {{--                    <div class="section-title">Commission Breakdown</div>--}}
        {{--                    <table class="earnings-table">--}}
        {{--                        <tr>--}}
        {{--                            <th>Component</th>--}}
        {{--                            <th>Calculation</th>--}}
        {{--                            <th>Amount (₨)</th>--}}
        {{--                        </tr>--}}
        {{--                        <tr>--}}
        {{--                            <td>Individual Commission (Base)</td>--}}
        {{--                            <td>$${data.target} × 4</td>--}}
        {{--                            <td>${data.individualCommission.base.toLocaleString()}</td>--}}
        {{--                        </tr>--}}
        {{--                        <tr>--}}
        {{--                            <td>Individual Commission (Overachieved)</td>--}}
        {{--                            <td>$${data.overachieved} × 6</td>--}}
        {{--                            <td>${data.individualCommission.over.toLocaleString()}</td>--}}
        {{--                        </tr>--}}
        {{--                        ${employee.name.includes('(Lead)') ? `--}}
        {{--                        <tr>--}}
        {{--                            <td>Team Commission (Base)</td>--}}
        {{--                            <td>$${data.target} × 2</td>--}}
        {{--                            <td>${data.teamCommission.base.toLocaleString()}</td>--}}
        {{--                        </tr>--}}
        {{--                        <tr>--}}
        {{--                            <td>Team Commission (Overachieved)</td>--}}
        {{--                            <td>$${data.overachieved} × 4</td>--}}
        {{--                            <td>${data.teamCommission.over.toLocaleString()}</td>--}}
        {{--                        </tr>--}}
        {{--                        ` : ''}--}}
        {{--                        <tr class="total-row">--}}
        {{--                            <td colspan="2">Subtotal - Commissions</td>--}}
        {{--                            <td>${(data.individualCommission.base + data.individualCommission.over +--}}
        {{--                            (employee.name.includes('(Lead)') ? data.teamCommission.base + data.teamCommission.over : 0)).toLocaleString()}</td>--}}
        {{--                        </tr>--}}
        {{--                    </table>--}}

        {{--                    <!-- SPIFF Earnings -->--}}
        {{--                    <div class="section-title">SPIFF Earnings</div>--}}
        {{--                    <table class="earnings-table">--}}
        {{--                        <tr>--}}
        {{--                            <th>Component</th>--}}
        {{--                            <th>Calculation</th>--}}
        {{--                            <th>Amount (₨)</th>--}}
        {{--                        </tr>--}}
        {{--                        <tr>--}}
        {{--                            <td>Wire SPIFF - Previous Wires</td>--}}
        {{--                            <td>Calculated based on previous wires</td>--}}
        {{--                            <td>${data.wireSpiffs.previous.toLocaleString()}</td>--}}
        {{--                        </tr>--}}
        {{--                        <tr>--}}
        {{--                            <td>Wire SPIFF - Current Period</td>--}}
        {{--                            <td>Calculated based on current wires</td>--}}
        {{--                            <td>${data.wireSpiffs.current.toLocaleString()}</td>--}}
        {{--                        </tr>--}}
        {{--                        <tr>--}}
        {{--                            <td>Above Target SPIFF (Individual)</td>--}}
        {{--                            <td>$${data.overachieved} × 2</td>--}}
        {{--                            <td>${data.aboveTargetSpiffs.individual.toLocaleString()}</td>--}}
        {{--                        </tr>--}}
        {{--                        ${employee.name.includes('(Lead)') ? `--}}
        {{--                        <tr>--}}
        {{--                            <td>Above Target SPIFF (Team Lead)</td>--}}
        {{--                            <td>$${data.overachieved} × 3</td>--}}
        {{--                            <td>${data.aboveTargetSpiffs.team.toLocaleString()}</td>--}}
        {{--                        </tr>--}}
        {{--                        <tr>--}}
        {{--                            <td>Lead Bonus</td>--}}
        {{--                            <td>Calculated based on team performance</td>--}}
        {{--                            <td>${data.leadBonus.toLocaleString()}</td>--}}
        {{--                        </tr>--}}
        {{--                        ` : ''}--}}
        {{--                        <tr class="total-row">--}}
        {{--                            <td colspan="2">Subtotal - SPIFFs</td>--}}
        {{--                            <td>${(data.wireSpiffs.previous + data.wireSpiffs.current +--}}
        {{--                            data.aboveTargetSpiffs.individual +--}}
        {{--                            (employee.name.includes('(Lead)') ? data.aboveTargetSpiffs.team + data.leadBonus : 0)).toLocaleString()}</td>--}}
        {{--                        </tr>--}}
        {{--                    </table>--}}

        {{--                    <!-- Total Earnings Summary -->--}}
        {{--                    <div class="section-title">Total Earnings Summary</div>--}}
        {{--                    <table class="earnings-table">--}}
        {{--                        <tr>--}}
        {{--                            <th>Description</th>--}}
        {{--                            <th>Amount (₨)</th>--}}
        {{--                        </tr>--}}
        {{--                        <tr>--}}
        {{--                            <td>Base Salary</td>--}}
        {{--                            <td>0</td>--}}
        {{--                        </tr>--}}
        {{--                        <tr>--}}
        {{--                            <td>Total Commissions</td>--}}
        {{--                            <td>${(data.individualCommission.base + data.individualCommission.over +--}}
        {{--                            (employee.name.includes('(Lead)') ? data.teamCommission.base + data.teamCommission.over : 0)).toLocaleString()}</td>--}}
        {{--                        </tr>--}}
        {{--                        <tr>--}}
        {{--                            <td>Total SPIFFs</td>--}}
        {{--                            <td>${(data.wireSpiffs.previous + data.wireSpiffs.current +--}}
        {{--                            data.aboveTargetSpiffs.individual +--}}
        {{--                            (employee.name.includes('(Lead)') ? data.aboveTargetSpiffs.team + data.leadBonus : 0)).toLocaleString()}</td>--}}
        {{--                        </tr>--}}
        {{--                        <tr class="total-row">--}}
        {{--                            <td>Gross Payable Amount</td>--}}
        {{--                            <td>${data.total.toLocaleString()}</td>--}}
        {{--                        </tr>--}}
        {{--                        <tr>--}}
        {{--                            <td>Tax Deductions</td>--}}
        {{--                            <td>-0</td>--}}
        {{--                        </tr>--}}
        {{--                        <tr>--}}
        {{--                            <td>Other Deductions</td>--}}
        {{--                            <td>-0</td>--}}
        {{--                        </tr>--}}
        {{--                        <tr class="total-row" style="background-color: #d5f5e3;">--}}
        {{--                            <td>Net Payable Amount</td>--}}
        {{--                            <td>${data.total.toLocaleString()}</td>--}}
        {{--                        </tr>--}}
        {{--                    </table>--}}

        {{--                    <div class="footer">--}}
        {{--                        <div>Generated on: ${new Date().toLocaleDateString()}</div>--}}
        {{--                        <div style="margin-top: 40px;">--}}
        {{--                            <div class="signature-line">Authorized Signature</div>--}}
        {{--                        </div>--}}
        {{--                        <div style="margin-top: 20px;">--}}
        {{--                            <div>Sales Department</div>--}}
        {{--                            <div>Your Company Name</div>--}}
        {{--                            <div>contact@yourcompany.com | +92 300 1234567</div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            `;--}}
        {{--                    });--}}

        {{--                    return `--}}
        {{--            <!DOCTYPE html>--}}
        {{--            <html>--}}
        {{--            <head>--}}
        {{--                <style>--}}
        {{--                    body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }--}}
        {{--                    .statement-container { width: 100%; max-width: 800px; margin: 0 auto; padding: 30px; }--}}
        {{--                    .header { display: flex; justify-content: space-between; border-bottom: 2px solid #2c3e50; padding-bottom: 20px; margin-bottom: 30px; }--}}
        {{--                    .statement-title h1 { color: #2c3e50; margin: 0; font-size: 24px; }--}}
        {{--                    .period { font-size: 16px; color: #7f8c8d; }--}}
        {{--                    .employee-info { background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px; }--}}
        {{--                    .info-row { display: flex; margin-bottom: 10px; }--}}
        {{--                    .info-label { font-weight: bold; width: 150px; color: #2c3e50; }--}}
        {{--                    .performance-summary { display: flex; justify-content: space-between; margin-bottom: 30px; }--}}
        {{--                    .metric-card { flex: 1; padding: 15px; border-radius: 5px; background-color: #f8f9fa; margin: 0 10px; text-align: center; }--}}
        {{--                    .metric-value { font-size: 24px; font-weight: bold; margin: 10px 0; }--}}
        {{--                    .positive { color: #27ae60; }--}}
        {{--                    .negative { color: #e74c3c; }--}}
        {{--                    .progress-bar { height: 10px; background-color: #ecf0f1; border-radius: 5px; margin-top: 10px; overflow: hidden; }--}}
        {{--                    .progress-fill { height: 100%; background-color: #3498db; }--}}
        {{--                    .section-title { background-color: #2c3e50; color: white; padding: 10px 15px; margin: 20px 0 10px 0; border-radius: 5px; font-size: 18px; }--}}
        {{--                    .earnings-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }--}}
        {{--                    .earnings-table th { background-color: #34495e; color: white; padding: 10px; text-align: left; }--}}
        {{--                    .earnings-table td { padding: 10px; border-bottom: 1px solid #ddd; }--}}
        {{--                    .earnings-table tr:nth-child(even) { background-color: #f8f9fa; }--}}
        {{--                    .total-row { font-weight: bold; background-color: #eaf2f8 !important; }--}}
        {{--                    .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #ddd; text-align: center; font-size: 12px; color: #7f8c8d; }--}}
        {{--                    .signature-line { margin-top: 50px; border-top: 1px solid #2c3e50; width: 250px; text-align: center; padding-top: 5px; }--}}
        {{--                    .employee-statement:last-child { page-break-after: auto; }--}}
        {{--                    @media print {--}}
        {{--                        body { padding: 20px; }--}}
        {{--                        .no-print { display: none !important; }--}}
        {{--                        .employee-statement {--}}
        {{--                            page-break-after: always;--}}
        {{--                            margin-bottom: 2cm;--}}
        {{--                        }--}}
        {{--                        .employee-statement:last-child {--}}
        {{--                            page-break-after: auto;--}}
        {{--                        }--}}
        {{--                    }--}}
        {{--                </style>--}}
        {{--            </head>--}}
        {{--            <body>--}}
        {{--                <div class="statement-container">--}}
        {{--                    ${employeeSections}--}}
        {{--                </div>--}}
        {{--            </body>--}}
        {{--            </html>--}}
        {{--        `;--}}
        {{--                }--}}
        {{--            </script>--}}
    @endpush
@endsection
