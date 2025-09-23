@extends('admin.layouts.app')
@section('title','Invoices')
@section('datatable', true)
@section('content')
    @push('style')
        @include('admin.invoices.style')
    @endpush
    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2 ">Invoices <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
                        {{--                        <h2 id="record-count" class="h6">{{count($invoices)}} records</h2>--}}


                    </div>
                    <div class="filters">
                        <div class="actions">
                            {{--                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>--}}

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
                                <label for="dateRangePicker">Select Date Range:</label>
                                <input type="text" id="dateRangePicker" name="dateRangePicker"
                                       class="form-control dateRangePicker"/>
                            </div>
                            <button class="start-tour-btn my-btn" data-toggle="tooltip" title="Take a Tour"
                                    data-tour="invoicecreate"><i class="fas fa-exclamation-circle custom-dot"></i>
                            </button>
                            <button class="create-contact open-form-btn tour-createinvoice">Create New</button>
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="content__boxed tour-invoicealldata">
            <div class="content__wrap">
                <div class="container" style="min-width: 100%;">
                    <div class="custom-tabs">
                        <ul class="tab-nav">
                            <li class="tab-item active" data-tab="home">Invoices
                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>
                            <li style="margin: 9px 2px">
                                <button class="my-btn start-tour-btn tour-invoicetitle" data-toggle="tooltip"
                                        title="Take a Tour" data-tour="invoices"><i
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
                                    <table id="allInvoicesTable" class="table table-striped datatable-exportable
                                            stripe row-border order-column nowrap
                                            initTable
                                            ">
                                        <thead>

                                        <tr>
                                            <th></th>
                                            <th class="align-middle text-center text-nowrap">SNO.</th>
                                            <th class="align-middle text-center text-nowrap">ATTEMPT</th>
                                            <th class="align-middle text-center text-nowrap">INVOICE #</th>
                                            <th class="align-middle text-center text-nowrap">BRAND</th>
                                            <th class="align-middle text-center text-nowrap">TEAM</th>
                                            <th class="align-middle text-center text-nowrap">CUSTOMER CONTACT</th>
                                            <th class="align-middle text-center text-nowrap">AGENT</th>
                                            <th class="align-middle text-center text-nowrap">AMOUNT</th>
                                            <th class="align-middle text-center text-nowrap">STATUS</th>
                                            <th class="align-middle text-center text-nowrap">DUE DATE</th>
                                            <th class="align-middle text-center text-nowrap">CREATE DATE</th>
                                            <th class="align-middle text-center text-nowrap tour-invoiceaction">ACTION
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoices as $invoice)
                                            <tr id="tr-{{$invoice->id}}">
                                                <td class="align-middle text-center text-nowrap"></td>
                                                <td class="align-middle text-center text-nowrap"
                                                    data-order="{{$loop->iteration}}">{{$loop->iteration}}</td>
                                                <td class="align-middle space-between text-nowrap" style="text-align: left;">
                                                    @php
                                                        $m=$invoice->invoice_merchants->pluck('merchant_type')->map(fn($t)=>strtolower($t))->toArray();
                                                        $s=['edp'=>0,'authorize'=>0,'stripe'=>0,'paypal'=>0];$f=['edp'=>0,'authorize'=>0,'stripe'=>0,'paypal'=>0];
                                                        if($invoice->payment_transaction_logs){foreach($invoice->payment_transaction_logs as $l){$g=strtolower($l->gateway);$st=strtolower($l->status);if($g=='edp')$st=='success'?$s['edp']++:$f['edp']++;if(in_array($g,['authorize.net','authorize']))$st=='success'?$s['authorize']++:$f['authorize']++;if($g=='stripe')$st=='success'?$s['stripe']++:$f['stripe']++;if($g=='paypal')$st=='success'?$s['paypal']++:$f['paypal']++;}}
                                                        if($invoice->status == 1 && $invoice->payment && array_sum($s) == 0){$pm=strtolower($invoice->payment->payment_method??'');if($pm=='edp')$s['edp']=1;if(in_array($pm,['authorize.net','authorize']))$s['authorize']=1;if($pm=='stripe')$s['stripe']=1;if($pm=='paypal')$s['paypal']=1;}
                                                        $show=false;foreach(['authorize','edp','stripe','paypal'] as $t){if(in_array($t,$m)||$s[$t]>0||$f[$t]>0){$show=true;break;}}
                                                    @endphp
                                                    @if($show)
                                                        @foreach(['authorize','edp','stripe','paypal'] as $t)
                                                            @if(in_array($t,$m)||$s[$t]>0||$f[$t]>0)
                                                                <div style="display:flex;justify-content:space-between;gap:10px;">
                                                                    <span>{{ucfirst($t)}} : </span>
                                                                    <span><span>{{$s[$t]}}</span>-<span class="text-danger">{{$f[$t]}}</span></span>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <div class="text-muted">No Gateway Found</div>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap text-sm invoice-cell">
                                                    <span
                                                        class="invoice-number">{{ $invoice->invoice_number }}</span><br>
                                                    {{--                                                    <span class="invoice-key">{{ $invoice->invoice_key }}</span>--}}
                                                    <span class="invoice-key view-transactions text-primary"
                                                          title="Show transaction logs"
                                                          style="cursor: pointer;"
                                                          data-invoice-key="{{ $invoice->invoice_key }}"><b
                                                            style="font-weight: 600;">{{ $invoice->invoice_key }}</b></span>
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if(isset($invoice->brand))
                                                        <a href="{{route('admin.brand.index')}}?search={{$invoice->brand->name}}">{{ $invoice->brand->name }}</a>
                                                        <br> {{ $invoice->brand->brand_key }}
                                                    @else
                                                        ---
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if(isset($invoice->team))
                                                        <a href="{{route('admin.team.index')}}?search={{$invoice->team->name}}">{{ $invoice->team->name }}</a>
                                                        <br> {{ $invoice->team->team_key }}
                                                    @else
                                                        ---
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if(isset($invoice->customer_contact))
                                                        <a href="{{route('admin.customer.contact.index')}}?search={{$invoice->customer_contact->name}}">{{ $invoice->customer_contact->name }}</a>
                                                        {{--                                                        <a href="{{route('admin.customer.contact.edit',[$invoice->customer_contact->id])}}">{{ $invoice->customer_contact->name }}</a>--}}
                                                        {{--                                                        <br> {{ $invoice->customer_contact->special_key }}--}}
                                                    @else
                                                        ---
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if(isset($invoice->agent_id , $invoice->agent_type ,$invoice->agent ))
                                                        <a href="{{route('admin.employee.index')}}?search={{$invoice->agent->name}}">{{ $invoice->agent->name }}</a>
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
                                                    @elseif($invoice->status == 3)
                                                        <span class="badge bg-danger">Charge Back</span>
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
                                                <td class="align-middle text-center table-actions ">
                                                    @if(isset($invoice->brand))
                                                        <button type="button" class="btn btn-sm btn-primary copyBtn"
                                                                data-id="{{ $invoice->id }}"
                                                                data-invoice-key="{{ $invoice->invoice_key }}"
                                                                @php
                                                                    $baseUrl = '';
                                                                    if (app()->environment('production')) {
                                                                        $baseUrl = url('');
                                                                    } elseif (app()->environment('development')) {
                                                                        $baseUrl = url('');
                                                                    } else {
                                                                        $baseUrl = url('');
                                                                    }
                                                                @endphp
                                                                data-invoice-url="{{ $baseUrl . '/invoice?InvoiceID=' . $invoice->invoice_key }}"
                                                                title="Copy Invoice Url"><i
                                                                class="fas fa-copy"></i></button>
                                                    @endif
                                                    @if(isset($invoice->payment_attachments) && count($invoice->payment_attachments) > 0)
                                                        @php
                                                            $allAttachments = $invoice->payment_attachments->flatMap(function($payment) {
                                                                return json_decode($payment->attachments, true) ?? [];
                                                            });
                                                            $attachmentCount = $allAttachments->count();
                                                        @endphp
                                                        <button type="button"
                                                                class="btn btn-sm btn-primary view-payment-proofs"
                                                                data-invoice-key="{{ $invoice->invoice_key }}"
                                                                title="View Payment Proofs"><i
                                                                class="fas fa-paperclip"></i>
                                                            {{ $attachmentCount }}
                                                        </button>
                                                    @endif
                                                    @if($invoice->status != 1)
                                                        <br>
                                                        <button type="button"
                                                                class="btn btn-sm btn-primary editBtn mt-2"
                                                                data-id="{{ $invoice->id }}" title="Edit"><i
                                                                class="fas fa-edit"></i></button>
                                                        <button type="button"
                                                                class="btn btn-sm btn-danger deleteBtn mt-2"
                                                                data-id="{{ $invoice->id }}" title="Delete"><i
                                                                class="fas fa-trash"></i></button>
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
                    <div id="custom-form-container">
                        @include('admin.invoices.custom-form')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transactionModalLabel">Payment Transaction Logs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="align-top">Attempt #</th>
                            <th class="align-top">Gateway</th>
                            <th class="align-top">Last 4</th>
                            <th class="align-top">Transaction Id</th>
                            <th class="align-top">Amount</th>
                            <th class="align-top">Message</th>
                            <th class="align-top">Response Code Message</th>
                            <th class="align-top">Avs Message</th>
                            <th class="align-top">Cvv Message</th>
                            <th class="align-top">Cavv Message</th>
                            <th class="align-top">Payment Status</th>
                            <th class="align-top">Date</th>
                        </tr>
                        </thead>
                        <tbody id="transactionLogs"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentProofModal" tabindex="-1" aria-labelledby="paymentProofModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentProofModalLabel">Payment Proofs for Invoice: <span
                            id="modalInvoiceId"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="overflow-y: auto;max-height: 350px">
                    <table class="table table-striped" id="paymentProofTable">
                        <thead>
                        <tr>
                            <th class="align-middle text-center">ID</th>
                            <th class="align-middle text-center">FILE NAME</th>
                            <th class="align-middle text-center">TYPE</th>
                            <th class="align-middle text-center">PREVIEW</th>
                            <th class="align-middle text-center">UPLOADED AT</th>
                            <th class="align-middle text-center">ACTIONS</th>
                        </tr>
                        </thead>
                        <tbody id="paymentProofsTbody">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional: Add a separate modal for file previews (e.g., PDF/images) -->
    <div class="modal fade" id="filePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewFileName">File Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <iframe id="pdfPreview" src="" style="width:100%; height:500px; border:none;"></iframe>
                    <img id="imagePreview" src="" class="img-fluid" style="display:none;">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @push('script')
        <script src="{{asset('assets/js/moment.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/daterangepicker/daterangepicker.min.js')}}"></script>
        <!-- INDEX SCRIPT -->
        @include('admin.invoices.script')
    @endpush
@endsection
