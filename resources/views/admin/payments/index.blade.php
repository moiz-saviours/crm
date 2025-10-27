@extends('admin.layouts.app')
@section('title','Payments')
@section('datatable', true)
@section('content')
    @push('style')
        @include('admin.payments.style')
    @endpush
    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2 ">Payments <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
                        {{--                        <h2 id="record-count" class="h6">{{ count($payments) }} records</h2>--}}

                    </div>
                    <div class="filters">
                        <div class="actions">
                            {{--                                                        <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>--}}

                            {{--                            <button class="header_btn" disabled>Actions <i class="fa fa-caret-down" aria-hidden="true"></i>--}}
                            {{--                            </button>--}}
                            {{--                            <button class="header_btn" disabled>Import</button>--}}

                            <div class="form-group ">
                                <label for="teamSelect">Select Team:</label>
                                <select id="teamSelect" name="teamSelect" class="form-control">
                                    <option value="all">All Teams</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->team_key }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="brandSelect">Select Brand:</label>
                                <select id="brandSelect" name="brandSelect" class="form-control">
                                    <option value="all">All Brands</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->brand_key }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="dateTypeSelect">Select Date Type:</label>
                                <select id="dateTypeSelect" name="dateTypeSelect" class="form-control">
                                    <option value="0">Created at</option>
                                    <option value="1">Payment Date</option>
                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="dateRangePicker">Select Date Range:</label>
                                <input type="text" id="dateRangePicker" name="dateRangePicker"
                                       class="form-control dateRangePicker"/>
                            </div>
                            <button class="start-tour-btn my-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Take a Tour"
                                    data-tour="paymentcreate"><i class="fas fa-exclamation-circle custom-dot"></i>
                            </button>
                            <button class="create-contact open-form-btn tour-createpayment">Create New</button>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="content__boxed tour-paymentalldata">
            <div class="content__wrap">
                <div class="container" style="min-width: 100%;">
                    <div class="custom-tabs">
                        <ul class="tab-nav">
                            <li class="tab-item active" data-tab="home">Payments
                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>
                            <li style="margin: 9px 2px">
                                <button class="my-btn start-tour-btn tour-paymenttitle"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Take a Tour" data-tour="payment"><i
                                        class="fas fa-exclamation-circle custom-dot"></i></button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home">
                            <div class="card">
                                {{--                                <div class="card-header">--}}
                                {{--                                    <div class="container" style="min-width: 100%;">--}}
                                {{--                                        <div class="row fltr-sec">--}}
                                {{--                                            <div class="col-md-8">--}}
                                {{--                                                <ul class="custm-filtr">--}}
                                {{--                                                    <div class="table-li">--}}
                                {{--                                                        <li class="">Company Owner <i class="fa fa-caret-down"--}}
                                {{--                                                                                      aria-hidden="true"></i></li>--}}
                                {{--                                                        <li class="">Create date <i class="fa fa-caret-down"--}}
                                {{--                                                                                    aria-hidden="true"></i></li>--}}
                                {{--                                                        <li class="">Last activity date <i class="fa fa-caret-down"--}}
                                {{--                                                                                           aria-hidden="true"></i>--}}
                                {{--                                                        </li>--}}
                                {{--                                                        <li class="">Lead status <i class="fa fa-caret-down"--}}
                                {{--                                                                                    aria-hidden="true"></i></li>--}}
                                {{--                                                        <li class=""><i class="fa fa-bars" aria-hidden="true"></i> All--}}
                                {{--                                                            filters--}}
                                {{--                                                        </li>--}}
                                {{--                                                    </div>--}}
                                {{--                                                </ul>--}}
                                {{--                                            </div>--}}
                                {{--                                            <div class="col-md-4 right-icon" id="right-icon-0"></div>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                <div class="card-body ">
                                    <table id="allPaymentsTable" class="table table-striped datatable-exportable
                                                stripe row-border order-column nowrap
                                            initTable
                                                ">
                                        <thead>

                                        <tr>
                                            <th></th>
                                            <th class="align-middle text-center text-nowrap">SNO.</th>
                                            <th class="align-middle text-center text-nowrap">INVOICE#</th>
                                            <th class="align-middle text-center text-nowrap">PAYMENT METHOD</th>
                                            <th class="align-middle text-center text-nowrap">METHOD NAME</th>
                                            <th class="align-middle text-center text-nowrap">TRANSACTION ID</th>
                                            <th class="align-middle text-center text-nowrap">BRAND</th>
                                            <th class="align-middle text-center text-nowrap">TEAM</th>
                                            <th class="align-middle text-center text-nowrap">AGENT</th>
                                            <th class="align-middle text-center text-nowrap">CUSTOMER</th>
                                            <th class="align-middle text-center text-nowrap">AMOUNT</th>
                                            <th class="align-middle text-center text-nowrap">STATUS</th>
                                            <th class="align-middle text-center text-nowrap">PAYMENT DATE</th>
                                            <th class="align-middle text-center text-nowrap">CREATE DATE</th>
                                            {{--                                            <th class="align-middle text-center text-nowrap">ACTION</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($payments as $payment)
                                            <tr id="tr-{{$payment->id}}">
                                                <td class="align-middle text-center text-nowrap"></td>
                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    <span
                                                        class="invoice-number">{{ optional($payment->invoice)->invoice_number }}</span><br>
                                                    <span
                                                        class="invoice-key">{{ optional($payment->invoice)->invoice_key }}</span>
                                                </td>
                                                <td class="align-middle text-center text-nowrap">{{isset($payment->payment_gateway) ? optional($payment->payment_gateway)->name : ucwords($payment->payment_method)}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->payment_gateway)->descriptor ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$payment->transaction_id}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->brand)->name ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->team)->name ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->agent)->name ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->customer_contact)->name ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    {{ $payment->currency ." ". number_format($payment->amount, 2, '.', '') }}
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if($payment->status == 0)
                                                        <span class="badge bg-warning text-dark">Due</span>
                                                    @elseif($payment->status == 1)
                                                        <span class="badge bg-success">Paid</span>
                                                    @elseif($payment->status == 2)
                                                        <span class="badge bg-danger">Refund</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if($payment->payment_date)
                                                        {{ $payment->payment_date_formatted }}
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if($payment->created_at)
                                                        {{ $payment->created_at_formatted }}
                                                    @endif
                                                </td>
                                                {{--                                                <td class="align-middle text-center table-actions">--}}
                                                {{--                                                    <button type="button" class="btn btn-sm btn-primary editBtn"--}}
                                                {{--                                                            data-id="{{ $payment->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i--}}
                                                {{--                                                            class="fas fa-edit"></i></button>--}}
                                                {{--                                                </td>--}}
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('admin.payments.custom-form')
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    @push('script')
        <script src="{{asset('assets/js/moment.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/daterangepicker/daterangepicker.min.js')}}"></script>
        @include('admin.payments.script')
    @endpush
@endsection
