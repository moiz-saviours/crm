@extends('admin.layouts.app')
@section('title', 'Deals')
@section('datatable', true)
@section('content')
    @push('style')
        @include('admin.deals.style')
    @endpush
    <section id="content" class="content">
        <div class="content__header content__boxed overlapping">
            <div class="content__wrap">
                <header class="custm_header">
                    <div class="new_head">
                        <h1 class="page-title mb-2">Deals <i class="fa fa-caret-down" aria-hidden="true"></i></h1>
                    </div>
                    <div class="filters">
                        <div class="actions">
                            <button class="start-tour-btn my-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Take a Tour"
                                    data-tour="deal_create"><i class="fas fa-exclamation-circle custom-dot"></i>
                            </button>
                            <button class="create-record open-form-btn tour-createdeal">Create New</button>
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="content__boxed">
            <div class="">
                <div class="container" style="min-width: 100%;">
                    <div class="tab-content">
                        <div class="tab-pane active" id="home">
                            <div class="card">

                                <div class="card-body">
                                    <table id="allDealsTable"
                                        class="table table-striped datatable-exportable
                            stripe row-border order-column nowrap initTable">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="align-middle text-left text-nowrap">DEAL NAME</th>
                                                <th class="align-middle text-left text-nowrap">COMPANY</th>
                                                <th class="align-middle text-left text-nowrap">CONTACT</th>
                                                <th class="align-middle text-left text-nowrap">DEAL STAGE</th>
                                                <th class="align-middle text-left text-nowrap">AMOUNT</th>
                                                <th class="align-middle text-left text-nowrap">CLOSE DATE</th>
                                                <th class="align-middle text-left text-nowrap">PRIORITY</th>
                                                <th class="align-middle text-left text-nowrap">STATUS</th>
                                                <th class="align-middle text-left text-nowrap tour-dealaction">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($deals as $deal)
                                                <tr id="tr-{{ $deal->id }}">
                                                    <td class="align-middle text-left text-nowrap"></td>
                                                    <td class="align-middle text-left text-nowrap">
                                                        {{ $deal->name ?? '' }}
                                                    </td>
                                                    <td class="align-middle text-left text-nowrap">
                                                        @if ($deal->company)
                                                            {{ $deal->company->name ?? '' }}
                                                        @else
                                                            
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-left text-nowrap">
                                                        @if ($deal->contact)
                                                            {{ $deal->contact->name ?? '' }}
                                                        @else
                                                            
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-left text-nowrap">
                                                        @if ($deal->deal_stage)
                                                            @php
                                                                $dealStages = [
                                                                    1 => 'Appointment Scheduled',
                                                                    2 => 'Qualified To Buy',
                                                                    3 => 'Presentation Scheduled',
                                                                    4 => 'Decision Maker Bought-In',
                                                                    5 => 'Contract Sent',
                                                                    6 => 'Closed Won',
                                                                    7 => 'Closed Lost',
                                                                ];
                                                            @endphp
                                                            <span
                                                                class="badge bg-{{ $deal->deal_stage >= 6 ? ($deal->deal_stage == 6 ? 'success' : 'danger') : 'warning' }}">
                                                                {{ $dealStages[$deal->deal_stage] ?? 'Unknown' }}
                                                            </span>
                                                        @else
                                                            
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-left text-nowrap">
                                                        ${{ number_format($deal->amount, 2) }}
                                                    </td>
                                                    <td class="align-middle text-left text-nowrap">
                                                        {{ $deal->close_date ? $deal->close_date->format('M d, Y') : '' }}
                                                    </td>
                                                    <td class="align-middle text-left text-nowrap">
                                                        @if ($deal->priority)
                                                            <span
                                                                class="badge bg-{{ $deal->priority == 'high' ? 'danger' : ($deal->priority == 'medium' ? 'warning' : 'secondary') }}">
                                                                {{ ucfirst($deal->priority) }}
                                                            </span>
                                                        @else
                                                            
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-left text-nowrap">
                                                        <span class="badge bg-{{ $deal->status ? 'success' : 'danger' }}">
                                                            {{ $deal->status ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-left table-actions">
                                                        <button type="button" class="btn btn-sm btn-primary editBtn"
                                                            data-id="{{ $deal->id }}" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger deleteBtn"
                                                            data-id="{{ $deal->id }}" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Delete">
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
                    @include('admin.deals.custom-form')
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    @push('script')
        <script src="{{asset('assets/js/moment.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/daterangepicker/daterangepicker.min.js')}}"></script>
        @include('admin.deals.script')
    @endpush
@endsection
