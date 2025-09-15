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

                            <div class="form-group col-md-2">
                                <label for="teamSelect">Select Team:</label>
                                <select id="teamSelect" name="teamSelect" class="form-control">
                                    <option value="all">All Teams</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->team_key }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="brandSelect">Select Brand:</label>
                                <select id="brandSelect" name="brandSelect" class="form-control">
                                    <option value="all">All Brands</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->brand_key }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="dateRangePicker">Select Date Range:</label>
                                <input type="text" id="dateRangePicker" name="dateRangePicker"
                                       class="form-control dateRangePicker"/>
                            </div>
                            <button class="start-tour-btn my-btn" data-toggle="tooltip" title="Take a Tour"
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
                                <button class="my-btn start-tour-btn tour-paymenttitle" data-toggle="tooltip"
                                        title="Take a Tour" data-tour="payment"><i
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
                                                    {{\carbon\carbon::parse($payment->payment_date)->timezone('GMT+5')->format('M d, Y g:i A')}}
                                                    GMT+5
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
                                                {{--                                                <td class="align-middle text-center table-actions">--}}
                                                {{--                                                    <button type="button" class="btn btn-sm btn-primary editBtn"--}}
                                                {{--                                                            data-id="{{ $payment->id }}" title="Edit"><i--}}
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
        @include('admin.payments.script')
        <!-- Date Range Picker -->
        <script src="{{asset('assets/js/moment.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/daterangepicker/daterangepicker.min.js')}}"></script>

        <script>
            $(document).ready(function () {
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

                var paymentsTable = $.fn.DataTable.isDataTable('#allPaymentsTable')
                    ? $('#allPaymentsTable').DataTable()
                    : $('#allPaymentsTable').DataTable({
                        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        responsive: true,
                        scrollX: true,
                        processing: true,
                        initComplete: function() {
                            // Hide the table initially if needed
                            $('#allPaymentsTable').show();
                        }
                    });

                // 2. Filter change handler
                $('#teamSelect, #brandSelect').change(function() {
                    filterPayments();
                });
                $('#dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
                    filterPayments();
                });

                // 3. Main filter function
                function filterPayments() {
                    var teamKey = $('#teamSelect').val();
                    var brandKey = $('#brandSelect').val();
                    var dateRange = $('#dateRangePicker').val();


                    paymentsTable.processing(true);

                    $.ajax({
                        url: '{{ route("admin.payment.filter") }}',
                        type: 'GET',
                        data: {
                            team_key: teamKey,
                            brand_key: brandKey,
                            date_range: dateRange
                        },
                        success: function(response) {
                            paymentsTable.clear();

                            if (response && response.success && response.data) {
                                response.data.forEach(function(payment, index) {
                                    paymentsTable.row.add([
                                        '',
                                        index + 1,
                                        payment.invoice ?
                                            `<span class="invoice-number">${payment.invoice.invoice_number || '---'}</span><br>
                             <span class="invoice-key">${payment.invoice.invoice_key || '---'}</span>`
                                            : '---',
                                        payment.payment_gateway ? payment.payment_gateway.name :
                                            payment.payment_method ? payment.payment_method.charAt(0).toUpperCase() +
                                                payment.payment_method.slice(1) : '---',
                                        payment.payment_gateway?.descriptor || '---',
                                        payment.transaction_id || '---',
                                        payment.brand?.name || '---',
                                        payment.team?.name || '---',
                                        payment.agent?.name || '---',
                                        payment.customer_contact?.name || '---',
                                        '$' + (payment.amount || '0.00'),
                                        getStatusBadge(payment.status),
                                        payment.payment_date || '---',
                                        payment.created_at || '---'
                                    ]);
                                });
                            } else {
                                paymentsTable.row.add([
                                    'No payments found', '', '', '', '', '', '', '', '', '', '', '', ''
                                ]);
                            }

                            paymentsTable.draw();
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr.responseText);

                        },
                        complete: function() {
                            paymentsTable.processing(false);
                        }
                    });
                }

                // Helper function
                function getStatusBadge(status) {
                    switch(status) {
                        case 0: return '<span class="badge bg-warning text-dark">Due</span>';
                        case 1: return '<span class="badge bg-success">Paid</span>';
                        case 2: return '<span class="badge bg-danger">Refund</span>';
                        default: return '<span class="badge bg-secondary">Unknown</span>';
                    }
                }

                // Initial load
                filterPayments();
            });

        </script>
    @endpush
@endsection
