@extends('admin.layouts.app')
@section('title','Customer Companies')
@section('datatable', true)
@section('content')
    @push('style')
        @include('admin.customers.companies.style')
    @endpush
    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2">Companies <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
{{--                        <h2 id="record-count" class="h6"> {{count ($customer_companies)}} records</h2>--}}
                    </div>
                    <div class="filters">
                        <div class="actions">
                            {{--                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>--}}

{{--                            <button class="header_btn">Actions <i class="fa fa-caret-down" aria-hidden="true"></i>--}}
{{--                            </button>--}}
{{--                            <button class="header_btn">Import</button>--}}
                            {{--                            <button class="create-contact open-form-btn">Create New</button>--}}
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="content__boxed">
            <div class="content__wrap">
                <div class="container" style="min-width: 100%;">
                    <div class="custom-tabs">
                        <ul class="tab-nav">
                            <li class="tab-item active" data-tab="home">Companies
                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>
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
                                    <table id="allEmployeesTable" class="table table-striped datatable-exportable
                            stripe row-border order-column nowrap
                            initTable
                            ">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th class="align-middle text-center text-nowrap">SNO.</th>
                                            <th class="align-middle text-center text-nowrap">COMPANY DOMAIN</th>
                                            <th class="align-middle text-center text-nowrap">COMPANY NAME</th>
                                            <th class="align-middle text-center text-nowrap">CREATE DATE (GMT+5)</th>
                                            <th class="align-middle text-center text-nowrap">PHONE NUMBER</th>
                                            <th class="align-middle text-center text-nowrap">ADDRESS</th>
                                            <th class="align-middle text-center text-nowrap">CITY</th>
                                            <th class="align-middle text-center text-nowrap">STATE</th>
                                            <th class="align-middle text-center text-nowrap">COUNTRY</th>
                                            <th class="align-middle text-center text-nowrap">POSTAL CODE</th>
                                            <th class="align-middle text-center text-nowrap">INDUSTRY</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($customer_companies as $key => $company)
                                            <tr id="tr-{{$company->id}}">
                                                <td class="align-middle text-center text-nowrap"></td>
                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$company->domain}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$company->name}}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if ($company->created_at->isToday())
                                                        Today
                                                        at {{ $company->created_at->timezone('GMT+5')->format('g:i A') }}
                                                        GMT+5
                                                    @else
                                                        {{ $company->created_at->timezone('GMT+5')->format('M d, Y g:i A') }}
                                                        GMT+5
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap">{{$company->phone}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$company->address}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$company->city}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$company->state}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$company->country}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$company->zipcode}}</td>
                                                <td class="align-middle text-center text-nowrap">{{isset($company->response->industry)? json_decode($company->response)->industry:"---"}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('admin.customers.companies.custom-form')
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    @push('script')
        @include('admin.customers.companies.script')
    @endpush
@endsection
