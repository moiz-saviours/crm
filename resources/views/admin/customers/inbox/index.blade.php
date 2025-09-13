@extends('admin.layouts.app')
@section('title', 'Customer Inbox')
@section('content')
    @push('style')
        @include('admin.customers.inbox.style')
    @endpush
    <!-- Ashter Working HTML start -->
    <section id="content" class="content custome-email-body">
        <div class="container-fluid p-0 ">
            <div class="row g-0">
                <div class="col-md-2 bg-white left-sidebar d-flex flex-column">
                    <div class="head-icons mb-3">
                        <div class="icon-side">
                            <i class="fas fa-angle-double-left"></i> <span>Inbox</span>
                        </div>
                        <div class="search-side">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                    <div class="main-heading mb-2">
                        <i class="fa fa-circle me-1"></i> You're available
                        <i class="fa fa-caret-down ms-1"></i>
                    </div>
                    <hr class="border-bottom-dark my-2"/>

                    <div class="list-group flex-grow-1" id="inbox-tabs" role="tablist">
                        <a
                            href="#unassigned-pane"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center active"
                            id="unassigned-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#unassigned-pane"
                            role="tab"
                            aria-controls="unassigned-pane"
                            aria-selected="true"
                        >
                            Unassigned
                            <span class="badge rounded-pill text-bg-light">4</span>
                        </a>
                        <a
                            href="#assigned-pane"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                            id="assigned-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#assigned-pane"
                            role="tab"
                            aria-controls="assigned-pane"
                            aria-selected="false"
                        >
                            Assigned to me
                            <span class="badge rounded-pill text-bg-light">0</span>
                        </a>
                        <a
                            href="#all-open-pane"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                            id="all-open-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#all-open-pane"
                            role="tab"
                            aria-controls="all-open-pane"
                            aria-selected="false"
                        >
                            All open
                            <span class="badge rounded-pill text-bg-light">4</span>
                        </a>

                        <a
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center text-dark less-link"
                            data-bs-toggle="collapse"
                            href="#less-content"
                            role="button"
                            aria-expanded="false"
                            aria-controls="less-content"
                        >
                            <i class="fa fa-caret-down less-icon me-2"></i> Less
                        </a>
                        <div class="collapse" id="less-content">
                            <a
                                href="#email-pane"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                id="email-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#email-pane"
                                role="tab"
                                aria-controls="email-pane"
                                aria-selected="false"
                            >
                                Email
                                <span class="badge rounded-pill text-bg-light">4</span>
                            </a>
                            <a
                                href="#calls-pane"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                id="calls-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#calls-pane"
                                role="tab"
                                aria-controls="calls-pane"
                                aria-selected="false"
                            >
                                Calls
                                <span class="badge rounded-pill text-bg-light">0</span>
                            </a>
                        </div>

                        <a
                            href="#all-closed-pane"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                            id="all-closed-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#all-closed-pane"
                            role="tab"
                            aria-controls="all-closed-pane"
                            aria-selected="false"
                        >
                            All Closed
                            <span class="badge rounded-pill text-bg-light">0</span>
                        </a>
                        <a
                            href="#sent-pane"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                            id="sent-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#sent-pane"
                            role="tab"
                            aria-controls="sent-pane"
                            aria-selected="false"
                        >
                            Sent <span class="badge rounded-pill text-bg-light">0</span>
                        </a>
                        <a
                            href="#spam-pane"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                            id="spam-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#spam-pane"
                            role="tab"
                            aria-controls="spam-pane"
                            aria-selected="false"
                        >
                            Spam <span class="badge rounded-pill text-bg-light">0</span>
                        </a>
                        <a
                            href="#trash-pane"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center mb-5"
                            id="trash-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#trash-pane"
                            role="tab"
                            aria-controls="trash-pane"
                            aria-selected="false"
                        >
                            Trash <span class="badge rounded-pill text-bg-light">0</span>
                        </a>
                    </div>

                    <hr class="my-2"/>
                    <div class="d-flex justify-content-center email-body-bottom-button">
                        <button class="button-one me-2">
                            Actions <i class="fa fa-caret-down ms-2"></i>
                        </button>
                        <button class="button-two">Compose</button>
                    </div>
                    <div class="w-100 text-center text-muted" style="font-size: 0.8rem">
                        <i class="fa fa-gear me-1"></i> Inbox Settings
                    </div>
                </div>

                <div class="col-md-3 uppper-part-main">
                    <div
                        class="d-flex justify-content-between align-items-center p-3 uppper-part"
                    >
                        <div id="action-container" class="d-flex align-items-center">
                            <label class="custom-checkbox me-2">
                                <input type="checkbox" id="main-checkbox"/>
                                <span class="check-icon"></span>
                            </label>

                            <div id="default-actions">
                                <button class="open-btn ms-2">Open</button>
                                <button class="close-btn me-2">Closed</button>
                            </div>

                            <div
                                id="selected-actions"
                                class="d-none d-flex align-items-center"
                            >
                                <span class="me-3">1 selected</span>
                                <div class="btn-group" role="group"></div>
                            </div>
                        </div>
                        <div class="upper-text">
                            Newest <i class="fa fa-caret-down"></i>
                        </div>
                    </div>

                    <div class="tab-content" id="inbox-tab-content">
                        <div
                            class="tab-pane fade show active"
                            id="unassigned-pane"
                            role="tabpanel"
                            aria-labelledby="unassigned-tab"
                        >
                            <div class="emails-wrapper">
                                <div class="email-main-body active-email">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                                <div class="email-main-body">
                                    <div class="d-flex align-items-center">
                                        <i
                                            id="email-icon"
                                            class="fa fa-envelope active-enelops me-3"
                                        ></i>
                                        <div class="email-contents flex-grow-1">
                                            <p class="mb-0 email-address">
                                                hasnat.khan@stellers.org
                                            </p>
                                            <p class="mb-0 email-subject">Re: Test</p>
                                            <p class="small-para mb-0 text-muted">
                                                <i class="fa fa-reply me-2"></i> test email
                                            </p>
                                        </div>
                                        <p class="para-second mb-0">11s</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="tab-pane fade"
                            id="assigned-pane"
                            role="tabpanel"
                            aria-labelledby="assigned-tab"
                        >
                            <div class="emails-wrapper">
                                <p class="text-center p-4 text-muted">
                                    No assigned emails found.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 main-email-area-section" id="main-email-area">
                    <div
                        id="email-header"
                        class="d-flex justify-content-between align-items-center py-2 px-3 border-bottom"
                    >
                        <div class="d-flex align-items-center">
                            <span class="profile-avatar-h me-3">H</span>
                            <div>
                  <span class="main-area-email-para"
                  >hasnat.khan@stellers.org</span
                  ><br/>
                                <span class="main-area-email-para-time"
                                >Created 3 hours ago</span
                                >
                            </div>
                        </div>
                        <div></div>
                    </div>
                    <div class="p-3">
                        <div
                            class="d-flex justify-content-between align-items-center mb-3"
                        >
                            <span class="profile-description">Owner</span>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <i class="fa fa-user-circle profile-icon me-2"></i>
                            <div class="flex-grow-1">
                                <p class="user_name mb-0">
                                    Moiz Athar <i class="fa fa-caret-down ms-2"></i>
                                </p>
                                <p class="mb-0 text-muted email-info-text">
                                    To: hasnat.khan@stellers.org
                                </p>
                            </div>
                            <h5 class="mb-3">Re: Test</h5>
                        </div>
                        <p class="email-divider">...</p>
                        <div class="d-flex align-items-start email-reply-block">
                            <i
                                class="fa fa-user-circle profile-icon profile-avatar-m me-3"
                            ></i>
                            <div class="flex-grow-1">
                                <p class="email-from mb-0">
                                    <b>Moiz Athar</b>
                                    <span class="text-muted small">8:19 PM</span>
                                    <span class="ms-4 last-span text-bold"
                                    >Email
                      <i class="fa fa-caret-down ms-2 last-span-icon"></i>
                    </span>
                                </p>
                                <p class="mb-0 email-to text-muted small">
                                    To: hasnat.khan@stellers.org
                                </p>
                                <p class="email-body mt-2">
                                    On Tue, Sep 9, 2025 at 8:19 AM, Moiz Athar from Aims 2 user
                                    alow
                                    <a class="email-reply-address" href="#">moiz@saviours.co</a>
                                    wrote:<br/>
                                    Test
                                </p>
                            </div>
                        </div>
                        <hr/>
                        <div
                            class="d-flex justify-content-start align-items-center mt-3 envelop-open-text-section"
                        >
                            <i
                                class="fa fa-envelope-open-text me-1 icon-email-reply"
                            ></i>
                            <span class="email-comment-tabs email-decription"
                            >Email <i class="fa fa-caret-down ms-1"></i
                                ></span>
                            <i class="fa fa-comment ms-4 me-2 icon-comment"></i>
                            <span class="email-comment-tabs comment-description"
                            >Comment</span
                            >
                            <span class="ms-auto">
                  <i
                      class="fa fa-up-right-and-down-left-from-center enlarge-icon"
                  ></i>
                </span>
                        </div>
                        <div
                            class="d-flex justify-content-between email-area-choose-reciepeint align-items-center text-muted mt-2 mb-2"
                        >
                            <div>
                                <i class="fa fa-reply"></i>
                                <input
                                    class="email-area-input-for-recipeint ms-2"
                                    placeholder="Enter or chooose a recipient"
                                    type="text"
                                />
                            </div>
                            <i class="fa fa-ellipsis-v me-5"></i>
                        </div>
                        <div class="form-control mt-2 email-compose-box">
                            <div class="text-muted text-placeholder" contenteditable="true">
                                Write a message. Press '/' or highlight text to access AI
                                commands.
                            </div>
                            <div
                                class="editor-toolbar d-flex justify-content-between align-items-center mt-3"
                            >
                                <div class="d-flex align-items-center">
                                    <i class="editor-icon fas fa-font me-3"></i>
                                    <i class="editor-icon fas fa-smile me-3"></i>
                                    <i class="editor-icon fas fa-link me-3"></i>
                                    <i class="editor-icon fas fa-image me-3"></i>
                                    <i class="editor-icon fas fa-paperclip me-3"></i>
                                    <div class="dropdown me-3">
                                        <button
                                            class="btn btn-secondary dropdown-toggle insert-btn"
                                            type="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            Insert
                                        </button>
                                    </div>
                                </div>
                                <button
                                    class="btn btn-secondary dropdown-toggle send-btn"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    Send
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 right-sidebar">
                    <div
                        class="right-sidebar-header d-flex justify-content-between align-items-center p-3"
                    >
                        <div class="btn-group me-2" role="group">
                            <button type="button" class="btn btn-tertiary-light">
                                <i class="fa fa-check-circle me-1"></i>
                                <span>Close conversation</span>
                            </button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-tertiary-light">
                                <i class="fa fa-ellipsis-h"></i>
                            </button>
                            <button
                                type="button"
                                class="btn btn-tertiary-light info-circle-iconnn"
                            >
                                <i class="fa fa-info-circle"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-3">
                        <div class="contact-info-item">
                            <p class="info-label">Email</p>
                            <p class="info-value">hasnat.khan@stellers.org</p>
                        </div>
                        <div class="contact-info-item">
                            <p class="info-label">Phone number</p>
                            <p class="info-value">---</p>
                        </div>
                        <div class="contact-info-item">
                            <p class="info-label">Company name</p>
                            <p class="info-value">---</p>
                        </div>
                        <hr/>
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
            </div>
        </div>
    </section>

    <!-- Ashter Working HTML start End -->

    @push('script')

        <!-- Ashter working script start -->
        <!-- cke editor  -->
        <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
        <script>
            ClassicEditor.create(document.querySelector("#editor")).catch((error) => {
                console.error(error);
            });
        </script>
        <script>
            document
                .getElementById("main-checkbox")
                .addEventListener("change", function () {
                    const isChecked = this.checked;
                    const defaultActions = document.getElementById("default-actions");
                    const selectedActions = document.getElementById("selected-actions");
                    const emailIcon = document.getElementById("email-icon");
                    const emailHeader = document.getElementById("email-header");

                    if (isChecked) {
                        defaultActions.classList.add("d-none");
                        selectedActions.classList.remove("d-none");
                        emailIcon.classList.remove(
                            "fa-regular",
                            "fa-envelope",
                            "active-enelops"
                        );
                        emailIcon.classList.add(
                            "fa",
                            "fa-square-check",
                            "selected-enelop"
                        );
                        emailHeader.classList.add("d-none");
                    } else {
                        defaultActions.classList.remove("d-none");
                        selectedActions.classList.add("d-none");
                        emailIcon.classList.remove(
                            "fa",
                            "fa-square-check",
                            "selected-enelop"
                        );
                        emailIcon.classList.add(
                            "fa-regular",
                            "fa-envelope",
                            "active-enelops"
                        );
                        emailHeader.classList.remove("d-none");
                    }
                });
        </script>
        <!-- Ashter working script start End  -->
    @endpush
@endsection
