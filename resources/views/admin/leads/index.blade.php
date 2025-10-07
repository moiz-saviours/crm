@extends('admin.layouts.app')
@section('title','Leads')
@section('datatable', true)
@section('content')
    @push('style')
        @include('admin.leads.style')
    @endpush
    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2">Leads <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
{{--                        <h2 id="record-count" class="h6">{{count($leads)}} records</h2>--}}
                    </div>
                    <div class="filters">
                        <div class="actions">
                            {{--                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>--}}

{{--                            <button class="header_btn" disabled>Actions <i class="fa fa-caret-down" aria-hidden="true"></i>--}}
{{--                            </button>--}}
{{--                            <button class="header_btn" disabled>Import</button>--}}
                            <button class="start-tour-btn my-btn" data-toggle="tooltip" title="Take a Tour" data-tour="lead_create"> <i class="fas fa-exclamation-circle custom-dot"></i> </button>
                            <button class="create-contact open-form-btn tour-createlead">Create New</button>
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="content__boxed tour-leadalldata">
            <div class="content__wrap">
                <div class="container" style="min-width: 100%;">
                    <div class="custom-tabs">
                        <ul class="tab-nav">
                            <li class="tab-item active" data-tab="home">Leads
                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>
                            <li style="margin: 9px 2px"><button class="my-btn start-tour-btn tour-leadtitle" data-toggle="tooltip" title="Take a Tour" data-tour="lead"><i class="fas fa-exclamation-circle custom-dot"></i> </button></li>

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
                            stripe row-border order-column nowrap initTable">
                                        <thead>

                                        <tr>
                                            <th></th>
                                            <th class="align-middle text-center text-nowrap">SNO.</th>
                                            <th class="align-middle text-center text-nowrap">BRAND</th>
                                            <th class="align-middle text-center text-nowrap">TEAM</th>
                                            <th class="align-middle text-center text-nowrap">CUSTOMER CONTACT</th>
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
                                            <th class="align-middle text-center text-nowrap">CREATED DATE</th>
                                            <th class="align-middle text-center text-nowrap">STATUS</th>
                                            <th class="align-middle text-center text-nowrap tour-leadaction">ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($leads as $lead)
                                            <tr id="tr-{{$lead->id}}">
                                                <td class="align-middle text-center text-nowrap"></td>
                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if(isset($lead->brand))
                                                        <a href="{{route('admin.brand.index')}}">{{ $lead->brand->name }}</a>
                                                        <br> {{ $lead->brand->brand_key }}
                                                    @else
                                                        ---
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if(isset($lead->team))
                                                        <a href="{{route('admin.team.index')}}">{{ $lead->team->name }}</a>
                                                        <br> {{ $lead->team->team_key }}
                                                    @else
                                                        ---
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap" data-field="customer_contact">
                                                    @if(isset($lead->customer_contact))
                                                        <a href="{{route('admin.customer.contact.edit',[$lead->customer_contact->id])}}">{{ $lead->customer_contact->name }}</a>
{{--                                                        <br> {{ $lead->customer_contact->special_key }}--}}
                                                    @else
                                                        ---
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap">{{$lead->name}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$lead->email}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$lead->phone}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$lead->address}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$lead->city}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$lead->state}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$lead->zipcode}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$lead->country}}</td>
                                                <td class="align-middle text-center text-nowrap editable"
                                                    data-id="{{ $lead->id }}"
                                                    data-field="leadStatus">{{optional($lead->leadStatus)->name}}</td>
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
                                                <td class="align-middle text-center text-nowrap">
                                                    <input type="checkbox" class="status-toggle change-status"
                                                           data-id="{{ $lead->id }}"
                                                           {{ $lead->status == 1 ? 'checked' : '' }} data-bs-toggle="toggle">
                                                </td>
                                                <td class="align-middle text-center table-actions">
                                                    <button type="button" class="btn btn-sm btn-primary editBtn"
                                                            data-id="{{ $lead->id }}" title="Edit"><i
                                                            class="fas fa-edit"></i></button>
                                                    <button type="button" class="btn btn-sm btn-danger deleteBtn"
                                                            data-id="{{ $lead->id }}" title="Delete"><i
                                                            class="fas fa-trash"></i></button>
                                                    @if(isset($lead->leadStatus)
                                                        && $lead->leadStatus->name != 'Converted'
                                                        && empty($lead->cus_contact_key))  
                                                    <button type="button"
                                                            class="btn btn-sm btn-success convertBtn"
                                                            data-id="{{ $lead->id }}"
                                                            title="Convert to Customer">
                                                        <i class="fas fa-user-check"></i>
                                                    </button>
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
                    @include('admin.leads.custom-form')
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    @push('script')
        @include('admin.leads.script')
    @endpush
@endsection
