<!-- Toastr CSS -->
<link rel="stylesheet" href="{{asset('build/toaster/css/toastr.min.css')}}">

<!-- Date Range Picker CSS -->
<link rel="stylesheet" href="{{asset('assets/css/daterangepicker/daterangepicker.css')}}">
<link id="_dm-cssOverlayScrollbars" rel="stylesheet"
      href="{{asset('assets/themes/nifty/assets/vendors/overlayscrollbars/overlayscrollbars.min.css')}}">
<!-- Fonts [ OPTIONAL ] -->
<!-- Font Awesome Icons -->
<script src="{{asset('assets/fonts/fontawsome.js')}}"></script>
<style type="text/css">
    @font-face {
        font-family: Poppins;
        font-style: normal;
        font-weight: 300;
        src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/latin/300/normal.woff2);
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        font-display: swap;
    }

    @font-face {
        font-family: Poppins;
        font-style: normal;
        font-weight: 300;
        src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/devanagari/300/normal.woff2);
        unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;
        font-display: swap;
    }

    @font-face {
        font-family: Poppins;
        font-style: normal;
        font-weight: 300;
        src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/latin-ext/300/normal.woff2);
        unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        font-display: swap;
    }

    @font-face {
        font-family: Poppins;
        font-style: normal;
        font-weight: 400;
        src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/devanagari/400/normal.woff2);
        unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;
        font-display: swap;
    }

    @font-face {
        font-family: Poppins;
        font-style: normal;
        font-weight: 400;
        src: url('{{asset('assets/themes/nifty/assets/fonts/poppins/400-normal.woff2')}}');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        font-display: swap;
    }

    @font-face {
        font-family: Poppins;
        font-style: normal;
        font-weight: 400;
        src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/latin-ext/400/normal.woff2);
        unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        font-display: swap;
    }

    @font-face {
        font-family: Poppins;
        font-style: normal;
        font-weight: 500;
        src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/devanagari/500/normal.woff2);
        unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;
        font-display: swap;
    }

    @font-face {
        font-family: Poppins;
        font-style: normal;
        font-weight: 500;
        src: url({{asset('assets/themes/nifty/assets/fonts/poppins/latin-500-normal.woff2')}});
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        font-display: swap;
    }

    @font-face {
        font-family: Poppins;
        font-style: normal;
        font-weight: 500;
        src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/latin-ext/500/normal.woff2);
        unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        font-display: swap;
    }

    @font-face {
        font-family: Poppins;
        font-style: normal;
        font-weight: 700;
        src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/devanagari/700/normal.woff2);
        unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;
        font-display: swap;
    }

    @font-face {
        font-family: Poppins;
        font-style: normal;
        font-weight: 700;
        src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/latin-ext/700/normal.woff2);
        unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        font-display: swap;
    }

    @font-face {
        font-family: Poppins;
        font-style: normal;
        font-weight: 700;
        src: url({{asset('assets/themes/nifty/assets/fonts/poppins/700-normal.woff2')}});
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 400;
        src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/cyrillic-ext/400/normal.woff2);
        unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 400;
        src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/greek-ext/400/normal.woff2);
        unicode-range: U+1F00-1FFF;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 400;
        src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/cyrillic/400/normal.woff2);
        unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 400;
        src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/latin-ext/400/normal.woff2);
        unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 400;
        src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/greek/400/normal.woff2);
        unicode-range: U+0370-03FF;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 400;
        src: url({{asset('assets/themes/nifty/assets/fonts/ubuntu/400-normal.woff2')}});
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 500;
        src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/greek-ext/500/normal.woff2);
        unicode-range: U+1F00-1FFF;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 500;
        src: url({{asset('assets/themes/nifty/assets/fonts/ubuntu/500-normal.woff2')}});
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 500;
        src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/greek/500/normal.woff2);
        unicode-range: U+0370-03FF;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 500;
        src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/latin-ext/500/normal.woff2);
        unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 500;
        src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/cyrillic/500/normal.woff2);
        unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 500;
        src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/cyrillic-ext/500/normal.woff2);
        unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 700;
        src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/cyrillic/700/normal.woff2);
        unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 700;
        src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/latin-ext/700/normal.woff2);
        unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 700;
        src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/cyrillic-ext/700/normal.woff2);
        unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 700;
        src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/greek-ext/700/normal.woff2);
        unicode-range: U+1F00-1FFF;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 700;
        src: url({{asset('assets/themes/nifty/assets/fonts/ubuntu/700-normal.woff2')}});
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        font-display: swap;
    }

    @font-face {
        font-family: Ubuntu;
        font-style: normal;
        font-weight: 700;
        src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/greek/700/normal.woff2);
        unicode-range: U+0370-03FF;
        font-display: swap;
    }</style>

