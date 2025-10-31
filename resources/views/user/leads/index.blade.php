@extends('user.layouts.app')
@section('title','Leads')
@section('datatable', true)
@section('content')
    @push('style')
        @include('user.leads.style')

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

                            <button class="create-record open-form-btn ">Create New</button>
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="content__boxed tour-userleadalldata">
            <div class="">
                <div class="container" style="min-width: 100%;">
                    <div class="custom-tabs">
                        <ul class="tab-nav">
                            <li class="tab-item active" data-tab="home">Leads
                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>
                            <li style="margin: 9px 2px"> <button class="my-btn start-tour-btn tour-userleadtitle" data-toggle="tooltip" title="Take a Tour" data-tour="user_leads"><i class="fas fa-exclamation-circle custom-dot"></i> </button></li>

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
                                    @php
                                        function makeAcronym($text) {
                                            $words = preg_split('/\s+/', trim($text));
                                            $acronym = '';
                                            foreach ($words as $word) {
                                                $acronym .= strtoupper(substr($word, 0, 1));
                                            }
                                            $lastWord = end($words);
                                            if (strtolower(substr($lastWord, -1)) === 's') {
                                                $acronym .= 's';
                                            }
                                            return $acronym;
                                        }
                                    @endphp
                                    <table id="allLeadTable" class="table table-striped datatable-exportable
                                        stripe row-border order-column nowrap
                                        initTable
                                        ">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th class="align-middle text-left text-nowrap">NAME</th>
                                            <th class="align-middle text-left text-nowrap">BRAND</th>
                                            <th class="align-middle text-left text-nowrap">TEAM</th>
                                            <th class="align-middle text-left text-nowrap">CREATE DATE</th>
                                            <th class="align-middle text-left text-nowrap">LEAD STATUS</th>
                                            <th class="align-middle text-left text-nowrap">COUNTRY</th>
                                            <th class="align-middle text-left text-nowrap">MESSAGE</th>
                                            <th class="align-middle text-left text-nowrap">ACTION</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all_leads as $lead)
                                            <tr id="tr-{{$lead->id}}">
                                                <td class="align-middle text-left text-nowrap"></td>
                                                <td class="align-middle text-left text-nowrap">
                                                    @if(isset($lead->customer_contact))
                                                        <a href="{{route('customer.contact.edit',[$lead->customer_contact->id])}}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $lead->customer_contact->name }}">{{ $lead->customer_contact->name }}</a>
                                                    @else
                                                        {{$lead->name}}
                                                    @endif
                                                </td>
                                                <td class="align-middle text-left text-nowrap">
                                                    @if(isset($lead->brand))
                                                        <a href="{{route('brand.index')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$lead->brand->name}}">{{ makeAcronym($lead->brand->name) }}</a>
                                                    @else

                                                    @endif
                                                </td>
                                                <td class="align-middle text-left text-nowrap">
                                                    @if(isset($lead->team))
                                                        <a href="{{route('teams.index')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $lead->team->name }}">{{ $lead->team->name }}</a>
                                                    @else

                                                    @endif
                                                </td>
                                                <td class="align-middle text-left text-nowrap">
                                                    @if ($lead->created_at->isToday())
                                                        Today
                                                        at {{ $lead->created_at->timezone('GMT+5')->format('g:i A') }}
                                                        GMT+5
                                                    @else
                                                        {{ $lead->created_at->timezone('GMT+5')->format('M d, Y g:i A') }}
                                                        GMT+5
                                                    @endif
                                                </td>
                                                <td class="align-middle text-left text-nowrap editable" data-id="{{ $lead->id }}" data-field="leadStatus">{{optional($lead->leadStatus)->name}}</td>
                                                <td class="align-middle text-left text-nowrap">{{$lead->country}}</td>
                                                <td class="align-middle text-left text-nowrap">{{ htmlspecialchars(strlen($lead->note) > 18 ? substr($lead->note, 0, 18) . '...' : $lead->note) }}</td>
                                                <td class="align-middle text-left table-actions">
                                                    <button type="button"
                                                            class="btn btn-sm btn-success @if(isset($lead->leadStatus)
                                                        && $lead->leadStatus->name != 'Converted'
                                                        && empty($lead->cus_contact_key)) convertBtn @else disabled @endif"
                                                            @if(isset($lead->leadStatus)
                                                        && $lead->leadStatus->name != 'Converted'
                                                        && empty($lead->cus_contact_key)) data-id="{{ $lead->id }}"
                                                            @endif
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Convert to Customer">
                                                        <i class="fas fa-user-check"></i>
                                                    </button>

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
    @include('user.leads.custom-form')

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
