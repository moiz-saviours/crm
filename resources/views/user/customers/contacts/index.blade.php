@extends('user.layouts.app')
@section('title','Contacts')
@section('datatable', true)
@section('content')
    @push('style')
        @include('user.customers.contacts.style')

    @endpush

    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2">Contacts <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
{{--                        <h2 id="record-count" class="h6">{{count($contacts)}} records</h2>--}}
                    </div>
                    <div class="filters">
                        <div class="actions">
                            {{--                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>--}}

{{--                            <button class="header_btn" disabled>Actions <i class="fa fa-caret-down" aria-hidden="true"></i>--}}
{{--                            </button>--}}
{{--                            <button class="header_btn" disabled>Import</button>--}}
                            <button class="create-contact open-form-btn ">Create New</button>
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
                            <li class="tab-item active" data-tab="home">Contacts
                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>
{{--                            <li class="tab-item " data-tab="menu1">My Contacts <i class="fa fa-times close-icon"--}}
{{--                                                                                  aria-hidden="true"></i></li>--}}
                        </ul>
                        {{--                        <div class="tab-buttons" >--}}
                        {{--                            <button class="btn btn-primary"><i class="fa fa-add"></i> Views (2/5)</button>--}}
                        {{--                            <button class="btn btn-secondary">All Views</button>--}}
                        {{--                        </div>--}}
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
{{--                                                                                       aria-hidden="true"></i></li>--}}
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
                                    <table id="allContactsTable" class="table table-striped datatable-exportable
                                        stripe row-border order-column nowrap initTable ">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th class="align-middle text-center text-nowrap">SNO.</th>
                                            <th class="align-middle text-center text-nowrap">BRAND</th>
                                            <th class="align-middle text-center text-nowrap">NAME</th>
                                            <th class="align-middle text-center text-nowrap">EMAIL</th>
                                            <th class="align-middle text-center text-nowrap">PHONE</th>
                                            <th class="align-middle text-center text-nowrap">ADDRESS</th>
                                            <th class="align-middle text-center text-nowrap">CITY</th>
                                            <th class="align-middle text-center text-nowrap">STATE</th>
                                            <th class="align-middle text-center text-nowrap">COUNTRY</th>
                                            <th class="align-middle text-center text-nowrap">POSTAL CODE</th>
{{--                                            <th class="align-middle text-center text-nowrap">ACTION</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all_contacts as $contact)
                                            <tr id="tr-{{$contact->id}}">
                                                <td class="align-middle text-center text-nowrap"></td>
                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>

                                                <td class="align-middle text-center text-nowrap">
                                                    @if(isset($contact->brand))
                                                        {{ $contact->brand->name }}
                                                    @else
                                                        ---
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    <span title="{{isset($contact->company) ? $contact->company->name : 'No associated company'}}">{{ $contact->name }}</span>
{{--                                                    <a href="{{route('customer.contact.edit',[$contact->id])}}"--}}
{{--                                                       title="{{isset($contact->company) ? $contact->company->name : 'No associated company'}}">{{ $contact->name }}</a>--}}
                                                </td>
                                                <td class="align-middle text-center text-nowrap">{{ $contact->email }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $contact->phone }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $contact->address }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $contact->city }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $contact->state }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $contact->country }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $contact->zipcode }}</td>

{{--                                                <td class="align-middle text-center table-actions">--}}
{{--                                                    <button type="button" class="btn btn-sm btn-primary editBtn"--}}
{{--                                                            data-id="{{ $contact->id }}" title="Edit"><i--}}
{{--                                                            class="fas fa-edit"></i></button>--}}

{{--                                                </td>--}}
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="menu1">
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
{{--                                            <div class="col-md-4 right-icon" id="right-icon-1">--}}
                                                {{--                                        <div class="right-icon">--}}
                                                {{--                                            <i class="fa fa-reply" aria-hidden="true"></i>--}}
                                                {{--                                            <i class="fa fa-clone" aria-hidden="true"></i>--}}
                                                {{--                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>--}}
                                                {{--                                        </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="card-body">
                                    <table id="allContactsTable" class="table table-striped datatable-exportable
                                        stripe row-border order-column nowrap initTable ">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th class="align-middle text-center text-nowrap">ID</th>
                                            <th class="align-middle text-center text-nowrap">NAME</th>
                                            <th class="align-middle text-center text-nowrap">EMAIL</th>
                                            <th class="align-middle text-center text-nowrap">PHONE NUMBER</th>
                                            <th class="align-middle text-center text-nowrap">CONTACT OWNER</th>
                                            <th class="align-middle text-center text-nowrap">PRIMARY COMPANY</th>
                                            <th class="align-middle text-center text-nowrap">CREATE DATE</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($my_contacts as $key => $contact)
                                            <tr id="tr-{{$contact->id}}">
                                                <td></td>
                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$contact->name}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$contact->email}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$contact->phone_number ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($contact->loggable)->name  ?? "---"}}</td>
                                                <td class="align-middle text-center text-nowrap">{{optional($contact->company)->name  ?? "---"}}</td>

                                                <td class="align-middle text-center text-nowrap">
                                                    @if ($contact->created_at->isToday())
                                                        Today
                                                        at {{ $contact->created_at->timezone('GMT+5')->format('g:i A') }}
                                                        GMT+5
                                                    @else
                                                        {{ $contact->created_at->timezone('GMT+5')->format('M d, Y g:i A') }}
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
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
@include('user.customers.contacts.custom-form')
    @push('script')
        @include('user.customers.contacts.script')
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
            });

        </script>
    @endpush
@endsection
