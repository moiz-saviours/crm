@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')
    @push('style')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            .btn-minimize {
                background-color: #ff5722;
                color: #fff;
                font-size: 12px;
            }

            .btn-minimize:hover {
                background-color: #ff5722;
                color: #fff;
            }

            .clos_btn {
                background-color: var(--bs-primary);
                color: #fff;
                font-size: 12px;
            }

            .clos_btn:hover {
                background-color: var(--bs-primary);
                color: #fff;
            }

            .right_col {
                display: block;
            }

            .right_col .card {
                margin: 20px 0px;
            }

            .dashbord_tbl {
                border-collapse: collapse;
                width: 100%;
            }

            .tabl_th {
                background-color: var(--bs-primary);
                text-align: center;
                padding: 15px 0px;
                color: #fff;
            }

            .tabl_td, .tabl_th {
                text-align: left;
                padding: 15px 0px;
                text-align: center;
            }

            .tabl_tr:nth-child(odd) {
                background-color: #98a3b0;
                color: #fff;
            }

            .tabl_tr:nth-child(even) {
                background-color: #fff;
                color: #000 !important;
            }

            /*New Dashboard Style*/
            .main-dashboard-header {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                /*padding: 12px 10px;*/
                margin-top: -90px;
                gap: 12px;
            }

            .main-dashboard-heading {
                font-size: 16px;
                color: #000;
                /* font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; */
                font-weight: 500;
            }

            .main-date-input {
                border: solid #ccc;
                border-width: 0px 0px 1px;
                background: transparent;
                font-size: 15px;
                min-width: 147px;
            }

            .tabular-main-box {
                padding: 9px 0px;
                /*box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;*/
                background-color: #b6bbc200;
                margin: 12px 0px;
                border-radius: 8px;

            }

            .sales-number-div {
                background-color: #fff;
                /* text-align: center; */
                border-radius: 7px;
                padding: 21px 12px;
                height: 100%;

            }

            .sales-total-heading {
                color: var(--bs-primary);
                font-size: 14px;
            }

            .sales-number-div p {
                margin: 0;
                font-size: 13px;
                color: #000;
            }

            .slider {
                -webkit-appearance: none;
                width: 100%;
                height: 25px;
                background: #d3d3d3;
                outline: none;
                opacity: 0.7;
                -webkit-transition: .2s;
                transition: opacity .2s;
            }

            .slider:hover {
                opacity: 1;
            }

            .slider::-webkit-slider-thumb {
                -webkit-appearance: none;
                appearance: none;
                width: 25px;
                height: 25px;
                background: var(--bs-primary);
                cursor: pointer;
            }

            .slider::-moz-range-thumb {
                width: 25px;
                height: 25px;
                background: var(--bs-primary);
                cursor: pointer;
            }

            .mtd-hedaing {
                font-size: 15px;
                color: #ccc;
            }

            .Acheived-numbers {
                color: green;
            }

            table th {
                font-size: 0.813rem !important;
                color: #000;

                text-transform: capitalize;
            }

            table td,
            tr {
                font-size: 10px !important;

            }

            .sales-record-table-container {
                height: 638px !important;
                /*overflow-y: scroll !important;*/
            }

            .sales-record-table-container::-webkit-scrollbar {
                width: 8px;
                /* width of the entire scrollbar */
            }

            .sales-record-table-container::-webkit-scrollbar-track {
                background: #fff;
                /* color of the tracking area */
            }

            .sales-record-table-container::-webkit-scrollbar-thumb {
                background-color: var(--bs-primary);
                /* color of the scroll thumb */
                /* border-radius: 20px; */
                /* roundness of the scroll thumb */
                /* border: 3px solid orange; */
                /* creates padding around scroll thumb */
            }

            .sales-record-table tbody,
            td,
            tfoot,
            th,
            thead {
                border: none;
            }

            .sales-record-table-row {
                /*box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;*/
                /* box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgb(14 30 37 / 29%) 0px 2px 16px 0px; */
            }

            .sales-record-table {
                /*background-color: #fff;*/
                border: none !important;
                /*border-collapse: separate;*/
                /*border-spacing: 0 10px;*/
                /*padding: 9px 6px;*/
                border-radius: 7px;
            }

            .table-headings {
            }

            .monthly-sales-record-table {
                box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
                /*box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;*/
            }

            .monthly-sales-record-table tr:nth-child(even) {
                background-color: #fff !important;
                color: #000 !important;
            }

            .monthly-sales-record-table-row {
                background-color: #fff;
            }

            .progress-bar-wrapper {
                display: flex;
                justify-content: space-between;
                align-items: baseline;
            }

            /* DATATABLE */
            div.dt-container div.dt-length {
                padding: 10px 0px 0px 10px;
            }

            div.dt-container div.dt-search {
                padding: 10px 10px 0 0;
            }

            div.dt-container div.dt-info {
                padding: 10px 10px 10px 10px;
            }

            div.dt-container div.dt-paging {
                padding: 0px 10px 0 0;
            }
            .dsh_btn {
                display: flex;
            }

            /* DATATABLE */
        </style>
    @endpush
    <section id="content" class="content ">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <!-- Page title and information -->
                <button class="start-tour-btn my-btn tour-dashboard2-alldata" data-bs-toggle="tooltip" data-bs-placement="top" title="Take a Tour"
                        data-tour="dashboard2"><i class="fas fa-exclamation-circle custom-dot"></i></button>
                <h1 class="page-title mb-2 all-data">Stats Dashboard</h1>
                {{--                <h2 class="h5">Welcome to the Stats Dashboard.</h2>--}}
                <p>Welcome to the Stats Dashboard.</p>
                {{--                <!-- END : Page title and information -->--}}
            </div>
        </div>
        <div class="content__boxed">
            <div class="content__wrap">

                <!-- new dashboard content start -->


                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-dashboard-header">
                                <h2 class="main-dashboard-heading"></h2>
                                <div class="form-group tour-team-select">
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
                                <div class="form-group tour-timezone-select">
                                    <label for="timeZoneSelect">Select TimeZone:</label>
                                    <select id="timeZoneSelect" name="timeZoneSelect" class="form-control">
                                        <!-- UTC/GMT -->
                                        <option value="UTC" selected>UTC (Coordinated Universal Time)</option>
                                        <option value="GMT">GMT (Greenwich Mean Time)</option>

                                        <!-- United States Timezones -->
                                        <optgroup label="United States">
                                            <!-- Eastern Time -->
                                            <option value="America/New_York">Eastern Time (ET) - New York</option>
                                            <option value="America/Detroit">Eastern Time (ET) - Detroit</option>

                                            <!-- Central Time -->
                                            <option value="America/Chicago">Central Time (CT) - Chicago</option>
                                            <option value="America/Mexico_City">Central Time (CT) - Mexico City</option>

                                            <!-- Mountain Time -->
                                            <option value="America/Denver">Mountain Time (MT) - Denver</option>
                                            <option value="America/Phoenix">Mountain Time (MT - No DST) - Phoenix</option>

                                            <!-- Pacific Time -->
                                            <option value="America/Los_Angeles">Pacific Time (PT) - Los Angeles</option>
                                            <option value="America/Tijuana">Pacific Time (PT) - Tijuana</option>

                                            <!-- Other US Zones -->
                                            <option value="America/Anchorage">Alaska Time (AKT) - Anchorage</option>
                                            <option value="Pacific/Honolulu">Hawaii Time (HST) - Honolulu</option>
                                        </optgroup>

                                        <!-- United Kingdom Timezones -->
                                        <optgroup label="United Kingdom">
                                            <option value="Europe/London">London (GMT/BST)</option>
                                            <option value="Europe/Belfast">Belfast (GMT/BST)</option>
                                            <option value="Europe/Guernsey">Guernsey (GMT/BST)</option>
                                            <option value="Europe/Isle_of_Man">Isle of Man (GMT/BST)</option>
                                            <option value="Europe/Jersey">Jersey (GMT/BST)</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="form-group tour-date-select">
                                    <label for="dateRangePicker">Select Date Range:</label>
                                    <input type="text" id="dateRangePicker" name="dateRangePicker"
                                           class="form-control dateRangePicker"/>
                                </div>

                                {{--                                <input type="date" id="start" name="trip-start" value="2018-07-22" min="2018-01-01"--}}
                                {{--                                       max="2018-12-31" class="main-date-input"/>--}}

                            </div>
                        </div>

                        <div class="tabular-main-box">
                            <div class="row">
                                <div class="col-lg-2 col-md-2 tour-totalsales-select">
                                    <div class="sales-number-div text-center">
                                        <h2 class="sales-total-heading">Total Sales</h2>
                                        <p id="total-sales-count" class="total-sales-count"> $0 </p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 tour-totalcash-select">
                                    <div class="sales-number-div text-center">
                                        <h2 class="sales-total-heading">Total Cash</h2>
                                        <p id="total-cash-count" class="total-sales-count"> $0 </p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 tour-refund-select">
                                    <div class="sales-number-div text-center">
                                        <h2 class="sales-total-heading">Refunds / Chargeback</h2>
                                        <p id="refund-charge-back" class="total-sales-count"> $0 / $0 </p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 tour-charge-select">
                                    <div class="sales-number-div text-center">
                                        <h2 class="sales-total-heading">Chargeback Ratio</h2>
                                        <p id="charge-back-ratio" class="total-sales-count"> 0 % </p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 tour-reversals-select">
                                    <div class="sales-number-div text-center">
                                        <h2 class="sales-total-heading">Reversals</h2>
                                        <p id="reversal-sales-count" class="total-sales-count"> $0 </p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 tour-netcash-select">
                                    <div class="sales-number-div text-center">
                                        <h2 class="sales-total-heading">Net Cash</h2>
                                        <p id="net-cash-count" class="total-sales-count"> $0 </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3 ">
                                <div class="col-lg-5">
                                    <div class="row ">
                                        <div class="col-lg-6">
                                            <div class="sales-number-div tour-targetvsachieved-select">
                                                <h2 class="sales-total-heading">Targeted Vs Achieved</h2>
                                                <!-- Total Target -->
                                                <p id="total-target-vs-total-achieved" class="total-sales-count">$0 /
                                                    $0</p>
                                                <!-- Progress Bar -->
                                                <div id="total-target-progress-bar-wrapper"
                                                     class="progress-bar-wrapper">
                                                    <div>
                                                        <div class="progress" style="width: 150px;">
                                                            <div id="total-target-progress-bar"
                                                                 class="progress-bar progress-bar-animated bg-primary"
                                                                 role="progressbar" style="width: 0%"
                                                                 aria-valuenow="0"
                                                                 aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Progress Percentage Text -->
                                                    <p id="total-target-progress-text">0%</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 tour-mtd-select">
                                            <div class="sales-number-div">
                                                <h2 class="mtd-hedaing">MTD/LA</h2>
                                                <p class="total-sales-count">
                                                    <span id="mtd-sales">0</span> /
                                                    <span class="achieved-numbers" id="lapse-percentage">
                                                        0
                                                    </span>
                                                    <i id="lapse-icon" class="fas fa-arrow-trend-up"></i>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-lg-6  mt-3 tour-upsell-select">
                                            <div class="sales-number-div">
                                                <h2 class="mtd-hedaing">UPSELL</h2>
                                                <p class="total-sales-count" id="total-upsell"> $0
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-lg-6  mt-3 tour-account-select">
                                            <div class="sales-number-div">
                                                <h2 class="mtd-hedaing">Accounts</h2>
                                                <p class="total-sales-count"> 0
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mt-3 tour-teamrecord-select">
                                            <table class="table table-striped initTable" id="teamRecordsTable">
                                                <thead>
                                                <tr class="monthly-sales-record-table-row ">
                                                    <th scope="col">Team</th>
                                                    <th scope="col">Month</th>
                                                    <th scope="col">Target</th>
                                                    <th scope="col">Target Acheived</th>
                                                    <th scope="col">Acheived %</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>Total Teams</th>
                                                    <th>Total Months</th>
                                                    <th>Sum of Targets</th>
                                                    <th>Sum of Achieved</th>
                                                    <th>Average %</th>
                                                </tr>
                                                </tfoot>
                                                <tbody></tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-lg-7 col-md-12 tour-userecord-select">
                                    {{--                                    <div class="sales-record-table-container">--}}
                                    {{--                                    <div class="sales-record-table-container monthly-sales-record-table">--}}
                                    <table class="table table-striped dashbord_tbl initTable"
                                           id="employeeRecordsTable">
                                        <thead>
                                        <tr class="monthly-sales-record-table-row ">
                                            <th class="table-headings">Name</th>
                                            <th class="table-headings">Team</th>
                                            <th class="table-headings">Target</th>
                                            <th class="table-headings">Sales</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>Total Employees</th>
                                            <th>Total Teams</th>
                                            <th>Sum of Targets</th>
                                            <th>Sum of Sales</th>
                                        </tr>
                                        </tfoot>
                                        <tbody></tbody>
                                    </table>
                                    {{--                                    </div>--}}

                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <!-- new dashboard content end -->
            </div>
        </div>


    </section>

    @push('script')
        <script>
            // Bar Chart
            if ($(".barchart").length > 0) {
                var options = {
                    series: [{
                        name: 'Team A',
                        type: 'column',
                        data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6]
                    }, {
                        name: 'Team B',
                        type: 'column',
                        data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
                    }, {
                        name: 'Team C',
                        type: 'column',
                        data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
                    },],
                    chart: {
                        height: 350,
                        type: 'line',
                        stacked: false
                    },
                    colors: ['var(--bs-primary)', '#ff5722', '#98a3b0'], // Custom colors for series
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: [1, 1, 1]
                    },

                    xaxis: {
                        categories: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016],
                    },

                    tooltip: {
                        fixed: {
                            enabled: true,
                            position: 'topLeft',
                            offsetY: 30,
                            offsetX: 60
                        },
                    },

                };
                var barchart = new ApexCharts($(".barchart")[0], options);
                barchart.render();
            }
            // Bar Chart

            // Area Chart
            if ($(".areachart").length > 0) {
                var options = {
                    series: [{
                        name: 'TEAM A',
                        type: 'area',
                        data: [44, 55, 31, 47, 31, 43, 26, 41, 31, 47, 33, 60]
                    }, {
                        name: 'TEAM B',
                        type: 'line',
                        data: [55, 69, 45, 61, 43, 54, 37, 52, 44, 61, 43, 60]
                    }],
                    chart: {
                        height: 350,
                        type: 'line',
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    fill: {
                        type: 'solid',
                        opacity: [0.35, 1],
                    },

                    colors: ['var(--bs-primary)', '#ff5722'],
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

                    tooltip: {
                        shared: true,
                        intersect: false,

                    }
                };
                var areachart = new ApexCharts($(".areachart")[0], options);
                areachart.render();
            }
            // Area Chart

            //Pie Chart
            if ($(".pieChart").length > 0) {
                var options = {
                    series: [44, 55, 60],
                    chart: {
                        type: 'pie',
                        toolbar: {
                            show: true,
                        },
                    },
                    colors: ['var(--bs-primary)', '#ff5722', '#98a3b0'],
                    labels: ['Team A', 'Team B', 'Team C'],
                    legend: {
                        position: 'right',
                    },

                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 300
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };
                var pieChart = new ApexCharts($(".pieChart")[0], options);
                pieChart.render();
            }
            //Pie Chart

            //Donut Chart
            if ($(".donutchart").length > 0) {
                var options = {
                    series: [44, 55, 60],
                    chart: {
                        type: 'donut',
                        toolbar: {
                            show: true,
                        },
                    },

                    colors: ['var(--bs-primary)', '#ff5722', '#98a3b0'],
                    labels: ['Team A', 'Team B', 'Team C'],

                    legend: {
                        position: 'right',
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 300
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };
                var donutchart = new ApexCharts($(".donutchart")[0], options);
                donutchart.render();
            }
            //Donut Chart

            //Radial Chart
            if ($(".radialchart").length > 0) {
                var options = {
                    series: [50, 55, 75], // Restricting to 3 values
                    chart: {

                        type: 'radialBar',
                        toolbar: {
                            show: true, // Toolbar enabled for download
                            tools: {
                                download: true // Allow chart download
                            }
                        },
                    },
                    colors: ['var(--bs-primary)', '#ff5722', '#98a3b0'], // Custom colors
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                size: '30%',
                            },
                            track: {
                                strokeWidth: '50%',
                            },
                            dataLabels: {
                                name: {
                                    fontSize: '22px',
                                },
                                value: {
                                    fontSize: '16px',
                                },
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function (w) {
                                        return 166; // Total of 3 series values
                                    }
                                }
                            }
                        }
                    },
                    labels: ['Apples', 'Oranges', 'Bananas'], // Only 3 labels

                };
                var radialchart = new ApexCharts($(".radialchart")[0], options);
                radialchart.render();
            }
            //Radial Chart

        </script>

        <!-- Date Range Picker -->
        <script src="{{asset('assets/js/moment.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/daterangepicker/daterangepicker.min.js')}}"></script>
        <script>
            $(document).ready(function () {
                const dataTables = [];
                if ($('.initTable').length) {
                    $('.initTable').each(function (index) {
                        dataTables[index] = initializeDatatable($(this), index)
                    })
                }

                function initializeDatatable(table_div, index) {
                    let parentHeight = table_div.parent().height();
                    let tableId = table_div.attr('id');

                    let datatable = table_div.DataTable({
                        dom:
                            "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        order: [[1, 'desc']],
                        responsive: false,
                        scrollX: true,
                        scrollY: tableId === "employeeRecordsTable" ? "500px" : parentHeight ? parentHeight - 145 + "px" : "500px",
                        scrollCollapse: true,
                        paging: true,
                        pageLength: tableId === "teamRecordsTable" ? 5 : 10,
                        lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],

                    });

                    return datatable;
                }
                $('#dateRangePicker').daterangepicker({
                    timePicker: true,
                    timePicker24Hour: false,
                    timePickerIncrement: 1,
                    locale: {
                        format: 'YYYY-MM-DD h:mm:ss A',
                    },
                    startDate: moment().startOf('month').startOf('day'),    // First moment of first day of month
                    endDate: moment().endOf('month').endOf('day'),         // Last moment of last day of month
                    ranges: {
                        'Today': [
                            moment().startOf('day').set({hour: 0, minute: 0}), // 12:00 AM
                            moment().endOf('day').set({hour: 23, minute: 59, second: 59})  // 11:59:59 PM
                        ],
                        'Yesterday': [
                            moment().subtract(1, 'days').startOf('day').set({hour: 0, minute: 0}), // 12:00 AM
                            moment().subtract(1, 'days').endOf('day').set({hour: 23, minute: 59, second: 59})   // 11:59:59 PM
                        ],
                        'Last 7 Days': [
                            moment().subtract(6, 'days').startOf('day').set({hour: 0, minute: 0}), // 12:00 AM
                            moment().endOf('day').set({hour: 23, minute: 59, second: 59})                       // 11:59:59 PM
                        ],
                        'Last 30 Days': [
                            moment().subtract(29, 'days').startOf('day').set({hour: 0, minute: 0}), // 12:00 AM
                            moment().endOf('day').set({hour: 23, minute: 59, second: 59})                        // 11:59:59 PM
                        ],
                        'This Month': [
                            moment().startOf('month').set({hour: 0, minute: 0}), // 12:00 AM
                            moment().endOf('month').set({hour: 23, minute: 59, second: 59})  // 11:59:59 PM
                        ],
                        'Last Month': [
                            moment().subtract(1, 'month').startOf('month').set({hour: 0, minute: 0}), // 12:00 AM
                            moment().subtract(1, 'month').endOf('month').set({hour: 23, minute: 59, second: 59})   // 11:59:59 PM
                        ],
                        'Current Quarter': [
                            moment().startOf('quarter').set({hour: 0, minute: 0}), // 12:00 AM
                            moment().endOf('quarter').set({hour: 23, minute: 59, second: 59})   // 11:59:59 PM
                        ],
                        'Last Quarter': [
                            moment().subtract(1, 'quarter').startOf('quarter').set({hour: 0, minute: 0}), // 12:00 AM
                            moment().subtract(1, 'quarter').endOf('quarter').set({hour: 23, minute: 59, second: 59})   // 11:59:59 PM
                        ],
                        'This Year': [
                            moment().startOf('year').set({hour: 0, minute: 0}), // 12:00 AM
                            moment().endOf('day').set({hour: 23, minute: 59, second: 59})    // 11:59:59 PM
                        ],
                        'Last Year': [
                            moment().subtract(1, 'year').startOf('year').set({hour: 0, minute: 0}), // 12:00 AM
                            moment().subtract(1, 'year').endOf('year').set({hour: 23, minute: 59, second: 59})   // 11:59:59 PM
                        ],
                    }
                });

                const startDate = moment().startOf('month').format('YYYY-MM-DD h:mm:ss A');
                const endDate = moment().endOf('month').format('YYYY-MM-DD h:mm:ss A');
                const timeZoneSelect = $('#timeZoneSelect').val();
                const teamKey = 'all';
                const brandKey = 'all';

                fetchData(startDate, endDate, timeZoneSelect, teamKey, brandKey);

                // Listen to 'apply' event and send the selected date range
                // $('#dateRangePicker').on('apply.daterangepicker', function (ev, picker) {
                //     var startDate = picker.startDate.format('YYYY-MM-DD');
                //     var endDate = picker.endDate.format('YYYY-MM-DD');
                //     const timeZoneSelect = $('#timeZoneSelect').val();
                //     fetchData(startDate, endDate,timeZoneSelect, teamKey, brandKey);
                // });

                // Listen to 'cancel' event and clear the date range
                $('#dateRangePicker').on('cancel.daterangepicker', function () {
                    fetchData('', '', '', '', '');
                });

                $('#dateRangePicker,#timeZoneSelect, #teamSelect, #brandSelect').on('change', function () {
                    const startDate = $('#dateRangePicker').data('daterangepicker').startDate.format('YYYY-MM-DD h:mm:ss A');
                    const endDate = $('#dateRangePicker').data('daterangepicker').endDate.format('YYYY-MM-DD h:mm:ss A');
                    const teamKey = $('#teamSelect').val();
                    const brandKey = $('#brandSelect').val();
                    const timeZoneSelect = $('#timeZoneSelect').val();
                    fetchData(startDate, endDate, timeZoneSelect, teamKey, brandKey);
                });

                // Function to send AJAX request with date range
                function fetchData(startDate, endDate, timeZoneSelect = "UTC", teamKey = 'all', brandKey = 'all') {
                    let url = `{{ route("admin.dashboard.2.update.stats") }}`;
                    if (startDate && endDate && teamKey) {
                        let table = dataTables[0];
                        AjaxRequestPromise(url, {
                            start_date: startDate,
                            end_date: endDate,
                            timeZoneSelect: timeZoneSelect,
                            team_key: teamKey,
                            brand_key: brandKey
                        }, 'GET')
                            .then(response => {
                                if (response.success) {
                                    animateNumericValue($('#mtd-sales'), 0, parseFloat(response.mtd_total_sales), 1000, '$');
                                    const lapsePercentage = parseFloat(response.lapse_percentage);
                                    animateNumericValue($('#lapse-percentage'), 0, lapsePercentage, 1000, '', '%', 2);
                                    const lapseIcon = $('#lapse-icon');
                                    if (lapsePercentage >= 0) {
                                        lapseIcon.removeClass('fa-arrow-trend-down').addClass('fa-arrow-trend-up').css('color', 'green')
                                    } else {
                                        lapseIcon.removeClass('fa-arrow-trend-up').addClass('fa-arrow-trend-down').css('color', 'red')
                                    }
                                    animateNumericValue($('#total-sales-count'), 0, parseFloat(response.total_sales), 1000, '$');
                                    animateNumericValue($('#total-cash-count'), 0, parseFloat(response.total_sales), 1000, '$');
                                    const refunded = parseFloat(response.refunded);
                                    const chargeBack = parseFloat(response.charge_back);
                                    animateNumericValue($('#refund-charge-back'), 0, refunded, 1000, '$', ` / $${chargeBack.toLocaleString()}`);

                                    animateNumericValue($('#charge-back-ratio'), 0, parseFloat(response.charge_back_ratio), 1000, '', '%', 2);

                                    animateNumericValue($('#reversal-sales-count'), 0, parseFloat(response.reversal), 1000, '$');
                                    animateNumericValue($('#net-cash-count'), 0, parseFloat(response.net_sales), 1000, '$');

                                    let employees_table = dataTables.filter(dt => dt.table().node().id === 'employeeRecordsTable')[0];
                                    employees_table.clear().draw();
                                    response.employees.forEach(employee => {
                                        employees_table.row.add($(`
                                        <tr>
                                            <td>${employee.name}</td>
                                            <td>
                                                ${employee.teams && employee.teams.length > 0
                                            ? employee.teams.map(team => team.name).join(', ')
                                            : 'No Team Assigned'}
                                            </td>
                                            <td>$${employee.target ?? 0}</td>
                                            <td>$${parseFloat(employee.sales).toFixed(2)}</td>
                                        </tr>
                                    `)).draw(false);
                                    });

                                    let teams_table = dataTables.filter(dt => dt.table().node().id === 'teamRecordsTable')[0];
                                    teams_table.clear().draw();
                                    const monthNames = [
                                        "January", "February", "March", "April", "May", "June",
                                        "July", "August", "September", "October", "November", "December"
                                    ];

                                    const allTargets = [];

                                    for (const teamKey in response.team_targets) {
                                        const yearData = response.team_targets[teamKey];
                                        for (const year in yearData) {
                                            const monthData = yearData[year];
                                            for (const month in monthData) {
                                                allTargets.push(monthData[month]);
                                            }
                                        }
                                    }

                                    allTargets.sort((a, b) => {
                                        const dateA = new Date(a.year, a.month - 1); // JS months are 0-based
                                        const dateB = new Date(b.year, b.month - 1);
                                        return dateB.getTime() - dateA.getTime();
                                    });

                                    allTargets.forEach(target => {
                                        teams_table.row.add($(`
                                            <tr>
                                                <td>${target.team_name}</td>
                                                <td>${monthNames[target.month - 1] || ""} ${target.year ?? "---"}</td>
                                                <td>$${target.target_amount.toFixed(2).toLocaleString()}</td>
                                                <td>$${target.achieved.toLocaleString()}</td>
                                                <td>${target.achieved_percentage}%</td>
                                            </tr>
                                        `)).draw(false);
                                    });

                                    const totalTarget = response.total_target || 0;
                                    const totalAchieved = response.total_target_achieved || 0;
                                    const totalAchievedPercentage = response.total_achieved_percentage || 0;
                                    const totalUpSales = response.totalUpSales || 0;

                                    function animateTwoValues(element, start1, end1, start2, end2, duration) {
                                        let startTimestamp = null;
                                        const step = (timestamp) => {
                                            if (!startTimestamp) startTimestamp = timestamp;
                                            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                                            const value1 = Math.floor(progress * (end1 - start1) + start1);
                                            const value2 = Math.floor(progress * (end2 - start2) + start2);
                                            element.text(`$${value1.toLocaleString()} / $${value2.toLocaleString()}`);
                                            if (progress < 1) {
                                                window.requestAnimationFrame(step);
                                            }
                                        };
                                        window.requestAnimationFrame(step);
                                    }

                                    const totalTargetAchievedElement = $('#total-target-vs-total-achieved');
                                    animateTwoValues(totalTargetAchievedElement, 0, totalAchieved, 0, totalTarget, 1000);

                                    const progressBar = $('#total-target-progress-bar');
                                    let currentPercentage = 0;
                                    const progressInterval = setInterval(() => {
                                        if (currentPercentage >= totalAchievedPercentage) {
                                            clearInterval(progressInterval);
                                        } else {
                                            currentPercentage += 1;
                                            progressBar.css('width', `${currentPercentage}%`);
                                            progressBar.attr('aria-valuenow', currentPercentage);
                                            $('#total-target-progress-text').text(`${currentPercentage.toFixed(2)}%`);
                                        }
                                    }, 20);

                                    animateNumericValue($('#total-upsell'), 0, totalUpSales, 1000, '$');
                                }
                            })
                            .catch(error => {
                                console.log(error);
                                // setTimeout(() => location.reload(), 5000);
                            });
                    }
                }

                function animateNumericValue(element, start, end, duration, prefix = '', suffix = '', toFixed = 0) {
                    let startTimestamp = null;
                    const step = (timestamp) => {
                        if (!startTimestamp) startTimestamp = timestamp;
                        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                        let value = start + progress * (end - start);
                        if (toFixed && toFixed > 0) {
                            value = parseFloat(value.toFixed(toFixed));
                        } else {
                            value = Math.floor(value);
                        }
                        value = value.toLocaleString();
                        element.text(`${prefix}${value}${suffix}`);
                        if (progress < 1) {
                            window.requestAnimationFrame(step);
                        }
                    };
                    window.requestAnimationFrame(step);
                }
            });
        </script>
        <!-- Date Range Picker -->

    @endpush
@endsection
