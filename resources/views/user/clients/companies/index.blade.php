@extends('user.layouts.app')
@section('title','Client Contact Companies')
@section('datatable', true)
@push('breadcrumb')
{{--    <li class="breadcrumb-item text-sm active" aria-current="page"><a href="{{route('user.brand.index')}}">Brand</a>--}}
{{--    </li>--}}
@endpush
@section('content')
    @push('style')
        @include('user.clients.companies.style')
    @endpush
    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2">Companies <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
{{--                        <h2 id="record-count" class="h6">{{count($client_companies) }} records</h2>--}}
                    </div>
                    <div class="filters">
                        <div class="actions">
                            {{--                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>--}}

{{--                            <button class="header_btn" disabled>Actions <i class="fa fa-caret-down" aria-hidden="true"></i>--}}
{{--                            </button>--}}
{{--                            <button class="header_btn" disabled>Import</button>--}}
                            {{--                            <button type="button" class="create-contact open-form-btn" data-bs-target="#create-modal" data-bs-toggle="modal">Add New</button>--}}
                            <button class="create-contact open-form-btn">Create New</button>

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

{{--                                                        <li class=""><i class="fa fa-bars" aria-hidden="true"></i> All--}}
{{--                                                            filters--}}
{{--                                                        </li>--}}
{{--                                                    </div>--}}
{{--                                                </ul>--}}
                                            </div>
                                            <div class="col-md-4 right-icon" id="right-icon-0"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="allClientCompaniesTable" class="table table-striped datatable-exportable
                            stripe row-border order-column nowrap
                            initTable ">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th class="align-middle text-center text-nowrap">SNO.</th>
                                            <th class="align-middle text-center text-nowrap">CONTACT</th>
                                            <th class="align-middle text-center text-nowrap">LOGO</th>
                                            <th class="align-middle text-center text-nowrap">NAME</th>
                                            <th class="align-middle text-center text-nowrap">EMAIL</th>
                                            <th class="align-middle text-center text-nowrap">URL</th>
                                            <th class="align-middle text-center text-nowrap">DESCRIPTION</th>
                                            <th class="align-middle text-center text-nowrap">STATUS</th>
                                            <th class="align-middle text-center text-nowrap">ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($client_companies as $key => $client_company)
                                            <tr id="tr-{{$client_company->id}}">
                                                <td class="align-middle text-center text-nowrap"></td>
                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($client_company->client_contact)->name}}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @php
                                                        $logoUrl = filter_var($client_company->logo, FILTER_VALIDATE_URL) ? $client_company->logo : asset('assets/images/clients/companies/logos/'.$client_company->logo);
                                                    @endphp
                                                    <object data="{{ $logoUrl }}" class="avatar avatar-sm me-3" title="{{ $client_company->name }}" ><img src="{{ $logoUrl }}" alt="{{ $client_company->name }}" class="avatar avatar-sm me-3" title="{{ $client_company->name }}"></object>
                                                </td>
                                                <td class="align-middle text-center text-nowrap">{{$client_company->name}}
                                                </td>
                                                <td class="align-middle text-center text-nowrap">{{$client_company->email}}
                                                </td>
                                                <td class="align-middle text-center text-nowrap">{{$client_company->url}}
                                                </td>
                                                <td class="align-middle text-center text-nowrap">{{$client_company->description}}
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    <input type="checkbox" class="status-toggle change-status"
                                                           data-id="{{ $client_company->id }}"
                                                           {{ $client_company->status == 1 ? 'checked' : '' }} data-bs-toggle="toggle">
                                                </td>
                                                <td class="align-middle text-center table-actions">
                                                    <button type="button" class="btn btn-sm btn-primary editBtn"
                                                            data-id="{{ $client_company->id }}" title="Edit"><i
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
                    @include('user.clients.companies.custom-form')
                </div>
            </div>
        </div>
    </section>


    @push('script')
        @include('user.clients.companies.script')
    @endpush
@endsection
