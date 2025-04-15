@extends('user.layouts.app')
@section('title','Leads')
@section('datatable', true)
@section('content')
    @push('style')
        @include('user.leads.style')
        <style>
            td.align-middle.text-center.text-nowrap.editable:hover select{
                border: 1px solid #000;
                border-radius: 5px;
            }
            td.align-middle.text-center.text-nowrap.editable[data] , td.align-middle.text-center.text-nowrap.editable{
                cursor:pointer;
            }
            .void {
                cursor: not-allowed;
            }

            .custm_header {
                padding: 2px 20px 2px 20px;
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
                margin: 0px 0px 4px 0px;
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
                        <h1 class="page-title mb-2">Leads <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
{{--                        <h2 id="record-count" class="h6">{{ count($all_leads) }} records</h2>--}}
                    </div>
                    <div class="filters">
                        <div class="actions">
                            {{--                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>--}}

{{--                            <button class="header_btn" disabled>Actions <i class="fa fa-caret-down" aria-hidden="true"></i>--}}
{{--                            </button>--}}
{{--                            <button class="header_btn" disabled>Import</button>--}}
                            <button class="create-contact open-form-btn void">Create New</button>
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
                            <li class="tab-item active" data-tab="home">Leads
                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>
{{--                            <li class="tab-item " data-tab="allleads">All Leads--}}
{{--                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>--}}
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
                                    <table id="allLeadsTable" class="table table-striped datatable-exportable
                            stripe row-border order-column nowrap
                            initTable
                            ">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th class="align-middle text-center text-nowrap">ID</th>
                                            <th class="align-middle text-center text-nowrap">BRAND</th>
                                            <th class="align-middle text-center text-nowrap">CLIENT</th>
                                            <th class="align-middle text-center text-nowrap">NAME</th>
                                            <th class="align-middle text-center text-nowrap">EMAIL</th>
                                            <th class="align-middle text-center text-nowrap">PHONE NUMBER</th>
                                            <th class="align-middle text-center text-nowrap">ADDRESS</th>
                                            <th class="align-middle text-center text-nowrap">CITY</th>
                                            <th class="align-middle text-center text-nowrap">STATE</th>
                                            <th class="align-middle text-center text-nowrap">ZIPCODE</th>
                                            <th class="align-middle text-center text-nowrap">COUNTRY</th>
                                            <th class="align-middle text-center text-nowrap">LEAD STATUS</th>
                                            <th class="align-middle text-center text-nowrap">NOTE</th>
                                            <th class="align-middle text-center text-nowrap">CREATE DATE</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all_leads as $lead)
                                            <tr id="tr-{{$lead->id}}">
                                                <td class="align-middle text-center text-nowrap"></td>
                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($lead->brand)->name ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($lead->client)->name ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$lead->name}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$lead->email}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$lead->phone}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$lead->address}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$lead->city}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$lead->state}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$lead->zipcode}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$lead->country}}</td>
                                                <td class="align-middle text-center text-nowrap editable" data-id="{{ $lead->id }}" data-field="leadStatus">{{optional($lead->leadStatus)->name}}</td>
                                                <td class="align-middle text-center text-nowrap">{{htmlspecialchars($lead->note)}}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if ($lead->created_at->isToday())
                                                        Today
                                                        at {{ $lead->created_at->timezone('GMT+5')->format('g:i A') }}
                                                        GMT+5
                                                    @else
                                                        {{ $lead->created_at->timezone('GMT+5')->format('M d, Y g:i A') }}
                                                        GMT+5
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="allleads">
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
{{--                                                        <li class="">Lead status <i class="fa fa-caret-down"--}}
{{--                                                                                    aria-hidden="true"></i></li>--}}
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
{{--                                <div class="card-body">--}}
{{--                                    <table id="allLeadsTable" class="table table-striped datatable-exportable--}}
{{--                                        stripe row-border order-column nowrap--}}
{{--                                        initTable--}}
{{--                                        ">--}}
{{--                                        <thead>--}}
{{--                                        <tr>--}}
{{--                                            <th></th>--}}
{{--                                            <th class="align-middle text-center text-nowrap">SNO.</th>--}}
{{--                                            <th class="align-middle text-center text-nowrap">Brand</th>--}}
{{--                                            <th class="align-middle text-center text-nowrap">Customer</th>--}}
{{--                                            <th class="align-middle text-center text-nowrap">Name</th>--}}
{{--                                            <th class="align-middle text-center text-nowrap">Email</th>--}}
{{--                                            <th class="align-middle text-center text-nowrap">Phone Number</th>--}}
{{--                                            <th class="align-middle text-center text-nowrap">Address</th>--}}
{{--                                            <th class="align-middle text-center text-nowrap">City</th>--}}
{{--                                            <th class="align-middle text-center text-nowrap">State</th>--}}
{{--                                            <th class="align-middle text-center text-nowrap">Zipcode</th>--}}
{{--                                            <th class="align-middle text-center text-nowrap">Country</th>--}}
{{--                                            <th class="align-middle text-center text-nowrap">Lead Status</th>--}}
{{--                                            <th class="align-middle text-center text-nowrap">Note</th>--}}
{{--                                            <th class="align-middle text-center text-nowrap">Created Date</th>--}}

{{--                                        </tr>--}}
{{--                                        </thead>--}}
{{--                                        <tbody>--}}
{{--                                        @foreach($leads as $lead)--}}
{{--                                            <tr id="tr-{{$lead->id}}">--}}
{{--                                                <td class="align-middle text-center text-nowrap"></td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{optional($lead->brand)->name ?? "---"}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{optional($lead->customer)->name ?? "---"}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$lead->name}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$lead->email}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$lead->phone}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$lead->address}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$lead->city}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$lead->state}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$lead->zipcode}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{$lead->country}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap editable"--}}
{{--                                                    data-id="{{ $lead->id }}"--}}
{{--                                                    data-field="leadStatus">{{optional($lead->leadStatus)->name}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">{{htmlspecialchars($lead->note)}}</td>--}}
{{--                                                <td class="align-middle text-center text-nowrap">--}}
{{--                                                    @if ($lead->created_at->isToday())--}}
{{--                                                        Today--}}
{{--                                                        at {{ $lead->created_at->timezone('GMT+5')->format('g:i A') }}--}}
{{--                                                        GMT+5--}}
{{--                                                    @else--}}
{{--                                                        {{ $lead->created_at->timezone('GMT+5')->format('M d, Y g:i A') }}--}}
{{--                                                        GMT+5--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
{{--                                        </tbody>--}}
{{--                                    </table>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
{{--                    <div class="custom-form">--}}
{{--                        <div class="form-container" id="formContainer">--}}
{{--                            <!-- Form Header -->--}}
{{--                            <div class="form-header">--}}
{{--                                Add Company--}}
{{--                                <button class="close-btn">×</button>--}}
{{--                            </div>--}}
{{--                            <!-- Form Body -->--}}
{{--                            <div class="form-body">--}}
{{--                                <label for="name">Company Name</label>--}}
{{--                                <input type="text" id="name" placeholder="Enter your name">--}}
{{--                                <label for="email">Company Domain</label>--}}
{{--                                <input type="email" id="email" placeholder="Enter your email">--}}
{{--                                <button>Submit</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}


                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->

    @push('script')
        @include('user.leads.script')
        <script>

            $(document).ready(function () {
                const formContainer = $('#formContainer');
                $('.open-form-btn').click(function () {
                    $(this).hasClass('void') ? $(this).attr('title', "You don't have access to create a record.").tooltip({placement: 'bottom'}).tooltip('show') : (formContainer.addClass('open'));
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
                $('td.align-middle.text-center.text-nowrap').each(function () {
                    if (!$(this).hasClass('select-checkbox') && $(this).text().trim() === '') {
                        $(this).text('---');
                    }
                });
            });

        </script>
    @endpush
@endsection
