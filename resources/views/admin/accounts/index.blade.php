@extends('admin.layouts.app')
@section('title','Admin Accounts')
@section('datatable', true)
@section('content')
    @push('style')
        @include('admin.accounts.style')
    @endpush
    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2">Admin Accounts <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
{{--                        <h2 id="record-count" class="h6">{{count($admins)}} records</h2>--}}

                    </div>
                    <div class="filters">
                        <div class="actions">
                            {{--                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>--}}

{{--                            <button class="header_btn" disabled>Actions <i class="fa fa-caret-down" aria-hidden="true"></i>--}}
{{--                            </button>--}}
{{--                            <button class="header_btn" disabled>Import</button>--}}
                            <button class="start-tour-btn my-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Take a Tour" data-tour="admincreate"> <i class="fas fa-exclamation-circle custom-dot"></i> </button>
                            <button class="create-contact open-form-btn tour-createadmin">Create New</button>
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="content__boxed tour-adminalldata">
            <div class="content__wrap">
                <div class="container" style="min-width: 100%;">
                    <div class="custom-tabs">
                        <ul class="tab-nav">
                            <li class="tab-item active" data-tab="home">Admins
                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>
                            <li style="margin: 9px 2px"> <button class="my-btn start-tour-btn tour-admintitle" data-bs-toggle="tooltip" data-bs-placement="top" title="Take a Tour" data-tour="admins"><i class="fas fa-exclamation-circle custom-dot"></i> </button></li>
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
                                    <table id="alladminsTable" class="table table-striped datatable-exportable
                            stripe row-border order-column nowrap
                            initTable
                            ">
                                        <thead>

                                        <tr>
                                            <th></th>
                                            <th class="align-middle text-center text-nowrap">SNO.</th>
                                            <th class="align-middle text-center text-nowrap">Image</th>
                                            <th class="align-middle text-center text-nowrap">Name</th>
                                            <th class="align-middle text-center text-nowrap">Email</th>
                                            <th class="align-middle text-center text-nowrap">Designation</th>
                                            <th class="align-middle text-center text-nowrap">Status</th>
                                            <th class="align-middle text-center text-nowrap tour-adminaction">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($admins as $admin)
                                            <tr id="tr-{{$admin->id}}">
                                                <td class="align-middle text-center text-nowrap"></td>
                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @php
                                                        $imageUrl = $admin->image
                                                            ? (filter_var($admin->image, FILTER_VALIDATE_URL) ? $admin->image : asset('assets/images/admins/' . $admin->image))
                                                            : asset('assets/images/no-image-available.png');
                                                    @endphp
                                                    <object data="{{ $imageUrl }}" class="avatar avatar-sm me-3" title="{{ $admin->name }}">
                                                        <img src="{{ $imageUrl }}" alt="{{ $admin->name }}" class="avatar avatar-sm me-3" title="{{ $admin->name }}">
                                                    </object>
                                                </td>
                                                <td class="align-middle text-center text-nowrap">{{ $admin->name }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $admin->email }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $admin->designation }}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    <input type="checkbox" class="status-toggle change-status"
                                                           data-id="{{ $admin->id }}"
                                                           {{ $admin->status == 1 ? 'checked' : '' }} data-bs-toggle="toggle">
                                                </td>
                                                <td class="align-middle text-center table-actions">
                                                    <button type="button" class="btn btn-sm btn-primary changePwdBtn"
                                                            data-id="{{ $admin->id }}" title="Change Password"><i
                                                            class="fas fa-key"></i></button>
                                                    <button type="button" class="btn btn-sm btn-primary editBtn"
                                                            data-id="{{ $admin->id }}" title="Edit"><i
                                                            class="fas fa-edit"></i></button>
                                                    <button type="button" class="btn btn-sm btn-danger deleteBtn"
                                                            data-id="{{ $admin->id }}" title="Delete"><i
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
                    @include('admin.accounts.custom-form')
                    @include('admin.accounts.change-password-form')
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    @push('script')
        @include('admin.accounts.script')
    @endpush
