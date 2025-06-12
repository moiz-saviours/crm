@extends('admin.layouts.app')
@section('title','Sales Kpi')
@section('datatable', true)

@section('content')
    @push('style')
        <style>


            .table-headings {
                background-color: #fff !important;
                text-align: left!important;
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
                font-weight: 500;
            }

            .main-date-input {
                border: solid #ccc;
                border-width: 0px 0px 1px;
                background: transparent;
                font-size: 15px;
                min-width: 147px;
            }
            .new_tbl td {
               text-align: left!important;
            }


        </style>
    @endpush

    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <!-- Page title and information -->
                <h1 class="page-title mb-2 all-data">Sales Kpi</h1>
                {{--                <h2 class="h5">Welcome to the Stats Dashboard.</h2>--}}
                <p>Welcome to Sales Kpi.</p>
                {{--                <!-- END : Page title and information -->--}}


{{--                <button class="start-tour-btn my-btn tour-dashboard2-alldata" data-toggle="tooltip" title="Take a Tour" data-tour="dashboard2"> <i class="fas fa-exclamation-circle custom-dot"></i> </button>--}}

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

                                <div class="form-group ">
                                    <label for="dateRangePicker">Select Date Range:</label>
                                    <input type="text" id="dateRangePicker" name="dateRangePicker"
                                           class="form-control dateRangePicker"/>
                                </div>

                                {{--                                <input type="date" id="start" name="trip-start" value="2018-07-22" min="2018-01-01"--}}
                                {{--                                       max="2018-12-31" class="main-date-input"/>--}}

                            </div>
                        </div>
                    </div>

                </div>


                <div class="col-lg-12 col-md-12 ">
                    {{--                                    <div class="sales-record-table-container">--}}
                    {{--                                    <div class="sales-record-table-container monthly-sales-record-table">--}}
                    <table class="table table-striped initTable new_tbl"
                           id="employeeSalesTable">
                        <thead>
                        <tr class="monthly-sales-record-table-row ">
                            <th class="table-headings">Name</th>
                            <th class="table-headings">Team</th>
                            <th class="table-headings">Target</th>
                            <th class="table-headings">Achieved Amount</th>
                            <th class="table-headings">MTD</th>
                            <th class="table-headings">Lapse</th>
                            <th class="table-headings">Qualified</th>
                            <th class="table-headings">Commission Amount</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>Alex</td>
                            <td>Team One</td>
                            <td>$5000</td>
                            <td>3000</td>
                            <td>2000</td>
                            <td>20%</td>
                            <td>2.00%</td>
                            <td>$2500</td>
                        </tr>
                        <tr>
                            <td>Alex</td>
                            <td>Team One</td>
                            <td>$5000</td>
                            <td>3000</td>
                            <td>2000</td>
                            <td>20%</td>
                            <td>2.00%</td>
                            <td>$2500</td>
                        </tr>
                        <tr>
                            <td>Alex</td>
                            <td>Team One</td>
                            <td>$5000</td>
                            <td>3000</td>
                            <td>2000</td>
                            <td>20%</td>
                            <td>2.00%</td>
                            <td>$2500</td>
                        </tr>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>


    </section>
@push('script')
    <!-- Date Range Picker -->
    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/daterangepicker/daterangepicker.min.js')}}"></script>

    <script>
        var dataTables = [];

        /** Initializing Datatable */
        if ($('.initTable').length) {
            $('.initTable').each(function (index) {
                dataTables[index] = initializeDatatable($(this), index)
            })
        }

        function initializeDatatable(table_div, index) {
            let datatable = table_div.DataTable({
                dom:
                    "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
                order: [[1, 'desc']],
                responsive: false,
                scrollX: true,
                scrollY: ($(window).height() - 350),
                scrollCollapse: true,
                paging: true,
                pageLength: 25,
                lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
            });
            datatable.columns.adjust().draw()
            return datatable;
        }

        $('.modal').on('shown.bs.modal', function () {
            let table = $(this).find('.initTable');
            if (table.length) {
                let datatable = table.DataTable();
                if (datatable) {
                    datatable.columns.adjust().draw();
                }
            }
        });
        $('#dateRangePicker').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            startDate: moment().startOf('month'), // Default start date (beginning of current month)
            endDate: moment().endOf('month'), // Default end date (end of current month)
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
    </script>
@endpush
@endsection
