<style>
    /*
* Theme-on Root Variables
*/
    :root {
        /* Font Variables */
        --font-family-base: "Lexend Deca", "Noto Sans", Helvetica, Arial, sans-serif;
        --font-family-heading: "Lexend Deca", "Noto Sans", Helvetica, Arial,
        sans-serif;
        --font-base: clamp(0.85rem, 1vw, 1rem);
        --nf-profile-para-size: clamp(0.8125rem, 0.95vw, 0.9375rem);
        --font-size-sm: clamp(
            0.75rem,
            0.875vw,
            0.875rem
        ); /* Added for smaller text */
        --font-size-lg: clamp(1rem, 1.25vw, 1.25rem); /* Added for headings */
        --line-height-base: 1.5; /* Nifty's standard line height */
        --line-height-sm: 1.2; /* Nifty's compact line height */
        --letter-spacing-base: 0; /* Nifty's default letter spacing */
        --letter-spacing-heading: 0.02em; /* Nifty's heading letter spacing */

        /* Color Variables */
        --bs-brand-custom: #0091ae; /* Primary brand color */
        --bs-brand-secondary: #1c75bc; /* Secondary brand color, renamed from --primary-blue */
        --nf-mainnav-bg: #2d3e50; /* Navigation background */
        --nf-mainnav-color: #9aa8b6;
        --theme-on-background-light: #f0f2f5; /* Light background */
        --theme-on-background-secondary: #f5f8fa; /* Secondary background */
        --theme-on-border: #e0e0e0; /* Primary border */
        --theme-on-border-secondary: #ebedf0; /* Secondary border */
        --theme-on-text-dark: #33475b; /* Primary text color */
        --theme-on-text-medium: #555; /* Secondary text color */
        --theme-on-text-light: #888; /* Muted text color */
        --theme-on-link: #0a89b4; /* Link color */
        --theme-on-accent: #00bda5; /* Accent color */
        --theme-on-success: #00b894; /* Success color */
        --theme-on-info: #d1d9e2; /* Info color */
        --theme-on-active-bg: #e5f5f8; /* Active/hover background */
        --theme-on-gray-100: #e9ecef; /* Light gray */
        --theme-on-gray-200: #ccc; /* Medium gray */
        --theme-on-gray-300: #ddd; /* Light-medium gray */
        --theme-on-gray-400: #c5c6c7; /* Added for additional gray shade */
        --theme-on-gray-500: #d6d4d4; /* Added for scrollbar */
        --theme-on-gray-600: #dee2e6; /* Added for borders */
        --theme-on-gray-700: #f1f1f1; /* Added for backgrounds */
        --theme-on-text-accent: #1b6b88; /* Accent text color */
        --theme-on-text-link-alt: #198fb7; /* Alternative link color */
        --theme-on-text-heading: #1f6e89; /* Heading text color */
        --theme-on-active-icon: #6a78d1; /* Active envelope icon color */
        --theme-on-empty-text: #9aa8b6; /* Empty result text color */

        /* Layout Variables */
        --panel-width: 280px;
        --sidebar-width: clamp(200px, 16.66667vw, 300px);
        --padding-base: clamp(0.5rem, 1vw, 1rem);
        background-color: var(--theme-on-background-light);
    }

    html,
    body {
        overflow: hidden;
        height: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
        font-family: var(--font-family-base);
        font-size: var(--font-base);
        line-height: var(--line-height-base);
        color: var(--theme-on-text-dark);
    }

    .custome-email-body {
        min-height: 100vh;
        background-color: var(--theme-on-background-light);
        font-family: var(--font-family-base);
        min-width: 100vh;
    }

    .row.g-0 {
        height: 100vh;
        display: flex;
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
        background-color: var(--theme-on-background-light); /* Added to match Nifty */
        font-family: var(--font-family-base);
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
        font-family: var(--font-family-base);
        font-weight: 500;
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
        font-size: var(--font-size-lg);
        font-weight: 700;
        color: var(--theme-on-text-heading);
        display: flex;
        align-items: center;
        font-family: var(--font-family-heading);
        letter-spacing: var(--letter-spacing-heading);
    }

    .main-heading .fa-circle {
        color: var(--theme-on-success);
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
        font-family: var(--font-family-base);
        font-size: var(--nf-profile-para-size);
        line-height: var(--line-height-sm);
    }

    .list-group-item:hover,
    .list-group-item.active {
        background-color: var(--bs-primary);
        color: var(--nf-mainnav-link-color) !important;
        /* font-weight: 600; */
    }

    .list-group-item.active {
        /*border-left: clamp(0.1rem, 0.1875vw, 0.1875rem) solid var(--bs-brand-custom);*/
        padding-left: calc(
            clamp(0.4rem, 0.625vw, 0.625rem) - clamp(0.1rem, 0.1875vw, 0.1875rem)
        );
        border-radius: 5px;
    }

    .list-group-item .badge {
        background-color: var(--nf-mainnav-link-color) !important;
        color: var(--theme-on-text-light);
        font-size: 0.7rem;
        font-weight: 400;
        padding: 5px 5px;
    }

    .list-group-item.active .badge {
        font-weight: 600;
    }

    .less-link {
        color: var(--theme-on-link) !important;
        font-weight: 600 !important;
        font-family: var(--font-family-base);
        font-size: var(--nf-profile-para-size);
    }

    .email-body-bottom-button {
        margin-bottom: clamp(1.9rem, 1.25vw, 1.25rem);
        padding-bottom: 10px;
    }

    .email-body-bottom-button button {
        border: 1px solid var(--theme-on-gray-200);
        padding: clamp(0.3rem, 0.4vw, 0.4rem);
        border-radius: clamp(0.1rem, 0.1875vw, 0.1875rem);
        font-weight: 600;
        font-size: var(--nf-profile-para-size);
        font-family: var(--font-family-base);
    }

    .email-body-bottom-button .button-one {
        background-color: var(--theme-on-info);
        color: var(--theme-on-text-dark);
    }

    .email-body-bottom-button .button-two {
        background-color: var(--nf-mainnav-bg);
        color: #fff;
    }

    .email-body-bottom-button .button-one i {
        color: var(--theme-on-text-dark);
    }

    .emails-wrapper {
        max-height: 90%;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--theme-on-gray-500) var(--theme-on-gray-700);
    }

    .custom-tab-pane {
        max-height: clamp(32.5rem, 52.25vh, 52.25rem);
        overflow-y: auto;
        padding-right: clamp(0.2rem, 0.3125vw, 0.3125rem);
    }

    .main-email-area-section {
        max-height: clamp(32.5rem, 52.25vh, 52.25rem) !important;
    }
    .custom-tab-pane::-webkit-scrollbar {
        width: clamp(0.3rem, 0.375vw, 0.375rem);
    }

    .custom-tab-pane::-webkit-scrollbar-thumb {
        background: var(--theme-on-gray-500);
        border-radius: clamp(0.2rem, 0.25vw, 0.25rem);
    }

    .custom-tab-pane::-webkit-scrollbar-thumb:hover {
        background: var(--theme-on-text-light);
    }

    .uppper-part-main {
        background-color: #fff;
        border-right: 1px solid var(--theme-on-border);
        overflow-y: auto;
        flex-grow: 1;
    }

    .uppper-part {
        background-color: #fff;
        border-bottom: 1px solid var(--theme-on-border);
        max-height: 48px;
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
        font-weight: 400;
        content: "\f0c8";
        font-size: var(--nf-profile-para-size);
        color: var(--theme-on-text-medium);
        border-radius: clamp(0.2rem, 0.25vw, 0.25rem);
        padding: clamp(0.1rem, 0.125vw, 0.125rem);
        display: inline-block;
        width: 1.5em;
        text-align: center;
    }

    .custom-checkbox input:checked + .check-icon::before {
        font-weight: 900;
        content: "\f14a";
        color: var(--bs-brand-custom);
        border-color: var(--bs-brand-custom);
    }

    .uppper-part .open-btn,
    .uppper-part .close-btn {
        border: none;
        font-weight: 600;
        padding: clamp(0.3rem, 0.5vw, 0.5rem) clamp(0.4rem, 0.625vw, 0.625rem);
        font-family: var(--font-family-base);
        font-size: var(--nf-profile-para-size);
    }

    .uppper-part .open-btn {
        background-color: var(--theme-on-info);
        border-radius: clamp(0.1rem, 0.1875vw, 0.1875rem) 0 0
        clamp(0.1rem, 0.1875vw, 0.1875rem);
        color: var(--theme-on-text-dark);
    }

    .uppper-part .close-btn {
        background-color: var(--nf-mainnav-bg);
        color: #fff;
        border-radius: 0 clamp(0.1rem, 0.1875vw, 0.1875rem)
        clamp(0.1rem, 0.1875vw, 0.1875rem) 0;
    }

    .uppper-part .upper-text {
        color: var(--theme-on-link);
        font-weight: 600;
        font-size: var(--nf-profile-para-size);
        font-family: var(--font-family-base);
    }

    .email-main-body {
        background-color: #fff;
        border-bottom: 1px solid var(--theme-on-border);
        padding: clamp(0.3rem, 0.5vw, 0.5rem) clamp(0.4rem, 0.625vw, 0.625rem);
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .email-main-body:hover {
        background-color: var(--bs-primary);
    }

    .email-main-body.active-email {
        background-color: var(--theme-on-active-bg);
        border-left: clamp(0.1rem, 0.1875vw, 0.1875rem) solid var(--bs-brand-custom);
        padding-left: calc(
            clamp(0.4rem, 0.625vw, 0.625rem) - clamp(0.1rem, 0.1875vw, 0.1875rem)
        );
    }

    .active-enelops {
        background-color: var(--theme-on-active-icon) !important;
        color: #fff;
        padding: clamp(0.3rem, 0.5vw, 0.5rem);
        border-radius: 50%;
        font-size: var(--nf-profile-para-size);
        font-family: var(--font-family-base);
    }

    .email-main-body .fa-envelope {
        background-color: var(--theme-on-info);
        color: #fff;
        padding: clamp(0.8rem, 0.5vw, 0.5rem);
        border-radius: 50%;
        font-size: var(--nf-profile-para-size);
    }

    /* .email-main-body .email-address {
    font-size: var(--nf-profile-para-size);
    font-weight: 600;
    line-height: var(--line-height-sm);
    color: var(--theme-on-text-dark);
    font-family: var(--font-family-base);
    word-break: break-all;
    overflow-wrap: break-word;
    white-space: normal; /
    } */

    .email-address {
        max-width: 180px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        position: relative;
        cursor: pointer;
    }
    .main-area-email-para-right-sidebar {
        max-width: 180px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        position: relative;
        cursor: pointer;
    }
    /* Custom tooltip (created via jQuery) */
    /* .tooltip-box {
    position: absolute;
    background: #333;
    color: #fff;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 0.875rem;
    white-space: nowrap;
    z-index: 9999;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    display: none;
    } */

    .email-main-body .email-subject {
        font-size: var(--nf-profile-para-size);
        font-weight: 400;
        font-family: var(--font-family-base);
    }

    .email-main-body .small-para {
        font-size: var(--nf-profile-para-size);
        line-height: var(--line-height-sm);
        font-family: var(--font-family-base);
    }

    .email-main-body .para-second {
        font-size: var(--nf-profile-para-size);
        /* color: var(--theme-on-text-light); */
        white-space: nowrap;
        font-family: var(--font-family-base);
    }

    .email-main-body.active-email .email-address,
    .email-main-body.active-email .email-subject {
        color: var(--nf-mainnav-link-color) !important;
        font-weight: 600;
    }

    .email-main-body.active-email .small-para {
        color: var(--theme-on-text-dark) !important;
    }
    p.email-subject {
        display: block;
        white-space: normal;
        word-break: break-word;
        overflow-wrap: break-word;
    }

    /* Main Email View */
    .main-email-area-section {
        background-color: #fff;
        min-height: 100vh;
        border-right: 1px solid var(--theme-on-border);
        flex-grow: 2;
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
        font-weight: 600;
        color: #fff;
        font-size: var(--nf-profile-para-size);
        overflow: hidden;
        flex-shrink: 0;
        font-family: var(--font-family-base);
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
        line-height: var(--line-height-sm);
        color: var(--theme-on-text-dark);
        font-family: var(--font-family-base);
    }

    .main-area-email-para-time {
        font-size: var(--nf-profile-para-size);
        color: var(--theme-on-text-light);
        font-family: var(--font-family-base);
    }

    .close-convo-btn {
        font-size: var(--nf-profile-para-size);
        font-weight: 600;
        color: var(--theme-on-text-dark);
        font-family: var(--font-family-base);
    }

    .profile-description {
        font-size: var(--nf-profile-para-size);
        font-style: normal;
        font-weight: 600;
        text-transform: none;
        margin: 0;
        padding: 0;
        font-family: var(--font-family-heading);
        letter-spacing: var(--letter-spacing-heading);
        line-height: clamp(0.9rem, 1.125vw, 1.125rem);
        color: var(--theme-on-text-dark);
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
        border: clamp(0.1rem, 0.125vw, 0.125rem) solid #fff;
    }

    .user_name {
        color: var(--bs-brand-custom);
        font-weight: 600;
        font-size: var(--nf-profile-para-size);
        font-family: var(--font-family-base);
    }

    .email-info-text,
    .date-time {
        font-size: var(--nf-profile-para-size);
        color: var(--theme-on-text-dark);
        font-family: var(--font-family-base);
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
        font-family: var(--font-family-base);
        height: 38hvh;
    }

    /*.email-reply-block .last-span {*/
    /*    font-size: var(--nf-profile-para-size);*/
    /*    font-family: var(--font-family-base);*/
    /*}*/

    .email-reply-block .last-span .last-span-icon {
        color: var(--bs-brand-custom);
    }

    .email-reply-block .email-reply-address {
        color: var(--bs-brand-custom);
        font-weight: 700;
        font-family: var(--font-family-base);
    }

    .enlarge-icon {
        color: var(--bs-brand-custom);
        font-weight: 700;
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
        font-family: var(--font-family-base);
    }

    .text-placeholder {
        font-size: var(--nf-profile-para-size);
        color: var(--theme-on-text-light);
        cursor: text;
        flex-grow: 1;
        /*padding-bottom: clamp(3.5rem, 4.375vh, 4.375rem);*/
        outline: none;
        font-family: var(--font-family-base);
    }

    .email-area-choose-reciepeint {
        font-size: var(--nf-profile-para-size);
        font-family: var(--font-family-base);
    }

    .email-area-choose-reciepeint .email-area-input-for-recipeint {
        font-size: var(--nf-profile-para-size);
        border: none;
        width: auto;
        font-family: var(--font-family-base);
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
        color: var(--theme-on-text-dark);
    }

    .editor-icon.fa-ellipsis-h {
        color: var(--theme-on-text-light);
    }

    .insert-btn,
    .send-option-btn {
        font-size: var(--nf-profile-para-size);
        padding: clamp(0.3rem, 0.375vw, 0.375rem) clamp(0.6rem, 0.75vw, 0.75rem);
        border-radius: clamp(1.25rem, 1.5625vw, 1.5625rem);
        font-weight: 600;
        border: 1px solid var(--theme-on-gray-300);
        background-color: #fff;
        color: var(--nf-mainnav-bg);
        display: flex;
        align-items: center;
        font-family: var(--font-family-base);
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
        color: var(--theme-on-text-dark);
        border-radius: clamp(0.25rem, 0.3125vw, 0.3125rem);
        font-size: var(--nf-profile-para-size);
        font-weight: 600;
        font-family: var(--font-family-base);
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
        color: var(--theme-on-text-light);
        border: none;
        border-radius: 4px;
        font-size: var(--nf-profile-para-size);
        padding: clamp(0.2rem, 0.6vw, 0.4rem) clamp(0.8rem, 1vw, 1.2rem);
        max-width: 100%;
        width: auto;
        white-space: normal;
        text-align: center;
        line-height: 1.3;
        word-break: break-word;
        box-sizing: border-box;
        font-family: var(--font-family-base);
        font-weight: 500;
    }

    .right-sidebar-header .btn-group button:not(:first-child) {
        border-left: 1px solid var(--theme-on-text-medium);
    }

    .right-sidebar-header .info-circle-iconnn {
        border-left: none;
    }

    .contact-info-item {
        margin-bottom: clamp(0.5rem, 0.625vw, 0.625rem);
    }

    .contact-info-item .info-label {
        font-size: var(--nf-profile-para-size);
        color: var(--theme-on-text-light);
        margin-bottom: clamp(0.2rem, 0.25vw, 0.25rem);
        font-family: var(--font-family-base);
        font-weight: 500;
    }

    .contact-info-item .info-value {
        font-size: var(--nf-profile-para-size);
        color: var(--theme-on-text-dark);
        font-weight: 600;
        font-family: var(--font-family-base);
    }

    .right-sidebar hr {
        margin-top: clamp(0.5rem, 0.625vw, 0.625rem);
        margin-bottom: clamp(0.5rem, 0.625vw, 0.625rem);
        border-color: var(--theme-on-gray-400);
    }

    .right-sidebar-profile-avator {
        background-color: var(--theme-on-info);
    }

    .main-area-email-para-right-sidebar {
        color: var(--bs-brand-custom);
        font-size: var(--nf-profile-para-size);
        font-weight: 600;
        font-family: var(--font-family-base);
    }

    .right-sidebar-down-icon {
        color: var(--theme-on-text-link-alt);
        font-size: clamp(1.2rem, 1.5vw, 1.5rem);
    }

    .right-sidebar-circle-icon {
        font-size: var(--nf-profile-para-size);
    }

    .right-sidebar-text-span {
        font-size: var(--nf-profile-para-size);
        font-weight: 600;
        color: var(--theme-on-text-dark);
        font-family: var(--font-family-base);
    }

    /* Logical CSS */
    .selected-enelop {
        color: var(--bs-brand-custom);
        font-size: var(--nf-profile-para-size);
        margin-left: clamp(0.2rem, 0.25vw, 0.25rem);
        font-family: var(--font-family-base);
    }

    .selected-actions .btn-group .btn {
        border-radius: clamp(0.3rem, 0.375vw, 0.375rem) !important;
        font-family: var(--font-family-base);
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
        font-family: var(--font-family-base);
        font-size: var(--nf-profile-para-size);
        background-color: #fff;
        border: 1px solid var(--theme-on-gray-600);
    }

    .email-compose-box {
        position: relative;
        background-color: #fff;
        border: 1px solid var(--theme-on-gray-200);
        border-radius: clamp(0.4rem, 0.5vw, 0.5rem);
        width: 100%;
        max-height: 180px;
        max-width: 100%;
        min-width: 0;
        overflow-y: auto;
        overflow-x: hidden;
        padding: clamp(0.5rem, 0.625vw, 0.625rem);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
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
        background-color: var(--theme-on-gray-100);
        border-radius: clamp(0.6rem, 0.75vw, 0.75rem);
        padding: clamp(0.2rem, 0.25vw, 0.25rem) clamp(0.4rem, 0.5vw, 0.5rem);
        margin: clamp(0.1rem, 0.125vw, 0.125rem);
        font-size: var(--nf-profile-para-size);
        color: var(--theme-on-text-dark);
        font-family: var(--font-family-base);
    }

    .recipient-tag-remove {
        margin-left: clamp(0.4rem, 0.5vw, 0.5rem);
        cursor: pointer;
        font-weight: 600;
    }

    .email-area-input-for-recipient {
        border: none;
        outline: none;
        background: none;
        flex-grow: 1;
        min-width: 0;
        font-family: var(--font-family-base);
        font-size: var(--nf-profile-para-size);
    }

    .email-area-choose-recipient {
        width: 100%;
        font-family: var(--font-family-base);
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
        font-family: var(--font-family-base);
    }

    .fullscreen-close:hover {
        color: var(--theme-on-text-dark);
    }

    .icon-checkbox-wrapper {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    /* Initially hide checkbox */
    .icon-checkbox-wrapper .custom-checkbox {
        display: none;
        opacity: 0;
        transform: scale(0.9);
        transition: all 0.25s ease;
    }

    /* Hide icon and show checkbox on hover */
    .icon-checkbox-wrapper:hover .fa-envelope {
        opacity: 0;
        transform: scale(0.8);
    }

    .icon-checkbox-wrapper:hover .custom-checkbox {
        display: inline-flex;
        opacity: 1;
        transform: scale(1);
    }

    /* --- HubSpot-style custom checkbox --- */
    .icon-checkbox-wrapper {
        position: relative;
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    /* Icon and checkbox stacked on top of each other */
    .icon-checkbox-wrapper i,
    .icon-checkbox-wrapper .custom-checkbox {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.25s ease, transform 0.25s ease;
    }

    /* Show icon by default */
    .icon-checkbox-wrapper i {
        opacity: 1;
        transform: scale(1);
    }

    /* Hide checkbox initially */
    .icon-checkbox-wrapper .custom-checkbox {
        opacity: 0;
        transform: scale(0.9);
        pointer-events: none; /* prevent accidental click before visible */
    }

    /* On hover: cross-fade effect */
    .icon-checkbox-wrapper:hover i {
        opacity: 0;
        transform: scale(0.9);
    }

    .icon-checkbox-wrapper:hover .custom-checkbox {
        opacity: 1;
        transform: scale(1);
        pointer-events: all;
    }

    /* --- HubSpot-style custom checkbox --- */
    .my-custom-check-box {
        display: inline-flex;
        align-items: center;
    }

    .my-custom-check-box input {
        display: none;
    }

    .my-custom-check-box .checkmark {
        width: 30px;
        height: 30px;
        border: 2px solid #cbd6e2;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        transition: all 0.25s ease;
    }

    .my-custom-check-box .checkmark svg {
        width: 12px;
        height: 12px;
        fill: transparent;
        stroke: #fff;
        stroke-width: 2;
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.25s ease;
    }

    .my-custom-check-box:hover .checkmark {
        border-color: #425b76;
        margin-left: 0px 0px 0px 0px;
    }

    .my-custom-check-box input:checked + .checkmark {
        background-color: #425b76;
        border-color: #425b76;
    }

    .my-custom-check-box input:checked + .checkmark svg {
        opacity: 1;
        fill: #fff;
        transform: scale(1);
    }

    /* end */

    /* Sidebar collapse */
    .left-sidebar-custom {
        border-right: clamp(1.5px, 4vw, 3px) solid var(--theme-on-gray-300);
        width: 105%;
        transition: width 0.3s ease-in-out, min-width 0.3s ease-in-out;
        white-space: nowrap;
        background-color: var(--theme-on-background-light);
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
        color: var(--theme-on-text-accent);
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
        color: var(--theme-on-text-dark);
        position: relative;
        font-family: var(--font-family-base);
        font-weight: 600;
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
        color: var(--theme-on-text-light);
        font-size: var(--nf-profile-para-size);
        margin-right: clamp(0.6rem, 0.75vw, 0.75rem);
    }

    .drag-handle-icon:active {
        cursor: grabbing;
    }

    .info-circle-icon {
        color: var(--theme-on-text-light);
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
        font-family: var(--font-family-base);
    }

    .custom-sidebar-content .info-label {
        color: var(--theme-on-text-light);
        font-weight: 500;
        font-family: var(--font-family-base);
    }

    .custom-sidebar-content .info-value {
        color: var(--theme-on-text-dark);
        font-family: var(--font-family-base);
    }

    .sortable-ghost {
        opacity: 0.4;
        background-color: var(--theme-on-gray-100);
        border: 1px dashed var(--theme-on-gray-200);
    }

    /* Company section */
    .company-card {
        background-color: #fff;
        border: 1px solid var(--theme-on-gray-400);
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
        font-family: var(--font-family-base);
        font-weight: 500;
    }

    .company-header .btn-primary {
        background-color: var(--bs-brand-custom);
        border-color: var(--bs-brand-custom);
        color: #fff;
    }

    .company-name {
        font-size: var(--nf-profile-para-size);
        font-weight: 600;
        color: var(--theme-on-text-dark);
        font-family: var(--font-family-base);
    }

    .company-link a {
        color: var(--bs-brand-custom);
        text-decoration: none;
        font-family: var(--font-family-base);
        font-size: var(--nf-profile-para-size);
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
        font-family: var(--font-family-base);
    }

    /* Other conversations */
    .other-conversations-section {
        background-color: #fff;
        padding: clamp(0.5rem, 0.625vw, 0.625rem);
        border: 1px solid var(--theme-on-gray-400);
    }

    .other-conversations-section-ptwo {
        font-weight: 700;
        font-size: var(--nf-profile-para-size);
        color: var(--bs-brand-custom);
        text-decoration: none;
        font-family: var(--font-family-base);
    }

    .other-conversations-section-pone {
        font-size: var(--nf-profile-para-size);
        font-family: var(--font-family-base);
    }

    /* Right sidebar contacts */
    .contacts-section {
        background-color: #fff;
        padding: clamp(0.5rem, 0.625vw, 0.625rem);
        border: 1px solid var(--theme-on-gray-400);
    }

    .contacts-section .contacts-section-para {
        font-size: var(--nf-profile-para-size);
        font-family: var(--font-family-base);
    }

    .right-sec-payment-btn {
        background-color: var(--theme-on-info);
        border-radius: clamp(0.15rem, 0.1875vw, 0.1875rem) 0 0
        clamp(0.15rem, 0.1875vw, 0.1875rem);
        padding: clamp(0.4rem, 0.5vw, 0.5rem) clamp(0.5rem, 0.625vw, 0.625rem);
        border: none;
        color: var(--theme-on-text-dark);
        font-family: var(--font-family-base);
        font-weight: 500;
    }

    .email-header-main {
        /*padding: clamp(0.9rem, 1.125vw, 1.125rem) clamp(0.5rem, 0.625vw, 0.625rem)*/
        /*clamp(0.95rem, 1.1875vw, 1.1875rem) clamp(0.5rem, 0.625vw, 0.625rem);*/
        padding: 10px 0px;
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
        background: var(--theme-on-background-secondary);
        border: 1px solid var(--theme-on-gray-200);
        padding: clamp(0.4rem, 0.5vw, 0.5rem) clamp(0.7rem, 0.875vw, 0.875rem);
        border-radius: clamp(0.25rem, 0.3125vw, 0.3125rem);
        cursor: pointer;
        font-size: var(--nf-profile-para-size);
        font-family: var(--font-family-base);
        color: var(--theme-on-text-dark);
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
        font-family: var(--font-family-base);
        color: var(--theme-on-text-dark);
    }

    .custom-menu li:hover {
        background: var(--theme-on-background-secondary);
    }

    .email-reply-wrapper {
        max-height: clamp(120rem, 12.5vh, 12.5rem);
        overflow-y: auto;
        padding-right: clamp(0.4rem, 0.5vw, 0.5rem);
        max-width: clamp(20rem, 33vw, 39rem);
    }

    .email-reply-wrapper::-webkit-scrollbar {
        width: clamp(0.3rem, 0.375vw, 0.375rem);
    }

    .email-reply-wrapper::-webkit-scrollbar-thumb {
        background-color: var(--theme-on-gray-500);
        border-radius: clamp(0.2rem, 0.25vw, 0.25rem);
    }

    .email-reply-wrapper::-webkit-scrollbar-thumb:hover {
        background-color: var(--theme-on-text-light);
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
        font-family: var(--font-family-base);
        font-size: var(--nf-profile-para-size);
        color: var(--theme-on-text-dark);
        height: 120vh;
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
        color: var(--theme-on-text-dark);
        text-decoration: none;
        font-size: var(--nf-profile-para-size);
        font-family: var(--font-family-base);
    }

    .custom-dropdown a:hover {
        background: var(--theme-on-background-secondary);
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
        background: var(--theme-on-gray-500);
        border-radius: clamp(0.2rem, 0.25vw, 0.25rem);
    }

    #sortable-container::-webkit-scrollbar-thumb:hover {
        background: var(--theme-on-text-light);
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
        left: 120%;
        transform: translateX(-50%);
        z-index: 1000;
        min-width: clamp(22.5rem, 15.625vw, 23.625rem);
        background-color: #fff;
        border: 1px solid var(--theme-on-gray-200);
        box-shadow: 0 clamp(0.2rem, 0.25vw, 0.25rem) clamp(0.3rem, 0.375vw, 0.375rem)
        rgba(0, 0, 0, 0.1);
        border-radius: clamp(0.4rem, 0.5vw, 0.5rem);
        padding: clamp(0.5rem, 0.625vw, 0.625rem);
        margin-top: clamp(0.5rem, 0.625vw, 0.625rem);
        display: none;
        font-family: var(--font-family-base);
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
        border: 1px solid var(--bs-brand-custom);
        border-radius: clamp(0.25rem, 0.3125vw, 0.3125rem);
        font-size: var(--nf-profile-para-size);
        color: var(--theme-on-text-dark);
        outline: none;
        font-family: var(--font-family-base);
    }

    .user-dropdown-menu .search-box input::placeholder {
        color: var(--theme-on-text-light);
    }

    .user-dropdown-menu .search-box .search-icon {
        position: absolute;
        right: clamp(0.75rem, 0.9375vw, 0.9375rem);
        top: 50%;
        transform: translateY(-50%);
        color: var(--bs-brand-custom);
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
        color: var(--theme-on-text-dark);
        margin-bottom: 6px;
        display: block;
        font-family: var(--font-family-base);
    }

    /* Date inputs */
    .filter-group input[type="date"].form-control {
        background-color: var(--theme-on-background-secondary);
        border: 1px solid var(--theme-on-gray-600);
        border-radius: 4px;
        padding: 8px 12px;
        font-size: var(--nf-profile-para-size);
        color: var(--theme-on-text-dark);
        transition: border-color 0.2s ease-in-out;
        font-family: var(--font-family-base);
    }

    /* Hover / focus effect */
    .filter-group input[type="date"].form-control:hover,
    .filter-group input[type="date"].form-control:focus {
        border-color: var(--bs-brand-custom);
        box-shadow: 0 0 0 0.2rem rgba(0, 145, 174, 0.2);
        outline: none;
    }

    /* "To" text */
    .filter-group .text {
        font-size: var(--nf-profile-para-size);
        font-weight: 500;
        color: var(--theme-on-text-light);
        margin: 0;
        font-family: var(--font-family-base);
    }

    /* Checkbox styling */
    .filter-group .form-check-input {
        cursor: pointer;
        border: 1px solid var(--theme-on-gray-600);
        transition: all 0.2s ease-in-out;
    }

    /* Checked state with custom color */
    .filter-group .form-check-input:checked {
        background-color: var(--bs-brand-custom);
        border-color: var(--bs-brand-custom);
    }

    /* Checkbox labels */
    .filter-group .form-check-label {
        font-size: 14px;
        color: var(--theme-on-text-dark);
        margin-left: 6px;
        font-family: var(--font-family-base);
    }

    /* Small heading (More options) */
    .filter-group small {
        font-weight: 600;
        font-size: 13px;
        color: var(--theme-on-text-light);
        font-family: var(--font-family-base);
    }

    /* for the scroll bar of the hidden col-md-2 */
    #filterPanel {
        height: 90%;
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
        overflow-y: auto;
        padding-right: 5px;
    }

    /* for date color */
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
        box-shadow: none;
        color: #fff;
        border-color: var(--bs-brand-custom) !important;
    }

    .flatpickr-months .flatpickr-prev-month,
    .flatpickr-months .flatpickr-next-month {
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
        color: var(--theme-on-text-accent);
        font-family: var(--font-family-base);
        font-size: var(--nf-profile-para-size);
    }

    .toggle-icon {
        margin-right: 8px;
        color: var(--nf-mainnav-link-color);
        cursor: pointer;
    }

    .search-side i {
        cursor: pointer;
        color: var(--theme-on-text-accent);
    }

    /* filter panel style */
    #filterPanel .filter-content {
        min-height: 100vh;
        border-right: 1px solid var(--theme-on-border-secondary);
        background: #fff;
        padding: 8px 8px 8px 7px;
    }

    #filterPanel .exit-search {
        color: var(--theme-on-text-link-alt);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
        font-size: 0.8rem;
        font-family: var(--font-family-base);
    }

    #filterPanel h6 {
        margin-bottom: 12px;
        color: var(--theme-on-text-heading);
        font-weight: 700;
        font-size: 16px;
        font-family: var(--font-family-heading);
    }

    .filter-group {
        margin-bottom: 14px;
    }

    .filter-label {
        font-size: 0.95rem;
        color: var(--theme-on-text-dark);
        margin-bottom: 6px;
        display: block;
        font-family: var(--font-family-base);
    }

    /* merged content style */
    #mergedContent {
        background: #fff;
        min-height: 100vh;
        border-left: 1px solid var(--theme-on-border-secondary);
        padding: 20px;
    }

    .search-bar {
        border: 2px solid var(--bs-brand-custom);
        border-radius: 6px;
        padding: 8px 12px;
    }

    .search-input {
        border: none;
        outline: none;
        width: 100%;
        font-family: var(--font-family-base);
        font-size: var(--nf-profile-para-size);
        color: var(--theme-on-text-dark);
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
        color: var(--theme-on-empty-text);
        font-family: var(--font-family-base);
    }

    .result-empty img {
        max-width: 160px;
        opacity: 0.9;
    }

    .list-column {
        background: #fff;
        border-right: 1px solid var(--theme-on-border-secondary);
        min-height: 100vh;
    }

    .small {
        border-radius: clamp(2px, 0.3125vw, 3px);
        /* font-weight: 600; */
        transition: 150ms ease-out;
        color: var(--theme-on-empty-text);
        cursor: not-allowed;
        text-decoration: none;
        /*font-size: var(--nf-profile-para-size);*/
        font-family: var(--font-family-base);
    }

    .email-from {
        font-size: 0.7rem;
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
        border: 1px solid var(--theme-on-gray-300);
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
        font-family: var(--font-family-base);
    }

    .cus-dropcol-2:hover {
        background-color: var(--theme-on-active-bg) !important;
        color: var(--theme-on-text-dark) !important;
    }

    /* Sidebar scrollable containers */
    .sortable-container-main {
        max-height: 76vh;
        overflow-y: auto;
        padding-right: 0.625rem;
    }

    .sortable-container-main::-webkit-scrollbar {
        width: 0.375rem;
    }

    .sortable-container-main::-webkit-scrollbar-track {
        background-color: var(--theme-on-gray-700);
        border-radius: 0.25rem;
    }

    .sortable-container-main::-webkit-scrollbar-thumb {
        background-color: var(--theme-on-gray-500);
        border-radius: 0.25rem;
    }

    .sortable-container-main::-webkit-scrollbar-thumb:hover {
        background-color: var(--theme-on-text-medium);
    }

    /* Custom dropdown menu style */
    .dropdown-menu.cust-hide-search {
        min-width: 156px;
        max-height: 221px;
        overflow-y: auto;
        border-radius: 0.5rem;
        border: 1px solid var(--theme-on-gray-600);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        padding: 0.5rem 0;
        left: 58% !important;
        transform: translateX(-50% -50%) !important;
        top: 100% !important;
        font-family: var(--font-family-base);
        background-color: #fff;
    }

    .dropdown-menu.cust-hide-search .dropdown-item {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        color: var(--theme-on-text-dark);
        transition: all 0.2s ease;
        font-family: var(--font-family-base);
    }

    .dropdown-menu.cust-hide-search .dropdown-item:hover,
    .dropdown-menu.cust-hide-search .dropdown-item:focus {
        background-color: var(--theme-on-active-bg);
        color: var(--theme-on-text-dark);
    }

    .dropdown-menu.cust-hide-search .dropdown-divider {
        margin: 0.5rem 0;
    }

    .unassign-btn {
        background-color: rgb(234, 240, 246);
        border: 1px solid rgb(203, 214, 226);
        border-radius: 3px;
        color: var(--theme-on-text-medium);
        font-size: var(--nf-profile-para-size);
        font-family: var(--font-family-base);
    }

    .item-user-name,
    .item-user-status {
        font-size: var(--nf-profile-para-size);
        font-family: var(--font-family-base);
    }

    /* Custom my row */
    .no-left-padding > * {
        padding-left: 0 !important;
    }

    .toggle-icon {
        transition: transform 0.011s ease;
    }

    .rotate {
        transform: rotate(90deg);
    }

    .email-part-contents {
        position: relative;
        background: #fff;
        /* border: 1px solid var(--theme-on-gray-300);
        border-radius: 8px; */
        padding: 1.5rem;
        width: 100%;
        height: 508px;
        max-width: 100%;
        min-width: 0;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        overflow-y: auto;
        overflow-x: hidden;
        scroll-behavior: smooth;
        box-sizing: border-box;
        font-family: var(--font-family-base);
    }

    /* 10-october css */

    .userbox-trigger {
        position: relative;
        cursor: pointer;
        color: var(--theme-on-text-accent);
    }

    .userbox-container {
        position: absolute;
        top: 111px;
        background: #fff;
        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.1);
        width: 320px;
        display: none;
        overflow: hidden;
        z-index: 2000;
    }

    .userbox-list {
        list-style: none;
        margin: 0;
        padding: 0;
        border: 1px solid var(--theme-on-gray-200);
        border-radius: 5px;
    }

    .userbox-item {
        border-bottom: 1px solid rgb(223, 227, 235);
        padding: 10px 20px;
    }

    .userbox-profile {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .userbox-avatar {
        width: 2rem;
        height: 2rem;
        color: var(--nf-mainnav-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 14px;

        background-color: rgb(229, 245, 248);
    }

    .userbox-name {
        font-weight: 600;
        color: var(--theme-on-text-dark);
        font-size: var(--font-size-sm);
    }

    .userbox-title {
        margin: 0 0 9px;

        font-weight: 600;
        color: var(--theme-on-text-dark);
        font-size: 0.9rem;
        font-family: var(--font-family-base);
    }

    .userbox-link {
        color: var(--theme-on-text-dark);
        text-decoration: none;
        font-size: 14px;
        display: inline-block;
        font-family: var(--font-family-base);
        padding: 10px 0px;
    }
    .userbox-link:hover {
        background-color: #2d3e50;
    }

    .userbox-link i {
        margin-right: 6px;
    }

    .userbox-status-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: 0.2s ease;
        font-size: 14px;
        font-size: var(--font-family-base);
        padding: 0px 0px;
        margin: 0px 0px;
    }

    .userbox-status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }

    .online {
        background: rgb(0, 189, 165);
    }

    /* /////////////////////////
    for email list popup icon click  */
    .emailbox-trigger {
        /* font-weight: 600; */
        /*font-size: 0.8rem;*/
        color: var(--theme-on-text-light);
        font-family: var(--font-family-base);
        cursor: pointer;
    }

    .emailbox-container {
        position: absolute;
        top: 8.75rem;
        right: 0;
        width: 100%;
        background: #fff;
        border-radius: 8px;
        border: 1px solid #dce0e5;
        display: none;

        padding: 10px 0 5px;
        font-size: var(--font-family-base);
        z-index: 12;
    }

    .emailbox-arrow {
        position: absolute;
        top: -8px;
        right: 6.444125rem;
        width: 16px;
        height: 16px;
        background: #fff;
        border-left: 1px solid #dce0e5;
        border-top: 1px solid #dce0e5;
        transform: rotate(45deg);
        font-size: var(--font-family-base);
    }

    .emailbox-content {
        padding: 8px 20px 10px;
    }

    .emailbox-row {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-bottom: 8px;
        gap: 6px;
    }

    .emailbox-label {
        width: 70px;
        color: #5f6b7a;
        font-weight: 600;
        font-size: 14px;
        font-size: var(--font-family-base);
    }

    .emailbox-value {
        flex: 1;
        color: #555;
        font-size: 14px;
        word-break: break-word;
        font-size: var(--font-family-base);
    }

    .emailbox-copy {
        color: var(--bs-brand-custom);
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .custom-blue-tooltip .tooltip-inner {
        background-color: var(--nf-mainnav-bg) !important;
        color: #ffffff !important;
        font-weight: 600;
    }

    .custom-blue-tooltip .tooltip-arrow::before {
        border-top-color: var(--nf-mainnav-bg) !important;
    }

    .tooltip.bs-tooltip-top .custom-blue-tooltip .tooltip-arrow::before {
        border-top-color: var(--nf-mainnav-bg) !important;
    }

    /* for icons in list email  */
    .icon-wrapper-two i {
        font-size: 0.7rem;
        color: var(--bs-brand-custom);
    }

    /* to hide/show  the icons on hover  */
    .email-reply-block .icon-actions {
        opacity: 0;
        transition: opacity 0.1s ease-in-out;
        cursor: pointer;
    }

    .email-reply-block:hover .icon-actions {
        opacity: 1;
    }

    .date-separator-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        margin: 10px 0;
    }

    .date-line-segment {
        flex-grow: 1;
        height: 1px;
        background-color: rgb(223, 227, 235);

        margin: 0;
        padding: 0;
    }

    .date-label-badge {
        padding: 4px 12px;

        background-color: #ffffff;
        border: 1px solid rgb(223, 227, 235);
        border-radius: 20px;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    .date-label-text {
        font-size: 12px;
        font-weight: 600;
        color: rgb(51, 71, 91);
        margin: 0;
        line-height: 1;
    }

    /* /////////////// */

    #main-checkbox {
        width: 225px;
        height: 215px;
    }

    /* ////////////// */

    .my-custom-check-box {
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        user-select: none;
        font-family: "Inter", sans-serif;
        font-size: 14px;
        color: #33475b;
    }

    .my-custom-check-box input {
        display: none; /* Hide default checkbox */
    }

    /* Checkbox visual box */
    .my-custom-check-box .checkmark {
        position: relative;
        width: 18px;
        height: 18px;
        border: 2px solid #cbd6e2;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        transition: all 0.25s ease;
        margin-right: 33px;
    }

    /* SVG styling (HubSpot-style bar/check look) */
    .my-custom-check-box .checkmark svg {
        width: 12px;
        height: 12px;
        fill: transparent;
        stroke: #fff;
        stroke-width: 2;
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.25s ease;
    }

    /* Hover effect */
    .my-custom-check-box:hover .checkmark {
        border-color: #425b76;
    }

    /* Checked state */
    .my-custom-check-box input:checked + .checkmark {
        background-color: #425b76; /* HubSpot dark blue */
        border-color: #425b76;
    }

    /* Show SVG on check */
    .my-custom-check-box input:checked + .checkmark svg {
        opacity: 1;
        fill: #fff;
        transform: scale(1);
    }

    /* Label text spacing */
    .my-custom-check-box .checkbox-label {
        margin-left: 4px;
    }

    .rep_btn_sec {
        display: flex;
        justify-content: space-between;
    }

    /* /////////////// */

    /* today  */

    /* When screen size is exactly 1440x900 */
    @media screen and (width: 1440px) and (height: 900px) {
        .custom-tab-pane {
            max-height: clamp(57rem, 52.25vh, 52.25rem);
            overflow-y: auto;
            padding-right: clamp(0.2rem, 0.3125vw, 0.3125rem);
        }
    }


    /* When screen size is exactly 1366x768 */
    @media screen and (width: 1366px) and (height: 768px) {
        .custom-tab-pane {
            max-height: clamp(50rem, 52.25vh, 52.25rem);
            overflow-y: auto;
            padding-right: clamp(0.2rem, 0.3125vw, 0.3125rem);
        }
    }

</style>
