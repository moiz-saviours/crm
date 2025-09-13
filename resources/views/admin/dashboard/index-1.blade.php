@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')
    @push('style')
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

            .modal.fade.show .modal-dialog.transform-popover {
                transform: scale(1)
            }

            .modal.fade .modal-dialog.transform-popover {
                transform: scale(0);
            }

            .col-md-3[data-bs-toggle="modal"] {
                cursor: pointer;
            }

            .total-sum {
                cursor: text;
                pointer-events: none;
            }
            .cstm_bdge {
                padding: 5px 10px;
                font-weight: 400;
                font-size: 0.7rem !important;
                border-radius: 3px;
            }
            .dsh_btn {
                display: flex;
            }
        </style>
    @endpush
    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <!-- Page title and information -->
               <div class="dsh_btn">
                   <h1 class="page-title mb-2">Dashboard </h1>
                   <button class="start-tour-btn my-btn tour-dashboard1-alldata" data-toggle="tooltip" title="Take a Tour" data-tour="dashboard1"> <i class="fas fa-exclamation-circle custom-dot"></i> </button>

               </div>
                <h2 class="h5">Welcome to the CRM Dashboard.</h2>


                <!-- END : Page title and information -->
            </div>
        </div>
        <div class="content__boxed">
            <div class="content__wrap">
                <div class="row">
                    <!-- Active Admins -->
                    <div class="col-md-3 tour-dashboard1-admin" data-bs-toggle="modal" data-bs-target="#activeAdminModal">
                        <div class="card text-white" style="background-color: var(--bs-primary);">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="demo-pli-add-user-star display-6"></i>
                                    <div class="ms-4">
                                        <h5 class="text-white h2 mb-0">{{ max(0, count($activeAdmins)) }}</h5>
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
                    <div class="col-md-3 tour-dashboard1-user" data-bs-toggle="modal" data-bs-target="#activeUserModal">
                        <div class="card text-white" style="background-color: var(--bs-primary);">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="demo-pli-male-female display-6"></i>
                                    <div class="ms-4">
                                        <h5 class="text-white h2 mb-0">{{ max(0, count($activeUsers)) }}</h5>
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
                    <div class="col-md-3 tour-dashboard1-freshinvoice" data-bs-toggle="modal" data-bs-target="#freshInvoicesModal">
                        <div class="card text-white" style="background-color: var(--bs-primary);">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="demo-pli-cart-coin display-6"></i>
                                    <div class="ms-4">
                                        <h5 class="text-white h2 mb-0 total-sum">
                                            ${{$freshInvoices->sum('total_amount')}}</h5>
                                        <p class="text-white text-opacity-75 mb-0">{{ max(0,count($freshInvoices)) }}
                                            Fresh Invoice</p>
                                    </div>
                                </div>
                                <div class="progress progress-md">
                                    <div class="progress-bar bg-white" role="progressbar"
                                         style="width: {{ $freshInvoiceProgress }}%;"
                                         aria-valuenow="{{ $freshInvoiceProgress }}" aria-valuemin="0"
                                         aria-valuemax="100">
                                    </div>
                                </div>
                                <small>{{ round($freshInvoiceProgress, 2) }}% of Total Paid Invoices</small>
                            </div>
                        </div>
                    </div>

                    <!-- Upsale Invoices -->
                    <div class="col-md-3 tour-dashboard1-upsaleinvoice" data-bs-toggle="modal" data-bs-target="#upsaleInvoicesModal">
                        <div class="card text-white" style="background-color: var(--bs-primary);">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="demo-pli-cart-coin display-6"></i>
                                    <div class="ms-4">
                                        <h5 class="text-white h2 mb-0 total-sum">
                                            ${{$upsaleInvoices->sum('total_amount')}}</h5>
                                        <p class="text-white text-opacity-75 mb-0">{{ max(0,count($upsaleInvoices)) }}
                                            Upsale Invoice</p>
                                    </div>
                                </div>
                                <div class="progress progress-md">
                                    <div class="progress-bar bg-white" role="progressbar"
                                         style="width: {{ $upsalInvoiceProgress }}%;"
                                         aria-valuenow="{{ $upsalInvoiceProgress }}" aria-valuemin="0"
                                         aria-valuemax="100">
                                    </div>
                                </div>
                                <small>{{ round($upsalInvoiceProgress, 2) }}% of Total Paid Invoices</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content__boxed">
            <div class="content__wrap" style="padding-top: 0px">
                <div class="row tour-dashboard1-invoicedata">
                    <h1 class="page-title mb-2">Invoices</h1>
                    @php
                        $invoiceData = [
                            ['title' => 'Paid', 'invoices' => $paidInvoices, 'count' => count($paidInvoices),'total_sum' => $paidInvoices->sum('total_amount'), 'progress' => $invoicesProgress['paid'], 'color' => 'success', 'icon' => 'demo-pli-check', 'modal' => 'paidInvoicesModal'],
                            ['title' => 'Due', 'invoices' => $dueInvoices, 'count' => count($dueInvoices),'total_sum' => $dueInvoices->sum('total_amount'), 'progress' => $invoicesProgress['due'], 'color' => 'danger', 'icon' => 'demo-pli-clock', 'modal' => 'dueInvoicesModal'],
                            ['title' => 'Refunded', 'invoices' => $refundInvoices, 'count' => count($refundInvoices),'total_sum' => $refundInvoices->sum('total_amount'), 'progress' => $invoicesProgress['refund'], 'color' => 'warning', 'icon' => 'demo-pli-repeat-2', 'modal' => 'refundInvoicesModal'],
                            ['title' => 'Chargeback', 'invoices' => $chargebackInvoices, 'count' => count($chargebackInvoices),'total_sum' => $chargebackInvoices->sum('total_amount'), 'progress' => $invoicesProgress['chargeback'], 'color' => 'dark', 'icon' => 'demo-pli-close', 'modal' => 'chargebackInvoicesModal']
                        ];
                    @endphp
                    @foreach ($invoiceData as $invoice)
                        <div class="col-md-3" data-bs-toggle="modal" data-bs-target="#{{ $invoice['modal'] }}">
                            <div class="card" style="color: var(--bs-primary);">
                                <div class="card-body" style="padding: 1rem;">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="{{ $invoice['icon'] }} display-6"></i>
                                        <div class="ms-4">
                                            <h5 class="h2 mb-0 total-sum"
                                                style="color: var(--bs-primary);">${{ $invoice['total_sum'] }}</h5>
                                            <p class="text-opacity-75 mb-0">{{ $invoice['count'] }}
                                                Total {{ $invoice['title'] }}</p>
                                        </div>
                                    </div>
                                    <div class="progress progress-md">
                                        <div class="progress-bar" role="progressbar"
                                             style="width: {{ $invoice['progress'] }}%;"
                                             aria-valuenow="{{ $invoice['progress'] }}" aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                    <small>{{ round($invoice['progress'], 2) }}% of Total Invoices</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{--                    @foreach ($invoiceData as $invoice)--}}
                    {{--                        <div class="col-md-3" data-bs-toggle="modal" data-bs-target="#{{ $invoice['modal'] }}">--}}
                    {{--                            <div class="card">--}}
                    {{--                                <div class="card-body">--}}
                    {{--                                    <div class="d-flex">--}}
                    {{--                                        <h5 class="card-title">Total {{ $invoice['title'] }}--}}
                    {{--                                            : {{ $invoice['count'] }}</h5>--}}
                    {{--                                    </div>--}}
                    {{--                                    <div class="d-flex flex-column gap-3">--}}
                    {{--                                        <div class="progress progress-lg">--}}
                    {{--                                            <div class="progress-bar bg-{{ $invoice['color'] }}"--}}
                    {{--                                                 role="progressbar"--}}
                    {{--                                                 style="width: {{ $invoice['progress'] }}%;"--}}
                    {{--                                                 aria-valuenow="{{ $invoice['progress'] }}"--}}
                    {{--                                                 aria-valuemin="0"--}}
                    {{--                                                 aria-valuemax="100">--}}
                    {{--                                                {{ round($invoice['progress']) }}%--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    @endforeach--}}
                </div>

            </div>
        </div>
        <div class="content__boxed">
            <div class="content__wrap">
                <div class="row">
                    <div class="col-md-6 tour-dashboard1-monthlydata">
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
                    <div class="col-md-6 tour-dashboard1-annualdata">
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
                        <table class="table table-striped dashbord_tbl initTable tour-dashboard1-recenpayment">
                            <thead>
                            <tr class="tabl_tr">
                                <th class="tabl_th align-middle text-center text-nowrap">Serial No</th>
                                <th class="tabl_th align-middle text-center text-nowrap">Invoice No</th>
                                <th class="tabl_th align-middle text-center text-nowrap">Payment Method</th>
                                <th class="tabl_th align-middle text-center text-nowrap">Brand</th>
                                <th class="tabl_th align-middle text-center text-nowrap">Team</th>
                                <th class="tabl_th align-middle text-center text-nowrap">Amount</th>
                                <th class="tabl_th align-middle text-center text-nowrap">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($recentPayments as $key => $payment)
                                <tr class="tabl_tr">
                                    <td class="tabl_td align-middle text-center text-nowrap">{{ $key + 1 }}</td>
                                    <td class="tabl_td align-middle text-center text-nowrap">{{ $payment->invoice_key }}</td>
                                    <td class="tabl_td align-middle text-center text-nowrap">{{ ucfirst($payment->payment_method) }}</td>
                                    <td class="tabl_td align-middle text-center text-nowrap">{{ ucfirst(optional($payment->brand)->name) }}</td>
                                    <td class="tabl_td align-middle text-center text-nowrap">{{ ucfirst(optional($payment->team)->name) }}</td>
                                    <td class="tabl_td align-middle text-center text-nowrap">{{ $payment->amount }} {{optional($payment->invoice)->currency}}</td>
                                    <td class="tabl_td align-middle text-center text-nowrap"><span class="badge bg-success cstm_bdge">Paid</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4 right_col">
                        <div class="card tour-dashboard1-leadprogress">
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
                        <div class="card tour-dashboard1-paymentprogress">
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
                        <div class="card tour-dashboard1-overallprogress">
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

    <!--Modals Start -->

    <!-- Active Admin Modal -->
    <div class="modal fade" id="activeAdminModal"
         aria-labelledby="activeAdminModalAnimationLabel">
        <div class="modal-dialog modal-dialog-centered transform-popover modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="activeAdminModalAnimationLabel">Active Admins</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped dashbord_tbl initTable">
                        <thead>
                        <tr class="tabl_tr">
                            <th class="tabl_th align-middle text-center text-nowrap">NAME</th>
                            <th class="tabl_th align-middle text-center text-nowrap">EMAIL</th>
                            <th class="tabl_th align-middle text-center text-nowrap">DESIGNATION</th>
                            <th class="tabl_th align-middle text-center text-nowrap">LAST SEEN</th>
                            <th class="tabl_th align-middle text-center text-nowrap">STATUS</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($activeAdmins as $key => $activeAdmin)
                            <tr class="tabl_tr">
                                <td class="tabl_td align-middle text-center text-nowrap">{{ ucfirst($activeAdmin->name) }}</td>
                                <td class="tabl_td align-middle text-center text-nowrap">{{ $activeAdmin->email }}</td>
                                <td class="tabl_td align-middle text-center text-nowrap">{{ ucfirst($activeAdmin->designation) }}</td>
                                <td class="tabl_td align-middle text-center text-nowrap">
                                    @if ($activeAdmin->last_seen)
                                        {{ Carbon\Carbon::parse($activeAdmin->last_seen)->diffForHumans() }}
                                    @else
                                        Never
                                    @endif
                                </td>
                                <td class="tabl_td align-middle text-center text-nowrap">{{$activeAdmin->status == 1 ? 'Active' : 'InActive'}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END : Active Admin Modal Animation -->

    <!-- Active User Modal -->
    <div class="modal fade" id="activeUserModal"
         aria-labelledby="activeUserModalAnimationLabel">
        <div class="modal-dialog modal-dialog-centered transform-popover modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="activeUserModalAnimationLabel">Active Users</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped dashbord_tbl initTable">
                        <thead>
                        <tr class="tabl_tr">
                            <th class="tabl_th align-middle text-center text-nowrap">NAME</th>
                            <th class="tabl_th align-middle text-center text-nowrap">EMAIL</th>
                            <th class="tabl_th align-middle text-center text-nowrap">DESIGNATION</th>
                            <th class="tabl_th align-middle text-center text-nowrap">LAST SEEN</th>
                            <th class="tabl_th align-middle text-center text-nowrap">STATUS</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($activeUsers as $key => $activeUser)
                            <tr class="tabl_tr">
                                <td class="tabl_td align-middle text-center text-nowrap">{{ ucfirst($activeUser->name) }}</td>
                                <td class="tabl_td align-middle text-center text-nowrap">{{ $activeUser->email }}</td>
                                <td class="tabl_td align-middle text-center text-nowrap">{{ ucfirst($activeUser->designation) }}</td>
                                <td class="tabl_td align-middle text-center text-nowrap">
                                    @if ($activeUser->last_seen)
                                        {{ Carbon\Carbon::parse($activeUser->last_seen)->diffForHumans() }}
                                    @else
                                        Never
                                    @endif
                                </td>
                                <td class="tabl_td align-middle text-center text-nowrap">{{$activeUser->status == 1 ? 'Active' : 'InActive'}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END : Active User Modal Animation -->

    <!-- Fresh Invoices Modal -->
    <div class="modal fade" id="freshInvoicesModal"
         aria-labelledby="freshInvoicesModalAnimationLabel">
        <div class="modal-dialog modal-dialog-centered transform-popover modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="freshInvoicesModalAnimationLabel">Fresh Invoices</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped dashbord_tbl initTable">
                        <thead>
                        <tr class="tabl_tr">
                            <th class="tabl_th align-middle text-center text-nowrap">INVOICE #</th>
                            <th class="tabl_th align-middle text-center text-nowrap">INVOICE DETAILS</th>
                            <th class="tabl_th align-middle text-center text-nowrap">AMOUNT</th>
                            <th class="tabl_th align-middle text-center text-nowrap">DATE</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($freshInvoices as $key => $freshInvoice)
                            <tr id="tr-{{$freshInvoice->id}}">
                                <td class="align-middle text-center text-nowrap text-sm invoice-cell">
                                    <span class="invoice-number">{{ $freshInvoice->invoice_number }}</span><br>
                                    <span class="invoice-key">{{ $freshInvoice->invoice_key }}</span>
                                    <div>
                                        @if($freshInvoice->status == 0)
                                            <span class="badge bg-warning text-dark"
                                                  style="min-width: -webkit-fill-available;">Pending</span>
                                        @elseif($freshInvoice->status == 1)
                                            <span class="badge bg-success" style="min-width: -webkit-fill-available;">Paid</span>
                                        @elseif($freshInvoice->status == 2)
                                            <span class="badge bg-danger" style="min-width: -webkit-fill-available;">Refund</span>
                                        @elseif($freshInvoice->status == 3)
                                            <span class="badge bg-danger" style="min-width: -webkit-fill-available;">Charge Back</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="align-middle text-left text-nowrap" style="padding: 0px 25px 0 25px;">
                                    @if(isset($freshInvoice->brand))
                                        <div>
                                            <span>Brand :</span>
                                            <a href="{{route('admin.brand.index')}}">{{ $freshInvoice->brand->name }}</a>
                                        </div>
                                    @endif
                                    @if(isset($freshInvoice->team))
                                        <div>
                                            <span>Team :</span>
                                            <a href="{{route('admin.team.index')}}">{{ $freshInvoice->team->name }}</a>
                                        </div>
                                    @endif
                                    @if(isset($freshInvoice->agent_id , $freshInvoice->agent_type ,$freshInvoice->agent ))
                                        <div>
                                            <span>Agent :</span>
                                            <a href="{{route('admin.employee.index')}}">{{ $freshInvoice->agent->name }}</a>
                                        </div>
                                    @endif
                                    @if(isset($freshInvoice->customer_contact))
                                        <div>
                                            <span>Customer :</span>
                                            <a href="{{route('admin.customer.contact.index')}}">{{ $freshInvoice->customer_contact->name }}</a>
                                        </div>
                                    @endif
                                </td>
                                <td class="align-middle space-between text-nowrap"
                                    style="text-align: left;">
                                    <div
                                        style="display: flex; justify-content: space-between; gap: 10px;">
                                        <span style="width: 120px; ">Amount:</span>
                                        <span>{{ $freshInvoice->currency ." ". number_format($freshInvoice->amount, 2, '.', '') }}</span>
                                    </div>
                                    <div
                                        style="display: flex; justify-content: space-between; gap: 10px;">
                                        <span style="width: 120px; ">Tax:</span>
                                        <span>{{ $freshInvoice->tax_type == 'percentage' ? '%' : ($freshInvoice->tax_type == 'fixed' ? $freshInvoice->currency : '') }} {{ $freshInvoice->tax_value ?? 0 }}</span>
                                    </div>
                                    <div
                                        style="display: flex; justify-content: space-between; gap: 10px;">
                                        <span style="width: 120px; ">Tax Amount:</span>
                                        <span>{{ $freshInvoice->currency ." ". number_format($freshInvoice->tax_amount, 2, '.', '') }}</span>
                                    </div>
                                    <div
                                        style="display: flex; justify-content: space-between; gap: 10px;">
                                        <span style="width: 120px; ">Total Amount:</span>
                                        <span>{{ $freshInvoice->currency ." ". number_format($freshInvoice->total_amount, 2, '.', '') }}</span>
                                    </div>
                                </td>
                                <td class="align-middle text-center text-nowrap">
                                    <div>
                                        <span>Due Date :</span>
                                    </div>
                                    <div>
                                        <span>{{Carbon\Carbon::parse($freshInvoice->due_date)->format('Y-m-d')}}</span>
                                    </div>
                                    <div>
                                        <span>Created Date :</span>
                                    </div>
                                    <div>
                                        <span>
                                            @if ($freshInvoice->created_at->isToday())
                                                Today
                                                at {{ $freshInvoice->created_at->timezone('GMT+5')->format('g:i A') }}
                                                GMT+5
                                            @else
                                                {{ $freshInvoice->created_at->timezone('GMT+5')->format('M d, Y g:i A') }}
                                                GMT+5
                                            @endif
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END : Fresh Invoices Modal Animation -->

    <!-- Upsale Invoices Modal -->
    <div class="modal fade" id="upsaleInvoicesModal"
         aria-labelledby="upsaleInvoicesModalAnimationLabel">
        <div class="modal-dialog modal-dialog-centered transform-popover modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="upsaleInvoicesModalAnimationLabel">Upsale </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped dashbord_tbl initTable">
                        <thead>
                        <tr class="tabl_tr">
                            <th class="tabl_th align-middle text-center text-nowrap">INVOICE #</th>
                            <th class="tabl_th align-middle text-center text-nowrap">INVOICE DETAILS</th>
                            <th class="tabl_th align-middle text-center text-nowrap">AMOUNT</th>
                            <th class="tabl_th align-middle text-center text-nowrap">DATE</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($upsaleInvoices as $key => $upsaleInvoice)
                            <tr id="tr-{{$upsaleInvoice->id}}">
                                <td class="align-middle text-center text-nowrap text-sm invoice-cell">
                                    <span class="invoice-number">{{ $upsaleInvoice->invoice_number }}</span><br>
                                    <span class="invoice-key">{{ $upsaleInvoice->invoice_key }}</span>
                                    <div>
                                        @if($upsaleInvoice->status == 0)
                                            <span class="badge bg-warning text-dark"
                                                  style="min-width: -webkit-fill-available;">Pending</span>
                                        @elseif($upsaleInvoice->status == 1)
                                            <span class="badge bg-success" style="min-width: -webkit-fill-available;">Paid</span>
                                        @elseif($upsaleInvoice->status == 2)
                                            <span class="badge bg-danger" style="min-width: -webkit-fill-available;">Refund</span>
                                        @elseif($upsaleInvoice->status == 3)
                                            <span class="badge bg-danger" style="min-width: -webkit-fill-available;">Charge Back</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="align-middle text-left text-nowrap" style="padding: 0px 25px 0 25px;">
                                    @if(isset($upsaleInvoice->brand))
                                        <div>
                                            <span>Brand :</span>
                                            <a href="{{route('admin.brand.index')}}">{{ $upsaleInvoice->brand->name }}</a>
                                        </div>
                                    @endif
                                    @if(isset($upsaleInvoice->team))
                                        <div>
                                            <span>Team :</span>
                                            <a href="{{route('admin.team.index')}}">{{ $upsaleInvoice->team->name }}</a>
                                        </div>
                                    @endif
                                    @if(isset($upsaleInvoice->agent_id , $upsaleInvoice->agent_type ,$upsaleInvoice->agent ))
                                        <div>
                                            <span>Agent :</span>
                                            <a href="{{route('admin.employee.index')}}">{{ $upsaleInvoice->agent->name }}</a>
                                        </div>
                                    @endif
                                    @if(isset($upsaleInvoice->customer_contact))
                                        <div>
                                            <span>Customer :</span>
                                            <a href="{{route('admin.customer.contact.index')}}">{{ $upsaleInvoice->customer_contact->name }}</a>
                                        </div>
                                    @endif
                                </td>
                                <td class="align-middle space-between text-nowrap"
                                    style="text-align: left;">
                                    <div
                                        style="display: flex; justify-content: space-between; gap: 10px;">
                                        <span style="width: 120px; ">Amount:</span>
                                        <span>{{ $upsaleInvoice->currency ." ". number_format($upsaleInvoice->amount, 2, '.', '') }}</span>
                                    </div>
                                    <div
                                        style="display: flex; justify-content: space-between; gap: 10px;">
                                        <span style="width: 120px; ">Tax:</span>
                                        <span>{{ $upsaleInvoice->tax_type == 'percentage' ? '%' : ($upsaleInvoice->tax_type == 'fixed' ? $upsaleInvoice->currency : '') }} {{ $upsaleInvoice->tax_value ?? 0 }}</span>
                                    </div>
                                    <div
                                        style="display: flex; justify-content: space-between; gap: 10px;">
                                        <span style="width: 120px; ">Tax Amount:</span>
                                        <span>{{ $upsaleInvoice->currency ." ". number_format($upsaleInvoice->tax_amount, 2, '.', '') }}</span>
                                    </div>
                                    <div
                                        style="display: flex; justify-content: space-between; gap: 10px;">
                                        <span style="width: 120px; ">Total Amount:</span>
                                        <span>{{ $upsaleInvoice->currency ." ". number_format($upsaleInvoice->total_amount, 2, '.', '') }}</span>
                                    </div>
                                </td>
                                <td class="align-middle text-center text-nowrap">
                                    <div>
                                        <span>Due Date :</span>
                                    </div>
                                    <div>
                                        <span>{{Carbon\Carbon::parse($upsaleInvoice->due_date)->format('Y-m-d')}}</span>
                                    </div>
                                    <div>
                                        <span>Created Date :</span>
                                    </div>
                                    <div>
                                        <span>
                                            @if ($upsaleInvoice->created_at->isToday())
                                                Today
                                                at {{ $upsaleInvoice->created_at->timezone('GMT+5')->format('g:i A') }}
                                                GMT+5
                                            @else
                                                {{ $upsaleInvoice->created_at->timezone('GMT+5')->format('M d, Y g:i A') }}
                                                GMT+5
                                            @endif
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- END : Upsale Invoices Modal Animation -->

    @foreach ($invoiceData as $invoice)
        <!-- Modal for {{ $invoice['title'] }} Invoices -->
        <div class="modal fade" id="{{ $invoice['modal'] }}"
             aria-labelledby="{{ $invoice['modal'] }}AnimationLabel">
            <div class="modal-dialog modal-dialog-centered transform-popover modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="{{ $invoice['modal'] }}AnimationLabel">{{ $invoice['title'] }}
                            Invoices</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped dashbord_tbl initTable">
                            <thead>
                            <tr class="tabl_tr">
                                <th class="tabl_th align-middle text-center text-nowrap">INVOICE #</th>
                                <th class="tabl_th align-middle text-center text-nowrap">INVOICE DETAILS</th>
                                <th class="tabl_th align-middle text-center text-nowrap">AMOUNT</th>
                                <th class="tabl_th align-middle text-center text-nowrap">DATE</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($invoice['invoices'] as $invoiceItem)
                                <tr id="tr-{{ $invoiceItem->id }}">
                                    <td class="align-middle text-center text-nowrap text-sm invoice-cell">
                                        <span class="invoice-number">{{ $invoiceItem->invoice_number }}</span><br>
                                        <span class="invoice-key">{{ $invoiceItem->invoice_key }}</span>
                                        <div>
                                            @if($invoiceItem->status == 0)
                                                <span class="badge bg-warning text-dark"
                                                      style="min-width: -webkit-fill-available;">Pending</span>
                                            @elseif($invoiceItem->status == 1)
                                                <span class="badge bg-success"
                                                      style="min-width: -webkit-fill-available;">Paid</span>
                                            @elseif($invoiceItem->status == 2)
                                                <span class="badge bg-danger"
                                                      style="min-width: -webkit-fill-available;">Refund</span>
                                            @elseif($invoiceItem->status == 3)
                                                <span class="badge bg-danger"
                                                      style="min-width: -webkit-fill-available;">Charge Back</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="align-middle text-left text-nowrap" style="padding: 0px 25px 0 25px;">
                                        @if(isset($invoiceItem->brand))
                                            <div>
                                                <span>Brand :</span>
                                                <a href="{{ route('admin.brand.index') }}">{{ $invoiceItem->brand->name }}</a>
                                            </div>
                                        @endif
                                        @if(isset($invoiceItem->team))
                                            <div>
                                                <span>Team :</span>
                                                <a href="{{ route('admin.team.index') }}">{{ $invoiceItem->team->name }}</a>
                                            </div>
                                        @endif
                                        @if(isset($invoiceItem->agent_id, $invoiceItem->agent_type, $invoiceItem->agent))
                                            <div>
                                                <span>Agent :</span>
                                                <a href="{{ route('admin.employee.index') }}">{{ $invoiceItem->agent->name }}</a>
                                            </div>
                                        @endif
                                        @if(isset($invoiceItem->customer_contact))
                                            <div>
                                                <span>Customer :</span>
                                                <a href="{{ route('admin.customer.contact.index') }}">{{ $invoiceItem->customer_contact->name }}</a>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="align-middle space-between text-nowrap"
                                        style="text-align: left;">
                                        <div style="display: flex; justify-content: space-between; gap: 10px;">
                                            <span style="width: 120px; ">Amount:</span>
                                            <span>{{ $invoiceItem->currency . " " . number_format($invoiceItem->amount, 2, '.', '') }}</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; gap: 10px;">
                                            <span style="width: 120px; ">Tax:</span>
                                            <span>{{ $invoiceItem->tax_type == 'percentage' ? '%' : ($invoiceItem->tax_type == 'fixed' ? $invoiceItem->currency : '') }} {{ $invoiceItem->tax_value ?? 0 }}</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; gap: 10px;">
                                            <span style="width: 120px; ">Tax Amount:</span>
                                            <span>{{ $invoiceItem->currency . " " . number_format($invoiceItem->tax_amount, 2, '.', '') }}</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; gap: 10px;">
                                            <span style="width: 120px; ">Total Amount:</span>
                                            <span>{{ $invoiceItem->currency . " " . number_format($invoiceItem->total_amount, 2, '.', '') }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-nowrap">
                                        <div>
                                            <span>Due Date :</span>
                                        </div>
                                        <div>
                                            <span>{{ Carbon\Carbon::parse($invoiceItem->due_date)->format('Y-m-d') }}</span>
                                        </div>
                                        <div>
                                            <span>Created Date :</span>
                                        </div>
                                        <div>
                                        <span>
                                            @if ($invoiceItem->created_at->isToday())
                                                Today
                                                at {{ $invoiceItem->created_at->timezone('GMT+5')->format('g:i A') }}
                                                GMT+5
                                            @else
                                                {{ $invoiceItem->created_at->timezone('GMT+5')->format('M d, Y g:i A') }}
                                                GMT+5
                                            @endif
                                        </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- END : {{ $invoice['title'] }} Invoices Modal Animation -->
    @endforeach


    <!--Modals End -->
    @push('script')
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
                    pageLength: 5,
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
            //     colors: ['var(--bs-primary)', '#ff5722', '#98a3b0'], // Custom colors for series
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
            //     colors: ['var(--bs-primary)', '#ff5722'],
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
                    colors: ['var(--bs-primary)'],
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
                    colors: ['var(--bs-primary)'],
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
            //         colors: ['var(--bs-primary)', '#ff5722', '#98a3b0'],
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
                            let total = [{{$paymentCounts->paid}}, {{$paymentCounts->refund}}, {{$paymentCounts->chargeback}}].reduce((a, b) => a + b, 0);
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
