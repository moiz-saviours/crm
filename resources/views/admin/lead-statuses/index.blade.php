@extends('admin.layouts.app')
@section('title','Lead Statuses')
@section('datatable', true)
@push('breadcrumb')
    <li class="breadcrumb-item text-sm text-white active" aria-current="page"><a
            href="{{route('admin.lead-status.index')}}">Lead Status</a>
    </li>
@endpush
@section('content')
    @push('style')
        @include('admin.lead-statuses.style')
        <style>
            .status-color {
                display: inline-block;
                width: 100px;
                height: 30px;
                border: 1px solid #000;
            }
        </style>
    @endpush

{{--    <div class="container-fluid py-4">--}}
{{--        <div class="row">--}}
{{--            <div class="col-12">--}}
{{--                <div class="card mb-4">--}}
{{--                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">--}}
{{--                        <h6 class="text-center">Lead Status Table</h6>--}}
{{--                        <button type="button" class="btn btn-secondary float-end rounded-pill" data-bs-toggle="modal"--}}
{{--                                id="create-modal-btn" data-bs-target="#create-modal">--}}
{{--                            <i class="fas fa-plus"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                    <div class="card-body px-0 pt-0 pb-2">--}}
{{--                        <div class="table table-responsive p-3">--}}
{{--                            <table id="leadStatusTable" class="table table-striped" style="width: 100%">--}}

{{--                                <thead>--}}
{{--                                <tr>--}}
{{--                                    <th class="align-middle text-center">ID</th>--}}
{{--                                    <th class="align-middle text-center">Name</th>--}}
{{--                                    <th class="align-middle text-center">Color</th>--}}
{{--                                    <th class="align-middle text-center">Description</th>--}}
{{--                                    <th class="align-middle text-center">Status</th>--}}
{{--                                    <th class="align-middle text-center">Actions</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @foreach($leadStatus as $status)--}}
{{--                                    <tr id="tr-{{$status->id}}">--}}
{{--                                        <td class="align-middle text-center">{{ $status->id }}</td>--}}
{{--                                        <td class="align-middle text-center">{{ $status->name }}</td>--}}
{{--                                        <td class="align-middle text-center">--}}
{{--                                            <span class="status-color" style="background-color: {{ $status->color }};"></span>--}}
{{--                                        </td>--}}
{{--                                        <td class="align-middle text-center">{{ $status->description }}</td>--}}
{{--                                        <td class="align-middle text-center text-nowrap">--}}
{{--                                            <input type="checkbox" class="status-toggle change-status"--}}
{{--                                                   data-id="{{ $status->id }}"--}}
{{--                                                   {{ $status->status == 1 ? 'checked' : '' }} data-bs-toggle="toggle">--}}
{{--                                        </td>--}}
{{--                                        <td class="align-middle text-center table-actions">--}}
{{--                                            <a href="javascript:void(0)" data-id="{{ $status->id }}"--}}
{{--                                               class="text-secondary editBtn" title="Edit Record">--}}
{{--                                                <i class="fas fa-edit"></i>--}}
{{--                                            </a>--}}
{{--                                            <a href="javascript:void(0)" class="text-secondary deleteBtn"--}}
{{--                                               data-id="{{ $status->id }}" title="Delete Record">--}}
{{--                                                <i class="fas fa-trash"></i>--}}
{{--                                            </a>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2">Lead Status <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
{{--                        <h2 id="record-count" class="h6"> {{ count($leadStatus) }}records</h2>--}}
                    </div>
                    <div class="filters">
                        <div class="actions">
                            {{--                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>--}}

{{--                            <button class="header_btn">Actions <i class="fa fa-caret-down" aria-hidden="true"></i>--}}
{{--                            </button>--}}
{{--                            <button class="header_btn">Import</button>--}}
                            {{--                            <button type="button" class="create-contact open-form-btn" data-bs-target="#create-modal" data-bs-toggle="modal">Add New</button>--}}
                            <button class="start-tour-btn my-btn" data-toggle="tooltip" title="Take a Tour" data-tour="lead_status_create"> <i class="fas fa-exclamation-circle custom-dot"></i> </button>
                            <button class="create-contact open-form-btn tour-createleadstatus">Create New</button>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="content__boxed tour-leadstatusalldata">
            <div class="content__wrap">
                <div class="container" style="min-width: 100%;">
                    <div class="custom-tabs">
                        <ul class="tab-nav">
                            <li class="tab-item active" data-tab="home">Lead Statuses
                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>
                            <li style="margin: 9px 2px"><button class="my-btn start-tour-btn tour-leadstatustitle" data-toggle="tooltip" title="Take a Tour" data-tour="lead_status"><i class="fas fa-exclamation-circle custom-dot"></i> </button></li>

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
                                    <table id="allLeadsStatusesTable" class="table table-striped datatable-exportable
                            stripe row-border order-column nowrap
                            initTable
                            ">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th class="align-middle text-center text-nowrap">SNO.</th>
                                            <th class="align-middle text-center text-nowrap">NAME</th>
                                            <th class="align-middle text-center text-nowrap">COLOR</th>
                                            <th class="align-middle text-center text-nowrap">DESCRIPTION</th>
                                            <th class="align-middle text-center text-nowrap tour-leadstatus">STATUS</th>
                                            <th class="align-middle text-center text-nowrap tour-leadstatusaction">ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($leadStatus as $status)
                                    <tr id="tr-{{$status->id}}">
                                        <td class="align-middle text-center text-nowrap"></td>
                                        <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                        <td class="align-middle text-center">{{ $status->name }}</td>
                                        <td class="align-middle text-center">
                                            <span class="status-color" style="background-color: {{ $status->color }};"></span>
                                        </td>
                                        <td class="align-middle text-center">{{ $status->description }}</td>
                                        <td class="align-middle text-center text-nowrap">
                                            <input type="checkbox" class="status-toggle change-status"
                                                   data-id="{{ $status->id }}"
                                                   {{ $status->status == 1 ? 'checked' : '' }} data-bs-toggle="toggle">
                                        </td>
                                        <td class="align-middle text-center table-actions">
                                            <button type="button" class="btn btn-sm btn-primary editBtn"
                                                    data-id="{{ $status->id }}" title="Edit"><i
                                                    class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger deleteBtn"
                                                    data-id="{{ $status->id }}" title="Delete"><i
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
                    @include('admin.lead-statuses.custom-form')
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    @include('admin.lead-statuses.create-modal')
{{--    @include('admin.lead-statuses.edit-modal')--}}

    @push('script')
        @include('admin.lead-statuses.script')
    @endpush
@endsection
