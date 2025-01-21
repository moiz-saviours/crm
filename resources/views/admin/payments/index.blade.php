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
                        <h1 class="page-title mb-2">Payments <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
                        <h2 id="record-count" class="h6">{{ count($all_payments) }} records</h2>
                    </div>
                    <div class="filters">
                        <div class="actions">
                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>

                            <button class="header_btn">Actions <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </button>
                            <button class="header_btn">Import</button>
                            <button class="create-contact open-form-btn">Create New</button>
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="content__boxed">
            <div class="content__wrap">
                <div class="container">
                    <div class="custom-tabs">
                        <ul class="tab-nav">
                            <li class="tab-item active" data-tab="home">Payments
                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home">
                            <div class="card">
                                <div class="card-header">
                                    <div class="container">
                                        <div class="row fltr-sec">
                                            <div class="col-md-8">
                                                <ul class="custm-filtr">
                                                    <div class="table-li">
                                                        <li class="">Company Owner <i class="fa fa-caret-down"
                                                                                      aria-hidden="true"></i></li>
                                                        <li class="">Create date <i class="fa fa-caret-down"
                                                                                    aria-hidden="true"></i></li>
                                                        <li class="">Last activity date <i class="fa fa-caret-down"
                                                                                           aria-hidden="true"></i>
                                                        </li>
                                                        <li class="">Lead status <i class="fa fa-caret-down"
                                                                                    aria-hidden="true"></i></li>
                                                        <li class=""><i class="fa fa-bars" aria-hidden="true"></i> All
                                                            filters
                                                        </li>
                                                    </div>
                                                </ul>
                                            </div>
                                            <div class="col-md-4 right-icon" id="right-icon-0"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="allPaymentsTable" class="table table-striped datatable-exportable
                            stripe row-border order-column nowrap
                            initTable
                            ">
                                        <thead>

                                        <tr>
                                            <th><input type="checkbox"></th>
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
                                            <th class="align-middle text-center text-nowrap">ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all_payments as $payment)
                                            <tr id="tr-{{$payment->id}}">
                                                <td class="align-middle text-center text-nowrap"></td>
                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    <span class="invoice-number">{{ optional($payment->invoice)->invoice_number }}</span><br>
                                                    <span class="invoice-key">{{ optional($payment->invoice)->invoice_key }}</span>
                                                </td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->payment_gateway)->name}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->payment_gateway)->descriptor}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$payment->transaction_id}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->brand)->name ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->team)->name ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->agent)->name ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment->customer)->name ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">${{$payment->amount}}</td>
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
                                                <td class="align-middle text-center table-actions">
                                                    <button type="button" class="btn btn-sm btn-primary editBtn"
                                                            data-id="{{ $payment->id }}" title="Edit"><i
                                                            class="fas fa-edit"></i></button>

                                                </td>
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
        @include('admin.payments.script')
    @endpush
@endsection
