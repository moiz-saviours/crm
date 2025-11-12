@extends('user.layouts.app')
@section('title', 'Teams')
@section('datatable', true)
@section('content')
    @push('style')
        @include('user.teams.style')
    @endpush
    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2">Teams <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
                    </div>
                    <div class="filters">
                        <div class="actions">
                            <button class="start-tour-btn my-btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Take a Tour" data-tour="team_create"> <i
                                    class="fas fa-exclamation-circle custom-dot"></i> </button>
                                    <button class="create-contact open-form-btn tour-createteam">Create New</button>
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="content__boxed tour-teamalldata">
            <div class="content__wrap">
                <div class="container" style="min-width: 100%;">
                    <div class="custom-tabs">
                        <ul class="tab-nav">
                            <li class="tab-item active" data-tab="home">Teams
                                <i class="fa fa-times close-icon" aria-hidden="true"></i>
                            </li>
                            <li style="margin: 9px 2px"><button class="my-btn start-tour-btn tour-teamtitle"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Take a Tour"
                                    data-tour="teams"><i class="fas fa-exclamation-circle custom-dot"></i> </button></li>

                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home">
                            <div class="card">
                                <div class="card-header">
                                    <div class="container" style="min-width: 100%;">
                                        <div class="row fltr-sec">
                                            <div class="col-md-8">
                                            </div>
                                            <div class="col-md-4 right-icon text-end" id="right-icon-0"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="allTeamsTable"
                                        class="table table-striped datatable-exportable stripe row-border order-column nowrap initTable">

                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="align-middle text-center text-nowrap">SNO.</th>
                                                    {{-- <th class="align-middle text-center text-nowrap">Team Key</th> --}}
                                                <th class="align-middle text-center text-nowrap">Name</th>

                                                    <th class="align-middle text-center text-nowrap">Description</th>
                                                    <th class="align-middle text-center text-nowrap">Assigned Brands</th>
                                                    <th class="align-middle text-center text-nowrap">Lead</th>
                                                    <th class="align-middle text-center text-nowrap tour-teamstatus">Status
                                                    </th>

                                                        <th class="align-middle text-center text-nowrap tour-teamaction">
                                                            Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($teams as $team)
                                                <tr id="tr-{{ $team->id }}">
                                                    <td class="align-middle text-center text-nowrap"></td>
                                                    <td class="align-middle text-center text-nowrap">{{ $loop->iteration }}
                                                    </td>
                                                        {{-- <td class="align-middle text-center text-nowrap">
                                                            {{ $team->team_key }}
                                                    </td> --}}
                                                    <td class="align-middle text-center text-nowrap">{{ $team->name }}
                                                    </td>

                                                        <td class="align-middle text-center text-nowrap">
                                                            {{ $team->description }}</td>

                                                        <td class="align-middle text-center text-nowrap"
                                                            style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="{{ implode(', ', $team->brands->pluck('name')->toArray()) }}">
                                                            {{ implode(', ', $team->brands->pluck('name')->toArray()) }}
                                                        </td>

                                                        <td class="align-middle text-center text-nowrap">
                                                            {{ optional($team->lead)->name }}
                                                        </td>

                                                        <td class="align-middle text-center text-nowrap">
                                                            <input type="checkbox" class="status-toggle change-status"
                                                                data-id="{{ $team->id }}"
                                                                {{ $team->status == 1 ? 'checked' : '' }}
                                                                data-bs-toggle="toggle">
                                                        </td>

                                                        <td class="align-middle text-center table-actions">
                                                            <button type="button"
                                                                class="btn btn-sm btn-primary editBtn"
                                                                data-id="{{ $team->id }}" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Edit">
                                                                <i class="fas fa-edit"></i>
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
                        @include('user.teams.custom-form')
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
        @push('script')
            @include('user.teams.script')
        @endpush

@endsection
