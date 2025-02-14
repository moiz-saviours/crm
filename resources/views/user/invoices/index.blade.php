@extends('user.layouts.app')
@section('title','Invoices')
@section('datatable', true)
@section('content')
    @push('style')
        @include('user.invoices.style')

    @endpush

    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2">Invoices <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
                        {{--                        <h2 id="record-count" class="h6">{{count ($invoices)}} records</h2>--}}
                    </div>
                    <div class="filters">
                        <div class="actions">
                            {{--                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>--}}

                            {{--                            <button class="header_btn">Actions <i class="fa fa-caret-down" aria-hidden="true"></i>--}}
                            {{--                            </button>--}}
                            {{--                            <button class="header_btn">Import</button>--}}
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
                            <li class="tab-item active" data-tab="home">All Invoices <i class="fa fa-times close-icon"
                                                                                        aria-hidden="true"></i></li>
                            <li class="tab-item my" data-tab="home">My Invoices <i class="fa fa-times close-icon"
                                                                                   aria-hidden="true"></i></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home">
                            <div class="card">
                                {{--                                <div class="card-header">--}}
                                {{--                                    <div class="container">--}}
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
                                    <table id="allInvoicesTable" class="table table-striped datatable-exportable
                            stripe row-border order-column nowrap
                            initTable
                            ">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th class="align-middle text-center text-nowrap">SNO.</th>
                                            <th class="align-middle text-center text-nowrap">INVOICE #</th>
                                            <th class="align-middle text-center text-nowrap">BRAND</th>
                                            <th class="align-middle text-center text-nowrap">TEAM</th>
                                            <th class="align-middle text-center text-nowrap">CUSTOMER CONTACT</th>
                                            <th class="align-middle text-center text-nowrap">AGENT</th>
                                            <th class="align-middle text-center text-nowrap">AMOUNT</th>
                                            <th class="align-middle text-center text-nowrap">STATUS</th>
                                            <th class="align-middle text-center text-nowrap">DUE DATE</th>
                                            <th class="align-middle text-center text-nowrap">CREATE DATE</th>
                                            <th class="align-middle text-center text-nowrap">ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($invoices as $invoice)
                                            <tr id="tr-{{$invoice->id}}">
                                                <td class="align-middle text-center text-nowrap"></td>
                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                <td class="align-middle text-center text-nowrap text-sm invoice-cell">
                                                    <span
                                                        class="invoice-number">{{ $invoice->invoice_number }}</span><br>
                                                    <span class="invoice-key">{{ $invoice->invoice_key }}</span>
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if(isset($invoice->brand))
                                                        {{ $invoice->brand->name }}
                                                    @else
                                                        ---
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if(isset($invoice->team))
                                                        {{ $invoice->team->name }}
                                                    @else
                                                        ---
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if(isset($invoice->customer_contact))
                                                        {{--                                                        <a href="{{route('customer.contact.edit',[$invoice->customer_contact->id])}}">{{ $invoice->customer_contact->name }}</a>--}}
                                                        {{ $invoice->customer_contact->name }}
                                                    @else
                                                        ---
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if(isset($invoice->agent_id , $invoice->agent_type ,$invoice->agent ))
                                                        {{ $invoice->agent->name }}
                                                    @else
                                                        ---
                                                    @endif
                                                </td>
                                                <td class="align-middle space-between text-nowrap"
                                                    style="text-align: left;">
                                                    <div
                                                        style="display: flex; justify-content: space-between; gap: 10px;">
                                                        <span style="width: 120px; ">Amount:</span>
                                                        <span>{{ $invoice->currency ." ". number_format($invoice->amount, 2, '.', '') }}</span>
                                                    </div>
                                                    <div
                                                        style="display: flex; justify-content: space-between; gap: 10px;">
                                                        <span style="width: 120px; ">Tax:</span>
                                                        <span>{{ $invoice->tax_type == 'percentage' ? '%' : ($invoice->tax_type == 'fixed' ? $invoice->currency : '') }} {{ $invoice->tax_value ?? 0 }}</span>
                                                    </div>
                                                    <div
                                                        style="display: flex; justify-content: space-between; gap: 10px;">
                                                        <span style="width: 120px; ">Tax Amount:</span>
                                                        <span>{{ $invoice->currency ." ". number_format($invoice->tax_amount, 2, '.', '') }}</span>
                                                    </div>
                                                    <div
                                                        style="display: flex; justify-content: space-between; gap: 10px;">
                                                        <span style="width: 120px; ">Total Amount:</span>
                                                        <span>{{ $invoice->currency ." ". number_format($invoice->total_amount, 2, '.', '') }}</span>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if($invoice->status == 0)
                                                        <span class="badge bg-warning text-dark">Due</span>
                                                    @elseif($invoice->status == 1)
                                                        <span class="badge bg-success">Paid</span>
                                                    @elseif($invoice->status == 2)
                                                        <span class="badge bg-danger">Refund</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap">{{Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d')}}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if ($invoice->created_at->isToday())
                                                        Today
                                                        at {{ $invoice->created_at->timezone('GMT+5')->format('g:i A') }}
                                                        GMT+5
                                                    @else
                                                        {{ $invoice->created_at->timezone('GMT+5')->format('M d, Y g:i A') }}
                                                        GMT+5
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center table-actions">
                                                    @if(isset($invoice->brand))
                                                        <button type="button" class="btn btn-sm btn-primary copyBtn"
                                                                data-id="{{ $invoice->id }}"
                                                                data-invoice-key="{{ $invoice->invoice_key }}"
                                                                data-invoice-url="{{ url('invoice?InvoiceID=' . $invoice->invoice_key) }}"
                                                                title="Copy Invoice Url"><i
                                                                class="fas fa-copy"></i></button>
                                                    @endif
                                                    @if($invoice->status != 1 && ((isset($invoice->agent) && $invoice->agent->id === auth()->user()->id) || (isset($invoice->creator) && $invoice->creator->id === auth()->user()->id)))
                                                        <button type="button" class="btn btn-sm btn-primary editBtn"
                                                                data-id="{{ $invoice->id }}" title="Edit"><i
                                                                class="fas fa-edit"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{--                        <div class="tab-pane" id="my-records">--}}
                        {{--                            <div class="card">--}}
                        {{--                                <div class="card-header">--}}
                        {{--                                    <div class="container">--}}
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
                        {{--                                            <div class="col-md-4 right-icon" id="right-icon-1"></div>--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                                <div class="card-body">--}}
                        {{--                                    <table id="MyInvoicesTable" class="table table-striped datatable-exportable--}}
                        {{--                            stripe row-border order-column nowrap--}}
                        {{--                            initTable--}}
                        {{--                            ">--}}
                        {{--                                        <thead>--}}
                        {{--                                        <tr>--}}
                        {{--                                            <th></th>--}}
                        {{--                                            <th class="align-middle text-center text-nowrap">SNO.</th>--}}
                        {{--                                            <th class="align-middle text-center text-nowrap">INVOICE #</th>--}}
                        {{--                                            <th class="align-middle text-center text-nowrap">BRAND</th>--}}
                        {{--                                            <th class="align-middle text-center text-nowrap">TEAM</th>--}}
                        {{--                                            <th class="align-middle text-center text-nowrap">CUSTOMER CONTACT</th>--}}
                        {{--                                            <th class="align-middle text-center text-nowrap">AGENT</th>--}}
                        {{--                                            <th class="align-middle text-center text-nowrap">AMOUNT</th>--}}
                        {{--                                            <th class="align-middle text-center text-nowrap">STATUS</th>--}}
                        {{--                                            <th class="align-middle text-center text-nowrap">DUE DATE</th>--}}
                        {{--                                            <th class="align-middle text-center text-nowrap">CREATE DATE</th>--}}
                        {{--                                        </tr>--}}
                        {{--                                        </thead>--}}
                        {{--                                        <tbody>--}}

                        {{--                                        @foreach($my_invoices as $invoice)--}}
                        {{--                                            <tr id="tr-{{$invoice->id}}">--}}

                        {{--                                                <td class="align-middle text-center text-nowrap"></td>--}}
                        {{--                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>--}}
                        {{--                                                <td class="align-middle text-center text-nowrap">--}}
                        {{--                                                    <span class="invoice-number">{{ $invoice->invoice_number }}</span><br>--}}
                        {{--                                                    <span class="invoice-key">{{ $invoice->invoice_key }}</span>--}}
                        {{--                                                </td>--}}
                        {{--                                                <td class="align-middle text-center text-nowrap">{{optional($invoice->brand)->name ?? "---"}}</td>--}}
                        {{--                                                <td class="align-middle text-center text-nowrap">{{optional($invoice->team)->name ?? "---"}}</td>--}}
                        {{--                                                <td class="align-middle text-center text-nowrap">{{optional($invoice->customer_contact)->name ?? "---"}}</td>--}}
                        {{--                                                <td class="align-middle text-center text-nowrap">{{optional($invoice->agent)->name ?? "---"}}</td>--}}
                        {{--                                                <td class="align-middle space-between text-nowrap"--}}
                        {{--                                                    style="text-align: left;">--}}
                        {{--                                                    <div--}}
                        {{--                                                        style="display: flex; justify-content: space-between; gap: 10px;">--}}
                        {{--                                                        <span style="width: 120px; ">Amount:</span>--}}
                        {{--                                                        <span>{{ $invoice->currency ." ". number_format($invoice->amount, 2, '.', '') }}</span>--}}
                        {{--                                                    </div>--}}
                        {{--                                                    <div--}}
                        {{--                                                        style="display: flex; justify-content: space-between; gap: 10px;">--}}
                        {{--                                                        <span style="width: 120px; ">Tax:</span>--}}
                        {{--                                                        <span>{{ $invoice->tax_type == 'percentage' ? '%' : ($invoice->tax_type == 'fixed' ? $invoice->currency : '') }} {{ $invoice->tax_value ?? 0 }}</span>--}}
                        {{--                                                    </div>--}}
                        {{--                                                    <div--}}
                        {{--                                                        style="display: flex; justify-content: space-between; gap: 10px;">--}}
                        {{--                                                        <span style="width: 120px; ">Tax Amount:</span>--}}
                        {{--                                                        <span>{{ $invoice->currency ." ". number_format($invoice->tax_amount, 2, '.', '') }}</span>--}}
                        {{--                                                    </div>--}}
                        {{--                                                    <div--}}
                        {{--                                                        style="display: flex; justify-content: space-between; gap: 10px;">--}}
                        {{--                                                        <span style="width: 120px; ">Total Amount:</span>--}}
                        {{--                                                        <span>{{ $invoice->currency ." ". number_format($invoice->total_amount, 2, '.', '') }}</span>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </td>--}}
                        {{--                                                <td class="align-middle text-center text-nowrap">--}}
                        {{--                                                    @if($invoice->status == 0)--}}
                        {{--                                                        <span class="badge bg-warning text-dark">Due</span>--}}
                        {{--                                                    @elseif($invoice->status == 1)--}}
                        {{--                                                        <span class="badge bg-success">Paid</span>--}}
                        {{--                                                    @endif--}}
                        {{--                                                </td>--}}
                        {{--                                                <td class="align-middle text-center text-nowrap">{{Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d')}}</td>--}}
                        {{--                                                <td class="align-middle text-center text-nowrap">--}}
                        {{--                                                    @if ($invoice->created_at->isToday())--}}
                        {{--                                                        Today--}}
                        {{--                                                        at {{ $invoice->created_at->timezone('GMT+5')->format('g:i A') }}--}}
                        {{--                                                        GMT+5--}}
                        {{--                                                    @else--}}
                        {{--                                                        {{ $invoice->created_at->timezone('GMT+5')->format('M d, Y g:i A') }}--}}
                        {{--                                                        GMT+5--}}
                        {{--                                                    @endif--}}
                        {{--                                                </td>--}}
                        {{--                                            </tr>--}}
                        {{--                                        @endforeach--}}
                        {{--                                        </tbody>--}}
                        {{--                                    </table>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    @include('user.invoices.custom-form')

    @push('script')
        @include('user.invoices.script')
    @endpush
@endsection
