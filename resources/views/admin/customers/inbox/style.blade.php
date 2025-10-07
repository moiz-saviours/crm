<!-- Ashter working css -->
<style>
    /*
 * Theme-on Root Variables
 */
    /*
 * Theme-on Root Variables
 */
    :root {
        --bs-brand-custom: #0091ae;
        --nf-mainnav-bg: #2d3e50;
        --theme-on-background-light: #f0f2f5;
        --theme-on-background-secondary: #f5f8fa;
        --theme-on-border: #e0e0e0;
        --theme-on-text-dark: rgb(51, 71, 91);
        --theme-on-text-medium: #555;
        --theme-on-text-light: #888;
        --theme-on-accent: #00bda5;
        --theme-on-info: #d1d9e2;
        --theme-on-active-bg: #e5f5f8;
        --theme-on-link: #0a89b4;
        --theme-on-success: #00b894;
        --theme-on-gray-100: #e9ecef;
        --theme-on-gray-200: #ccc;
        --theme-on-gray-300: #ddd;
        background-color: #999;
        --primary-blue: #1c75bc;
        --light-bg: #f7f9fc;
        --border-color: #ebedf0;
        --panel-width: 280px;
        --bs-brand-custom: #0091ae;
        --sidebar-width: clamp(200px, 16.66667vw, 300px);
        /* Fluid sidebar width */
        --font-base: clamp(0.85rem, 1vw, 1rem);
        /* Fluid base font */
        --padding-base: clamp(0.5rem, 1vw, 1rem);
        /* Fluid padding */
    }

    html,
    body {
        overflow: hidden;
        height: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
        /* font-size: var(--font-base); */
    }

    .custome-email-body {
        min-height: 100vh;
        background-color: var(--theme-on-background-light);
        font-family: Arial, sans-serif;
        min-width: 100vh;
    }

    .row.g-0 {
        height: 100vh;
        display: flex;
        /* Enhanced with flex for better responsiveness */
        flex-wrap: nowrap;
    }

    /* Left Sidebar */
    .left-sidebar {
        padding: var(--padding-base) calc(var(--padding-base) * 0.625);
        border-right: 1px solid var(--theme-on-border);
        box-shadow: 2px 0 0.3125rem rgba(0, 0, 0, 0.05);
        min-height: 100vh;
        width: var(--sidebar-width);
        flex-shrink: 0;
        transition: width 0.3s ease, padding 0.3s ease;
        /* Smooth transitions */
    }

    .head-icons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: clamp(0.8rem, 1.25vw, 1.25rem);
    }

    .icon-side {
        font-size: var(--nf-profile-para-size);
        color: var(--theme-on-text-medium);
        display: flex;
        align-items: center;
        gap: clamp(0.4rem, 0.625vw, 0.625rem);
    }

    .icon-side i,
    .search-side i {
        color: var(--bs-brand-custom);
    }

    .search-side i {
        font-size: var(--nf-profile-para-size);
    }

    .icon-side span {
        font-weight: 500;
        font-size: var(--nf-profile-para-size);
    }

    .main-heading {
        font-size: var(--nf-profile-para-size);
        font-weight: bold;
        color: var(--bs-brand-custom);
        display: flex;
        align-items: center;
    }

    .main-heading .fa-circle {
        color: var(--theme-on-accent);
        font-size: var(--nf-profile-para-size);
    }

    .main-heading .fa-caret-down {
        color: var(--bs-brand-custom);
    }

    .list-group {
        border-radius: 0;
    }

    .list-group-item {
        border: none;
        padding: clamp(0.3rem, 0.5vw, 0.5rem) clamp(0.4rem, 0.625vw, 0.625rem);
        margin-bottom: clamp(0.2rem, 0.3125vw, 0.3125rem);
        border-radius: clamp(0.2rem, 0.3125vw, 0.3125rem);
        transition: all 0.2s;
        font-weight: 500;
        color: var(--theme-on-text-medium);
    }

    .list-group-item:hover,
    .list-group-item.active {
        background-color: var(--theme-on-active-bg);
        color: #000;
        font-weight: bold;
        border-color: none;
    }

    .list-group-item.active {
        border-left: clamp(0.1rem, 0.1875vw, 0.1875rem) solid var(--bs-brand-custom);
        padding-left: calc(
            clamp(0.4rem, 0.625vw, 0.625rem) - clamp(0.1rem, 0.1875vw, 0.1875rem)
        );
    }

    .list-group-item .badge {
        background-color: transparent;
        color: var(--bs-secondary-color);
        font-size: var(--nf-profile-para-size);
        font-weight: normal;
    }

    .list-group-item.active .badge {
        font-weight: bold;
    }

    .less-link {
        color: var(--bs-brand-custom) !important;
        font-weight: bold !important;
    }

    .email-body-bottom-button {
        margin-bottom: clamp(0.8rem, 1.25vw, 1.25rem);
    }

    .email-body-bottom-button button {
        border: 1px solid var(--theme-on-gray-200);
        padding: clamp(0.3rem, 0.4vw, 0.4rem);
        border-radius: clamp(0.1rem, 0.1875vw, 0.1875rem);
        font-weight: bold;
        font-size: var(--nf-profile-para-size);
    }

    .email-body-bottom-button .button-one {
        background-color: var(--theme-on-info);
        color: #333;
    }

    .email-body-bottom-button .button-two {
        background-color: var(--nf-mainnav-bg);
        color: #fff;
    }

    .email-body-bottom-button .button-one i {
        color: #333;
    }

    .emails-wrapper {
        max-height: 90%;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--theme-on-text-light) #f1f1f1;
    }

    #unassigned-pane {
        max-height: clamp(40rem, 52.25vh, 52.25rem);
        /* Fluid max-height */
        overflow-y: auto;
        padding-right: clamp(0.2rem, 0.3125vw, 0.3125rem);
    }

    #unassigned-pane::-webkit-scrollbar {
        width: clamp(0.3rem, 0.375vw, 0.375rem);
    }

    #unassigned-pane::-webkit-scrollbar-thumb {
        background: #bbb;
        border-radius: clamp(0.2rem, 0.25vw, 0.25rem);
    }

    #unassigned-pane::-webkit-scrollbar-thumb:hover {
        background: var(--theme-on-text-light);
    }

    .uppper-part-main {
        background-color: #fff;
        border-right: 1px solid var(--theme-on-border);
        overflow-y: auto;
        flex-grow: 1;
        /* Allow flex growth */
    }

    .uppper-part {
        background-color: #fff;
        border-bottom: 1px solid var(--theme-on-border);
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
        font-family: "Font Awesome 5 Free";
        /* FA5 */
        font-weight: 400;
        /* regular style */
        content: "\f0c8";
        /* fa-square icon */
        font-size: var(--nf-profile-para-size);
        color: var(--theme-on-text-medium);
        border-radius: clamp(0.2rem, 0.25vw, 0.25rem);
        padding: clamp(0.1rem, 0.125vw, 0.125rem);
        display: inline-block;
        /* reserve space to prevent shifting */
        width: 1.5em;
        /* fixed width */
        text-align: center;
        /* keep icon centered */
    }

    .custom-checkbox input:checked + .check-icon::before {
        font-weight: 900;
        content: "\f14a";
        color: var(--bs-brand-custom);
        border-color: currentcolor;
    }

    .uppper-part .open-btn,
    .uppper-part .close-btn {
        border: none;
        font-weight: bold;
        padding: clamp(0.3rem, 0.5vw, 0.5rem) clamp(0.4rem, 0.625vw, 0.625rem);
    }

    .uppper-part .open-btn {
        background-color: var(--theme-on-info);
        border-radius: clamp(0.1rem, 0.1875vw, 0.1875rem) 0 0
        clamp(0.1rem, 0.1875vw, 0.1875rem);
    }

    .uppper-part .close-btn {
        background-color: var(--nf-mainnav-bg);
        color: #fff;
        border-radius: 0 clamp(0.1rem, 0.1875vw, 0.1875rem)
        clamp(0.1rem, 0.1875vw, 0.1875rem) 0;
    }

    .uppper-part .upper-text {
        color: var(--theme-on-link);
        font-weight: bold;
        font-size: var(--nf-profile-para-size);
    }

    .email-main-body {
        background-color: #fff;
        border-bottom: 1px solid var(--theme-on-border);
        padding: clamp(0.3rem, 0.5vw, 0.5rem) clamp(0.4rem, 0.625vw, 0.625rem);
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .email-main-body:hover {
        background-color: var(--theme-on-background-secondary);
    }

    .email-main-body.active-email {
        background-color: var(--theme-on-active-bg);
        border-left: clamp(0.1rem, 0.1875vw, 0.1875rem) solid var(--bs-brand-custom);
        padding-left: calc(
            clamp(0.4rem, 0.625vw, 0.625rem) - clamp(0.1rem, 0.1875vw, 0.1875rem)
        );
    }

    .active-enelops {
        background-color: #6a78d1 !important;
        color: #fff;
        padding: clamp(0.3rem, 0.5vw, 0.5rem);
        border-radius: 50%;
        font-size: var(--nf-profile-para-size);
    }

    .email-main-body .fa-envelope {
        background-color: var(--theme-on-info);
        color: #fff;
        padding: clamp(0.3rem, 0.5vw, 0.5rem);
        border-radius: 50%;
        font-size: var(--nf-profile-para-size);
    }

    .email-main-body .email-address {
        font-size: var(--nf-profile-para-size);
        font-weight: bold;
        line-height: 1.2;
        color: var(--theme-on-text-dark);
    }

    .email-main-body .email-subject {
        font-size: var(--nf-profile-para-size);
        font-weight: normal;
        color: var(--theme-on-text-dark);
    }

    .email-main-body .small-para {
        font-size: var(--nf-profile-para-size);
        line-height: 1.2;
    }

    .email-main-body .para-second {
        font-size: var(--nf-profile-para-size);
        color: var(--theme-on-text-light);
        white-space: nowrap;
    }

    .email-main-body.active-email .email-address,
    .email-main-body.active-email .email-subject {
        color: var(--theme-on-text-dark);
        font-weight: bold;
    }

    .email-main-body.active-email .small-para {
        color: #000 !important;
    }

    /* Main Email View */
    .main-email-area-section {
        background-color: #fff;
        min-height: 100vh;
        border-right: 1px solid var(--theme-on-border);
        flex-grow: 2;
        /* Enhanced flex for main area */
    }

    .profile-avatar-h,
    .profile-avatar-m {
        display: flex;
        align-items: center;
        justify-content: center;
        width: clamp(2rem, 2.5vw, 2.5rem);
        height: clamp(2rem, 2.5vw, 2.5rem);
        min-width: clamp(2rem, 2.5vw, 2.5rem);
        min-height: clamp(2rem, 2.5vw, 2.5rem);
        max-width: clamp(2rem, 2.5vw, 2.5rem);
        max-height: clamp(2rem, 2.5vw, 2.5rem);
        border-radius: 50%;
        font-weight: bold;
        color: #fff;
        font-size: var(--nf-profile-para-size);
        overflow: hidden;
        flex-shrink: 0;
    }

    .profile-avatar-h {
        background-color: var(--bs-brand-custom);
    }

    .profile-avatar-m {
        background-color: var(--nf-mainnav-bg);
    }

    .main-area-email-para {
        font-size: var(--nf-profile-para-size);
        font-weight: 500;
        line-height: 1.2;
    }

    .main-area-email-para-time {
        font-size: var(--nf-profile-para-size);
        color: var(--theme-on-text-light);
    }

    .close-convo-btn {
        font-size: var(--nf-profile-para-size);
        font-weight: bold;
    }

    .profile-description {
        font-size: var(--nf-profile-para-size);
        font-style: unset;
        font-weight: 600;
        text-transform: unset;
        margin: 0;
        padding: 0;
        font-family: "Lexend Deca", Helvetica, Arial, sans-serif;
        letter-spacing: 0;
        line-height: clamp(0.9rem, 1.125vw, 1.125rem);
    }

    .icon-wrapper {
        position: relative;
        display: inline-block;
    }

    .profile-icon {
        font-size: clamp(2rem, 2.5vw, 2.5rem);

        color: var(--theme-on-info);
    }

    .user-info {
        cursor: pointer;
    }

    .status-dot {
        position: absolute;
        top: clamp(1.5rem, 1.9375vw, 1.9375rem);
        right: 0;
        width: clamp(0.6rem, 0.75vw, 0.75rem);
        height: clamp(0.6rem, 0.75vw, 0.75rem);
        background-color: var(--theme-on-success);
        border-radius: 50%;
        border: clamp(0.1rem, 0.125vw, 0.125rem) solid white;
    }

    .user_name {
        color: var(--bs-brand-custom);
        font-weight: bold;
        font-size: var(--nf-profile-para-size);
    }

    .email-info-text,
    .date-time {
        font-size: var(--nf-profile-para-size);
    }

    .email-divider {
        color: var(--theme-on-gray-200);
        text-align: center;
    }

    .email-reply-block {
        background-color: var(--theme-on-background-secondary);
        padding: clamp(0.4rem, 0.625vw, 0.625rem);
        border-radius: clamp(0.3rem, 0.5vw, 0.5rem);
        font-size: var(--nf-profile-para-size);
        min-width: 100%;
        max-width: 200px;
    }

    .email-reply-block .last-span {
        font-size: var(--nf-profile-para-size);
    }

    .email-reply-block .last-span .last-span-icon {
        color: var(--bs-brand-custom);
    }

    .email-reply-block .email-reply-address {
        color: var(--bs-brand-custom);
        font-weight: bolder;
    }

    .enlarge-icon {
        color: var(--bs-brand-custom);
        font-weight: bolder;
    }

    .envelop-open-text-section {
        font-weight: 500;
        font-size: var(--nf-profile-para-size);
        padding-block: clamp(0.6rem, 0.75vw, 0.75rem);
        padding-inline: clamp(1.4rem, 1.75vw, 1.75rem);
        position: relative;
        color: var(--theme-on-text-dark);
        transition-property: color;
        white-space: nowrap;
    }

    .email-compose-box {
        background-color: #fff;
        border: 1px solid var(--theme-on-gray-200);
        min-height: clamp(7rem, 9.375vh, 9.375rem);
        padding: clamp(0.4rem, 0.625vw, 0.625rem);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .text-placeholder {
        font-size: var(--nf-profile-para-size);
        color: rgb(68, 68, 68);
        cursor: text;
        flex-grow: 1;
        padding-bottom: clamp(3.5rem, 4.375vh, 4.375rem);
        outline: none;
    }

    .email-area-choose-reciepeint {
        font-size: var(--nf-profile-para-size);
    }

    .email-area-choose-reciepeint .email-area-input-for-recipeint {
        font-size: var(--nf-profile-para-size);
        border: none;
        width: auto;
    }

    /* Toolbar styling */
    .editor-toolbar {
        background: #fff;
        padding: clamp(0.3rem, 0.5vw, 0.5rem) clamp(0.8rem, 1vw, 1rem);
        border-top: 1px solid var(--theme-on-gray-300);

        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: clamp(0.3rem, 0.5vw, 0.5rem);
    }

    .editor-icon {
        font-size: var(--nf-profile-para-size);
        color: var(--nf-mainnav-bg);
        cursor: pointer;
        transition: color 0.2s;
    }

    .editor-icon:hover {
        color: #000;
    }

    .editor-icon.fa-ellipsis-h {
        color: var(--theme-on-text-light);
    }

    .insert-btn,
    .send-option-btn {
        font-size: var(--nf-profile-para-size);
        padding: clamp(0.3rem, 0.375vw, 0.375rem) clamp(0.6rem, 0.75vw, 0.75rem);
        border-radius: clamp(1.25rem, 1.5625vw, 1.5625rem);
        font-weight: bold;
        border: 1px solid var(--theme-on-gray-300);
        background-color: #fff;
        color: var(--nf-mainnav-bg);
        display: flex;
        align-items: center;
    }

    .insert-btn {
        color: var(--bs-brand-custom);
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
        background-color: var(--theme-on-info);
        border: none;
        color: #333;
        border-radius: clamp(0.25rem, 0.3125vw, 0.3125rem);
        font-size: var(--nf-profile-para-size);
        font-weight: 600;
    }

    .send-option-btn {
        background-color: var(--bs-brand-custom);
        border: none;
        color: #fff;
        border-left: 1px solid #fff;
        border-radius: 0 clamp(1.25rem, 1.5625vw, 1.5625rem)
        clamp(1.25rem, 1.5625vw, 1.5625rem) 0;
        padding-left: clamp(0.2rem, 0.25vw, 0.25rem);
        padding-right: clamp(0.2rem, 0.25vw, 0.25rem);
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

    /* Right Sidebar */
    .right-sidebar {
        background-color: #fff;
        border-left: 1px solid var(--theme-on-border);
        width: clamp(200px, 20vw, 300px);
        /* Fluid right sidebar */
        flex-shrink: 0;
        transition: width 0.3s ease;
    }
    .right-sidebar-header {
        background-color: #fff;
        border-bottom: 1px solid var(--theme-on-border);
        padding: clamp(0.85rem, 1.0625vw, 1.0625rem) clamp(0.5rem, 0.625vw, 0.625rem)
        clamp(1.1rem, 1.375vw, 1.375rem) clamp(0.3rem, 0.375vw, 0.375rem);
    }

    .right-sidebar-header .btn-tertiary-light {
        background-color: var(--theme-on-gray-100);
        color: var(--bs-secondary-color);
        border: none;
        border-radius: 4px;
        font-size: var(--nf-profile-para-size);
        padding: clamp(0.2rem, 0.6vw, 0.4rem) clamp(0.8rem, 1vw, 1.2rem);
        max-width: 100%; /* allow it to grow with parent */
        width: auto;
        white-space: normal; /* allow text to wrap */
        text-align: center;
        line-height: 1.3;
        word-break: break-word;
        box-sizing: border-box;
    }

    .right-sidebar-header .btn-group button:not(:first-child) {
        border-left: 1px solid #444;
    }

    .right-sidebar-header .info-circle-iconnn {
        border-left: none;
    }

    .contact-info-item {
        margin-bottom: clamp(0.5rem, 0.625vw, 0.625rem);
    }

    .contact-info-item .info-label {
        font-size: var(--nf-profile-para-size);
        color: var(--bs-secondary-color);
        margin-bottom: clamp(0.2rem, 0.25vw, 0.25rem);
    }

    .contact-info-item .info-value {
        font-size: var(--nf-profile-para-size);
        color: #212529;
        font-weight: 600;
    }

    .right-sidebar hr {
        margin-top: clamp(0.5rem, 0.625vw, 0.625rem);
        margin-bottom: clamp(0.5rem, 0.625vw, 0.625rem);
    }

    .right-sidebar-profile-avator {
        background-color: var(--theme-on-info);
    }

    .main-area-email-para-right-sidebar {
        color: var(--bs-brand-custom);
        font-size: var(--nf-profile-para-size);
        font-weight: 600;
    }

    .right-sidebar-down-icon {
        color: #0c96b2;
        font-size: clamp(1.2rem, 1.5vw, 1.5rem);
    }

    .right-sidebar-circle-icon {
        font-size: var(--nf-profile-para-size);
    }

    .right-sidebar-text-span {
        font-size: var(--nf-profile-para-size);
        font-weight: 600;
        color: #333;
    }

    /* Logical CSS */
    .selected-enelop {
        color: var(--bs-brand-custom);
        font-size: var(--nf-profile-para-size);
        margin-left: clamp(0.2rem, 0.25vw, 0.25rem);
    }

    .selected-actions .btn-group .btn {
        border-radius: clamp(0.3rem, 0.375vw, 0.375rem) !important;
    }

    /* Sliding effect for column one */
    .left-sidebar {
        position: relative;
        transition: transform 0.3s ease-in-out;
    }

    body.sidebar-collapsed .left-sidebar {
        transform: translateX(-100%);
    }

    .uppper-part-main {
        transition: margin-left 0.3s ease-in-out;
    }

    body.sidebar-collapsed .uppper-part-main {
        margin-left: calc(-1 * var(--sidebar-width));
    }

    /* Icon hover and rotation */
    .left-sidebar .icon-side i {
        transition: transform 0.3s ease-in-out;
    }

    body.sidebar-collapsed .left-sidebar .icon-side i {
        transform: rotate(180deg);
    }

    #email-icon {
        transition: transform 0.2s ease-in-out;
    }

    /* Bootstrap dropdown adjustment */
    .dropdown-menu {
        left: 18% !important;
        transform: translateX(-50%) !important;
        top: 100% !important;
    }

    .email-compose-box {
        margin-top: auto;
        /* position: sticky; */
        bottom: 0;
        min-height: clamp(6rem, 7.5vh, 7.5rem);
        max-height: clamp(11rem, 13.625vh, 13.625rem);
        overflow-y: auto;
        background: #fff;
        border: 1px solid var(--theme-on-gray-300);
        border-radius: clamp(0.4rem, 0.5vw, 0.5rem);
        padding: clamp(0.5rem, 0.625vw, 0.625rem);
        transition: all 0.3s ease;
    }

    .drag-handle {
        height: clamp(0.4rem, 0.5vw, 0.5rem);
        cursor: ns-resize;
        background: var(--theme-on-border);
        border-top: 1px solid var(--theme-on-gray-200);
        border-radius: 0 0 clamp(0.3rem, 0.375vw, 0.375rem)
        clamp(0.3rem, 0.375vw, 0.375rem);
    }

    .recipient-selection-container {
        position: relative;
        flex-grow: 1;
    }

    .recipient-tag {
        display: inline-block;
        background-color: var(--theme-on-border);
        border-radius: clamp(0.6rem, 0.75vw, 0.75rem);
        padding: clamp(0.2rem, 0.25vw, 0.25rem) clamp(0.4rem, 0.5vw, 0.5rem);
        margin: clamp(0.1rem, 0.125vw, 0.125rem);
        font-size: var(--nf-profile-para-size);
        color: #333;
    }

    .recipient-tag-remove {
        margin-left: clamp(0.4rem, 0.5vw, 0.5rem);
        cursor: pointer;
        font-weight: bold;
    }

    .email-area-input-for-recipient {
        border: none;
        outline: none;
        background: none;
        flex-grow: 1;
        min-width: 0;
    }

    .email-area-choose-recipient {
        width: 100%;
    }

    .fullscreen-compose {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #fff;
        z-index: 1050;
        padding: clamp(1rem, 1.25vw, 1.25rem) clamp(2rem, 2.5vw, 2.5rem);
        display: flex;
        flex-direction: column;
        box-shadow: 0 0 clamp(1rem, 1.25vw, 1.25rem) rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }

    .fullscreen-compose .editor-toolbar {
        margin-top: auto;
        border-top: 1px solid var(--theme-on-gray-300);
        padding-top: clamp(0.5rem, 0.625vw, 0.625rem);
    }

    .fullscreen-close {
        position: absolute;
        top: clamp(0.75rem, 0.9375vw, 0.9375rem);
        right: clamp(1rem, 1.25vw, 1.25rem);
        font-size: var(--nf-profile-para-size);
        cursor: pointer;
        color: var(--theme-on-text-medium);
    }

    .fullscreen-close:hover {
        color: #000;
    }

    .icon-checkbox-wrapper .custom-checkbox {
        display: none;
    }

    .icon-checkbox-wrapper:hover .fa-envelope {
        display: none;
    }

    .icon-checkbox-wrapper:hover .custom-checkbox {
        display: inline-block;
    }

    /* Sidebar collapse */
    .left-sidebar-custom {
        border-right: clamp(0.3rem, 4vw, 4px) solid var(--theme-on-gray-300);
        width: 105%;
        transition: width 0.3s ease-in-out, min-width 0.3s ease-in-out;
        white-space: nowrap;
    }

    .left-sidebar-custom.collapsed {
        width: clamp(3rem, 3.75vw, 3.75rem);
        min-width: clamp(3rem, 3.75vw, 3.75rem);
        border-right: 1px solid var(--theme-on-gray-300);
        transition: width 0.3s ease-in-out, min-width 0.3s ease-in-out;
        overflow: hidden;
    }

    .left-sidebar-custom.collapsed .sidebar-label,
    .left-sidebar-custom.collapsed .list-group,
    .left-sidebar-custom.collapsed .main-heading,
    .left-sidebar-custom.collapsed hr,
    .left-sidebar-custom.collapsed .email-body-bottom-button,
    .left-sidebar-custom.collapsed .w-100,
    .left-sidebar-custom.collapsed .search-side {
        display: none !important;
    }

    .toggle-icon {
        transition: transform 0.3s ease;
    }

    .left-sidebar-custom.collapsed .toggle-icon {
        transform: rotate(180deg);
    }

    .sidebar-toggle-btn-custom {
        cursor: pointer;
    }

    .sortable-item {
        border-bottom: 1px solid var(--theme-on-gray-100);
    }

    .sortable-item:last-child {
        border-bottom: none;
    }

    .custom-sidebar-header {
        display: flex;
        align-items: center;
        padding: clamp(0.4rem, 0.5vw, 0.5rem) clamp(0.5rem, 0.625vw, 0.625rem);
        cursor: pointer;
        font-size: var(--nf-profile-para-size);
        color: #343a40;
        position: relative;
    }

    .custom-sidebar-header:hover {
        background-color: var(--theme-on-background-secondary);
    }

    .custom-toggle-icon {
        margin-right: clamp(0.4rem, 0.5vw, 0.5rem);
        transition: transform 0.2s ease;
        color: var(--theme-on-link);
        font-size: var(--nf-profile-para-size);
    }

    .custom-sidebar-header:not(.collapsed) .custom-toggle-icon {
        transform: rotate(90deg);
    }

    .drag-handle-icon {
        cursor: grab;
        color: var(--bs-secondary-color);
        font-size: var(--nf-profile-para-size);
        margin-right: clamp(0.6rem, 0.75vw, 0.75rem);
    }

    .drag-handle-icon:active {
        cursor: grabbing;
    }

    .info-circle-icon {
        color: var(--bs-secondary-color);
        font-size: var(--nf-profile-para-size);
        margin-left: clamp(0.4rem, 0.5vw, 0.5rem);
        opacity: 0.7;
    }

    .custom-sidebar-content {
        padding: clamp(0.4rem, 0.5vw, 0.5rem) clamp(0.5rem, 0.625vw, 0.625rem);
        background-color: #fff;
        border-top: 1px solid var(--theme-on-gray-100);
    }

    .custom-sidebar-content .contact-info-item p {
        margin-bottom: clamp(0.2rem, 0.25vw, 0.25rem);
        font-size: var(--nf-profile-para-size);
    }

    .custom-sidebar-content .info-label {
        color: var(--bs-secondary-color);
        font-weight: 500;
    }

    .custom-sidebar-content .info-value {
        color: #343a40;
    }

    .sortable-ghost {
        opacity: 0.4;
        background-color: var(--theme-on-border);
        border: 1px dashed var(--theme-on-gray-200);
    }

    /* Company section */
    .company-card {
        background-color: #fff;
        border: 1px solid #c5c6c7;
        border-radius: clamp(0.25rem, 0.3125vw, 0.3125rem);
        padding: clamp(0.5rem, 0.625vw, 0.625rem);
    }

    .company-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: clamp(0.5rem, 0.625vw, 0.625rem);
    }

    .company-header .btn {
        font-size: var(--nf-profile-para-size);
        padding: clamp(0.2rem, 0.25vw, 0.25rem) clamp(0.4rem, 0.5vw, 0.5rem);
    }

    .company-header .btn-primary {
        background-color: var(--bs-brand-custom);
        border-color: var(--bs-brand-custom);
    }

    .company-name {
        font-size: var(--nf-profile-para-size);
        font-weight: 600;
        color: #343a40;
    }

    .company-link a {
        color: var(--bs-brand-custom);
        text-decoration: none;
    }

    .company-link a:hover {
        text-decoration: underline;
    }

    .company-link .fa-copy {
        margin-left: clamp(0.4rem, 0.5vw, 0.5rem);
        cursor: pointer;
        color: var(--bs-brand-custom);
    }

    .company-link .fa-external-link-alt {
        margin-left: clamp(0.2rem, 0.25vw, 0.25rem);
    }

    .company-link i {
        font-size: var(--nf-profile-para-size);
    }

    .view-commpany {
        font-size: var(--nf-profile-para-size);
        color: var(--bs-brand-custom);
        font-weight: 500;
    }

    /* Other conversations */
    .other-conversations-section {
        background-color: #fff;
        padding: clamp(0.5rem, 0.625vw, 0.625rem);
        border: 1px solid #c5c6c7;
    }

    .other-conversations-section-ptwo {
        font-weight: 900;
        font-size: var(--nf-profile-para-size);
        color: var(--bs-brand-custom);
        text-decoration: none;
    }

    .other-conversations-section-pone {
        font-size: var(--nf-profile-para-size);
    }

    /* Right sidebar contacts */
    .contacts-section {
        background-color: #fff;
        padding: clamp(0.5rem, 0.625vw, 0.625rem);
        border: 1px solid #c5c6c7;
    }

    .contacts-section .contacts-section-para {
        font-size: var(--nf-profile-para-size);
    }

    .right-sec-payment-btn {
        background-color: var(--theme-on-info);
        border-radius: clamp(0.15rem, 0.1875vw, 0.1875rem) 0 0
        clamp(0.15rem, 0.1875vw, 0.1875rem);
        padding: clamp(0.4rem, 0.5vw, 0.5rem) clamp(0.5rem, 0.625vw, 0.625rem);
        border: none;
        color: #343a40;
    }

    .email-header-main {
        padding: clamp(0.9rem, 1.125vw, 1.125rem) clamp(0.5rem, 0.625vw, 0.625rem)
        clamp(0.95rem, 1.1875vw, 1.1875rem) clamp(0.5rem, 0.625vw, 0.625rem);
    }

    .left-bottom-buttons-above-hr {
        margin-bottom: clamp(2.5rem, 3.125vw, 3.125rem) !important;
    }

    .left-sidebar-custom {
        height: 100vh;
        display: flex;
        flex-direction: column;
    }

    #inbox-tabs {
        flex-grow: 1;
        overflow-y: auto;
        overflow-x: hidden;
        max-height: calc(100vh - clamp(10rem, 12.5vh, 12.5rem));
    }
    .action-dropdown {
        position: relative;
        display: inline-block;
    }

    .button-one {
        background: #f5f5f5;
        border: 1px solid var(--theme-on-gray-200);
        padding: clamp(0.4rem, 0.5vw, 0.5rem) clamp(0.7rem, 0.875vw, 0.875rem);
        border-radius: clamp(0.25rem, 0.3125vw, 0.3125rem);
        cursor: pointer;
        font-size: var(--nf-profile-para-size);
    }

    .custom-menu {
        position: absolute;
        bottom: 100%;
        left: 0;
        margin-bottom: clamp(0.4rem, 0.5vw, 0.5rem);
        background: #fff;
        border: 1px solid var(--theme-on-gray-300);
        border-radius: clamp(0.3rem, 0.375vw, 0.375rem);
        list-style: none;
        padding: clamp(0.3rem, 0.375vw, 0.375rem) 0;
        min-width: clamp(10rem, 12.5vw, 12.5rem);
        display: none;
        box-shadow: 0 clamp(0.2rem, 0.25vw, 0.25rem) clamp(0.5rem, 0.625vw, 0.625rem)
        rgba(0, 0, 0, 0.15);
        z-index: 1000;
    }

    .custom-menu li {
        padding: clamp(0.4rem, 0.5vw, 0.5rem) clamp(0.6rem, 0.75vw, 0.75rem);
        font-size: var(--nf-profile-para-size);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .custom-menu li:hover {
        background: #f5f5f5;
    }

    .email-reply-wrapper {
        max-height: clamp(10rem, 12.5vh, 12.5rem);
        overflow-y: auto;
        padding-right: clamp(0.4rem, 0.5vw, 0.5rem);
        max-width: clamp(20rem, 33vw, 39rem);
    }
    .email-reply-wrapper::-webkit-scrollbar {
        width: clamp(0.3rem, 0.375vw, 0.375rem);
    }

    .email-reply-wrapper::-webkit-scrollbar-thumb {
        background-color: var(--theme-on-gray-200);
        border-radius: clamp(0.2rem, 0.25vw, 0.25rem);
    }

    .email-reply-wrapper::-webkit-scrollbar-thumb:hover {
        background-color: #999;
    }

    .editor-wrapper {
        display: flex;
        flex-direction: column;
        height: clamp(15rem, 18.75vh, 18.75rem);
        border-radius: clamp(0.3rem, 0.375vw, 0.375rem);
        background: #fff;
        overflow: hidden;
        font-size-adjust: from-font;
    }

    #editorContent {
        flex: 1;
        overflow-y: auto;
        padding: clamp(0.5rem, 0.625vw, 0.625rem);
        border-bottom: 1px solid var(--theme-on-gray-300);
    }

    .editor-toolbar {
        background: #fff;
        padding: clamp(0.4rem, 0.5vw, 0.5rem) clamp(0.5rem, 0.625vw, 0.625rem);
        border-top: 1px solid var(--theme-on-gray-300);
        flex-shrink: 0;
    }

    .custom-dropdown {
        position: absolute;
        background: #fff;
        border: 1px solid var(--theme-on-gray-300);
        border-radius: clamp(0.4rem, 0.5vw, 0.5rem);
        box-shadow: 0px clamp(0.2rem, 0.25vw, 0.25rem)
        clamp(0.5rem, 0.625vw, 0.625rem) rgba(0, 0, 0, 0.1);
        padding: clamp(0.5rem, 0.625vw, 0.625rem) clamp(0.75rem, 0.9375vw, 0.9375rem);
        min-width: clamp(9rem, 11.25vw, 11.25rem);
        z-index: 1000;
    }

    .custom-dropdown::after {
        content: "";
        position: absolute;
        bottom: clamp(-0.4rem, -0.5vw, -0.5rem);
        left: clamp(1rem, 1.25vw, 1.25rem);
        border-width: clamp(0.4rem, 0.5vw, 0.5rem);
        border-style: solid;
        border-color: #fff transparent transparent transparent;
        filter: drop-shadow(
            0px clamp(0.1rem, 0.125vw, 0.125rem) clamp(0.1rem, 0.125vw, 0.125rem)
            rgba(0, 0, 0, 0.1)
        );
    }

    .custom-dropdown a {
        display: block;
        padding: clamp(0.3rem, 0.375vw, 0.375rem) clamp(0.5rem, 0.625vw, 0.625rem);
        color: #333;
        text-decoration: none;
        font-size: var(--nf-profile-para-size);
    }

    .custom-dropdown a:hover {
        background: #f5f5f5;
        border-radius: clamp(0.25rem, 0.3125vw, 0.3125rem);
    }

    .right-sidebar {
        display: flex;
        flex-direction: column;
        height: 100vh;
        overflow: hidden;
    }

    .right-sidebar-header,
    .right-sidebar > .d-flex,
    .right-sidebar hr {
        flex-shrink: 0;
    }

    #sortable-container {
        flex-grow: 1;
        overflow-y: auto;
        padding-right: clamp(0.3rem, 0.375vw, 0.375rem);
        scrollbar-width: thin;
    }

    #sortable-container::-webkit-scrollbar {
        width: clamp(0.3rem, 0.375vw, 0.375rem);
    }

    #sortable-container::-webkit-scrollbar-thumb {
        background: #d6d4d4;
        border-radius: clamp(0.2rem, 0.25vw, 0.25rem);
    }

    #sortable-container::-webkit-scrollbar-thumb:hover {
        background: #999;
    }

    .custom-fa-caret-down {
        font-size: var(--nf-profile-para-size);
        color: var(--bs-brand-custom);
    }

    /* User Info Dropdown */
    .user-info-dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle {
        cursor: pointer;
    }

    .user-dropdown-menu {
        position: absolute;
        top: 100%;
        left: 75%;
        transform: translateX(-50%);
        z-index: 1000;
        min-width: clamp(12.5rem, 15.625vw, 15.625rem);
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 clamp(0.2rem, 0.25vw, 0.25rem) clamp(0.3rem, 0.375vw, 0.375rem)
        rgba(0, 0, 0, 0.1);
        border-radius: clamp(0.4rem, 0.5vw, 0.5rem);
        padding: clamp(0.5rem, 0.625vw, 0.625rem);
        margin-top: clamp(0.5rem, 0.625vw, 0.625rem);
        display: none;
    }

    .user-dropdown-menu.show {
        display: block;
    }

    .user-dropdown-menu .search-box {
        position: relative;
        margin-bottom: clamp(0.5rem, 0.625vw, 0.625rem);
    }

    .user-dropdown-menu .search-box input {
        width: 100%;
        padding: clamp(0.4rem, 0.5vw, 0.5rem) clamp(1.75rem, 2.1875vw, 2.1875rem)
        clamp(0.4rem, 0.5vw, 0.5rem) clamp(0.75rem, 0.9375vw, 0.9375rem);
        border: 1px solid #0091ae;
        border-radius: clamp(0.25rem, 0.3125vw, 0.3125rem);
        font-size: var(--nf-profile-para-size);
        color: #555;
        outline: none;
    }

    .user-dropdown-menu .search-box input::placeholder {
        color: #aaa;
    }

    .user-dropdown-menu .search-box .search-icon {
        position: absolute;
        right: clamp(0.75rem, 0.9375vw, 0.9375rem);
        top: 50%;
        transform: translateY(-50%);
        color: #0091ae;
    }

    .user-dropdown-menu .user-list {
        max-height: clamp(10rem, 12.5vh, 12.5rem);
        overflow-y: auto;
    }

    .user-dropdown-menu .user-item {
        display: flex;
    }

    /* Wrapper for each filter group */
    .filter-group {
        margin-bottom: 1.5rem;
    }

    /* Labels like "Date" */
    .filter-label {
        font-weight: 600;
        font-size: 14px;
        color: #33475b;
        margin-bottom: 6px;
        display: block;
    }

    /* Date inputs */
    .filter-group input[type="date"].form-control {
        background-color: #f5f8fa;
        border: 1px solid #cbd6e2;
        border-radius: 4px;
        padding: 8px 12px;
        font-size: var(--nf-profile-para-size);
        color: #33475b;
        transition: border-color 0.2s ease-in-out;
    }

    /* Hover / focus effect */
    .filter-group input[type="date"].form-control:hover,
    .filter-group input[type="date"].form-control:focus {
        border-color: #00a0c7;
        box-shadow: 0 0 0 0.2rem rgba(0, 160, 199, 0.2);
        outline: none;
    }

    /* "To" text */
    .filter-group .text {
        font-size: var(--nf-profile-para-size);
        font-weight: 500;
        color: #5c6f82;
        margin: 0;
    }

    /* Checkbox styling */
    .filter-group .form-check-input {
        cursor: pointer;
        border: 1px solid #cbd6e2;
        transition: all 0.2s ease-in-out;
    }

    /* Checked state with custom color */
    .filter-group .form-check-input:checked {
        background-color: #00a0c7;
        border-color: #00a0c7;
    }

    /* Checkbox labels */
    .filter-group .form-check-label {
        font-size: 14px;
        color: #33475b;
        margin-left: 6px;
    }

    /* Small heading (More options) */
    .filter-group small {
        font-weight: 600;
        font-size: 13px;
        color: #5c6f82;
    }

    /* for the scroll  bar of the hidden col-md-2 */
    #filterPanel {
        height: 90%;
        /* full height of parent */
        display: flex;
        flex-direction: column;
    }

    .filter-content {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .filter-scrollable {
        flex: 1;
        max-height: 700px;
        /* set max height as per your UI */
        overflow-y: auto;
        /* scrollbar only when content overflows */
        padding-right: 5px;
        /* avoid hiding scrollbar */
    }

    /* for date color  */
    .flatpickr-day.selected,
    .flatpickr-day.startRange,
    .flatpickr-day.endRange,
    .flatpickr-day.selected.inRange,
    .flatpickr-day.startRange.inRange,
    .flatpickr-day.endRange.inRange,
    .flatpickr-day.selected:focus,
    .flatpickr-day.startRange:focus,
    .flatpickr-day.endRange:focus,
    .flatpickr-day.selected:hover,
    .flatpickr-day.startRange:hover,
    .flatpickr-day.endRange:hover,
    .flatpickr-day.selected.prevMonthDay,
    .flatpickr-day.startRange.prevMonthDay,
    .flatpickr-day.endRange.prevMonthDay,
    .flatpickr-day.selected.nextMonthDay,
    .flatpickr-day.startRange.nextMonthDay,
    .flatpickr-day.endRange.nextMonthDay {
        background: var(--bs-brand-custom) !important;
        -webkit-box-shadow: none;
        box-shadow: none;
        color: #fff;
        border-color: var(--bs-brand-custom) !important;
    }

    .flatpickr-months .flatpickr-prev-month,
    .flatpickr-months .flatpickr-next-month {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        text-decoration: none;
        cursor: pointer;
        position: absolute;
        top: 0;
        height: 34px;
        padding: 10px;
        z-index: 3;
        color: var(--bs-brand-custom) !important;
        fill: var(--bs-brand-custom) !important;
    }

    .sidebar-label {
        font-weight: 600;
        color: #1b6b88;
    }

    .toggle-icon {
        margin-right: 8px;
        color: #1b6b88;
        cursor: pointer;
    }

    .search-side i {
        cursor: pointer;
        color: #1b6b88;
    }

    /* filter panel style */
    #filterPanel .filter-content {
        min-height: 100vh;
        border-right: 1px solid #e6eef5;
        background: #fff;
        padding: 8px 8px 8px 7px;
    }

    #filterPanel .exit-search {
        color: #198fb7;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
        font-size: 0.8rem;
    }

    #filterPanel h6 {
        margin-bottom: 12px;
        color: #1f6e89;
        font-weight: 700;
        font-size: 16px;
    }

    .filter-group {
        margin-bottom: 14px;
    }

    .filter-label {
        font-size: 0.95rem;
        color: #475569;
        margin-bottom: 6px;
        display: block;
    }

    /* merged content style */
    #mergedContent {
        background: #fff;
        min-height: 100vh;
        border-left: 1px solid #e6eef5;
        padding: 20px;
    }

    .search-bar {
        border: 2px solid #00a0c7;
        border-radius: 6px;
        padding: 8px 12px;
    }

    .search-input {
        border: none;
        outline: none;
        width: 100%;
    }

    .search-top {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 12px;
    }

    .result-empty {
        text-align: center;
        padding-top: 60px;
        color: #9aa8b6;
    }

    .result-empty img {
        max-width: 160px;
        opacity: 0.9;
    }

    .list-column {
        background: #fff;
        border-right: 1px solid #eef5f8;
        min-height: 100vh;
        /* padding: 10px; */
    }

    .small {
        border-radius: clamp(2px, 0.3125vw, 3px);
        font-weight: 600;
        transition: 150ms ease-out;
        color: rgb(153, 172, 194);
        cursor: not-allowed;
        text-decoration: none;
        font-size: var(--nf-profile-para-size);
    }

    .right-sidebar-header .btn-group:first-child button {
        white-space: nowrap;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .actions-menu {
        position: absolute;
        bottom: 2.5rem;
        left: 14.375rem;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 0.375rem;
        padding: 0.375rem 0;
        min-width: 11.5rem;
        box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.15);
        z-index: 1000;
    }

    .cus-dropcol-2 {
        color: var(--theme-on-text-medium);
        padding: 0.5rem;
        font-size: 0.8rem;
    }

    .cus-dropcol-2:hover {
        background-color: #e5f5f8 !important;
        color: var(--theme-on-text-medium) !important;
    }

    /* Sidebar scrollable containers */
    #sortable-container-1,
    #sortable-container-2,
    #sortable-container-3 {
        max-height: 80vh;
        overflow-y: auto;
        padding-right: 0.625rem;
    }

    #sortable-container-1::-webkit-scrollbar,
    #sortable-container-2::-webkit-scrollbar,
    #sortable-container-3::-webkit-scrollbar {
        width: 0.375rem;
    }

    #sortable-container-1::-webkit-scrollbar-track,
    #sortable-container-2::-webkit-scrollbar-track,
    #sortable-container-3::-webkit-scrollbar-track {
        background-color: #f1f1f1;
        border-radius: 0.25rem;
    }

    #sortable-container-1::-webkit-scrollbar-thumb,
    #sortable-container-2::-webkit-scrollbar-thumb,
    #sortable-container-3::-webkit-scrollbar-thumb {
        background-color: #999;
        border-radius: 0.25rem;
    }

    #sortable-container-1::-webkit-scrollbar-thumb:hover,
    #sortable-container-2::-webkit-scrollbar-thumb:hover,
    #sortable-container-3::-webkit-scrollbar-thumb:hover {
        background-color: var(--theme-on-text-medium);
    }

    /* Sidebar scrollable containers End  */

    /* ////////////////custom-hide se4arch bar dropdown //////////////////////////// */
    /* Custom dropdown menu style */
    .dropdown-menu.cust-hide-search {
        min-width: 156px;
        max-height: 221px;
        overflow-y: auto;
        border-radius: 0.5rem;
        border: 1px solid #dee2e6;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        padding: 0.5rem 0;
        left: 58% !important;
        transform: translateX(-50% -50%) !important;
        top: 100% !important;
    }

    /* Dropdown items inside */
    .dropdown-menu.cust-hide-search .dropdown-item {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        color: #212529;
        transition: all 0.2s ease;
    }

    /* Hover / active state */
    .dropdown-menu.cust-hide-search .dropdown-item:hover,
    .dropdown-menu.cust-hide-search .dropdown-item:focus {
        background-color: #e5f5f8;
        color: var(--theme-on-text-medium);
    }

    /* Divider inside custom menu */
    .dropdown-menu.cust-hide-search .dropdown-divider {
        margin: 0.5rem 0;
    }

    .unassign-btn {
        background-color: #e5f5f8;
        border: solid 1px (--theme-on-text-medium);
        border-radius: 5px;
        color: var(--theme-on-text-medium);
        font-size: var(--nf-profile-para-size);
    }

    .item-user-name,
    .item-user-status {
        font-size: var(--nf-profile-para-size);
    }

    /* /////////custome my row  /////////////// */
    .no-left-padding > * {
        padding-left: 0 !important;
    }
</style>
<!-- Ashter working css end  -->