@endsection
{{--@extends('admin.layouts.app')--}}
{{--@section('title','Admin')--}}
{{--@section('datatable', true)--}}
{{--@push('breadcrumb')--}}
{{--    <li class="breadcrumb-item text-sm active" aria-current="page"><a--}}
{{--            href="{{route('admin.account.index')}}">Admin</a>--}}
{{--    </li>--}}
{{--@endpush--}}
{{--@section('content')--}}
{{--    @push('style')--}}
{{--        @include('admin.accounts.style')--}}
{{--    @endpush--}}
{{--    <div class="container-fluid py-4">--}}
{{--        <div class="row">--}}
{{--            <div class="col-12">--}}
{{--                <div class="card mb-4">--}}
{{--                    <div class="card-header pb-0">--}}
{{--                        <h3 class="text-center">Admin Table</h3>--}}
{{--                        <a href="{{ route('admin.account.create') }}"--}}
{{--                           class="btn btn-secondary float-end rounded-pill"><i--}}
{{--                                class="fas fa-plus"></i></a>--}}
{{--                    </div>--}}
{{--                    <div class="card-body px-0 pt-0 pb-2">--}}
{{--                        <div class="table table-responsive p-3">--}}
{{--                            <table id="adminsTable" class="table table-striped" style="width: 100%">--}}
{{--                                <thead>--}}
{{--                                <tr>--}}
{{--                                    <th class="align-middle text-center text-nowrap">Id</th>--}}
{{--                                    <th class="align-middle text-center text-nowrap">Image</th>--}}
{{--                                    <th class="align-middle text-center text-nowrap">Name</th>--}}
{{--                                    <th class="align-middle text-center text-nowrap">Email</th>--}}
{{--                                    <th class="align-middle text-center text-nowrap">Designation</th>--}}
{{--                                    <th class="align-middle text-center text-nowrap">Status</th>--}}
{{--                                    <th class="align-middle text-center text-nowrap">Action</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @foreach($admins as $admin)--}}
{{--                                    <tr id="tr-{{$admin->id}}">--}}
{{--                                        <td class="align-middle text-center text-nowrap">{{ $admin->id }}</td>--}}
{{--                                        <td class="align-middle text-center text-nowrap">--}}
{{--                                            @if($admin->image)--}}
{{--                                                @php--}}
{{--                                                    $imageUrl = filter_var($admin->image, FILTER_VALIDATE_URL) ? $admin->image : asset('assets/images/admins/' . $admin->image);--}}
{{--                                                @endphp--}}
{{--                                                <object--}}
{{--                                                    data="{{ $imageUrl }}"--}}
{{--                                                    class="avatar avatar-sm me-3"--}}
{{--                                                    title="{{ $admin->name }}"--}}
{{--                                                >--}}
{{--                                                    <img--}}
{{--                                                        src="{{ $imageUrl }}"--}}
{{--                                                        alt="{{ $admin->name }}"--}}
{{--                                                        class="avatar avatar-sm me-3"--}}
{{--                                                        title="{{ $admin->name }}">--}}
{{--                                                </object>--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                        <td class="align-middle text-center text-nowrap">{{ $admin->name }}</td>--}}
{{--                                        <td class="align-middle text-center text-nowrap">{{ $admin->email }}</td>--}}
{{--                                        <td class="align-middle text-center text-nowrap">{{ $admin->designation }}</td>--}}
{{--                                        <td class="align-middle text-center text-nowrap">--}}
{{--                                            <input type="checkbox" class="status-toggle change-status"--}}
{{--                                                   data-id="{{ $admin->id }}"--}}
{{--                                                   {{ $admin->status == 1 ? 'checked' : '' }} data-bs-toggle="toggle">--}}
{{--                                        </td>--}}
{{--                                        <td class="align-middle text-center table-actions">--}}
{{--                                            <a href="{{ route('admin.account.edit', [$admin->id]) }}"--}}
{{--                                               class="text-secondary" title="Edit Record">--}}
{{--                                                <i class="fas fa-edit"></i>--}}
{{--                                            </a>--}}
{{--                                            <a href="javascript:void(0)" class="text-secondary deleteBtn"--}}
{{--                                               data-id="{{ $admin->id }}" title="Delete Record">--}}
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
{{--    @push('script')--}}
{{--        @include('admin.accounts.script')--}}
{{--    @endpush--}}
{{--@endsection--}}
