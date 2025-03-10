@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')
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
            background-color: #2d3e50;
            color: #fff;
            font-size: 12px;
        }

        .clos_btn:hover {
            background-color: #2d3e50;
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
            background-color: #2d3e50;
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
    </style>
    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <!-- Page title and information -->
                <h1 class="page-title mb-2">Dashboard</h1>
                <h2 class="h5">Welcome to the CRM Dashboard.</h2>
                <!-- END : Page title and information -->
            </div>
        </div>
        <div class="content__boxed">
            <div class="content__wrap">
                <div class="row">
                    <!-- Active Admins -->
                    <div class="col-md-3">
                        <div class="card text-white" style="background-color: var(--bs-primary);">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="demo-pli-add-user-star display-6"></i>
                                    <div class="ms-4">
                                        <h5 class="text-white h2 mb-0">{{ $activeAdmins }}</h5>
                                        <p class="text-white text-opacity-75 mb-0">Active Admins</p>
                                    </div>
                                </div>
                                <div class="progress progress-md">
                                    <div class="progress-bar bg-white" role="progressbar"
                                         style="width: {{ $adminProgress }}%;"
                                         aria-valuenow="{{ $adminProgress }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small>{{ round($adminProgress, 2) }}% Active</small>
                            </div>
                        </div>
                    </div>

                    <!-- Active Users -->
                    <div class="col-md-3">
                        <div class="card text-white" style="background-color: var(--bs-primary);">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="demo-pli-male-female display-6"></i>
                                    <div class="ms-4">
                                        <h5 class="text-white h2 mb-0">{{ $activeUsers }}</h5>
                                        <p class="text-white text-opacity-75 mb-0">Active Users</p>
                                    </div>
                                </div>
                                <div class="progress progress-md">
                                    <div class="progress-bar bg-white" role="progressbar"
                                         style="width: {{ $userProgress }}%;"
                                         aria-valuenow="{{ $userProgress }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small>{{ round($userProgress, 2) }}% Active</small>
                            </div>
                        </div>
                    </div>

                    <!-- Fresh Invoices -->
                    <div class="col-md-3">
                        <div class="card text-white" style="background-color: var(--bs-primary);">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="demo-pli-cart-coin display-6"></i>
                                    <div class="ms-4">
                                        <h5 class="text-white h2 mb-0">{{ $freshInvoices }}</h5>
                                        <p class="text-white text-opacity-75 mb-0">Fresh Invoices</p>
                                    </div>
                                </div>
                                <div class="progress progress-md">
                                    <div class="progress-bar bg-white" role="progressbar"
                                         style="width: {{ $freshInvoiceProgress }}%;"
                                         aria-valuenow="{{ $freshInvoiceProgress }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small>{{ round($freshInvoiceProgress, 2) }}% of Total Invoices</small>
                            </div>
                        </div>
                    </div>

                    <!-- Upsale Invoices -->
                    <div class="col-md-3">
                        <div class="card text-white" style="background-color: var(--bs-primary);">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="demo-pli-cart-coin display-6"></i>
                                    <div class="ms-4">
                                        <h5 class="text-white h2 mb-0">{{ $upsaleInvoices }}</h5>
                                        <p class="text-white text-opacity-75 mb-0">Upsale Invoices</p>
                                    </div>
                                </div>
                                <div class="progress progress-md">
                                    <div class="progress-bar bg-white" role="progressbar"
                                         style="width: {{ $upsalInvoiceProgress }}%;"
                                         aria-valuenow="{{ $upsalInvoiceProgress }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                                <small>{{ round($upsalInvoiceProgress, 2) }}% of Total Invoices</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content__boxed">
            <div class="content__wrap">
                <div class="row">
                    <h1 class="page-title mb-2">Invoices</h1>

                    @php
                        $invoiceData = [
                            ['title' => 'Paid', 'count' => $paidInvoices, 'progress' => $invoicesProgress['paid'], 'color' => 'success'],
                            ['title' => 'Due', 'count' => $dueInvoices, 'progress' => $invoicesProgress['due'], 'color' => 'danger'],
                            ['title' => 'Refunded', 'count' => $refundInvoices, 'progress' => $invoicesProgress['refund'], 'color' => 'warning'],
                            ['title' => 'Chargeback', 'count' => $chargebackInvoices, 'progress' => $invoicesProgress['chargeback'], 'color' => 'dark']
                        ];
                    @endphp

                    @foreach ($invoiceData as $invoice)
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h5 class="card-title">Total {{ $invoice['title'] }} : {{ $invoice['count'] }}</h5>
                                    </div>
                                    <div class="d-flex flex-column gap-3">
                                        <div class="progress progress-lg">
                                            <div class="progress-bar bg-{{ $invoice['color'] }}"
                                                 role="progressbar"
                                                 style="width: {{ $invoice['progress'] }}%;"
                                                 aria-valuenow="{{ $invoice['progress'] }}"
                                                 aria-valuemin="0"
                                                 aria-valuemax="100">
                                                {{ round($invoice['progress']) }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
        <div class="content__boxed">
            <div class="content__wrap">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header toolbar">
                                <div class="toolbar-start">
                                    <h5 class="m-0">Monthly Revenue</h5>
                                </div>
                                <div class="toolbar-end">
                                    <button type="button" class="btn btn-icon btn-minimize btn-xs"
                                            data-bs-toggle="collapse" data-bs-target="#_dm-Barchart"
                                            aria-expanded="true" aria-controls="_dm-Barchart">
                                        <i class="demo-psi-min"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon btn-xs btn-secondary clos_btn"
                                            data-nf-toggler="dismiss" data-nf-target=".card">
                                        <i class="demo-psi-cross"></i>
                                        <span class="visually-hidden">Close the card</span>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="barchart collapse show" id="_dm-Barchart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header toolbar">
                                <div class="toolbar-start">
                                    <h5 class="m-0">Annual Revenue</h5>
                                </div>
                                <div class="toolbar-end">
                                    <button type="button" class="btn btn-icon btn-minimize btn-xs"
                                            data-bs-toggle="collapse" data-bs-target="#_dm-AreaChart"
                                            aria-expanded="true" aria-controls="_dm-AreaChart">
                                        <i class="demo-psi-min"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon btn-xs btn-secondary clos_btn"
                                            data-nf-toggler="dismiss" data-nf-target=".card">
                                        <i class="demo-psi-cross"></i>
                                        <span class="visually-hidden">Close the card</span>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="areachart collapse show" id="_dm-AreaChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content__boxed">
            <div class="content__wrap">
                <div class="row">
                    <div class="col-md-8">
                        <h2>Recent Payments</h2>
                        <table class="table table-striped dashbord_tbl initTable">
                            <thead>
                            <tr class="tabl_tr">
                                <th class="tabl_th">Serial No</th>
                                <th class="tabl_th">Invoice No</th>
                                <th class="tabl_th">Payment Method</th>
                                <th class="tabl_th">Brand</th>
                                <th class="tabl_th">Team</th>
                                <th class="tabl_th">Amount</th>
                                <th class="tabl_th">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($recentPayments as $key => $payment)
                                <tr class="tabl_tr">
                                    <td class="tabl_td">{{ $key + 1 }}</td>
                                    <td class="tabl_td">{{ $payment->invoice_key }}</td>
                                    <td class="tabl_td">{{ ucfirst($payment->payment_method) }}</td>
                                    <td class="tabl_td">{{ ucfirst(optional($payment->brand)->name) }}</td>
                                    <td class="tabl_td">{{ ucfirst(optional($payment->team)->name) }}</td>
                                    <td class="tabl_td">{{ $payment->amount }} {{optional($payment->invoice)->currency}}</td>
                                    <td class="tabl_td">Paid</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4 right_col">
                        <div class="card">
                            <div class="card-header toolbar">
                                <div class="toolbar-start">
                                    <h5 class="m-0">Lead Progress</h5>
                                </div>
                                <div class="toolbar-end">
                                    <button type="button" class="btn btn-icon btn-minimize btn-xs"
                                            data-bs-toggle="collapse" data-bs-target="#_dm-PieChart"
                                            aria-expanded="true" aria-controls="_dm-PieChart">
                                        <i class="demo-psi-min"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon btn-xs btn-secondary clos_btn"
                                            data-nf-toggler="dismiss" data-nf-target=".card">
                                        <i class="demo-psi-cross"></i>
                                        <span class="visually-hidden">Close the card</span>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="leadpieChart collapse show" id="leadPieChart"></div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header toolbar">
                                <div class="toolbar-start">
                                    <h5 class="m-0">Payment Progress</h5>
                                </div>
                                <div class="toolbar-end">
                                    <button type="button" class="btn btn-icon btn-minimize btn-xs"
                                            data-bs-toggle="collapse" data-bs-target="#_dm-DonutChart"
                                            aria-expanded="true" aria-controls="_dm-DonutChart">
                                        <i class="demo-psi-min"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon btn-xs btn-secondary clos_btn"
                                            data-nf-toggler="dismiss" data-nf-target=".card">
                                        <i class="demo-psi-cross"></i>
                                        <span class="visually-hidden">Close the card</span>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="donutchart" id="_dm-DonutChart"></div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header toolbar">
                                <div class="toolbar-start">
                                    <h5 class="m-0">OverAll CRM</h5>
                                </div>
                                <div class="toolbar-end">
                                    <button type="button" class="btn btn-icon btn-minimize btn-xs"
                                            data-bs-toggle="collapse" data-bs-target="#_dm-RadialChart"
                                            aria-expanded="true" aria-controls="_dm-RadialChart">
                                        <i class="demo-psi-min"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon btn-xs btn-secondary clos_btn"
                                            data-nf-toggler="dismiss" data-nf-target=".card">
                                        <i class="demo-psi-cross"></i>
                                        <span class="visually-hidden">Close the card</span>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="radialchart" id="_dm-RadialChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>


    @push('script')
        <script>
            if ($('.initTable').length) {
                $('.initTable').each(function (index) {
                    initializeDatatable($(this), index)
                })
            }
            function initializeDatatable(table_div, index) {
                table = table_div.DataTable({
                    dom:
                        "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
                    order: [[1, 'desc']],
                    responsive: false,
                    scrollX: true,
                    scrollY:  ($(window).height() - 350),
                    scrollCollapse: true,
                    paging: true,
                });
            }
            // // Bar Chart
            // var options = {
            //     series: [{
            //         name: 'Team A',
            //         type: 'column',
            //         data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6]
            //     }, {
            //         name: 'Team B',
            //         type: 'column',
            //         data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
            //     }, {
            //         name: 'Team C',
            //         type: 'column',
            //         data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
            //     },],
            //     chart: {
            //         height: 350,
            //         type: 'line',
            //         stacked: false
            //     },
            //     colors: ['#2d3e50', '#ff5722', '#98a3b0'], // Custom colors for series
            //     dataLabels: {
            //         enabled: false
            //     },
            //     stroke: {
            //         width: [1, 1, 1]
            //     },
            //
            //     xaxis: {
            //         categories: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016],
            //     },
            //
            //     tooltip: {
            //         fixed: {
            //             enabled: true,
            //             position: 'topLeft',
            //             offsetY: 30,
            //             offsetX: 60
            //         },
            //     },
            //
            // };
            //
            // var barchart = new ApexCharts($(".barchart")[0], options);
            // barchart.render();
            // // Bar Chart
            //
            // // Area Chart
            // var options = {
            //     series: [{
            //         name: 'Team A',
            //         type: 'column',
            //         data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6]
            //     }, {
            //         name: 'Team B',
            //         type: 'column',
            //         data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
            //     }, {
            //         name: 'Team C',
            //         type: 'column',
            //         data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
            //     },],
            //     chart: {
            //         height: 350,
            //         type: 'line',
            //     },
            //     stroke: {
            //         curve: 'smooth'
            //     },
            //     fill: {
            //         type: 'solid',
            //         opacity: [0.35, 1],
            //     },
            //
            //     colors: ['#2d3e50', '#ff5722'],
            //     labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            //
            //     tooltip: {
            //         shared: true,
            //         intersect: false,
            //
            //     }
            // };
            //
            // var areachart = new ApexCharts($(".areachart")[0], options);
            // areachart.render();
            // // Area Chart

            document.addEventListener("DOMContentLoaded", function () {
                const dailyPayments = @json($dailyPayments);
                const dailyLabels = @json($dailyLabels);

                var barOptions = {
                    series: [{
                        name: 'Total Payments',
                        data: dailyPayments,
                    }],
                    chart: {
                        height: 350,
                        type: 'bar',
                    },
                    colors: ['#2d3e50'],
                    dataLabels: {
                        enabled: false,
                    },
                    xaxis: {
                        categories: dailyLabels,
                    },
                    tooltip: {
                        shared: true,
                        intersect: false,
                    },
                };

                var barChart = new ApexCharts(document.querySelector(".barchart"), barOptions);
                barChart.render();

                const annualPayments = @json(array_values($annualPayments));
                const currentYear = new Date().getFullYear().toString().slice(-2);
                const monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'].map((month, index) => `${month} ${currentYear}`);
                var areaOptions = {
                    series: [{
                        name: 'Total Payments',
                        data: annualPayments,
                    }],
                    chart: {
                        height: 350,
                        type: 'area',
                    },
                    stroke: {
                        curve: 'smooth',
                    },
                    fill: {
                        type: 'solid',
                        opacity: [0.35],
                    },
                    colors: ['#2d3e50'],
                    xaxis: {
                        categories: monthlyLabels,
                        labels: {
                            rotate: 0,
                            style: {
                                fontSize: '10px',
                                fontWeight: 'bold',
                            },
                            show: true,
                        },
                        tickAmount: 12,
                    },
                    yaxis: {
                        labels: {
                            formatter: function (value) {
                                return value.toFixed(2);
                            },
                        },
                    },
                    tooltip: {
                        shared: true,
                        intersect: false,
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    markers: {
                        size: 0,
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            xaxis: {
                                labels: {
                                    show: false,
                                }
                            },
                            tooltip: {
                                enabled: false,
                            }
                        }
                    }]
                };

                var areaChart = new ApexCharts(document.querySelector(".areachart"), areaOptions);
                areaChart.render();
            });

            document.addEventListener("DOMContentLoaded", function () {
                const labels = @json($leadStatuses->pluck('name')) ||
                [];
                const data = @json($leadCounts) ||
                {
                }
                ;
                const colors = @json($leadStatuses->pluck('color')) ||
                [];

                const series = labels.map(status => data[status] || 0);

                var options = {
                    series: series,
                    chart: {
                        type: 'pie',
                        toolbar: {
                            show: true,
                        },
                    },
                    colors: colors,
                    labels: labels,
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

                var pieChart = new ApexCharts(document.getElementById("leadPieChart"), options);
                pieChart.render();
            });

            // if ($(".pieChart").length > 0) {
            //     //Pie Chart
            //     var options = {
            //         series: [44, 55, 60],
            //         chart: {
            //             type: 'pie',
            //             toolbar: {
            //                 show: true,
            //             },
            //         },
            //         colors: ['#2d3e50', '#ff5722', '#98a3b0'],
            //         labels: ['Team A', 'Team B', 'Team C'],
            //         legend: {
            //             position: 'right',
            //         },
            //
            //         responsive: [{
            //             breakpoint: 480,
            //             options: {
            //                 chart: {
            //                     width: 300
            //                 },
            //                 legend: {
            //                     position: 'bottom'
            //                 }
            //             }
            //         }]
            //     };
            //
            //     var pieChart = new ApexCharts($(".pieChart")[0], options);
            //     pieChart.render();
            //     //Pie Chart

            // }
            //Donut Chart
            var options = {
                series: [
                    {{ $paymentCounts->paid }},
                    {{ $paymentCounts->refund }},
                    {{ $paymentCounts->chargeback }},
                ],
                chart: {
                    type: 'donut',
                    toolbar: {
                        show: true,
                    },
                },

                colors: ['#28a745', '#ffc107', '#dc3545'],
                labels: ['Paid', 'Refund', 'Chargeback'],

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
                }],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '75%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total Payments',
                                    formatter: function (w) {
                                        return {{ $totalPayments }};
                                    }
                                }, value: {
                                    formatter: function (val, chart) {
                                        return val
                                    }
                                }

                            }
                        },
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            let total = [{{$paymentCounts->paid}},{{$paymentCounts->refund}},{{$paymentCounts->chargeback}}].
                            reduce((a, b) => a + b, 0);
                            let percentage = (val / total) * 100;
                            return percentage.toFixed(2) + "%";
                        }
                    }
                }
            };

            var donutchart = new ApexCharts($(".donutchart")[0], options);
            donutchart.render();
            //Donut Chart

            //Radial Chart
            var options = {
                series: [
                    {{ $totalLeads }},
                    {{ $totalCustomers }},
                    {{ $totalInvoices }},
                    {{ $totalPayments }}
                ], // 4 dynamic values
                chart: {
                    type: 'radialBar',
                    toolbar: {
                        show: true,
                        tools: {
                            download: true
                        }
                    },
                },
                colors: ['#28a745', '#ffc107', '#dc3545', '#007bff'],
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
                                show: true,
                                fontSize: '16px',
                                fontWeight: 'bold',
                                color: '#333',
                                offsetY: -10,
                                formatter: function (val) {
                                    return val;
                                }
                            },
                            value: {
                                fontSize: '24px',
                                fontWeight: 'bold',
                                color: '#333',
                                offsetY: 10,
                                formatter: function (val) {
                                    return val;
                                }
                            },
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                },
                labels: ['Leads', 'Customers', 'Invoices', 'Payments'],
            };

            var radialchart = new ApexCharts($(".radialchart")[0], options);
            radialchart.render();
            //Radial Chart

        </script>
    @endpush
@endsection