<!-- Bootstrap CSS [ REQUIRED ] -->
<link rel="stylesheet"
      href="{{asset('assets/themes/nifty/assets/css/bootstrap.min.66c59451bbe016158b4aec61e40cb76ecbf0a3d3ff23ba206bdbffb9a89b97f5.css')}}">

<!-- CSS [ REQUIRED ] -->
<link rel="stylesheet"
      href="{{asset('assets/themes/nifty/assets/css/nifty.min.ef4dee33cb03225ab91107ec2905fe15f71a06ba22edcf1e480874b0fb882a31.css')}}">

<!-- Favicons [ OPTIONAL ] -->
<link rel="manifest" href="{{asset('assets/themes/nifty/site.webmanifest')}}">
<link rel="manifest" href="{{asset('assets/themes/nifty/site.webmanifest')}}">
<!-- Spinkit [ OPTIONAL ] -->
<link rel="stylesheet" href="{{asset('assets/themes/nifty/assets/pages/spinkit.css')}}">

{{--Jquery UI--}}
<link rel="stylesheet" href="{{asset ('assets/themes/nifty/assets/css/jquery-ui.css')}}">
<style>

    /* Full-screen loader styles */

    .loader-light {
        background-color: rgba(255, 255, 255, 0.2) !important;
    }


    #loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgb(255 255 255); /* Semi-transparent background */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999999;
        visibility: visible;
        opacity: 1;
        transition: opacity 0.3s ease, visibility 0s ease 0.3s;
    }

    /* Hidden loader after the time interval */
    #loader.hidden {
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.3s ease, visibility 0s ease 0s;
    }

    .load-spinner {
        display: none;
    }

</style>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

[ REQUIRED ]
You must include this category in your project.


[ OPTIONAL ]
This is an optional plugin. You may choose to include it in your project.


[ DEMO ]
Used for demonstration purposes only. This category should NOT be included in your project.


[ SAMPLE ]
Here's a sample script that explains how to initialize plugins and/or components: This category should NOT be included in your project.


Detailed information and more samples can be found in the documentation.

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

<!-- Toastr CSS -->
<link rel="stylesheet" href="{{asset('build/toaster/css/toastr.min.css')}}">

