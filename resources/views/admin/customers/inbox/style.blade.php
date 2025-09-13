<!-- Ashter working css -->
<style>
    .custome-email-body {
        min-height: 100vh;
        background-color: #f0f2f5;
        font-family: Arial, sans-serif;
    }
    .row.g-0 {
        height: 100vh;
    }

    /* Left Sidebar */
    .left-sidebar {
        padding: 1.5rem 1rem;
        border-right: 1px solid #e0e0e0;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
        min-height: 100vh;
    }
    .head-icons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .icon-side {
        font-size: 1rem;
        color: #555;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .icon-side i,
    .search-side i {
        color: #0091ae;
    }
    .search-side i {
        font-size: 1.25rem;
    }
    .icon-side span {
        font-weight: 500;
        font-size: 1rem;
    }
    .main-heading {
        font-size: 0.9rem;
        font-weight: bold;
        color: #0091ae;
        display: flex;
        align-items: center;
    }
    .main-heading .fa-circle {
        color: #00bda5;
        font-size: 0.6rem;
    }
    .main-heading .fa-caret-down {
        color: #0091ae;
    }
    .list-group {
        border-radius: 0;
    }
    .list-group-item {
        border: none;
        padding: 0.6rem 1rem;
        margin-bottom: 5px;
        border-radius: 5px;
        transition: all 0.2s;
        font-weight: 500;
        color: #555;
    }
    .list-group-item:hover,
    .list-group-item.active {
        background-color: #e5f5f8;
        color: #000;
        font-weight: bold;
    }
    .list-group-item.active {
        border-left: 3px solid #0091ae;
        padding-left: calc(1rem - 3px);
    }
    .list-group-item .badge {
        background-color: transparent;
        color: #6c757d;
        font-size: 0.75rem;
        font-weight: normal;
    }
    .list-group-item.active .badge {
        font-weight: bold;
    }
    .less-link {
        color: #0091ae !important;
        font-weight: bold !important;
    }
    .email-body-bottom-button button {
        border: 1px solid #ccc;
        padding: 0.4rem 1.2rem;
        border-radius: 3px;
        font-weight: bold;
        font-size: 0.9rem;
    }
    .email-body-bottom-button .button-one {
        background-color: #eaf0f6;
        color: #333;
    }
    .email-body-bottom-button .button-two {
        background-color: #425b76;
        color: #fff;
    }
    .email-body-bottom-button .button-one i {
        color: #333;
    }

    .emails-wrapper {
        max-height: 90%;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
    }

    /* Scrollbar styling for Chrome, Edge, Safari */
    .emails-wrapper::-webkit-scrollbar {
        width: 6px;
        transition: width 0.3s ease;
    }

    .emails-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .emails-wrapper::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    /* Expand scrollbar on hover */
    .emails-wrapper:hover::-webkit-scrollbar {
        width: 12px;
    }

    .emails-wrapper::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .uppper-part-main {
        background-color: #f0f2f5;
        border-right: 1px solid #e0e0e0;
        overflow-y: auto;
    }
    .uppper-part {
        background-color: #fff;
        border-bottom: 1px solid #e0e0e0;
    }
    .custom-checkbox {
        cursor: pointer;
        display: inline-flex;
        align-items: center;
    }

    .custom-checkbox input {
        display: none;
    }

    .custom-checkbox .check-icon::before {
        font-family: "Font Awesome 6 Free";
        font-weight: 400;
        content: "\f0c8";
        font-size: 20px;
        color: #555;

        border-radius: 4px;
        padding: 2px;
    }

    .custom-checkbox input:checked + .check-icon::before {
        font-weight: 900;
        content: "\f14a";
        color: rgb(0, 145, 174);
        border-color: currentcolor;
    }

    .uppper-part .open-btn,
    .uppper-part .close-btn {
        border: none;
        font-weight: bold;
        padding: 0.5rem 1rem;
    }
    .uppper-part .open-btn {
        background-color: #d1d9e2;
        border-radius: 3px 0 0 3px;
    }
    .uppper-part .close-btn {
        background-color: #aabcce;
        color: #fff;
        border-radius: 0 3px 3px 0;
    }
    .uppper-part .upper-text {
        color: #0a89b4;
        font-weight: bold;
        font-size: 20px;
    }
    .email-main-body {
        background-color: #fff;
        border-bottom: 1px solid #e0e0e0;
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .email-main-body:hover {
        background-color: #f8f9fa;
    }
    .email-main-body.active-email {
        background-color: #e5f5f8;
        border-left: 3px solid #0091ae;
        padding-left: calc(1rem - 3px);
    }
    .active-enelops {
        background-color: #6a78d1 !important;
        color: #fff;
        padding: 0.6rem;
        border-radius: 50%;
        font-size: 0.8rem;
    }
    .email-main-body .fa-envelope {
        background-color: #c9d2de;
        color: #fff;
        padding: 0.6rem;
        border-radius: 50%;
        font-size: 0.8rem;
    }
    .email-main-body .email-address {
        font-size: 0.9rem;
        font-weight: bold;
        line-height: 1.2;
        color: rgb(51, 71, 91);
    }
    .email-main-body .email-subject {
        font-size: 0.9rem;
        font-weight: normal;
        color: rgb(51, 71, 91);
    }
    .email-main-body .small-para {
        font-size: 0.8rem;
        line-height: 1.2;
    }
    .email-main-body .para-second {
        font-size: 0.8rem;
        color: #888;
        white-space: nowrap;
    }
    .email-main-body.active-email .email-address,
    .email-main-body.active-email .email-subject {
        color: rgb(51, 71, 91);
        font-weight: bold;
    }
    .email-main-body.active-email .small-para {
        color: #000 !important;
    }

    /* Main Email View */
    .main-email-area-section {
        background-color: #fff;
        min-height: 100vh;
        border-right: 1px solid #e0e0e0;
    }
    .profile-avatar-h,
    .profile-avatar-m {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-weight: bold;
        color: #fff;
        font-size: 1rem;
    }
    .profile-avatar-h {
        background-color: #0091ae;
    }
    .profile-avatar-m {
        background-color: #425b76;
    }
    .main-area-email-para {
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.2;
    }
    .main-area-email-para-time {
        font-size: 0.8rem;
        color: #888;
    }
    .close-convo-btn {
        font-size: 0.8rem;
        font-weight: bold;
    }
    .profile-description {
        font-size: 14px;
        font-style: unset;
        font-weight: 600;
        text-transform: unset;
        margin: 0px;
        padding: 0px;
        font-family: "Lexend Deca", Helvetica, Arial, sans-serif;
        letter-spacing: 0px;
        line-height: 18px;
    }
    .profile-icon {
        background-color: #eaf0f6;
        padding: 0.6rem;
        color: #6f7a85;
        border-radius: 50%;
        font-size: 1rem;
    }
    .user_name {
        color: #0091ae;
        font-weight: bold;
        font-size: 17px;
    }
    .email-info-text,
    .date-time {
        font-size: 0.8rem;
    }
    .email-divider {
        color: #ccc;
        text-align: center;
    }
    .email-reply-block {
        background-color: #f5f8fa;
        padding: 1rem;
        border-radius: 8px;
        font-size: 16px;
    }
    .email-reply-block .last-span {
        font-size: 14px;
    }
    .email-reply-block .last-span .last-span-icon {
        color: #0091ae;
    }
    .email-reply-block .email-reply-address {
        color: #0091ae;
        font-weight: bolder;
    }
    .enlarge-icon {
        color: #0091ae;
        font-weight: bolder;
    }
    .envelop-open-text-section {
        font-weight: 500;
        font-size: 15px;
        padding-block: 12px;
        padding-inline: 28px;
        position: relative;
        color: rgb(51, 71, 91);
        transition-property: color;
        white-space: nowrap;
    }
    .email-compose-box {
        background-color: #fff;
        border: 1px solid #ccc;
        min-height: 150px;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .text-placeholder {
        font-size: 0.9rem;
        color: #888;
        cursor: text;
        flex-grow: 1;
        padding-bottom: 1rem;
        outline: none;
    }
    .email-area-choose-reciepeint {
        font-size: 19px;
    }
    .email-area-choose-reciepeint .email-area-input-for-recipeint {
        font-size: 17px;
        border: none;
        width: auto;
    }

    /* Toolbar styling */
    .editor-toolbar {
        padding: 0.5rem 0;
        margin-top: 0 !important;
    }

    .editor-icon {
        font-size: 1.1rem;
        color: #425b76;
        cursor: pointer;
        transition: color 0.2s;
    }
    .editor-icon:hover {
        color: #000;
    }
    .editor-icon.fa-ellipsis-h {
        color: #888;
    }

    .insert-btn,
    .send-option-btn {
        font-size: 0.9rem;
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-weight: bold;
        border: 1px solid #ddd;
        background-color: #fff;
        color: #425b76;
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
    }
    .insert-btn {
        color: #0091ae;
    }
    .insert-btn::after {
        display: inline-block;
        margin-left: 0.255em;
        vertical-align: 0.255em;
        content: "";
        border-top: 0.3em solid;
        border-right: 0.3em solid transparent;
        border-bottom: 0;
        border-left: 0.3em solid transparent;
    }
    .send-btn {
        background-color: #ccd1d9;
        border: none;
        color: #333;
        border-radius: 5px;
        font-size: 15px;
        font-weight: 600;
    }
    .send-option-btn {
        background-color: #0091ae;
        border: none;
        color: #fff;
        border-left: 1px solid #fff;
        border-radius: 0 50px 50px 0;
        padding-left: 0.25rem;
        padding-right: 0.25rem;
    }
    .send-option-btn::after {
        display: inline-block;
        margin-left: 0.5em;
        vertical-align: 0.255em;
        content: "";
        border-top: 0.3em solid;
        border-right: 0.3em solid transparent;
        border-bottom: 0;
        border-left: 0.3em solid transparent;
    }
    /* Toolbar styling */
    .editor-toolbar {
        border-top: 1px solid #e0e0e0;
        padding-top: 0.5rem;
        margin-top: 0 !important;
    }
    .toolbar-btn {
        background: none;
        border: none;
        font-size: 1.1rem;
        padding: 0.3rem 0.5rem;
        color: #444;
        cursor: pointer;
        transition: color 0.2s;
    }
    .toolbar-btn:hover {
        color: #000;
    }
    .toolbar-btn.text-muted {
        color: #999;
    }

    /* Right Sidebar */
    .right-sidebar {
        background-color: #fff;
        min-height: 100vh;
    }
    .right-sidebar-header .btn-group {
        background-color: rgb(234, 240, 246);
        border: 1px solid rgb(216, 220, 224);
    }
    .info-circle-iconnn {
        border-left: 0.5px solid rgb(115, 117, 119);
    }
    .contact-info-item {
        margin-bottom: 1rem;
    }
    .info-label {
        font-size: 0.8rem;
        color: #888;
        margin-bottom: 0.2rem;
        text-transform: uppercase;
    }
    .info-value {
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* this is the begining of the logical css */
    .selected-enelop {
        color: #007bff; /* Change this to your desired selection color */
    }

    /* Optional: Style for the selected actions dropdown */
    .selected-actions .btn-group .btn {
        border-radius: 0.375rem !important;
    }
</style>
<!-- Ashter working css end  -->
