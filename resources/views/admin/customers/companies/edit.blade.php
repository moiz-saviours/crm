@extends('admin.layouts.app')
@section('title','Customer CustomerCompany / Edit')
@section('content')
    @push('style')
        @include('admin.customers.companies.style')
    @endpush
    <section id="content" class="content">
        <!-- ab content -->
        <style>
            /*body {*/
            /*    font-family: Arial, sans-serif;*/
            /*    margin: 0;*/
            /*    padding: 0;*/
            /*    display: flex;*/
            /*    height: 100vh;*/
            /*}*/

            .containerr {
                display: flex;
                width: 100%;
                height: 100%;
                padding: 0px;
                margin: 0px;
            }

            .sidebarr {
                width: auto;
                background-color: #f0f4f8;
                padding: 20px 20px;
                box-sizing: border-box;
                border-right: 1px solid #ddd;
                overflow-y: auto;
            }

            .profile {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .avatar {
                width: 80px;
                height: 80px;
                background-color: #ccc;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                margin-bottom: 20px;
            }

            .contact-info {
                text-align: center;
                margin-left: 8px;
            }

            .contact-info h2 {
                margin: 0;
                font-size: 20px;
                text-align: left;
                font-weight: 600;
                color: #2d3e50;
                margin-bottom: -3px;
            }

            .contact-info p {
                margin: 5px 0;
                font-size: 13px;
                color: gray;
            }

            .profile_actions p {
                font-size: 12px;
                margin: 0px 8px;
                color: gray;
            }

            .profile_actions p i {
                background: #e3dede;
                padding: 8px;
                border-radius: 20px;
            }

            .actions {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                justify-content: center;
                margin: 20px 0;
            }

            .actions button {
                background-color: #007bff;
                color: white;
                border: none;
                padding: 10px;
                cursor: pointer;
                border-radius: 5px;
                flex: 1 1 calc(50% - 10px);
                max-width: 80px;
                text-align: center;
            }

            .sections .section {
                margin-top: 20px;
            }

            .collaborators {
                margin-top: 20px;
            }

            .collaborators h3 {
                margin-bottom: 10px;
            }

            .collapsible {
                margin-bottom: 10px;
            }

            .collapsible-content h5 {
                font-size: 14px;
                margin-top: 11px;
                margin-bottom: 0px;
            }

            .collapsible-header {
                background-color: transparent;
                color: #2d3e50;
                cursor: pointer;
                padding: 5px 0px;
                width: 100%;
                border: none;
                text-align: left;
                outline: none;
                font-size: 15px;
                border-radius: 5px;
                font-weight: 600;
            }

            .collapsible-content {
                padding: 0 10px;
                display: none;
                overflow: hidden;
                background-color: #f0f4f8;
                border-radius: 5px;
                margin-top: 5px;
            }

            .collapsible-content p {
                padding: 0px 0px;
                margin: 0;
                font-size: 13px;
                color: gray;
            }

            .main {
                flex-grow: 1;
                padding: 20px;
                box-sizing: border-box;
                overflow-y: auto;
            }

            .headerr {
                display: flex;
                justify-content: flex-start;
                margin-bottom: 20px;
                gap: 10px;
            }

            .headerr .tablink {
                background-color: #f0f4f8;
                color: black;
                border: none;
                padding: 10px 20px;
                cursor: pointer;
                font-size: 16px;
            }

            .headerr .tablink.active {
                background-color: #2d3e50;
                color: white;
            }

            .content {
                height: calc(100% - 60px);
            }

            .data-highlights,
            .recent-activities {
                margin-bottom: 20px;
            }

            .data-highlights h2,
            .recent-activities h2 {
                margin: 0 0 10px 0;
                font-size: 18px;
            }

            .data-row {
                display: flex;
                justify-content: space-between;
            }

            .data-row div {
                flex: 1;
                margin-right: 20px;
            }

            .data-row div:last-child {
                margin-right: 0;
            }

            .data-row p {
                margin: 0;
                color: gray;
                font-size: 13px;
            }

            .activity {
                border: 1px solid #ddd;
                padding: 15px;
                border-radius: 5px;
                margin-bottom: 10px;
                background-color: #fff;
            }

            .recent-activities h2 {
                text-align: left;
                padding-left: 15px;
                font-size: 17px;
                color: #2d3e50;
                padding-top: 10px;
            }

            .activity-header {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
            }

            .activity-icon {
                margin-right: 10px;
            }

            .activity-header p {
                margin: 0;
                margin-right: 10px;
                color: #007bff;
            }

            .right-sidebarr {
                width: 25%;
                background-color: #f0f4f8;
                padding: 20px;
                box-sizing: border-box;
                border-left: 1px solid #ddd;
                overflow-y: auto;
            }

            .associated-objects .section {
                margin-bottom: 20px;
            }

            .associated-objects h3 {
                margin-bottom: 10px;
            }

            .associated-objects p {
                color: #666;
            }

            .associated-objects button {
                background-color: #007bff;
                color: white;
                border: none;
                padding: 10px;
                cursor: pointer;
                border-radius: 5px;
            }

            .profile_box {
                display: flex;
                align-items: center;
            }

            .profile_actions {
                display: flex;
                align-items: center;
            }

            .profile_actions p {
                text-align: center;
            }

            .data-highlights {
                background: white;
                text-align: center;
                padding-bottom: 15px;
                padding-top: 11px;
            }

            .data-highlights h2 {
                text-align: left;
                padding-left: 15px;
                padding-bottom: 15px;
                font-size: 17px;
                color: #2d3e50;
            }

            .data-row h5 {
                font-size: 15px;
                font-weight: 500;
                color: #2d3e50;
                margin-bottom: 3px;
            }

            .activ_head p {
                color: gray;
                font-size: 13px;
            }

            span.user_name {
                color: #2d3e50;
            }

            .avatarr {
                width: 40px;
                height: 40px;
                background-color: #ccc;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 15px;
                margin-bottom: 20px;
            }

            .user_profile {
                display: flex;
            }

            .user_profile_text p {
                margin-bottom: -3px;
                font-size: 11px;
                font-weight: 700;
                margin-top: 4px;
                padding-left: 8px;
            }

            .activ_head {
                display: flex;
                justify-content: space-between;
            }

            .user_cont p {
                font-size: 12px;
                color: gray;
            }

            .right_collab i {
                float: right;
                background: #2d3e50;
                color: white;
                padding: 5px;
                border-radius: 5px;
                font-size: 11px;
            }

            .user_cont h4 {
                font-size: 13px;
                font-weight: 600;
                color: #2d3e50;
                margin-bottom: 4px;
            }

            .activ_top {
                margin-top: 2%;
            }

            .balnk_text p {
                text-align: center;
                margin: 50px;
                font-size: 14px;
            }

            .tabs_header {
                display: flex;
                justify-content: space-between;
                margin-bottom: 3%;
            }

            .tabs_header select {
                width: 35%;
            }

            .tabs_header input {
                width: 35%;
            }
        </style>

        <div class="containerr">
            <div class="sidebarr">
                <div class="profile">
                    <div class="profile_box">
                        <div class="avatar">MM</div>
                        <div class="contact-info">
                            <h2>Mr Malik</h2>
                            <p>mmr840327@gmail.com</p>
                        </div>
                    </div>
                    <div class="profile_actions">
                        <p>
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Note
                        </p>
                        <p><i class="fa fa-envelope-o" aria-hidden="true"></i> Email</p>
                        <p>
                            <i class="fa fa-phone-square" aria-hidden="true"></i> Call
                        </p>
                        <p><i class="fa fa-coffee" aria-hidden="true"></i> Task</p>
                        <p>
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i> More
                        </p>
                    </div>
                </div>
                <div class="sections">
                    <div class="collaborators">
                        <div class="collapsible">
                            <button class="collapsible-header">
                                About this contact
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </button>
                            <div class="collapsible-content">
                                <h5>Eamil</h5>
                                <p>arhamumar63@gmail.com</p>
                                <h5>Phone number</h5>
                                <p>+92 306-1343427</p>
                                <h5>Contact owner</h5>
                                <p>arhum butt</p>
                            </div>
                        </div>
                        <div class="collapsible">
                            <button class="collapsible-header">
                                Communication subscriptions
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </button>
                            <div class="collapsible-content">
                                <p>
                                    Use subscription types to manage the communications this
                                    contact receives from you
                                </p>
                            </div>
                        </div>
                        <div class="collapsible">
                            <button class="collapsible-header">
                                Website activity
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </button>
                            <div class="collapsible-content">
                                <p>
                                    Website activity shows you how many times a contact has
                                    visited your site and viewed your pages.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main">
                <div class="headerr">
                    <button class="tablink active" onclick="openTab('Overview')">
                        Overview
                    </button>
                    <button class="tablink" onclick="openTab('Activities')">
                        Activities
                    </button>
                </div>
                <div class="content">
                    <div id="Overview" class="tabcontent">
                        <div class="data-highlights">
                            <h2>Data highlights</h2>
                            <div class="data-row">
                                <div>
                                    <h5>CREATE DATE</h5>
                                    <p>12/03/2024 4:48 PM GMT+5</p>
                                </div>
                                <div>
                                    <h5>LIFECYCLE STAGE</h5>
                                    <p>Lead</p>
                                </div>
                                <div>
                                    <h5>LAST ACTIVITY DATE</h5>
                                    <p>12/03/2024 4:48 PM GMT+5</p>
                                </div>
                            </div>
                        </div>
                        <div class="recent-activities">
                            <h2>Recent activities</h2>
                            <div class="activity">
                                <div class="activ_head">
                                    <p>
                                        Inbound email from
                                        <span class="user_name">Mr Malik</span>
                                    </p>
                                    <p class="usre_date">Dec 3, 2024 at 4:48 PM GMT+5</p>
                                </div>

                                <div>
                                    <div class="user_profile">
                                        <div class="user_profile_img">
                                            <div class="avatarr">MM</div>
                                        </div>
                                        <div class="user_profile_text">
                                            <p>Mike Stewar mikestewar1932@outlook.com</p>
                                            <p>to info@phototouchexpert.com</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="user_cont">
                                    <p>
                                        Hi there, I hope you're doing well. I specialize in
                                        online reputation management and can help boost your
                                        business's presence by generating positive reviews and
                                        addressing any negative feedback.
                                    </p>
                                </div>
                            </div>
                            <div class="activity">
                                <div class="activ_head">
                                    <p>
                                        Inbound email from
                                        <span class="user_name">Mr Malik</span>
                                    </p>
                                    <p class="usre_date">Dec 3, 2024 at 4:48 PM GMT+5</p>
                                </div>

                                <div>
                                    <div class="user_profile">
                                        <div class="user_profile_img">
                                            <div class="avatarr">MM</div>
                                        </div>
                                        <div class="user_profile_text">
                                            <p>Mike Stewar mikestewar1932@outlook.com</p>
                                            <p>to info@phototouchexpert.com</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="user_cont">
                                    <p>
                                        Hi there, I hope you're doing well. I specialize in
                                        online reputation management and can help boost your
                                        business's presence by generating positive reviews and
                                        addressing any negative feedback.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="Activities" class="tabcontent" style="display: none">
                        <div class="recent-activities">
                            <div class="tabs_header">
                                <input
                                    type="email"
                                    class="form-control"
                                    id="exampleFormControlInput1"
                                    placeholder="name@example.com"
                                />
                                <select class="form-control" id="exampleFormControlSelect1">
                                    <option>Collapse All</option>
                                    <option>Expand All</option>
                                </select>
                            </div>

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link active"
                                        id="activity-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#activity"
                                        type="button"
                                        role="tab"
                                        aria-controls="activity"
                                        aria-selected="true"
                                    >
                                        Activity
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link"
                                        id="notes-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#notes"
                                        type="button"
                                        role="tab"
                                        aria-controls="notes"
                                        aria-selected="false"
                                    >
                                        Notes
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link"
                                        id="emails-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#emails"
                                        type="button"
                                        role="tab"
                                        aria-controls="emails"
                                        aria-selected="false"
                                    >
                                        Emails
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link"
                                        id="calls-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#calls"
                                        type="button"
                                        role="tab"
                                        aria-controls="calls"
                                        aria-selected="false"
                                    >
                                        Calls
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link"
                                        id="tasks-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#tasks"
                                        type="button"
                                        role="tab"
                                        aria-controls="tasks"
                                        aria-selected="false"
                                    >
                                        Tasks
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link"
                                        id="meetings-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#meetings"
                                        type="button"
                                        role="tab"
                                        aria-controls="meetings"
                                        aria-selected="false"
                                    >
                                        Meetings
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div
                                    class="tab-pane fade show active"
                                    id="activity"
                                    role="tabpanel"
                                    aria-labelledby="activity-tab"
                                >
                                    <div>
                                        <div class="activity activ_top">
                                            <div class="activ_head">
                                                <p>
                                                    Inbound email from
                                                    <span class="user_name">Mr Malik</span>
                                                </p>
                                                <p class="usre_date">
                                                    Dec 3, 2024 at 4:48 PM GMT+5
                                                </p>
                                            </div>

                                            <div class="user_cont">
                                                <h4>Online Reputation Management</h4>
                                                <p>
                                                    Hi there, I hope you're doing well. I specialize
                                                    in online reputation management and can help boost
                                                    your business's presence by generating positive
                                                    reviews and addressing any negative feedback.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="tab-pane fade"
                                    id="notes"
                                    role="tabpanel"
                                    aria-labelledby="notes-tab"
                                >
                                    <div class="balnk_text">
                                        <p>
                                            Take notes about this record to keep track of
                                            important info. You can even @mention a teammate if
                                            you need to. Learn more
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="tab-pane fade"
                                    id="emails"
                                    role="tabpanel"
                                    aria-labelledby="emails-tab"
                                >
                                    <div class="balnk_text">
                                        <p>
                                            Take notes about this record to keep track of
                                            important info. You can even @mention a teammate if
                                            you need to. Learn more
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="tab-pane fade"
                                    id="calls"
                                    role="tabpanel"
                                    aria-labelledby="calls-tab"
                                >
                                    <div class="balnk_text">
                                        <p>
                                            Take notes about this record to keep track of
                                            important info. You can even @mention a teammate if
                                            you need to. Learn more
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="tab-pane fade"
                                    id="tasks"
                                    role="tabpanel"
                                    aria-labelledby="tasks-tab"
                                >
                                    <div class="balnk_text">
                                        <p>
                                            Take notes about this record to keep track of
                                            important info. You can even @mention a teammate if
                                            you need to. Learn more
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="tab-pane fade"
                                    id="meetings"
                                    role="tabpanel"
                                    aria-labelledby="meetings-tab"
                                >
                                    <div class="balnk_text">
                                        <p>
                                            Take notes about this record to keep track of
                                            important info. You can even @mention a teammate if
                                            you need to. Learn more
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-sidebarr">
                <div class="collaborators right_collab">
                    <div class="collapsible">
                        <button class="collapsible-header">
                            About this contact
                            <i class="fa fa-plus" aria-hidden="true"> Add</i>
                        </button>
                        <div class="collapsible-content">
                            <h5>Eamil</h5>
                            <p>arhamumar63@gmail.com</p>
                            <h5>Phone number</h5>
                            <p>+92 306-1343427</p>
                            <h5>Contact owner</h5>
                            <p>arhum butt</p>
                        </div>
                    </div>
                    <div class="collapsible">
                        <button class="collapsible-header">
                            Communication
                            <i class="fa fa-plus" aria-hidden="true"> Add</i>
                        </button>
                        <div class="collapsible-content">
                            <p>
                                Use subscription types to manage the communications this
                                contact receives from you
                            </p>
                        </div>
                    </div>
                    <div class="collapsible">
                        <button class="collapsible-header">
                            Website activity
                            <i class="fa fa-plus" aria-hidden="true"> Add</i>
                        </button>
                        <div class="collapsible-content">
                            <p>
                                Website activity shows you how many times a contact has
                                visited your site and viewed your pages.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('script')
        @include('admin.customers.companies.script')
    @endpush
@endsection
