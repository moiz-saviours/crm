@extends('admin.layouts.app')
@section('title','Client Accounts')
@section('datatable', true)
@section('content')
    @push('style')
        @include('admin.payment-merchants.style')
    @endpush
    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2 ">Client Accounts <i class="fa fa-caret-down" aria-hidden="true"></i>
                        </h1>
                        {{--                        <h2 id="record-count" class="h6">{{count($payment_merchants)}} records</h2>--}}

                    </div>
                    <div class="filters">
                        <div class="actions">
                            {{--                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>--}}

                            {{--                            <button class="header_btn">Actions <i class="fa fa-caret-down" aria-hidden="true"></i>--}}
                            {{--                            </button>--}}
                            {{--                            <button class="header_btn">Import</button>--}}
                            <button class="start-tour-btn my-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Take a Tour" data-tour="client_account_create"> <i class="fas fa-exclamation-circle custom-dot"></i> </button>
                            <button class="create-contact open-form-btn tour-createclientaccount">Create New</button>
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="content__boxed tour-clientaccountalldata">
            <div class="content__wrap">
                <div class="container" style="min-width: 100%;">
                    <div class="custom-tabs">
                        <ul class="tab-nav">
                            <li class="tab-item active" data-tab="home">Accounts
                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>
                            <li style="margin: 9px 2px"><button class="my-btn start-tour-btn tour-clientaccounttitle" data-bs-toggle="tooltip" data-bs-placement="top" title="Take a Tour" data-tour="client_account"><i class="fas fa-exclamation-circle custom-dot"></i> </button></li>
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
                                    <table id="allClientTable" class="table table-striped datatable-exportable
                            stripe row-border order-column nowrap initTable">
                                        <thead>

                                        <tr>
                                            <th></th>
                                            <th class="align-middle text-center text-nowrap">SNO.</th>
                                            <th class="align-middle text-center text-nowrap">CLIENT CONTACT</th>
                                            <th class="align-middle text-center text-nowrap">CLIENT COMPANY</th>
                                            <th class="align-middle text-center text-nowrap">NAME</th>
                                            <th class="align-middle text-center text-nowrap">DESCRIPTOR</th>
                                            {{--                                            <th class="align-middle text-center text-nowrap">VENDOR NAME</th>--}}
                                            <th class="align-middle text-center text-nowrap">PAYMENT METHOD</th>
                                            <th class="align-middle text-center text-nowrap">EMAIL</th>
                                            <th class="align-middle text-center text-nowrap">LOGIN ID</th>
                                            <th class="align-middle text-center text-nowrap">TRANSACTION KEY</th>
                                            <th class="align-middle text-center text-nowrap">MAX TRANSACTION</th>
                                            <th class="align-middle text-center text-nowrap">MAX VOLUME</th>
                                            <th class="align-middle text-center text-nowrap">{{ \Carbon\Carbon::now()->format('F') }}
                                                Usage
                                            </th>
                                            <th class="align-middle text-center text-nowrap">ENVIRONMENT</th>
                                            <th class="align-middle text-center text-nowrap tour-clientaccountstatus">STATUS</th>
                                            <th class="align-middle text-center text-nowrap tour-clientaccountaction">ACTION</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($payment_merchants as $payment_merchant)
                                            <tr id="tr-{{$payment_merchant->id}}">
                                                <td class="align-middle text-center text-nowrap"></td>
                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment_merchant->client_contact)->name}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($payment_merchant->client_company)->name}}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $payment_merchant->name }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $payment_merchant->descriptor }}</td>
                                                {{--                                                <td class="align-middle text-center text-nowrap">{{ $payment_merchant->vendor_name }}</td>--}}
                                                <td class="align-middle text-center text-nowrap">{{ strtoupper($payment_merchant->payment_method) }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $payment_merchant->email }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $payment_merchant->login_id }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $payment_merchant->transaction_key }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $payment_merchant->limit }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $payment_merchant->capacity }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $payment_merchant->usage }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $payment_merchant->environment }}</td>
                                                <td class="align-middle text-center text-nowrap ">
                                                    <input type="checkbox" class="status-toggle change-status"
                                                           data-id="{{ $payment_merchant->id }}"
                                                           {{ $payment_merchant->status == "active" ? 'checked' : '' }} data-bs-toggle="toggle">
                                                </td>

                                                <td class="align-middle text-center table-actions ">
                                                    <button type="button" class="btn btn-sm btn-primary editBtn"
                                                            data-id="{{ $payment_merchant->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i
                                                            class="fas fa-edit"></i></button>

                                                    <button type="button" class="btn btn-sm btn-danger deleteBtn"
                                                            data-id="{{ $payment_merchant->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i
                                                            class="fas fa-trash"></i></button>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('admin.payment-merchants.custom-form')
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    @push('script')
        @include('admin.payment-merchants.script')
    @endpush
@endsection
