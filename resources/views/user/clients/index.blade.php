@extends('user.layouts.app')
@section('title','Clients')
@section('datatable', true)
@section('content')
    @push('style')
        @include('user.clients.style')
        <style>

            .void {
                cursor: not-allowed;
            }

            .custm_header {
                padding: 10px 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .actions {
                display: flex;
            }

            .actions h1 {
                margin: auto;
                color: #52a0bf;
                font-size: 15px;
            }

            .filters,
            .table-controls {
                display: flex;
                justify-content: space-between;
                padding: 10px 20px;
                border-bottom: 1px solid #ddd;
            }

            .filters .filter-tabs button,
            .actions button {
                padding: 5px 12px;
                border: 1px solid #ff5722;
                border-radius: 4px;
                background-color: #fff;
                cursor: pointer;
            }

            .filters .actions .create-contact {
                background-color: #ff5722;
                color: #fff;
                border: none;
            }

            .search-bar input {
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px;
                width: 250px;
            }

            .contacts-table {
                width: 100%;
                border-collapse: collapse;
            }

            .contacts-table th,
            .contacts-table td {
                padding: 10px;
                text-align: left;
                /*border: 1px solid #ddd;*/
            }

            .contacts-table th {
                /*background-color: #f1f5f9;*/
                font-weight: bold;
            }

            .contacts-table tbody tr:hover {
                background-color: #f9f9f9;
            }


            .header .new_head h1 {
                font-size: 20px;
                color: #52a0bf;
                font-weight: 700;

            }

            .header_btn {
                padding: 0px 30px;
                color: #ff5722;
                margin: 0px 10px;
            }

            .custom-tabs {
                margin: 10px 0px;
                display: flex;
            }

            .tab-nav {
                display: flex;
                justify-content: space-around;
                list-style: none;
                padding: 0;
                margin: 0;
                width: 70%;
            }

            .tab-buttons {
                margin-left: 100px;
            }

            .tab-item {
                padding: 10px 20px;
                cursor: pointer;
                border: 1px solid #cbd6e2;
                background: #f9f9f9;
                width: 100%;
                transition: background 0.3s ease;
            }

            .tab-item.active {
                background: #fff;
                border-bottom: none;

            }

            .tab-item.active i {
                float: right;
                font-size: 14px;
                margin: auto;
            }

            .tab-content {
                /*padding: 10px;*/
                /*margin-top: 10px;*/
            }

            .tab-pane {
                display: none;
            }

            .tab-pane.active {
                display: block;

            }

            .fltr-sec {
                padding-top: 20px;
            }

            .table-li {
                display: flex;
            }

            .table-li .page-title {
                font-size: 14px;
                padding: 0px 30px 0px 0px;

                font-weight: 700;
            }

            .right-icon i {
                float: right;
                margin: 0px 4px;
                border: 1px solid #ccc;
                padding: 5px;
                border-radius: 5px;
                font-size: 12px;
            }

            .custom-form .form-container {
                position: fixed;
                top: 0;
                right: -100%;
                width: 500px;
                height: 100%;
                background: #ffffff;
                box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
                transition: right 0.5s ease;
                box-sizing: border-box;
                z-index: 1001;
            }

            .custom-form .form-container.open {
                right: 0;
            }

            .custom-form .form-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 15px 20px;
                background: #52a0bf;
                color: white;
                font-size: 18px;
                font-weight: bold;
            }

            .custom-form .form-header .close-btn {
                font-size: 20px;
                font-weight: bold;
                background: none;
                border: none;
                color: white;
                cursor: pointer;
            }

            .custom-form .form-body {
                padding: 20px;
            }

            .custom-form .form-body label {
                display: block;
                margin-bottom: 5px;
                font-weight: 500;
            }

            .custom-form .form-body input:not(.is-invalid) {
                width: 100%;
                padding: 8px;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }

            .custom-form .form-body button {
                width: 100%;
                padding: 10px;
                background: #52a0bf;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            .close-icon {
                display: none;
            }

            .tab-item.active .close-icon {
                display: inline;
            }

        </style>
    @endpush

    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2">Clients <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
                        <h2 id="record-count" class="h6"> records</h2>
                    </div>
                    <div class="filters">
                        <div class="actions">
                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>

                            <button class="header_btn">Actions <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </button>
                            <button class="header_btn">Import</button>
                            <button class="create-contact open-form-btn void">Create New Client</button>
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
                            <li class="tab-item active" data-tab="home">All Clients
                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>
                            <li class="tab-item " data-tab="menu1">My Clients <i class="fa fa-times close-icon"
                                                                                   aria-hidden="true"></i></li>
                        </ul>
                        {{--                        <div class="tab-buttons" >--}}
                        {{--                            <button class="btn btn-primary"><i class="fa fa-add"></i> Views (2/5)</button>--}}
                        {{--                            <button class="btn btn-secondary">All Views</button>--}}
                        {{--                        </div>--}}
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
                                    <table id="allCompaniesTable" class="table table-striped datatable-exportable
                            stripe row-border order-column nowrap
                            initTable
                            ">
                                        <thead>
                                        <tr>
                                            <th><input type="checkbox"></th>
                                            <th>Id</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Company</th>
                                            <th>Country</th>
                                        </tr>
                                        </thead>
                                        <tbody>
{{--                                        @foreach($companies as $key => $company)--}}
{{--                                            <tr id="tr-{{$company->id}}">--}}
{{--                                                <td></td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">Syed Moiz Athar</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">--}}
{{--                                                    syedmoizathar@gmail.com--}}
{{--                                                </td>--}}
{{--                                                --}}{{--                                        <td class="align-middle text-center text-nowrap">--}}
{{--                                                --}}{{--                                            @php--}}
{{--                                                --}}{{--                                                $logoUrl = filter_var($company->logo, FILTER_VALIDATE_URL) ? $company->logo : asset('assets/images/company-logos/'.$company->logo);--}}
{{--                                                --}}{{--                                            @endphp--}}
{{--                                                --}}{{--                                            <object--}}
{{--                                                --}}{{--                                                data="{{ $logoUrl }}"--}}
{{--                                                --}}{{--                                                class="avatar avatar-sm me-3"--}}
{{--                                                --}}{{--                                                title="{{ $company->name }}"--}}
{{--                                                --}}{{--                                            >--}}
{{--                                                --}}{{--                                                <img--}}
{{--                                                --}}{{--                                                    src="{{ $logoUrl }}"--}}
{{--                                                --}}{{--                                                    alt="{{ $company->name }}"--}}
{{--                                                --}}{{--                                                    class="avatar avatar-sm me-3"--}}
{{--                                                --}}{{--                                                    title="{{ $company->name }}">--}}
{{--                                                --}}{{--                                            </object>--}}
{{--                                                --}}{{--                                        </td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$company->name}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$company->name}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$company->name}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$company->name}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$company->name}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$company->url}}</td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="menu1">
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
                                            <div class="col-md-4 right-icon" id="right-icon-1">
                                                {{--                                        <div class="right-icon">--}}
                                                {{--                                            <i class="fa fa-reply" aria-hidden="true"></i>--}}
                                                {{--                                            <i class="fa fa-clone" aria-hidden="true"></i>--}}
                                                {{--                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>--}}
                                                {{--                                        </div>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="myCompaniesTable" class="table table-striped datatable-exportable
                            stripe row-border order-column nowrap
                            initTable">
                                        <thead>
                                        <tr>
                                            <th class="align-middle text-center text-nowrap"><input type="checkbox">
                                            </th>
                                            <th class="align-middle text-center text-nowrap">NAME</th>
                                            <th class="align-middle text-center text-nowrap">EMAIL</th>
                                            {{--                                    <th>PHONE NUMBER</th>--}}
                                            <th class="align-middle text-center text-nowrap">PHONE NUMBER</th>
                                            <th class="align-middle text-center text-nowrap">PHONE NUMBER</th>
                                            <th class="align-middle text-center text-nowrap">Image</th>
                                            <th class="align-middle text-center text-nowrap">PHONE NUMBER</th>
                                            <th class="align-middle text-center text-nowrap">PHONE NUMBER</th>
                                            <th class="align-middle text-center text-nowrap">PHONE NUMBER</th>
                                            <th class="align-middle text-center text-nowrap">CONTACT OWNER</th>
                                        </tr>
                                        </thead>
                                        <tbody>
{{--                                        @foreach($companies as $key => $company)--}}
{{--                                            <tr id="myCompaniesTable-tr-{{$company->id}}">--}}
{{--                                                <td></td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">Syed Moiz Athar</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">--}}
{{--                                                    syedmoizathar@gmail.com--}}
{{--                                                </td>--}}
{{--                                                --}}{{--                                        <td class="align-middle text-center text-nowrap">--}}
{{--                                                --}}{{--                                            @php--}}
{{--                                                --}}{{--                                                $logoUrl = filter_var($company->logo, FILTER_VALIDATE_URL) ? $company->logo : asset('assets/images/company-logos/'.$company->logo);--}}
{{--                                                --}}{{--                                            @endphp--}}
{{--                                                --}}{{--                                            <object--}}
{{--                                                --}}{{--                                                data="{{ $logoUrl }}"--}}
{{--                                                --}}{{--                                                class="avatar avatar-sm me-3"--}}
{{--                                                --}}{{--                                                title="{{ $company->name }}"--}}
{{--                                                --}}{{--                                            >--}}
{{--                                                --}}{{--                                                <img--}}
{{--                                                --}}{{--                                                    src="{{ $logoUrl }}"--}}
{{--                                                --}}{{--                                                    alt="{{ $company->name }}"--}}
{{--                                                --}}{{--                                                    class="avatar avatar-sm me-3"--}}
{{--                                                --}}{{--                                                    title="{{ $company->name }}">--}}
{{--                                                --}}{{--                                            </object>--}}
{{--                                                --}}{{--                                        </td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$company->name}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$company->name}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">--}}
{{--                                                    @php--}}
{{--                                                        $logoUrl = filter_var($company->logo, FILTER_VALIDATE_URL) ? $company->logo : asset('assets/images/brand-logos/'.$company->logo);--}}
{{--                                                    @endphp--}}
{{--                                                    <object--}}
{{--                                                        data="{{ $logoUrl }}"--}}
{{--                                                        class="avatar avatar-sm me-3"--}}
{{--                                                        title="{{ $company->name }}"--}}
{{--                                                    >--}}
{{--                                                        <img--}}
{{--                                                            src="{{ $logoUrl }}"--}}
{{--                                                            alt="{{ $company->name }}"--}}
{{--                                                            class="avatar avatar-sm me-3"--}}
{{--                                                            title="{{ $company->name }}">--}}
{{--                                                    </object>--}}
{{--                                                </td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$company->name}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$company->name}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$company->name}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$company->url}}</td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="custom-form">
                        <div class="form-container" id="formContainer">
                            <!-- Form Header -->
                            <div class="form-header">
                                Add Company
                                <button class="close-btn">×</button>
                            </div>
                            <!-- Form Body -->
                            <div class="form-body">
                                <label for="name">Company Name</label>
                                <input type="text" id="name" placeholder="Enter your name">
                                <label for="email">Company Domain</label>
                                <input type="email" id="email" placeholder="Enter your email">
                                <button>Submit</button>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->

    @push('script')
        @include('user.clients.script')
        <script>

            $(document).ready(function () {
                const formContainer = $('#formContainer');
                $('.open-form-btn').click(function () {
                    $(this).hasClass('void') ? $(this).attr('title', "You don't have access to create a company.").tooltip({placement: 'bottom'}).tooltip('show') : (formContainer.addClass('open'));
                });
                $(document).click(function (event) {
                    if (!$(event.target).closest('#formContainer').length && !$(event.target).is('#formContainer') && !$(event.target).closest('.open-form-btn').length) {
                        formContainer.removeClass('open')
                    }
                });
                $(".tab-item").on("click", function () {
                    // Remove 'active' class from all tabs and panes
                    $(".tab-item").removeClass("active");
                    $(".tab-pane").removeClass("active");

                    $(this).addClass("active");

                    const targetPane = $(this).data("tab");
                    $("#" + targetPane).addClass("active");
                });
            });

        </script>
    @endpush
@endsection
