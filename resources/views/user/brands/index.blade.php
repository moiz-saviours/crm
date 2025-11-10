@extends('user.layouts.app')
@section('title','Brands')
@section('datatable', true)
@section('content')
    @push('style')
        @include('user.brands.style')

    @endpush

    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2">Brands <i class="fa fa-caret-down" aria-hidden="true"></i>
                        </h1>
                        {{--                        <h2 id="record-count" class="h6">{{ count($teams) }} records</h2>--}}
                    </div>
                    <div class="filters">
                        <div class="actions">
                            {{--                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>--}}

                            {{--                            <button class="header_btn" disabled>Actions <i class="fa fa-caret-down" aria-hidden="true"></i>--}}
                            {{--                            </button>--}}
                            {{--                            <button class="header_btn" disabled>Import</button>--}}
                            {{--                            <button class="create-contact open-form-btn void">Create New</button>--}}

                            @if(\App\Helpers\NavigationHelper::hasAccess('brand.store'))
                            <button class="start-tour-btn my-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Take a Tour"
                                    data-tour="user_brand_create"><i class="fas fa-exclamation-circle custom-dot"></i>
                            </button>
                            <button class="create-contact open-form-btn user-tour-createbrand">Create New</button>
                            @endif
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="content__boxed tour-userbrandalldata">
            <div class="content__wrap">
                <div class="container" style="min-width: 100%;">
                    <div class="custom-tabs">
                        <ul class="tab-nav">
                            @if(isset($teams) && count($teams) > 0)
                                @foreach($teams as $team)
                                    <li class="tab-item {{$loop->first ? "active":""}}"
                                        data-tab="tab-pane-{{$team->team_key}}">{{$team->name}}<i
                                            class="fa fa-times close-icon"
                                            aria-hidden="true"></i></li>
                                    <li style="margin: 9px 2px"> <button class="my-btn start-tour-btn tour-userbrandtitle" data-toggle="tooltip" title="Take a Tour" data-tour="user_brands"><i class="fas fa-exclamation-circle custom-dot"></i> </button></li>

                                @endforeach
                            @else
                                <li class="tab-item active"
                                    data-tab="tab-pane-brands">Brands<i
                                        class="fa fa-times close-icon"
                                        aria-hidden="true"></i></li>

                            @endif
                            {{--                                <li class="tab-item"--}}
                            {{--                                    data-tab="tab-pane-"><i--}}
                            {{--                                        class="fa fa-times close-icon"--}}
                            {{--                                        aria-hidden="true"></i></li>--}}
                        </ul>
                        {{--                        <div class="tab-buttons" >--}}
                        {{--                            <button class="btn btn-primary"><i class="fa fa-add"></i> Views (2/5)</button>--}}
                        {{--                            <button class="btn btn-secondary">All Views</button>--}}
                        {{--                        </div>--}}
                    </div>
                    <div class="tab-content">
                        @if(isset($teams) && count($teams) > 0)
                        @foreach($teams as $index => $team)
                            <div class="tab-pane {{$loop->first ? "active":""}}" id="tab-pane-{{$team->team_key}}">
                                <div class="card">
                                    {{--                                    <div class="card-header">--}}
                                    {{--                                        <div class="container" style="min-width: 100%;">--}}
                                    {{--                                            <div class="row fltr-sec">--}}
                                    {{--                                                <div class="col-md-8">--}}
                                    {{--                                                <ul class="custm-filtr">--}}
                                    {{--                                                    <div class="table-li">--}}
                                    {{--                                                        <li class="">CustomerCompany Owner <i class="fa fa-caret-down"--}}
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
                                    {{--                                                </div>--}}
                                    {{--                                                <div class="col-md-4 right-icon" id="right-icon-{{ $index }}"></div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                    <div class="card-body">
                                        <table id="{{$team->team_key}}-Table" class="table table-striped datatable-exportable
                                               stripe row-border order-column nowrap initTable">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th class="align-middle text-center text-nowrap">S.NO</th>
                                                <th class="align-middle text-center text-nowrap">LOGO</th>
                                                <th class="align-middle text-center text-nowrap">NAME</th>
                                                <th class="align-middle text-center text-nowrap">URL</th>
                                                {{--                                                <th class="align-middle text-center text-nowrap">Action</th>--}}
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($team->brands as $brand)
                                                <tr>
                                                    <td class="align-middle text-center text-nowrap"></td>
                                                    <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                    <td class="align-middle text-center text-nowrap">
                                                        @php
                                                            $logoUrl = filter_var($brand->logo, FILTER_VALIDATE_URL) ? $brand->logo : asset('assets/images/brand-logos/'.$brand->logo);
                                                        @endphp
                                                        <object data="{{ $logoUrl }}" class="avatar avatar-sm me-3"
                                                                title="{{ $brand->name }}"><img
                                                                src="{{ $logoUrl }}" alt="{{ $brand->name }}"
                                                                class="avatar avatar-sm me-3"
                                                                title="{{ $brand->name }}"></object>
                                                    </td>
                                                    <td class="align-middle text-center text-nowrap">{{$brand->name}}</td>
                                                    <td class="align-middle text-center text-nowrap">{{$brand->url}}</td>
                                                    {{--                                                    <td class="align-middle text-center table-actions">--}}
                                                    {{--                                                        <button type="button" class="btn btn-sm btn-primary editBtn"--}}
                                                    {{--                                                                data-id="{{ $brand->id }}" title="Edit"><i--}}
                                                    {{--                                                                class="fas fa-edit"></i></button>--}}
                                                    {{--                                                    </td>--}}
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @else
                            @if(\App\Helpers\NavigationHelper::hasAccess('brand.store'))
                              <div class="tab-pane active" id="tab-pane-brands">
                                <div class="card"><div class="card-body">
                                        <table id="brands-Table" class="table table-striped datatable-exportable
                                stripe row-border order-column nowrap initTable">
                                            <thead>
                                            <tr>
                                                <th class="align-middle text-center text-nowrap"></th>
                                                <th class="align-middle text-center text-nowrap">S.NO</th>
                                                <th class="align-middle text-center text-nowrap">LOGO</th>
                                                <th class="align-middle text-center text-nowrap">Brand Key</th>
                                                <th class="align-middle text-center text-nowrap">NAME</th>
                                                <th class="align-middle text-center text-nowrap">URL</th>
                                                <th class="align-middle text-center text-nowrap">STATUS</th>
                                                <th class="align-middle text-center text-nowrap">ACTIONS</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($brands as $brand)
                                                <tr>
                                                    <td class="align-middle text-center text-nowrap"></td>
                                                    <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                    <td class="align-middle text-center text-nowrap">
                                                        @php
                                                            $logoUrl = filter_var($brand->logo, FILTER_VALIDATE_URL) ? $brand->logo : asset('assets/images/brand-logos/'.$brand->logo);
                                                        @endphp
                                                        <object data="{{ $logoUrl }}" class="avatar avatar-sm me-3" title="{{ $brand->name }}">
                                                            <img src="{{ $logoUrl }}" alt="{{ $brand->name }}" class="avatar avatar-sm me-3" title="{{ $brand->name }}">
                                                        </object>
                                                    </td>
                                                    <td class="align-middle text-center text-nowrap">{{$brand->brand_key}}</td>
                                                    <td class="align-middle text-center text-nowrap">{{$brand->name}}</td>
                                                    <td class="align-middle text-center text-nowrap">{{$brand->url}}</td>
                                                    <td class="align-middle text-center text-nowrap">
                                                        <input type="checkbox" class="status-toggle change-status"
                                                               data-id="{{ $brand->id }}"
                                                               {{ $brand->status == 1 ? 'checked' : '' }} data-bs-toggle="toggle">
                                                    </td>
                                                    <td class="align-middle text-center table-actions">
                                                        <button type="button" class="btn btn-sm btn-primary copyScriptBtn"
                                                                data-script='<script src="{{ asset('assets/js/wl-script.js') }}?token={{ $brand->script_token }}"></script>'
                                                                title="Copy Script">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-primary editBtn"
                                                                data-id="{{ $brand->id }}" title="Edit"><i
                                                                class="fas fa-edit"></i></button>

                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    @if(\App\Helpers\NavigationHelper::hasAccess('brand.store'))
    @include('user.brands.custom-form');
    @endif


    @push('script')
        @include('user.brands.script')
        <script>
            // Copy Script Js

            $(document).ready(function () {
                $(document).on('click', '.copyScriptBtn', function () {
                    const scriptText = $(this).data('script');
                    navigator.clipboard.writeText(scriptText)
                        .then(() => {
                            toastr.success('Script copied to clipboard!');
                        })
                        .catch(err => {
                            toastr.error('Failed to copy script');
                            console.error(err);
                        });
                });
            });
        </script>

    @endpush
@endsection
