@extends('admin.layouts.app')
@section('title','Client Contact Contacts')
@section('datatable', true)
@section('content')
    @push('style')
        @include('admin.clients.contacts.style')
    @endpush
    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2 ">Contacts <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
{{--                        <h2 id="record-count" class="h6">{{count($client_contacts)}} records</h2>--}}

                    </div>
                    <div class="filters">
                        <div class="actions">
                            {{--                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>--}}

{{--                            <button class="header_btn" disabled>Actions <i class="fa fa-caret-down" aria-hidden="true"></i>--}}
{{--                            </button>--}}
{{--                            <button class="header_btn" disabled>Import</button>--}}
                            <button class="start-tour-btn my-btn" data-toggle="tooltip" title="Take a Tour" data-tour="client_contact_create"> <i class="fas fa-exclamation-circle custom-dot"></i> </button>
                            <button class="create-contact open-form-btn tour-createclientcontact">Create New</button>
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="content__boxed tour-clientcontactalldata">
            <div class="content__wrap">
                <div class="container" style="min-width: 100%;">
                    <div class="custom-tabs">
                        <ul class="tab-nav">
                            <li class="tab-item active" data-tab="home">Contacts
                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>
                            <li style="margin: 9px 2px"><button class="my-btn start-tour-btn tour-clientcontacttitle" data-toggle="tooltip" title="Take a Tour" data-tour="client_contact"><i class="fas fa-exclamation-circle custom-dot"></i> </button></li>
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
                                    <table id="allContactsTable" class="table table-striped datatable-exportable
                            stripe row-border order-column nowrap
                            initTable
                            ">
                                        <thead>

                                        <tr>
                                            <th>SELECT</th>
                                            <th class="align-middle text-center text-nowrap">SNO.</th>
                                            <th class="align-middle text-center text-nowrap">NAME</th>
                                            <th class="align-middle text-center text-nowrap">EMAIL</th>
                                            <th class="align-middle text-center text-nowrap">PHONE</th>
                                            <th class="align-middle text-center text-nowrap">ADDRESS</th>
                                            <th class="align-middle text-center text-nowrap">CITY</th>
                                            <th class="align-middle text-center text-nowrap">STATE</th>
                                            <th class="align-middle text-center text-nowrap tour-clientcontactstatus">STATUS</th>
                                            <th class="align-middle text-center text-nowrap tour-clientcontactaction">ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($client_contacts as $client_contact)
                                            <tr id="tr-{{$client_contact->id}}">
                                                <td class="align-middle text-center text-nowrap"></td>
                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $client_contact->name }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $client_contact->email }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $client_contact->phone }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $client_contact->address }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $client_contact->city }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ $client_contact->state }}</td>
                                                <td class="align-middle text-center text-nowrap ">
                                                    <input type="checkbox" class="status-toggle change-status"
                                                           data-id="{{ $client_contact->id }}"
                                                           {{ $client_contact->status == 1 ? 'checked' : '' }} data-bs-toggle="toggle">
                                                </td>
                                                <td class="align-middle text-center table-actions ">
                                                    <button type="button" class="btn btn-sm btn-primary editBtn"
                                                            data-id="{{ $client_contact->id }}" title="Edit"><i
                                                                class="fas fa-edit"></i></button>
                                                    <button type="button" class="btn btn-sm btn-danger deleteBtn"
                                                            data-id="{{ $client_contact->id }}" title="Delete"><i
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
                    @include('admin.clients.contacts.custom-form')
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    @push('script')
        @include('admin.clients.contacts.script')
    @endpush
@endsection
