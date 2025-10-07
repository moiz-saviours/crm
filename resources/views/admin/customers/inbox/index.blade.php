@extends('admin.layouts.app')
@section('title', 'Customer Inbox')
@section('content')
    @push('style')
        @include('admin.customers.inbox.style')
    @endpush
    <!-- Ashter Working HTML start -->
    <section id="content" class="content custome-email-body">
        <div class="container-fluid loading-container">
            <section class="email-main-body-section">
                <div class="row custom-my-row">
                    <!-- Page 1 Start -->
                    <!-- Left Sidebar (col-md-2) -->
                    <div class="col-md-2 p-0" id="leftSidebar">
                        <div class="bg-white left-sidebar-custom d-flex flex-column p-3 main-content-col"
                             id="left-sidebar">

                            <!-- Header Icons -->
                            <div class="head-icons mb-3">
                                <div class="icon-side sidebar-toggle-btn-custom" id="sidebar-toggle">
                                    <i class="fas fa-angle-double-left toggle-icon"></i>
                                    <span class="sidebar-label">Inbox</span>
                                </div>
                                <div class="search-side sidebar-label">
                                    <i class="fas fa-search" id="openSearch"></i>
                                </div>
                            </div>

                            <!-- User Status -->
                            <div class="main-heading mb-2 sidebar-label">
                                <i class="fas fa-circle me-1" style="color: #10b981"></i>
                                You're available
                                <i class="fas fa-caret-down ms-1"></i>
                            </div>
                            <hr class="border-bottom-dark my-2 sidebar-label"/>

                            <!-- Tabs in Left Sidebar -->
                            <div class="list-group flex-grow-1 sidebar-label" id="inbox-tabs" role="tablist">

                                <!-- Tab links -->
                                <a href="#unassigned-pane"
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center active"
                                   id="unassigned-tab" data-bs-toggle="tab" data-bs-target="#unassigned-pane" role="tab"
                                   aria-controls="unassigned-pane" aria-selected="true">
                                    Unassigned
                                    <span
                                        class="badge rounded-pill text-bg-light">{{ $emails->where('assigned_to', null)->count() }}</span>
                                </a>

                                <a href="#assigned-pane"
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                   id="assigned-tab-1" data-bs-toggle="tab" data-bs-target="#assigned-pane" role="tab"
                                   aria-controls="assigned-pane" aria-selected="false">
                                    Assigned me
                                    <span
                                        class="badge rounded-pill text-bg-light">{{ $emails->where('assigned_to', auth()->id())->count() }}</span>
                                </a>

                                <a href="#all-open-pane"
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                   id="all-open-tab" data-bs-toggle="tab" data-bs-target="#all-open-pane" role="tab"
                                   aria-controls="all-open-pane" aria-selected="false">
                                    All open
                                    <span
                                        class="badge rounded-pill text-bg-light">{{ $emails->where('is_read', true)->count() }}</span>
                                </a>

                                <!-- More / Less Toggle -->
                                <button
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center text-dark toggle-btn"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#moreContent"
                                    aria-expanded="false"
                                    aria-controls="moreContent">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-caret-down toggle-icon me-2"></i>
                                        <span class="toggle-text">More</span>
                                    </div>
                                </button>

                                <!-- Collapsible Content -->
                                <div class="collapse show mt-2" id="moreContent">
                                    <a href="#email-pane"
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                       id="email-tab" data-bs-toggle="tab" data-bs-target="#email-pane" role="tab"
                                       aria-controls="email-pane" aria-selected="false">
                                        Email
                                        <span class="badge rounded-pill text-bg-light">{{count($emails)}}</span>
                                    </a>
                                    <a href="#calls-pane"
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                       id="calls-tab" data-bs-toggle="tab" data-bs-target="#calls-pane" role="tab"
                                       aria-controls="calls-pane" aria-selected="false">
                                        Calls
                                        <span class="badge rounded-pill text-bg-light">0</span>
                                    </a>
                                    <a href="#sent-pane"
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                       id="sent-tab" data-bs-toggle="tab" data-bs-target="#sent-pane" role="tab"
                                       aria-controls="sent-pane"
                                       aria-selected="false">
                                        Sent
                                        <span
                                            class="badge rounded-pill text-bg-light">{{ $emails->where('type', 'sent')->count() }}</span>
                                    </a>
                                    <a href="#spam-pane"
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                       id="spam-tab" data-bs-toggle="tab" data-bs-target="#spam-pane" role="tab"
                                       aria-controls="spam-pane"
                                       aria-selected="false">
                                        Spam
                                        <span
                                            class="badge rounded-pill text-bg-light">{{ $emails->where('is_spam', true)->count() }}</span>
                                    </a>
                                    <a href="#trash-pane"
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                       id="trash-tab" data-bs-toggle="tab" data-bs-target="#trash-pane" role="tab"
                                       aria-controls="trash-pane" aria-selected="false">
                                        Trash
                                        <span
                                            class="badge rounded-pill text-bg-light">{{ $emails->where('is_trashed', true)->count() }}</span>
                                    </a>
                                </div>

                            </div>

                            <hr class="sidebar-label-hr"/>

                            <!-- Bottom buttons -->
                            <div class="d-flex justify-content-center email-body-bottom-button sidebar-label">
                                <div class=" me-2">
                                    <button class="btn btn-secondary" id="actionsBtn">
                                        Actions <i class="fas fa-caret-up ms-2"></i>
                                    </button>

                                    <ul class="actions-menu list-unstyled mt-2" id="actionsMenu" style="display:none;">
                                        <li><a class="dropdown-item cus-dropcol-2" href="#">Manage Team Availability</a>
                                        </li>
                                        <li><a class="dropdown-item cus-dropcol-2" href="#">Create a View <i
                                                    class="fas fa-eye ms-2"></i>
                                            </a></li>
                                        <li><a class="dropdown-item cus-dropcol-2" href="#">Connect a Channel</a></li>
                                    </ul>


                                </div>
                                <button class="btn btn-primary">Compose</button>
                            </div>

                        </div>
                    </div>

                    <!-- Email Content Area (col-md-3) -->
                    <div class="col-md-3 uppper-part-main list-column">
                        <div class="main-content-col" id="email-content">
                            <div class="d-flex justify-content-between align-items-center p-3 uppper-part">
                                <div id="action-container" class="d-flex align-items-center">
                                    <label class="custom-checkbox me-2">
                                        <input type="checkbox" id="main-checkbox">
                                        <span class="check-icon"></span>
                                    </label>
                                    <div id="default-actions" class="d-flex">
                                        <button class="open-btn ms-2">Open</button>
                                        <button class="close-btn me-2">Closed</button>
                                    </div>
                                    <div id="selected-actions" class="d-flex align-items-center d-none">
                                        <span class="me-3 hidden-text-selected">1 selected</span>
                                        <div class="btn-group" role="group"></div>
                                    </div>
                                </div>
                                <div class="upper-text">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle upper-text" type="button" id="sortDropdown"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            Newest
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                            <li><a class="dropdown-item" href="#">Newest</a></li>
                                            <li><a class="dropdown-item" href="#">Oldest</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content" id="inbox-tab-content">
                                <!-- Unassigned Tab Pane -->
                                <div class="tab-pane fade show active" id="unassigned-pane" role="tabpanel"
                                     aria-labelledby="unassigned-tab">
                                    <div class="list-group" id="email-list-unassigned" role="tablist">
                                        <!-- Static Start -->
                                        {{--                                        <a href="#email-detail-1"--}}
                                        {{--                                           class="list-group-item list-group-item-action email-main-body active"--}}
                                        {{--                                           data-bs-toggle="tab" data-bs-target="#email-detail-1"--}}
                                        {{--                                           data-sidebar-target="#sidebar-detail-1"--}}
                                        {{--                                           role="tab" aria-controls="email-detail-1" aria-selected="true"--}}
                                        {{--                                           data-name="Hasnat Khan"--}}
                                        {{--                                           data-email="hasnat.khan@stellers.org" data-subject="Re: Test">--}}
                                        {{--                                            <div class="d-flex align-items-center">--}}
                                        {{--                                                <div class="icon-checkbox-wrapper me-3">--}}
                                        {{--                                                    <i class="far fa-envelope active-enelops"></i>--}}
                                        {{--                                                    <label class="custom-checkbox me-2">--}}
                                        {{--                                                        <input type="checkbox" id="main-checkbox">--}}
                                        {{--                                                        <span class="check-icon"></span>--}}
                                        {{--                                                    </label>--}}
                                        {{--                                                    </label>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <div class="email-contents flex-grow-1">--}}
                                        {{--                                                    <p class="mb-0 email-address">--}}
                                        {{--                                                        hasnat.khan@stellers.org--}}
                                        {{--                                                    </p>--}}
                                        {{--                                                    <p class="mb-0 email-subject">Re: Test</p>--}}
                                        {{--                                                    <p class="small-para mb-0 text-muted">--}}
                                        {{--                                                        <i class="fas fa-reply me-2"></i> test email--}}
                                        {{--                                                    </p>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <p class="para-second mb-0">11s</p>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </a>--}}
                                        {{--                                        <a href="#email-detail-2"--}}
                                        {{--                                           class="list-group-item list-group-item-action email-main-body"--}}
                                        {{--                                           data-bs-toggle="tab" data-bs-target="#email-detail-2"--}}
                                        {{--                                           data-sidebar-target="#sidebar-detail-2"--}}
                                        {{--                                           role="tab" aria-controls="email-detail-2" aria-selected="false"--}}
                                        {{--                                           data-name="Moiz Athar"--}}
                                        {{--                                           data-email="moiz@saviours.co" data-subject="Project Update">--}}
                                        {{--                                            <div class="d-flex align-items-center">--}}
                                        {{--                                                <div class="icon-checkbox-wrapper me-3">--}}
                                        {{--                                                    <i class="far fa-envelope"></i>--}}
                                        {{--                                                    <label class="custom-checkbox me-2">--}}
                                        {{--                                                        <input type="checkbox" class="hover-checkbox"/>--}}
                                        {{--                                                        <span class="check-icon"></span>--}}
                                        {{--                                                    </label>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <div class="email-contents flex-grow-1">--}}
                                        {{--                                                    <p class="mb-0 email-address">moiz@saviours.co</p>--}}
                                        {{--                                                    <p class="mb-0 email-subject">Project Update</p>--}}
                                        {{--                                                    <p class="small-para mb-0 text-muted">--}}
                                        {{--                                                        <i class="fas fa-reply me-2"></i> Regarding the--}}
                                        {{--                                                        new feature.--}}
                                        {{--                                                    </p>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <p class="para-second mb-0">5m</p>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </a>--}}
                                        <!-- Static End -->

                                        @foreach($emails->where('assigned_to', null) as $email)
                                            @include('admin.customers.inbox.partials.email-list')
                                        @endforeach
                                    </div>
                                </div>
                                <!-- Assigned to Me Tab Pane -->
                                <div class="tab-pane fade" id="assigned-pane" role="tabpanel"
                                     aria-labelledby="assigned-tab">
                                    <div class="list-group" id="email-list-assigned" role="tablist">
                                        {{--                                        <a href="#email-detail-3"--}}
                                        {{--                                           class="list-group-item list-group-item-action email-main-body"--}}
                                        {{--                                           data-bs-toggle="tab" data-bs-target="#email-detail-3"--}}
                                        {{--                                           data-sidebar-target="#sidebar-detail-3"--}}
                                        {{--                                           role="tab" aria-controls="email-detail-3" aria-selected="true"--}}
                                        {{--                                           data-name="Sarah Johnson"--}}
                                        {{--                                           data-email="sarah.j@example.com" data-subject="Meeting Request">--}}
                                        {{--                                            <div class="d-flex align-items-center">--}}
                                        {{--                                                <div class="icon-checkbox-wrapper me-3">--}}
                                        {{--                                                    <i class="far fa-envelope"></i>--}}
                                        {{--                                                    <label class="custom-checkbox me-2">--}}
                                        {{--                                                        <input type="checkbox" class="hover-checkbox"/>--}}
                                        {{--                                                        <span class="check-icon"></span>--}}
                                        {{--                                                    </label>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <div class="email-contents flex-grow-1">--}}
                                        {{--                                                    <p class="mb-0 email-address">--}}
                                        {{--                                                        sarah.j@example.com--}}
                                        {{--                                                    </p>--}}
                                        {{--                                                    <p class="mb-0 email-subject">Meeting Request</p>--}}
                                        {{--                                                    <p class="small-para mb-0 text-muted">--}}
                                        {{--                                                        <i class="fas fa-reply me-2"></i> Let's schedule a--}}
                                        {{--                                                        call next week.--}}
                                        {{--                                                    </p>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <p class="para-second mb-0">15m</p>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </a>--}}
                                        @foreach($emails->where('assigned_to', auth()->id()) as $email)
                                            @include('admin.customers.inbox.partials.email-list')
                                        @endforeach
                                    </div>
                                </div>

                                <!-- All Open Tab Pane -->
                                <div class="tab-pane fade" id="all-open-pane" role="tabpanel"
                                     aria-labelledby="all-open-tab">
                                    <div class="list-group" id="email-list-all-open" role="tablist">
                                        {{--                                        <a href="#email-detail-1"--}}
                                        {{--                                           class="list-group-item list-group-item-action email-main-body"--}}
                                        {{--                                           data-bs-toggle="tab" data-bs-target="#email-detail-1"--}}
                                        {{--                                           data-sidebar-target="#sidebar-detail-1"--}}
                                        {{--                                           role="tab" aria-controls="email-detail-1" aria-selected="true">--}}
                                        {{--                                            <div class="d-flex align-items-center">--}}
                                        {{--                                                <div class="icon-checkbox-wrapper me-3">--}}
                                        {{--                                                    <i class="far fa-envelope active-enelops"></i>--}}
                                        {{--                                                    <label class="custom-checkbox me-2">--}}
                                        {{--                                                        <input type="checkbox" class="hover-checkbox"/>--}}
                                        {{--                                                        <span class="check-icon"></span>--}}
                                        {{--                                                    </label>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <div class="email-contents flex-grow-1">--}}
                                        {{--                                                    <p class="mb-0 email-address">--}}
                                        {{--                                                        hasnat.khan@stellers.org--}}
                                        {{--                                                    </p>--}}
                                        {{--                                                    <p class="mb-0 email-subject">Re: Test</p>--}}
                                        {{--                                                    <p class="small-para mb-0 text-muted">--}}
                                        {{--                                                        <i class="fas fa-reply me-2"></i> test email--}}
                                        {{--                                                    </p>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <p class="para-second mb-0">11s</p>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </a>--}}
                                        {{--                                        <a href="#email-detail-2"--}}
                                        {{--                                           class="list-group-item list-group-item-action email-main-body"--}}
                                        {{--                                           data-bs-toggle="tab" data-bs-target="#email-detail-2"--}}
                                        {{--                                           data-sidebar-target="#sidebar-detail-2"--}}
                                        {{--                                           role="tab" aria-controls="email-detail-2" aria-selected="false">--}}
                                        {{--                                            <div class="d-flex align-items-center">--}}
                                        {{--                                                <div class="icon-checkbox-wrapper me-3">--}}
                                        {{--                                                    <i class="far fa-envelope"></i>--}}
                                        {{--                                                    <label class="custom-checkbox me-2">--}}
                                        {{--                                                        <input type="checkbox" class="hover-checkbox"/>--}}
                                        {{--                                                        <span class="check-icon"></span>--}}
                                        {{--                                                    </label>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <div class="email-contents flex-grow-1">--}}
                                        {{--                                                    <p class="mb-0 email-address">moiz@saviours.co</p>--}}
                                        {{--                                                    <p class="mb-0 email-subject">Project Update</p>--}}
                                        {{--                                                    <p class="small-para mb-0 text-muted">--}}
                                        {{--                                                        <i class="fas fa-reply me-2"></i> Regarding the--}}
                                        {{--                                                        new feature.--}}
                                        {{--                                                    </p>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <p class="para-second mb-0">5m</p>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </a>--}}
                                        @foreach($emails->where('is_read', true) as $email)
                                            @include('admin.customers.inbox.partials.email-list')
                                        @endforeach
                                    </div>
                                </div>
                                <!-- Email Tab Pane -->
                                <div class="tab-pane fade" id="email-pane" role="tabpanel" aria-labelledby="email-tab">
                                    <div class="list-group" id="email-list-email" role="tablist">
                                        {{--                                        <a href="#email-detail-1"--}}
                                        {{--                                           class="list-group-item list-group-item-action email-main-body"--}}
                                        {{--                                           data-bs-toggle="tab" data-bs-target="#email-detail-1"--}}
                                        {{--                                           data-sidebar-target="#sidebar-detail-1"--}}
                                        {{--                                           role="tab" aria-controls="email-detail-1" aria-selected="true">--}}
                                        {{--                                            <div class="d-flex align-items-center">--}}
                                        {{--                                                <div class="icon-checkbox-wrapper me-3">--}}
                                        {{--                                                    <i class="far fa-envelope active-enelops"></i>--}}
                                        {{--                                                    <label class="custom-checkbox me-2">--}}
                                        {{--                                                        <input type="checkbox" class="hover-checkbox"/>--}}
                                        {{--                                                        <span class="check-icon"></span>--}}
                                        {{--                                                    </label>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <div class="email-contents flex-grow-1">--}}
                                        {{--                                                    <p class="mb-0 email-address">--}}
                                        {{--                                                        hasnat.khan@stellers.org--}}
                                        {{--                                                    </p>--}}
                                        {{--                                                    <p class="mb-0 email-subject">Re: Test</p>--}}
                                        {{--                                                    <p class="small-para mb-0 text-muted">--}}
                                        {{--                                                        <i class="fas fa-reply me-2"></i> test email--}}
                                        {{--                                                    </p>--}}
                                        {{--                                                </div>--}}
                                        {{--                                                <p class="para-second mb-0">11s</p>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </a>--}}

                                        @foreach($emails as $email)
                                            @include('admin.customers.inbox.partials.email-list')
                                        @endforeach
                                    </div>
                                </div>
                                <!-- Calls Tab Pane -->
                                <div class="tab-pane fade" id="calls-pane" role="tabpanel" aria-labelledby="calls-tab">
                                    <div class="list-group" id="email-list-calls" role="tablist">
                                        <div class="text-center p-4 text-muted">
                                            <i class="fas fa-phone-slash fa-2x mb-3"></i>

                                            <p>No call conversations</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Trash Tab Pane -->
                                <div class="tab-pane fade" id="trash-pane" role="tabpanel" aria-labelledby="trash-tab">
                                    <div class="list-group" id="email-list-trash" role="tablist">
                                        @if($emails->where('is_trashed', true)->count())
                                            @foreach($emails->where('is_trashed', true) as $email)
                                                @include('admin.customers.inbox.partials.email-list')
                                            @endforeach
                                        @else
                                            <div class="text-center p-4 text-muted">
                                                <i class="fas fa-trash fa-2x mb-3"></i>
                                                <p>No trash conversations</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- Sent Tab Pane -->
                                <div class="tab-pane fade" id="sent-pane" role="tabpanel" aria-labelledby="sent-tab">
                                    <div class="list-group" id="email-list-sent" role="tablist">
                                        @if($emails->where('type', 'sent')->count())
                                            @foreach($emails->where('type', 'sent') as $email)
                                                @include('admin.customers.inbox.partials.email-list')
                                            @endforeach
                                        @else
                                            <div class="text-center p-4 text-muted">
                                                <i class="fas fa-paper-plane fa-2x mb-3"></i>
                                                <p>No sent conversations</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Spam Tab Pane -->
                                <div class="tab-pane fade" id="spam-pane" role="tabpanel" aria-labelledby="spam-tab">
                                    <div class="list-group" id="email-list-spam" role="tablist">
                                        @if($emails->where('is_spam', true)->count())
                                            @foreach($emails->where('is_spam', true) as $email)
                                                @include('admin.customers.inbox.partials.email-list')
                                            @endforeach
                                        @else
                                            <div class="text-center p-4 text-muted">
                                                <i class="fas fa-ban fa-2x mb-3"></i>
                                                <p>No spam conversations</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- All Closed Tab Pane -->
                                <div class="tab-pane fade" id="all-closed-pane" role="tabpanel"
                                     aria-labelledby="all-closed-tab">
                                    <div class="list-group" id="email-list-all-closed" role="tablist">
                                        @if($emails->where('is_read', false)->count())
                                            @foreach($emails->where('is_read', false) as $email)
                                                @include('admin.customers.inbox.partials.email-list')
                                            @endforeach
                                        @else
                                            <div class="text-center p-4 text-muted">
                                                <i class="fas fa-inbox fa-2x mb-3"></i>
                                                <p>No closed conversations</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Panel - Email Detail View (col-md-4) -->
                    <div class="col-md-4 main-email-area-section list-column">
                        <div class="main-content-col" id="main-email-area">
                            <div class="tab-content" id="email-detail-content">
                                @foreach($emails as $email)
                                    @include('admin.customers.inbox.partials.email-box')
                                @endforeach
                                {{--                                <!-- Email Detail for Email ID 1 -->--}}
                                {{--                                <div class="tab-pane fade show active" id="email-detail-1" role="tabpanel"--}}
                                {{--                                     aria-labelledby="email-detail-1-tab">--}}
                                {{--                                    <div--}}
                                {{--                                        class="d-flex justify-content-between align-items-center email-header-main px-3 border-bottom">--}}
                                {{--                                        <div class="d-flex align-items-center">--}}
                                {{--                                            <span class="profile-avatar-h me-3">H</span>--}}
                                {{--                                            <div>--}}
                                {{--                                                <span class="main-area-email-para">hasnat.khan@stellers.org</span><br/>--}}
                                {{--                                                <span class="main-area-email-para-time">Created 3 hours ago</span>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                    <div class="p-3">--}}
                                {{--                                        <div class="d-flex justify-content-between align-items-center mb-3">--}}
                                {{--                                            <span class="profile-description">Owner</span>--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="d-flex align-items-center justify-content-between mb-4">--}}
                                {{--                                            <div class="user-info-dropdown">--}}
                                {{--                                                <div class="user-info d-flex align-items-center" id="userDropdownToggle"--}}
                                {{--                                                     role="button" aria-expanded="false">--}}
                                {{--                                                    <div class="icon-wrapper me-2">--}}
                                {{--                                                        <i class="fas fa-user-circle profile-icon"--}}
                                {{--                                                           aria-hidden="true"></i>--}}
                                {{--                                                        <span class="status-dot"></span>--}}
                                {{--                                                    </div>--}}
                                {{--                                                    <p class="user_name mb-0">Hasnat Khan</p>--}}
                                {{--                                                    <i class="fas fa-caret-down ms-2 custom-fa-caret-down"--}}
                                {{--                                                       aria-hidden="true"></i>--}}
                                {{--                                                </div>--}}

                                {{--                                                <div class="user-dropdown-menu" id="userDropdownMenu">--}}
                                {{--                                                    <div class="search-box">--}}
                                {{--                                                        <input type="text" placeholder="Search for a specific user">--}}
                                {{--                                                        <i class="fas fa-search search-icon"></i>--}}
                                {{--                                                    </div>--}}

                                {{--                                                    <div class="d-flex justify-content-end mb-2">--}}
                                {{--                                                        <button class="unassign-btn">Unassign</button>--}}
                                {{--                                                    </div>--}}

                                {{--                                                    <div class="user-list">--}}
                                {{--                                                        <div--}}
                                {{--                                                            class="user-item-row active-user d-flex align-items-center justify-content-between">--}}
                                {{--                                                            <div class="d-flex align-items-center">--}}
                                {{--                                                                <div class="avatar-sm me-2">--}}
                                {{--                                                                    <i class="fas fa-user-circle"></i>--}}
                                {{--                                                                    <span class="status-dot-sm away"></span>--}}
                                {{--                                                                </div>--}}
                                {{--                                                                <div>--}}
                                {{--                                                                    <p class="item-user-name mb-0">Hasnat Khan</p>--}}
                                {{--                                                                    <p class="item-user-status mb-0 away-text">Away</p>--}}
                                {{--                                                                </div>--}}
                                {{--                                                            </div>--}}
                                {{--                                                            <i class="fas fa-check check-icon"></i>--}}
                                {{--                                                        </div>--}}

                                {{--                                                    </div>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                            <h5 class="mb-3">Re: Test</h5>--}}
                                {{--                                        </div>--}}

                                {{--                                        <div class="email-reply-wrapper">--}}
                                {{--                                            <div class="d-flex align-items-start email-reply-block">--}}
                                {{--                                                <i class="fas fa-user-circle profile-icon me-4"></i>--}}
                                {{--                                                <div class="flex-grow-1">--}}
                                {{--                                                    <p class="email-from mb-0">--}}
                                {{--                                                        <b>Hasnat Khan</b>--}}
                                {{--                                                        <span class="text-muted small">8:19 PM</span>--}}
                                {{--                                                        <span class="ms-4 last-span text-bold">--}}
                                {{--                              Email--}}
                                {{--                              <i class="fas fa-caret-down ms-2 last-span-icon"></i>--}}
                                {{--                            </span>--}}
                                {{--                                                    </p>--}}
                                {{--                                                    <p class="mb-0 email-to text-muted small">--}}
                                {{--                                                        To: hasnat.khan@stellers.org--}}
                                {{--                                                    </p>--}}
                                {{--                                                    <p class="email-body mt-2">--}}
                                {{--                                                        Test email content goes here. This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes. Test email content goes here.--}}
                                {{--                                                        This is a sample--}}
                                {{--                                                        email for demonstration purposes.--}}
                                {{--                                                    </p>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                        <hr/>--}}
                                {{--                                        <div class="resizable-panel">--}}
                                {{--                                            <div class="resizable-content">--}}
                                {{--                                                <div--}}
                                {{--                                                    class="d-flex justify-content-start align-items-center mt-3 envelop-open-text-section">--}}
                                {{--                                                    <i class="fas fa-envelope-open-text me-1 icon-email-reply"></i>--}}
                                {{--                                                    <span class="email-comment-tabs email-decription">Email <i--}}
                                {{--                                                            class="fas fa-caret-down ms-1"></i></span>--}}
                                {{--                                                    <i class="fas fa-comment ms-4 me-2 icon-comment"></i>--}}
                                {{--                                                    <span class="email-comment-tabs comment-description">Comment</span>--}}
                                {{--                                                    <span class="ms-auto">--}}
                                {{--                            <i class="fa-solid fa-up-right-and-down-left-from-center enlarge-icon"></i>--}}
                                {{--                          </span>--}}
                                {{--                                                </div>--}}
                                {{--                                                <div--}}
                                {{--                                                    class="d-flex justify-content-between align-items-center text-muted mt-2 mb-2 email-area-choose-reciepeint">--}}
                                {{--                                                    <div--}}
                                {{--                                                        class="recipient-selection-container d-flex align-items-center flex-grow-1 me-3">--}}
                                {{--                                                        <i class="fas fa-reply" id="reply-icon"></i>--}}
                                {{--                                                        <div class="d-flex flex-wrap align-items-center flex-grow-1">--}}
                                {{--                                                            <input--}}
                                {{--                                                                class="email-area-input-for-recipeint ms-2 flex-grow-1 border-0"--}}
                                {{--                                                                placeholder="Enter or choose a recipient"--}}
                                {{--                                                                type="text"--}}
                                {{--                                                                autocomplete="off"/>--}}
                                {{--                                                        </div>--}}
                                {{--                                                    </div>--}}
                                {{--                                                    <i class="fas fa-ellipsis-v ms-3" id="more-options-icon"></i>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="form-control mt-2 email-compose-box">--}}
                                {{--                                            <div class="editor-wrapper">--}}
                                {{--                                                <div id="editorContent" class=" text-placeholder"--}}
                                {{--                                                     contenteditable="true">--}}
                                {{--                                                    Write a message. Press '/' or highlight text to--}}
                                {{--                                                    access AI commands.--}}
                                {{--                                                </div>--}}
                                {{--                                                <div class="editor-toolbar d-flex justify-content-between">--}}
                                {{--                                                    <div class="d-flex align-items-center">--}}
                                {{--                                                        <i class="editor-icon fas fa-font me-3" data-bs-toggle="tooltip"--}}
                                {{--                                                           title="Change Font"></i>--}}
                                {{--                                                        <i class="editor-icon fas fa-smile me-3 text-primary"--}}
                                {{--                                                           data-bs-toggle="tooltip"--}}
                                {{--                                                           title="Press window with ;"></i>--}}
                                {{--                                                        <div class="dropdown me-3">--}}
                                {{--                                                            <i class="editor-icon fas fa-link" role="button"--}}
                                {{--                                                               data-bs-toggle="dropdown"--}}
                                {{--                                                               aria-expanded="false"></i>--}}
                                {{--                                                            <ul class="dropdown-menu">--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Insert Link</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Remove Link</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                            </ul>--}}
                                {{--                                                        </div>--}}
                                {{--                                                        <div class="dropdown me-3">--}}
                                {{--                                                            <i class="editor-icon fas fa-image" role="button"--}}
                                {{--                                                               data-bs-toggle="dropdown"--}}
                                {{--                                                               aria-expanded="false"></i>--}}
                                {{--                                                            <ul class="dropdown-menu">--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Upload New--}}
                                {{--                                                                        Image</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Insert Existing--}}
                                {{--                                                                        Image</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                            </ul>--}}
                                {{--                                                        </div>--}}
                                {{--                                                        <div class="dropup me-3">--}}
                                {{--                                                            <i class="editor-icon fas fa-paperclip" role="button"--}}
                                {{--                                                               data-bs-toggle="dropdown"--}}
                                {{--                                                               aria-expanded="false"></i>--}}
                                {{--                                                            <ul class="dropdown-menu">--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Attach File</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Browse--}}
                                {{--                                                                        Documents</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                            </ul>--}}
                                {{--                                                        </div>--}}
                                {{--                                                        <div class="dropup me-3">--}}
                                {{--                                                            <button class="btn btn-secondary insert-btn" type="button"--}}
                                {{--                                                                    data-bs-toggle="dropdown"--}}
                                {{--                                                                    aria-expanded="false">--}}
                                {{--                                                                Insert--}}
                                {{--                                                            </button>--}}
                                {{--                                                            <ul class="dropdown-menu">--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Insert Invoice</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Insert--}}
                                {{--                                                                        Documents</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Insert Code</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                            </ul>--}}
                                {{--                                                        </div>--}}
                                {{--                                                    </div>--}}
                                {{--                                                    <button class="btn btn-primary send-btn">--}}
                                {{--                                                        Send--}}
                                {{--                                                    </button>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                {{--                                <!-- Email Detail for Email ID 2 -->--}}
                                {{--                                <div class="tab-pane fade" id="email-detail-2" role="tabpanel"--}}
                                {{--                                     aria-labelledby="email-detail-2-tab">--}}
                                {{--                                    <div--}}
                                {{--                                        class="d-flex justify-content-between align-items-center email-header-main px-3 border-bottom">--}}
                                {{--                                        <div class="d-flex align-items-center">--}}
                                {{--                                            <span class="profile-avatar-h me-3">M</span>--}}
                                {{--                                            <div>--}}
                                {{--                                                <span class="main-area-email-para">moiz@saviours.co</span><br/>--}}
                                {{--                                                <span class="main-area-email-para-time">Created 5 minutes ago</span>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                    <div class="p-3">--}}
                                {{--                                        <div class="d-flex justify-content-between align-items-center mb-3">--}}
                                {{--                                            <span class="profile-description">Owner</span>--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="d-flex align-items-center justify-content-between mb-4">--}}
                                {{--                                            <div class="user-info-dropdown">--}}
                                {{--                                                <div class="user-info d-flex align-items-center">--}}
                                {{--                                                    <div class="icon-wrapper me-2">--}}
                                {{--                                                        <i class="fas fa-user-circle profile-icon"></i>--}}
                                {{--                                                        <span class="status-dot"></span>--}}
                                {{--                                                    </div>--}}
                                {{--                                                    <p class="user_name mb-0">Moiz Athar</p>--}}
                                {{--                                                    <i class="fas fa-caret-down ms-2 custom-fa-caret-down"></i>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                            <h5 class="mb-3">Project Update</h5>--}}
                                {{--                                        </div>--}}

                                {{--                                        <div class="email-reply-wrapper">--}}
                                {{--                                            <div class="d-flex align-items-start email-reply-block">--}}
                                {{--                                                <i class="fas fa-user-circle profile-icon me-4"></i>--}}
                                {{--                                                <div class="flex-grow-1">--}}
                                {{--                                                    <p class="email-from mb-0">--}}
                                {{--                                                        <b>Moiz Athar</b>--}}
                                {{--                                                        <span class="text-muted small">9:05 PM</span>--}}
                                {{--                                                        <span class="ms-4 last-span text-bold">--}}
                                {{--                              Email--}}
                                {{--                              <i class="fas fa-caret-down ms-2 last-span-icon"></i>--}}
                                {{--                            </span>--}}
                                {{--                                                    </p>--}}
                                {{--                                                    <p class="mb-0 email-to text-muted small">--}}
                                {{--                                                        To: moiz@saviours.co--}}
                                {{--                                                    </p>--}}
                                {{--                                                    <p class="email-body mt-2">--}}
                                {{--                                                        Regarding the new feature implementation. We've--}}
                                {{--                                                        completed the initial testing phase and are ready--}}
                                {{--                                                        for the next steps. Please review the attached--}}
                                {{--                                                        document and let me know your thoughts. Regarding--}}
                                {{--                                                        the new feature implementation. We've completed--}}
                                {{--                                                        the initial testing phase and are ready for the--}}
                                {{--                                                        next steps. Please review the attached document--}}
                                {{--                                                        and let me know your thoughts.Regarding the new--}}
                                {{--                                                        feature implementation. We've completed the--}}
                                {{--                                                        initial testing phase and are ready for the next--}}
                                {{--                                                        steps. Please review the attached document and let--}}
                                {{--                                                        me know your thoughts. Regarding the new feature--}}
                                {{--                                                        implementation. We've completed the initial--}}
                                {{--                                                        testing phase and are ready for the next steps.--}}
                                {{--                                                        Please review the attached document and let me--}}
                                {{--                                                        know your thoughts. Regarding the new feature--}}
                                {{--                                                        implementation. We've completed the initial--}}
                                {{--                                                        testing phase and are ready for the next steps.--}}
                                {{--                                                        Please review the attached document and let me--}}
                                {{--                                                        know your thoughts.Regarding the new feature--}}
                                {{--                                                        implementation. We've completed the initial--}}
                                {{--                                                        testing phase and are ready for the next steps.--}}
                                {{--                                                        Please review the attached document and let me--}}
                                {{--                                                        know your thoughts. Regarding the new feature--}}
                                {{--                                                        implementation. We've completed the initial--}}
                                {{--                                                        testing phase and are ready for the next steps.--}}
                                {{--                                                        Please review the attached document and let me--}}
                                {{--                                                        know your thoughts. Regarding the new feature--}}
                                {{--                                                        implementation. We've completed the initial--}}
                                {{--                                                        testing phase and are ready for the next steps.--}}
                                {{--                                                        Please review the attached document and let me--}}
                                {{--                                                        know your thoughts.Regarding the new feature--}}
                                {{--                                                        implementation. We've completed the initial--}}
                                {{--                                                        testing phase and are ready for the next steps.--}}
                                {{--                                                        Please review the attached document and let me--}}
                                {{--                                                        know your thoughts.--}}
                                {{--                                                    </p>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                        <hr/>--}}
                                {{--                                        <div class="resizable-panel">--}}
                                {{--                                            <div class="resizable-content">--}}
                                {{--                                                <div--}}
                                {{--                                                    class="d-flex justify-content-start align-items-center mt-3 envelop-open-text-section">--}}
                                {{--                                                    <i class="fas fa-envelope-open-text me-1 icon-email-reply"></i>--}}
                                {{--                                                    <span class="email-comment-tabs email-decription">Email <i--}}
                                {{--                                                            class="fas fa-caret-down ms-1"></i></span>--}}
                                {{--                                                    <i class="fas fa-comment ms-4 me-2 icon-comment"></i>--}}
                                {{--                                                    <span class="email-comment-tabs comment-description">Comment</span>--}}
                                {{--                                                    <span class="ms-auto">--}}
                                {{--                            <i class="fa-solid fa-up-right-and-down-left-from-center enlarge-icon"></i>--}}
                                {{--                          </span>--}}
                                {{--                                                </div>--}}
                                {{--                                                <div--}}
                                {{--                                                    class="d-flex justify-content-between align-items-center text-muted mt-2 mb-2 email-area-choose-reciepeint">--}}
                                {{--                                                    <div--}}
                                {{--                                                        class="recipient-selection-container d-flex align-items-center flex-grow-1 me-3">--}}
                                {{--                                                        <i class="fas fa-reply" id="reply-icon"></i>--}}
                                {{--                                                        <div class="d-flex flex-wrap align-items-center flex-grow-1">--}}
                                {{--                                                            <input--}}
                                {{--                                                                class="email-area-input-for-recipeint ms-2 flex-grow-1 border-0"--}}
                                {{--                                                                placeholder="Enter or choose a recipient"--}}
                                {{--                                                                type="text"--}}
                                {{--                                                                autocomplete="off"/>--}}
                                {{--                                                        </div>--}}
                                {{--                                                    </div>--}}
                                {{--                                                    <i class="fas fa-ellipsis-v ms-3" id="more-options-icon"></i>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="form-control mt-2 email-compose-box">--}}
                                {{--                                            <div class="editor-wrapper">--}}
                                {{--                                                <div id="editorContent" class="text-muted text-placeholder"--}}
                                {{--                                                     contenteditable="true">--}}
                                {{--                                                    Write a message. Press '/' or highlight text to--}}
                                {{--                                                    access AI commands.--}}
                                {{--                                                </div>--}}
                                {{--                                                <div--}}
                                {{--                                                    class="editor-toolbar d-flex justify-content-between align-items-center">--}}
                                {{--                                                    <div class="d-flex align-items-center">--}}
                                {{--                                                        <i class="editor-icon fas fa-font me-3" data-bs-toggle="tooltip"--}}
                                {{--                                                           title="Change Font"></i>--}}
                                {{--                                                        <i class="editor-icon fas fa-smile me-3 text-primary"--}}
                                {{--                                                           data-bs-toggle="tooltip"--}}
                                {{--                                                           title="Insert Emoji"></i>--}}
                                {{--                                                        <div class="dropdown me-3">--}}
                                {{--                                                            <i class="editor-icon fas fa-link" role="button"--}}
                                {{--                                                               data-bs-toggle="dropdown"--}}
                                {{--                                                               aria-expanded="false"></i>--}}
                                {{--                                                            <ul class="dropdown-menu">--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Insert Link</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Remove Link</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                            </ul>--}}
                                {{--                                                        </div>--}}
                                {{--                                                        <div class="dropdown me-3">--}}
                                {{--                                                            <i class="editor-icon fas fa-image" role="button"--}}
                                {{--                                                               data-bs-toggle="dropdown"--}}
                                {{--                                                               aria-expanded="false"></i>--}}
                                {{--                                                            <ul class="dropdown-menu">--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Upload New--}}
                                {{--                                                                        Image</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Insert Existing--}}
                                {{--                                                                        Image</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                            </ul>--}}
                                {{--                                                        </div>--}}
                                {{--                                                        <div class="dropup me-3">--}}
                                {{--                                                            <i class="editor-icon fas fa-paperclip" role="button"--}}
                                {{--                                                               data-bs-toggle="dropdown"--}}
                                {{--                                                               aria-expanded="false"></i>--}}
                                {{--                                                            <ul class="dropdown-menu">--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Attach File</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Browse--}}
                                {{--                                                                        Documents</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                            </ul>--}}
                                {{--                                                        </div>--}}
                                {{--                                                        <div class="dropup me-3">--}}
                                {{--                                                            <button class="btn btn-secondary insert-btn" type="button"--}}
                                {{--                                                                    data-bs-toggle="dropdown"--}}
                                {{--                                                                    aria-expanded="false">--}}
                                {{--                                                                Insert--}}
                                {{--                                                            </button>--}}
                                {{--                                                            <ul class="dropdown-menu">--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Insert Invoice</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Insert--}}
                                {{--                                                                        Documents</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Insert Code</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                            </ul>--}}
                                {{--                                                        </div>--}}
                                {{--                                                    </div>--}}
                                {{--                                                    <button class="btn btn-primary send-btn">--}}
                                {{--                                                        Send--}}
                                {{--                                                    </button>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                {{--                                <!-- Email Detail for Email ID 3 -->--}}
                                {{--                                <div class="tab-pane fade" id="email-detail-3" role="tabpanel"--}}
                                {{--                                     aria-labelledby="email-detail-3-tab">--}}
                                {{--                                    <div--}}
                                {{--                                        class="d-flex justify-content-between align-items-center email-header-main px-3 border-bottom">--}}
                                {{--                                        <div class="d-flex align-items-center">--}}
                                {{--                                            <span class="profile-avatar-h me-3">S</span>--}}
                                {{--                                            <div>--}}
                                {{--                                                <span class="main-area-email-para">sarah.j@example.com</span><br/>--}}
                                {{--                                                <span class="main-area-email-para-time">Created 15 minutes ago</span>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                    <div class="p-3">--}}
                                {{--                                        <div class="d-flex justify-content-between align-items-center mb-3">--}}
                                {{--                                            <span class="profile-description">Owner</span>--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="d-flex align-items-center justify-content-between mb-4">--}}
                                {{--                                            <div class="user-info-dropdown">--}}
                                {{--                                                <div class="user-info d-flex align-items-center" id="userDropdownToggle"--}}
                                {{--                                                     role="button" aria-expanded="false">--}}
                                {{--                                                    <div class="icon-wrapper me-2">--}}
                                {{--                                                        <i class="fas fa-user-circle profile-icon"--}}
                                {{--                                                           aria-hidden="true"></i>--}}
                                {{--                                                        <span class="status-dot"></span>--}}
                                {{--                                                    </div>--}}
                                {{--                                                    <p class="user_name mb-0">Hasnat Khan</p>--}}
                                {{--                                                    <i class="fas fa-caret-down ms-2 custom-fa-caret-down"--}}
                                {{--                                                       aria-hidden="true"></i>--}}
                                {{--                                                </div>--}}

                                {{--                                                <div class="user-dropdown-menu" id="userDropdownMenu">--}}
                                {{--                                                    <div class="search-box">--}}
                                {{--                                                        <input type="text" placeholder="Search for a specific user">--}}
                                {{--                                                        <i class="fas fa-search search-icon"></i>--}}
                                {{--                                                    </div>--}}

                                {{--                                                    <div class="d-flex justify-content-end mb-2">--}}
                                {{--                                                        <button class="unassign-btn">Unassign</button>--}}
                                {{--                                                    </div>--}}

                                {{--                                                    <div class="user-list">--}}
                                {{--                                                        <div--}}
                                {{--                                                            class="user-item-row active-user d-flex align-items-center justify-content-between">--}}
                                {{--                                                            <div class="d-flex align-items-center">--}}
                                {{--                                                                <div class="avatar-sm me-2">--}}
                                {{--                                                                    <i class="fas fa-user-circle"></i>--}}
                                {{--                                                                    <span class="status-dot-sm away"></span>--}}
                                {{--                                                                </div>--}}
                                {{--                                                                <div>--}}
                                {{--                                                                    <p class="item-user-name mb-0">Hasnat Khan</p>--}}
                                {{--                                                                    <p class="item-user-status mb-0 away-text">Away</p>--}}
                                {{--                                                                </div>--}}
                                {{--                                                            </div>--}}
                                {{--                                                            <i class="fas fa-check check-icon"></i>--}}
                                {{--                                                        </div>--}}

                                {{--                                                    </div>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                            <h5 class="mb-3">Meeting Request</h5>--}}
                                {{--                                        </div>--}}

                                {{--                                        <div class="email-reply-wrapper">--}}
                                {{--                                            <div class="d-flex align-items-start email-reply-block">--}}
                                {{--                                                <i class="fas fa-user-circle  profile-icon me-4"></i>--}}
                                {{--                                                <div class="flex-grow-1">--}}
                                {{--                                                    <p class="email-from mb-0">--}}
                                {{--                                                        <b>Sarah Johnson</b>--}}
                                {{--                                                        <span class="text-muted small">7:45 PM</span>--}}
                                {{--                                                        <span class="ms-4 last-span text-bold">--}}
                                {{--                              Email--}}
                                {{--                              <i class="fas fa-caret-down ms-2 last-span-icon"></i>--}}
                                {{--                            </span>--}}
                                {{--                                                    </p>--}}
                                {{--                                                    <p class="mb-0 email-to text-muted small">--}}
                                {{--                                                        To: team@company.com--}}
                                {{--                                                    </p>--}}
                                {{--                                                    <p class="email-body mt-2">--}}
                                {{--                                                        I'd like to schedule a meeting to discuss the--}}
                                {{--                                                        upcoming project timeline. Are you available next--}}
                                {{--                                                        Tuesday at 2 PM?--}}
                                {{--                                                    </p>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                        <hr/>--}}
                                {{--                                        <div class="resizable-panel">--}}
                                {{--                                            <div class="resizable-content">--}}
                                {{--                                                <div--}}
                                {{--                                                    class="d-flex justify-content-start align-items-center mt-3 envelop-open-text-section">--}}
                                {{--                                                    <i class="fas fa-envelope-open-text me-1 icon-email-reply"></i>--}}
                                {{--                                                    <span class="email-comment-tabs email-decription">Email <i--}}
                                {{--                                                            class="fas fa-caret-down ms-1"></i></span>--}}
                                {{--                                                    <i class="fas fa-comment ms-4 me-2 icon-comment"></i>--}}
                                {{--                                                    <span class="email-comment-tabs comment-description">Comment</span>--}}
                                {{--                                                    <span class="ms-auto">--}}
                                {{--                            <i class="fa-solid fa-up-right-and-down-left-from-center enlarge-icon"></i>--}}
                                {{--                          </span>--}}
                                {{--                                                </div>--}}
                                {{--                                                <div--}}
                                {{--                                                    class="d-flex justify-content-between align-items-center text-muted mt-2 mb-2 email-area-choose-reciepeint">--}}
                                {{--                                                    <div--}}
                                {{--                                                        class="recipient-selection-container d-flex align-items-center flex-grow-1 me-3">--}}
                                {{--                                                        <i class="fas fa-reply" id="reply-icon"></i>--}}
                                {{--                                                        <div class="d-flex flex-wrap align-items-center flex-grow-1">--}}
                                {{--                                                            <input--}}
                                {{--                                                                class="email-area-input-for-recipeint ms-2 flex-grow-1 border-0"--}}
                                {{--                                                                placeholder="Enter or choose a recipient"--}}
                                {{--                                                                type="text"--}}
                                {{--                                                                autocomplete="off"/>--}}
                                {{--                                                        </div>--}}
                                {{--                                                    </div>--}}
                                {{--                                                    <i class="fas fa-ellipsis-v ms-3" id="more-options-icon"></i>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="form-control mt-2 email-compose-box">--}}
                                {{--                                            <div class="editor-wrapper">--}}
                                {{--                                                <div id="editorContent" class="text-muted text-placeholder"--}}
                                {{--                                                     contenteditable="true">--}}
                                {{--                                                    Write a message. Press '/' or highlight text to--}}
                                {{--                                                    access AI commands.--}}
                                {{--                                                </div>--}}
                                {{--                                                <div--}}
                                {{--                                                    class="editor-toolbar d-flex justify-content-between align-items-center">--}}
                                {{--                                                    <div class="d-flex align-items-center">--}}
                                {{--                                                        <i class="editor-icon fas fa-font me-3" data-bs-toggle="tooltip"--}}
                                {{--                                                           title="Change Font"></i>--}}
                                {{--                                                        <i class="editor-icon fas fa-smile me-3 text-primary"--}}
                                {{--                                                           data-bs-toggle="tooltip"--}}
                                {{--                                                           title="Insert Emoji"></i>--}}
                                {{--                                                        <div class="dropdown me-3">--}}
                                {{--                                                            <i class="editor-icon fas fa-link" role="button"--}}
                                {{--                                                               data-bs-toggle="dropdown"--}}
                                {{--                                                               aria-expanded="false"></i>--}}
                                {{--                                                            <ul class="dropdown-menu">--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Insert Link</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Remove Link</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                            </ul>--}}
                                {{--                                                        </div>--}}
                                {{--                                                        <div class="dropdown me-3">--}}
                                {{--                                                            <i class="editor-icon fas fa-image" role="button"--}}
                                {{--                                                               data-bs-toggle="dropdown"--}}
                                {{--                                                               aria-expanded="false"></i>--}}
                                {{--                                                            <ul class="dropdown-menu">--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Upload New--}}
                                {{--                                                                        Image</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Insert Existing--}}
                                {{--                                                                        Image</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                            </ul>--}}
                                {{--                                                        </div>--}}
                                {{--                                                        <div class="dropup me-3">--}}
                                {{--                                                            <i class="editor-icon fas fa-paperclip" role="button"--}}
                                {{--                                                               data-bs-toggle="dropdown"--}}
                                {{--                                                               aria-expanded="false"></i>--}}
                                {{--                                                            <ul class="dropdown-menu">--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Attach File</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Browse--}}
                                {{--                                                                        Documents</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                            </ul>--}}
                                {{--                                                        </div>--}}
                                {{--                                                        <div class="dropup me-3">--}}
                                {{--                                                            <button class="btn btn-secondary insert-btn" type="button"--}}
                                {{--                                                                    data-bs-toggle="dropdown"--}}
                                {{--                                                                    aria-expanded="false">--}}
                                {{--                                                                Insert--}}
                                {{--                                                            </button>--}}
                                {{--                                                            <ul class="dropdown-menu">--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Insert Invoice</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Insert--}}
                                {{--                                                                        Documents</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                                <li>--}}
                                {{--                                                                    <a class="dropdown-item" href="#">Insert Code</a>--}}
                                {{--                                                                </li>--}}
                                {{--                                                            </ul>--}}
                                {{--                                                        </div>--}}
                                {{--                                                    </div>--}}
                                {{--                                                    <button class="btn btn-primary send-btn">--}}
                                {{--                                                        Send--}}
                                {{--                                                    </button>--}}
                                {{--                                                </div>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                            </div>
                        </div>
                    </div>

                    <!-- Right Sidebar (col-md-3) -->
                    <div class="col-md-3 right-sidebar list-column">
                        <div class="main-content-col" id="right-sidebar">
                            <div class="tab-content" id="right-sidebar-content">
                                <!-- Right Sidebar for Email ID 1 -->
                                <div class="tab-pane fade show active" id="sidebar-detail-1" role="tabpanel"
                                     aria-labelledby="email-detail-1-tab">
                                    <div class="right-sidebar-header d-flex justify-content-between align-items-center">
                                        <div class="btn-group me-2" role="group">

                                            <button type="button"
                                                    class="custom-btn-right btn btn-tertiary-light d-flex align-items-center justify-content-center">
                                                <i class="fas fa-check-circle me-1" aria-hidden="true"></i>
                                                <span>Close conversation</span>
                                            </button>

                                            <button id="extraBtn1" type="button"
                                                    class="btn btn-tertiary-light d-none d-flex align-items-center justify-content-center">
                                                <i class="fas fa-trash me-1" aria-hidden="true"></i>
                                                <span>Trash</span>
                                            </button>
                                        </div>

                                        <div class="btn-group" role="group">
                                            <div class="dropdown custom-popup">
                                                <button type="button" class="btn btn-tertiary-light"
                                                        id="actionMenuButton1"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-start ms-2"
                                                    aria-labelledby="actionMenuButton1">
                                                    <li>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="fas fa-trash me-2 text-danger"></i>
                                                            Move to Trash</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="fas fa-ban me-2 text-warning"></i>
                                                            Block Sender</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="fas fa-exclamation-triangle me-2 text-secondary"></i>
                                                            Mark as Spam</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <button type="button" class="btn btn-tertiary-light info-circle-iconnn">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mt-3 mb-3 ms-2">
                                        <span class="profile-avatar-h me-3 right-sidebar-profile-avator">H</span>
                                        <div>
                                            <span
                                                class="main-area-email-para-right-sidebar">hasnat.khan@stellers.org</span><br/>
                                        </div>
                                    </div>
                                    <hr/>

                                    <div id="sortable-container-1">
                                        <!-- About Contact -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#about-contact-section-1" aria-expanded="false"
                                                 aria-controls="about-contact-section-1">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>About this Contact</span>
                                                <i class="fas fa-info-circle info-circle-icon ms-auto"></i>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="about-contact-section-1">
                                                <div class="contact-info-item">
                                                    <p class="info-label">Email</p>
                                                    <p class="info-value">hasnatkha@gmail.com</p>
                                                </div>
                                                <div class="contact-info-item">
                                                    <p class="info-label">Phone Number</p>
                                                    <p class="info-value">---</p>
                                                </div>
                                                <div class="contact-info-item">
                                                    <p class="info-label">Contact owner</p>
                                                    <p class="info-value">Moiz Athar</p>
                                                </div>
                                                <div class="contact-info-item">
                                                    <p class="info-label">Total revenue</p>
                                                    <p class="info-value">---</p>
                                                </div>
                                                <div class="contact-info-item">
                                                    <p class="info-label">Recent deal amount</p>
                                                    <p class="info-value">---</p>
                                                </div>
                                                <div class="contact-info-item">
                                                    <p class="info-label">
                                                        Date entered (Customer Lifecycle Stage)
                                                    </p>
                                                    <p class="info-value">---</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Companies -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#companies-section-1" aria-expanded="false"
                                                 aria-controls="companies-section-1">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Companies (1)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="companies-section-1">
                                                <div class="company-card">
                                                    <div class="company-header">
                                                        <span class="btn btn-sm btn-outline-primary">Primary</span>
                                                        <div>
                                                            <span class="btn btn-sm btn-dark">Preview</span>
                                                            <span
                                                                class="btn btn-sm btn-dark dropdown-toggle">More</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <span class="me-2 fw-bold">--</span>
                                                        <i class="fas fa-building fa-2x text-muted ms-auto"></i>
                                                    </div>
                                                    <p class="company-link">
                                                        <a href="http://pivotbookwriting.com" target="_blank">pivotbookwriting.com<i
                                                                class="fas fa-external-link-alt"></i></a>
                                                        <i class="fas fa-copy"></i>
                                                    </p>
                                                    <p>Phone: --</p>
                                                </div>
                                                <p class="view-commpany ms-3 mt-2">
                                                    View Associated Company
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Other Conversations -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#other-conversations-section-1" aria-expanded="false"
                                                 aria-controls="other-conversations-section-1">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Other Conversations (1)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content"
                                                 id="other-conversations-section-1">
                                                <div class="other-conversations-section">
                                                    <p>
                                                        <i class="fas fa-envelope"></i> Assigned to Moiz
                                                        Athar
                                                    </p>
                                                    <p>
                                                        <a href="http://pivotbookwriting.com" target="_blank">Test
                                                            <i class="fas fa-external-link-alt ms-2"></i></a>
                                                    </p>
                                                    <p>Latest message sent 8 hours ago</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Contacts -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#contacts-section-1" aria-expanded="false"
                                                 aria-controls="contacts-section-1">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Contacts (0)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="contacts-section-1">
                                                <div class="contacts-section">
                                                    <p>See the people associated with this record</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Subscriptions -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#subscriptions-section-1" aria-expanded="false"
                                                 aria-controls="subscriptions-section-1">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Subscriptions (0)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="subscriptions-section-1">
                                                <div class="contacts-section">
                                                    <p>
                                                        Automate subscription management and recurring
                                                        billing from this record
                                                    </p>
                                                    <div class="d-flex justify-content-center">
                                                        <button class="right-sec-payment-btn">
                                                            Set up Payment
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payments -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#payments-section-1" aria-expanded="false"
                                                 aria-controls="payments-section-1">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Payments (0)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="payments-section-1">
                                                <div class="contacts-section">
                                                    <p>
                                                        Track payments associated with this record. A
                                                        payment is created when a customer pays or
                                                        recurring payment is processed through HubSpot.
                                                    </p>
                                                    <div class="d-flex justify-content-center">
                                                        <button class="right-sec-payment-btn">
                                                            Set up Payment
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tickets -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#ticket-section-1" aria-expanded="false"
                                                 aria-controls="ticket-section-1">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Tickets (02)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="ticket-section-1"></div>
                                        </div>

                                        <!-- Deals -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#deals-section-1" aria-expanded="false"
                                                 aria-controls="deals-section-1">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Deals (04)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="deals-section-1"></div>
                                        </div>

                                        <!-- Other Tickets -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#other-ticket-section-1" aria-expanded="false"
                                                 aria-controls="other-ticket-section-1">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Other Tickets (04)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content"
                                                 id="other-ticket-section-1"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Sidebar for Email ID 2 -->
                                <div class="tab-pane fade" id="sidebar-detail-2" role="tabpanel"
                                     aria-labelledby="email-detail-2-tab">
                                    <div class="right-sidebar-header d-flex justify-content-between align-items-center">
                                        <div class="btn-group me-2" role="group">
                                            <button type="button" class="btn btn-tertiary-light">
                                                <i class="fas fa-check-circle me-1" aria-hidden="true"></i>
                                                <span>Close conversation</span>
                                            </button>
                                            <button id="extraBtn2" type="button" class="btn btn-secondary"
                                                    style="display: none">
                                                <i class="fas fa-trash me-1" aria-hidden="true"></i>
                                                <span>Trash</span>
                                            </button>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <div class="dropdown custom-popup">
                                                <button type="button" class="btn btn-tertiary-light"
                                                        id="actionMenuButton2"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-start ms-2"
                                                    aria-labelledby="actionMenuButton2">
                                                    <li>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="fas fa-trash me-2 text-danger"></i>
                                                            Move to Trash</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="fas fa-ban me-2 text-warning"></i>
                                                            Block Sender</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="fas fa-exclamation-triangle me-2 text-secondary"></i>
                                                            Mark as Spam</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <button type="button" class="btn btn-tertiary-light info-circle-iconnn">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mt-3 mb-3 ms-2">
                                        <span class="profile-avatar-h me-3 right-sidebar-profile-avator">M</span>
                                        <div>
                                            <span
                                                class="main-area-email-para-right-sidebar">moiz@saviours.co</span><br/>
                                        </div>
                                    </div>
                                    <hr/>

                                    <div id="sortable-container-2">
                                        <!-- About Contact -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#about-contact-section-2" aria-expanded="false"
                                                 aria-controls="about-contact-section-2">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>About this Contact</span>
                                                <i class="fas fa-info-circle info-circle-icon ms-auto"></i>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="about-contact-section-2">
                                                <div class="contact-info-item">
                                                    <p class="info-label">Email</p>
                                                    <p class="info-value">moiz@saviours.co</p>
                                                </div>
                                                <div class="contact-info-item">
                                                    <p class="info-label">Phone Number</p>
                                                    <p class="info-value">---</p>
                                                </div>
                                                <div class="contact-info-item">
                                                    <p class="info-label">Contact owner</p>
                                                    <p class="info-value">Moiz Athar</p>
                                                </div>
                                                <div class="contact-info-item">
                                                    <p class="info-label">Total revenue</p>
                                                    <p class="info-value">---</p>
                                                </div>
                                                <div class="contact-info-item">
                                                    <p class="info-label">Recent deal amount</p>
                                                    <p class="info-value">---</p>
                                                </div>
                                                <div class="contact-info-item">
                                                    <p class="info-label">
                                                        Date entered (Customer Lifecycle Stage)
                                                    </p>
                                                    <p class="info-value">---</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Companies -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#companies-section-2" aria-expanded="false"
                                                 aria-controls="companies-section-2">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Companies (1)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="companies-section-2">
                                                <div class="company-card">
                                                    <div class="company-header">
                                                        <span class="btn btn-sm btn-outline-primary">Primary</span>
                                                        <div>
                                                            <span class="btn btn-sm btn-dark">Preview</span>
                                                            <span
                                                                class="btn btn-sm btn-dark dropdown-toggle">More</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <span class="me-2 fw-bold">--</span>
                                                        <i class="fas fa-building fa-2x text-muted ms-auto"></i>
                                                    </div>
                                                    <p class="company-link">
                                                        <a href="http://pivotbookwriting.com" target="_blank">pivotbookwriting.com<i
                                                                class="fas fa-external-link-alt"></i></a>
                                                        <i class="fas fa-copy"></i>
                                                    </p>
                                                    <p>Phone: --</p>
                                                </div>
                                                <p class="view-commpany ms-3 mt-2">
                                                    View Associated Company
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Other Conversations -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#other-conversations-section-2" aria-expanded="false"
                                                 aria-controls="other-conversations-section-2">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Other Conversations (1)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content"
                                                 id="other-conversations-section-2">
                                                <div class="other-conversations-section">
                                                    <p>
                                                        <i class="fas fa-envelope"></i> Assigned to Moiz
                                                        Athar
                                                    </p>
                                                    <p>
                                                        <a href="http://pivotbookwriting.com" target="_blank">Test
                                                            <i class="fas fa-external-link-alt ms-2"></i></a>
                                                    </p>
                                                    <p>Latest message sent 8 hours ago</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Contacts -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#contacts-section-2" aria-expanded="false"
                                                 aria-controls="contacts-section-2">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Contacts (0)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="contacts-section-2">
                                                <div class="contacts-section">
                                                    <p>See the people associated with this record</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Subscriptions -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#subscriptions-section-2" aria-expanded="false"
                                                 aria-controls="subscriptions-section-2">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Subscriptions (0)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="subscriptions-section-2">
                                                <div class="contacts-section">
                                                    <p>
                                                        Automate subscription management and recurring
                                                        billing from this record
                                                    </p>
                                                    <div class="d-flex justify-content-center">
                                                        <button class="right-sec-payment-btn">
                                                            Set up Payment
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payments -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#payments-section-2" aria-expanded="false"
                                                 aria-controls="payments-section-2">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Payments (0)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="payments-section-2">
                                                <div class="contacts-section">
                                                    <p>
                                                        Track payments associated with this record. A
                                                        payment is created when a customer pays or
                                                        recurring payment is processed through HubSpot.
                                                    </p>
                                                    <div class="d-flex justify-content-center">
                                                        <button class="right-sec-payment-btn">
                                                            Set up Payment
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tickets -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#ticket-section-2" aria-expanded="false"
                                                 aria-controls="ticket-section-2">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Tickets (02)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="ticket-section-2"></div>
                                        </div>

                                        <!-- Deals -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#deals-section-2" aria-expanded="false"
                                                 aria-controls="deals-section-2">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Deals (04)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="deals-section-2"></div>
                                        </div>

                                        <!-- Other Tickets -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#other-ticket-section-2" aria-expanded="false"
                                                 aria-controls="other-ticket-section-2">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Other Tickets (04)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content"
                                                 id="other-ticket-section-2"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Sidebar for Email ID 3 -->
                                <div class="tab-pane fade" id="sidebar-detail-3" role="tabpanel"
                                     aria-labelledby="email-detail-3-tab">
                                    <div class="right-sidebar-header d-flex justify-content-between align-items-center">
                                        <div class="btn-group me-2" role="group">
                                            <button type="button" class="btn btn-tertiary-light">
                                                <i class="fas fa-check-circle me-1" aria-hidden="true"></i>
                                                <span>Close conversation</span>
                                            </button>
                                            <button id="extraBtn3" type="button" class="btn btn-secondary"
                                                    style="display: none">
                                                <i class="fas fa-trash me-1" aria-hidden="true"></i>
                                                <span>Trash</span>
                                            </button>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <div class="dropdown custom-popup">
                                                <button type="button" class="btn btn-tertiary-light"
                                                        id="actionMenuButton3"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-start ms-2"
                                                    aria-labelledby="actionMenuButton3">
                                                    <li>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="fas fa-trash me-2 text-danger"></i>
                                                            Move to Trash</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="fas fa-ban me-2 text-warning"></i>
                                                            Block Sender</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="fas fa-exclamation-triangle me-2 text-secondary"></i>
                                                            Mark as Spam</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <button type="button" class="btn btn-tertiary-light info-circle-iconnn">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mt-3 mb-3 ms-2">
                                        <span class="profile-avatar-h me-3 right-sidebar-profile-avator">A</span>
                                        <div>
                                            <span
                                                class="main-area-email-para-right-sidebar">ashter@example.com</span><br/>
                                        </div>
                                    </div>
                                    <hr/>

                                    <div id="sortable-container-3">
                                        <!-- About Contact -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#about-contact-section-3" aria-expanded="false"
                                                 aria-controls="about-contact-section-3">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>About this Contact</span>
                                                <i class="fas fa-info-circle info-circle-icon ms-auto"></i>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="about-contact-section-3">
                                                <div class="contact-info-item">
                                                    <p class="info-label">Email</p>
                                                    <p class="info-value">ashter@example.com</p>
                                                </div>
                                                <div class="contact-info-item">
                                                    <p class="info-label">Phone Number</p>
                                                    <p class="info-value">---</p>
                                                </div>
                                                <div class="contact-info-item">
                                                    <p class="info-label">Contact owner</p>
                                                    <p class="info-value">Moiz Athar</p>
                                                </div>
                                                <div class="contact-info-item">
                                                    <p class="info-label">Total revenue</p>
                                                    <p class="info-value">---</p>
                                                </div>
                                                <div class="contact-info-item">
                                                    <p class="info-label">Recent deal amount</p>
                                                    <p class="info-value">---</p>
                                                </div>
                                                <div class="contact-info-item">
                                                    <p class="info-label">
                                                        Date entered (Customer Lifecycle Stage)
                                                    </p>
                                                    <p class="info-value">---</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Companies -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#companies-section-3" aria-expanded="false"
                                                 aria-controls="companies-section-3">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Companies (1)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="companies-section-3">
                                                <div class="company-card">
                                                    <div class="company-header">
                                                        <span class="btn btn-sm btn-outline-primary">Primary</span>
                                                        <div>
                                                            <span class="btn btn-sm btn-dark">Preview</span>
                                                            <span
                                                                class="btn btn-sm btn-dark dropdown-toggle">More</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <span class="me-2 fw-bold">--</span>
                                                        <i class="fas fa-building fa-2x text-muted ms-auto"></i>
                                                    </div>
                                                    <p class="company-link">
                                                        <a href="http://pivotbookwriting.com" target="_blank">pivotbookwriting.com<i
                                                                class="fas fa-external-link-alt"></i></a>
                                                        <i class="fas fa-copy"></i>
                                                    </p>
                                                    <p>Phone: --</p>
                                                </div>
                                                <p class="view-commpany ms-3 mt-2">
                                                    View Associated Company
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Other Conversations -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#other-conversations-section-3" aria-expanded="false"
                                                 aria-controls="other-conversations-section-3">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Other Conversations (1)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content"
                                                 id="other-conversations-section-3">
                                                <div class="other-conversations-section">
                                                    <p>
                                                        <i class="fas fa-envelope"></i> Assigned to Moiz
                                                        Athar
                                                    </p>
                                                    <p>
                                                        <a href="http://pivotbookwriting.com" target="_blank">Test
                                                            <i class="fas fa-external-link-alt ms-2"></i></a>
                                                    </p>
                                                    <p>Latest message sent 8 hours ago</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Contacts -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#contacts-section-3" aria-expanded="false"
                                                 aria-controls="contacts-section-3">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Contacts (0)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="contacts-section-3">
                                                <div class="contacts-section">
                                                    <p>See the people associated with this record</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Subscriptions -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#subscriptions-section-3" aria-expanded="false"
                                                 aria-controls="subscriptions-section-3">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Subscriptions (0)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="subscriptions-section-3">
                                                <div class="contacts-section">
                                                    <p>
                                                        Automate subscription management and recurring
                                                        billing from this record
                                                    </p>
                                                    <div class="d-flex justify-content-center">
                                                        <button class="right-sec-payment-btn">
                                                            Set up Payment
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payments -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#payments-section-3" aria-expanded="false"
                                                 aria-controls="payments-section-3">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Payments (0)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="payments-section-3">
                                                <div class="contacts-section">
                                                    <p>
                                                        Track payments associated with this record. A
                                                        payment is created when a customer pays or
                                                        recurring payment is processed through HubSpot.
                                                    </p>
                                                    <div class="d-flex justify-content-center">
                                                        <button class="right-sec-payment-btn">
                                                            Set up Payment
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tickets -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#ticket-section-3" aria-expanded="false"
                                                 aria-controls="ticket-section-3">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Tickets (02)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="ticket-section-3"></div>
                                        </div>

                                        <!-- Deals -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#deals-section-3" aria-expanded="false"
                                                 aria-controls="deals-section-3">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Deals (04)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content" id="deals-section-3"></div>
                                        </div>

                                        <!-- Other Tickets -->
                                        <div class="sortable-item">
                                            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                                                 data-bs-target="#other-ticket-section-3" aria-expanded="false"
                                                 aria-controls="other-ticket-section-3">
                                                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                                                <i class="fas fa-angle-right custom-toggle-icon"></i>
                                                <span>Other Tickets (04)</span>
                                            </div>
                                            <div class="collapse custom-sidebar-content"
                                                 id="other-ticket-section-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Page 1 End -->

                    <!-- Page 2 Start -->

                    <!-- Hidden Filter Panel (col-md-2) -->
                    <div class="col-md-2 d-none" id="filterPanel">
                        <div class="filter-content">
                            <!-- fixed top -->
                            <a href="#" id="exitSearch" class="exit-search">
                                <i class="fas fa-chevron-left"></i> Exit search
                            </a>

                            <div
                                class="custom-header-text-search d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Filter by:</h6>
                                <a href="#" id="clearFilters" class="small custom-clear">Clear all</a>
                            </div>

                            <!-- scrollable section -->
                            <div class="filter-scrollable">
                                <div class="filter-group">
                                    <label class="filter-label">Status</label>
                                    <select class="form-select custom-status-select">
                                        <option selected>Select a status</option>
                                        <option>Open</option>
                                        <option>Closed</option>
                                    </select>
                                </div>

                                <div class="filter-group">
                                    <label class="filter-label">Channel</label>
                                    <select class="form-select custom-status-select">
                                        <option class="cstm-opt">Select a channel</option>
                                        <option class="cstm-opt">Email</option>
                                        <option class="cstm-opt">Chat</option>
                                    </select>
                                </div>

                                <div class="filter-group">
                                    <label class="filter-label">Channel Account</label>
                                    <select class="form-select custom-status-select">
                                        <option selected>Select a channel account</option>
                                    </select>
                                </div>

                                <div class="filter-group">
                                    <label class="filter-label">Contact</label>
                                    <select class="form-select custom-status-select">
                                        <option selected>Select a contact</option>
                                    </select>
                                </div>

                                <div class="filter-group">
                                    <label class="filter-label">Assignee</label>
                                    <select class="form-select custom-status-select">
                                        <option selected>Select an assignee</option>
                                    </select>
                                </div>

                                <div class="filter-group d-block">
                                    <label class="filter-label">Date</label>
                                    <div class="gap-2">
                                        <input id="dateRange" class="form-control " placeholder="Select date range"/>
                                    </div>
                                </div>

                                <div class="filter-group mt-3">
                                    <small class="d-block mb-2">More options</small>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input custom-form-check" type="checkbox"
                                               id="hideFiltered" checked/>
                                        <label class="form-check-label" for="hideFiltered">Hide filtered</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="hideTrash" checked/>
                                        <label class="form-check-label" for="hideTrash">Hide trash</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Merged col-md-10 (search results + empty state) -->
                    <div class="col-md-10 d-none" id="mergedContent">
                        <div class="search-top">
                            <div style="flex: 1" class="pe-2">
                                <div class="search-bar d-flex align-items-center">
                                    <input class="search-input" type="text" placeholder="Search Inbox"
                                           id="searchInput"/>
                                    <i class="fas fa-search ms-2"></i>
                                </div>
                            </div>
                            <div style="width: 160px" class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-light dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Newest
                                    </button>
                                    <ul class="dropdown-menu cust-hide-search" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#">Newest </a></li>
                                        <li><a class="dropdown-item" href="#">Oldest</a></li>

                                    </ul>
                                </div>

                            </div>
                        </div>

                        <div class="d-flex">
                            <!-- small left column inside merged view (acts like list area) -->
                            <div style="
                  width: 320px;
                  border-right:2px solid #eef5f8;
                  min-height: 600px;
                  padding: 12px;
                  height: 100vh;
                ">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox"/>
                                </div>
                                <div class="text-muted small">Newest</div>
                                <div class="mt-4 small text-muted">
                                    Search or filter to view results
                                </div>
                            </div>

                            <!-- big empty state -->
                            <div style="flex: 1; padding: 60px">
                                <div class="result-empty">
                                    <!-- using svg-like icon (simple) -->
                                    <img src="{{asset ('assets/images/empty-state-charts.png')}}">


                                    <div style="height: 18px"></div>
                                    <div style="font-weight: 600; color: #6f98a8; margin-bottom: 8px">
                                        Search for anything in Inbox by typing in a term or applying
                                        filters
                                    </div>
                                    <div class="text-muted small">
                                        Try typing something in the search bar or adjusting the
                                        filters on the left.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Page 2 End -->
                </div>
            </section>
        </div>
    </section>

    <!-- Ashter Working HTML start End -->

    @push('script')

        <script>
            // Ensure right sidebar updates with email selection
            document.querySelectorAll(".email-main-body").forEach((item) => {
                item.addEventListener("click", function (e) {
                    e.preventDefault();
                    // Remove active class from all email items
                    document.querySelectorAll(".email-main-body").forEach((el) => el.classList.remove("active"));
                    // Add active class to clicked item
                    this.classList.add("active");
                    // Get the target email detail and sidebar panes
                    const emailTarget = this.getAttribute("data-bs-target");
                    const sidebarTarget = this.getAttribute("data-sidebar-target");

                    // Activate email detail pane
                    document.querySelectorAll("#email-detail-content .tab-pane").forEach((pane) => pane.classList.remove("show", "active"));
                    document.querySelector(emailTarget).classList.add("show", "active");
                    // Activate sidebar pane
                    document.querySelectorAll("#right-sidebar-content .tab-pane").forEach((pane) => pane.classList.remove("show", "active"));
                    document.querySelector(sidebarTarget).classList.add("show", "active");
                });
            });

            // Initialize Bootstrap tooltips
            const tooltipTriggerList = document.querySelectorAll(
                '[data-bs-toggle="tooltip"]'
            );
            const tooltipList = [...tooltipTriggerList].map(
                (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
            );
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                // Select all sortable containers
                const containers = document.querySelectorAll(
                    "#sortable-container-1, #sortable-container-3, #sortable-container-2"
                );
                containers.forEach((container) => {
                    new Sortable(container, {
                        handle: ".drag-handle-icon",
                        animation: 150,
                        ghostClass: "sortable-ghost",
                        chosenClass: "sortable-chosen",
                        dragClass: "sortable-drag",
                        onEnd: () => {
                            console.log("Sort order updated");
                        },
                    });
                });
            });
            $(document).on('click', '.hover-checkbox', function (e) {
                e.stopPropagation();
                const isChecked = $(this).is(':checked');
                const $listItem = $(this).closest('.list-group-item');
                const $icon = $listItem.find('.fa-envelope');
                const $defaultActions = $('#default-actions');
                const $selectedActions = $('#selected-actions');
                const $emailIcon = $('#email-icon');
                const $emailHeader = $('#email-header');
                const $upperText = $('.upper-text');

                const checkedCount = $('.hover-checkbox:checked').length;
                const anyChecked = checkedCount > 0;

                if (anyChecked) {
                    $defaultActions.addClass('d-none');
                    $selectedActions.removeClass('d-none');
                    $upperText.addClass('d-none');
                    $emailIcon.removeClass('fa-regular fa-envelope active-enelops');
                    $emailIcon.addClass('fa-solid fa-square-check selected-enelop');
                    $emailHeader.addClass('d-none');

                    $('#selected-count').text(checkedCount);
                } else {
                    $defaultActions.removeClass('d-none');
                    $selectedActions.addClass('d-none');
                    $upperText.removeClass('d-none');
                    $emailIcon.removeClass('fa-solid fa-square-check selected-enelop');
                    $emailIcon.addClass('fa-regular fa-envelope active-enelops');
                    $emailHeader.removeClass('d-none');
                }

                if (isChecked) {
                    $icon.removeClass('fa-regular active-enelops');
                    $icon.addClass('fa-solid fa-square-check selected-enelop');
                } else {
                    $icon.removeClass('fa-solid fa-square-check selected-enelop');
                    $icon.addClass('fa-regular active-enelops');
                }
            });

            $(document).on('change', '.select-all-checkbox', function () {
                const isChecked = $(this).is(':checked');
                $('.hover-checkbox').prop('checked', isChecked).trigger('change');
                trashBtn.classList.toggle("d-none", !isChecked);
            });
            // for email-open
            $(function () {
                // Open search: hide left sidebar and show filter + merged content
                $("#openSearch").on("click", function (e) {
                    e.preventDefault();

                    // if already open, do nothing (guard)
                    if (!$("#filterPanel").hasClass("d-none")) return;

                    // hide default left sidebar
                    $("#leftSidebar").addClass("d-none");

                    // hide original 3+4+3 columns
                    $(
                        ".uppper-part-main, .main-email-area-section, .right-sidebar"
                    ).addClass("d-none");

                    // show filter panel and merged content
                    $("#filterPanel").removeClass("d-none");
                    $("#mergedContent").removeClass("d-none");

                    // optional: focus search input
                    setTimeout(function () {
                        $("#searchInput").focus();
                    }, 100);
                });

                // Exit search: restore original layout
                $("#exitSearch").on("click", function (e) {
                    e.preventDefault();
                    restoreLayout();
                });

                // Pressing ESC inside search input will also exit search
                $(document).on("keyup", function (e) {
                    if (e.key === "Escape") {
                        if (!$("#filterPanel").hasClass("d-none")) {
                            restoreLayout();
                        }
                    }
                });

                // Clear filters - just a small handler (reset selects/inputs)
                $("#clearFilters").on("click", function (e) {
                    e.preventDefault();
                    $("#filterPanel select").prop("selectedIndex", 0);
                    $("#filterPanel input[type=date]").val("");
                    $("#filterPanel input[type=checkbox]").prop("checked", false);
                });

                function restoreLayout() {
                    // hide filter panel + merged
                    $("#filterPanel").addClass("d-none");
                    $("#mergedContent").addClass("d-none");

                    // show original left sidebar + columns
                    $("#leftSidebar").removeClass("d-none");
                    $(
                        ".uppper-part-main, .main-email-area_section, .main-email-area-section, .right-sidebar"
                    ).removeClass("d-none");

                    // small fix: ensure our 3 columns are visible (they might have combined classes)
                    $(".uppper-part-main").removeClass("d-none");
                    $(".main-email-area-section").removeClass("d-none");
                    $(".right-sidebar").removeClass("d-none");
                }
            });

            $(document).ready(function () {
                $("#actionsBtn").on("click", function (e) {
                    e.stopPropagation();
                    $("#actionsMenu").toggle();
                });

                // Hide menu when clicking outside
                $(document).on("click", function (e) {
                    if (!$(e.target).closest("#actionsBtn").length) {
                        $("#actionsMenu").hide();
                    }
                });
            });
            // Show loader
            $("#loader").addClass("show");

            // Hide loader after page loads
            $(window).on("load", function () {
                $("#loader").removeClass("show");
            });
        </script>
        // for date picker
        <script>
            flatpickr("#dateRange", {
                mode: "range", // allows From → To
                dateFormat: "Y-m-d", // backend format
                altInput: true, // prettier format for users
                altFormat: "F j, Y", // e.g. July 16, 2025
                showMonths: 1 // can set to 2 if you want two months side-by-side
            });
        </script>

        // this is for the popup
        <script>
            // Simple JavaScript to toggle the dropdown menu
            document.addEventListener('DOMContentLoaded', function () {
                const toggle = document.getElementById('userDropdownToggle');
                const menu = document.getElementById('userDropdownMenu');

                if (toggle && menu) {
                    toggle.addEventListener('click', function (event) {
                        // Toggle the 'show' class to display/hide the menu
                        menu.classList.toggle('show');
                        event.stopPropagation();
                    });

                    // Close the menu when clicking outside
                    document.addEventListener('click', function (event) {
                        if (menu.classList.contains('show') && !menu.contains(event.target) && !toggle.contains(event.target)) {
                            menu.classList.remove('show');
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
