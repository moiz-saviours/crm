@extends('admin.layouts.app')
@section('title','Employees')
@section('datatable', true)
@section('content')
    @push('style')
        @include('admin.employees.style')
    @endpush
    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2">Employees <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
{{--                        <h2 id="record-count" class="h6">{{count($users)}} records</h2>--}}

                    </div>
                    <div class="filters">
                        <div class="actions">
                            {{--                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>--}}

{{--                            <button class="header_btn" disabled>Actions <i class="fa fa-caret-down" aria-hidden="true"></i>--}}
{{--                            </button>--}}
{{--                            <button class="header_btn" disabled>Import</button>--}}
                            <button class="start-tour-btn my-btn" data-toggle="tooltip" title="Take a Tour" data-tour="employeecreate"> <i class="fas fa-exclamation-circle custom-dot"></i> </button>
                            <button class="create-contact open-form-btn tour-createmployee">Create New</button>
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="content__boxed tour-employeealldata">
            <div class="content__wrap">
                <div class="container" style="min-width: 100%;">
                    <div class="custom-tabs">
                        <ul class="tab-nav">
                            <li class="tab-item active" data-tab="home">Employees
                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>
                            <li style="margin: 9px 2px"> <button class="my-btn start-tour-btn tour-employeetitle" data-toggle="tooltip" title="Take a Tour" data-tour="employee"><i class="fas fa-exclamation-circle custom-dot"></i> </button></li>
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
                                            <th class="align-middle text-center text-nowrap">EMP ID</th>
                                            <th class="align-middle text-center text-nowrap">Image</th>
                                            <th class="align-middle text-center text-nowrap">Name</th>
                                            <th class="align-middle text-center text-nowrap">Email</th>
                                            <th class="align-middle text-center text-nowrap">Designation</th>
                                            <th class="align-middle text-center text-nowrap">Team</th>
                                            <th class="align-middle text-center text-nowrap">Target</th>
                                            <th class="align-middle text-center text-nowrap">Status</th>
                                            <th class="align-middle text-center text-nowrap tour-employeeaction">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                            <tr id="tr-{{$user->id}}">
                                                <td class="align-middle text-center text-nowrap"></td>
                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$user->emp_id}}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @php
                                                        $imageUrl = $user->image
                                                            ? (filter_var($user->image, FILTER_VALIDATE_URL) ? $user->image : asset('assets/images/employees/' . $user->image))
                                                            : asset('assets/images/no-image-available.png');
                                                    @endphp
                                                    <object data="{{ $imageUrl }}" class="avatar avatar-sm me-3" title="{{ $user->name }}"><img src="{{ $imageUrl }}" alt="{{ $user->name }}" class="avatar avatar-sm me-3" title="{{ $user->name }}"></object>
                                                </td>
                                                <td class="align-middle text-center text-nowrap">{{ $user->name }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $user->email }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $user->designation }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ optional($user->teams)->pluck('name')->map('htmlspecialchars_decode')->implode(', ') }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $user->target }}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    <input type="checkbox" class="status-toggle change-status"
                                                           data-id="{{ $user->id }}"
                                                           {{ $user->status == 1 ? 'checked' : '' }} data-bs-toggle="toggle">
                                                </td>
                                                <td class="align-middle text-center table-actions">
                                                    <button type="button" class="btn btn-sm btn-primary changePwdBtn"
                                                            data-id="{{ $user->id }}" title="Change Password"><i
                                                            class="fas fa-key"></i></button>
                                                    <button type="button" class="btn btn-sm btn-primary editBtn"
                                                            data-id="{{ $user->id }}" title="Edit"><i
                                                            class="fas fa-edit"></i></button>
                                                    <button type="button" class="btn btn-sm btn-danger deleteBtn"
                                                            data-id="{{ $user->id }}" title="Delete"><i
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
                    @include('admin.employees.custom-form')
                    @include('admin.employees.change-password-form')
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    @push('script')
        @include('admin.employees.script')
    @endpush
@endsection
