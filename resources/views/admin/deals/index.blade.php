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
                                        class="table table-striped datatable-exportable stripe row-border order-column nowrap initTable">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    <input type="checkbox" id="select-all">
                                                </th>
                                                <th class="text-center">#</th>
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
