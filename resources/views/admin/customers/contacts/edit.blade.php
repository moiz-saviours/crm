@extends('admin.layouts.app')
@section('title', 'Customer CustomerContact / Edit')
@section('content')
    @push('style')
        @include('admin.customers.contacts.style')

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

            .custom-drop-down-show-main {
                display: flex !important;

            }

            .custom-drop-down-show.dropdown-menu.show {
                box-shadow: none;
                border: 1px solid #ddd;
            }

            .collpase-divider {
                background-color: #ddd;
                height: 1px;
            }

            .collapse-header-box {
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .nav-tabs.newtabs-space {
                margin-bottom: 34px;
            }

            .date-by-order {
                text-align: left;
                padding-left: 15px;
                font-size: 1.063rem;
                color: var(--bs-primary);
                padding-top: 10px
            }

            .custom-tabs-row-scroll {
                padding-bottom: 50px;
                height: 100vh;
                /* Makes sure it takes up full height of the viewport */
                overflow-y: auto;
                /* Enables vertical scrolling */
            }

            .custom-tabs-row {
                padding: 14px 7px;
            }

            .nav-tabs .nav-link.main-tabs-view {
                border-radius: 0px;
                font-weight: 400;
                font-size: var(--nf-profile-para-size);;
                /*font-size: 0.813rem;*/
                padding: 12px 28px;
                color: rgb(51, 71, 91);
                position: relative;
                white-space: nowrap;
                /* transition: background-color 200ms cubic-bezier(0.25, 0.1, 0.25, 1); */
                /* background-color: rgb(234, 240, 246); */
                /* border-left: 1px solid rgb(203, 214, 226); */
            }

            .nav-tabs .nav-link.main-tabs-view.active {
                background-color: rgb(234, 240, 246);
            }

            .nav-tabs .nav-link.customize {
                background-color: transparent !important;
                border: 0px;
                font-size: var(--nf-profile-para-size);
            }

            .nav-tabs .nav-link.customize.active {
                border-bottom: 3px solid var(--bs-primary);
                background: transparent;
                border-width: 0px 0px 3px 0px;
                border-radius: 3px;
            }

            .custom-btn-collapse {
                background: transparent;
                border: none;
                padding: 0;
                color: var(--bs-primary);
                font-size: var(--nf-profile-para-size);
                /*font-size: 0.75rem;*/
                /* border-radius: 5px; */
                font-weight: 600;
                text-align: left;

            }

            .custom-btn-collapse:hover {
                color: #0091AE;
            }

            .custom-spacing {
                padding: 0px 13px;
            }

            .data-top-heading-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                /* padding: 10px 0px; */

            }

            .sidebar-icons {
                background-color: #EAF0F6;
                border: 1px solid #CBD6E2;
                color: #506E91;
                padding: 12px;
                border-radius: 31px;
                /*font-size: 9px;*/
                font-size: 0.9rem;
            }


            .main-left-sidebar-actions {
                display: flex;
                padding: 16px 16px;
                justify-content: space-between;

            }

            .new-class-hide-scroll {
                height: 100vh;
                overflow: hidden;
            }


            .sidebarr {
                /*width: auto;*/
                /* padding-bottom: 50px; */
                background-color: #fff;
                padding: 0px 2px 50px;
                box-sizing: border-box;
                border-right: 1px solid #ddd;
                height: 100vh;
                /* Makes sure it takes up full height of the viewport */
                overflow-y: auto;
                /* Enables vertical scrolling */
                /*height: calc(-200px + 100vh);*/
                /*flex-grow: 1;*/
                border-radius: 0px 0px 0px 0px;

            }

            .view-subscription-link {

                color: #0091ae !important;
                font-weight: 600;
                font-size: var(--nf-profile-para-size);
                /*font-size: 12px;*/
                margin: 0px !important;
                padding-top: 11px;
                text-decoration: none;
                text-transform: capitalize;

            }

            .profile {
                display: flex;
                /* flex-direction: column; */
                align-items: center;
            }

            /* .avatar-img-box {
                            width: 53px;
                            height: 43px;
                        } */

            .avatar-img {
                border-radius: 50%;
                background: #F2F5F8;
                /* padding-top: 10px; */
                max-height: 3rem;
                max-width: 3rem;
                /*height: 40px;*/
                /*width: 47px;*/
                padding: 9px 0px 0px;

            }

            .avatar-icon {
                border-radius: 50%;
                background: #F2F5F8;
                /* padding-top: 10px; */
                height: 55px;
                width: 55px;
                padding: 10px 0px;
                font-size: 30px;
                text-align: center;
                line-height: 0;
            }

            .searchbox .searchbox__input.bg-color {
                border: 0;
                box-shadow: none !important;
                background: #fff !important;
                color: #ddd !important;
            }

            .avatar {
                width: 58px;
                height: 58px;
                background-color: #ccc;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
                /* margin-bottom: 20px; */
            }

            .contact-info {
                /* text-align: center; */
                /*margin-left: 8px;*/
                margin: auto 5px;

            }

            .email-box-container {
                background-color: rgb(255, 255, 255);
                border: 1px solid rgb(223, 227, 235);
                border-radius: 4px;
                padding: 16px 17px;
                margin-bottom: 20px;
            }

            .customize-select {
                min-width: 150px;
            }

            .customize-select select {
                appearance: none;
                width: 100%;
            }

            .contact-info h2 {
                margin: 0;
                /*font-size: var(--nf-profile-title-size);*/
                /*font-weight: var(--nf-profile-title-weight);*/
                /*font-size: 1.125rem;*/
                /*font-size: var(--nf-profile-heading-size);*/

                font-weight: 100;
                text-align: left;

                color: var(--bs-primary);
                /* margin-bottom: -3px; */
            }

            .recent-filters {
                color: rgb(81, 111, 144);
                font-weight: 400;
                font-size: var(--nf-profile-para-size);
                line-height: 24px;
            }

            .contact-info p {
                /* margin: 5px 0; */
                /*font-size: 10px;*/
                font-size: 0.8rem;
                font-weight: 400;
                color: gray;
                margin: 3px 0px;
                line-break: anywhere;
            }

            .profile_actions p {
                font-size: 0.75rem;
                /*font-size: 10px;*/
                margin: 0px 8px;
                color: gray;
            }

            .email-child-wrapper {
                display: flex;
                gap: 8px;
                cursor: pointer;
                align-items: center
            }

            .comment-active_head {
                display: flex;
                justify-content: space-between;
                margin: 10px 0px;
                /* align-items: center; */
                align-items: baseline;
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
                /*margin-top: 20px;*/
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
                color: var(--bs-primary);
                cursor: pointer;
                padding: 5px 0px;
                width: 100%;
                border: none;
                text-align: left;
                outline: none;
                font-size: 13px;
                border-radius: 5px;
                font-weight: 600;
            }

            .collapse-header-prent-box {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 12px;
                /* margin-top: 11px; */
                /* border-bottom: 1px solid #ddd; */
                /* padding-bottom: 14px; */
                padding: 0px 12px;

            }

            .custom-collapse-cards {
                padding: 0 19px;
                box-shadow: none;
                /*margin: 0px 15px 9px;*/
            }

            .custom-collapse-cards-two {
                padding: 13px;
                box-shadow: none;
                margin: 0px 15px;
                background: transparent;
            }

            .custom-contact-cards {
                background: transparent;
                box-shadow: none;
                padding: 0px 0px 0px 30px;
            }

            .contact-card-details-head {
                font-size: var(--nf-profile-para-size);
                color: gray;
                /*font-weight: 400;*/
                margin: 5px 0px;
            }

            .custom-right-detail-column {
            }

            .contact-card-details-para {
                font-weight: 500;
                font-size: var(--nf-profile-para-size);
            }

            .contact-details-input-fields {
                width: 100%;
                border: none;

            }

            .contact-details-input-fields:focus-visible {
                outline: 0;
                border-bottom: 1px solid #0091AE;
                padding: 8px;
            }

            .custom-contact-detail-dropdown {
                font-size: var(--nf-profile-para-size) !important;
                color: gray !important;
                font-weight: 400 !important;
                margin: 0;
                border: 0;
                background: transparent;
                padding: 0;
                /*letter-spacing: 1px;*/
            }

            .custom-contact-detail-dropdown.dropdown-toggle::after {
                color: #0091AE;
            }

            .dropdown-menu.custom-contact-detail-dropdown-show.show {
                /* box-shadow: none; */
                width: 100%;
            }

            .contact-card-subscription-para {
                font-size: var(--nf-profile-para-size);
                font-weight: 400;
                line-height: 24px;
                color: #33475B;
                margin-bottom: 0;
            }

            .custom-contact-detail-dropdown:focus-visible {
                outline: none;
                border: none;
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
                background-color: var(--bs-primary);
                color: white;
            }

            .content {
                height: calc(100% - 60px);
                background-color: #f5f8fa;
            }

            .data-highlights,
            .recent-activities {
                margin-bottom: 20px;
            }

            .data-highlights h2,
            .recent-activities h2 {
                margin: 0 0 0px 0;
                /*margin: 0 0 10px 0;*/
                font-size: 1.125rem;
            }

            .data-highlights p {
                font-size: var(--nf-profile-para-size);
            }

            .data-row {
                display: flex;
                justify-content: space-between;
                padding: 2px 9px;
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
                font-size: 10px;
                text-align: center;
            }

            .activity {
                border: 1px solid #ddd;
                padding: 21px 17px;
                border-radius: 5px;
                margin-bottom: 10px;
                background-color: #fff;
            }

            .recent-activities h2 {
                text-align: left;
                /* padding-left: 15px; */
                font-size: var(--nf-profile-heading-size);
                color: var(--bs-primary);
                padding-top: 10px;
            }

            .activities-seprater {
                color: #0091ae !important;
                font-weight: 600;
                font-size: var(--nf-profile-para-size);
                margin: 0px !important;
            }

            .activities-addition-links {
                color: #0091ae !important;
                font-weight: 600;
                font-size: var(--nf-profile-para-size);
                /*font-size: 12px;*/
                margin: 0px !important;
                text-decoration: none;
            }

            .activities-addition-links:hover {
                text-decoration: underline;

            }

            .add-coment-icon {
                color: #75868f;
            }

            .hidden {
                display: none;
            }

            /* .email-child-wrapper {
                            color: #007bff;
                            padding: 10px 15px;

                            font-size: 14px;
                        } */

            .comment-box {
                margin-top: 10px;
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
                /* color: #007bff; */
            }

            .right-sidebarr {
                /* width: 25%; */
                background-color: #fff;
                /*background-color: #f0f4f8;*/
                padding: 20px 0px 50px;
                height: 100vh;
                /* Makes sure it takes up full height of the viewport */
                overflow-y: auto;
                /* Enables vertical scrolling */
                box-sizing: border-box;
                border-left: 1px solid #ddd;
                padding-bottom: 50px;

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
                padding: 12px 13px 0px;
                /* align-items: center; */
                /*gap: 9px;*/
                /*align-items: center;*/
            }

            .profile_actions {
                display: flex;
                align-items: center;
                justify-content: space-evenly;
                border-bottom: 1px solid #ddd;
                /* padding-bottom: 30px; */
                padding: 20px 13px;
                /* gap: 11px; */
                flex-wrap: wrap;
                margin: 10px 0px;
            }


            .profile_actions p {
                text-align: center;
            }


            .data-highlights {
                background: white;
                /* text-align: center; */
                padding: 20px 17px;
                margin-top: 20px;
                border-radius: 3px;
                box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
            }

            .data-highlights h2 {
                text-align: left;
                /* padding-left: 15px;
                            padding-bottom: 15px; */
                font-size: var(--nf-profile-heading-size);
                color: var(--bs-primary);
            }

            .data-row h5 {
                font-size: 11px;
                font-weight: 500;
                color: var(--bs-primary);
                margin-bottom: 3px;
                text-align: center;
            }

            .activ_head p {
                color: gray;
                margin: 0px;
                font-size: var(--nf-profile-para-size);
            }

            span.user_name {
                color: var(--bs-primary);
            }

            .new-sidebar-icons {
                color: #808080;
                background-color: #ddd;
                padding: 12px;
                border-radius: 50%;
                display: flex;
                align-items: center;
            }

            .avatarr {
                width: 35px;
                height: 35px;
                background-color: #ccc;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 12px;
                margin-bottom: 20px;
            }

            .editor-container {
                /* width: 80%; */
                display: flex;
                gap: 8px;
                /* margin: 0 auto; */
            }

            .search-containers {
                display: flex;
                align-items: center;
                position: relative;
                overflow: hidden;
                border: 1px solid #ccc;
                /* border-radius: 20px; */
                background-color: white;
                transition: width 0.4s ease;
                /* Initial small width */
            }

            .search-containers.expanded {
                width: 300px;
                /* Expanded width */
            }

            .search-inputs {
                border: none;
                outline: none;
                padding: 6px 0;
                padding-left: 14px;
                font-size: var(--nf-profile-para-size);
                width: 136px;
                /* width: 0; */
                transition: width 0.4s ease;
                opacity: 1;
            }

            .search-containers.expanded .search-inputs {
                width: 240px;
                /* Full width inside expanded container */
                padding-left: 15px;
                opacity: 1;
            }

            .search-btns {
                background: none;
                border: none;
                outline: none;
                padding: 8px;
                cursor: pointer;
                font-size: 12px;
                color: #666;
            }

            .search-btns span {
                font-size: 18px;
            }

            .new-activity-dropdown {
                background-color: #dddddd;
                border: 1px solid #ccc;
                border-radius: 0;
                padding: 8px 16px;
                font-size: var(--nf-profile-para-size);
                /*font-size: 0.813rem;*/
                /*font-size: 13px;*/
            }

            .new-activity-dropdown:hover {
                box-shadow: none;
            }

            .new-activity-dropdown:focus {
                box-shadow: none;
            }

            .new-activity-dropdown.dropdown-menu.show {
                box-shadow: none;
                border: 1px solid #ddd;
            }

            .your-comment-btn {
            }

            .toolbar {
                background-color: #dddddda6;
                padding: 6px;
                border: 1px solid #ccc;
                display: flex;
                justify-content: flex-start;
                gap: 10px;
                margin-bottom: 10px;
            }

            .toolbar button {
                padding: 2px 12px;
                cursor: pointer;
                border: 1px solid #ccc;
                background-color: #fff;
                font-size: 12px;
            }

            .editor {
                border: 1px solid #ccc;
                padding: 10px;
                min-height: 90px;
                background-color: #dddddda6;
                width: 100%;
            }

            .editor[contenteditable="true"]:empty:before {
                content: "Leave comment...";
                color: #aaa;
            }

            .custom-drop-btn-design {
                background: transparent;
                border: none;
                color: #0c96b2;
                font-weight: 600;
                padding: 0;
                /*font-size: 13px;*/
                font-size: var(--nf-profile-para-size);
                text-align: left;
            }


            .custom-drop-btn-design:hover {
                background-color: transparent;
                box-shadow: none;
                border: none;
                color: #0c96b2;
            }

            .user_profile {
                display: flex;
            }

            .user_profile-hidden {
                display: none;
            }

            .contact-us-text {

                /* margin-bottom: -3px; */
                font-size: 11px;
                font-weight: 700;
                margin-top: 4px;
                padding-left: 4px;

            }

            .user-email-template {
                padding-left: 47px;

            }

            .contentdisplay {
                display: none;

            }

            .contentdisplaytwo {
                display: none;

            }

            .new-profile-email-wrapper {
                display: flex;
                gap: 7px;
            }

            .new-profile-parent-wrapper {
                display: flex;
                justify-content: space-between;
            }


            .user_profile_text p {
                margin-bottom: -3px;
                font-size: 0.75rem;
                font-weight: 700;
                margin-top: 4px;
                padding-left: 8px;
            }

            .activ_head {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
                align-items: center;
            }

            .user_cont p {
                font-size: var(--nf-profile-para-size);
                color: gray;
                margin: 0;
            }


            .user_cont {
                font-size: var(--nf-profile-para-size);
                color: gray;
                margin: 0;
                /* padding: 16px 6px; */
            }

            .right_collab {
                float: right;
                /* background: var(--bs-primary); */
                color: #0091ae;
                /*color: var(--bs-primary);*/
                padding: 5px;
                border-radius: 5px;
                font-size: var(--nf-profile-para-size);
                /*font-size: 11px;*/
                cursor: pointer;
            }

            .right_collab:hover {
                text-decoration: underline;
            }

            .prof-edit-icons {
                color: #0091ae !important;
                font-size: 11px;
                margin: auto 0px auto 8px;
            }

            .edit-icons-kit {
                opacity: 0;
            }

            .profile_box:hover .edit-icons-kit {
                opacity: 1;
            }

            .edit-prof-head {
                color: #33475b;
                /*line-height: 24px;*/
                font-weight: 500;
                margin-bottom: 0px;
                font-size: 14px;
            }

            .dropdown-menu.custom-edit-detail-dropdown-show.show {
                /* box-shadow: none; */
                width: 19%;
                background: #FFF;
                padding: 20px 24px;
                transform: translate(418px, 133px) !important;
            }

            .edit-input-fields {
                margin: 7px 0px 15px;
                width: 100%;
                font-size: 13px;
                line-height: 22px;
                text-align: left;
                vertical-align: middle;
                color: rgb(51, 71, 91);
                background-color: rgb(245, 248, 250);
                border: 1px solid rgb(203, 214, 226);
                border-radius: 3px;
                padding: 4px 10px;
                height: auto;
                resize: none;
                display: inline-block;
                font-weight: 400 !important;
            }

            .companies-add-forms {
                background-color: #eaf0f6;
                border-color: #cbd6e2;
                color: #506e91;
                font-size: 11px;
                line-height: 14px;
                padding: 5px 10px;
                border-radius: 3px;
                border-style: solid;
                border-width: 1px;
            }

            .edit-input-fields:focus-visible {
                outline: 0;
                border: 1px solid #0091ae;
            }

            .main-edit-btn-box {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .edit-prof-btn {
                background-color: #425b76;
                border-color: #425b76;
                border-radius: 3px;
                border-style: solid;
                border-width: 1px;
                color: #fff;
                font-size: 12px;
                line-height: 14px;
                padding: 6px 0px;
                width: 35%;

            }

            .canel-edition-btn {
                background-color: #eaf0f6;
                border-color: #cbd6e2;
                color: #506e91;
            }

            .create-contact {
                font-size: 7px;
            }

            .main-payment-btn-wrapper {
                text-align: center;
                margin-left: 33px;
                margin-top: 16px;
                /*margin-bottom: 12px;*/
            }

            .set-payment-btn {
                background-color: #eaf0f6;
                border-color: #cbd6e2;
                color: #506e91;
                font-size: 12px;
                font-weight: 400;
                line-height: 14px;
                padding: 6px 14px;
                border-radius: 3px;
                border-style: solid;
                border-width: 1px;
            }

            .right_collaboratrs-box {
                display: flex;
                justify-content: space-between;
                align-items: baseline;
            }

            .user_cont h4 {
                font-size: 0.813rem;
                font-weight: 600;
                color: var(--bs-primary);
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

            /*EMAIL SECTION CSS*/

            .email-threading-row {
                display: flex;
                justify-content: end;
                gap: 7px;
                flex-wrap: wrap;
                align-items: center;
            }

            .threading-email-btn-one {
                background-color: #dddddd;
                border-color: #ccc;
                color: gray;
                font-size: 0.813rem;
                /*font-size: 12px;*/
                font-weight: 400;
                line-height: 14px;
                padding: 6px 14px;
                border-radius: 3px;
                border-style: solid;
                border-width: 1px;
            }

            .threading-email-btn-two {
                background-color: var(--bs-primary);
                border-color: var(--bs-primary);
                color: #fff;
                font-size: 0.813rem;
                font-weight: 400;
                line-height: 14px;
                padding: 6px 14px;
                border-radius: 3px;
                border-style: solid;
                border-width: 1px;
            }

            .email-body-text {
                padding: 10px 0px;
            }

            .email-body-img {
                width: 566px;
            }

            .email-client-site-link {
                color: #1155cc;

                font-weight: 600;
                text-decoration: none;
            }

            .email-client-site-link:hover {
                color: #1155cc;
                text-decoration: underline;
            }

            .client-email-logo {
                width: 155px;
            }

            .view-full-email-reply-btn {
                font-size: 12px;
                font-weight: 400;
                line-height: 0;
                padding: 4px 13px;
                border-radius: 19px;
                border-style: solid;
                border-width: 1px;
                background-color: #EAF0F6;
                border: 1px solid #CBD6E2;
                color: #506E91;
            }

            .custom-email-reply-collapse {
                box-shadow: none;
                padding: 12px 0px 0px;
            }

            .custom-email-reply-collapse-body {
                padding: 0px 12px;
                border-left: 1px solid #CBD6E2;
                margin-bottom: 15px;
            }

            .new-profile-email-thread-wrapper {
                display: flex;
                gap: 7px;
                opacity: 0;
            }

            .comment-head-thread-wrapper {
                display: flex;
                justify-content: space-between;
                margin: 10px 0px 0px;

            }

            .thread-dropdown-display {
                opacity: 0;
            }

            .email-box-container:hover .new-profile-email-thread-wrapper {
                opacity: 1;
            }

            .email-box-container:hover .thread-dropdown-display {
                opacity: 1;
            }

            .doc-attachment-container- {
                padding: 10px;
            }

            .doc-attachment {
                display: flex;
                align-items: center;
                background-color: #edf2fa;
                border: 1px solid #ddd;
                border-radius: 0;
                padding: 4px 7px;
                text-decoration: none;
                color: gray;
                width: 243px;
                /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); */
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            /* .doc-attachment:hover {
                        transform: scale(1.05);
                        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                        } */

            .icon-doc {
                font-size: 24px;
                margin-right: 10px;
            }

            .file-info-doc {
                flex-grow: 1;
            }

            .file-name-doc {
                font-weight: bold;
                margin: 0;
                color: #0091ae !important;
            }

            .file-size-doc {
                font-size: 0.85rem;
                color: #777;
                margin: 0;
            }

            .collapse-all-content-container {
                background-color: #2d3f4f;
                padding: 8px 21px;
                text-align: center;
            }

            .all-collapse-thread-emails-btn {
                color: #fff;
                border: none;
                background: transparent;
                font-size: var(--nf-profile-para-size);
            }

            .moretext {
                display: none;
            }

            .invoice_sec {
                display: grid;
                padding: 5px 10px;
                border: 1px solid #ddd;
                margin: 10px 0px;
                font-size: var(--nf-profile-para-size);
            }

            .invoice_sec .invoice_num {
                color: #0091ae;
                font-weight: 600;
                padding-bottom: 5px;
                display: flex;
                justify-content: space-between;
            }

            .cstm_note_cont {
                display: flex;
                justify-content: space-between;
            }

            .cstm_right_icon {
                display: flex;
            }

            .cstm_btn {
                background: transparent;
            }

            .cstm_right_icon {
                opacity: 0;
                transition: opacity 0.3s ease-in-out;
            }

            .data-highlights:hover .cstm_right_icon {
                opacity: 1;
            }

            .cstm_right_icon i {
                color: #0091ae;
            }


            /*NEw STYLE*/
            .profile_box img {
                background-color: #dedede;
            }

            .company_sec {
                display: grid;
                padding: 5px 10px;
                border: 1px solid #ddd;
                margin: 10px 0px;
                font-size: var(--nf-profile-para-size);
            }

            .company_sec span {
                font-size: 0.8rem;
            }

            .company_sec span a {
                text-decoration: none;
                color: #0a89b4;
            }

            .invoice_sec span {
                font-size: 0.8rem;
            }

            .cstm_bdge {
                padding: 5px 10px;
                font-weight: 400;
                font-size: 0.7rem !important;
                border-radius: 3px;
            }

            .showhide-invoice {
                font-size: 10px;
                font-weight: 500;
                color: #0091ae;
                border: none;
                background-color: #fff;

            }

            .showhide-payment {
                font-size: 10px;
                font-weight: 500;
                color: #0091ae;
                border: none;
                background-color: #fff;

            }

            .showhide:hover {
            }


            .show_btn:hover {
                text-decoration: none;
            }

            .para_sec {
                padding: 5px 0px;
                margin: 10px 0px;
                font-size: var(--nf-profile-para-size);
            }

            .note-para {
                padding: 10px 10px;
                text-align: center;
                font-size: var(--nf-profile-para-size);
                color: grey;
            }

        </style>
    @endpush
    <div class="new-class-hide-scroll">
        <section id="content" class="content new-box-main-wrapper ">

            <div class="container-fluid p-0 ">

                <div class="">
                    @if($imapError)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ $imapError }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif


                    <div class="row ">
                        <div class="col-lg-3">

                            <div class="sidebarr">
                                <div class="main-left-sidebar-actions">
                                    <a href="{{ route('admin.customer.contact.index') }}"
                                       class="view-subscription-link">
                                        <span><i class="fa fa-angle-left " aria-hidden="true"></i>
                                            contacts</span>
                                    </a>
                                    {{--                                    <a href="#" class="view-subscription-link"> --}}
                                    {{--                                        <span>Actions</span> --}}
                                    {{--                                    </a> --}}

                                </div>
                                <div class="left_side_sec">
                                    <div class="profile_box">
                                        <div class="avatar-img-box" style="padding-inline-end: 10px;">
                                            @if (file_exists(public_path('assets/images/user1.png')))
                                                <img class="mainnav__avatar img-md rounded-circle hv-oc profile-image"
                                                     src="{{ asset('assets/images/user1.png') }}">
                                            @else
                                                @php
                                                    $words = explode(
                                                        ' ',
                                                        $customer_contact->name ?? $customer_contact->email,
                                                    );
                                                    $initials = strtoupper(
                                                        $words[0][0] . (count($words) > 1 ? $words[1][0] : ''),
                                                    );
                                                @endphp
                                                <div
                                                    class="mainnav__avatar img-md rounded-circle hv-oc profile-image d-flex align-items-center justify-content-center "
                                                    style="background-color: var(--bs-primary);color:var(--bs-primary-color);font-size: var(--bs-border-radius-xxl);">
                                                    {{ $initials }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="contact-info">
                                            <h2>{{ $customer_contact->name ?? '---' }}</h2>
                                            <!-- <h5>Business Development Executive</h5> -->
                                            <style>
                                                .email_sec {
                                                    display: flex;
                                                    justify-content: center;
                                                }
                                            </style>
                                            <div class="email_sec">
                                                <p id="customerEmail">{{ $customer_contact->email }}</p>
                                                <i class="fa fa-clone prof-edit-icons copyEmail" aria-hidden="true"
                                                   data-bs-toggle="tooltip" data-bs-placement="top"
                                                   title="Copy email to clipboard"></i>
                                            </div>
                                        </div>
                                        <div>

                                            {{--                                            <button class="custom-contact-detail-dropdown" type="button" --}}
                                            {{--                                                    id="dropdownMenuButtonedit" data-bs-toggle="dropdown" --}}
                                            {{--                                                    aria-expanded="false"> --}}
                                            {{--                                                <i class="fa fa-pencil prof-edit-icons edit-icons-kit" --}}
                                            {{--                                                   aria-hidden="true"></i> --}}
                                            {{--                                            </button> --}}
                                            {{--                                            <ul class="dropdown-menu custom-edit-detail-dropdown-show" --}}
                                            {{--                                                aria-labelledby="dropdownMenuButtonedit"> --}}
                                            {{--                                                <li> --}}
                                            {{--                                                    <p class="edit-prof-head">First Name</p> --}}
                                            {{--                                                    <input class="edit-input-fields " type="text" --}}
                                            {{--                                                           placeholder="Hanny"> --}}
                                            {{--                                                </li> --}}
                                            {{--                                                <li> --}}
                                            {{--                                                    <p class="edit-prof-head">Last Name</p> --}}
                                            {{--                                                    <input class="edit-input-fields " type="text" --}}
                                            {{--                                                           placeholder="Hanny"> --}}
                                            {{--                                                </li> --}}
                                            {{--                                                <li> --}}
                                            {{--                                                    <p class="edit-prof-head">Job Title</p> --}}
                                            {{--                                                    <input class="edit-input-fields " type="text" --}}
                                            {{--                                                           placeholder="Hanny"> --}}
                                            {{--                                                </li> --}}
                                            {{--                                                <li> --}}
                                            {{--                                                    <div class="main-edit-btn-box"> --}}
                                            {{--                                                        <button class="edit-prof-btn"> --}}
                                            {{--                                                            Save --}}
                                            {{--                                                        </button> --}}
                                            {{--                                                        <button class="edit-prof-btn canel-edition-btn"> --}}
                                            {{--                                                            Cancel --}}
                                            {{--                                                        </button> --}}
                                            {{--                                                    </div> --}}
                                            {{--                                                </li> --}}

                                            {{--                                            </ul> --}}

                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="profile_actions">
                                        <div class="text-center">

                                            <i class="fa fa-pencil-square-o sidebar-icons" aria-hidden="true"></i>
                                            <p> Note</p>

                                        </div>

                                        <div class="text-center">

                                            <i class="fa fa-envelope sidebar-icons" aria-hidden="true"></i>
                                            <p> Email</p>
                                        </div>

                                        <div class="text-center">

                                            <i class="fa fa-phone sidebar-icons" aria-hidden="true"></i>
                                            <p>Call</p>
                                        </div>
                                        <div class="text-center">
                                            <i class="fa fa-calendar sidebar-icons" aria-hidden="true"></i>
                                            <p>Meeting</p>
                                        </div>
                                        {{--                                        <div class="text-center"> --}}
                                        {{--                                            <i class="fa fa-list sidebar-icons" aria-hidden="true"></i> --}}
                                        {{--                                            <p>Task</p> --}}
                                        {{--                                        </div> --}}

                                        {{--                                        <div class="text-center"> --}}
                                        {{--                                            <i class="fa fa-calendar-check-o sidebar-icons" aria-hidden="true"></i> --}}
                                        {{--                                            <p>More</p> --}}
                                        {{--                                        </div> --}}
                                    </div>
                                </div>

                                <div class="sections">
                                    <div class="collaborators">

                                        <div class="collapse-header-prent-box mt-4">
                                            <div class="collapse-header-box">

                                                <button class="btn custom-btn-collapse toggle-collapse" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseExamplecontact"
                                                        aria-expanded="true" aria-controls="collapseExamplecontact">
                                                    <i class="fa fa-chevron-down toggle-icon" aria-hidden="true"
                                                       style="padding-right: 5px;"></i>
                                                    About this contact
                                                </button>
                                            </div>
                                        </div>

                                        <div class="collapse show" id="collapseExamplecontact">
                                            <div class="card custom-contact-cards card-body">
                                                <div class="mb-2">
                                                    <p class="contact-card-details-head">Email</p>
                                                    <p class="contact-card-details-para">{{ $customer_contact->email }}</p>
                                                </div>
                                                <div class="mb-2">
                                                    <p class="contact-card-details-head">Phone</p>
                                                    <p class="contact-card-details-para">{{ $customer_contact->phone }}</p>
                                                    {{--                                                <input class="contact-details-input-fields " type="number" --}}
                                                    {{--                                                       placeholder=""> --}}
                                                </div>
                                                <div class="mb-2">
                                                    <p class="contact-card-details-head">Contact Owner</p>
                                                    <p class="contact-card-details-para">
                                                        {{ $customer_contact->creator->name ?? '---' }}</p>
                                                </div>
                                                {{--                                                <div class="mb-4"> --}}
                                                {{--                                                    <p class="contact-card-details-head">Last contacted</p> --}}
                                                {{--                                                    <input class="contact-details-input-fields " type="text" --}}
                                                {{--                                                           placeholder=""> --}}
                                                {{--                                                </div> --}}
                                                {{--                                                <div class="mb-4"> --}}
                                                {{--                                                    <div class=""> --}}
                                                {{--                                                        <button --}}
                                                {{--                                                            class="custom-contact-detail-dropdown dropdown-toggle" --}}
                                                {{--                                                            type="button" id="dropdownMenuButtonlead" --}}
                                                {{--                                                            data-bs-toggle="dropdown" aria-expanded="false"> --}}
                                                {{--                                                            Lead --}}
                                                {{--                                                        </button> --}}
                                                {{--                                                        <ul class="dropdown-menu custom-contact-detail-dropdown-show" --}}
                                                {{--                                                            aria-labelledby="dropdownMenuButtonlead"> --}}
                                                {{--                                                            <li><a class="dropdown-item" href="#">Action</a> --}}
                                                {{--                                                            </li> --}}
                                                {{--                                                            <li><a class="dropdown-item" href="#">Another --}}
                                                {{--                                                                    action</a> --}}
                                                {{--                                                            </li> --}}
                                                {{--                                                            <li><a class="dropdown-item" href="#">Something else --}}
                                                {{--                                                                    here</a> --}}
                                                {{--                                                            </li> --}}
                                                {{--                                                        </ul> --}}
                                                {{--                                                    </div> --}}
                                                {{--                                                </div> --}}
                                            </div>
                                        </div>

                                        {{--                                        <div class="collpase-divider mb-3 mt-3"></div> --}}


                                        {{--                                        <div class="collapse-header-prent-box"> --}}
                                        {{--                                            <div class="collapse-header-box"> --}}

                                        {{--                                                <button class="btn custom-btn-collapse" type="button" --}}
                                        {{--                                                        data-bs-toggle="collapse" --}}
                                        {{--                                                        data-bs-target="#collapseExamplesubscriptions" --}}
                                        {{--                                                        aria-expanded="true" --}}
                                        {{--                                                        aria-controls="collapseExamplesubscriptions"> --}}
                                        {{--                                                    <i class="fa fa-caret-down" aria-hidden="true" --}}
                                        {{--                                                       style="padding-right: 5px;"></i> --}}
                                        {{--                                                    Communication subscriptions --}}
                                        {{--                                                </button> --}}
                                        {{--                                            </div> --}}
                                        {{--                                        </div> --}}

                                        {{--                                        <div class="collapse" id="collapseExamplesubscriptions"> --}}
                                        {{--                                            <div class="card custom-contact-cards card-body"> --}}
                                        {{--                                                <p class="contact-card-subscription-para"> --}}
                                        {{--                                                    Use subscription types to manage the communication this --}}
                                        {{--                                                    contact --}}
                                        {{--                                                    receives --}}
                                        {{--                                                    from you --}}
                                        {{--                                                </p> --}}
                                        {{--                                                <a href="#" class="view-subscription-link"> --}}
                                        {{--                                                    <span>View Subscription</span> --}}
                                        {{--                                                </a> --}}
                                        {{--                                            </div> --}}
                                        {{--                                        </div> --}}

                                        {{--                                        <div class="collpase-divider mb-3 mt-3"></div> --}}
                                        {{--                                        <div class="collapse-header-prent-box"> --}}
                                        {{--                                            <div class="collapse-header-box"> --}}

                                        {{--                                                <button class="btn custom-btn-collapse" type="button" --}}
                                        {{--                                                        data-bs-toggle="collapse" data-bs-target="#collapseExampleweb" --}}
                                        {{--                                                        aria-expanded="true" aria-controls="collapseExampleweb"> --}}
                                        {{--                                                    <i class="fa fa-caret-down" aria-hidden="true" --}}
                                        {{--                                                       style="padding-right: 5px;"></i> --}}
                                        {{--                                                    Website Activity --}}
                                        {{--                                                </button> --}}
                                        {{--                                            </div> --}}
                                        {{--                                        </div> --}}

                                        <div class="collapse" id="collapseExampleweb">
                                            <div class="card custom-contact-cards card-body">
                                                <p class="contact-card-subscription-para">
                                                    Use subscription types to manage the communication this contact
                                                    receives from you
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6 p-0">

                            <div class="custom-tabs-row custom-tabs-row-scroll">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    {{--                                    <li class="nav-item" role="presentation"> --}}
                                    {{--                                        <button class="nav-link main-tabs-view active" id="home-tab" --}}
                                    {{--                                                data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" --}}
                                    {{--                                                aria-controls="home" aria-selected="true">Overview --}}
                                    {{--                                        </button> --}}
                                    {{--                                    </li> --}}
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link main-tabs-view active" id="profile-tab"
                                                data-bs-toggle="tab"
                                                data-bs-target="#profile" type="button" role="tab"
                                                aria-controls="profile"
                                                aria-selected="true">Activities
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    {{--                                    <div class="tab-pane fade active show" id="home" role="tabpanel" --}}
                                    {{--                                         aria-labelledby="home-tab"> --}}
                                    {{--                                        <div> --}}

                                    {{--                                            <div class="data-highlights"> --}}
                                    {{--                                                <div class="data-top-heading-header"> --}}
                                    {{--                                                    <h2>Data highlights</h2> --}}
                                    {{--                                                    <p class="contact-card-details-head">12/03/2024 4:48 PM --}}
                                    {{--                                                        GMT+5 --}}
                                    {{--                                                    </p> --}}
                                    {{--                                                </div> --}}
                                    {{--                                                <div class="data-row"> --}}
                                    {{--                                                    <div> --}}
                                    {{--                                                        <h5>CREATE DATE</h5> --}}
                                    {{--                                                        <p>{{$customer_contact->created_at}}</p> --}}
                                    {{--                                                    </div> --}}
                                    {{--                                                    <div> --}}
                                    {{--                                                        <h5>LIFECYCLE STAGE</h5> --}}
                                    {{--                                                        <p>Lead</p> --}}
                                    {{--                                                    </div> --}}
                                    {{--                                                    <div> --}}
                                    {{--                                                        <h5>LAST ACTIVITY DATE</h5> --}}
                                    {{--                                                        <p>12/03/2024 4:48 PM GMT+5</p> --}}
                                    {{--                                                    </div> --}}
                                    {{--                                                </div> --}}
                                    {{--                                            </div> --}}
                                    {{--                                            <div class="recent-activities"> --}}

                                    {{--                                                <div class="activity"> --}}
                                    {{--                                                    <h2>Recent activities</h2> --}}
                                    {{--                                                    <div> --}}
                                    {{--                                                        <p class="recent-filters"> Filter by: <span --}}
                                    {{--                                                                class="activities-seprater">7 --}}
                                    {{--                                                                    activities</span></p> --}}
                                    {{--                                                    </div> --}}
                                    {{--                                                    <div class="email-box-container"> --}}
                                    {{--                                                        <div class="activ_head" --}}
                                    {{--                                                             onclick="toggleContent('toggledContent1')"> --}}
                                    {{--                                                            <div class="email-child-wrapper"> --}}
                                    {{--                                                                <i class="fa fa-caret-right" aria-hidden="true"></i> --}}
                                    {{--                                                                <i class="fa fa-envelope-o new-sidebar-icons" --}}
                                    {{--                                                                   aria-hidden="true"></i> --}}

                                    {{--                                                                <p> --}}
                                    {{--                                                                    Inbound email from --}}
                                    {{--                                                                    <span --}}
                                    {{--                                                                        class="activities-seprater">{{$customer_contact->name}}</span> --}}
                                    {{--                                                                </p> --}}
                                    {{--                                                            </div> --}}
                                    {{--                                                            <p class="usre_date">Dec 3, 2024 at 4:48 PM GMT+5 --}}
                                    {{--                                                            </p> --}}
                                    {{--                                                        </div> --}}

                                    {{--                                                        <div class="collpase-divider mt-2 mb-2"></div> --}}


                                    {{--                                                        <div> --}}
                                    {{--                                                            <div class="contact-us-text"> --}}
                                    {{--                                                                <p>contact us</p> --}}

                                    {{--                                                            </div> --}}
                                    {{--                                                            <div class="user_profile-hidden" id="toggledContent1"> --}}
                                    {{--                                                                <div class="user_profile_img"> --}}
                                    {{--                                                                    <div class="avatarr">MM</div> --}}
                                    {{--                                                                </div> --}}
                                    {{--                                                                <div class="user_profile_text"> --}}
                                    {{--                                                                    <p>Mike Stewar mikestewar1932@outlook.com --}}
                                    {{--                                                                    </p> --}}
                                    {{--                                                                    <p style="font-weight: 500">to --}}
                                    {{--                                                                        info@phototouchexpert.com --}}
                                    {{--                                                                    </p> --}}
                                    {{--                                                                </div> --}}
                                    {{--                                                            </div> --}}
                                    {{--                                                        </div> --}}
                                    {{--                                                        <div class="user_cont"> --}}
                                    {{--                                                            <p> --}}
                                    {{--                                                                Hi there, I hope you're doing well. I specialize --}}
                                    {{--                                                                in --}}
                                    {{--                                                                online reputation management and can help boost --}}
                                    {{--                                                                your --}}
                                    {{--                                                                business's presence by generating positive --}}
                                    {{--                                                                reviews --}}
                                    {{--                                                                and --}}
                                    {{--                                                                addressing any negative feedback. --}}
                                    {{--                                                            </p> --}}
                                    {{--                                                        </div> --}}


                                    {{--                                                        <div> --}}
                                    {{--                                                            <div class="comment-active_head" id="toggledContent1"> --}}


                                    {{--                                                                <div> --}}

                                    {{--                                                                    <div class="email-child-wrapper" --}}
                                    {{--                                                                         id="toggleButton"> --}}
                                    {{--                                                                        <i class="fa fa-commenting-o add-coment-icon" --}}
                                    {{--                                                                           aria-hidden="true"></i> --}}
                                    {{--                                                                        <span class="activities-addition-links">Add --}}
                                    {{--                                                                                Comments</span> --}}
                                    {{--                                                                    </div> --}}


                                    {{--                                                                    <div id="contents" class="hidden comment-box"> --}}
                                    {{--                                                                        <div class="editor-container"> --}}
                                    {{--                                                                            <div class="avatarr">MM</div> --}}
                                    {{--                                                                            <div> --}}
                                    {{--                                                                                <!-- editor --> --}}

                                    {{--                                                                                <!-- <div class="editor-container"> --}}
                                    {{--                                                                            <button --}}
                                    {{--                                                                                class="your-create-contact create-contact">comment</button> --}}
                                    {{--                                                                            <button --}}
                                    {{--                                                                                class="your-comment-cancel">Cancel</button> --}}
                                    {{--                                                                        </div> --> --}}
                                    {{--                                                                            </div> --}}
                                    {{--                                                                        </div> --}}
                                    {{--                                                                    </div> --}}
                                    {{--                                                                </div> --}}


                                    {{--                                                                <button type="button" --}}
                                    {{--                                                                        class="dropdown-toggle custom-drop-btn-design" --}}
                                    {{--                                                                        id="dropdownMenuButtonassociate" --}}
                                    {{--                                                                        data-bs-toggle="dropdown" --}}
                                    {{--                                                                        aria-expanded="false"> --}}
                                    {{--                                                                    3 --}}
                                    {{--                                                                    association --}}
                                    {{--                                                                </button> --}}
                                    {{--                                                                <ul class="dropdown-menu" --}}
                                    {{--                                                                    aria-labelledby="dropdownMenuButtonassociate"> --}}
                                    {{--                                                                    <div> --}}

                                    {{--                                                                        <div --}}
                                    {{--                                                                            class="dropdown-content-wraper"> --}}
                                    {{--                                                                            <ul --}}
                                    {{--                                                                                class="nested-select-list"> --}}
                                    {{--                                                                                <li --}}
                                    {{--                                                                                    class="checkbox-item"> --}}

                                    {{--                                                                                    <label>Companies --}}
                                    {{--                                                                                        0</label> --}}
                                    {{--                                                                                </li> --}}
                                    {{--                                                                                <li --}}
                                    {{--                                                                                    class="checkbox-item"> --}}

                                    {{--                                                                                    <label>Carts --}}
                                    {{--                                                                                        0</label> --}}
                                    {{--                                                                                </li> --}}
                                    {{--                                                                                <li --}}
                                    {{--                                                                                    class="checkbox-item"> --}}

                                    {{--                                                                                    <label>Contacts --}}
                                    {{--                                                                                        0</label> --}}
                                    {{--                                                                                </li> --}}
                                    {{--                                                                                <li --}}
                                    {{--                                                                                    class="checkbox-item"> --}}

                                    {{--                                                                                    <label>Leads --}}
                                    {{--                                                                                        0</label> --}}
                                    {{--                                                                                </li> --}}
                                    {{--                                                                                <li --}}
                                    {{--                                                                                    class="checkbox-item"> --}}

                                    {{--                                                                                    <label>Deals --}}
                                    {{--                                                                                        0</label> --}}
                                    {{--                                                                                </li> --}}
                                    {{--                                                                                <li --}}
                                    {{--                                                                                    class="checkbox-item"> --}}

                                    {{--                                                                                    <label>Orders --}}
                                    {{--                                                                                        0</label> --}}
                                    {{--                                                                                </li> --}}
                                    {{--                                                                                <!-- Add more items as needed --> --}}
                                    {{--                                                                            </ul> --}}
                                    {{--                                                                            <div> --}}
                                    {{--                                                                                <div --}}
                                    {{--                                                                                    class="search-box-select"> --}}
                                    {{--                                                                                    <input --}}
                                    {{--                                                                                        type="text" --}}
                                    {{--                                                                                        placeholder="Search current associations" --}}
                                    {{--                                                                                        class="search-input"> --}}
                                    {{--                                                                                </div> --}}
                                    {{--                                                                                <div --}}
                                    {{--                                                                                    class="select-contact-box-space"> --}}
                                    {{--                                                                                    <p --}}
                                    {{--                                                                                        class="select-contact"> --}}
                                    {{--                                                                                        Contacts --}}
                                    {{--                                                                                    </p> --}}

                                    {{--                                                                                    <input --}}
                                    {{--                                                                                        type="checkbox" --}}
                                    {{--                                                                                        id="contact2"> --}}
                                    {{--                                                                                    <label --}}
                                    {{--                                                                                        for="contact2">HoeoSQMLp --}}
                                    {{--                                                                                        becelhmerthewatt@yahoo.com</label> --}}
                                    {{--                                                                                </div> --}}
                                    {{--                                                                            </div> --}}

                                    {{--                                                                        </div> --}}
                                    {{--                                                                    </div> --}}
                                    {{--                                                                </ul> --}}


                                    {{--                                                            </div> --}}
                                    {{--                                                            <div class="collpase-divider mt-2 mb-2"></div> --}}
                                    {{--                                                            <div class=" mt-2 mb-2"> --}}
                                    {{--                                                                <a href="#" class="activities-addition-links">View --}}
                                    {{--                                                                    full --}}
                                    {{--                                                                    activity</a> --}}
                                    {{--                                                            </div> --}}
                                    {{--                                                        </div> --}}

                                    {{--                                                    </div> --}}
                                    {{--                                                </div> --}}


                                    {{--                                                <div class="activity"> --}}
                                    {{--                                                    <div class="association-activities-box"> --}}
                                    {{--                                                        <h2>Companies</h2> --}}
                                    {{--                                                        <div> --}}
                                    {{--                                                            <i class="fa fa-plus companies-add-forms open-form-btn" --}}
                                    {{--                                                               aria-hidden="true"> Add</i> --}}
                                    {{--                                                        </div> --}}

                                    {{--                                                    </div> --}}
                                    {{--                                                    <p class="user_cont text-center"> No associated objects of --}}
                                    {{--                                                        this --}}
                                    {{--                                                        type --}}
                                    {{--                                                        exist or you don't have permission to view them.</p> --}}
                                    {{--                                                </div> --}}

                                    {{--                                            </div> --}}
                                    {{--                                        </div> --}}
                                    {{--                                    </div> --}}


                                    <div class="tab-pane fade active show" id="profile" role="tabpanel"
                                         aria-labelledby="profile-tab">

                                        <div class="activ_head mt-3">

                                            <!-- Searchbox input -->
                                            <div class="search-containers">
                                                <form id="search-form" style="margin:0;">
                                                    <input type="text" class="search-inputs"
                                                           placeholder="Search activities" name="query">
                                                    <button class="search-btns">
                                                        <i class="fa fa-search" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <!-- dropdown  -->
                                            <div class="dropdown">
                                                {{--                                                <button class="new-activity-dropdown btn-secondary dropdown-toggle" --}}
                                                {{--                                                        type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" --}}
                                                {{--                                                        aria-expanded="false"> --}}
                                                {{--                                                    Collapse all --}}
                                                {{--                                                </button> --}}
                                                {{--                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"> --}}
                                                {{--                                                    <li><a class="dropdown-item" href="#">Action</a></li> --}}
                                                {{--                                                    <li><a class="dropdown-item" href="#">Another action</a> --}}
                                                {{--                                                    </li> --}}
                                                {{--                                                    <li><a class="dropdown-item" href="#">Something else --}}
                                                {{--                                                            here</a></li> --}}
                                                {{--                                                </ul> --}}
                                            </div>


                                        </div>

                                        <div class="custom-tabs-row">
                                            <ul class="nav nav-tabs newtabs-space" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link customize active" id="act-tab"
                                                            data-bs-toggle="tab" data-bs-target="#act" type="button"
                                                            role="tab" aria-controls="act" aria-selected="true">Activity
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link customize" id="notes-tab"
                                                            data-bs-toggle="tab" data-bs-target="#notes" type="button"
                                                            role="tab" aria-controls="notes" aria-selected="true">Notes
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link customize" id="emails-tab"
                                                            data-bs-toggle="tab" data-bs-target="#email" type="button"
                                                            role="tab" aria-controls="emails" aria-selected="true">
                                                        Emails
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link customize disabled" id="calls-tab"
                                                            data-bs-toggle="tab" data-bs-target="#act" type="button"
                                                            role="tab" aria-controls="calls" aria-selected="true">Calls
                                                    </button>
                                                </li>
                                                {{--                                                <li class="nav-item" role="presentation"> --}}
                                                {{--                                                    <button class="nav-link customize" id="email-tab" --}}
                                                {{--                                                            data-bs-toggle="tab" data-bs-target="#email" type="button" --}}
                                                {{--                                                            role="tab" aria-controls="email" aria-selected="false" --}}
                                                {{--                                                            tabindex="-1">Emails --}}
                                                {{--                                                    </button> --}}
                                                {{--                                                </li> --}}
                                                {{--                                                <li class="nav-item" role="presentation"> --}}
                                                {{--                                                    <button class="nav-link customize" id="call-tab" --}}
                                                {{--                                                            data-bs-toggle="tab" data-bs-target="#call" type="button" --}}
                                                {{--                                                            role="tab" aria-controls="call" aria-selected="false" --}}
                                                {{--                                                            tabindex="-1">Calls --}}
                                                {{--                                                    </button> --}}
                                                {{--                                                </li> --}}
                                                {{--                                                <li class="nav-item" role="presentation"> --}}
                                                {{--                                                    <button class="nav-link customize" id="task-tab" --}}
                                                {{--                                                            data-bs-toggle="tab" data-bs-target="#task" type="button" --}}
                                                {{--                                                            role="tab" aria-controls="task" aria-selected="false" --}}
                                                {{--                                                            tabindex="-1">Tasks --}}
                                                {{--                                                    </button> --}}
                                                {{--                                                </li> --}}
                                                {{--                                                <li class="nav-item" role="presentation"> --}}
                                                {{--                                                    <button class="nav-link customize" id="meeting-tab" --}}
                                                {{--                                                            data-bs-toggle="tab" data-bs-target="#meeting" type="button" --}}
                                                {{--                                                            role="tab" aria-controls="meeting" aria-selected="false" --}}
                                                {{--                                                            tabindex="-1">Meetings --}}
                                                {{--                                                    </button> --}}
                                                {{--                                                </li> --}}
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="act" role="tabpanel"
                                                     aria-labelledby="act-tab">
                                                    <div>
                                                        <div>
                                                            <p class="recent-filters"> Filter by:
                                                                <span class="activities-seprater">7
                                                                                                                                                                        activities</span>
                                                            </p>
                                                        </div>
                                                        <p class="date-by-order"> May 2021</p>
                @include('admin.customers.contacts.partials.notes-list')
                                                   <div class="recent-activities">
                                                        <div id="email-section">
                                                            @include('admin.customers.contacts.partials.emails-list')
                                                        </div>
                                                    </div>

                                                        
                                                        <div class="data-highlights">
                                                            <div class="data-top-heading-header">
                                                                <h2>Life Cycle</h2>
                                                                <p>12/03/2024 4:48 PM GMT+5</p>
                                                            </div>
                                                            <p class="user_cont"> No associated objects of this
                                                                type
                                                                exist or you don't have permission to view them.
                                                                <span class="activities-seprater"> View detail
                                                                                                                                                                        <i class="fa fa-external-link"
                                                                                                                                                                           aria-hidden="true"></i>
                                                                                                                                                                    </span>
                                                            </p>
                                                        </div>

                                                        <div class="recent-activities">


                                                            <div class="email-box-container ">
                                                                <div class="toggle-btnss">
                                                                    <div class="activ_head ">
                                                                        <div class="email-child-wrapper">
                                                                            <i class="fa fa-caret-right"
                                                                               aria-hidden="true"></i>
                                                                            <di>
                                                                                <h2>
                                                                                    Email - #Professional Image
                                                                                    Editing
                                                                                    <span class="user_cont">from
                                                                                                                                                                                                                                                                            Harry
                                                                                                                                                                                                                                                                            Brown</span>
                                                                                </h2>
                                                                                <p class="user_cont">from Harry
                                                                                    Brown</p>
                                                                            </di>
                                                                        </div>
                                                                        <p>12/03/2024 4:48 PM GMT+5</p>
                                                                    </div>
                                                                </div>


                                                                <div>
                                                                    <!-- <div class="contact-us-text">
                                                                    --
                                                                </div> -->
                                                                    <div class="contentdisplay ">

                                                                        <div class="new-profile-parent-wrapper">
                                                                            <div class="new-profile-email-wrapper">
                                                                                <div class="user_profile_img">
                                                                                    <div class="avatarr">MS
                                                                                    </div>
                                                                                </div>
                                                                                <div class="user_profile_text">
                                                                                    <p>Mike Stewar</p>
                                                                                    <p style="font-weight: 500">
                                                                                        --
                                                                                    </p>
                                                                                </div>
                                                                            </div>

                                                                            <div
                                                                                class="new-profile-email-wrapper open-email-form"
                                                                                style="position: relative">
                                                                                <div class="activities-seprater ">
                                                                                    Reply
                                                                                </div>

                                                                                <div
                                                                                    class="activities-seprater open-form-btn">
                                                                                    Forward
                                                                                </div>
                                                                                <div
                                                                                    class="activities-seprater open-form-btn">
                                                                                    Delete
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- <div class="user_profile-hidden activ_head "
                                                                    id="toggledContent01">
                                                                    <div class="">
                                                                        <div class="user_profile_img">
                                                                            <div class="avatarr">MM</div>
                                                                        </div>
                                                                        <div class="user_profile_text">
                                                                            <p>Mike Stewar mikestewar1932@outlook.com
                                                                            </p>
                                                                            <p style="font-weight: 500">--
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <i class="fa fa-plus companies-add-forms open-form-btn"
                                                                            aria-hidden="true"> Add</i>
                                                                    </div>
                                                                </div> -->
                                                                </div>
                                                                <div class="user_cont user-email-template">
                                                                    <p>
                                                                        Hi, <br> I hope you're doing well. I
                                                                        specialize
                                                                        in
                                                                        online reputation management and can
                                                                        help
                                                                        boost
                                                                        your
                                                                        business's presence by generating
                                                                        positive
                                                                        reviews
                                                                        and
                                                                        addressing any negative feedback.
                                                                    </p>
                                                                </div>
                                                                <!-- <div class="user_cont-toggler">
                                                                <p>
                                                                    Hi, <br> I hope you're doing well. I specialize in
                                                                    online reputation management and can help boost your
                                                                    business's presence by generating positive reviews
                                                                    and
                                                                    addressing any negative feedback.
                                                                </p>
                                                            </div> -->


                                                            </div>

                                                            <div class="data-highlights">
                                                                <div class="data-top-heading-header">
                                                                    <h2>Life Cycle</h2>
                                                                    <p>This contact was created </p>
                                                                </div>
                                                                <p class="user_cont"> No associated objects of
                                                                    this
                                                                    type
                                                                    exist or you don't have permission to view
                                                                    them.
                                                                    <span class="activities-seprater"> View
                                                                                                                                                                            detail
                                                                                                                                                                            <i class="fa fa-external-link"
                                                                                                                                                                               aria-hidden="true"></i>
                                                                                                                                                                        </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="notes" role="tabpanel"
                                                     aria-labelledby="notes-tab">
                                                    <div class="email-threading-row">
                                                        <button class="threading-email-btn-two" data-bs-toggle="modal"
                                                                data-bs-target="#addNoteModal">
                                                            Create Notes
                                                        </button>
                                                    </div>
                                                    <p class="date-by-order">{{ \Carbon\Carbon::now()->format('F Y') }}</p>

                                                    {{-- @if($customer_contact->notes->count() > 0)
                                                        @foreach($customer_contact->notes as $noteKey => $note)
                                                            <div class="data-highlights">
                                                                <div class="cstm_note">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="data-top-heading-header">
                                                                                <h2>Note</h2>
                                                                                <p>
                                                                                    {{ $note->created_at
                                                                                        ? \Carbon\Carbon::parse($note->created_at)->timezone('Asia/Karachi')->format('M j, Y \a\t g:i A \G\M\TP')
                                                                                        : '---' }}
                                                                                </p>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Edit & Delete Icons -->
                                                                <div class="cstm_note_2">
                                                                    <div class="row">
                                                                        <div class="col-md-12 cstm_note_cont">
                                                                            <p class="user_cont"
                                                                               id="note-text-{{$note->id}}">
                                                                                {{ $note->note ?? "No Note Available" }}
                                                                            </p>
                                                                            <div class="cstm_right_icon">
                                                                                <!-- Edit Icon -->
                                                                                <button class="p-0 border-0 cstm_btn">
                                                                                    <i class="fas fa-edit me-2 editNoteModal"
                                                                                       style="cursor: pointer;"
                                                                                       data-bs-toggle="modal"
                                                                                       data-bs-target="#editNoteModal"
                                                                                       data-id="{{$note->id}}"
                                                                                       data-note="{{$note->note}}"></i>
                                                                                </button>
                                                                                <!-- Delete Form -->
                                                                                <form
                                                                                    action="{{ route('admin.customer.contact.note.delete', $note->id) }}"
                                                                                    method="POST"
                                                                                    class="deleteNoteForm">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit"
                                                                                            class="p-0 border-0 cstm_btn">
                                                                                        <i class="fas fa-trash"></i>
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="note-para">
                                                            Take notes about this record to keep track of important
                                                            info.
                                                            You can even @mention a teammate if you need to.
                                                        </p>
                                                    @endif --}}
                @include('admin.customers.contacts.partials.notes-list')

                                                    
                                                </div>


                                                <!-- Keep your existing HTML for other parts of the edit page -->
                                                @include('admin.customers.contacts.components.email')



                                                {{-- <div class="tab-pane fade" id="call" role="tabpanel" --}}
                                                {{--                                                     aria-labelledby="call-tab"> --}}
                                                {{--                                                    <div class="email-threading-row"> --}}

                                                {{--                                                        <button class="threading-email-btn-two"> --}}
                                                {{--                                                            Make a call --}}
                                                {{--                                                        </button> --}}
                                                {{--                                                    </div> --}}
                                                {{--                                                    <div class="data-highlights"> --}}
                                                {{--                                                        <div class="data-top-heading-header"> --}}
                                                {{--                                                            <h2>Life Cycle</h2> --}}
                                                {{--                                                            <p>This contact was created </p> --}}
                                                {{--                                                        </div> --}}
                                                {{--                                                        <p class="user_cont"> No associated objects of this --}}
                                                {{--                                                            type --}}
                                                {{--                                                            exist or you don't have permission to view them. --}}
                                                {{--                                                            <span class="activities-seprater"> View detail <i --}}
                                                {{--                                                                    class="fa fa-external-link" --}}
                                                {{--                                                                    aria-hidden="true"></i> --}}
                                                {{--                                                                </span> --}}
                                                {{--                                                        </p> --}}
                                                {{--                                                    </div> --}}
                                                {{--                                                </div> --}}

                                                {{--                                                <div class="tab-pane fade" id="task" role="tabpanel" --}}
                                                {{--                                                     aria-labelledby="task-tab"> --}}
                                                {{--                                                    <div class="email-threading-row"> --}}

                                                {{--                                                        <button class="threading-email-btn-two"> --}}
                                                {{--                                                            Create a Task --}}
                                                {{--                                                        </button> --}}
                                                {{--                                                    </div> --}}
                                                {{--                                                    <div class="data-highlights"> --}}
                                                {{--                                                        <div class="data-top-heading-header"> --}}
                                                {{--                                                            <h2>Life Cycle</h2> --}}
                                                {{--                                                            <p>This contact was created </p> --}}
                                                {{--                                                        </div> --}}
                                                {{--                                                        <p class="user_cont"> No associated objects of this --}}
                                                {{--                                                            type --}}
                                                {{--                                                            exist or you don't have permission to view them. --}}
                                                {{--                                                            <span class="activities-seprater"> View detail <i --}}
                                                {{--                                                                    class="fa fa-external-link" --}}
                                                {{--                                                                    aria-hidden="true"></i> --}}
                                                {{--                                                                </span> --}}
                                                {{--                                                        </p> --}}
                                                {{--                                                    </div> --}}

                                                {{--                                                </div> --}}

                                                {{--                                                <div class="tab-pane fade" id="meeting" role="tabpanel" --}}
                                                {{--                                                     aria-labelledby="meeting-tab"> --}}
                                                {{--                                                    <div class="email-threading-row"> --}}

                                                {{--                                                        <button class="threading-email-btn-two"> --}}
                                                {{--                                                            Call a Meeting --}}
                                                {{--                                                        </button> --}}
                                                {{--                                                    </div> --}}
                                                {{--                                                    <div class="data-highlights"> --}}
                                                {{--                                                        <div class="data-top-heading-header"> --}}
                                                {{--                                                            <h2>Life Cycle</h2> --}}
                                                {{--                                                            <p>This contact was created </p> --}}
                                                {{--                                                        </div> --}}
                                                {{--                                                        <p class="user_cont"> No associated objects of this --}}
                                                {{--                                                            type --}}
                                                {{--                                                            exist or you don't have permission to view them. --}}
                                                {{--                                                            <span class="activities-seprater"> View detail <i --}}
                                                {{--                                                                    class="fa fa-external-link" --}}
                                                {{--                                                                    aria-hidden="true"></i> --}}
                                                {{--                                                                </span> --}}
                                                {{--                                                        </p> --}}
                                                {{--                                                    </div> --}}

                                                {{--                                                </div> --}}
                                            </div>
                                        </div>


                                    </div>

                                </div>
                            </div>

                            <div class="main">
                            </div>
                        </div>
                        <div class="col-lg-3 ps-0">

                            <div class="right-sidebarr">
                                <div class="collaborators ">

                                    <div class="right_collaboratrs-box">
                                        <div class="collapse-header-prent-box">
                                            <div class="collapse-header-box">

                                                <button class="btn custom-btn-collapse toggle-collapse" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseExample"
                                                        aria-expanded="true" aria-controls="collapseExample">
                                                    <i class="fa fa-chevron-down toggle-icon"
                                                       style="padding-right: 5px;"
                                                       aria-hidden="true"></i>
                                                    Company
                                                    <span> ( {{ $customer_contact->companies->count() }} )</span>
                                                </button>
                                            </div>

                                        </div>

                                        {{--                                        <div class="right_collab open-form-btn"> --}}
                                        {{--                                            <i class="fa fa-plus create-contact open-form-btn" aria-hidden="true"> --}}
                                        {{--                                            </i> --}}
                                        {{--                                            <span>Add</span> --}}
                                        {{--                                        </div> --}}

                                    </div>
                                    <div class="collapse show" id="collapseExample">
                                        <div class="card custom-collapse-cards card-body">
                                            <div class="col-md-12">
                                                <div class="company_sec">
                                                    <span>Name : {{ $customer_contact->company->name ?? '---' }}</span>
                                                    {{--                                                   <span>Domain : {{($customer_contact->company)->domain ?? "---"}}</span> --}}
                                                    <span> Domain :
                                                        @if (!empty($customer_contact->company->domain))
                                                            <a href="https://{{ $customer_contact->company->domain }}"
                                                               target="_blank">
                                                                {{ $customer_contact->company->domain }}
                                                            </a>
                                                        @else
                                                            ---
                                                        @endif
                                                    </span>
                                                    <span>Phone No :
                                                        {{ $customer_contact->company->phone ?? '---' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="collpase-divider mt-2 mb-2"></div>


                                    <div class="right_collaboratrs-box">
                                        <div class="collapse-header-prent-box">
                                            <div class="collapse-header-box">

                                                <button class="btn custom-btn-collapse toggle-collapse" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseExamplepayment"
                                                        aria-expanded="true" aria-controls="collapseExamplepayment">
                                                    <i class="fa fa-chevron-down toggle-icon"
                                                       style="padding-right: 5px;"
                                                       aria-hidden="true"></i>
                                                    Payments <span> ( {{ $customer_contact->payments->count() ?? '---' }} )
                                                    </span>
                                                </button>
                                            </div>

                                        </div>
                                        {{--                                        <div class="right_collab open-form-btn"> --}}
                                        {{--                                            <i class="fa fa-plus create-contact " aria-hidden="true"> </i> --}}
                                        {{--                                            <span>Add</span> --}}
                                        {{--                                        </div> --}}
                                    </div>

                                    <div class="collapse show" id="collapseExamplepayment">
                                        <div class="card custom-collapse-cards card-body">

                                            <div class="col-md-12">
                                                @if ($customer_contact->payments->count() == 0)
                                                    <p class="para_sec">Track payments associated with this record. A
                                                        payment is created when a customer pays or a recurring payment
                                                        is processed through CRM.

                                                    </p>
                                                @else
                                                    @foreach ($customer_contact->payments as $index => $payment)
                                                        <div
                                                            class=" invoice_sec {{ $index >= 2 ? 'extra-payment d-none' : '' }}">
                                                            <span
                                                                class="invoice_num">{{ optional($payment->invoice)->invoice_number ?? '---' }}


                                                                @if ($payment->status == 0)
                                                                    <span
                                                                        class="badge bg-warning text-dark cstm_bdge">Due</span>
                                                                @elseif($payment->status == 1)
                                                                    <span class="badge bg-success cstm_bdge">Paid</span>
                                                                @elseif($payment->status == 2)
                                                                    <span
                                                                        class="badge bg-danger cstm_bdge">Refund</span>
                                                                @elseif($payment->status == 3)
                                                                    <span class="badge bg-primary cstm_bdge">Charge
                                                                        Back</span>
                                                                @endif
                                                            </span>
                                                            <span>TXIDs : {{ $payment->transaction_id ?? '---' }}</span>
                                                            <span>Brand : {{ optional($payment->brand)->name }}</span>
                                                            <span>Method : {{ $payment->payment_method ?? '---' }}</span>
                                                            <span>Amount : {{ $payment->amount }}$

                                                            </span>
                                                            <span data-toggle="tooltip" title="Due Date">
                                                                Due:
                                                                {{ $payment->payment_date->format('d M Y') ?? '---' }}
                                                            </span>

                                                            <span data-toggle="tooltip" title="Create Date">Date :
                                                                {{ $payment->created_at->format('d M Y') ?? '---' }}</span>
                                                        </div>
                                                    @endforeach

                                                @endif
                                            </div>
                                            @if (count($customer_contact->payments) > 2)
                                                <div class="text-center show_btn">
                                                    <button class="showhide-payment">See More</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="collpase-divider mt-2 mb-2"></div>

                                    <div class="right_collaboratrs-box">
                                        <div class="collapse-header-prent-box">
                                            <div class="collapse-header-box">

                                                <button class="btn custom-btn-collapse toggle-collapse" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseExampleinvoice"
                                                        aria-expanded="true" aria-controls="collapseExampleinvoice">
                                                    <i class="fa fa-chevron-down toggle-icon"
                                                       style="padding-right: 5px;"
                                                       aria-hidden="true"></i>
                                                    Invoices <span> ({{ $customer_contact->invoices->count() }}) </span>
                                                </button>
                                            </div>

                                        </div>
                                        {{--                                        <div class="right_collab open-form-btn"> --}}
                                        {{--                                            <i class="fa fa-plus create-contact " aria-hidden="true"> </i> --}}
                                        {{--                                            <span>Add</span> --}}
                                        {{--                                        </div> --}}
                                    </div>

                                    <div class="collapse show" id="collapseExampleinvoice">
                                        <div class="card custom-collapse-cards card-body">
                                            <div class="col-md-12">
                                                @if ($customer_contact->invoices->count() == 0)
                                                    <p class="para_sec">Send your customer a request for payment and
                                                        associate it with this record.</p>
                                                @else
                                                    @foreach ($customer_contact->invoices as $index => $invoice)
                                                        <div
                                                            class="invoice_sec {{ $index >= 2 ? 'extra-invoice d-none' : '' }}">
                                                            <span class="invoice_num">
                                                                {{ $invoice->invoice_number ?? '---' }}
                                                                @if ($invoice->status == 0)
                                                                    <span class="badge bg-warning cstm_bdge">Due</span>
                                                                @elseif($invoice->status == 1)
                                                                    <span class="badge bg-success cstm_bdge">Paid</span>
                                                                @elseif($invoice->status == 2)
                                                                    <span
                                                                        class="badge bg-danger cstm_bdge">Refund</span>
                                                                @elseif($invoice->status == 3)
                                                                    <span class="badge bg-primary cstm_bdge">Charge
                                                                        Back</span>
                                                                @endif
                                                            </span>
                                                            <span>Brand : {{ optional($invoice->brand)->name }} </span>
                                                            <span>
                                                                Amount : {{ $invoice->total_amount }}$
                                                                @if ($invoice->taxable == 1)
                                                                    (Incl. Tax {{ $invoice->tax_value }}%)
                                                                @endif
                                                            </span>
                                                            <span data-toggle="tooltip" title="Due Date">Due :
                                                                {{ $invoice->due_date ?? '---' }}</span>
                                                            <span data-toggle="tooltip" title="Create Date">Date :
                                                                {{ $invoice->created_at->format('d M Y') ?? '---' }}</span>
                                                        </div>
                                                    @endforeach

                                                @endif
                                            </div>

                                            @if (count($customer_contact->invoices) > 2)
                                                <div class="text-center show_btn">
                                                    <button class="showhide-invoice">See More</button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="collapse " id="collapseExamplepay">
                                        <div class="card custom-collapse-cards card-body">
                                            <p class="contact-card-subscription-para">
                                                Give customers a fast, flexible way to pay. Add a payment link to accept
                                                a
                                                payment and associate it with this record.
                                            </p>
                                            <div class="main-payment-btn-wrapper ">
                                                <button class="set-payment-btn">Set up Payments</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="collpase-divider mt-2 mb-2"></div>


                                    {{--                                    <div class="right_collaboratrs-box"> --}}
                                    {{--                                        <div class="collapse-header-prent-box"> --}}
                                    {{--                                            <div class="collapse-header-box"> --}}

                                    {{--                                                <button class="btn custom-btn-collapse" type="button" --}}
                                    {{--                                                        data-bs-toggle="collapse" data-bs-target="#collapseExampleatt" --}}
                                    {{--                                                        aria-expanded="true" aria-controls="collapseExampleatt"> --}}
                                    {{--                                                    <i class="fa fa-caret-down" style="padding-right: 5px;" --}}
                                    {{--                                                       aria-hidden="true"></i> --}}
                                    {{--                                                    Attachments --}}
                                    {{--                                                </button> --}}
                                    {{--                                            </div> --}}

                                    {{--                                        </div> --}}

                                    {{--                                        <div class="right_collab open-form-btn"> --}}
                                    {{--                                            <i class="fa fa-plus create-contact open-form-btn" aria-hidden="true"> --}}
                                    {{--                                            </i> --}}
                                    {{--                                            <span>Add</span> --}}
                                    {{--                                        </div> --}}

                                    {{--                                    </div> --}}
                                    {{--                                    <div class="collapse " id="collapseExampleatt"> --}}
                                    {{--                                        <div class="card custom-collapse-cards card-body"> --}}
                                    {{--                                            <p class="contact-card-subscription-para"> --}}
                                    {{--                                                See the businesses or organizations associated with this record. --}}
                                    {{--                                            </p> --}}
                                    {{--                                        </div> --}}
                                    {{--                                    </div> --}}

                                    {{--                                    <div class="collpase-divider mt-2 mb-2"></div> --}}

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>


    @include('admin.customers.contacts.notes-add-modal')
    @include('admin.customers.contacts.notes-edit-modal')
    @include('admin.customers.companies.custom-form')
    @include('admin.customers.contacts.email-template')

    @push('script')
        @include('admin.customers.companies.script')

        {{--        MY SCRIPT --}}
        <script>
            $(document).ready(function () {
                $('.showhide-payment, .showhide-invoice').click(function () {
                    // Determine which type: "payment" or "invoice"
                    let type = $(this).hasClass('showhide-payment') ? 'payment' : 'invoice';

                    // Find the matching hidden elements
                    let $extradata = $('.extra-' + type);

                    if ($extradata.is(':visible')) {
                        $extradata.addClass('d-none');
                        $(this).text('See More');
                    } else {
                        $extradata.removeClass('d-none');
                        $(this).text('See Less');
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function () {
                $('.toggle-collapse').each(function () {
                    var $button = $(this);
                    var target = $button.data('bs-target'); // Get target id from data-bs-target
                    var $collapse = $(target);

                    // On show event
                    $collapse.on('show.bs.collapse', function () {
                        $button.find('.toggle-icon').removeClass('fa-chevron-right').addClass(
                            'fa-chevron-down');
                    });

                    // On hide event
                    $collapse.on('hide.bs.collapse', function () {
                        $button.find('.toggle-icon').removeClass('fa-chevron-down').addClass(
                            'fa-chevron-right');
                    });
                });
            });
        </script>
        <script>
            // Function to toggle the visibility of the additional content div
            function toggleContent(contentId) {
                var contentDiv = document.getElementById(contentId);
                // Toggle the display property (show/hide)
                if (contentDiv.style.display === "none" || contentDiv.style.display === "") {
                    contentDiv.style.display = "flex"; // Show the content
                } else {
                    contentDiv.style.display = "none"; // Hide the content
                }
            }

            // Second comment function
            $(document).ready(function () {
                $('#toggleButton').click(function () {
                    const contents = $('#contents');
                    if (contents.hasClass('hidden')) {
                        contents.removeClass('hidden');
                        $(this).find('span').text('Hide Comment');
                    } else {
                        contents.addClass('hidden');
                        $(this).find('span').text('Add Comments');
                    }
                });
            });
            // select to function
            $(document).ready(function () {
                // Toggle dropdown visibility
                $(".dropdown-toggle").on("click", function () {
                    $(".dropdown-content").toggle();
                });
                // Filter list based on search input
                $(".search-input").on("input", function () {
                    const filter = $(this).val().toLowerCase();
                    $(".checkbox-item").each(function () {
                        const label = $(this).find("label").text().toLowerCase();
                        $(this).toggle(label.includes(filter));
                    });
                });
                // Close dropdown if clicked outside
                $(document).on("click", function (e) {
                    if (!$(e.target).closest(".dropdown").length) {
                        $(".dropdown-content").hide();
                    }
                });
            });
            // $('select>option:eq(3)').attr('selected', true);
            // Searching Input function
            $(document).ready(function () {
                // Expand and collapse the search bar
                $(".search-btns").on("click", function (e) {
                    e.preventDefault(); // Prevent form submission on button click
                    $(".search-containers").toggleClass("expanded");
                    $(".search-inputs").focus();
                });
                // Handle form submission for search
                $("#search-form").on("submit", function (e) {
                    e.preventDefault(); // Prevent default form submission
                    const query = $(".search-inputs").val().trim();
                    if (query) {
                        // Log the search query or perform an action
                        console.log("Searching for:", query);
                        // Redirect or process search here
                        // Example: window.location.href = `/search?q=${encodeURIComponent(query)}`;
                    } else {
                        alert("Please enter a search term.");
                    }
                });
                // Collapse the search bar when clicking outside
                $(document).on("click", function (e) {
                    if (!$(e.target).closest(".search-containers").length) {
                        $(".search-containers").removeClass("expanded");
                    }
                });
            });

            // NEw
            // Function hide and show
            $(document).ready(function () {
                $(".toggle-btnss").click(function () {
                    let targetId = $(this).data("target");
                    $(targetId).slideToggle(); // Only toggle this email's content

                    // Rotate caret icon
                    $(this).find("i.fa").toggleClass("fa-caret-right fa-caret-down");
                });
            });

            //new

            // EMAIL TEMPLATE OPEN AND CLOSE
            $(document).ready(function () {
                const emailTemplate = $('#emailTemplate');

                // Open form
                $('.open-email-form').click(function () {
                    emailTemplate.addClass('open');

                });

                // Close form
                $('.close-btn').click(function () {
                    emailTemplate.removeClass('open');

                });
            });
            // view threads function
            $(document).ready(function () {
                $('#toggleButtonThread').click(function () {
                    const contents = $('#thread');
                    if (contents.hasClass('hidden')) {
                        contents.removeClass('hidden');
                        // $(this).text('See less');
                        $(this).find('span').text('See less');
                    } else {
                        contents.addClass('hidden');
                        // $(this).text('View thread');
                        $(this).find('span').text('View thread');
                    }
                });
            });
            // read more text function
            $('.moreless-button').click(function () {
                $('.moretext').slideToggle();
                if ($('.moreless-button').text() == "See more") {
                    $(this).text("See less")
                } else {
                    $(this).text("See more")
                }
            });

            // Copy Clipboard Email

            $(document).ready(function () {
                // Initialize Bootstrap tooltips
                $('[data-bs-toggle="tooltip"]').tooltip();

                $(document).on('click', '.copyEmail', async function () {
                    try {
                        let emailText = $("#customerEmail").text().trim();
                        await navigator.clipboard.writeText(emailText);

                        // Change tooltip to "Copied!" and show it
                        $(this).attr('data-bs-original-title', 'Copied!').tooltip('show');

                        // Reset tooltip text after 2 seconds
                        setTimeout(() => {
                            $(this).attr('data-bs-original-title', 'Copy to clipboard');
                        }, 2000);
                    } catch (err) {
                        console.error('Clipboard copy failed:', err);
                    }
                });
            });
        </script>
    @endpush
@endsection
