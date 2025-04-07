@extends('user.layouts.app')
@section('title','Payments')
@section('datatable', true)
@section('content')
    @push('style')
        @include('user.payment.style')
        <style>

            .void {
                cursor: not-allowed;
            }

            .custm_header {
                padding: 2px 20px 2px 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .actions {
                display: flex;
            }

            .actions h1 {
                margin: auto;
                color: #52a0bf;
                font-size: 15px;
            }

            .filters,
            .table-controls {
                display: flex;
                justify-content: space-between;
                padding: 10px 20px;
                border-bottom: 1px solid #ddd;
            }

            .filters .filter-tabs button,
            .actions button {
                padding: 5px 12px;
                border: 1px solid #ff5722;
                border-radius: 4px;
                background-color: #fff;
                cursor: pointer;
            }

            .filters .actions .create-contact {
                background-color: #ff5722;
                color: #fff;
                border: none;
            }

            .search-bar input {
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px;
                width: 250px;
            }

            .contacts-table {
                width: 100%;
                border-collapse: collapse;
            }

            .contacts-table th,
            .contacts-table td {
                padding: 10px;
                text-align: left;
                /*border: 1px solid #ddd;*/
            }

            .contacts-table th {
                /*background-color: #f1f5f9;*/
                font-weight: bold;
            }

            .contacts-table tbody tr:hover {
                background-color: #f9f9f9;
            }


            .header .new_head h1 {
                font-size: 20px;
                color: #52a0bf;
                font-weight: 700;

            }

            .header_btn {
                padding: 0px 30px;
                color: #ff5722;
                margin: 0px 10px;
            }

            .custom-tabs {
                margin: 0px 0px 4px 0px;
                display: flex;
            }

            .tab-nav {
                display: flex;
                justify-content: space-around;
                list-style: none;
                padding: 0;
                margin: 0;
                width: 70%;
            }

            .tab-buttons {
                margin-left: 100px;
            }

            .tab-item {
                padding: 10px 20px;
                cursor: pointer;
                border: 1px solid #cbd6e2;
                background: #f9f9f9;
                width: 100%;
                transition: background 0.3s ease;
            }

            .tab-item.active {
                background: #fff;
                border-bottom: none;

            }

            .tab-item.active i {
                float: right;
                font-size: 14px;
                margin: auto;
            }

            .tab-content {
                /*padding: 10px;*/
                /*margin-top: 10px;*/
            }

            .tab-pane {
                display: none;
            }

            .tab-pane.active {
                display: block;

            }

            .fltr-sec {
                padding-top: 20px;
            }

            .table-li {
                display: flex;
            }

            .table-li .page-title {
                font-size: 14px;
                padding: 0px 30px 0px 0px;

                font-weight: 700;
            }

            .right-icon i {
                float: right;
                margin: 0px 4px;
                border: 1px solid #ccc;
                padding: 5px;
                border-radius: 5px;
                font-size: 12px;
            }

            .custom-form .form-container {
                position: fixed;
                top: 0;
                right: -100%;
                width: 500px;
                height: 100%;
                background: #ffffff;
                box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
                transition: right 0.5s ease;
                box-sizing: border-box;
                z-index: 1001;
            }

            .custom-form .form-container.open {
                right: 0;
            }

            .custom-form .form-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 15px 20px;
                background: #52a0bf;
                color: white;
                font-size: 18px;
                font-weight: bold;
            }

            .custom-form .form-header .close-btn {
                font-size: 20px;
                font-weight: bold;
                background: none;
                border: none;
                color: white;
                cursor: pointer;
            }

            .custom-form .form-body {
                padding: 20px;
            }

            .custom-form .form-body label {
                display: block;
                margin-bottom: 5px;
                font-weight: 500;
            }

            .custom-form .form-body input:not(.is-invalid) {
                width: 100%;
                padding: 8px;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }

            .custom-form .form-body button {
                width: 100%;
                padding: 10px;
                background: #52a0bf;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            .close-icon {
                display: none;
            }

            .tab-item.active .close-icon {
                display: inline;
            }

        </style>
    @endpush

    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2">Payments <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
                        {{--                        <h2 id="record-count" class="h6"> {{count ($all_payments)}}records</h2>--}}
                    </div>
                    {{--                    <div class="filters">--}}
                    {{--                        <div class="actions">--}}
                    {{--                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>--}}

                    {{--                            <button class="header_btn" disabled>Actions <i class="fa fa-caret-down" aria-hidden="true"></i>--}}
                    {{--                            </button>--}}
                    {{--                            <button class="header_btn" disabled>Import</button>--}}
                    {{--                            <button class="create-contact open-form-btn void">Create New</button>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </header>
            </div>
        </div>
        <div class="content__boxed">
            <div class="content__wrap">
                <div class="container" style="min-width: 100%;">
                    <div class="custom-tabs">
                        <ul class="tab-nav">
                            <li class="tab-item active all-tab" data-tab="home">All Payments
                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>
                            @if(Auth::user()->department->name === 'Sales')
                                <li class="tab-item  my-tab" data-tab="home">My Payments <i
                                        class="fa fa-times close-icon"
                                        aria-hidden="true"></i></li>
                            @endif
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
                                <div class="card-body">
                                    <table id="allPaymentsTable" class="table table-striped datatable-exportable
                            stripe row-border order-column nowrap
                            initTable
                            ">
                                        <thead>
                                        <tr>
                                            <th class="align-middle text-center text-nowrap"><input type="checkbox">
                                            </th>
                                            <th class="align-middle text-center text-nowrap">SNO.</th>
                                            <th class="align-middle text-center text-nowrap">INVOICE#</th>
                                            <th class="align-middle text-center text-nowrap">PAYMENT METHOD</th>
                                            <th class="align-middle text-center text-nowrap">METHOD NAME</th>
                                            <th class="align-middle text-center text-nowrap">TRANSACTION ID</th>
                                            @if(Auth::user()->department->name === 'Sales')
                                                <th class="align-middle text-center text-nowrap">BRAND</th>
                                                <th class="align-middle text-center text-nowrap">TEAM</th>
                                                <th class="align-middle text-center text-nowrap">AGENT</th>
                                            @endif
                                            <th class="align-middle text-center text-nowrap">CUSTOMER</th>
                                            <th class="align-middle text-center text-nowrap">AMOUNT</th>
                                            <th class="align-middle text-center text-nowrap">STATUS</th>
                                            <th class="align-middle text-center text-nowrap">CREATE DATE</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all_payments as $payment)
                                            <tr id="tr-{{$payment->id}}">
                                                <td class="align-middle text-center text-nowrap"></td>
                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    <span
                                                        class="invoice-number">{{ optional($payment->invoice)->invoice_number ?? "---"}}</span><br>
                                                    <span
                                                        class="invoice-key">{{ optional($payment->invoice)->invoice_key }}</span>
                                                </td>
                                                <td class="align-middle text-center text-nowrap">{{$payment->payment_method}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->payment_gateway)->descriptor ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$payment->transaction_id}}</td>
                                                @if(Auth::user()->department->name === 'Sales')
                                                    <td class="align-middle text-center text-nowrap">{{optional($payment->brand)->name ?? "---"}}</td>
                                                    <td class="align-middle text-center text-nowrap">{{optional($payment->team)->name ?? "---"}}</td>
                                                    <td class="align-middle text-center text-nowrap">{{optional($payment->agent)->name ?? "---"}}</td>
                                                @endif
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->customer_contact)->name ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    ${{$payment->amount}}</td>
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
                                                    @if ($payment->created_at->isToday())
                                                        Today
                                                        at {{ $payment->created_at->timezone('GMT+5')->format('g:i A') }}
                                                        GMT+5
                                                    @else
                                                        {{ $payment->created_at->timezone('GMT+5')->format('M d, Y g:i A') }}
                                                        GMT+5
                                                    @endif
                                                </td>

                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="menu1">
                            <div class="card">
                                <div class="card-header">
                                    <div class="container" style="min-width: 100%;">
                                        <div class="row fltr-sec">
                                            <div class="col-md-8">
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
                                            </div>
                                            <div class="col-md-4 right-icon" id="right-icon-1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="myPaymentsTable" class="table table-striped datatable-exportable
                            stripe row-border order-column nowrap
{{--                            initTable--}}
                            ">
                                        <thead>
                                        <tr>
                                            <th class="align-middle text-center text-nowrap"><input type="checkbox">
                                            </th>
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
                                            <th class="align-middle text-center text-nowrap">CREATE DATE</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($my_payments as $payment)
                                            <tr id="tr-{{$payment->id}}">
                                                <td class="align-middle text-center text-nowrap"></td>
                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    <span
                                                        class="invoice-number">{{ optional($payment->invoice)->invoice_number }}</span><br>
                                                    <span
                                                        class="invoice-key">{{ optional($payment->invoice)->invoice_key }}</span>
                                                </td>
                                                <td class="align-middle text-center text-nowrap">{{$payment->payment_method}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->payment_gateway)->descriptor ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$payment->transaction_id}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->brand)->name ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->team)->name ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->agent)->name ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->customer_contact)->name ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    ${{$payment->amount}}</td>
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
                                                    @if ($payment->created_at->isToday())
                                                        Today
                                                        at {{ $payment->created_at->timezone('GMT+5')->format('g:i A') }}
                                                        GMT+5
                                                    @else
                                                        {{ $payment->created_at->timezone('GMT+5')->format('M d, Y g:i A') }}
                                                        GMT+5
                                                    @endif
                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-form">
                        <div class="form-container" id="formContainer">
                            <!-- Form Header -->
                            <div class="form-header">
                                Add Company
                                <button class="close-btn">×</button>
                            </div>
                            <!-- Form Body -->
                            <div class="form-body">
                                <label for="name">Company Name</label>
                                <input type="text" id="name" placeholder="Enter your name">
                                <label for="email">Company Domain</label>
                                <input type="email" id="email" placeholder="Enter your email">
                                <button>Submit</button>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->

    @push('script')
        @include('user.payment.script')
        <script>

            $(document).ready(function () {
                const formContainer = $('#formContainer');
                $('.open-form-btn').click(function () {
                    $(this).hasClass('void') ? $(this).attr('title', "You don't have access to create a company.").tooltip({placement: 'bottom'}).tooltip('show') : (formContainer.addClass('open'));
                });
                $(document).click(function (event) {
                    if (!$(event.target).closest('#formContainer').length && !$(event.target).is('#formContainer') && !$(event.target).closest('.open-form-btn').length) {
                        formContainer.removeClass('open')
                    }
                });
                $(".tab-item").on("click", function () {
                    // Remove 'active' class from all tabs and panes
                    $(".tab-item").removeClass("active");
                    $(".tab-pane").removeClass("active");

                    $(this).addClass("active");

                    const targetPane = $(this).data("tab");
                    $("#" + targetPane).addClass("active");
                });
            });

        </script>
    @endpush
@endsection
