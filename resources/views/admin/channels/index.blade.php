@extends('admin.layouts.app')
@section('title','Channels')
@section('datatable', true)
@section('content')
    @push('style')
        @include('admin.channels.style')
    @endpush
    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2">Channels <i class="fa fa-caret-down" aria-hidden="true"></i>
                        </h1>
                        {{--                        <h2 id="record-count" class="h6">{{count($channels)}} records</h2>--}}
                    </div>
                    <div class="filters">
                        <div class="actions">
                            {{--                            <h1><i class="fa fa-lock" aria-hidden="true"></i> Data Quality</h1>--}}

                            {{--                            <button class="header_btn">Actions <i class="fa fa-caret-down" aria-hidden="true"></i>--}}
                            {{--                            </button>--}}
                            {{--                            <button class="header_btn">Import</button>--}}
                            <button class="create-contact open-form-btn">Create New</button>
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
                            <li class="tab-item active" data-tab="home">Channels
                                <i class="fa fa-times close-icon" aria-hidden="true"></i></li>
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
                                    <table id="allChannelTable" class="table table-striped datatable-exportable
                            stripe row-border order-column nowrap initTable">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th class="align-middle text-center text-nowrap">SNO.</th>
                                            <th class="align-middle text-center text-nowrap">NAME</th>
                                            <th class="align-middle text-center text-nowrap">SLUG</th>
                                            <th class="align-middle text-center text-nowrap">URL</th>
                                            <th class="align-middle text-center text-nowrap">LOGO</th>
                                            <th class="align-middle text-center text-nowrap">FAVICON</th>
                                            <th class="align-middle text-center text-nowrap">DESCRIPTION</th>
                                            <th class="align-middle text-center text-nowrap">LANGUAGE</th>
                                            <th class="align-middle text-center text-nowrap">TIMEZONE</th>
                                            <th class="align-middle text-center text-nowrap">META TITLE</th>
                                            <th class="align-middle text-center text-nowrap">META DESCRIPTION</th>
                                            <th class="align-middle text-center text-nowrap">META KEYWORDS</th>
{{--                                            <th class="align-middle text-center text-nowrap">LAST ACTIVITY</th>--}}
                                            <th class="align-middle text-center text-nowrap">STATUS</th>
                                            <th class="align-middle text-center text-nowrap">ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($channels as $channel)
                                            <tr id="tr-{{$channel->id}}">
                                                <td class="align-middle text-center text-nowrap"></td>
                                                <td class="align-middle text-center text-nowrap">{{$loop->iteration}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$channel->name}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$channel->slug}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$channel->url}}</td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if($channel->logo)
                                                        <img src="{{$channel->logoUrl}}" alt="Logo" style="max-height: 30px;">
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap">
                                                    @if($channel->favicon)
                                                        <img src="{{$channel->faviconUrl}}" alt="Favicon" style="max-height: 30px;">
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-nowrap">{{ Str::limit($channel->description, 50) }}</td>
                                                <td class="align-middle text-center text-nowrap">{{$channel->language}}</td>
                                                <td class="align-middle text-center text-nowrap">{{$channel->timezone}}</td>
                                                <td class="align-middle text-center text-nowrap">{{ Str::limit($channel->meta_title, 20) }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ Str::limit($channel->meta_description, 30) }}</td>
                                                <td class="align-middle text-center text-nowrap">{{ Str::limit($channel->meta_keywords, 30) }}</td>
{{--                                                <td class="align-middle text-center text-nowrap">--}}
{{--                                                    {{ $channel->last_activity_at ? $channel->last_activity_at->timezone('GMT+5')->format('M d, Y g:i A') . " GMT+5": '' }}--}}
{{--                                                </td>--}}
                                                <td class="align-middle text-center text-nowrap">
                                                    <input type="checkbox" class="status-toggle change-status"
                                                           data-id="{{ $channel->id }}"
                                                           {{ $channel->status ? 'checked' : '' }} data-bs-toggle="toggle">
                                                </td>
                                                <td class="align-middle text-center table-actions">
                                                    <button type="button" class="btn btn-sm btn-primary editBtn"
                                                            data-id="{{ $channel->id }}" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger deleteBtn"
                                                            data-id="{{ $channel->id }}" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('admin.channels.custom-form')
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    @push('script')
        @include('admin.channels.script')
    @endpush
@endsection