<style>

    .mainnav__top-content::-webkit-scrollbar {
        display: none;
    }

    .root .mainnav__inner li.nav-item {
        margin-top: 1px;
    }

    .is-invalid {
        background-color: #f8d7da85;
    }

    .is-invalid + .text-danger {
        color: red;
    }

    .modal span.text-danger {
        font-size: 12px;
    }

    /** Datatable */

    div.dt-container div.dt-length select {
        min-width: 60px;
    }

    .dt-buttons button.btn.btn-secondary {
        margin: 0px;
    }

    /* Style the length dropdown container */
    div.dt-container div.dt-length {
        margin-top: 0px; /* Adjust spacing between buttons and dropdown */
        font-size: 14px; /* Adjust font size */
        display: flex;
        align-items: center;
    }


    /* Style the select dropdown */
    div.dt-container div.dt-length select {
        width: 80px; /* Set the width */
        padding: 5px; /* Add padding */
        font-size: 14px; /* Adjust font size */
        border: 1px solid #ccc; /* Border color */
        border-radius: 4px; /* Round corners */
        background-color: #f8f9fa; /* Background color */
        color: #333; /* Font color */
        margin-right: 8px; /* Add space between select and "entries per page" text */
    }

    /* Style the "entries per page" label */
    div.dt-container div.dt-length label {
        font-size: 14px;
        color: #333; /* Font color */
    }

    /* Hover and focus state for dropdown */
    div.dt-container div.dt-length select:hover, div.dt-container div.dt-length select:focus {
        border-color: #828283;
        box-shadow: 0px 0px 5px #9399a3;
    }

    /* Style the dropdown options */
    div.dt-container div.dt-length select option {
        background-color: #f8f9fa; /* Option background */
        color: #333; /* Text color */
        font-size: 14px; /* Font size for options */
    }

    /* Selected option styling (applied in some browsers) */
    div.dt-container div.dt-length select option:checked {
        background-color: #e0e0e0; /* Background color for selected option */
        color: #333; /* Selected text color */
    }

    .dt-buttons .btn.btn-secondary {
        /*padding: 6px 9px;*/
        background-color: #fff;
    }

    .dt-buttons .btn.btn-secondary span {
        color: #8392ab;
    }

    .dt-buttons .btn.btn-secondary:hover {
        background-color: transparent;
        /*background-color: #8392ab;*/
    }

    .dt-buttons .btn.btn-secondary span:hover {
        color: #fff;
    }

    span.dt-column-title {
        color: var(--bs-primary);
    }

    .custm-filtr {
        padding: 0;
    }

    ul.custm-filtr li {
        color: var(--bs-primary);
        margin-right: 20px;
        display: inline-block;
    }

    .table.dataTable.table.table-striped > tbody > tr:nth-of-type(2n+1).selected > *,
    .table.dataTable.table > tbody > tr.selected > * {
        box-shadow: inset 0 0 0 9999px var(--bs-primary);
        color: var(--bs-primary-color);
    }
    .table.dataTable.table-striped > tbody > tr > td *:not(button):not(button *):not(.badge.bg-success) {
        color: var(--bs-primary);
    }

    .table.dataTable.table-striped > tbody > tr.selected > td *:not(button):not(button *):not(.badge.bg-success) {
        color: var(--bs-primary-color);
    }

    .table.dataTable.table-striped > tbody > tr.selected > td > button.btn-primary {
        color: var(--bs-primary);
        background-color: var(--bs-primary-color);
        box-shadow: 0 .1rem .5rem rgba(var(--bs-primary-color-rgb), .5),
    }

    .table.dataTable.table-striped > tbody > tr.selected > td > button * {
        color: inherit;
    }


    .right-icon {
        display: flex;
        justify-content: end;
    }

    .dt-search {
        float: right;
    }

    .dt-paging ul.pagination {
        float: right;
    }

    .dt-buttons button {
        border: none;
        padding: 0;
        /*left: 150px;*/
    }

    .card-header:has(.fltr-sec) {
        border-bottom: none;
    }

    /** Status */
    .status-toggle {
        width: 35px;
        height: 15px;
        appearance: none;
        -webkit-appearance: none;
        background-color: #ccc;
        position: relative;
        outline: none;
        border-radius: 15px;
        cursor: pointer;
        transition: background-color 0.2s;
        border: #8392ab;
    }

    .status-toggle:checked {
        background-color: #8392ab;
    }

    .status-toggle::before {
        content: '';
        width: 14px;
        height: 14px;
        background-color: white;
        border-radius: 50%;
        position: absolute;
        top: 1px;
        left: 1px;
        transition: left 0.2s;
    }

    .status-toggle:checked::before {
        left: 20px;
    }

    .table a {
        /*text-decoration: underline;*/
        text-decoration: none;
        color: var(--bs-primary);
        font-weight: 600;
    }

    .table a:hover {
        text-decoration: underline;
    }

    table object.avatar.avatar-sm.me-3 {
        max-width: 50px;
        max-height: 50px;
    }

    .root .mainnav__inner .nav-link.active ~ .nav .active, .root .mainnav__inner .nav-link.active ~ .nav .active:hover {
        color: var(--nf-mainnav-submenu-active-color);
    }

    .mn--min .mininav-content h3 {
        color: var(--nf-mainnav-link-color);
        font-size: var(--nf-brand-size);
        font-weight: 600;
        font-family: var(--bs-body-font-family);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        padding: var(--nf-mainnav-min-submenu-link-padding-y) var(--nf-mainnav-min-submenu-link-padding-x) 0;
    }

    .navigate-heading {
        display: none;
    }

    .mn--min .navigate-heading {
        margin-left: 5px;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-items: center;
    }


    .table > :not(caption) > * > * {
        /*padding: .5rem .5rem;*/
    }

    button.btn.btn-sm {
        /*padding: 0px;*/
    }

    .profile-image {
        object-fit: contain;
    }

    select#brands {
        height: 250px;
    }
</style>
