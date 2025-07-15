@extends('admin.layouts.app')
@section('title','Sales KPI')
@section('datatable', true)

@section('content')
    @push('style')
        <style>
            /* Expandable rows styling */
            .details-control {
                cursor: pointer;
                text-align: center;
            }

            .expand-icon {
                font-size: 1.2em;
                color: #17a2b8;
                transition: transform 0.3s;
            }

            tr.shown .expand-icon {
                transform: rotate(180deg);
            }

            .team-details {
                background-color: #f8f9fa;
                padding: 15px;
                border-left: 4px solid #6c757d;
            }

            .team-details table {
                width: 100%;
                margin-bottom: 0;
            }

            /* Table styling */
            .text-right {
                text-align: right !important;
            }

            .font-weight-bold {
                font-weight: 700 !important;
            }

            .text-success {
                color: #28a745 !important;
            }

            .text-danger {
                color: #dc3545 !important;
            }

            /* Badges */
            .badge-lead {
                background-color: #17a2b8;
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

            /* Date range picker */
            .daterangepicker-container {
                display: inline-block;
                margin-left: 15px;
            }
        </style>
    @endpush

    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <h1 class="page-title mb-2">Sales KPI Dashboard</h1>
                <p>Commission calculations and performance metrics</p>
            </div>
        </div>

        <div class="content__boxed">
            <div class="content__wrap">
                <div class="col-lg-12 col-md-12 ">

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
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                </div>
                                <div>
                                    <button id="refreshData" class="btn btn-secondary ml-2">
                                        <i class="fas fa-sync-alt"></i> Refresh
                                    </button>
                                </div>
                            </div>

                            <table id="salesKpiTable2" class="table table-striped table-bordered" style="width:100%">
                                <thead class="thead-dark">
                                <tr>
                                    <th width="40px"></th>
                                    <th>Sales Agent</th>
                                    <th>Teams</th>
                                    <th class="text-right">Target ($)</th>
                                    <th class="text-right">Achieved ($)</th>
                                    <th class="text-right">Achieved %</th>
                                    <th class="text-right">Ind. Commission (₨)</th>
                                    <th class="text-right">Team Commission (₨)</th>
                                    <th class="text-right">Total (₨)</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/daterangepicker/daterangepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Initialize date range picker
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
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });

            // Initialize DataTable
            var table = $('#salesKpiTable2').DataTable({
                dom:
                // "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'>>" +
                    "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
                processing: false,
                serverSide: false,
                ajax: {
                    url: '{{ route("admin.sales.kpi.update.2") }}',
                    data: function (d) {
                        var dates = $('#dateRangePicker').data('daterangepicker');
                        d.start_date = dates.startDate.format('YYYY-MM-DD');
                        d.end_date = dates.endDate.format('YYYY-MM-DD');
                    },
                    dataSrc: function (json) {
                        if (json.success && json.data) {
                            return json.data;
                        } else {
                            console.error("Invalid data format:", json);
                            return [];
                        }
                    }
                },
                columns: [
                    {
                        className: 'details-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                        render: function () {
                            return '<i class="fas fa-plus-circle expand-icon"></i>';
                        }
                    },
                    {
                        data: 'name',
                        render: function (data, type, row) {
                            return data + (row?.teamsData?.is_lead ? ' <span class="badge ml-2">Lead</span>' : '');
                        }
                    },
                    {
                        data: 'teams',
                        render: function (data) {
                            return Array.isArray(data) ? data.map(t => t.name).join(', ') : (data && typeof data === 'object' ? Object.values(data).map(t => t.name).join(', ') : '---');
                        }
                    },
                    {
                        data: 'target',
                        className: 'text-right',
                        render: $.fn.dataTable.render.number(',', '.', 2, '$')
                    },
                    {
                        data: 'achieved',
                        className: 'text-right',
                        render: $.fn.dataTable.render.number(',', '.', 2, '$')
                    },
                    {
                        data: 'achieved_percentage',
                        className: 'text-right',
                        render: function (data) {
                            var cls = data >= 85 ? 'text-success' : 'text-danger';
                            return '<span class="' + cls + '">' + data.toFixed(2) + '%</span>';
                        }
                    },
                    {
                        data: 'individual_commission',
                        className: 'text-right',
                        render: function (data, type, row) {
                            return formatCurrency(data / 2, '₨') + '<br><small class="text-muted">(' + formatCurrency(data, '₨') + ')</small>';
                        }
                    },
                    {
                        data: 'total_team_commission',
                        className: 'text-right',
                        render: function (data, type, row) {
                            return formatCurrency(data / 2, '₨') + '<br><small class="text-muted">(' + formatCurrency(data, '₨') + ')</small>';
                        }
                    },
                    {
                        data: 'total_amount',
                        className: 'text-right font-weight-bold',
                        render: function (data, type, row) {
                            return formatCurrency(data / 2, '₨') + '<br><small class="text-muted">(' + formatCurrency(data, '₨') + ')</small>';
                        }
                    }
                ],
                order: [[1, 'asc']],
                createdRow: function (row, data) {
                    if (data?.teamsData?.is_lead) {
                        $(row).addClass('table-primary');
                    }
                },
                error: function (xhr, error, thrown) {
                    console.error("DataTables error:", error, thrown);
                    $('#salesKpiTable2').before(
                        '<div class="alert alert-danger">Failed to load data. Please try again.</div>'
                    );
                }
            });

            // Expand/collapse team details
            $('#salesKpiTable2 tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var icon = $(this).find('i');

                if (row.child.isShown()) {
                    row.child.hide();
                    icon.removeClass('fa-minus-circle').addClass('fa-plus-circle');
                } else {
                    var data = row.data();
                    row.child(formatDetails(data)).show();
                    icon.removeClass('fa-plus-circle').addClass('fa-minus-circle');
                }
            });

            // Refresh data when date range changes
            $('#dateRangePicker').on('apply.daterangepicker', function () {
                table.ajax.reload();
            });

            // Refresh button
            $('#refreshData').click(function () {
                table.ajax.reload();
            });

            // Export Excel
            {{--$('#exportExcel').click(function() {--}}
            {{--    var dates = $('#dateRangePicker').data('daterangepicker');--}}
            {{--    var url = '{{ route("admin.sales.kpi.export") }}?start_date=' +--}}
            {{--        dates.startDate.format('YYYY-MM-DD') + '&end_date=' +--}}
            {{--        dates.endDate.format('YYYY-MM-DD');--}}
            {{--    window.location = url;--}}
            {{--});--}}

            // Format team details for expandable rows
            // function formatDetails(d) {
            //     var html = '<div class="team-details p-3">';
            //
            //     // Individual Commission Breakdown
            //     html += '<h5 class="mb-3">Individual Commission Breakdown</h5>' +
            //         '<table class="table table-sm table-bordered mb-4">' +
            //         '<thead class="thead-light">' +
            //         '<tr>' +
            //         '<th>Type</th>' +
            //         '<th class="text-right">Amount ($)</th>' +
            //         '<th class="text-right">Multiplier</th>' +
            //         '<th class="text-right">Commission (₨)</th>' +
            //         '</tr>' +
            //         '</thead>' +
            //         '<tbody>' +
            //         '<tr>' +
            //         '<td>Up to Target</td>' +
            //         '<td class="text-right">' + formatCurrency(d.up_to_target, '$') + '</td>' +
            //         '<td class="text-right">' + (d.achieved_percentage >= 85 ? '4x' : '0x') + '</td>' +
            //         '<td class="text-right">' + formatCurrency(d.individual_4x, '₨') + '</td>' +
            //         '</tr>' +
            //         '<tr>' +
            //         '<td>Above Target</td>' +
            //         '<td class="text-right">' + formatCurrency(d.above_target, '$') + '</td>' +
            //         '<td class="text-right">' + (d.achieved_percentage >= 85 ? '6x' : '0x') + '</td>' +
            //         '<td class="text-right">' + formatCurrency(d.individual_6x, '₨') + '</td>' +
            //         '</tr>' +
            //         '<tr>' +
            //         '<td colspan="3">Amount To Disbursed</td>' +
            //         '<td class="text-right">' + formatCurrency(d.individual_commission, '₨') + '</td>' +
            //         '</tr>' +
            //         '<tr class="font-weight-bold">' +
            //         '<td colspan="3">Total Individual Commission</td>' +
            //         '<td class="text-right">' + formatCurrency(d.individual_commission/2, '₨') + '</td>' +
            //         '</tr>' +
            //         '</tbody></table>';
            //
            //     // Team Commission Breakdown (only for leads)
            //     if (d.is_lead && d.team_commissions && Object.keys(d.team_commissions).length > 0) {
            //         html += '<h5 class="mb-3">Team Commission Breakdown</h5>' +
            //             '<table class="table table-sm table-bordered mb-0">' +
            //             '<thead class="thead-light">' +
            //             '<tr>' +
            //             '<th>Team</th>' +
            //             '<th class="text-right">Target ($)</th>' +
            //             '<th class="text-right">Achieved ($)</th>' +
            //             '<th class="text-right">%</th>' +
            //             '<th class="text-right">Up to Target (2x)</th>' +
            //             '<th class="text-right">Above Target (4x)</th>' +
            //             '<th class="text-right">Amount To Disbursed (₨)</th>' +
            //             '<th class="text-right">Total Team Commission (₨)</th>' +
            //             '</tr>' +
            //             '</thead>' +
            //             '<tbody>';
            //
            //         for (var teamId in d.team_commissions) {
            //             var team = d.team_commissions[teamId];
            //             var percentageClass = team.team_achieved_percentage >= 85 ? 'text-success' : 'text-danger';
            //
            //             html += '<tr>' +
            //                 '<td>' + team.team_name + '</td>' +
            //                 '<td class="text-right">' + formatCurrency(team.team_target, '$') + '</td>' +
            //                 '<td class="text-right">' + formatCurrency(team.team_achieved, '$') + '</td>' +
            //                 '<td class="text-right ' + percentageClass + '">' + team.team_achieved_percentage.toFixed(2) + '%</td>' +
            //                 '<td class="text-right">' + formatCurrency(team.team_2x, '₨') + '</td>' +
            //                 '<td class="text-right">' + formatCurrency(team.team_4x, '₨') + '</td>' +
            //                 '<td class="text-right">' + formatCurrency(team.team_commission, '₨') + '</td>' +
            //                 '<td class="text-right">' + formatCurrency(team.team_commission / 2, '₨') + '</td>' +
            //                 '</tr>';
            //         }
            //
            //         html += '<tr class="font-weight-bold">' +
            //             '<td colspan="7">Total Commission</td>' +
            //             '<td colspan="1" class="text-right">' + formatCurrency(d.total_team_commission / 2, '₨') + '</td>' +
            //             '</tr>' +
            //             '</tbody></table>';
            //     }
            //
            //     html += '</div>';
            //     return html;
            // }
            function formatDetails(d) {
                var html = '<div class="team-details p-3">';

                // Individual Commission Breakdown
                html += '<h5 class="mb-3">Individual Commission Breakdown</h5>' +
                    '<table class="table table-sm table-bordered mb-4">' +
                    '<thead class="thead-light">' +
                    '<tr>' +
                    '<th>Type</th>' +
                    '<th class="text-right">Amount ($)</th>' +
                    '<th class="text-right">Multiplier</th>' +
                    '<th class="text-right">Commission (₨)</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>' +
                    '<tr>' +
                    '<td>Up to Target</td>' +
                    '<td class="text-right">' + formatCurrency(d.up_to_target, '$') + '</td>' +
                    '<td class="text-right">4x</td>' +
                    '<td class="text-right">' + formatCurrency(d.individual_4x, '₨') + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Above Target</td>' +
                    '<td class="text-right">' + formatCurrency(d.above_target, '$') + '</td>' +
                    '<td class="text-right">6x</td>' +
                    '<td class="text-right">' + formatCurrency(d.individual_6x, '₨') + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td colspan="3">Amount To Disbursed</td>' +
                    '<td class="text-right">' + formatCurrency(d.individual_commission, '₨') + '</td>' +
                    '</tr>' +
                    '<tr class="font-weight-bold">' +
                    '<td colspan="3">Total Individual Commission</td>' +
                    '<td class="text-right">' + formatCurrency(d.individual_commission / 2, '₨') + '</td>' +
                    '</tr>' +
                    '</tbody></table>';

                // html += '<h5 class="mb-3">Individual Commission Breakdown</h5>' +
                //     '<table class="table table-sm table-bordered mb-4">' +
                //     '<thead class="thead-light">' +
                //     '<tr>' +
                //     '<th colspan="2">User Name</th>' +
                //     '<th colspan="2" class="text-right">Target ($)</th>' +
                //     '<th colspan="2" class="text-right">Achieved ($)</th>' +
                //     '<th colspan="2" class="text-right">Achieved (%)</th>' +
                //     '<th colspan="2" class="text-right">Up to Target ($)</th>' +
                //     '<th colspan="2" class="text-right">Above Target ($)</th>' +
                //     '<th colspan="2" class="text-right">4x Multiplier (Rs)</th>' +
                //     '<th colspan="2" class="text-right">6x Multiplier (Rs)</th>' +
                //     '<th colspan="2" class="text-right">Amount To Disbursed (Rs)</th>' +
                //     '<th colspan="2" class="text-right">Total Individual Commission (Rs)</th>' +
                //     '</tr>' +
                //     '</thead>' +
                //     '<tbody>' +
                //     '<tr>' +
                //     '<td colspan="2">' + d.name + '</td>' +
                //     '<td colspan="2" class="text-right">' + formatCurrency(d.target, '$') + '</td>' +
                //     '<td colspan="2" class="text-right">' + formatCurrency(d.achieved, '$') + '</td>' +
                //     '<td colspan="2" class="text-right">' + d.achieved_percentage + '</td>' +
                //     '<td colspan="2" class="text-right">' + formatCurrency(d.up_to_target, '$') + '</td>' +
                //     '<td colspan="2" class="text-right">' + formatCurrency(d.above_target, '$') + '</td>' +
                //     '<td colspan="2" class="text-right">' + formatCurrency(d.individual_4x, '₨') + '</td>' +
                //     '<td colspan="2" class="text-right">' + formatCurrency(d.individual_6x, '₨') + '</td>' +
                //     '<td colspan="2" class="text-right">' + formatCurrency(d.individual_commission, '₨') + '</td>' +
                //     '<td colspan="2" class="text-right">' + formatCurrency(d.individual_commission / 2, '₨') + '</td>' +
                //     '</tr>' +
                //     '</tbody></table>';

                // Team Commission Breakdown (only for leads) - Now formatted like individual breakdown
                if (d.teams && Object.keys(d.teams).length > 0 && d?.teamsData?.is_lead) {
                    html += '<h5 class="mb-3">Team Commission Breakdown</h5>';

                    for (var teamId in d.teams) {
                        var team = d.teams[teamId];
                        if (team.is_lead) {
                            var percentageClass = team.percentage >= 85 ? 'text-success' : 'text-danger';

                            html += '<div class="team-member mb-4">' +
                                '<h6>' + team.name + ' (' +
                                'A ' + formatCurrency(team.achieved, '$') + ' / ' +
                                'T ' + formatCurrency(team.target, '$') + ' = ' +
                                team.percentage.toFixed(2) + '%)</h6>' + '<table class="table table-sm table-bordered mb-2">' +
                                '<thead class="thead-light">' +
                                '<tr>' +
                                '<th>Type</th>' +
                                '<th class="text-right">Amount ($)</th>' +
                                '<th class="text-right">Multiplier</th>' +
                                '<th class="text-right">Commission (₨)</th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody>' +
                                '<tr>' +
                                '<td>Up to Target</td>' +
                                '<td class="text-right">' + formatCurrency(team.percentage >= 85 ? team.target : 0, '$') + '</td>' +
                                '<td class="text-right">2x</td>' +
                                '<td class="text-right">' + formatCurrency(team?.commission?.base, '₨') + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Above Target</td>' +
                                '<td class="text-right">' + formatCurrency(team.percentage >= 85 ? (team.achieved - team.target) : 0, '$') + '</td>' +
                                '<td class="text-right">4x</td>' +
                                '<td class="text-right">' + formatCurrency(team?.commission?.above, '₨') + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td colspan="3">Amount To Disbursed</td>' +
                                '<td class="text-right">' + formatCurrency(team?.commission?.amount, '₨') + '</td>' +
                                '</tr>' +
                                '<tr class="font-weight-bold">' +
                                '<td colspan="3">Team ' + team.name + ' Commission</td>' +
                                '<td class="text-right">' + formatCurrency(team?.commission?.amount / 2, '₨') + '</td>' +
                                '</tr>' +
                                '</tbody></table></div>';

                            // html += '<table class="table table-sm table-bordered mb-4">' +
                            //     '<thead class="thead-light">' +
                            //     '<tr>' +
                            //     '<th colspan="2">Team Name</th>' +
                            //     '<th colspan="2" class="text-right">Target ($)</th>' +
                            //     '<th colspan="2" class="text-right">Achieved ($)</th>' +
                            //     '<th colspan="2" class="text-right">Achieved (%)</th>' +
                            //     '<th colspan="2" class="text-right">Up to Target ($)</th>' +
                            //     '<th colspan="2" class="text-right">Above Target ($)</th>' +
                            //     '<th colspan="2" class="text-right">4x Multiplier (Rs)</th>' +
                            //     '<th colspan="2" class="text-right">6x Multiplier (Rs)</th>' +
                            //     '<th colspan="2" class="text-right">Amount To Disbursed (Rs)</th>' +
                            //     '<th colspan="2" class="text-right">Total Individual Commission (Rs)</th>' +
                            //     '</tr>' +
                            //     '</thead>' +
                            //     '<tbody>' +
                            //     '<tr>' +
                            //     '<td colspan="2">' + team.team_name + '</td>' +
                            //     '<td colspan="2" class="text-right">' + formatCurrency(team.team_target, '$') + '</td>' +
                            //     '<td colspan="2" class="text-right">' + formatCurrency(team.team_achieved, '$') + '</td>' +
                            //     '<td colspan="2" class="text-right">' + team.team_achieved_percentage + '</td>' +
                            //     '<td colspan="2" class="text-right">' + formatCurrency(d.up_to_target, '$') + '</td>' +
                            //     '<td colspan="2" class="text-right">' + formatCurrency(d.above_target, '$') + '</td>' +
                            //     '<td colspan="2" class="text-right">' + formatCurrency(d.individual_4x, '₨') + '</td>' +
                            //     '<td colspan="2" class="text-right">' + formatCurrency(d.individual_6x, '₨') + '</td>' +
                            //     '<td colspan="2" class="text-right">' + formatCurrency(d.individual_commission, '₨') + '</td>' +
                            //     '<td colspan="2" class="text-right">' + formatCurrency(d.individual_commission / 2, '₨') + '</td>' +
                            //     '</tr>' +
                            //     '</tbody></table>';
                        }
                    }

                    // Add total team commission summary
                    html += '<div class="total-summary mb-4">' +
                        '<table class="table table-sm table-bordered mb-2">' +
                        '<tbody>' +
                        '<tr class="font-weight-bold">' +
                        '<td colspan="3" style="width: 68%;">Total Team Commission</td>' +
                        '<td class="text-right">' + formatCurrency(d?.total_team_commission / 2, '₨') + '</td>' +
                        '</tr>' +
                        '</tbody></table></div>';
                }
                // Wire Spiff Breakdown
                html += '<h5 class="mb-3">Wire Transfer Spiff Breakdown</h5>' +
                    '<table class="table table-sm table-bordered mb-4">' +
                    '<thead class="thead-light">' +
                    '<tr>' +
                    '<th>Tier</th>' +
                    '<th class="text-right">Amount ($)</th>' +
                    '<th class="text-right">Multiplier</th>' +
                    '<th class="text-right">Commission (₨)</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>' +
                    '<tr>' +
                    '<td>Basic (1x)</td>' +
                    '<td class="text-right">' + formatCurrency(d?.wire?.current?.wire1x / 1, '$') + '</td>' +
                    '<td class="text-right">1x</td>' +
                    '<td class="text-right">' + formatCurrency(d?.wire?.current?.wire1x, '₨') + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Mid (2x)</td>' +
                    '<td class="text-right">' + formatCurrency(d?.wire?.current?.wire2x / 2, '$') + '</td>' +
                    '<td class="text-right">2x</td>' +
                    '<td class="text-right">' + formatCurrency(d?.wire?.current?.wire2x, '₨') + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Premium (3x)</td>' +
                    '<td class="text-right">' + formatCurrency(d?.wire?.current?.wire3x / 3, '$') + '</td>' +
                    '<td class="text-right">3x</td>' +
                    '<td class="text-right">' + formatCurrency(d?.wire?.current?.wire3x, '₨') + '</td>' +
                    '</tr>' +
                    '<tr class="font-weight-bold">' +
                    '<td colspan="3">Total Wire Spiff</td>' +
                    '<td class="text-right">' + formatCurrency(d?.wire?.current?.commission, '₨') + '</td>' +
                    '</tr>' +
                    '</tbody></table>';

                // Above Target SPIFF Breakdown Resource
                html += `<h5 class="mb-3">Above Target Spiff Resource Breakdown</h5><table class="table table-sm table-bordered mb-4"><thead class="thead-light"><tr><th>Tier</th><th class="text-right">Threshold</th><th class="text-right">Amount ($)</th><th class="text-right">Multiplier</th><th class="text-right">Commission (₨)</th></tr></thead><tbody><tr><td>2x Bonus</td><td class="text-right">>150%</td><td class="text-right">${formatCurrency(d.above_target2x / 2, '$')}</td><td class="text-right">2x</td><td class="text-right">${formatCurrency(d.above_target2x, '₨')}</td></tr><tr><td>2.5x Bonus</td><td class="text-right">>200%</td><td class="text-right">${formatCurrency(d.above_target2_5x / 2.5, '$')}</td><td class="text-right">2.5x</td><td class="text-right">${formatCurrency(d.above_target2_5x, '₨')}</td></tr><tr><td>3x Bonus</td><td class="text-right">>250%</td><td class="text-right">${formatCurrency(d.above_target3x / 3, '$')}</td><td class="text-right">3x</td><td class="text-right">${formatCurrency(d.above_target3x, '₨')}</td></tr><tr class="font-weight-bold"><td colspan="4">Total Above Target Resource SPIFF</td><td class="text-right">${formatCurrency(d.total_bonus, '₨')}</td></tr></tbody></table>`;

                // Above Target SPIFF Breakdown Lead
                if (d?.teamsData?.is_lead) {

                    html += '<h5 class="mb-3">Above Target Spiff Lead Breakdown</h5>' +
                        '<table class="table table-sm table-bordered mb-4">' +
                        '<thead class="thead-light">' +
                        '<tr>' +
                        '<th style="width: 25.7%">Tier</th>' +
                        '<th class="text-right">Amount ($)</th>' +
                        '<th class="text-right">Multiplier</th>' +
                        '<th class="text-right">Commission (₨)</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>' +
                        '<td>3x Bonus</td>' +
                        '<td class="text-right">' + formatCurrency(d?.lead_bonus / 3, '$') + '</td>' +
                        '<td class="text-right">3x</td>' +
                        '<td class="text-right">' + formatCurrency(d?.lead_bonus, '₨') + '</td>' +
                        '</tr>' +
                        '<tr class="font-weight-bold">' +
                        '<td colspan="3">Total Above Target Lead SPIFF</td>' +
                        '<td class="text-right">' + formatCurrency(d?.lead_bonus, '₨') + '</td>' +
                        '</tr>' +
                        '</tbody></table>';
                }
                // Total Summary
                html += '<h5 class="mb-3">Total Commission Summary</h5>' +
                    '<table class="table table-sm table-bordered">' +
                    '<tbody>' +
                    '<tr class="font-weight-bold">' +
                    '<td>Individual Commission</td>' +
                    '<td class="text-right">' + formatCurrency(d.individual_commission / 2, '₨') + '</td>' +
                    '</tr>';

                if (d?.teamsData?.is_lead) {
                    html += '<tr class="font-weight-bold">' +
                        '<td>Team Commission</td>' +
                        '<td class="text-right">' + formatCurrency(d.total_team_commission / 2, '₨') + '</td>' +
                        '</tr>';
                }

                html += '<tr class="font-weight-bold">' +
                    '<td>Wire Spiff</td>' +
                    '<td class="text-right">' + formatCurrency(d.wire?.current?.commission, '₨') + '</td>' +
                    '</tr>' +
                    '<tr class="font-weight-bold">' +
                    '<td>Above Target Spiff Resource</td>' +
                    '<td class="text-right">' + formatCurrency(d.total_bonus, '₨') + '</td>' +
                    '</tr>' +
                    (d?.teamsData?.is_lead ?
                    '<tr class="font-weight-bold">' +
                    '<td>Above Target Spiff Lead</td>' +
                    '<td class="text-right">' + formatCurrency(d.lead_bonus, '₨') + '</td>' +
                    '</tr>':""
                    ) +
                    '<tr class="font-weight-bold table-primary">' +
                    '<td>Total Amount To Disburse</td>' +
                    '<td class="text-right">' +
                    formatCurrency((d.individual_commission + d.total_team_commission) / 2, '₨') +
                    ' + ' +
                    formatCurrency(d.wire?.current?.commission + d.total_bonus + d.lead_bonus, '₨') +
                    ' Spiff' +
                    '</td>' +
                    '</tr>' +
                    '</tbody></table>';

                html += '</div>';
                return html;
            }
            function formatCurrency(value, symbol) {
                return symbol + ' ' + parseFloat(value || 0).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        });
    </script>
@endpush
