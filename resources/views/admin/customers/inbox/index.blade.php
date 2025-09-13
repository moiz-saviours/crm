<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-scheme="navy">
<head>
    <meta name="csrf-token"
          content="1vH94yB4UUsVONeEfOu7yS9Qri6WB7zUEuEiuscX"
    />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta
        name="viewport"
        content="width=device-width, height=device-height, initial-scale=1"
    />
    <link
        rel="icon"
        type="image/png"
        href="https://payusinginvoice.com/crm-development/assets/img/favicon.png"
    />
    <meta name="description" content="Crm Management System" />
    <title>Customer CustomerContact / Edit</title>

    <link
        rel="preload"
        as="style"
        href="https://payusinginvoice.com/crm-development/build/assets/app-V36qSI5w.css"
    />
    <link
        rel="modulepreload"
        href="https://payusinginvoice.com/crm-development/build/assets/app-BvCIJes9.js"
    />
    <link
        rel="modulepreload"
        href="https://payusinginvoice.com/crm-development/build/assets/bootstrap-BA2Cz7cT.js"
    />
    <link
        rel="stylesheet"
        href="https://payusinginvoice.com/crm-development/build/assets/app-V36qSI5w.css"
    />
    <script
        type="module"
        src="https://payusinginvoice.com/crm-development/build/assets/app-BvCIJes9.js"
    ></script>
    <!-- STYLESHEETS -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- Toastr CSS -->
    <link
        rel="stylesheet"
        href="https://payusinginvoice.com/crm-development/assets/toaster/css/toastr.min.css"
    />

    <!-- Date Range Picker CSS -->
    <link
        rel="stylesheet"
        href="https://payusinginvoice.com/crm-development/assets/css/daterangepicker/daterangepicker.css"
    />
    <link
        id="_dm-cssOverlayScrollbars"
        rel="stylesheet"
        href="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/vendors/overlayscrollbars/overlayscrollbars.min.css"
    />
    <!-- Fonts [ OPTIONAL ] -->

    <link
        rel="stylesheet"
        href="https://payusinginvoice.com/crm-development/assets/css/tour.css"
    />

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/shepherd.js/dist/css/shepherd.css"
    />

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        rel="stylesheet"
    />
    <!-- Font Awesome CDN -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        rel="stylesheet"
    />

    <!-- Font Awesome Icons -->
    <script src="https://payusinginvoice.com/crm-development/assets/fonts/fontawsome.js"></script>

    <style type="text/css">
        @font-face {
            font-family: Poppins;
            font-style: normal;
            font-weight: 300;
            src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/latin/300/normal.woff2);
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6,
            U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC,
            U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            font-display: swap;
        }

        @font-face {
            font-family: Poppins;
            font-style: normal;
            font-weight: 300;
            src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/devanagari/300/normal.woff2);
            unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9,
            U+25CC, U+A830-A839, U+A8E0-A8FF;
            font-display: swap;
        }

        @font-face {
            font-family: Poppins;
            font-style: normal;
            font-weight: 300;
            src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/latin-ext/300/normal.woff2);
            unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F,
            U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F,
            U+A720-A7FF;
            font-display: swap;
        }

        /*@font-face {*/
        /*    font-family: Poppins;*/
        /*    font-style: normal;*/
        /*    font-weight: 400;*/
        /*    src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/devanagari/400/normal.woff2);*/
        /*    unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;*/
        /*    font-display: swap;*/
        /*}*/

        @font-face {
            font-family: Poppins;
            font-style: normal;
            font-weight: 400;
            src: url("https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/fonts/poppins/400-normal.woff2");
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6,
            U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC,
            U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            font-display: swap;
        }

        /*@font-face {*/
        /*    font-family: Poppins;*/
        /*    font-style: normal;*/
        /*    font-weight: 400;*/
        /*    src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/latin-ext/400/normal.woff2);*/
        /*    unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;*/
        /*    font-display: swap;*/
        /*}*/

        @font-face {
            font-family: Poppins;
            font-style: normal;
            font-weight: 500;
            src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/devanagari/500/normal.woff2);
            unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9,
            U+25CC, U+A830-A839, U+A8E0-A8FF;
            font-display: swap;
        }

        @font-face {
            font-family: Poppins;
            font-style: normal;
            font-weight: 500;
            src: url(https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/fonts/poppins/latin-500-normal.woff2);
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6,
            U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC,
            U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            font-display: swap;
        }

        @font-face {
            font-family: Poppins;
            font-style: normal;
            font-weight: 500;
            src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/latin-ext/500/normal.woff2);
            unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F,
            U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F,
            U+A720-A7FF;
            font-display: swap;
        }

        /*@font-face {*/
        /*    font-family: Poppins;*/
        /*    font-style: normal;*/
        /*    font-weight: 700;*/
        /*    src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/devanagari/700/normal.woff2);*/
        /*    unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;*/
        /*    font-display: swap;*/
        /*}*/

        /*@font-face {*/
        /*    font-family: Poppins;*/
        /*    font-style: normal;*/
        /*    font-weight: 700;*/
        /*    src: url(https://preview.themeon.net/cf-fonts/s/poppins/5.0.11/latin-ext/700/normal.woff2);*/
        /*    unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;*/
        /*    font-display: swap;*/
        /*}*/

        @font-face {
            font-family: Poppins;
            font-style: normal;
            font-weight: 700;
            src: url(https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/fonts/poppins/700-normal.woff2);
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6,
            U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC,
            U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            font-display: swap;
        }

        @font-face {
            font-family: Ubuntu;
            font-style: normal;
            font-weight: 400;
            src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/cyrillic-ext/400/normal.woff2);
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF,
            U+A640-A69F, U+FE2E-FE2F;
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
            unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F,
            U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F,
            U+A720-A7FF;
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
            src: url(https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/fonts/ubuntu/400-normal.woff2);
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6,
            U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC,
            U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
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
            src: url(https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/fonts/ubuntu/500-normal.woff2);
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6,
            U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC,
            U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
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
            unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F,
            U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F,
            U+A720-A7FF;
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
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF,
            U+A640-A69F, U+FE2E-FE2F;
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
            unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F,
            U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F,
            U+A720-A7FF;
            font-display: swap;
        }

        @font-face {
            font-family: Ubuntu;
            font-style: normal;
            font-weight: 700;
            src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/cyrillic-ext/700/normal.woff2);
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF,
            U+A640-A69F, U+FE2E-FE2F;
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
            src: url(https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/fonts/ubuntu/700-normal.woff2);
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6,
            U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC,
            U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            font-display: swap;
        }

        @font-face {
            font-family: Ubuntu;
            font-style: normal;
            font-weight: 700;
            src: url(https://preview.themeon.net/cf-fonts/s/ubuntu/5.0.11/greek/700/normal.woff2);
            unicode-range: U+0370-03FF;
            font-display: swap;
        }
    </style>

    <!-- Bootstrap CSS [ REQUIRED ] -->
    <link
        rel="stylesheet"
        href="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/css/bootstrap.min.66c59451bbe016158b4aec61e40cb76ecbf0a3d3ff23ba206bdbffb9a89b97f5.css"
    />

    <!-- CSS [ REQUIRED ] -->
    <link
        rel="stylesheet"
        href="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/css/nifty.min.ef4dee33cb03225ab91107ec2905fe15f71a06ba22edcf1e480874b0fb882a31.css"
    />

    <!-- Favicons [ OPTIONAL ] -->
    <link
        rel="manifest"
        href="https://payusinginvoice.com/crm-development/assets/themes/nifty/site.webmanifest"
    />
    <link
        rel="manifest"
        href="https://payusinginvoice.com/crm-development/assets/themes/nifty/site.webmanifest"
    />
    <!-- Spinkit [ OPTIONAL ] -->
    <link
        rel="stylesheet"
        href="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/pages/spinkit.css"
    />

    <link
        rel="stylesheet"
        href="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/css/jquery-ui.css"
    />
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
            background-color: rgb(255 255 255);
            /* Semi-transparent background */
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
    <link
        rel="stylesheet"
        href="https://payusinginvoice.com/crm-development/assets/toaster/css/toastr.min.css"
    />

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

        .is-invalid+.text-danger {
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
            margin-top: 0px;
            /* Adjust spacing between buttons and dropdown */
            font-size: 14px;
            /* Adjust font size */
            display: flex;
            align-items: center;
        }


        /* Style the select dropdown */
        div.dt-container div.dt-length select {
            width: 80px;
            /* Set the width */
            padding: 5px;
            /* Add padding */
            font-size: 14px;
            /* Adjust font size */
            border: 1px solid #ccc;
            /* Border color */
            border-radius: 4px;
            /* Round corners */
            background-color: #f8f9fa;
            /* Background color */
            color: #333;
            /* Font color */
            margin-right: 8px;
            /* Add space between select and "entries per page" text */
        }

        /* Style the "entries per page" label */
        div.dt-container div.dt-length label {
            font-size: 14px;
            color: #333;
            /* Font color */
        }

        /* Hover and focus state for dropdown */
        div.dt-container div.dt-length select:hover,
        div.dt-container div.dt-length select:focus {
            border-color: #828283;
            box-shadow: 0px 0px 5px #9399a3;
        }

        /* Style the dropdown options */
        div.dt-container div.dt-length select option {
            background-color: #f8f9fa;
            /* Option background */
            color: #333;
            /* Text color */
            font-size: 14px;
            /* Font size for options */
        }

        /* Selected option styling (applied in some browsers) */
        div.dt-container div.dt-length select option:checked {
            background-color: #e0e0e0;
            /* Background color for selected option */
            color: #333;
            /* Selected text color */
        }

        .dt-buttons .btn.btn-secondary {
            padding: 6px 9px;
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
            color: var(--bs-primary);
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

        .table.dataTable.table.table-striped>tbody>tr:nth-of-type(2n+1).selected>*,
        .table.dataTable.table>tbody>tr.selected>* {
            box-shadow: inset 0 0 0 9999px var(--bs-primary);
            color: var(--bs-primary-color);
        }

        .table.dataTable.table-striped>tbody>tr>td *:not(button):not(button *):not(.badge.bg-success) {
            color: var(--bs-primary);
        }

        .table.dataTable.table-striped>tbody>tr.selected>td *:not(button):not(button *):not(.badge.bg-success) {
            color: var(--bs-primary-color);
        }

        .table.dataTable.table-striped>tbody>tr.selected>td>button.btn-primary {
            color: var(--bs-primary);
            background-color: var(--bs-primary-color);
            box-shadow: 0 .1rem .5rem rgba(var(--bs-primary-color-rgb), .5),
        }

        .table.dataTable.table-striped>tbody>tr.selected>td>button * {
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
            background-color: var(--bs-primary);
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

        .table th.move-col {
            position: relative;
            padding-left: 5px !important;
            transition: background-color 0.2s ease;
        }

        .table th.move-col::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            background-image: url('https://payusinginvoice.com/crm-development/assets/images/dott-to-move-col.png');
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0;
            transition: all 0.2s ease;
        }

        .table th.move-col:hover::before {
            opacity: 0.7;
            left: 3px;
        }

        .table th.move-col:active::before {
            opacity: 1;
            transform: translateY(-50%) scale(1.1);
        }

        table object.avatar.avatar-sm.me-3 {
            max-width: 50px;
            max-height: 50px;
        }

        .root .mainnav__inner .nav-link.active~.nav .active,
        .root .mainnav__inner .nav-link.active~.nav .active:hover {
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


        .table> :not(caption)>*>* {
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

        .dropdown-menu.dt-button-collection {
            display: block !important;
            opacity: 1 !important;
            pointer-events: auto !important;
            transform: none !important;
            visibility: visible !important;
            position: absolute !important;
            animation: none !important;
            transition: none !important;
            border: none;
            z-index: 12;
        }

        .mainnav .dropdown-menu:not(.dt-button-collection) {
            opacity: 0;
            pointer-events: none;
            visibility: hidden;
            transform: scale(0);
        }

        .dropdown-item:focus,
        .dropdown-item:hover {
            color: var(--bs-primary-color);
            background-color: var(--bs-primary);
        }

        div.dt-button-background {
            position: absolute !important;
            z-index: 11 !important;
        ;
        }

        div.dt-button-background {
            background: radial-gradient(ellipse farthest-corner at center, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.15) 100%) !important;
            border-radius: inherit;
        }

        table.dataTable input.dt-select-checkbox {
            border: none !important;
        }

        th.select-checkbox.dt-select.dt-orderable-none .dt-select-checkbox {
            border: 1px solid !important;
        }

        table.dataTable>tbody>tr.selected>td.select-checkbox:before,
        table.dataTable>tbody>tr.selected>th.select-checkbox:before {
            content: "" !important;
        }

        .dt-scroll-head table.dataTable.table-bordered th {
            border-top-width: 1px;
            border-top-color: var(--bs-secondary);
            border-bottom-width: 1px !important;
            border-bottom-color: var(--bs-secondary);
        }

        .dt-scroll-head table.dataTable.table-bordered tr:not(:first-child) th {
            border-top-width: 0 !important;
        }

        .dt-scroll-body table.dataTable.table-bordered td {
            border-top-width: 1px !important;
            border-top-color: var(--bs-secondary);
        }

        .mn--min .header__brand .brand-img img.logo {
            max-width: 70px;
            margin-left: 20px;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            color: var(--nf-sidebar-color) !important;

        }

        .select2-container--default .select2-search--dropdown .select2-search__field:focus-visible {
            color: var(--nf-sidebar-color) !important;
            border: none !important;

        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: var(--bs-primary);
        !important;
        }
    </style>
    <style>
        .custom-form .fh-1 {
            background: var(--nf-header-bg);
        }

        td.align-middle.text-center.text-nowrap.editable:hover select {
            border: 1px solid #000;
            border-radius: 5px;
        }

        td.align-middle.text-center.text-nowrap.editable[data],
        td.align-middle.text-center.text-nowrap.editable {
            cursor: pointer;
        }

        .void {
            cursor: not-allowed;
        }

        .custm_header {
            padding: 2px 20px 2px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .actions {
            display: flex;
        }

        .actions h1 {
            margin: auto;
            color: #52a0bf;
            font-size: 15px;
        }

        .filters,
        .table-controls {
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
            /*border-bottom: 1px solid #ddd;*/
        }

        .filters .filter-tabs button,
        .actions button {
            padding: 5px 12px;
            border: 1px solid #ff5722;
            border-radius: 4px;
            background-color: #fff;
            cursor: pointer;
        }

        .filters .actions .create-contact {
            background-color: #ff5722;
            color: #fff;
            border: none;
        }

        .your-create-contact {
            background-color: #ff5722;
            color: #fff;
            border: none;
            padding: 5px 10px;
            text-transform: capitalize;
        }

        .your-comment-cancel {
            background-color: #fff;
            color: #ff5722;
            border: 1px solid #ff5722;
            padding: 5px 10px;
            text-transform: capitalize;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        .dropdown-content-wraper {
            display: flex;
            justify-content: space-between;
            min-width: 374px;
            width: 100%;
        }

        .select-contact-box-space {
            padding: 8px;
        }

        .association-activities-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-box-select {
            /* padding: 8px; */
            padding: 7px 7px;
            /* border-bottom: 1px solid #ccc; */
        }

        .search-box-select input {
            width: 100%;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            min-width: 230px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 3px;
            font-size: 12px;
            color: gray;
        }

        .nested-select-list {
            margin: 0;
            padding: 1px 11px;
            height: 129px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .select-contact {
            margin-bottom: 10px;
            font-size: 12px;
            font-weight: 700;
            /* margin-top: 4px; */
            /* padding-left: 8px; */
        }

        .selectionBox option {
            width: 120px !important;
        }

        .search-bar input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 250px;
        }

        .contacts-table {
            width: 100%;
            border-collapse: collapse;
        }

        .contacts-table th,
        .contacts-table td {
            padding: 10px;
            text-align: left;
            /*border: 1px solid #ddd;*/
        }

        .contacts-table th {
            /*background-color: #f1f5f9;*/
            font-weight: bold;
        }

        .contacts-table tbody tr:hover {
            background-color: #f9f9f9;
        }

        .header .new_head h1 {
            font-size: 20px;
            color: #52a0bf;
            font-weight: 700;
        }

        .header_btn {
            padding: 0px 30px;
            color: #ff5722;
            margin: 0px 10px;
        }

        .custom-tabs {
            margin: 0px 0px 4px 0px;
            display: flex;
        }

        .tab-nav {
            display: flex;
            justify-content: space-around;
            list-style: none;
            padding: 0;
            margin: 0;
            width: 70%;
        }

        .tab-buttons {
            margin-left: 100px;
        }

        .tab-item {
            padding: 10px 20px;
            cursor: pointer;
            border: 1px solid #cbd6e2;
            background: #f9f9f9;
            width: 100%;
            transition: background 0.3s ease;
        }

        .tab-item.active {
            background: #fff;
            border-bottom: none;
        }

        .tab-item.active i {
            float: right;
            font-size: 14px;
            margin: auto;
        }

        .tab-content {
            /*padding: 10px;*/
            /*margin-top: 10px;*/
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }

        .fltr-sec {
            padding-top: 20px;
        }

        .table-li {
            display: flex;
        }

        .table-li .page-title {
            font-size: 14px;
            padding: 0px 30px 0px 0px;
            font-weight: 700;
        }

        .right-icon i {
            float: right;
            margin: 0px 4px;
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 5px;
            font-size: 12px;
        }

        .custom-form .form-container {
            position: fixed;
            top: 0;
            right: -100%;
            width: 500px;
            height: 100%;
            background: #ffffff;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
            transition: right 0.5s ease;
            box-sizing: border-box;
            z-index: 1001;
        }

        .custom-form .form-container.open {
            right: 0;
        }

        .custom-form .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            /*background: #52a0bf;*/
            color: white;
            font-size: 18px;
            font-weight: bold;
        }

        .custom-form .form-header .close-btn {
            font-size: 20px;
            font-weight: bold;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
        }

        .custom-form .form-body {
            padding: 20px;
            height: 79.5%;
            overflow-y: scroll;
        }

        .custom-form .form-body label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--bs-heading-color);
        }

        .custom-form .form-body input:not(.is-invalid) {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .custom-form .form-body select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            /*color: #757575;*/
            color: var(--nf-sidebar-color);
        }

        .custom-form .form-body button {
            width: 100%;
            padding: 10px;
            /*background: #ff5722;*/
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background: var(--bs-primary);
        }

        .close-icon {
            display: none;
        }

        .tab-item.active .close-icon {
            display: inline;
        }

        .fh-check,
        .fh-radio {
            height: 140px;
            overflow-y: scroll;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .fh-checkbox,
        .fh-radiobox {
            display: flex;
            width: 100%;
        }

        .fh-checkbox label,
        .fh-radiobox label {
            width: 100%;
        }

        .custom-form .form-body input:not(.is-invalid)[type="checkbox"] {
            width: 2%;
            margin-right: 10px;
            appearance: none;
            cursor: pointer;
            position: relative;
        }

        .custom-form .form-body input:not(.is-invalid)[type="radio"] {
            margin-right: 10px;
            appearance: none;
            width: auto;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
        }

        .fh-checkbox input[type="checkbox"]:checked,
        .fh-radiobox input[type="radio"]:checked {
            background: var(--nf-header-bg);
            border-color: var(--nf-header-bg);
        }

        .fh-checkbox input[type="checkbox"]:checked::after {
            content: "\2713";
            color: #fff;
            font-size: 14px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
            z-index: 99;
        }

        .fh-radiobox input[type="radio"]:checked::after {
            content: "";
            width: 8px;
            height: 8px;
            background-color: #fff;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .form-button {
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: var(--bs-body-bg);
            padding: 10px;
            display: flex;
            justify-content: space-evenly;
        }

        .form-button .btn-primary {
            width: 30%;
            padding: 10px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background: var(--bs-primary);
            margin-right: 10px;
        }

        .form-button .btn-secondary {
            width: 30%;
            padding: 10px;
            color: var(--bs-primary);
            border: 1px solid var(--bs-primary);
            border-radius: 4px;
            cursor: pointer;
            background: transparent;
            margin-right: 10px;
        }

        .form-container img {
            max-width: 100px;
            max-height: 100px;
        }
    </style>

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
            padding-top: 10px;
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
            font-size: var(--nf-profile-para-size);
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
            color: #0091ae;
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
            background-color: #eaf0f6;
            border: 1px solid #cbd6e2;
            color: #506e91;
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
            background: #f2f5f8;
            /* padding-top: 10px; */
            max-height: 3rem;
            max-width: 3rem;
            /*height: 40px;*/
            /*width: 47px;*/
            padding: 9px 0px 0px;
        }

        .avatar-icon {
            border-radius: 50%;
            background: #f2f5f8;
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
            align-items: center;
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
            border-bottom: 1px solid #0091ae;
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
            color: #0091ae;
        }

        .dropdown-menu.custom-contact-detail-dropdown-show.show {
            /* box-shadow: none; */
            width: 100%;
        }

        .contact-card-subscription-para {
            font-size: var(--nf-profile-para-size);
            font-weight: 400;
            line-height: 24px;
            color: #33475b;
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
            background: #fff;
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
            background-color: #eaf0f6;
            border: 1px solid #cbd6e2;
            color: #506e91;
        }

        .custom-email-reply-collapse {
            box-shadow: none;
            padding: 12px 0px 0px;
        }

        .custom-email-reply-collapse-body {
            padding: 0px 12px;
            border-left: 1px solid #cbd6e2;
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
    </style>

    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
</head>
<style>
    .email-template {
        display: none;
    }

    .email-template.open {
        display: block;
        position: fixed;
        justify-content: end;
        /*position: absolute;*/
        bottom: 0;
        right: 50px;
        z-index: 10026;
        width: 47%;
        background-color: #fff;
    }

    .email-template input[type="text"]:focus,
    .email-child-wrapper tags.tagify:focus-within {
        outline-offset: calc(-2px);
        border-color: transparent !important;
        outline: rgb(0, 164, 189) solid 2px !important;
        box-shadow: rgb(255, 255, 255) 0px 0px 0px 2px inset !important;
        border-radius: 3px;
    }

    .email-template input[type="text"],
    .email-child-wrapper tags.tagify {
        padding: 0.3em 0.5em;
    }

    .email-header-main-wrapper {
        color: #fff;
        display: flex;
        justify-content: space-between;
        padding: 10px 30px;
        background-color: var(--bs-primary);
        cursor: move;
    }

    .email-child-wrapper-one {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .email-child-wrapper-one i {
        height: 20px;
        width: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .email-child-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        background-color: #fff;
    }

    .email-child-wrapper input,
    .email-child-wrapper tags.tagify {
        width: 500px;
        border: none;
    }

    .email-child-wrapper input:focus-visible,
    .email-child-wrapper tags.tagify:focus-within {
        outline: none;
    }

    .email-titles {
        font-weight: 500;
        margin: 0;
    }

    .email-titles-hide {
        color: #ccc;
        font-weight: 500;
        margin: 0;
    }

    .email-titles-show {
        color: var(--bs-primary);
        font-weight: 600;
        margin: 0px;
    }

    .icon-display-email-box {
        color: #ccc;
        font-size: 12px;
    }

    .email-divider {
        background-color: #ddd;
        height: 1px;
    }

    .email-sending-titles {
        font-weight: 700;
        margin: 0;
        color: var(--bs-primary);
        min-width: 6%;
    }

    .email-sender-box {
        padding: 12px 0px;
        margin: 0;
        background-color: #eaf0f6;
        border-color: #cbd6e2;
        /* color: #506e91; */
        font-size: 12px;
        font-weight: 400;
        padding: 4px 17px;
        border-radius: 3px;
        border-style: solid;
        border-width: 1px;
    }

    .email-sender-box-icon {
        color: gray;
        font-size: 10px;
        padding-left: 7px;
    }

    .email-sending-box {
        display: flex;
        justify-content: space-between;
        background-color: #fff;
        padding: 5px 20px;
        min-height: 40px;
    }

    .main-content-email-box {
        background-color: #fff;
        padding: 0px;
        text-align: center;
    }

    .main-content-email-box textarea {
        width: 100%;
        border: none;
        border-radius: 5px;
        margin: 0;
        resize: vertical;
        padding: 0 30px;
    }

    .main-content-email-box textarea:focus-visible {
        outline: none;
    }

    .main-content-email-text {
        color: #000;
        text-align: center;
        font-size: 15px;
    }

    .main-content-email-para {
        margin: 0;
        color: gray;
        padding: 20px 0px;
    }

    .connect-to-inbox-btn {
        background-color: var(--bs-primary);
        border: none;
        color: #fff;
        font-size: 13px;
        font-weight: 400;
        padding: 7px 16px;
        border-radius: 0px;
        font-weight: 600;
        border-radius: 4px;
    }

    .email-footer-div {
        background-color: #f8f9fa;
        border-top: 1px solid #ddd;
        padding: 10px 20px;
    }

    .email-footer-btn {
        background-color: #fff;
        border: 1px solid var(--bs-primary);
        color: var(--bs-primary);
        font-size: 12px;
        font-weight: 400;
        padding: 3px 17px;
        border-radius: 0px;
        border-radius: 4px;
    }

    .email-sender-name {
        margin: 0;
        color: #33475b;
    }

    .email-sender-emailid {
        color: var(--bs-primary);
        font-weight: 500;
    }

    .email-warning-icon {
        color: #f5c26b;
        padding-left: 9px;
        font-size: 12px;
    }

    .email-titles-dropdown {
        color: var(--bs-primary);
        font-weight: 600;
        margin: 0px;
        background-color: transparent;
        border: none;
        cursor: pointer;
    }

    .email-titles-dropdown:hover {
        text-decoration: underline;
    }

    .email-titles-dropdown-menu.show {
        width: 45%;
        width: 22%;
        /* transform: translate3d(240px, 100px, 0px); */
        transform: translate(210px, 100px) !important;
        padding: 21px 40px;
        border-radius: 0;
    }

    .dropdown-img {
        width: 238px;
    }

    .get-started-icon {
        padding-left: 8px;
    }

    .quotes-titles-dropdown-menu.show {
        width: 45%;
        width: 18%;
        /* transform: translate3d(240px, 100px, 0px); */
        transform: translate(316px, 100px) !important;
        padding: 0;
        border-radius: 0;
    }

    .quotes-header-box {
        padding: 21px 32px;
    }

    .quotes-content-para {
        color: #6c757da1;
    }

    .quotes-titles-link {
        color: var(--bs-primary);
        font-weight: 600;
        margin: 0px;
    }

    .quotes-titles-link:hover {
        color: var(--bs-primary);
    }

    tags.tagify.email-sender-name * {
        margin: 1px;
    }

    .tagify__tag {
        background-color: var(--tag-bg);
    }

    .tagify__tag:hover {
        background-color: var(--tag-hover);
    }

    tags.tagify.email-sender-name {
        max-height: 70px;
        overflow: auto;
    }

    .email-child-wrapper input {
        padding: 100px;
        transition: all 0.3s ease;
    }

    .email-child-wrapper input:focus {
        padding: 10px 15px;
        outline: none;
        border-color: #4a90e2;
    }

    .email-template-body {
        max-height: 543px;
        overflow: auto;
    }

    @charset "UTF-8";

    :root {
        --tagify-dd-color-primary: rgb(53, 149, 246);
        --tagify-dd-text-color: black;
        --tagify-dd-bg-color: white;
        --tagify-dd-item-pad: 0.3em 0.5em;
        --tagify-dd-max-height: 300px;
    }

    .tagify {
        --tags-disabled-bg: #f1f1f1;
        --tags-border-color: #ddd;
        --tags-hover-border-color: #ccc;
        --tags-focus-border-color: #3595f6;
        --tag-border-radius: 3px;
        --tag-bg: #e5e5e5;
        --tag-hover: #d3e2e2;
        --tag-text-color: black;
        --tag-text-color--edit: black;
        --tag-pad: 0.3em 0.5em;
        --tag-inset-shadow-size: 1.2em;
        --tag-invalid-color: #d39494;
        --tag-invalid-bg: rgba(211, 148, 148, 0.5);
        --tag--min-width: 1ch;
        --tag--max-width: 100%;
        --tag-hide-transition: 0.3s;
        --tag-remove-bg: rgba(211, 148, 148, 0.3);
        --tag-remove-btn-color: black;
        --tag-remove-btn-bg: none;
        --tag-remove-btn-bg--hover: #c77777;
        --input-color: inherit;
        --placeholder-color: rgba(0, 0, 0, 0.4);
        --placeholder-color-focus: rgba(0, 0, 0, 0.25);
        --loader-size: 0.8em;
        --readonly-striped: 1;
        display: inline-flex;
        align-items: flex-start;
        align-content: baseline;
        flex-wrap: wrap;
        border: 1px solid var(--tags-border-color);
        padding: 0;
        line-height: 0;
        outline: 0;
        position: relative;
        box-sizing: border-box;
        transition: 0.1s;
    }

    @keyframes tags--bump {
        30% {
            transform: scale(1.2);
        }
    }

    @keyframes rotateLoader {
        to {
            transform: rotate(1turn);
        }
    }

    .tagify:has([contenteditable="true"]) {
        cursor: text;
    }

    .tagify:hover:not(.tagify--focus):not(.tagify--invalid) {
        --tags-border-color: var(--tags-hover-border-color);
    }

    .tagify[disabled] {
        background: var(--tags-disabled-bg);
        filter: saturate(0);
        opacity: 0.5;
        pointer-events: none;
    }

    .tagify[disabled].tagify--empty > .tagify__input:before {
        position: relative;
    }

    .tagify[disabled].tagify--select,
    .tagify[readonly].tagify--select {
        pointer-events: none;
    }

    .tagify[disabled]:not(.tagify--mix):not(.tagify--select):not(
        .tagify--empty
      ),
    .tagify[readonly]:not(.tagify--mix):not(.tagify--select):not(
        .tagify--empty
      ) {
        cursor: default;
    }

    .tagify[disabled]:not(.tagify--mix):not(.tagify--select):not(.tagify--empty)
    > .tagify__input,
    .tagify[readonly]:not(.tagify--mix):not(.tagify--select):not(.tagify--empty)
    > .tagify__input {
        visibility: hidden;
        width: 0;
        margin: 5px 0;
    }

    .tagify[disabled]:not(.tagify--mix):not(.tagify--select):not(.tagify--empty)
    .tagify__tag
    > div,
    .tagify[readonly]:not(.tagify--mix):not(.tagify--select):not(.tagify--empty)
    .tagify__tag
    > div {
        padding: var(--tag-pad);
    }

    .tagify[disabled]:not(.tagify--mix):not(.tagify--select):not(.tagify--empty)
    .tagify__tag
    > div:before,
    .tagify[readonly]:not(.tagify--mix):not(.tagify--select):not(.tagify--empty)
    .tagify__tag
    > div:before {
        animation: readonlyStyles 1s calc(-1s * (var(--readonly-striped) - 1))
        paused;
    }

    .tagify[disabled] .tagify__tag__removeBtn,
    .tagify[readonly] .tagify__tag__removeBtn {
        display: none;
    }

    .tagify--loading .tagify__input > br:last-child {
        display: none;
    }

    .tagify--loading .tagify__input:before {
        content: none;
    }

    .tagify--loading .tagify__input:after {
        vertical-align: middle;
        opacity: 1;
        width: 0.7em;
        height: 0.7em;
        width: var(--loader-size);
        height: var(--loader-size);
        min-width: 0;
        border: 3px solid;
        border-color: #eee #bbb #888 transparent;
        border-radius: 50%;
        animation: rotateLoader 0.4s infinite linear;
        content: "" !important;
        margin: -2px 0 -2px 0.5em;
    }

    .tagify--loading .tagify__input:empty:after {
        margin-left: 0;
    }

    .tagify + input,
    .tagify + textarea {
        position: absolute !important;
        left: -9999em !important;
        transform: scale(0) !important;
    }

    .tagify__tag {
        display: inline-flex;
        align-items: center;
        max-width: var(--tag--max-width);
        margin-inline: 5px 0;
        margin-block: 5px;
        position: relative;
        z-index: 1;
        outline: 0;
        line-height: normal;
        cursor: default;
        transition: 0.13s ease-out;
    }

    .tagify__tag > div {
        display: flex;
        flex: 1;
        vertical-align: top;
        box-sizing: border-box;
        max-width: 100%;
        padding: var(--tag-pad);
        color: var(--tag-text-color);
        line-height: inherit;
        border-radius: var(--tag-border-radius);
        white-space: nowrap;
        transition: 0.13s ease-out;
    }

    .tagify__tag > div > * {
        white-space: pre-wrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        vertical-align: top;
        min-width: var(--tag--min-width);
        max-width: var(--tag--max-width);
        transition: 0.8s ease, 0.1s color;
    }

    .tagify__tag > div > [contenteditable] {
        display: block;
        outline: 0;
        -webkit-user-select: text;
        user-select: text;
        cursor: text;
        margin: -2px;
        padding: 2px;
        max-width: 350px;
    }

    .tagify__tag > div > :only-child {
        width: 100%;
    }

    .tagify__tag > div:before {
        content: "";
        position: absolute;
        border-radius: inherit;
        inset: var(--tag-bg-inset, 0);
        z-index: -1;
        pointer-events: none;
        transition: 0.12s ease;
        animation: tags--bump 0.3s ease-out 1;
        box-shadow: 0 0 0 var(--tag-inset-shadow-size) var(--tag-bg) inset;
    }

    .tagify__tag:focus div:before,
    .tagify__tag:hover:not([readonly]) div:before {
        --tag-bg-inset: -2.5px;
        --tag-bg: var(--tag-hover);
    }

    .tagify__tag--loading {
        pointer-events: none;
    }

    .tagify__tag--loading .tagify__tag__removeBtn {
        display: none;
    }

    .tagify__tag--loading:after {
        --loader-size: 0.4em;
        content: "";
        vertical-align: middle;
        opacity: 1;
        width: 0.7em;
        height: 0.7em;
        width: var(--loader-size);
        height: var(--loader-size);
        min-width: 0;
        border: 3px solid;
        border-color: #eee #bbb #888 transparent;
        border-radius: 50%;
        animation: rotateLoader 0.4s infinite linear;
        margin: 0 0.5em 0 -0.1em;
    }

    .tagify__tag--flash div:before {
        animation: none;
    }

    .tagify__tag--hide {
        width: 0 !important;
        padding-left: 0;
        padding-right: 0;
        margin-left: 0;
        margin-right: 0;
        opacity: 0;
        transform: scale(0);
        transition: var(--tag-hide-transition);
        pointer-events: none;
    }

    .tagify__tag--hide > div > * {
        white-space: nowrap;
    }

    .tagify__tag.tagify--noAnim > div:before {
        animation: none;
    }

    .tagify__tag.tagify--notAllowed:not(.tagify__tag--editable) div > span {
        opacity: 0.5;
    }

    .tagify__tag.tagify--notAllowed:not(.tagify__tag--editable) div:before {
        --tag-bg: var(--tag-invalid-bg);
        transition: 0.2s;
    }

    .tagify__tag[readonly] .tagify__tag__removeBtn {
        display: none;
    }

    .tagify__tag[readonly] > div:before {
        animation: readonlyStyles 1s calc(-1s * (var(--readonly-striped) - 1))
        paused;
    }

    @keyframes readonlyStyles {
        0% {
            background: linear-gradient(
                45deg,
                var(--tag-bg) 25%,
                transparent 25%,
                transparent 50%,
                var(--tag-bg) 50%,
                var(--tag-bg) 75%,
                transparent 75%,
                transparent
            )
            0/5px 5px;
            box-shadow: none;
            filter: brightness(0.95);
        }
    }

    .tagify__tag--editable > div {
        color: var(--tag-text-color--edit);
    }

    .tagify__tag--editable > div:before {
        box-shadow: 0 0 0 2px var(--tag-hover) inset !important;
    }

    .tagify__tag--editable > .tagify__tag__removeBtn {
        pointer-events: none;
        opacity: 0;
        transform: translate(100%) translate(5px);
    }

    .tagify__tag--editable.tagify--invalid > div:before {
        box-shadow: 0 0 0 2px var(--tag-invalid-color) inset !important;
    }

    .tagify__tag__removeBtn {
        order: 5;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50px;
        cursor: pointer;
        font: 14px/1 Arial;
        background: var(--tag-remove-btn-bg);
        color: var(--tag-remove-btn-color);
        width: 14px;
        height: 14px;
        margin-inline: auto 4.6666666667px;
        overflow: hidden;
        transition: 0.2s ease-out;
    }

    .tagify__tag__removeBtn:after {
        content: "×";
        transition: 0.3s, color 0s;
    }

    .tagify__tag__removeBtn:hover {
        color: #fff;
        background: var(--tag-remove-btn-bg--hover);
    }

    .tagify__tag__removeBtn:hover + div > span {
        opacity: 0.5;
    }

    .tagify__tag__removeBtn:hover + div:before {
        box-shadow: 0 0 0 var(--tag-inset-shadow-size)
        var(--tag-remove-bg, rgba(211, 148, 148, 0.3)) inset !important;
        transition: box-shadow 0.2s;
    }

    .tagify:not(.tagify--mix) .tagify__input br {
        display: none;
    }

    .tagify:not(.tagify--mix) .tagify__input * {
        display: inline;
        white-space: nowrap;
    }

    .tagify__input {
        flex-grow: 1;
        display: inline-block;
        min-width: 110px;
        margin: 5px;
        padding: var(--tag-pad);
        line-height: normal;
        position: relative;
        white-space: pre-wrap;
        color: var(--input-color);
        box-sizing: inherit;
        overflow: hidden;
    }

    .tagify__input:focus {
        outline: 0;
    }

    .tagify__input:focus:before {
        transition: 0.2s ease-out;
        opacity: 0;
        transform: translate(6px);
    }

    @supports (-ms-ime-align: auto) {
        .tagify__input:focus:before {
            display: none;
        }
    }

    .tagify__input:focus:empty:before {
        transition: 0.2s ease-out;
        opacity: 1;
        transform: none;
        color: #00000040;
        color: var(--placeholder-color-focus);
    }

    @-moz-document url-prefix() {
        .tagify__input:focus:empty:after {
            display: none;
        }
    }

    .tagify__input:before {
        content: attr(data-placeholder);
        width: 100%;
        height: 100%;
        margin: auto 0;
        z-index: 1;
        color: var(--placeholder-color);
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        pointer-events: none;
        opacity: 0;
        position: absolute;
    }

    .tagify__input:after {
        content: attr(data-suggest);
        display: inline-block;
        vertical-align: middle;
        position: absolute;
        min-width: calc(100% - 1.5em);
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: pre;
        color: var(--tag-text-color);
        opacity: 0.3;
        pointer-events: none;
        max-width: 100px;
    }

    .tagify__input .tagify__tag {
        margin: 0 1px;
    }

    .tagify--mix {
        display: block;
    }

    .tagify--mix .tagify__input {
        padding: 5px;
        margin: 0;
        width: 100%;
        height: 100%;
        line-height: 1.5;
        display: block;
    }

    .tagify--mix .tagify__input:before {
        height: auto;
        display: none;
        line-height: inherit;
    }

    .tagify--mix .tagify__input:after {
        content: none;
    }

    .tagify--select {
        cursor: default;
    }

    .tagify--select:after {
        content: ">";
        opacity: 0.5;
        position: absolute;
        top: 50%;
        right: 0;
        bottom: 0;
        font: 16px monospace;
        line-height: 8px;
        height: 8px;
        pointer-events: none;
        transform: translate(-150%, -50%) scaleX(1.2) rotate(90deg);
        transition: 0.2s ease-in-out;
    }

    .tagify--select[aria-expanded="true"]:after {
        transform: translate(-150%, -50%) rotate(270deg) scaleY(1.2);
    }

    .tagify--select[aria-expanded="true"] .tagify__tag__removeBtn {
        pointer-events: none;
        opacity: 0;
        transform: translate(100%) translate(5px);
    }

    .tagify--select .tagify__tag {
        flex: 1;
        max-width: none;
        margin-inline-end: 2em;
        margin-block: 0;
        padding-block: 5px;
        cursor: text;
    }

    .tagify--select .tagify__tag div:before {
        display: none;
    }

    .tagify--select .tagify__tag + .tagify__input {
        display: none;
    }

    .tagify--empty .tagify__input:before {
        transition: 0.2s ease-out;
        opacity: 1;
        transform: none;
        display: inline-block;
        width: auto;
    }

    .tagify--mix .tagify--empty .tagify__input:before {
        display: inline-block;
    }

    .tagify--focus {
        --tags-border-color: var(--tags-focus-border-color);
        transition: 0s;
    }

    .tagify--invalid {
        --tags-border-color: #d39494;
    }

    .tagify__dropdown {
        position: absolute;
        z-index: 9999;
        transform: translateY(-1px);
        border-top: 1px solid var(--tagify-dd-color-primary);
        overflow: hidden;
    }

    .tagify__dropdown[dir="rtl"] {
        transform: translate(-100%, -1px);
    }

    .tagify__dropdown[placement="top"] {
        margin-top: 0;
        transform: translateY(-100%);
    }

    .tagify__dropdown[placement="top"] .tagify__dropdown__wrapper {
        border-top-width: 1.1px;
        border-bottom-width: 0;
    }

    .tagify__dropdown[position="text"] {
        box-shadow: 0 0 0 3px rgba(var(--tagify-dd-color-primary), 0.1);
        font-size: 0.9em;
    }

    .tagify__dropdown[position="text"] .tagify__dropdown__wrapper {
        border-width: 1px;
    }

    .tagify__dropdown__wrapper {
        scroll-behavior: auto;
        max-height: var(--tagify-dd-max-height);
        overflow: hidden;
        overflow-x: hidden;
        color: var(--tagify-dd-text-color);
        background: var(--tagify-dd-bg-color);
        border: 1px solid;
        border-color: var(--tagify-dd-color-primary);
        border-bottom-width: 1.5px;
        border-top-width: 0;
        box-shadow: 0 2px 4px -2px #0003;
        transition: 0.3s cubic-bezier(0.5, 0, 0.3, 1), transform 0.15s;
        animation: dd-wrapper-show 0s 0.3s forwards;
    }

    @keyframes dd-wrapper-show {
        to {
            overflow-y: auto;
        }
    }

    .tagify__dropdown__header:empty {
        display: none;
    }

    .tagify__dropdown__footer {
        display: inline-block;
        margin-top: 0.5em;
        padding: var(--tagify-dd-item-pad);
        font-size: 0.7em;
        font-style: italic;
        opacity: 0.5;
    }

    .tagify__dropdown__footer:empty {
        display: none;
    }

    .tagify__dropdown--initial .tagify__dropdown__wrapper {
        max-height: 20px;
        transform: translateY(-1em);
    }

    .tagify__dropdown--initial[placement="top"] .tagify__dropdown__wrapper {
        transform: translateY(2em);
    }

    .tagify__dropdown__item {
        box-sizing: border-box;
        padding: var(--tagify-dd-item-pad);
        margin: 1px;
        white-space: pre-wrap;
        cursor: pointer;
        border-radius: 2px;
        outline: 0;
        max-height: 60px;
        max-width: 100%;
        line-height: normal;
        position: relative;
    }

    .tagify__dropdown__item--active {
        background: var(--tagify-dd-color-primary);
        color: #fff;
    }

    .tagify__dropdown__item:active {
        filter: brightness(105%);
    }

    .tagify__dropdown__item--hidden {
        padding-top: 0;
        padding-bottom: 0;
        margin: 0 1px;
        pointer-events: none;
        overflow: hidden;
        max-height: 0;
        transition: var(--tagify-dd-item--hidden-duration, 0.3s) !important;
    }

    .tagify__dropdown__item--hidden > * {
        transform: translateY(-100%);
        opacity: 0;
        transition: inherit;
    }

    .tagify__dropdown__item--selected:before {
        content: "✓";
        font-family: monospace;
        position: absolute;
        inset-inline-start: 6px;
        text-indent: 0;
        line-height: 1.1;
    }

    .tagify__dropdown:has(.tagify__dropdown__item--selected)
    .tagify__dropdown__item {
        text-indent: 1em;
    }

    .main-content-email-box {
        max-width: 720px;
    }

    .rich-email-editor {
        min-height: 100px;
        max-height: 400px;
        overflow: auto;
        border: none !important;
        padding: 5px 10px;
    }

    .rich-email-editor.ql-container.ql-snow .ql-editor::before {
        padding: 0px 10px;
    }

    .email-minimized .email-template-body,
    .email-minimized .email-child-wrapper,
    .email-minimized .email-footer-div {
        display: none;
    }

    .email-minimized .email-divider {
        display: none;
    }
</style>

<body class="out-quart">
<div id="loader">
    <div class="sk-plane load-spinner"></div>
    <div class="sk-chase load-spinner">
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
    </div>
    <div class="sk-bounce load-spinner">
        <div class="sk-bounce-dot"></div>
        <div class="sk-bounce-dot"></div>
    </div>
    <div class="sk-wave load-spinner">
        <div class="sk-wave-rect"></div>
        <div class="sk-wave-rect"></div>
        <div class="sk-wave-rect"></div>
        <div class="sk-wave-rect"></div>
        <div class="sk-wave-rect"></div>
    </div>
    <div class="sk-pulse load-spinner"></div>
    <div class="sk-flow load-spinner">
        <div class="sk-flow-dot"></div>
        <div class="sk-flow-dot"></div>
        <div class="sk-flow-dot"></div>
    </div>
    <div class="sk-swing load-spinner">
        <div class="sk-swing-dot"></div>
        <div class="sk-swing-dot"></div>
    </div>
    <div class="sk-circle load-spinner">
        <div class="sk-circle-dot"></div>
        <div class="sk-circle-dot"></div>
        <div class="sk-circle-dot"></div>
        <div class="sk-circle-dot"></div>
        <div class="sk-circle-dot"></div>
        <div class="sk-circle-dot"></div>
        <div class="sk-circle-dot"></div>
        <div class="sk-circle-dot"></div>
        <div class="sk-circle-dot"></div>
        <div class="sk-circle-dot"></div>
        <div class="sk-circle-dot"></div>
        <div class="sk-circle-dot"></div>
    </div>
    <div class="sk-circle-fade load-spinner">
        <div class="sk-circle-fade-dot"></div>
        <div class="sk-circle-fade-dot"></div>
        <div class="sk-circle-fade-dot"></div>
        <div class="sk-circle-fade-dot"></div>
        <div class="sk-circle-fade-dot"></div>
        <div class="sk-circle-fade-dot"></div>
        <div class="sk-circle-fade-dot"></div>
        <div class="sk-circle-fade-dot"></div>
        <div class="sk-circle-fade-dot"></div>
        <div class="sk-circle-fade-dot"></div>
        <div class="sk-circle-fade-dot"></div>
        <div class="sk-circle-fade-dot"></div>
    </div>
    <div class="sk-grid load-spinner">
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
    </div>
    <div class="sk-fold load-spinner">
        <div class="sk-fold-cube"></div>
        <div class="sk-fold-cube"></div>
        <div class="sk-fold-cube"></div>
        <div class="sk-fold-cube"></div>
    </div>
    <div class="sk-wander load-spinner">
        <div class="sk-wander-cube"></div>
        <div class="sk-wander-cube"></div>
        <div class="sk-wander-cube"></div>
    </div>
</div>
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

<!-- Ashter Working HTML start -->

<!-- PAGE CONTAINER -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<div id="root" class="root mn--max tm--primary-mn hd--sticky mn--sticky">
    <!-- CONTENTS -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

    <section class="custome-email-body">
        <div class="row g-0">
            <div class="col-md-2 bg-white left-sidebar d-flex flex-column">
                <div class="head-icons mb-3">
                    <div class="icon-side">
                        <i class="fa-solid fa-angles-left"></i> <span>Inbox</span>
                    </div>
                    <div class="search-side">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
                <div class="main-heading mb-2">
                    <i class="fa-solid fa-circle me-1"></i> You're available
                    <i class="fa-solid fa-caret-down ms-1"></i>
                </div>
                <hr class="border-bottom-dark my-2" />

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
                        <i class="fa-solid fa-caret-down less-icon me-2"></i> Less
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

                <hr class="my-2" />
                <div class="d-flex justify-content-center email-body-bottom-button">
                    <button class="button-one me-2">
                        Actions <i class="fa-solid fa-caret-down ms-2"></i>
                    </button>
                    <button class="button-two">Compose</button>
                </div>
                <div class="w-100 text-center text-muted" style="font-size: 0.8rem">
                    <i class="fa-solid fa-gear me-1"></i> Inbox Settings
                </div>
            </div>

            <div class="col-md-3 uppper-part-main">
                <div
                    class="d-flex justify-content-between align-items-center p-3 uppper-part"
                >
                    <div id="action-container" class="d-flex align-items-center">
                        <label class="custom-checkbox me-2">
                            <input type="checkbox" id="main-checkbox" />
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
                        Newest <i class="fa-solid fa-caret-down"></i>
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
                                        class="fa-regular fa-envelope active-enelops me-3"
                                    ></i>
                                    <div class="email-contents flex-grow-1">
                                        <p class="mb-0 email-address">
                                            hasnat.khan@stellers.org
                                        </p>
                                        <p class="mb-0 email-subject">Re: Test</p>
                                        <p class="small-para mb-0 text-muted">
                                            <i class="fa-solid fa-reply me-2"></i> test email
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
                  ><br />
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
                        <i class="fa-solid fa-user-circle profile-icon me-2"></i>
                        <div class="flex-grow-1">
                            <p class="user_name mb-0">
                                Moiz Athar <i class="fa-solid fa-caret-down ms-2"></i>
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
                            class="fa-solid fa-user-circle profile-icon profile-avatar-m me-3"
                        ></i>
                        <div class="flex-grow-1">
                            <p class="email-from mb-0">
                                <b>Moiz Athar</b>
                                <span class="text-muted small">8:19 PM</span>
                                <span class="ms-4 last-span text-bold"
                                >Email
                      <i class="fa-solid fa-caret-down ms-2 last-span-icon"></i>
                    </span>
                            </p>
                            <p class="mb-0 email-to text-muted small">
                                To: hasnat.khan@stellers.org
                            </p>
                            <p class="email-body mt-2">
                                On Tue, Sep 9, 2025 at 8:19 AM, Moiz Athar from Aims 2 user
                                alow
                                <a class="email-reply-address" href="#">moiz@saviours.co</a>
                                wrote:<br />
                                Test
                            </p>
                        </div>
                    </div>
                    <hr />
                    <div
                        class="d-flex justify-content-start align-items-center mt-3 envelop-open-text-section"
                    >
                        <i
                            class="fa-solid fa-envelope-open-text me-1 icon-email-reply"
                        ></i>
                        <span class="email-comment-tabs email-decription"
                        >Email <i class="fa-solid fa-caret-down ms-1"></i
                            ></span>
                        <i class="fa-solid fa-comment ms-4 me-2 icon-comment"></i>
                        <span class="email-comment-tabs comment-description"
                        >Comment</span
                        >
                        <span class="ms-auto">
                  <i
                      class="fa-solid fa-up-right-and-down-left-from-center enlarge-icon"
                  ></i>
                </span>
                    </div>
                    <div
                        class="d-flex justify-content-between email-area-choose-reciepeint align-items-center text-muted mt-2 mb-2"
                    >
                        <div>
                            <i class="fa-solid fa-reply"></i>
                            <input
                                class="email-area-input-for-recipeint ms-2"
                                placeholder="Enter or chooose a recipient"
                                type="text"
                            />
                        </div>
                        <i class="fa-solid fa-ellipsis-v me-5"></i>
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
                            <i class="fa-solid fa-check-circle me-1"></i>
                            <span>Close conversation</span>
                        </button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-tertiary-light">
                            <i class="fa-solid fa-ellipsis-h"></i>
                        </button>
                        <button
                            type="button"
                            class="btn btn-tertiary-light info-circle-iconnn"
                        >
                            <i class="fa-solid fa-info-circle"></i>
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
                    <hr />
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
    </section>

    <!-- Ashter Working HTML start End -->
    <!-- Add Note Modal -->
    <div
        class="modal fade"
        id="addNoteModal"
        tabindex="-1"
        aria-labelledby="addNoteModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNoteModalLabel">Add Note</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form
                    action="https://payusinginvoice.com/crm-development/admin/customer/contact/note/store"
                    method="POST"
                >
                    <input
                        type="hidden"
                        name="_token"
                        value="1vH94yB4UUsVONeEfOu7yS9Qri6WB7zUEuEiuscX"
                        autocomplete="off"
                    />
                    <input type="hidden" name="cus_contact_key" value="316290" />
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea
                                name="note"
                                class="form-control"
                                rows="3"
                                required
                            ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Note</button>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Note Modal -->
    <div
        class="modal fade NoteModal"
        id="editNoteModal"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Note</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>
                </div>
                <form action="" method="POST" id="editNoteModalForm">
                    <input
                        type="hidden"
                        name="_token"
                        value="1vH94yB4UUsVONeEfOu7yS9Qri6WB7zUEuEiuscX"
                        autocomplete="off"
                    />
                    <div class="modal-body">
                <textarea
                    id="note"
                    name="note"
                    class="form-control"
                    rows="3"
                    required
                ></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Update Note
                        </button>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="custom-form">
        <form
            id="manage-form"
            class="manage-form"
            method="POST"
            enctype="multipart/form-data"
        >
            <div class="form-container" id="formContainer">
                <label for="crsf_token" class="form-label d-none">Crsf Token</label>
                <input
                    type="text"
                    id="crsf_token"
                    name="crsf_token"
                    value=""
                    style="opacity: 0; position: absolute"
                />
                <!-- Form Header -->
                <div class="form-header fh-1">
                    <span id="custom-form-heading">Manage Company</span>
                    <button type="button" class="close-btn">×</button>
                </div>
                <!-- Form Body -->
                <div class="form-body">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            placeholder="Enter name"
                            required
                        />
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            placeholder="Enter email"
                            required
                        />
                    </div>
                    <div class="form-group mb-3">
                        <label for="designation" class="form-label">Designation</label>
                        <input
                            type="text"
                            class="form-control"
                            id="designation"
                            name="designation"
                            placeholder="e.g. Software Engineer"
                        />
                    </div>
                    <div class="form-group mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="" disabled>Select Gender</option>
                            <option value="male" selected>Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone_number" class="form-label"
                        >Phone Number</label
                        >
                        <input
                            type="text"
                            class="form-control"
                            id="phone_number"
                            name="phone_number"
                            placeholder="e.g. +1234567890"
                        />
                    </div>

                    <div class="form-group mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea
                            class="form-control"
                            id="address"
                            name="address"
                            rows="3"
                        ></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="image" class="form-label d-block"
                        >Profile Image (Optional)</label
                        >

                        <div class="d-flex align-items-start">
                            <!-- Image Upload Section (Left) -->
                            <div
                                class="me-3 image-div"
                                id="image-div"
                                style="display: none"
                            >
                                <label for="image">
                                    <img
                                        id="image-display"
                                        src=""
                                        alt="Preview"
                                        class="img-thumbnail"
                                        style="cursor: pointer; max-width: 100px"
                                        title="Click to choose a new file"
                                    />
                                </label>
                            </div>

                            <!-- Input Fields (Right) -->
                            <div class="flex-grow-1">
                                <div class="">
                                    <input
                                        type="file"
                                        class="form-control"
                                        id="image"
                                        name="image"
                                        accept="image/*"
                                        aria-describedby="imageHelp"
                                    />
                                </div>
                                <div class="input-group">
                                    <input
                                        type="url"
                                        class="form-control"
                                        id="image_url"
                                        name="image_url"
                                        placeholder="https://example.com/image.png"
                                        aria-describedby="imageHelp"
                                    />
                                </div>
                                <small id="imageHelp" class="form-text text-muted">
                                    You can either upload an image or provide a valid image
                                    URL.
                                </small>
                                <!-- Validation Error Messages -->
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="form-button">
                    <button type="submit" class="btn-primary save-btn">
                        <i class="fas fa-save me-2"></i> Save
                    </button>
                    <button type="button" class="btn-secondary close-btn">
                        <i class="fas fa-times me-2"></i> Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>

    <section class="new-template-mail email-template" id="emailTemplate">
        <div class="container-fluid p-0">
            <div class="row justify-content-end">
                <div class="col-lg-12">
                    <div class="email-header-main-wrapper">
                        <div class="email-child-wrapper-one">
                            <i
                                class="fa fa-angle-down minimize-btn"
                                aria-hidden="true"
                                style="cursor: pointer"
                            ></i>
                            <p class="email-titles" style="cursor: pointer">Email</p>
                        </div>
                        <div class="email-child-wrapper-one">
                            <i
                                class="fa fa-external-link-square"
                                aria-hidden="true"
                                style="cursor: pointer"
                            ></i>
                            <i
                                class="fa fa-times close-btn"
                                aria-hidden="true"
                                style="cursor: pointer"
                            ></i>
                        </div>
                    </div>
                    <div class="email-child-wrapper" style="padding: 10px 20px">
                        <p class="email-titles-hide">Templates</p>
                        <p class="email-titles-show">
                            Sequence
                            <span
                            ><i
                                    class="fa fa-lock icon-display-email-box"
                                    aria-hidden="true"
                                ></i
                                ></span>
                        </p>
                        <p class="email-titles-hide">Documnets</p>
                        <!-- <p class="email-titles-show">Meetings </p> -->
                        <div class="">
                            <button
                                class="email-titles-dropdown dropdown-toggle"
                                type="button"
                                id="dropdownMenuButtonmeet"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                Meetings
                            </button>
                            <ul
                                class="dropdown-menu email-titles-dropdown-menu"
                                aria-labelledby="dropdownMenuButtonmeet"
                            >
                                <li>
                                    <h4 class="main-content-email-text">
                                        Connect with your Email
                                    </h4>
                                </li>
                                <li class="text-center">
                                    <img
                                        src="img/dropdown-img.png"
                                        class="img-fluid dropdown-img"
                                    />
                                </li>
                                <li class="text-center">
                                    <p class="main-content-email-para">
                                        Lorem ipsum, dolor sit amet consectetur adipisicing
                                        elit. Obcaecati culpa optio ex et,
                                    </p>
                                    <button class="connect-to-inbox-btn">
                                        Get started<span
                                        ><i
                                                class="fa fa-external-link get-started-icon"
                                                aria-hidden="true"
                                            ></i
                                            ></span>
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="">
                            <button
                                class="email-titles-dropdown dropdown-toggle"
                                type="button"
                                id="dropdownMenuButtonquote"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                Quotes
                            </button>
                            <ul
                                class="dropdown-menu quotes-titles-dropdown-menu"
                                aria-labelledby="dropdownMenuButtonquote"
                            >
                                <li class="quotes-header-box">
                                    <p class="main-content-email-para quotes-content-para">
                                        Lorem ipsum, dolor sit amet consectetur
                                    </p>
                                </li>
                                <li class="email-footer-div">
                                    <a href="#" class="quotes-titles-link"
                                    >How do I create quotes?
                                        <span
                                        ><i
                                                class="fa fa-external-link icon-display-email-box get-started-icon"
                                                aria-hidden="true"
                                            ></i
                                            ></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="email-divider"></div>
                    <div class="email-template-body">
                        <div class="email-child-wrapper" style="padding: 5px 20px">
                            <p class="email-sending-titles">To</p>

                            <input
                                class="email-sender-name"
                                id="toFieldInput"
                                name="to"
                                value="ashcus@gmail.com"
                                type="text"
                                placeholder="Add recipients"
                                style="border: none"
                            />
                        </div>
                        <div
                            class="email-child-wrapper d-none"
                            id="ccField"
                            style="padding: 5px 20px"
                        >
                            <p class="email-sending-titles">Cc</p>

                            <input
                                class="email-sender-name"
                                id="ccFieldInput"
                                type="email"
                                name="cc"
                                placeholder="Add Cc recipients"
                                style="border: none"
                            />
                        </div>
                        <div
                            class="email-child-wrapper d-none"
                            id="bccField"
                            style="padding: 5px 20px"
                        >
                            <p class="email-sending-titles">Bcc</p>

                            <input
                                class="email-sender-name"
                                id="bccFieldInput"
                                name="bcc"
                                type="text"
                                placeholder="Add Bcc recipients"
                                style="border: none"
                            />
                        </div>
                        <div class="email-sending-box">
                            <div class="email-child-wrapper">
                                <p class="email-sending-titles">From</p>
                                <p class="email-sender-name" style="min-width: 550px">
                                    <select
                                        name="from_email"
                                        id="from_email"
                                        class="form-select form-control"
                                        style="width: auto; display: inline-block; border: none"
                                    >
                                        <option
                                            value="salena@gmail.com"
                                            data-name="Salena"
                                            data-company="gmail.com"
                                            selected
                                        >
                                            Salena (salena@gmail.com)
                                        </option>
                                        <option
                                            value="alora@gmail.com"
                                            data-name="Alora"
                                            data-company="gmail.com"
                                        >
                                            Alora (alora@gmail.com)
                                        </option>
                                        <option
                                            value="ashh@gmail.com"
                                            data-name="hkb"
                                            data-company="gmail.com"
                                        >
                                            hkb (ashh@gmail.com)
                                        </option>
                                        <option
                                            value="xcalbert@gmail.com"
                                            data-name="xc-Albert"
                                            data-company="gmail.com"
                                        >
                                            xc-Albert (xcalbert@gmail.com)
                                        </option>
                                        <option
                                            value="xcfiona@gmail.com"
                                            data-name="xc-Fiona"
                                            data-company="gmail.com"
                                        >
                                            xc-Fiona (xcfiona@gmail.com)
                                        </option>
                                        <option
                                            value="empoyeee1@gmail.com"
                                            data-name="Aoun Employee"
                                            data-company="gmail.com"
                                        >
                                            Aoun Employee (empoyeee1@gmail.com)
                                        </option>
                                        <option
                                            value="employee2@gmail.com"
                                            data-name="Emppoyee 2"
                                            data-company="gmail.com"
                                        >
                                            Emppoyee 2 (employee2@gmail.com)
                                        </option>
                                        <option
                                            value="em3@gmail.com"
                                            data-name="Employee 3"
                                            data-company="gmail.com"
                                        >
                                            Employee 3 (em3@gmail.com)
                                        </option>
                                        <option
                                            value="name1@gmail.com"
                                            data-name="Unknown Sender"
                                            data-company="gmail.com"
                                        >
                                            Unknown Sender (name1@gmail.com)
                                        </option>
                                        <option
                                            value="ashhf@gmail.com"
                                            data-name="Ashter F"
                                            data-company="gmail.com"
                                        >
                                            Ashter F (ashhf@gmail.com)
                                        </option>
                                        <option
                                            value="fu@gmail.com"
                                            data-name="F User"
                                            data-company="gmail.com"
                                        >
                                            F User (fu@gmail.com)
                                        </option>
                                        <option
                                            value="kmpp@gmail.com"
                                            data-name="Kumail Employee One"
                                            data-company="gmail.com"
                                        >
                                            Kumail Employee One (kmpp@gmail.com)
                                        </option>
                                        <option
                                            value="kumem2@gmail.com"
                                            data-name="Kumail Employee Two"
                                            data-company="gmail.com"
                                        >
                                            Kumail Employee Two (kumem2@gmail.com)
                                        </option>
                                        <option
                                            value="kumailthre@gmail.com"
                                            data-name="Kumail Employee Three"
                                            data-company="gmail.com"
                                        >
                                            Kumail Employee Three (kumailthre@gmail.com)
                                        </option>
                                        <option
                                            value="kumail333@gmail.com"
                                            data-name="Kumail Employee Three"
                                            data-company="gmail.com"
                                        >
                                            Kumail Employee Three (kumail333@gmail.com)
                                        </option>
                                        <option
                                            value="kum555@gmail.com"
                                            data-name="Kumail Employee five"
                                            data-company="gmail.com"
                                        >
                                            Kumail Employee five (kum555@gmail.com)
                                        </option>
                                        <option
                                            value="kum66@gmail.com"
                                            data-name="Kumail Employee Six"
                                            data-company="gmail.com"
                                        >
                                            Kumail Employee Six (kum66@gmail.com)
                                        </option>
                                        <option
                                            value="sev7@gmail.com"
                                            data-name="Kumail Team Seven"
                                            data-company="gmail.com"
                                        >
                                            Kumail Team Seven (sev7@gmail.com)
                                        </option>
                                        <option
                                            value="kumail8888@gmail.com"
                                            data-name="Kumail Employee Eight"
                                            data-company="gmail.com"
                                        >
                                            Kumail Employee Eight (kumail8888@gmail.com)
                                        </option>
                                    </select>

                                    <span id="from_company"> from gmail.com </span>
                                </p>
                            </div>
                            <div class="email-child-wrapper">
                                <p
                                    class="email-sending-titles"
                                    onclick="toggleCcField(this)"
                                    style="padding: 0 5px"
                                >
                                    Cc
                                </p>
                            </div>
                            <div class="email-child-wrapper">
                                <p
                                    class="email-sending-titles"
                                    onclick="toggleBccField(this)"
                                >
                                    Bcc
                                </p>
                            </div>
                        </div>
                        <div class="email-divider"></div>
                        <div class="email-child-wrapper" style="padding: 5px 20px">
                            <p class="email-sending-titles">Subject</p>

                            <input
                                type="text"
                                name="subject"
                                id="emailSubject"
                                value=""
                            />
                        </div>
                        <div class="email-divider"></div>
                        <div class="main-content-email-box">
                            <div
                                class="rich-email-editor"
                                data-placeholder="Write your message..."
                            ></div>
                            <input type="hidden" name="email_content" id="emailContent" />
                        </div>
                    </div>

                    <div class="email-footer-div">
                        <button class="email-footer-btn" id="sendEmailBtn">Send</button>
                        <button class="email-footer-btn close-btn gap-2">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- END - CONTENTS -->

    <!-- HEADER -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <header class="header">
        <div class="header__inner">
            <!-- Brand -->
            <div class="header__brand">
                <div class="brand-wrap">
                    <!-- Brand logo -->
                    <a
                        href="https://payusinginvoice.com/crm-development/admin/dashboard"
                        class="brand-img stretched-link"
                    >
                        <img
                            src="https://payusinginvoice.com/crm-development/assets/img/favicon.png"
                            alt="Logo"
                            class="logo"
                            style="max-width: 110px; max-height: 30px"
                        />
                    </a>

                    <!-- Brand title -->
                    <div class="brand-title">Crm</div>

                    <!-- You can also use IMG or SVG instead of a text element. -->
                    <!--
              <div class="brand-title">
                 <img src="./assets/img/brand-title.svg" alt="Brand Title">
              </div>
              -->
                </div>
            </div>
            <!-- End - Brand -->

            <div class="header__content">
                <!-- Content Header - Left Side: -->
                <div class="header__content-start">
                    <!-- Navigation Toggler -->
                    <button
                        type="button"
                        class="nav-toggler header__btn btn btn-icon btn-sm"
                        aria-label="Nav Toggler"
                    >
                        <i class="demo-psi-list-view"></i>
                    </button>

                    <div class="vr mx-1 d-none d-md-block"></div>

                    <!-- Searchbox -->
                    <div class="header-searchbox">
                        <!-- Searchbox toggler for small devices -->
                        <label
                            for="header-search-input"
                            class="header__btn d-md-none btn btn-icon rounded-pill shadow-none border-0 btn-sm"
                            type="button"
                        >
                            <i class="demo-psi-magnifi-glass"></i>
                        </label>

                        <!-- Searchbox input -->
                        <form
                            class="searchbox searchbox--auto-expand searchbox--hide-btn input-group"
                        >
                            <input
                                id="header-search-input"
                                class="searchbox__input form-control bg-transparent"
                                type="search"
                                placeholder="Type for search . . ."
                                aria-label="Search"
                            />
                            <div class="searchbox__backdrop">
                                <button
                                    class="searchbox__btn header__btn btn btn-icon rounded shadow-none border-0 btn-sm"
                                    type="button"
                                >
                                    <i class="demo-pli-magnifi-glass"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End - Content Header - Left Side -->

                <!-- Content Header - Right Side: -->
                <div class="header__content-end">
                    <!-- Mega Dropdown -->
                    <div class="dropdown">
                        <!-- Toggler -->
                        <button
                            class="header__btn btn btn-icon btn-sm"
                            type="button"
                            data-bs-toggle="dropdown"
                            data-bs-auto-close="outside"
                            aria-label="Megamenu dropdown"
                            aria-expanded="false"
                            disabled
                        >
                            <i class="demo-psi-layout-grid"></i>
                        </button>

                        <!-- Mega Dropdown Menu -->
                        <div class="dropdown-menu dropdown-menu-end p-3 mega-dropdown">
                            <div class="row">
                                <div class="col-md-3">
                                    <!-- Pages List Group -->
                                    <div class="list-group list-group-borderless">
                                        <div
                                            class="list-group-item d-flex align-items-center border-bottom mb-2"
                                        >
                                            <div class="flex-shrink-0 me-2">
                                                <i class="demo-pli-file fs-4"></i>
                                            </div>
                                            <h5 class="flex-grow-1 m-0">Pages</h5>
                                        </div>
                                        <a
                                            href="#"
                                            class="list-group-item list-group-item-action"
                                        >Profile</a
                                        >
                                        <a
                                            href="#"
                                            class="list-group-item list-group-item-action"
                                        >Search Result</a
                                        >
                                        <a
                                            href="#"
                                            class="list-group-item list-group-item-action"
                                        >FAQ</a
                                        >
                                        <a
                                            href="#"
                                            class="list-group-item list-group-item-action"
                                        >Screen Lock</a
                                        >
                                        <a
                                            href="#"
                                            class="list-group-item list-group-item-action"
                                        >Maintenance</a
                                        >
                                        <a
                                            href="#"
                                            class="list-group-item list-group-item-action"
                                        >Invoices</a
                                        >
                                        <a
                                            href="#"
                                            class="list-group-item list-group-item-action disabled"
                                            tabindex="-1"
                                            aria-disabled="true"
                                        >Disabled Item</a
                                        >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <!-- Mailbox list group -->
                                    <div class="list-group list-group-borderless mb-3">
                                        <div
                                            class="list-group-item d-flex align-items-center border-bottom mb-2"
                                        >
                                            <div class="flex-shrink-0 me-2">
                                                <i class="demo-pli-mail fs-4"></i>
                                            </div>
                                            <h5 class="flex-grow-1 m-0">Mailbox</h5>
                                        </div>
                                        <a
                                            href="#"
                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                        >
                                            Inbox
                                            <span class="badge bg-danger rounded-pill">14</span>
                                        </a>
                                        <a
                                            href="#"
                                            class="list-group-item list-group-item-action"
                                        >Read Messages</a
                                        >
                                        <a
                                            href="#"
                                            class="list-group-item list-group-item-action"
                                        >Compose</a
                                        >
                                        <a
                                            href="#"
                                            class="list-group-item list-group-item-action"
                                        >Template</a
                                        >
                                    </div>

                                    <!-- News -->
                                    <div
                                        class="list-group list-group-borderless bg-warning-subtle py-2"
                                    >
                                        <div
                                            class="list-group-item d-flex align-items-center border-bottom text-warning-emphasis"
                                        >
                                            <div class="flex-shrink-0 me-2">
                                                <i class="demo-pli-calendar-4 fs-4"></i>
                                            </div>
                                            <h5 class="flex-grow-1 m-0 text-reset">News</h5>
                                        </div>
                                        <small class="list-group-item text-warning-emphasis">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit. Hic dolore unde autem, molestiae eum laborum
                                            aliquid at commodi cum? Blanditiis.
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <!-- List Group -->
                                    <div class="list-group list-group-borderless">
                                        <div
                                            class="list-group-item list-group-item-action d-flex align-items-start mb-3"
                                        >
                                            <div class="flex-shrink-0 me-3">
                                                <i class="demo-pli-data-settings fs-1"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div
                                                    class="d-flex justify-content-between align-items-start"
                                                >
                                                    <a
                                                        href="#"
                                                        class="h5 d-block mb-0 stretched-link text-decoration-none"
                                                    >Data Backup</a
                                                    >
                                                    <span
                                                        class="badge bg-success rounded-pill ms-auto"
                                                    >40%</span
                                                    >
                                                </div>
                                                <small class="text-body-secondary"
                                                >Current usage of disks for backups.</small
                                                >
                                            </div>
                                        </div>

                                        <div
                                            class="list-group-item list-group-item-action d-flex align-items-start mb-3"
                                        >
                                            <div class="flex-shrink-0 me-3">
                                                <i class="demo-pli-support fs-1"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <a
                                                    href="#"
                                                    class="h5 d-block mb-0 stretched-link text-decoration-none"
                                                >Support</a
                                                >
                                                <small class="text-body-secondary"
                                                >Have any questions ? please don't hesitate to
                                                    ask.</small
                                                >
                                            </div>
                                        </div>

                                        <div
                                            class="list-group-item list-group-item-action d-flex align-items-start mb-3"
                                        >
                                            <div class="flex-shrink-0 me-3">
                                                <i class="demo-pli-computer-secure fs-1"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <a
                                                    href="#"
                                                    class="h5 d-block mb-0 stretched-link text-decoration-none"
                                                >Security</a
                                                >
                                                <small class="text-body-secondary"
                                                >Our devices are secure and up-to-date.</small
                                                >
                                            </div>
                                        </div>

                                        <div
                                            class="list-group-item list-group-item-action d-flex align-items-start"
                                        >
                                            <div class="flex-shrink-0 me-3">
                                                <i class="demo-pli-map-2 fs-1"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <a
                                                    href="#"
                                                    class="h5 d-block mb-0 stretched-link text-decoration-none"
                                                >Location</a
                                                >
                                                <small class="text-body-secondary"
                                                >From our location up here, we kept in close
                                                    touch.</small
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <!-- Simple gallery -->
                                    <div class="d-grid gap-2 pt-4 pt-md-0">
                                        <div class="row g-1 rounded-3 overflow-hidden">
                                            <div class="col-6 mt-0">
                                                <img
                                                    class="img-fluid"
                                                    src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/megamenu/img-1.jpg"
                                                    alt="thumbnails"
                                                    loading="lazy"
                                                />
                                            </div>
                                            <div class="col-6 mt-0">
                                                <img
                                                    class="img-fluid"
                                                    src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/megamenu/img-3.jpg"
                                                    alt="thumbnails"
                                                    loading="lazy"
                                                />
                                            </div>
                                            <div class="col-6">
                                                <img
                                                    class="img-fluid"
                                                    src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/megamenu/img-2.jpg"
                                                    alt="thumbnails"
                                                    loading="lazy"
                                                />
                                            </div>
                                            <div class="col-6">
                                                <img
                                                    class="img-fluid"
                                                    src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/megamenu/img-4.jpg"
                                                    alt="thumbnails"
                                                    loading="lazy"
                                                />
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-primary">Browse Gallery</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End - Mega Dropdown -->

                    <!-- Notification Dropdown -->
                    <div class="dropdown">
                        <!-- Toggler -->
                        <button
                            class="header__btn btn btn-icon btn-sm"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-label="Notification dropdown"
                            aria-expanded="false"
                            disabled
                        >
                  <span class="d-block position-relative">
                    <i class="demo-psi-bell"></i>

                    <span class="badge badge-super rounded-pill bg-danger p-1">
                      <span class="visually-hidden">unread messages</span>
                    </span>

                      <!-- Set custom notification count -->
                      <!--
                      <span class="badge badge-super rounded-pill bg-danger p-1">
                           19<span class="visually-hidden">unread messages</span>
                      </span>
                      -->
                  </span>
                        </button>

                        <!-- Notification dropdown menu -->
                        <div class="dropdown-menu dropdown-menu-end w-md-300px">
                            <div class="border-bottom px-3 py-2 mb-3">
                                <h5>Notifications</h5>
                            </div>

                            <div class="list-group list-group-borderless">
                                <!-- List item -->
                                <div
                                    class="list-group-item list-group-item-action d-flex align-items-center mb-3"
                                >
                                    <div class="flex-shrink-0 me-3">
                                        <i class="demo-psi-data-settings text-danger fs-2"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <a
                                            href="#"
                                            class="h6 fw-normal d-block mb-0 stretched-link text-decoration-none"
                                        >Your storage is full</a
                                        >
                                        <small class="text-body-secondary"
                                        >Local storage is nearly full.</small
                                        >
                                    </div>
                                </div>

                                <!-- List item -->
                                <div
                                    class="list-group-item list-group-item-action d-flex align-items-center mb-3"
                                >
                                    <div class="flex-shrink-0 me-3">
                                        <i class="demo-psi-pen-5 text-info fs-2"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <a
                                            href="#"
                                            class="h6 fw-normal d-block mb-0 stretched-link text-decoration-none"
                                        >Writing a New Article</a
                                        >
                                        <small class="text-body-secondary"
                                        >Wrote a news article for the John Mike</small
                                        >
                                    </div>
                                </div>

                                <!-- List item -->
                                <div
                                    class="list-group-item list-group-item-action d-flex align-items-start mb-3"
                                >
                                    <div class="flex-shrink-0 me-3">
                                        <i
                                            class="demo-psi-speech-bubble-3 text-success fs-2"
                                        ></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div
                                            class="d-flex justify-content-between align-items-start"
                                        >
                                            <a
                                                href="#"
                                                class="h6 fw-normal mb-0 stretched-link text-decoration-none"
                                            >Comment sorting</a
                                            >
                                            <span class="badge bg-info rounded ms-auto">NEW</span>
                                        </div>
                                        <small class="text-body-secondary"
                                        >You have 1,256 unsorted comments.</small
                                        >
                                    </div>
                                </div>

                                <!-- List item -->
                                <div
                                    class="list-group-item list-group-item-action d-flex align-items-start mb-3"
                                >
                                    <div class="flex-shrink-0 me-3">
                                        <img
                                            class="img-xs rounded-circle"
                                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/profile-photos/7.png"
                                            alt="Profile Picture"
                                            loading="lazy"
                                        />
                                    </div>
                                    <div class="flex-grow-1">
                                        <a
                                            href="#"
                                            class="h6 fw-normal d-block mb-0 stretched-link text-decoration-none"
                                        >Lucy Sent you a message</a
                                        >
                                        <small class="text-body-secondary"
                                        >30 minutes ago</small
                                        >
                                    </div>
                                </div>

                                <!-- List item -->
                                <div
                                    class="list-group-item list-group-item-action d-flex align-items-start mb-3"
                                >
                                    <div class="flex-shrink-0 me-3">
                                        <img
                                            class="img-xs rounded-circle"
                                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/profile-photos/3.png"
                                            alt="Profile Picture"
                                            loading="lazy"
                                        />
                                    </div>
                                    <div class="flex-grow-1">
                                        <a
                                            href="#"
                                            class="h6 fw-normal d-block mb-0 stretched-link text-decoration-none"
                                        >Jackson Sent you a message</a
                                        >
                                        <small class="text-body-secondary">1 hours ago</small>
                                    </div>
                                </div>

                                <div class="text-center mb-2">
                                    <a
                                        href="#"
                                        class="btn-link text-primary icon-link icon-link-hover"
                                    >
                                        Show all Notifications
                                        <i class="bi demo-psi-arrow-out-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End - Notification dropdown -->

                    <!-- User dropdown -->
                    <div class="dropdown">
                        <!-- Toggler -->
                        <button
                            class="header__btn btn btn-icon btn-sm"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-label="User dropdown"
                            aria-expanded="false"
                            disabled
                        >
                            <i class="demo-psi-male"></i>
                        </button>

                        <!-- User dropdown menu -->
                        <div class="dropdown-menu dropdown-menu-end w-md-450px">
                            <!-- User dropdown header -->
                            <div
                                class="d-flex align-items-center border-bottom px-3 py-2"
                            >
                                <div class="flex-shrink-0">
                                    <img
                                        class="img-sm rounded-circle"
                                        src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/profile-photos/4.png"
                                        alt="Profile Picture"
                                        loading="lazy"
                                    />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0">Aaron Chavez</h5>
                                    <span class="text-body-secondary fst-italic"
                                    >aaron_chavez@example.com</span
                                    >
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-7">
                                    <!-- Simple widget and reports -->
                                    <div class="list-group list-group-borderless mb-3">
                                        <div
                                            class="list-group-item text-center border-bottom mb-3"
                                        >
                                            <p class="h1 display-1 text-primary fw-semibold">
                                                17
                                            </p>
                                            <p class="h6 mb-0">
                                                <i class="demo-pli-basket-coins fs-3 me-2"></i> New
                                                orders
                                            </p>
                                            <small class="text-body-secondary"
                                            >You have new orders</small
                                            >
                                        </div>
                                        <div
                                            class="list-group-item py-0 d-flex justify-content-between align-items-center"
                                        >
                                            Today Earning
                                            <small class="fw-bolder">$578</small>
                                        </div>
                                        <div
                                            class="list-group-item py-0 d-flex justify-content-between align-items-center"
                                        >
                                            Tax
                                            <small class="fw-bolder text-danger">- $28</small>
                                        </div>
                                        <div
                                            class="list-group-item py-0 d-flex justify-content-between align-items-center"
                                        >
                                            Total Earning
                                            <span class="fw-bolder text-body-emphasis"
                                            >$6,578</span
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <!-- User menu link -->
                                    <div class="list-group list-group-borderless h-100 py-3">
                                        <a
                                            href="#"
                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                        >
                          <span
                          ><i class="demo-pli-mail fs-5 me-2"></i>
                            Messages</span
                          >
                                            <span class="badge bg-danger rounded-pill">14</span>
                                        </a>
                                        <a
                                            href="#"
                                            class="list-group-item list-group-item-action"
                                        >
                                            <i class="demo-pli-male fs-5 me-2"></i> Profile
                                        </a>
                                        <a
                                            href="#"
                                            class="list-group-item list-group-item-action"
                                        >
                                            <i class="demo-pli-gear fs-5 me-2"></i> Settings
                                        </a>

                                        <a
                                            href="#"
                                            class="list-group-item list-group-item-action mt-auto"
                                        >
                                            <i class="demo-pli-computer-secure fs-5 me-2"></i>
                                            Lock screen
                                        </a>
                                        <button
                                            type="button"
                                            class="list-group-item list-group-item-action"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        >
                                            <i class="demo-pli-unlock fs-5 me-2"></i> Logout
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End - User dropdown -->

                    <div class="vr mx-1 d-none d-md-block"></div>

                    <div class="form-check form-check-alt form-switch mx-md-2">
                        <input
                            id="headerThemeToggler"
                            class="form-check-input mode-switcher"
                            type="checkbox"
                            role="switch"
                            disabled
                        />
                        <label
                            class="form-check-label ps-1 fw-bold d-none d-md-flex align-items-center"
                            for="headerThemeToggler"
                        >
                            <i
                                class="mode-switcher-icon icon-light demo-psi-sun fs-5"
                            ></i>
                            <i
                                class="mode-switcher-icon icon-dark d-none demo-psi-half-moon"
                            ></i>
                        </label>
                    </div>

                    <div class="vr mx-1 d-none d-md-block"></div>

                    <!-- Channel Dropdown -->
                    <div class="dropdown">
                        <!-- Toggler -->
                        <button
                            class="header__btn channels btn"
                            type="button"
                            id="channelDropdown"
                            data-bs-toggle="dropdown"
                            aria-label="Channel dropdown"
                            aria-expanded="false"
                        >
                  <span class="d-block position-relative">
                    Pay using invoice
                  </span>
                        </button>

                        <!-- Channel dropdown menu -->
                        <div
                            class="dropdown-menu dropdown-menu-end w-md-300px"
                            aria-labelledby="channelDropdown"
                        >
                            <div class="border-bottom px-3 py-2 mb-2">
                                <h5>Channels</h5>
                            </div>
                            <div
                                class="list-group list-group-borderless channel-list px-3"
                            >
                                <!-- Current channel will be shown immediately -->
                                <div class="list-group-item py-1">
                      <span class="text-decoration-none text-primary fw-bold">
                        Pay using invoice (Current)
                      </span>
                                </div>
                                <!-- Loading indicator for other channels -->
                                <div
                                    class="list-group-item py-1 text-muted loading-channels"
                                    style="display: none"
                                >
                                    Checking available channels...
                                </div>
                                <!-- Channels will be appended here -->
                            </div>
                        </div>
                    </div>

                    <div class="vr mx-1 d-none d-md-block"></div>

                    <!-- Sidebar Toggler -->
                    <button
                        class="sidebar-toggler header__btn btn btn-icon btn-sm"
                        type="button"
                        aria-label="Sidebar button"
                        disabled
                    >
                        <i class="demo-psi-dot-vertical"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- END - HEADER -->

    <!-- MAIN NAVIGATION -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <nav id="mainnav-container" class="mainnav">
        <div class="mainnav__inner">
            <!-- Navigation menu -->
            <div class="mainnav__top-content scrollable-content pb-2 pt-2">
                <!-- Profile Widget -->
                <div
                    id="_dm-mainnavProfile"
                    class="mainnav__widget my-3 hv-outline-parent d-none"
                >
                    <!-- Profile picture  -->
                    <div class="mininav-toggle text-center py-2">
                        <img
                            class="mainnav__avatar img-md rounded-circle hv-oc profile-image"
                            style="background-color: var(--bs-secondary)"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/profile-photos/2.png"
                            alt="Hasnaat Khan"
                            title="Dashboard"
                            loading="lazy"
                        />
                    </div>
                    <div class="mininav-content collapse d-mn-max">
                        <span data-popper-arrow class="arrow"></span>
                        <div class="d-grid">
                            <!-- User name and position -->
                            <button
                                class="mainnav-widget-toggle d-block btn border-0 p-2"
                                data-bs-toggle="collapse"
                                data-bs-target="#usernav"
                                aria-expanded="false"
                                aria-controls="usernav"
                            >
                    <span
                        class="dropdown-toggle d-flex justify-content-center align-items-center"
                    >
                      <h5 class="mb-0 me-3">Hasnaat Khan</h5>
                    </span>
                            </button>
                            <div class="text-center pb-1">
                                <small class="text-body-secondary d-block"
                                >hasnat.khan@stellers.org</small
                                >
                                <small class="text-body-secondary d-block text-capitalize"
                                >Backend Developer</small
                                >
                            </div>

                            <!-- Collapsed user menu -->
                            <div id="usernav" class="nav flex-column collapse">
                                <a
                                    href="https://payusinginvoice.com/crm-development/admin/profile"
                                    class="nav-link"
                                >
                                    <i class="demo-pli-male fs-5 me-2"></i>
                                    <span class="ms-1">Profile</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End - Profile widget -->

                <!-- Navigation Category Dashboard -->
                <div class="mainnav__categoriy pb-1">
                    <ul class="mainnav__menu nav flex-column">
                        <!-- Link with submenu -->
                        <li class="nav-item has-sub">
                            <a class="mininav-toggle nav-link collapsed"
                            ><i class="demo-pli-home fs-5 me-2"></i>
                                <span class="nav-label ms-1">Dashboard</span>
                            </a>
                            <!-- Dashboard submenu list -->
                            <ul class="mininav-content nav collapse">
                                <li data-popper-arrow class="arrow"></li>
                                <li class="nav-item">
                                    <a
                                        href="https://payusinginvoice.com/crm-development/admin/dashboard"
                                        class="nav-link"
                                    >Dashboard 1</a
                                    >
                                </li>
                                <li class="nav-item">
                                    <a
                                        href="https://payusinginvoice.com/crm-development/admin/dashboard-2"
                                        class="nav-link"
                                    >Dashboard 2</a
                                    >
                                </li>
                            </ul>
                            <!-- END : Dashboard submenu list -->
                        </li>
                        <!-- END : Link with submenu -->
                    </ul>
                </div>
                <!-- END : Navigation Category -->

                <!-- Components Category Crm-->
                <div class="mainnav__categoriy py-1">
                    <h6 class="mainnav__caption mt-0 fw-bold">CRM</h6>
                    <ul class="mainnav__menu nav flex-column">
                        <!-- Link with submenu -->
                        <li class="nav-item">
                            <a
                                href="https://payusinginvoice.com/crm-development/admin/channels"
                                class="nav-link mininav-toggle"
                            >
                                <i class="demo-pli-data-cloud fs-5 me-2"></i>
                                <span
                                    class="nav-label mininav-content ms-1 collapse show"
                                    style=""
                                >
                      <span data-popper-arrow="" class="arrow"></span>
                      Channels
                    </span>
                            </a>
                        </li>
                        <li class="nav-item has-sub">
                            <a
                                href="javascript:void(0)"
                                class="mininav-toggle nav-link collapsed"
                            ><i class="demo-pli-building fs-5 me-2"></i>
                                <span class="nav-label ms-1">Sales</span>
                            </a>
                            <!-- Ui Elements submenu list -->
                            <ul class="mininav-content nav collapse">
                                <li data-popper-arrow class="arrow"></li>
                                <div class="navigate-heading">
                                    <i class="demo-pli-address-book"></i>
                                    <h3>Sales Kpi</h3>
                                </div>
                                <li class="nav-item">
                                    <a
                                        href="https://payusinginvoice.com/crm-development/admin/sales/sales-kpi"
                                        class="nav-link"
                                    >Sales Kpi</a
                                    >
                                </li>
                                <li class="nav-item">
                                    <a
                                        href="https://payusinginvoice.com/crm-development/admin/sales/sales-kpi-2"
                                        class="nav-link"
                                    >Sales Kpi 2</a
                                    >
                                </li>
                            </ul>
                            <!-- END : Ui Elements submenu list -->
                        </li>
                        <li class="nav-item">
                            <a
                                href="https://payusinginvoice.com/crm-development/admin/accounts"
                                class="nav-link mininav-toggle"
                            >
                                <i class="demo-pli-lock-user fs-5 me-2"></i>
                                <span
                                    class="nav-label mininav-content ms-1 collapse show"
                                    style=""
                                >
                      <span data-popper-arrow="" class="arrow"></span>
                      Admins
                    </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="https://payusinginvoice.com/crm-development/admin/employees"
                                class="nav-link mininav-toggle"
                            >
                                <i class="demo-pli-add-user fs-5 me-2"></i>
                                <span
                                    class="nav-label mininav-content ms-1 collapse show"
                                    style=""
                                >
                      <span data-popper-arrow="" class="arrow"></span>
                      Employees
                    </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="https://payusinginvoice.com/crm-development/admin/brands"
                                class="nav-link mininav-toggle"
                            >
                                <i class="demo-pli-tag fs-5 me-2"></i>
                                <span
                                    class="nav-label mininav-content ms-1 collapse show"
                                    style=""
                                >
                      <span data-popper-arrow="" class="arrow"></span>
                      Brands
                    </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="https://payusinginvoice.com/crm-development/admin/teams"
                                class="nav-link mininav-toggle"
                            >
                                <i class="demo-pli-add-user fs-5 me-2"></i>
                                <span
                                    class="nav-label mininav-content ms-1 collapse show"
                                    style=""
                                >
                      <span data-popper-arrow="" class="arrow"></span>
                      Teams
                    </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="https://payusinginvoice.com/crm-development/admin/team-targets"
                                class="nav-link mininav-toggle"
                            >
                                <i class="demo-pli-bar-chart fs-5 me-2"></i>
                                <span
                                    class="nav-label mininav-content ms-1 collapse show"
                                    style=""
                                >
                      <span data-popper-arrow="" class="arrow"></span>
                      Team Targets
                    </span>
                            </a>
                        </li>

                        <li class="nav-item has-sub">
                            <a
                                href="javascript:void(0)"
                                class="mininav-toggle nav-link collapsed"
                            ><i class="demo-pli-address-book fs-5 me-2"></i>
                                <span class="nav-label ms-1">Customers</span>
                            </a>
                            <!-- Ui Elements submenu list -->
                            <ul class="mininav-content nav collapse">
                                <li data-popper-arrow class="arrow"></li>
                                <div class="navigate-heading">
                                    <i class="demo-pli-address-book"></i>
                                    <h3>Customer</h3>
                                </div>
                                <li class="nav-item">
                                    <a
                                        href="https://payusinginvoice.com/crm-development/admin/customer/contacts"
                                        class="nav-link active"
                                    >Contact</a
                                    >
                                </li>
                                <li class="nav-item">
                                    <a
                                        href="https://payusinginvoice.com/crm-development/admin/customer/companies"
                                        class="nav-link"
                                    >Company</a
                                    >
                                </li>
                            </ul>
                            <!-- END : Ui Elements submenu list -->
                        </li>
                        <li class="nav-item has-sub">
                            <a
                                href="javascript:void(0)"
                                class="mininav-toggle nav-link collapsed"
                            ><i class="demo-pli-address-book fs-5 me-2"></i>
                                <span class="nav-label ms-1">Tasks</span>
                            </a>
                            <!-- Ui Elements submenu list -->
                            <ul class="mininav-content nav collapse">
                                <li data-popper-arrow class="arrow"></li>
                                <div class="navigate-heading">
                                    <i class="demo-pli-address-book"></i>
                                    <h3>Task Board</h3>
                                </div>
                                <li class="nav-item">
                                    <a
                                        href="https://payusinginvoice.com/crm-development/admin/tasks"
                                        target="_blank"
                                        class="nav-link"
                                    >Task Board</a
                                    >
                                </li>
                            </ul>
                            <!-- END : Ui Elements submenu list -->
                        </li>
                        <li class="nav-item">
                            <a
                                href="https://payusinginvoice.com/crm-development/admin/lead-statuses"
                                class="nav-link mininav-toggle"
                            >
                                <i class="demo-pli-gears fs-5 me-2"></i>
                                <span
                                    class="nav-label mininav-content ms-1 collapse show"
                                    style=""
                                >
                      <span data-popper-arrow="" class="arrow"></span>
                      Lead Status
                    </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="https://payusinginvoice.com/crm-development/admin/leads"
                                class="nav-link mininav-toggle"
                            >
                                <i class="demo-pli-mine fs-5 me-2"></i>
                                <span
                                    class="nav-label mininav-content ms-1 collapse show"
                                    style=""
                                >
                      <span data-popper-arrow="" class="arrow"></span>
                      Leads
                    </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="https://payusinginvoice.com/crm-development/admin/invoices"
                                class="nav-link mininav-toggle"
                            >
                                <i class="demo-pli-file fs-5 me-2"></i>
                                <span
                                    class="nav-label mininav-content ms-1 collapse show"
                                    style=""
                                >
                      <span data-popper-arrow="" class="arrow"></span>
                      Invoices
                    </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="https://payusinginvoice.com/crm-development/admin/payments"
                                class="nav-link mininav-toggle"
                            >
                                <i class="demo-pli-wallet-2 fs-5 me-2"></i>
                                <span
                                    class="nav-label mininav-content ms-1 collapse show"
                                    style=""
                                >
                      <span data-popper-arrow="" class="arrow"></span>
                      Payments
                    </span>
                            </a>
                        </li>

                        <li class="nav-item has-sub">
                            <a
                                href="javascript:void(0)"
                                class="mininav-toggle nav-link collapsed"
                            ><i class="demo-pli-add-user-star fs-5 me-2"></i>
                                <span class="nav-label ms-1">Clients</span>
                            </a>
                            <!-- Ui Elements submenu list -->
                            <ul class="mininav-content nav collapse">
                                <li data-popper-arrow class="arrow"></li>
                                <div class="navigate-heading">
                                    <i class="demo-pli-wallet-2"></i>
                                    <h3>Clients</h3>
                                </div>
                                <li class="nav-item">
                                    <a
                                        href="https://payusinginvoice.com/crm-development/admin/client/contacts"
                                        class="nav-link"
                                    >Contacts</a
                                    >
                                </li>

                                <li class="nav-item">
                                    <a
                                        href="https://payusinginvoice.com/crm-development/admin/client/companies"
                                        class="nav-link"
                                    >Company</a
                                    >
                                </li>
                                <li class="nav-item">
                                    <a
                                        href="https://payusinginvoice.com/crm-development/admin/client/accounts"
                                        class="nav-link"
                                    >Accounts</a
                                    >
                                </li>
                            </ul>
                            <!-- END : Ui Elements submenu list -->
                        </li>
                        <li class="nav-item">
                            <a
                                href="https://payusinginvoice.com/crm-development/admin/activity-logs"
                                class="nav-link mininav-toggle"
                            >
                                <i class="demo-pli-calendar-4 fs-5 me-2"></i>
                                <span
                                    class="nav-label mininav-content ms-1 collapse show"
                                    style=""
                                >
                      <span data-popper-arrow="" class="arrow"></span>
                      Activity Logs
                    </span>
                            </a>
                        </li>

                        <!-- END : Link with submenu -->
                    </ul>
                </div>
                <!-- END : Components Category -->

                <!-- Server Status Category -->

                <!-- End : Server Status Category -->
            </div>
            <!-- End - Navigation menu -->

            <!-- Bottom navigation menu -->
            <div class="mainnav__bottom-content border-top pb-2 pt-2">
                <ul id="mainnav" class="mainnav__menu nav flex-column">
                    <li class="nav-item has-sub">
                        <button
                            type="button"
                            class="nav-link"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        >
                            <i class="demo-pli-unlock fs-5 me-2"></i>
                            <span class="nav-label ms-1">Logout</span>
                        </button>
                        <form
                            method="POST"
                            action="https://payusinginvoice.com/crm-development/admin/logout"
                            id="logout-form"
                            class="d-none"
                        >
                            <input
                                type="hidden"
                                name="_token"
                                value="1vH94yB4UUsVONeEfOu7yS9Qri6WB7zUEuEiuscX"
                                autocomplete="off"
                            />
                        </form>
                    </li>
                </ul>
            </div>
            <!-- End - Bottom navigation menu -->
        </div>
    </nav>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- END - MAIN NAVIGATION -->

    <!-- SIDEBAR -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <aside class="sidebar">
        <div class="sidebar__inner scrollable-content">
            <!-- This element is only visible when sidebar Stick mode is active. -->
            <div class="sidebar__stuck align-items-center mb-3 px-3">
                <button
                    type="button"
                    class="sidebar-toggler btn-close btn-lg rounded-circle"
                    aria-label="Close"
                ></button>
                <p class="m-0 text-danger fw-bold">&lt;= Close the sidebar</p>
            </div>

            <!-- Sidebar tabs nav -->
            <div class="sidebar__wrap">
                <nav>
                    <div
                        class="nav nav-underline nav-fill nav-component flex-nowrap border-bottom"
                        id="nav-tab"
                        role="tablist"
                    >
                        <button
                            class="nav-link active"
                            data-bs-toggle="tab"
                            data-bs-target="#nav-chat"
                            type="button"
                            role="tab"
                            aria-controls="nav-chat"
                            aria-selected="true"
                        >
                            <i class="d-block demo-pli-speech-bubble-5 fs-3 mb-2"></i>
                            <span>Chat</span>
                        </button>

                        <button
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#nav-reports"
                            type="button"
                            role="tab"
                            aria-controls="nav-reports"
                            aria-selected="false"
                        >
                            <i class="d-block demo-pli-information fs-3 mb-2"></i>
                            <span>Reports</span>
                        </button>

                        <button
                            class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#nav-settings"
                            type="button"
                            role="tab"
                            aria-controls="nav-settings"
                            aria-selected="false"
                        >
                            <i class="d-block demo-pli-wrench fs-3 mb-2"></i>
                            <span>Settings</span>
                        </button>
                    </div>
                </nav>
            </div>
            <!-- End - Sidebar tabs nav -->

            <!-- Sideabar tabs content -->
            <div class="tab-content sidebar__wrap" id="nav-tabContent">
                <!-- Chat tab Content -->
                <div
                    id="nav-chat"
                    class="tab-pane fade py-4 show active"
                    role="tabpanel"
                    aria-labelledby="nav-chat-tab"
                >
                    <!-- Family list group -->
                    <h5 class="px-3">Family</h5>
                    <div class="list-group list-group-borderless">
                        <div
                            class="list-group-item list-group-item-action d-flex align-items-start mb-2"
                        >
                            <div class="flex-shrink-0 me-3">
                                <img
                                    class="img-xs rounded-circle"
                                    src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/profile-photos/2.png"
                                    alt="Profile Picture"
                                    loading="lazy"
                                />
                            </div>
                            <div class="flex-grow-1">
                                <a
                                    href="#"
                                    class="h6 d-block mb-0 stretched-link text-decoration-none"
                                >Stephen Tran</a
                                >
                                <small class="text-body-secondary">Available</small>
                            </div>
                        </div>

                        <div
                            class="list-group-item list-group-item-action d-flex align-items-start mb-2"
                        >
                            <div class="flex-shrink-0 me-3">
                                <img
                                    class="img-xs rounded-circle"
                                    src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/profile-photos/8.png"
                                    alt="Profile Picture"
                                    loading="lazy"
                                />
                            </div>
                            <div class="flex-grow-1">
                                <a
                                    href="#"
                                    class="h6 d-block mb-0 stretched-link text-decoration-none"
                                >Betty Murphy</a
                                >
                                <small class="text-body-secondary">Iddle</small>
                            </div>
                        </div>

                        <div
                            class="list-group-item list-group-item-action d-flex align-items-start mb-2"
                        >
                            <div class="flex-shrink-0 me-3">
                                <img
                                    class="img-xs rounded-circle"
                                    src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/profile-photos/7.png"
                                    alt="Profile Picture"
                                    loading="lazy"
                                />
                            </div>
                            <div class="flex-grow-1">
                                <a
                                    href="#"
                                    class="h6 d-block mb-0 stretched-link text-decoration-none"
                                >Brittany Meyer</a
                                >
                                <small class="text-body-secondary">I think so!</small>
                            </div>
                        </div>

                        <div
                            class="list-group-item list-group-item-action d-flex align-items-start mb-2"
                        >
                            <div class="flex-shrink-0 me-3">
                                <img
                                    class="img-xs rounded-circle"
                                    src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/profile-photos/4.png"
                                    alt="Profile Picture"
                                    loading="lazy"
                                />
                            </div>
                            <div class="flex-grow-1">
                                <a
                                    href="#"
                                    class="h6 d-block mb-0 stretched-link text-decoration-none"
                                >Jack George</a
                                >
                                <small class="text-body-secondary"
                                >Last seen 2 hours ago</small
                                >
                            </div>
                        </div>
                    </div>
                    <!-- End - Family list group -->

                    <!-- Friends Group -->
                    <h5 class="d-flex mt-5 px-3">
                        Friends <span class="badge bg-success ms-auto">587 +</span>
                    </h5>
                    <div class="list-group list-group-borderless">
                        <a href="#" class="list-group-item list-group-item-action">
                  <span
                      class="d-inline-block bg-success rounded-circle p-1 me-2"
                  ></span>
                            Joey K. Greyson
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                  <span
                      class="d-inline-block bg-info rounded-circle p-1 me-2"
                  ></span>
                            Andrea Branden
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                  <span
                      class="d-inline-block bg-warning rounded-circle p-1 me-2"
                  ></span>
                            Johny Juan
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                  <span
                      class="d-inline-block bg-secondary rounded-circle p-1 me-2"
                  ></span>
                            Susan Sun
                        </a>
                    </div>
                    <!-- End - Friends Group -->

                    <!-- Simple news widget -->
                    <div class="p-3 mt-5 rounded bg-info-subtle text-info-emphasis">
                        <h5 class="text-info-emphasis">News</h5>
                        <p>
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui
                            consequatur ipsum porro a repellat eaque exercitationem
                            necessitatibus esse voluptate corporis.
                        </p>
                        <small class="fst-italic">Last Update : Today 13:54</small>
                    </div>
                    <!-- End - Simple news widget -->
                </div>
                <!-- End - Chat tab content -->

                <!-- Reports tab content -->
                <div
                    id="nav-reports"
                    class="tab-pane fade py-4"
                    role="tabpanel"
                    aria-labelledby="nav-reports-tab"
                >
                    <!-- Billing and Resports -->
                    <div class="px-3">
                        <h5 class="mb-3">Billing &amp; Reports</h5>
                        <p>
                            Get <span class="badge bg-danger">$15.00 off</span> your next
                            bill by making sure your full payment reaches us before August
                            5th.
                        </p>

                        <h5 class="mt-5 mb-0">Amount Due On</h5>
                        <p>August 17, 2028</p>
                        <p class="h1">$83.09</p>

                        <div class="d-grid">
                            <button class="btn btn-success" type="button">Pay now</button>
                        </div>
                    </div>
                    <!-- End - Billing and Resports -->

                    <!-- Additional actions nav -->
                    <h5 class="mt-5 px-3">Additional Actions</h5>
                    <div class="list-group list-group-borderless">
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="demo-pli-information me-2 fs-5"></i>
                            Services Information
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="demo-pli-mine me-2 fs-5"></i>
                            Usage
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="demo-pli-credit-card-2 me-2 fs-5"></i>
                            Payment Options
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="demo-pli-support me-2 fs-5"></i>
                            Messages Center
                        </a>
                    </div>
                    <!-- End - Additional actions nav -->

                    <!-- Contact widget -->
                    <div class="px-3 mt-5 text-center">
                        <div class="mb-3">
                            <i class="demo-pli-old-telephone display-4 text-primary"></i>
                        </div>
                        <p>Have a question ?</p>
                        <p class="h5 mb-0">(415) 234-53454</p>
                        <small><em>We are here 24/7</em></small>
                    </div>
                    <!-- End - Contact widget -->
                </div>
                <!-- End - Reports tab content -->

                <!-- Settings content -->
                <div
                    id="nav-settings"
                    class="tab-pane fade py-4"
                    role="tabpanel"
                    aria-labelledby="nav-settings-tab"
                >
                    <!-- Account settings -->
                    <h5 class="px-3">Account Settings</h5>
                    <div class="list-group list-group-borderless">
                        <div class="list-group-item mb-1">
                            <div class="d-flex justify-content-between mb-1">
                                <label
                                    class="form-check-label text-body-emphasis stretched-link"
                                    for="_dm-sbPersonalStatus"
                                >Show my personal status</label
                                >
                                <div class="form-check form-switch">
                                    <input
                                        id="_dm-sbPersonalStatus"
                                        class="form-check-input"
                                        type="checkbox"
                                        checked
                                    />
                                </div>
                            </div>
                            <small class="text-body-secondary"
                            >Lorem ipsum dolor sit amet, consectetuer adipiscing
                                elit.</small
                            >
                        </div>

                        <div class="list-group-item mb-1">
                            <div class="d-flex justify-content-between mb-1">
                                <label
                                    class="form-check-label text-body-emphasis stretched-link"
                                    for="_dm-sbOfflineContact"
                                >Show offline contact</label
                                >
                                <div class="form-check form-switch">
                                    <input
                                        id="_dm-sbOfflineContact"
                                        class="form-check-input"
                                        type="checkbox"
                                    />
                                </div>
                            </div>
                            <small class="text-body-secondary"
                            >Aenean commodo ligula eget dolor. Aenean massa.</small
                            >
                        </div>

                        <div class="list-group-item mb-1">
                            <div class="d-flex justify-content-between mb-1">
                                <label
                                    class="form-check-label text-body-emphasis stretched-link"
                                    for="_dm-sbInvisibleMode"
                                >Invisible Mode</label
                                >
                                <div class="form-check form-switch">
                                    <input
                                        id="_dm-sbInvisibleMode"
                                        class="form-check-input"
                                        type="checkbox"
                                    />
                                </div>
                            </div>
                            <small class="text-body-secondary"
                            >Cum sociis natoque penatibus et magnis dis parturient
                                montes, nascetur ridiculus mus.</small
                            >
                        </div>
                    </div>
                    <!-- End - Account settings -->

                    <!-- Public Settings -->
                    <h5 class="mt-5 px-3">Public Settings</h5>
                    <div class="list-group list-group-borderless">
                        <div
                            class="list-group-item d-flex justify-content-between mb-1"
                        >
                            <label class="form-check-label" for="_dm-sbOnlineStatus"
                            >Online Status</label
                            >
                            <div class="form-check form-switch">
                                <input
                                    id="_dm-sbOnlineStatus"
                                    class="form-check-input"
                                    type="checkbox"
                                    checked
                                />
                            </div>
                        </div>

                        <div
                            class="list-group-item d-flex justify-content-between mb-1"
                        >
                            <label class="form-check-label" for="_dm-sbMuteNotifications"
                            >Mute Notifications</label
                            >
                            <div class="form-check form-switch">
                                <input
                                    id="_dm-sbMuteNotifications"
                                    class="form-check-input"
                                    type="checkbox"
                                    checked
                                />
                            </div>
                        </div>

                        <div
                            class="list-group-item d-flex justify-content-between mb-1"
                        >
                            <label class="form-check-label" for="_dm-sbMyDevicesName"
                            >Show my device name</label
                            >
                            <div class="form-check form-switch">
                                <input
                                    id="_dm-sbMyDevicesName"
                                    class="form-check-input"
                                    type="checkbox"
                                    checked
                                />
                            </div>
                        </div>
                    </div>
                    <!-- End - Public Settings -->
                </div>
                <!-- End - Settings content -->
            </div>
            <!-- End - Sidebar tabs content -->
        </div>
    </aside>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- END - SIDEBAR -->
</div>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- END - PAGE CONTAINER -->

<!-- SCROLL TO TOP BUTTON -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<div class="scroll-container">
    <a
        href="javascript:void(0)"
        class="scroll-page ratio ratio-1x1"
        aria-label="Scroll button"
    ></a>
</div>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- END - SCROLL TO TOP BUTTON -->

<!-- BOXED LAYOUT : BACKGROUND IMAGES CONTENT [ DEMO ] -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<div
    id="_dm-boxedBgContent"
    class="_dm-boxbg offcanvas offcanvas-bottom"
    data-bs-scroll="true"
    tabindex="-1"
>
    <div class="offcanvas-body px-4">
        <!-- Content Header -->
        <div class="offcanvas-header border-bottom p-0 pb-3">
            <div>
                <h4 class="offcanvas-title">Background Images</h4>
                <span class="text-body-secondary"
                >Add an image to replace the solid background color</span
                >
            </div>
            <button
                type="button"
                class="btn-close btn-lg text-reset shadow-none"
                data-bs-dismiss="offcanvas"
                aria-label="Close"
            ></button>
        </div>
        <!-- End - Content header -->

        <!-- Collection Of Images -->
        <div id="_dm-boxedBgContainer" class="row mt-3">
            <!-- Blurred Background Images -->
            <div class="col-lg-4">
                <h5 class="mb-2">Blurred</h5>
                <div class="_dm-boxbg__img-container d-flex flex-wrap">
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/1.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/2.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/3.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/4.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/5.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/6.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/7.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/8.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/9.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/10.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/11.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/12.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/13.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/14.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/15.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/16.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                </div>
            </div>
            <!-- End - Blurred Background Images -->

            <!-- Polygon Background Images -->
            <div class="col-lg-4">
                <h5 class="mb-2">Polygon &amp; Geometric</h5>
                <div class="_dm-boxbg__img-container d-flex flex-wrap mb-4">
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/1.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/2.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/3.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/4.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/5.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/6.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/7.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/8.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/9.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/10.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/11.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/12.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/13.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/14.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/15.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/16.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                </div>
            </div>
            <!-- End - Polygon Background Images -->

            <!-- Abstract Background Images -->
            <div class="col-lg-4">
                <h5 class="mb-2">Abstract</h5>
                <div class="_dm-boxbg__img-container d-flex flex-wrap">
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/1.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/2.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/3.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/4.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/5.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/6.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/7.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/8.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/9.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/10.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/11.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/12.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/13.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/14.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/15.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img
                            class="img-responsive"
                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/16.jpg"
                            alt="Background Image"
                            loading="lazy"
                        />
                    </a>
                </div>
            </div>
            <!-- End - Abstract Background Images -->
        </div>
        <!-- End - Collection Of Images -->
    </div>
</div>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- END - BOXED LAYOUT : BACKGROUND IMAGES CONTENT [ DEMO ] -->

<!-- SETTINGS CONTAINER [ DEMO ] -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<div
    id="_dm-settingsContainer"
    class="_dm-settings-container offcanvas offcanvas-end rounded-start"
    tabindex="-1"
>
    <button
        id="_dm-settingsToggler"
        class="_dm-btn-settings btn btn-sm btn-primary p-2 rounded-0 rounded-start shadow-none"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#_dm-settingsContainer"
        aria-label="Customization button"
        aria-controls="#_dm-settingsContainer"
    >
        <i class="demo-psi-gear fs-1"></i>
    </button>

    <form id="settingsForm">
        <div class="offcanvas-body py-0">
            <div class="_dm-settings-container__content row">
                <div class="col-lg-3 p-4">
                    <h4 class="fw-bold pb-3 mb-2">Layouts</h4>

                    <!-- OPTION : Centered Layout -->
                    <h6 class="mb-2 pb-1">Layouts</h6>
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label
                            class="form-check-label flex-fill"
                            for="_dm-fluidLayoutRadio"
                        >Fluid Layout</label
                        >
                        <div class="form-check form-switch">
                            <input
                                id="_dm-fluidLayoutRadio"
                                class="form-check-input ms-0"
                                type="radio"
                                name="settingLayouts"
                                autocomplete="off"
                                checked
                            />
                        </div>
                    </div>

                    <!-- OPTION : Boxed layout -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label
                            class="form-check-label flex-fill"
                            for="_dm-boxedLayoutRadio"
                        >Boxed Layout</label
                        >
                        <div class="form-check form-switch">
                            <input
                                id="_dm-boxedLayoutRadio"
                                class="form-check-input ms-0"
                                type="radio"
                                name="settingLayouts"
                                autocomplete="off"
                            />
                        </div>
                    </div>

                    <!-- OPTION : Boxed layout with background images -->
                    <div
                        id="_dm-boxedBgOption"
                        class="opacity-50 d-flex align-items-center pt-1 mb-2"
                    >
                        <label class="form-label flex-fill mb-0"
                        >BG for Boxed Layout</label
                        >

                        <button
                            id="_dm-boxedBgBtn"
                            class="btn btn-icon btn-primary btn-xs"
                            type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#_dm-boxedBgContent"
                            disabled
                        >
                            <i class="demo-psi-dot-horizontal"></i>
                        </button>
                    </div>

                    <!-- OPTION : Centered Layout -->
                    <div class="d-flex align-items-start pt-1 pb-3 mb-2">
                        <label
                            class="form-check-label flex-fill text-nowrap"
                            for="_dm-centeredLayoutRadio"
                        >Centered Layout</label
                        >
                        <div class="form-check form-switch">
                            <input
                                id="_dm-centeredLayoutRadio"
                                class="form-check-input ms-0"
                                type="radio"
                                name="settingLayouts"
                                autocomplete="off"
                            />
                        </div>
                    </div>

                    <!-- OPTION : Transition timing -->
                    <h6 class="mt-4 mb-2 py-1">Transitions</h6>
                    <div class="d-flex align-items-center pt-1 pb-3 mb-2">
                        <select
                            id="_dm-transitionSelect"
                            class="form-select"
                            aria-label="select transition timing"
                        >
                            <option value="in-quart">In Quart</option>
                            <option value="out-quart" selected>Out Quart</option>
                            <option value="in-back">In Back</option>
                            <option value="out-back">Out Back</option>
                            <option value="in-out-back">In Out Back</option>
                            <option value="steps">Steps</option>
                            <option value="jumping">Jumping</option>
                            <option value="rubber">Rubber</option>
                        </select>
                    </div>

                    <!-- OPTION : Sticky Header -->
                    <h6 class="mt-4 mb-2 py-1">Header</h6>
                    <div class="d-flex align-items-center pt-1 pb-3 mb-2">
                        <label
                            class="form-check-label flex-fill"
                            for="_dm-stickyHeaderCheckbox"
                        >Sticky header</label
                        >
                        <div class="form-check form-switch">
                            <input
                                id="_dm-stickyHeaderCheckbox"
                                class="form-check-input ms-0"
                                type="checkbox"
                                autocomplete="off"
                                checked
                            />
                        </div>
                    </div>

                    <button type="submit" class="btn btn-md btn-primary">Save</button>

                    <!-- OPTION : Additional Offcanvas -->
                </div>
                <div class="col-lg-3 p-4 bg-body">
                    <h4 class="fw-bold pb-3 mb-2">Sidebars</h4>

                    <!-- OPTION : Sticky Navigation -->
                    <h6 class="mb-2 pb-1">Navigation</h6>
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label
                            class="form-check-label flex-fill"
                            for="_dm-stickyNavCheckbox"
                        >Sticky navigation</label
                        >
                        <div class="form-check form-switch">
                            <input
                                id="_dm-stickyNavCheckbox"
                                class="form-check-input ms-0"
                                type="checkbox"
                                autocomplete="off"
                                checked
                            />
                        </div>
                    </div>

                    <!-- OPTION : Navigation Profile Widget -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label
                            class="form-check-label flex-fill"
                            for="_dm-profileWidgetCheckbox"
                        >Widget Profile</label
                        >
                        <div class="form-check form-switch">
                            <input
                                id="_dm-profileWidgetCheckbox"
                                class="form-check-input ms-0 enabled"
                                type="checkbox"
                                autocomplete="off"
                            />
                        </div>
                    </div>

                    <!-- OPTION : Mini navigation mode -->
                    <div class="d-flex align-items-center pt-3 mb-2">
                        <label class="form-check-label flex-fill" for="_dm-miniNavRadio"
                        >Min / Collapsed Mode</label
                        >
                        <div class="form-check form-switch">
                            <input
                                id="_dm-miniNavRadio"
                                class="form-check-input ms-0"
                                type="radio"
                                name="navigation-mode"
                                autocomplete="off"
                            />
                        </div>
                    </div>

                    <!-- OPTION : Maxi navigation mode -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label class="form-check-label flex-fill" for="_dm-maxiNavRadio"
                        >Max / Expanded Mode</label
                        >
                        <div class="form-check form-switch">
                            <input
                                id="_dm-maxiNavRadio"
                                class="form-check-input ms-0"
                                type="radio"
                                name="navigation-mode"
                                autocomplete="off"
                                checked
                            />
                        </div>
                    </div>

                    <!-- OPTION : Push navigation mode -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label class="form-check-label flex-fill" for="_dm-pushNavRadio"
                        >Push Mode</label
                        >
                        <div class="form-check form-switch">
                            <input
                                id="_dm-pushNavRadio"
                                class="form-check-input ms-0"
                                type="radio"
                                name="navigation-mode"
                                autocomplete="off"
                            />
                        </div>
                    </div>

                    <!-- OPTION : Slide on top navigation mode -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label
                            class="form-check-label flex-fill"
                            for="_dm-slideNavRadio"
                        >Slide on top</label
                        >
                        <div class="form-check form-switch">
                            <input
                                id="_dm-slideNavRadio"
                                class="form-check-input ms-0"
                                type="radio"
                                name="navigation-mode"
                                autocomplete="off"
                            />
                        </div>
                    </div>

                    <!-- OPTION : Slide on top navigation mode -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label
                            class="form-check-label flex-fill"
                            for="_dm-revealNavRadio"
                        >Reveal Mode</label
                        >
                        <div class="form-check form-switch">
                            <input
                                id="_dm-revealNavRadio"
                                class="form-check-input ms-0"
                                type="radio"
                                name="navigation-mode"
                                autocomplete="off"
                            />
                        </div>
                    </div>

                    <div
                        class="d-flex align-items-center justify-content-between gap-3 py-3"
                    >
                        <button
                            class="nav-toggler btn btn-primary btn-sm"
                            type="button"
                        >
                            Navigation
                        </button>
                        <button
                            class="sidebar-toggler btn btn-primary btn-sm"
                            type="button"
                        >
                            Sidebar
                        </button>
                    </div>

                    <h6 class="mt-3 mb-2 py-1">Sidebar</h6>

                    <!-- OPTION : Disable sidebar backdrop -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label
                            class="form-check-label flex-fill"
                            for="_dm-disableBackdropCheckbox"
                        >Disable backdrop</label
                        >
                        <div class="form-check form-switch">
                            <input
                                id="_dm-disableBackdropCheckbox"
                                class="form-check-input ms-0"
                                type="checkbox"
                                autocomplete="off"
                            />
                        </div>
                    </div>

                    <!-- OPTION : Static position -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label
                            class="form-check-label flex-fill"
                            for="_dm-staticSidebarCheckbox"
                        >Static position</label
                        >
                        <div class="form-check form-switch">
                            <input
                                id="_dm-staticSidebarCheckbox"
                                class="form-check-input ms-0"
                                type="checkbox"
                                autocomplete="off"
                            />
                        </div>
                    </div>

                    <!-- OPTION : Stuck sidebar -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label
                            class="form-check-label flex-fill"
                            for="_dm-stuckSidebarCheckbox"
                        >Stuck Sidebar
                        </label>
                        <div class="form-check form-switch">
                            <input
                                id="_dm-stuckSidebarCheckbox"
                                class="form-check-input ms-0"
                                type="checkbox"
                                autocomplete="off"
                            />
                        </div>
                    </div>

                    <!-- OPTION : Unite Sidebar -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label
                            class="form-check-label flex-fill"
                            for="_dm-uniteSidebarCheckbox"
                        >Unite Sidebar</label
                        >
                        <div class="form-check form-switch">
                            <input
                                id="_dm-uniteSidebarCheckbox"
                                class="form-check-input ms-0"
                                type="checkbox"
                                autocomplete="off"
                            />
                        </div>
                    </div>

                    <!-- OPTION : Pinned Sidebar -->
                    <div class="d-flex align-items-start pt-1 mb-2">
                        <label
                            class="form-check-label flex-fill"
                            for="_dm-pinnedSidebarCheckbox"
                        >Pinned Sidebar</label
                        >
                        <div class="form-check form-switch">
                            <input
                                id="_dm-pinnedSidebarCheckbox"
                                class="form-check-input ms-0"
                                type="checkbox"
                                autocomplete="off"
                            />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 p-4">
                    <h4 class="fw-bold pb-3 mb-2">Colors</h4>

                    <div class="d-flex mb-4 pb-4">
                        <div class="d-flex flex-column">
                            <h5 class="h6">Modes</h5>
                            <div class="form-check form-check-alt form-switch">
                                <input
                                    id="settingsThemeToggler"
                                    class="form-check-input mode-switcher"
                                    type="checkbox"
                                    role="switch"
                                />
                                <label
                                    class="form-check-label ps-3 fw-bold d-none d-md-flex align-items-center"
                                    for="settingsThemeToggler"
                                >
                                    <i
                                        class="mode-switcher-icon icon-light demo-psi-sun fs-3"
                                    ></i>
                                    <i
                                        class="mode-switcher-icon icon-dark d-none demo-psi-half-moon fs-5"
                                    ></i>
                                </label>
                            </div>
                        </div>
                        <div class="vr mx-4"></div>
                        <div class="_dm-colorSchemesMode__colors">
                            <h5 class="h6">Color Schemes</h5>
                            <div
                                id="dm_colorSchemesContainer"
                                class="d-flex flex-wrap justify-content-center"
                            >
                                <button
                                    class="_dm-colorSchemes _dm-box-xs _dm-bg-gray"
                                    type="button"
                                    data-color="gray"
                                ></button>
                                <button
                                    class="_dm-colorSchemes _dm-box-xs _dm-bg-navy"
                                    type="button"
                                    data-color="navy"
                                ></button>
                                <button
                                    class="_dm-colorSchemes _dm-box-xs _dm-bg-ocean"
                                    type="button"
                                    data-color="ocean"
                                ></button>
                                <button
                                    class="_dm-colorSchemes _dm-box-xs _dm-bg-lime"
                                    type="button"
                                    data-color="lime"
                                ></button>

                                <button
                                    class="_dm-colorSchemes _dm-box-xs _dm-bg-violet"
                                    type="button"
                                    data-color="violet"
                                ></button>
                                <button
                                    class="_dm-colorSchemes _dm-box-xs _dm-bg-orange"
                                    type="button"
                                    data-color="orange"
                                ></button>
                                <button
                                    class="_dm-colorSchemes _dm-box-xs _dm-bg-teal"
                                    type="button"
                                    data-color="teal"
                                ></button>
                                <button
                                    class="_dm-colorSchemes _dm-box-xs _dm-bg-corn"
                                    type="button"
                                    data-color="corn"
                                ></button>

                                <button
                                    class="_dm-colorSchemes _dm-box-xs _dm-bg-cherry"
                                    type="button"
                                    data-color="cherry"
                                ></button>
                                <button
                                    class="_dm-colorSchemes _dm-box-xs _dm-bg-coffee"
                                    type="button"
                                    data-color="coffee"
                                ></button>
                                <button
                                    class="_dm-colorSchemes _dm-box-xs _dm-bg-pear"
                                    type="button"
                                    data-color="pear"
                                ></button>
                                <button
                                    class="_dm-colorSchemes _dm-box-xs _dm-bg-night"
                                    type="button"
                                    data-color="night"
                                ></button>
                            </div>
                        </div>
                    </div>

                    <div id="dm_colorModeContainer">
                        <div class="row text-center mb-2">
                            <!-- Expanded Header -->
                            <div class="col-md-4">
                                <h6 class="m-0">Expanded Header</h6>
                                <div class="_dm-colorShcemesMode">
                                    <!-- Scheme Button -->
                                    <button
                                        type="button"
                                        class="_dm-colorModeBtn btn p-1 shadow-none"
                                        data-color-mode="tm--expanded-hd"
                                    >
                                        <img
                                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/color-schemes/expanded-header.png"
                                            alt="color scheme illusttration"
                                            loading="lazy"
                                        />
                                    </button>
                                </div>
                            </div>

                            <!-- Fair Header -->
                            <div class="col-md-4">
                                <h6 class="m-0">Fair Header</h6>
                                <div class="_dm-colorShcemesMode">
                                    <!-- Scheme Button -->
                                    <button
                                        type="button"
                                        class="_dm-colorModeBtn btn p-1 shadow-none"
                                        data-color-mode="tm--fair-hd"
                                    >
                                        <img
                                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/color-schemes/fair-header.png"
                                            alt="color scheme illusttration"
                                            loading="lazy"
                                        />
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h6 class="m-0">Full Header</h6>

                                <div class="_dm-colorShcemesMode">
                                    <!-- Scheme Button -->
                                    <button
                                        type="button"
                                        class="_dm-colorModeBtn btn p-1 shadow-none"
                                        data-color-mode="tm--full-hd"
                                    >
                                        <img
                                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/color-schemes/full-header.png"
                                            alt="color scheme illusttration"
                                            loading="lazy"
                                        />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row text-center mb-2">
                            <div class="col-md-4">
                                <h6 class="m-0">Primary Nav</h6>

                                <div class="_dm-colorShcemesMode">
                                    <!-- Scheme Button -->
                                    <button
                                        type="button"
                                        class="_dm-colorModeBtn btn p-1 shadow-none"
                                        data-color-mode="tm--primary-mn"
                                    >
                                        <img
                                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/color-schemes/navigation.png"
                                            alt="color scheme illusttration"
                                            loading="lazy"
                                        />
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h6 class="m-0">Brand</h6>

                                <div class="_dm-colorShcemesMode">
                                    <!-- Scheme Button -->
                                    <button
                                        type="button"
                                        class="_dm-colorModeBtn btn p-1 shadow-none"
                                        data-color-mode="tm--primary-brand"
                                    >
                                        <img
                                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/color-schemes/brand.png"
                                            alt="color scheme illusttration"
                                            loading="lazy"
                                        />
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <h6 class="m-0">Tall Header</h6>
                                <div class="_dm-colorShcemesMode">
                                    <!-- Scheme Button -->
                                    <button
                                        type="button"
                                        class="_dm-colorModeBtn btn p-1 shadow-none"
                                        data-color-mode="tm--tall-hd"
                                    >
                                        <img
                                            src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/img/color-schemes/tall-header.png"
                                            alt="color scheme illusttration"
                                            loading="lazy"
                                        />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3">
                        <h5 class="fw-bold mt-2">Miscellaneous</h5>

                        <div class="d-flex gap-3 my-3">
                            <label
                                for="_dm-fontSizeRange"
                                class="form-label flex-shrink-0 mb-0"
                            >Root Font sizes</label
                            >
                            <div class="position-relative flex-fill">
                                <input
                                    type="range"
                                    class="form-range"
                                    min="9"
                                    max="19"
                                    step="1"
                                    value="16"
                                    id="_dm-fontSizeRange"
                                />
                                <output
                                    id="_dm-fontSizeValue"
                                    class="range-bubble"
                                ></output>
                            </div>
                        </div>

                        <h5 class="fw-bold mt-4">Scrollbars</h5>
                        <p class="mb-2">
                            Hides native scrollbars and creates custom styleable overlay
                            scrollbars.
                        </p>
                        <div class="row">
                            <div class="col-5">
                                <!-- OPTION : Apply the OverlayScrollBar to the body. -->
                                <div class="d-flex align-items-center pt-1 mb-2">
                                    <label
                                        class="form-check-label flex-fill"
                                        for="_dm-bodyScrollbarCheckbox"
                                    >Body scrollbar</label
                                    >
                                    <div class="form-check form-switch">
                                        <input
                                            id="_dm-bodyScrollbarCheckbox"
                                            class="form-check-input ms-0"
                                            type="checkbox"
                                            autocomplete="off"
                                        />
                                    </div>
                                </div>

                                <!-- OPTION : Apply the OverlayScrollBar to content containing class .scrollable-content. -->
                                <div class="d-flex align-items-center pt-1 mb-2">
                                    <label
                                        class="form-check-label flex-fill"
                                        for="_dm-sidebarsScrollbarCheckbox"
                                    >Navigation and Sidebar</label
                                    >
                                    <div class="form-check form-switch">
                                        <input
                                            id="_dm-sidebarsScrollbarCheckbox"
                                            class="form-check-input ms-0"
                                            type="checkbox"
                                            autocomplete="off"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="alert alert-warning mb-0" role="alert">
                                    Please consider the performance impact of using any
                                    scrollbar plugin.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- END - SETTINGS CONTAINER [ DEMO ] -->

<!-- OFFCANVAS [ DEMO ] -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<div id="_dm-offcanvas" class="offcanvas" tabindex="-1">
    <!-- Offcanvas header -->
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Offcanvas Header</h5>
        <button
            type="button"
            class="btn-close btn-lg text-reset"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>
    </div>

    <!-- Offcanvas content -->
    <div class="offcanvas-body">
        <h5>Content Here</h5>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente eos
            nihil earum aliquam quod in dolor, aspernatur obcaecati et at. Dicta,
            ipsum aut, fugit nam dolore porro non est totam sapiente animi
            recusandae obcaecati dolorum, rem ullam cumque. Illum quidem
            reiciendis autem neque excepturi odit est accusantium, facilis
            provident molestias, dicta obcaecati itaque ducimus fuga iure in
            distinctio voluptate nesciunt dignissimos rem error a. Expedita
            officiis nam dolore dolores ea. Soluta repellendus delectus culpa quo.
            Ea tenetur impedit error quod exercitationem ut ad provident quisquam
            omnis! Nostrum quasi ex delectus vero, facilis aut recusandae deleniti
            beatae. Qui velit commodi inventore.
        </p>
    </div>
</div>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- END - OFFCANVAS [ DEMO ] -->

<!-- JAVASCRIPTS -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- Bootstrap JS [ OPTIONAL ] -->
<script src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/js/bootstrap.min.705accd2201a27b32a1b95615e20fbb58fc9f3200388517b3a66f322ad955857.js"></script>
<!-- JS [ OPTIONAL ] -->
<script src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/js/nifty.min.b960437305df20c97b96bfb28e62b7d655ad70041fcfed38fae70d11012b2b58.js"></script>

<!-- Plugin scripts [ OPTIONAL ] -->
<script src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/pages/dashboard-1.min.b651fbd1a6f6a43e11bc01617b4481ab0edc4ba4582106c466d7ae2a9a9ac178.js"></script>
<script src="https://payusinginvoice.com/crm-development/assets/js/jquery.min.js"></script>
<script
    id="_dm-jsOverlayScrollbars"
    src="https://payusinginvoice.com/crm-development/assets/themes/nifty/assets/vendors/overlayscrollbars/overlayscrollbars.browser.es6.min.js"
></script>
<!-- New -->

<link
    href="https://payusinginvoice.com/crm-development/assets/css/datatable/new/datatables.min.css"
    rel="stylesheet"
/>

<script src="https://payusinginvoice.com/crm-development/assets/js/plugins/datatable/new/pdfmake.min.js"></script>

<script src="https://payusinginvoice.com/crm-development/assets/js/plugins/datatable/new/vfs_fonts.js"></script>

<script src="https://payusinginvoice.com/crm-development/assets/js/plugins/datatable/new/datatables.min.js"></script>

<script src="https://payusinginvoice.com/crm-development/assets/js/plugins/datatable/new/dataTables.select.js"></script>
<script src="https://payusinginvoice.com/crm-development/assets/js/plugins/datatable/new/select.dataTables.js"></script>

<!-- New -->

<!-- SweetAlert2 -->
<script src="https://payusinginvoice.com/crm-development/assets/js/plugins/sweetalert2@11.js"></script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script src="https://cdn.jsdelivr.net/npm/shepherd.js/dist/js/shepherd.min.js"></script>

<script src="https://payusinginvoice.com/crm-development/assets/js/intro-tour.js"></script>
<script src="https://payusinginvoice.com/crm-development/assets/js/tour.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<!-- Jquery UI -->

<!-- End Jquery UI -->

<script>
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
        var options = {
            damping: "0.5",
        };
        Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }
</script>

<!-- Scroll Top -->
<script>
    $(".scroll-page").on("click", function () {
        document
            .getElementById("root")
            .scrollIntoView({ behavior: "smooth", block: "start" });
    });
</script>
<!-- Scroll Top -->

<!-- Toaster -->
<script src="https://payusinginvoice.com/crm-development/assets/toaster/js/toastr.min.js"></script>

<script>
    // Toastr options
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: false,
        progressBar: true,
        positionClass: "toast-top-right",
        preventDuplicates: true,
        preventOpenDuplicates: true,
        onclick: null,
        showDuration: "500",
        hideDuration: "1000",
        timeOut: "3000", // 5 seconds
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };

    // Display error messages (multiple)

    const userSettings = {
        layouts: {
            fluidLayout: true,
            boxedLayout: false,
            centeredLayout: false,
        },
        transitions: { transitionTiming: "out-quart" },
        header: { stickyHeader: true },
        navigation: {
            stickyNav: true,
            profileWidget: true,
            miniNav: false,
            maxiNav: true,
            pushNav: false,
            slideNav: false,
            revealNav: false,
        },
        sidebar: {
            disableBackdrop: false,
            staticPosition: false,
            stuckSidebar: false,
            uniteSidebar: false,
            pinnedSidebar: false,
        },
        colors: {
            themeColor: false,
            colorScheme: "navy",
            colorSchemeMode: "tm--primary-mn",
        },
        font: { fontSize: 16 },
        scrollbars: { bodyScrollbar: false, sidebarScrollbar: false },
    };
    document.addEventListener("DOMContentLoaded", function () {
        const settings = userSettings;
        function stringToBoolean(value) {
            if (typeof value === "string") {
                return value.toLowerCase() === "true";
            }
            return Boolean(value);
        }
        function isElementInDesiredState(element, desiredState) {
            if (element.type === "checkbox" || element.type === "radio") {
                return element.checked === desiredState;
            }
            return false;
        }
        if (settings.layouts) {
            const fluidLayoutRadio = document.getElementById(
                "_dm-fluidLayoutRadio"
            );
            if (
                stringToBoolean(settings.layouts.fluidLayout) &&
                !isElementInDesiredState(fluidLayoutRadio, true)
            ) {
                fluidLayoutRadio.click();
            }

            const boxedLayoutRadio = document.getElementById(
                "_dm-boxedLayoutRadio"
            );
            if (
                stringToBoolean(settings.layouts.boxedLayout) &&
                !isElementInDesiredState(boxedLayoutRadio, true)
            ) {
                boxedLayoutRadio.click();
            }

            const centeredLayoutRadio = document.getElementById(
                "_dm-centeredLayoutRadio"
            );
            if (
                stringToBoolean(settings.layouts.centeredLayout) &&
                !isElementInDesiredState(centeredLayoutRadio, true)
            ) {
                centeredLayoutRadio.click();
            }
        }

        if (settings.transitions) {
            const transitionSelect = document.getElementById(
                "_dm-transitionSelect"
            );
            if (
                transitionSelect.value !== settings.transitions.transitionTiming
            ) {
                transitionSelect.value = settings.transitions.transitionTiming;
                const changeEvent = new Event("change", { bubbles: true });
                transitionSelect.dispatchEvent(changeEvent);
            }
        }

        if (settings.header) {
            const stickyHeaderCheckbox = document.getElementById(
                "_dm-stickyHeaderCheckbox"
            );
            if (
                stringToBoolean(settings.header.stickyHeader) &&
                !isElementInDesiredState(stickyHeaderCheckbox, true)
            ) {
                stickyHeaderCheckbox.click();
            }
        }

        if (settings.navigation) {
            const stickyNavCheckbox = document.getElementById(
                "_dm-stickyNavCheckbox"
            );
            if (
                stringToBoolean(settings.navigation.stickyNav) &&
                !isElementInDesiredState(stickyNavCheckbox, true)
            ) {
                stickyNavCheckbox.click();
            }

            const profileWidgetCheckbox = document.getElementById(
                "_dm-profileWidgetCheckbox"
            );
            if (
                stringToBoolean(settings.navigation.profileWidget) &&
                !isElementInDesiredState(profileWidgetCheckbox, true)
            ) {
                profileWidgetCheckbox.click();
            }

            const miniNavRadio = document.getElementById("_dm-miniNavRadio");
            if (
                stringToBoolean(settings.navigation.miniNav) &&
                !isElementInDesiredState(miniNavRadio, true)
            ) {
                miniNavRadio.click();
            }

            const maxiNavRadio = document.getElementById("_dm-maxiNavRadio");
            if (
                stringToBoolean(settings.navigation.maxiNav) &&
                !isElementInDesiredState(maxiNavRadio, true)
            ) {
                maxiNavRadio.click();
            }

            const pushNavRadio = document.getElementById("_dm-pushNavRadio");
            if (
                stringToBoolean(settings.navigation.pushNav) &&
                !isElementInDesiredState(pushNavRadio, true)
            ) {
                pushNavRadio.click();
            }

            const slideNavRadio = document.getElementById("_dm-slideNavRadio");
            if (
                stringToBoolean(settings.navigation.slideNav) &&
                !isElementInDesiredState(slideNavRadio, true)
            ) {
                slideNavRadio.click();
            }

            const revealNavRadio = document.getElementById("_dm-revealNavRadio");
            if (
                stringToBoolean(settings.navigation.revealNav) &&
                !isElementInDesiredState(revealNavRadio, true)
            ) {
                revealNavRadio.click();
            }
        }

        if (settings.sidebar) {
            const disableBackdropCheckbox = document.getElementById(
                "_dm-disableBackdropCheckbox"
            );
            if (
                stringToBoolean(settings.sidebar.disableBackdrop) &&
                !isElementInDesiredState(disableBackdropCheckbox, true)
            ) {
                disableBackdropCheckbox.click();
            }

            const staticSidebarCheckbox = document.getElementById(
                "_dm-staticSidebarCheckbox"
            );
            if (
                stringToBoolean(settings.sidebar.staticPosition) &&
                !isElementInDesiredState(staticSidebarCheckbox, true)
            ) {
                staticSidebarCheckbox.click();
            }

            const stuckSidebarCheckbox = document.getElementById(
                "_dm-stuckSidebarCheckbox"
            );
            if (
                stringToBoolean(settings.sidebar.stuckSidebar) &&
                !isElementInDesiredState(stuckSidebarCheckbox, true)
            ) {
                stuckSidebarCheckbox.click();
            }

            const uniteSidebarCheckbox = document.getElementById(
                "_dm-uniteSidebarCheckbox"
            );
            if (
                stringToBoolean(settings.sidebar.uniteSidebar) &&
                !isElementInDesiredState(uniteSidebarCheckbox, true)
            ) {
                uniteSidebarCheckbox.click();
            }

            const pinnedSidebarCheckbox = document.getElementById(
                "_dm-pinnedSidebarCheckbox"
            );
            if (
                stringToBoolean(settings.sidebar.pinnedSidebar) &&
                !isElementInDesiredState(pinnedSidebarCheckbox, true)
            ) {
                pinnedSidebarCheckbox.click();
            }
        }

        if (settings.colors) {
            const themeToggler = document.getElementById("settingsThemeToggler");
            if (
                stringToBoolean(settings.colors.themeColor) &&
                !isElementInDesiredState(themeToggler, true)
            ) {
                themeToggler.click();
            }

            const colorSchemeButton = document.querySelector(
                `._dm-colorSchemes[data-color="${settings.colors.colorScheme}"]`
            );
            if (
                colorSchemeButton &&
                !colorSchemeButton.classList.contains("active")
            ) {
                colorSchemeButton.click();
            }

            const colorSchemeModeButton = document.querySelector(
                `._dm-colorModeBtn[data-color-mode="${settings.colors.colorSchemeMode}"]`
            );
            if (
                colorSchemeModeButton &&
                !colorSchemeModeButton.classList.contains("active")
            ) {
                colorSchemeModeButton.click();
            }
        }

        if (settings.font) {
            const fontSizeRange = document.getElementById("_dm-fontSizeRange");
            const fontSizeValue = document.getElementById("_dm-fontSizeValue");

            if (fontSizeRange.value !== settings.font.fontSize) {
                fontSizeRange.value = settings.font.fontSize;
                const inputEvent = new Event("input", { bubbles: true });
                fontSizeRange.dispatchEvent(inputEvent);
                fontSizeValue.textContent = settings.font.fontSize;
            }
        }

        setTimeout(function () {
            if (settings.scrollbars) {
                const bodyScrollbarCheckbox = document.getElementById(
                    "_dm-bodyScrollbarCheckbox"
                );
                if (
                    stringToBoolean(settings.scrollbars.bodyScrollbar) &&
                    !isElementInDesiredState(bodyScrollbarCheckbox, true)
                ) {
                    bodyScrollbarCheckbox.click();
                }

                const sidebarScrollbarCheckbox = document.getElementById(
                    "_dm-sidebarsScrollbarCheckbox"
                );
                if (
                    stringToBoolean(settings.scrollbars.sidebarScrollbar) &&
                    !isElementInDesiredState(sidebarScrollbarCheckbox, true)
                ) {
                    sidebarScrollbarCheckbox.click();
                }
            }
        }, 1000);
    });
    document
        .getElementById("settingsForm")
        .addEventListener("submit", function (e) {
            e.preventDefault();

            const settings = {
                layouts: {
                    fluidLayout: document.getElementById("_dm-fluidLayoutRadio")
                        .checked,
                    boxedLayout: document.getElementById("_dm-boxedLayoutRadio")
                        .checked,
                    centeredLayout: document.getElementById("_dm-centeredLayoutRadio")
                        .checked,
                },
                transitions: {
                    transitionTiming: document.getElementById("_dm-transitionSelect")
                        .value,
                },
                header: {
                    stickyHeader: document.getElementById("_dm-stickyHeaderCheckbox")
                        .checked,
                },
                navigation: {
                    stickyNav: document.getElementById("_dm-stickyNavCheckbox")
                        .checked,
                    profileWidget: document.getElementById(
                        "_dm-profileWidgetCheckbox"
                    ).checked,
                    miniNav: document.getElementById("_dm-miniNavRadio").checked,
                    maxiNav: document.getElementById("_dm-maxiNavRadio").checked,
                    pushNav: document.getElementById("_dm-pushNavRadio").checked,
                    slideNav: document.getElementById("_dm-slideNavRadio").checked,
                    revealNav: document.getElementById("_dm-revealNavRadio").checked,
                },
                sidebar: {
                    disableBackdrop: document.getElementById(
                        "_dm-disableBackdropCheckbox"
                    ).checked,
                    staticPosition: document.getElementById(
                        "_dm-staticSidebarCheckbox"
                    ).checked,
                    stuckSidebar: document.getElementById("_dm-stuckSidebarCheckbox")
                        .checked,
                    uniteSidebar: document.getElementById("_dm-uniteSidebarCheckbox")
                        .checked,
                    pinnedSidebar: document.getElementById(
                        "_dm-pinnedSidebarCheckbox"
                    ).checked,
                },
                colors: {
                    themeColor: document.getElementById("settingsThemeToggler")
                        .checked,
                    colorScheme: document.querySelector("._dm-colorSchemes.active")
                        ?.dataset.color,
                    colorSchemeMode: document.querySelector(
                        "._dm-colorModeBtn.active"
                    )?.dataset.colorMode,
                },
                font: {
                    fontSize: document.getElementById("_dm-fontSizeRange").value,
                },
                scrollbars: {
                    bodyScrollbar: document.getElementById(
                        "_dm-bodyScrollbarCheckbox"
                    ).checked,
                    sidebarScrollbar: document.getElementById(
                        "_dm-sidebarsScrollbarCheckbox"
                    ).checked,
                },
            };
            const formData = new FormData();
            flattenObject(settings, "settings", formData);
            AjaxRequestPromise(
                `https://payusinginvoice.com/crm-development/admin/save-settings`,
                formData,
                "POST",
                { useToastr: true }
            )
                .then((response) => {
                    console.log("Settings updated successfully:", response);
                })
                .catch((error) =>
                    console.error(
                        "An error occurred while updating the record.",
                        error
                    )
                );
        });
    function flattenObject(obj, parentKey = "", formData = new FormData()) {
        for (let key in obj) {
            if (obj.hasOwnProperty(key)) {
                const nestedKey = parentKey ? `${parentKey}[${key}]` : key;
                if (typeof obj[key] === "object" && !(obj[key] instanceof File)) {
                    flattenObject(obj[key], nestedKey, formData); // Recursively flatten nested objects
                } else {
                    formData.append(nestedKey, obj[key]); // Append primitive values to FormData
                }
            }
        }
        return formData;
    }
    $(function () {
        // $('._dm-settings-container__content .enabled').click();
        // $("#_dm-stickyHeaderCheckbox").prop("checked") || $("#_dm-stickyHeaderCheckbox").click();
        // $("#dm_colorModeContainer ._dm-colorModeBtn[data-color-mode='tm--primary-mn']:not(.active)").click();
    });

    /** Loader Start */
    const loaders = [
        "sk-plane",
        "sk-chase",
        "sk-bounce",
        "sk-wave",
        "sk-pulse",
        "sk-flow",
        "sk-swing",
        "sk-circle",
        "sk-circle-fade",
        "sk-grid",
        "sk-fold",
        "sk-wander",
    ];
    let randomLoader;

    function randomLoaderFunction() {
        return loaders[Math.floor(Math.random() * loaders.length)];
    }

    randomLoader = randomLoaderFunction();

    $(`#loader`).show();
    $(`.${randomLoader}`).removeClass("load-spinner");
    $(document).ready(function () {
        if (false) {
            setTimeout(() => {
                $("#loader").hide();
                $(`.${randomLoader}`).toggleClass("load-spinner");
            }, 1000);
        } else {
            $(`#loader`).hide();
            $(`.${randomLoader}`).toggleClass("load-spinner");
        }

        // $('#testTable').DataTable();
    });
    /** Loader End */

    $(document).ajaxStart(function () {
        $(`#loader`).show();
        $(`#loader`).addClass("loader-light");
        $(`.${randomLoader}`).removeClass("load-spinner");
    });

    $(document).ajaxStop(function () {
        $(`#loader`).hide();
        $(`#loader`).removeClass("loader-light");
        $(`.${randomLoader}`).addClass("load-spinner");
    });

    var error = false;
    function refreshCsrfToken() {
        return $.get(
            "https://payusinginvoice.com/crm-development/csrf-token"
        ).then((response) => {
            $('meta[name="csrf-token"]').attr("content", response.token);
        });
    }
    $(document).ready(function () {
        /** Ajax Error Handle Start */
        $.ajaxSetup({
            error: function (jqXHR, textStatus, errorThrown) {
                error = true;
                if (jqXHR.status === 429) {
                    Swal.fire({
                        title: "Too Many Requests",
                        text: "You are making requests too frequently. Please slow down and try again later.",
                        icon: "warning",
                        confirmButtonText: "OK",
                    });
                } else if (jqXHR.status === 500) {
                    Swal.fire({
                        title: "Server Error",
                        text: "An unexpected error occurred on the server. Please try again later.",
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                } else if (jqXHR.status === 404) {
                    Swal.fire({
                        title: "Not Found",
                        text: "The requested resource could not be found.",
                        icon: "info",
                        confirmButtonText: "OK",
                    });
                } else if (jqXHR.status === 403) {
                    Swal.fire({
                        title: "Forbidden",
                        text:
                            jqXHR.responseJSON.error ??
                            "You do not have permission to perform this action.",
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                } else if (jqXHR.status === 0) {
                    Swal.fire({
                        title: "Network Error",
                        text: "It seems you are offline or there was a network issue.",
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                } else if (jqXHR.status === 422) {
                    // Swal.fire({
                    //     title: 'Error',
                    //     text: `An error occurred: ${jqXHR.status} - ${jqXHR.statusText}`,
                    //     icon: 'error',
                    //     confirmButtonText: 'OK'
                    // });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: `An error occurred: ${jqXHR.status} - ${jqXHR.statusText}`,
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                }
            },
        });
    });
    /** Ajax Error Handle End */

    let currentRequest = null;
    $(document).ajaxSend(function (event, jqXHR, settings) {
        if (currentRequest) {
            currentRequest.abort();
        }
        currentRequest = jqXHR;
    });
    $(document).ajaxComplete(function (event, jqXHR, settings) {
        currentRequest = null;
        error = false;
    });
    $(document).ajaxError(function myErrorHandler(
        event,
        jqXHR,
        ajaxOptions,
        thrownError
    ) {
        if (
            jqXHR.status === 422 ||
            (jqXHR.responseJSON && jqXHR.responseJSON.errors)
        ) {
            return;
        }
        resetFields();

        const formContainer = $(".form-container");
        if (formContainer.length > 0) {
            formContainer.removeClass("open");
        }
        const manageForm = $(".custom-form form");
        if (manageForm.length > 0) {
            manageForm[0].reset();
            manageForm.removeData("id");
        }
        if (jqXHR.status === 429) {
            Swal.fire({
                title: "Too Many Requests",
                text: "You are making requests too frequently. Please slow down and try again later.",
                icon: "warning",
                confirmButtonText: "OK",
            });
        } else if (jqXHR.status === 500) {
            Swal.fire({
                title: "Server Error",
                text: "An unexpected error occurred on the server. Please try again later.",
                icon: "error",
                confirmButtonText: "OK",
            });
        } else if (jqXHR.status === 404) {
            Swal.fire({
                title: "Not Found",
                text: "The requested resource could not be found.",
                icon: "info",
                confirmButtonText: "OK",
            });
        } else if (jqXHR.status === 403) {
            Swal.fire({
                title: "Forbidden",
                text:
                    jqXHR.responseJSON.error ??
                    "You do not have permission to perform this action.",
                icon: "error",
                confirmButtonText: "OK",
            });
        } else if (jqXHR.status === 0) {
            Swal.fire({
                title: "Network Error",
                text: "It seems you are offline or there was a network issue.",
                icon: "error",
                confirmButtonText: "OK",
            });
        } else if (jqXHR.status === 401) {
            Swal.fire({
                title: "Unauthorized",
                text: "Your session has expired or you are not authorized to perform this action. Please log in again.",
                icon: "warning",
                confirmButtonText: "Login",
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `https://payusinginvoice.com/crm-development/admin/login`;
                }
            });
        } else if (jqXHR.status === 403) {
            Swal.fire({
                title: "Forbidden",
                text: "You do not have permission to perform this action.",
                icon: "error",
                confirmButtonText: "OK",
            });
        } else {
            Swal.fire({
                title: "Error",
                text: `An error occurred: ${jqXHR.status} - ${jqXHR.statusText}`,
                icon: "error",
                confirmButtonText: "OK",
            });
        }
    });

    function AjaxDeleteRequestPromise(
        url,
        data,
        method = "DELETE",
        options = {}
    ) {
        method = method.toUpperCase();
        options = {
            useDeleteSwal: false /* * Show SweetAlert confirmation for delete */,
            deleteSwalMessage: "This action cannot be undone.",
            ...options,
        };
        if (options.useDeleteSwal && method === "DELETE") {
            return Swal.fire({
                icon: "warning",
                title: "Are you sure?",
                text: options.deleteSwalMessage,
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                customClass: {
                    cancelButton: "swal2-left-button",
                    confirmButton: "swal2-right-button",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    return AjaxRequestPromise(url, data, method, options).then(
                        (response) => {
                            return { isConfirmed: true, response: response };
                        }
                    );
                }
                return Promise.reject({
                    isConfirmed: false,
                    message: "Phew! The delete action was saved.",
                });
            });
        } else {
            return AjaxRequestPromise(url, data, method, options);
        }
    }

    function AjaxRequestPromise(url, data, method = "GET", options = {}) {
        method = method.toUpperCase();
        options = {
            useReload: false /* * Reload the page after success */,
            useRedirect: false /* * Redirect to another page after success */,
            redirectLocation: "" /* * Location to redirect to */,
            useSwal: false /* * Show SweetAlert notification */,
            title: "Success" /* * Title for SweetAlert */,
            showConfirmButton: true /* * Display confirm button in SweetAlert */,
            confirmButtonText: "OK" /* * Confirm button text in SweetAlert */,
            cancelButtonText: "Reload" /* * Cancel button text in SweetAlert */,
            useSwalReload: false /* * Reload the page if SweetAlert is confirmed */,
            icon: "success" /* * SweetAlert & toastr icon: 'success', 'error', 'warning', 'info' */,
            useToastr: false /* * Show toastr notification */,
            message:
                "Request was successful." /* * Message text for toastr & SweetAlert*/,
            useToastrReload: false /* * Reload the page after toastr notification */,
            ...options /* * Use provided options if any */,
        };
        if (method === "GET" && data && Object.keys(data).length > 0) {
            const queryString = $.param(data);
            url = `${url}?${queryString}`;
        }
        return new Promise((resolve, reject) => {
            $("form").find(".is-invalid").removeClass("is-invalid");
            $("form").find(".text-danger").fadeOut();
            $.ajax({
                url: url,
                type: method,
                data: method === "GET" ? null : data,
                processData: method === "GET",
                contentType:
                    method === "GET" ? "application/x-www-form-urlencoded" : false,
                headers:
                    method === "GET"
                        ? {}
                        : {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                beforeSend: function () {
                    // $('#loading').show();
                },
                success: function (response) {
                    if (
                        typeof response === "string" &&
                        response.startsWith("<!DOCTYPE html>")
                    ) {
                        toastr["error"](
                            "It looks like you've been disconnected. Please reload the page."
                        );
                        return reject(error);
                    }
                    const message =
                        response.message ||
                        response.success ||
                        options.message ||
                        "Request was successful.";

                    if (options.useSwal) {
                        Swal.fire({
                            icon: options.icon,
                            title: options.title,
                            text: message,
                            confirmButtonText: options.showConfirmButton
                                ? options.confirmButtonText
                                : null,
                            showConfirmButton: options.showConfirmButton,
                            cancelButtonText: options.useSwalReload
                                ? options.cancelButtonText
                                : null,
                            showCancelButton: options.useSwalReload,
                            focusConfirm: false,
                            customClass: {
                                cancelButton: "swal2-left-button",
                                confirmButton: "swal2-right-button",
                            },
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (options.useRedirect && options.redirectLocation) {
                                    window.location.href = options.redirectLocation;
                                }
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                if (options.useSwalReload) {
                                    location.reload();
                                }
                            }
                        });
                    }

                    /** Toastr notification */
                    if (options.useToastr) {
                        toastr[options.icon](message);
                        if (options.useToastrReload) {
                            setTimeout(() => location.reload(), 5000);
                        } else if (options.useRedirect && options.redirectLocation) {
                            setTimeout(
                                () => (window.location.href = options.redirectLocation),
                                5000
                            );
                        }
                    }

                    /** Handle redirection or page reload */
                    if (!options.useSwal && !options.useToastr) {
                        if (options.useReload) {
                            location.reload();
                        } else if (options.useRedirect && options.redirectLocation) {
                            window.location.href = options.redirectLocation;
                        }
                    }
                    resolve(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    const response = jqXHR.responseJSON;
                    const message =
                        response?.message ||
                        response?.error ||
                        errorThrown ||
                        "Something went wrong. Please try again.";
                    if (
                        jqXHR.status === 419 ||
                        message.includes("CSRF token mismatch")
                    ) {
                        console.log("Page Expire. Please try again.");
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                        return refreshCsrfToken()
                            .then(() => {
                                return AjaxRequestPromise(url, data, method, options);
                            })
                            .catch(() => {
                                console.log(
                                    "Failed to refresh CSRF token. Please try again."
                                );
                                reject(textStatus);
                            });
                    }
                    if (jqXHR.status === 422 && response && response.errors) {
                        const isUpdate = url.includes("update");

                        if (response.errors && Array.isArray(response.errors)) {
                            let errorMessages = "";
                            response.errors.forEach((message) => {
                                errorMessages += `<p>${message}</p>`;
                            });
                            $(".error-messages")
                                .html(
                                    `<div class="alert alert-danger text-danger">${errorMessages}</div>`
                                )
                                .show();
                            setTimeout(function () {
                                $(".error-messages").fadeOut();
                            }, 5000);
                        } else if (response.errors) {
                            let firstError = false;
                            for (let field in response.errors) {
                                let normalizedField = field.replace(/\./g, "_");
                                const fieldSelector =
                                    $(
                                        isUpdate
                                            ? `#edit_${normalizedField}`
                                            : `#edit_${normalizedField}`
                                    ).length > 0
                                        ? `#edit_${normalizedField}`
                                        : `#${normalizedField}`;
                                if (!firstError) {
                                    firstError = true;
                                    document.getElementById(normalizedField).scrollIntoView({
                                        behavior: "smooth",
                                        block: "center",
                                    });
                                }

                                const errorMessages = response.errors[field];

                                $(fieldSelector).next(".text-danger").remove();

                                if (Array.isArray(errorMessages)) {
                                    errorMessages.forEach((message) => {
                                        $(fieldSelector).after(
                                            `<span class="text-danger">${message}</span>`
                                        );
                                    });
                                } else {
                                    $(fieldSelector).after(
                                        `<span class="text-danger">${errorMessages}</span>`
                                    );
                                }

                                $(fieldSelector).addClass("is-invalid");

                                setTimeout(function () {
                                    $(fieldSelector).removeClass("is-invalid");
                                    $(fieldSelector).siblings(".text-danger").fadeOut();
                                }, 10000);
                            }
                        }
                    }
                    /** Show generic error with SweetAlert */
                    if (options.useSwal) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: message,
                            confirmButtonText: options.showConfirmButton
                                ? options.confirmButtonText
                                : null,
                            showConfirmButton: options.showConfirmButton,
                            cancelButtonText: options.useSwalReload
                                ? options.cancelButtonText
                                : null,
                            showCancelButton: options.useSwalReload,
                            focusConfirm: false,
                            customClass: {
                                cancelButton: "swal2-left-button",
                                confirmButton: "swal2-right-button",
                            },
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (options.useRedirect && options.redirectLocation) {
                                    window.location.href = options.redirectLocation;
                                }
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                if (options.useSwalReload) {
                                    location.reload();
                                }
                            }
                        });
                    }
                    /** Show generic error with toastr */
                    if (options.useToastr) {
                        if (jqXHR.status !== 422 || !jqXHR.responseJSON.errors) {
                            toastr["error"](message);
                        }
                        if (options.useToastrReload) {
                            setTimeout(() => location.reload(), 5000);
                        } else if (options.useRedirect && options.redirectLocation) {
                            setTimeout(
                                () => (window.location.href = options.redirectLocation),
                                5000
                            );
                        }
                    }

                    reject(textStatus);
                },
                complete: function (jqXHR, textStatus) {
                    if (jqXHR.status !== 422 || !jqXHR.responseJSON.errors) {
                        if (url.includes("store") || url.includes("update")) {
                            $(".modal").modal("hide");
                            $(".form-container").removeClass("open");
                            resetFields();
                            const manageForm = $(".custom-form form");
                            if (manageForm.length > 0) {
                                manageForm[0].reset();
                            }
                        }
                    }
                },
            });
        });
    }

    function generateRandomPassword(length) {
        const upperCase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        const lowerCase = "abcdefghijklmnopqrstuvwxyz";
        const numbers = "0123456789";
        const symbols = "!@#$%^&*()";
        const allChars = upperCase + lowerCase + numbers + symbols;
        let password = "";
        for (let i = 0; i < 2; i++) {
            password += upperCase.charAt(
                Math.floor(Math.random() * upperCase.length)
            );
            password += lowerCase.charAt(
                Math.floor(Math.random() * lowerCase.length)
            );
            password += numbers.charAt(
                Math.floor(Math.random() * numbers.length)
            );
            password += symbols.charAt(
                Math.floor(Math.random() * symbols.length)
            );
        }
        for (let i = password.length; i < length; i++) {
            password += allChars.charAt(
                Math.floor(Math.random() * allChars.length)
            );
        }
        password = password
            .split("")
            .sort(() => 0.5 - Math.random())
            .join("");
        return password;
    }

    window.resetHooks = [];
    function resetFields() {
        $(".second-fields").fadeOut();
        $(".first-fields").fadeIn();
        $(".first-field-inputs").prop("required", true);
        $(".second-field-inputs").prop("required", false);
        $(".image-div").css("display", "none");
        $(".extra-dynamic-fields").empty();
        $(".unique-select-2").val("").trigger("change");
        let placeholderMsg = $(".extra-dynamic-fields-to-show")?.html()?.trim();
        if (placeholderMsg) {
            $(".extra-dynamic-fields").html(placeholderMsg);
        }
        window.resetHooks.forEach((hook) => {
            if (typeof hook === "function") {
                hook();
            }
        });
        // $('.first-fields').fadeOut(() => {
        //     $('.second-fields').fadeIn();
        //     $('.second-field-inputs').prop('required', true);
        //     $('.first-field-inputs').prop('required', false);
        // });
    }
    $(document).ready(function () {
        const formContainerClass = document.querySelector(".form-container");
        if (!formContainerClass) {
            return;
        }
        const toggleInputs = () => {
            const isDisabled = formContainerClass.classList.contains("open");
            const searchInputs = document.querySelectorAll(
                'input[type="search"]'
            );
            const selectInputs = document.querySelectorAll(
                ".dt-container select"
            );
            const checkboxInputs = document.querySelectorAll(
                '.dt-container input[type="checkbox"]'
            );
            searchInputs.forEach((input) => (input.disabled = isDisabled));
            selectInputs.forEach((input) => (input.disabled = isDisabled));
            checkboxInputs.forEach((input) => (input.disabled = isDisabled));
        };

        const observer = new MutationObserver(toggleInputs);

        observer.observe(formContainerClass, {
            attributes: true,
            attributeFilter: ["class"],
        });

        toggleInputs();

        const formContainer = $("#formContainer");
        const manageForm = $(".custom-form form");

        let isAjaxRequestInProgress = false;
        $(document)
            .ajaxStart(function () {
                isAjaxRequestInProgress = true;
            })
            .ajaxStop(function () {
                isAjaxRequestInProgress = false;
            })
            .ajaxError(function () {
                error = true;
            });

        if (formContainer.length > 0) {
            openCustomForm(formContainer, manageForm);
            //closeCustomForm(formContainer, manageForm);
        } else {
            // console.warn('#formContainer does not exist.');
        }

        // Function to open and reset the form
        function openCustomForm(formContainer, manageForm) {
            $(".open-form-btn, .editBtn").click(function () {
                manageForm[0].reset();
                manageForm.removeData("id");
                resetFields();
                // Show message if no access
                if ($(this).hasClass("void")) {
                    $(this)
                        .attr("title", "You don't have access to create a record.")
                        .tooltip({ placement: "bottom" })
                        .tooltip("show");
                } else {
                    formContainer.addClass("open");
                    $(".form-body").animate(
                        {
                            scrollTop: $(".form-body").offset().top - 500,
                        },
                        500
                    );
                }
            });
        }
        $(document).on("dblclick", function (event) {
            if (
                (!$(event.target).closest(".form-container").length &&
                    !$(event.target).is(".form-container") &&
                    !$(event.target).closest(".open-form-btn").length &&
                    !$(event.target).is(".editBtn") &&
                    !$(event.target).is(".changePwdBtn") &&
                    !window.getSelection().toString().trim().length > 0) ||
                $(event.target).is(".form-container .close-btn")
            ) {
                closeCustomForm(formContainer, manageForm);
            }
        });

        $(document).on("click", ".form-container .close-btn", function () {
            closeCustomForm(formContainer, manageForm);
        });
        // Function to close the form and reset form fields
        function closeCustomForm(formContainer, manageForm) {
            // Close the form
            formContainer.removeClass("open");
            $(".form-container").removeClass("open");
            resetFields();

            // Reset the form if available
            if (manageForm.length > 0) {
                manageForm[0].reset();
                manageForm.removeData("id");
            }
        }
        $(".tab-item").on("click", function () {
            $(".tab-item").removeClass("active");
            $(".tab-pane").removeClass("active");

            $(this).addClass("active");

            const targetPane = $(this).data("tab");
            $("#" + targetPane).addClass("active");

            let tabId = $(this).attr("data-tab");
            let targetTable = $("#" + tabId).find("table");
            if ($.fn.DataTable.isDataTable(targetTable)) {
                targetTable.DataTable().columns.adjust().draw();
            }
        });
        $(".searchbox").on("submit", function (e) {
            e.preventDefault();
            const searchTerm = $("#header-search-input").val().trim();
            if (searchTerm) {
                const currentUrl =
                    window.location.origin + window.location.pathname;
                window.location.href = `${currentUrl}?search=${searchTerm}`;
                // window.location.href = `${currentUrl}?search=${encodeURIComponent(searchTerm)}`;
            } else {
                window.location.href =
                    window.location.origin + window.location.pathname;
            }
        });
        $(".searchbox__btn").on("click", function () {
            $(".searchbox").submit();
        });

        const params = new URLSearchParams(window.location.search);
        function onAllDataTablesReady(callback) {
            const tables = $.fn.dataTable.tables({ api: true });
            let readyCount = 0;

            if (!tables.length) {
                callback();
                return;
            }

            tables.each(function () {
                const dt = new $.fn.dataTable.Api(this);
                if (dt.settings()[0]._bInitComplete) {
                    readyCount++;
                } else {
                    $(dt.table().node()).on("init.dt", function () {
                        readyCount++;
                        if (readyCount === tables.length) {
                            callback();
                        }
                    });
                }
                if (readyCount === tables.length) {
                    callback();
                }
            });
        }

        setTimeout(function () {
            onAllDataTablesReady(function () {
                const searchId = params.get("ref");
                const searchTerm = params.get("search");

                if (searchId) {
                    $(".editBtn").each(function () {
                        if ($(this).data("id") == searchId) {
                            $(this).click();
                        }
                    });
                }
                if (searchTerm) {
                    $($.fn.dataTable.tables({ visible: true })).each(function () {
                        const dt = $(this).DataTable();
                        dt.search(searchTerm).draw();
                    });
                }
            });
        }, 100);

        function strLimit(string, limit = 100, end = "...") {
            if (!string) return "---";
            return string.length > limit
                ? string.substring(0, limit) + end
                : string;
        }
    });
    !(function () {
        document.currentScript?.remove();
    })();
</script>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- END - LAYOUT [ SCRIPT ] -->
<script>
    /** Edit Note */
    $(document).on("click", ".editNoteModal", function () {
        const id = $(this).data("id");
        const noteText = $(this).data("note"); // Get note from data attribute

        if (!id) {
            Swal.fire("Error!", "Record not found.", "error");
            return;
        }

        // Reset form
        $("#editNoteModalForm")[0].reset();

        // Update form action URL
        $("#editNoteModalForm").attr(
            "action",
            `https://payusinginvoice.com/crm-development/admin/customer/contact/note/update/` +
            id
        );

        $("#note").val(noteText);
    });
</script>

<script>
    $(function () {
        $("#from_email").on("change", function () {
            let selected = $(this).find(":selected");

            $("#from_name").val(selected.data("name"));
            $("#from_company").text("from " + selected.data("company"));
        });
    });
    function toggleCcField(element) {
        document.getElementById("ccField").classList.toggle("d-none");
        element.parentElement.classList.add("d-none");
        if (!document.getElementById("ccField").classList.contains("d-none")) {
            document.querySelector("#ccField input").focus();
        }
    }
    function toggleBccField(element) {
        document.getElementById("bccField").classList.toggle("d-none");
        element.parentElement.classList.add("d-none");
        if (!document.getElementById("bccField").classList.contains("d-none")) {
            document.querySelector("#bccField input").focus();
        }
    }
    document.addEventListener("DOMContentLoaded", () => {
        const suggestions = [
            { value: "john@example.com", name: "John Doe" },
            { value: "jane@example.com", name: "Jane Smith" },
            { value: "support@company.com", name: "Support" },
        ];

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const toFieldInput = document.getElementById("toFieldInput");
        if (toFieldInput) {
            const tagify = new Tagify(toFieldInput, {
                pattern: emailPattern,
                delimiters: ", ",
                placeholder: "Add recipients",
                enforceWhitelist: false,
                whitelist: suggestions,
                dropdown: {
                    enabled: 1,
                    maxItems: 5,
                    position: "input",
                    closeOnSelect: true,
                    highlightFirst: true,
                    fuzzySearch: true,
                    searchKeys: ["value", "name"],
                },
            });

            if (toFieldInput.value) {
                tagify.addTags(`Ashter Aoun Customer`);
            }
        }

        const ccFieldInput = document.getElementById("ccFieldInput");
        if (ccFieldInput) {
            new Tagify(ccFieldInput, {
                pattern: emailPattern,
                delimiters: ", ",
                placeholder: "Add Cc recipients",
                enforceWhitelist: false,
                whitelist: suggestions,
                dropdown: {
                    enabled: 1,
                    maxItems: 5,
                    position: "input",
                    closeOnSelect: true,
                    highlightFirst: true,
                    fuzzySearch: true,
                    searchKeys: ["value", "name"],
                },
            });
        }

        const bccFieldInput = document.getElementById("bccFieldInput");
        if (bccFieldInput) {
            new Tagify(bccFieldInput, {
                pattern: emailPattern,
                whitelist: suggestions,
                dropdown: {
                    enabled: 1,
                    maxItems: 5,
                    position: "input",
                    closeOnSelect: true,
                    highlightFirst: true,
                    fuzzySearch: true,
                    searchKeys: ["value", "name"],
                },
            });
        }

        document
            .getElementById("sendEmailBtn")
            .addEventListener("click", function (e) {
                e.preventDefault();

                const quill = window.quillInstances["editor_0"];
                const emailContent = document.getElementById("emailContent");
                if (quill) {
                    emailContent.value = quill.root.innerHTML;
                }

                const formData = new FormData();

                formData.append("email_content", emailContent.value);
                formData.append(
                    "subject",
                    document.getElementById("emailSubject").value
                );

                const toTagify = document.querySelector('[name="to"]');
                const ccTagify = document.querySelector('[name="cc"]');
                const bccTagify = document.querySelector('[name="bcc"]');

                function extractEmails(tagifyField) {
                    try {
                        return JSON.parse(tagifyField.value).map((item) => item.value);
                    } catch (e) {
                        return [];
                    }
                }

                const toEmails = extractEmails(toTagify);
                const ccEmails = ccTagify ? extractEmails(ccTagify) : [];
                const bccEmails = bccTagify ? extractEmails(bccTagify) : [];

                formData.append("to", JSON.stringify(toEmails));
                if (ccEmails.length) {
                    formData.append("cc", JSON.stringify(ccEmails));
                }
                if (bccEmails.length) {
                    formData.append("bcc", JSON.stringify(bccEmails));
                }
                formData.append(
                    "from",
                    document.querySelector('[name="from_email"]').value
                );
                formData.append("customer_id", "43");

                AjaxRequestPromise(
                    `https://payusinginvoice.com/crm-development/admin/customer/contact/send-email`,
                    formData,
                    "POST",
                    { useToastr: false }
                )
                    .then((response) => {
                        if (response.success) {
                            toastr.success("Email sent successfully!");

                            document.getElementById("emailSubject").value = "";

                            if (
                                window.quillInstances &&
                                window.quillInstances["editor_0"]
                            ) {
                                window.quillInstances["editor_0"].root.innerHTML = "";
                            }

                            const ccField = document.querySelector('[name="cc"]');
                            const bccField = document.querySelector('[name="bcc"]');

                            if (ccField) ccField.value = "";
                            if (bccField) bccField.value = "";

                            resetEmailTemplatePosition();
                        } else {
                            toastr.error(response.message || "Failed to send email");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        toastr.error("Something went wrong while sending email!");
                    });
            });
    });

    // dynamic function for reset position

    function resetEmailTemplatePosition() {
        const emailTemplate = document.querySelector("#emailTemplate");
        if (emailTemplate) {
            emailTemplate.classList.remove("open");
            emailTemplate.classList.remove("email-minimized");

            emailTemplate.style.position = "fixed";
            emailTemplate.style.bottom = "0";
            emailTemplate.style.right = "50px";
            emailTemplate.style.left = "auto";
            emailTemplate.style.top = "auto";
        }
    }

    //minimize and show email template (jQuery version)
    $(document).ready(function () {
        var $emailTemplate = $("#emailTemplate");
        var $minimizeBtn = $emailTemplate.find(".minimize-btn");

        $minimizeBtn.on("click", function () {
            $emailTemplate.toggleClass("email-minimized");

            if ($emailTemplate.hasClass("email-minimized")) {
                $minimizeBtn.removeClass("fa-angle-down").addClass("fa-angle-up");
            } else {
                $minimizeBtn.removeClass("fa-angle-up").addClass("fa-angle-down");
            }
        });
    });

    $(function () {
        let offsetX = 0,
            offsetY = 0,
            isDragging = false;

        const $dragElement = $("#emailTemplate");
        const $dragHandle = $dragElement.find(".email-header-main-wrapper");

        $dragHandle.on("mousedown", function (e) {
            isDragging = true;

            const rect = $dragElement[0].getBoundingClientRect();
            $dragElement.css({
                top: rect.top,
                left: rect.left,
                bottom: "auto",
                right: "auto",
                position: "fixed",
            });

            offsetX = e.clientX - rect.left;
            offsetY = e.clientY - rect.top;

            $("body").css("user-select", "none");
        });

        $(document).on("mousemove", function (e) {
            if (!isDragging) return;

            const winW = $(window).width();
            const winH = $(window).height();
            const elemW = $dragElement.outerWidth();
            const elemH = $dragElement.outerHeight();

            // calculate new position
            let newLeft = e.clientX - offsetX;
            let newTop = e.clientY - offsetY;

            // clamp values to viewport
            if (newLeft < 0) newLeft = 0;
            if (newTop < 0) newTop = 0;
            if (newLeft + elemW > winW) newLeft = winW - elemW;
            if (newTop + elemH > winH) newTop = winH - elemH;

            $dragElement.css({
                left: newLeft,
                top: newTop,
            });
        });

        $(document).on("mouseup", function () {
            isDragging = false;
            $("body").css("user-select", "auto");
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const closeBtns = document.querySelectorAll(".close-btn");
        const emailTemplate = document.querySelector("#emailTemplate");

        closeBtns.forEach((btn) => {
            btn.addEventListener("click", function () {
                document.getElementById("emailSubject").value = "";

                if (window.quillInstances && window.quillInstances["editor_0"]) {
                    window.quillInstances["editor_0"].root.innerHTML = "";
                }

                const ccField = document.querySelector('[name="cc"]');
                const bccField = document.querySelector('[name="bcc"]');
                if (ccField) ccField.value = "";
                if (bccField) bccField.value = "";

                resetEmailTemplatePosition();
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        /** Valid Url */
        function isValidUrl(url) {
            try {
                new URL(url);
                return true;
            } catch (_) {
                return false;
            }
        }

        function decodeHtmlEntities(str) {
            return str ? $("<div>").html(str).text() : str;
        }

        const formatBody = (type) => (data, row, column, node) => {
            if (type === "print") {
                if ($(node).find("img").length > 0) {
                    const src = $(node).find("img").attr("src");
                    return `<img src="${src}" style="max-width: 100px; max-height: 100px;" />`;
                }
            } else if (
                type !== "print" &&
                ($(node).find("object").length > 0 ||
                    $(node).find("img").length > 0)
            ) {
                return (
                    $(node).find("object").attr("data") ||
                    $(node).find("object img").attr("src") ||
                    $(node).find("img").attr("src") ||
                    ""
                );
            }
            if ($(node).find(".status-toggle").length > 0) {
                return $(node).find(".status-toggle:checked").length > 0
                    ? "Active"
                    : "Inactive";
            }
            if ($(node).find(".invoice-cell").length > 0) {
                const invoiceNumber = $(node).find(".invoice-number").text().trim();
                const invoiceKey = $(node).find(".invoice-key").text().trim();
                return invoiceNumber + "\n" + invoiceKey;
            }
            return decodeHtmlEntities(data);
        };
        const exportButtons = [
            // 'copy', 'excel', 'csv'
            // , 'pdf'
            // , 'print'
        ].map((type) => ({
            extend: type,
            text:
                type == "copy"
                    ? '<i class="fas fa-copy"></i>'
                    : type == "excel"
                        ? '<i class="fas fa-file-excel"></i>'
                        : type == "csv"
                            ? '<i class="fas fa-file-csv"></i>'
                            : type == "pdf"
                                ? '<i class="fas fa-file-pdf"></i>'
                                : type == "print"
                                    ? '<i class="fas fa-print"></i>'
                                    : "",
            orientation: type === "pdf" ? "landscape" : undefined,
            exportOptions: {
                columns: function (index, node, column) {
                    const columnHeader = column.textContent.trim().toLowerCase();
                    return (
                        columnHeader !== "action" &&
                        !$(node).find(".table-actions").length &&
                        !$(node).find("i.fas.fa-edit").length &&
                        !$(node).find("i.fas.fa-trash").length &&
                        !$(node).find(".deleteBtn").length &&
                        !$(node).find(".editBtn").length
                    );
                },
                format: { body: formatBody(type) },
            },
        }));

        /** Initializing Datatable */
        if ($(".initTable").length) {
            $(".initTable").each(function (index) {
                initializeDatatable($(this), index);
            });
        }
        var table;

        function initializeDatatable(table_div, index) {
            table = table_div.DataTable({
                dom:
                // "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'>>" +
                    "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
                buttons: exportButtons,
                order: [[1, "desc"]],
                responsive: false,
                scrollX: true,
                scrollY: $(window).height() - 350,
                scrollCollapse: true,
                paging: true,
                columnDefs: [
                    {
                        orderable: false,
                        className: "select-checkbox",
                        targets: 0,
                    },
                ],
                select: {
                    style: "os",
                    selector: "td:first-child",
                },
                fixedColumns: {
                    start: 0,
                },
            });
            table.buttons().container().appendTo(`#right-icon-${index}`);
        }

        /** Edit */
        $(document).on("click", ".editBtn", function () {
            const id = $(this).data("id");
            if (!id) {
                Swal.fire({
                    title: "Error!",
                    text: "Record not found. Do you want to reload the page?",
                    icon: "error",
                    showCancelButton: true,
                    confirmButtonText: "Reload",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            }
            $("#manage-form")[0].reset();
            $.ajax({
                url:
                    `https://payusinginvoice.com/crm-development/admin/customer/company/edit/` +
                    id,
                type: "GET",
                success: function (data) {
                    setDataAndShowEdit(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                },
            });
        });

        var $defaultImage;
        const $imageInput = $("#image"),
            $imageUrl = $("#image_url"),
            $imageDisplay = $("#image-display"),
            $imageDiv = $("#image-div");

        const updateImage = (src) => {
            $imageDisplay.attr("src", src || $defaultImage);
            $imageDiv.toggle(!!src);
        };
        $imageInput.on("change", function () {
            const file = this.files[0];
            if (file) {
                updateImage(URL.createObjectURL(file));
                $imageUrl.val(null);
            } else {
                updateImage($imageUrl.val());
            }
        });
        $imageUrl.on("input", function () {
            if (!$imageInput.val()) updateImage($(this).val());
        });
        updateImage();

        function setDataAndShowEdit(data) {
            $("#manage-form").data("id", data.id);

            $("#name").val(data.name);
            $("#email").val(data.email);
            $("#designation").val(data.designation);
            $("#gender").val(data.gender);
            $("#phone_number").val(data.phone_number);
            $("#address").val(data.address);
            $("#status").val(data.status);
            if (data.image) {
                var isValidUrl = data.image.match(/^(https?:\/\/|\/|\.\/)/);
                if (isValidUrl) {
                    $imageUrl.val(data.image);
                    $defaultImage = data.image;
                    updateImage(data.image);
                } else {
                    $imageUrl.val(
                        `https://payusinginvoice.com/crm-development/assets/images/employees/` +
                        data.image
                    );
                    $defaultImage =
                        `https://payusinginvoice.com/crm-development/assets/images/employees/` +
                        data.image;
                    updateImage(
                        `https://payusinginvoice.com/crm-development/assets/images/employees/` +
                        data.image
                    );
                }
                $imageDisplay.attr("alt", data.name);
                $imageDiv.show();
            }
            $("#manage-form").attr(
                "action",
                `https://payusinginvoice.com/crm-development/admin/customer/company/update/` +
                data.id
            );
            $("#formContainer").addClass("open");
        }
        const decodeHtml = (html) => {
            const txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        };

        /** Manage Record */
        $("#manage-form").on("submit", function (e) {
            e.preventDefault();
            var dataId = $("#manage-form").data("id");
            var formData = new FormData(this);
            if (!dataId) {
                AjaxRequestPromise(
                    `https://payusinginvoice.com/crm-development/admin/customer/company/store`,
                    formData,
                    "POST",
                    { useToastr: true }
                )
                    .then((response) => {
                        if (response?.data) {
                            const {
                                id,
                                image,
                                name,
                                email,
                                designation,
                                team_name,
                                status,
                            } = response.data;
                            const imageUrl = isValidUrl(image)
                                ? image
                                : image
                                    ? `https://payusinginvoice.com/crm-development/assets/images/employees/${image}`
                                    : "https://payusinginvoice.com/crm-development/assets/images/no-image-available.png";
                            const index = table.rows().count() + 1;
                            const columns = `
                                <td class="align-middle text-center text-nowrap"></td>
                                <td class="align-middle text-center text-nowrap">${index}</td>
                                <td class="align-middle text-center text-nowrap">
                                    ${
                                imageUrl
                                    ? `<object data="${imageUrl}" class="avatar avatar-sm me-3" title="${name}">
                                        <img src="${imageUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">
                                    </object>`
                                    : null
                            }
                                </td>
                                <td class="align-middle text-center text-nowrap">${name}</td>
                                <td class="align-middle text-center text-nowrap">${email}</td>
                                <td class="align-middle text-center text-nowrap">${designation}</td>
                                <td class="align-middle text-center text-nowrap">${team_name}</td>
                                <td class="align-middle text-center text-nowrap">
                                    <input type="checkbox" class="status-toggle change-status" data-id="${id}" ${
                                status == 1 ? "checked" : ""
                            } data-bs-toggle="toggle">
                                </td>
                                <td class="align-middle text-center table-actions">
                                    <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${id}" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${id}" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                        `;
                            table.row
                                .add($("<tr>", { id: `tr-${id}` }).append(columns))
                                .draw(false);
                            $("#manage-form")[0].reset();
                            $("#image-display").attr("src", null);
                            $("#formContainer").removeClass("open");
                        }
                    })
                    .catch((error) =>
                        console.error(
                            "An error occurred while updating the record.",
                            error
                        )
                    );
            } else {
                const url = $(this).attr("action");
                AjaxRequestPromise(url, formData, "POST", { useToastr: true })
                    .then((response) => {
                        if (response?.data) {
                            const {
                                id,
                                image,
                                name,
                                email,
                                designation,
                                team_name,
                                status,
                            } = response.data;
                            const imageUrl = isValidUrl(image)
                                ? image
                                : image
                                    ? `https://payusinginvoice.com/crm-development/assets/images/employees/${image}`
                                    : `https://payusinginvoice.com/crm-development/assets/images/no-image-available.png`;
                            const index = table.row($("#tr-" + id)).index();
                            const rowData = table.row(index).data();
                            // Column 2: Image
                            const imageHtml = imageUrl
                                ? `<object data="${imageUrl}" class="avatar avatar-sm me-3" title="${name}"><img src="${imageUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}"></object>`
                                : "";
                            if (decodeHtml(rowData[2]) !== imageHtml) {
                                table
                                    .cell(index, 2)
                                    .data(
                                        imageUrl
                                            ? `<object data="${imageUrl}" class="avatar avatar-sm me-3" title="${name}">
                                                            <img src="${imageUrl}" alt="${name}" class="avatar avatar-sm me-3" title="${name}">
                                                        </object>`
                                            : ""
                                    )
                                    .draw();
                            }
                            /** Column 3: Name */
                            if (decodeHtml(rowData[3]) !== name) {
                                table.cell(index, 3).data(name).draw();
                            }
                            // Column 4: Email
                            if (decodeHtml(rowData[4]) !== email) {
                                table.cell(index, 4).data(email).draw();
                            }
                            // Column 5: Designation
                            if (decodeHtml(rowData[5]) !== designation) {
                                table.cell(index, 5).data(designation).draw();
                            }
                            // Column 6: Team
                            if (decodeHtml(rowData[6]) !== team_name) {
                                table.cell(index, 6).data(team_name).draw();
                            }
                            // Column 7: Status
                            const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${id}" ${
                                status == 1 ? "checked" : ""
                            } data-bs-toggle="toggle">`;
                            if (decodeHtml(rowData[7]) !== statusHtml) {
                                table.cell(index, 7).data(statusHtml).draw();
                            }
                            $("#manage-form")[0].reset();
                            $("#image-display").attr("src", null);
                            $("#formContainer").removeClass("open");
                        }
                    })
                    .catch((error) => console.log(error));
            }
        });
        /** Change Status*/
        $("tbody").on("change", ".change-status", function () {
            const statusCheckbox = $(this);
            const status = +statusCheckbox.is(":checked");
            const rowId = statusCheckbox.data("id");
            AjaxRequestPromise(
                `https://payusinginvoice.com/crm-development/admin/customer/company/change-status/${rowId}?status=${status}`,
                null,
                "GET",
                { useToastr: true }
            )
                .then((response) => {
                    const rowIndex = table.row($("#tr-" + rowId)).index();
                    const statusHtml = `<input type="checkbox" class="status-toggle change-status" data-id="${rowId}" ${
                        status ? "checked" : ""
                    } data-bs-toggle="toggle">`;
                    table.cell(rowIndex, 7).data(statusHtml).draw();
                })
                .catch(() => {
                    statusCheckbox.prop("checked", !status);
                });
        });
        /** Delete Record */
        $(document).on("click", ".deleteBtn", function () {
            const id = $(this).data("id");
            AjaxDeleteRequestPromise(
                `https://payusinginvoice.com/crm-development/admin/customer/company/delete/${id}`,
                null,
                "DELETE",
                {
                    useDeleteSwal: true,
                    useToastr: true,
                }
            )
                .then((response) => {
                    table.row(`#tr-${id}`).remove().draw();
                })
                .catch((error) => {
                    if (error.isConfirmed === false) {
                        Swal.fire({
                            title: "Action Canceled",
                            text: error?.message || "The deletion has been canceled.",
                            icon: "info",
                            confirmButtonText: "OK",
                        });
                        console.error("Record deletion was canceled:", error?.message);
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: "An error occurred while deleting the record.",
                            icon: "error",
                            confirmButtonText: "Try Again",
                        });
                        console.error(
                            "An error occurred while deleting the record:",
                            error
                        );
                    }
                });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $(".showhide-payment, .showhide-invoice").click(function () {
            // Determine which type: "payment" or "invoice"
            let type = $(this).hasClass("showhide-payment")
                ? "payment"
                : "invoice";

            // Find the matching hidden elements
            let $extradata = $(".extra-" + type);

            if ($extradata.is(":visible")) {
                $extradata.addClass("d-none");
                $(this).text("See More");
            } else {
                $extradata.removeClass("d-none");
                $(this).text("See Less");
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $(".toggle-collapse").each(function () {
            var $button = $(this);
            var target = $button.data("bs-target"); // Get target id from data-bs-target
            var $collapse = $(target);

            // On show event
            $collapse.on("show.bs.collapse", function () {
                $button
                    .find(".toggle-icon")
                    .removeClass("fa-chevron-right")
                    .addClass("fa-chevron-down");
            });

            // On hide event
            $collapse.on("hide.bs.collapse", function () {
                $button
                    .find(".toggle-icon")
                    .removeClass("fa-chevron-down")
                    .addClass("fa-chevron-right");
            });
        });
    });
</script>
<script>
    // Function to toggle the visibility of the additional content div
    function toggleContent(contentId) {
        var contentDiv = document.getElementById(contentId);
        // Toggle the display property (show/hide)
        if (
            contentDiv.style.display === "none" ||
            contentDiv.style.display === ""
        ) {
            contentDiv.style.display = "flex"; // Show the content
        } else {
            contentDiv.style.display = "none"; // Hide the content
        }
    }

    // Second comment function
    $(document).ready(function () {
        $("#toggleButton").click(function () {
            const contents = $("#contents");
            if (contents.hasClass("hidden")) {
                contents.removeClass("hidden");
                $(this).find("span").text("Hide Comment");
            } else {
                contents.addClass("hidden");
                $(this).find("span").text("Add Comments");
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
            $(".contentdisplay, .contentdisplaytwo").slideToggle(); // Smoothly show or hide content
        });
    });
    //new

    // EMAIL TEMPLATE OPEN AND CLOSE
    $(document).ready(function () {
        const emailTemplate = $("#emailTemplate");

        // Open form
        $(".open-email-form").click(function () {
            emailTemplate.addClass("open");
        });

        // Close form
        $(".close-btn").click(function () {
            emailTemplate.removeClass("open");
        });
    });
    // view threads function
    $(document).ready(function () {
        $("#toggleButtonThread").click(function () {
            const contents = $("#thread");
            if (contents.hasClass("hidden")) {
                contents.removeClass("hidden");
                // $(this).text('See less');
                $(this).find("span").text("See less");
            } else {
                contents.addClass("hidden");
                // $(this).text('View thread');
                $(this).find("span").text("View thread");
            }
        });
    });
    // read more text function
    $(".moreless-button").click(function () {
        $(".moretext").slideToggle();
        if ($(".moreless-button").text() == "See more") {
            $(this).text("See less");
        } else {
            $(this).text("See more");
        }
    });

    // Copy Clipboard Email

    $(document).ready(function () {
        // Initialize Bootstrap tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();

        $(document).on("click", ".copyEmail", async function () {
            try {
                let emailText = $("#customerEmail").text().trim();
                await navigator.clipboard.writeText(emailText);

                // Change tooltip to "Copied!" and show it
                $(this).attr("data-bs-original-title", "Copied!").tooltip("show");

                // Reset tooltip text after 2 seconds
                setTimeout(() => {
                    $(this).attr("data-bs-original-title", "Copy to clipboard");
                }, 2000);
            } catch (err) {
                console.error("Clipboard copy failed:", err);
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        const storageKey = "channelsData_5";
        let channelsData =
            JSON.parse(sessionStorage.getItem(storageKey)) || null;
        let isChecking = false;
        if (channelsData) {
            renderChannels(channelsData);
        }

        $(".header__btn.channels.btn").on("click", function () {
            const $channelList = $(this)
                .closest(".dropdown")
                .find(".channel-list");
            const $loadingIndicator = $channelList.find(".loading-channels");
            $channelList.children().not(":first").remove();
            if (channelsData && channelsData.timestamp > Date.now() - 300000) {
                // 5 minute cache
                renderChannels(channelsData);
                return;
            }
            if (isChecking) {
                $loadingIndicator.show();
                return;
            }

            // Start new check
            isChecking = true;
            $loadingIndicator.show();

            $.ajax({
                url: "https://payusinginvoice.com/crm-development/admin/check-channels",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "1vH94yB4UUsVONeEfOu7yS9Qri6WB7zUEuEiuscX",
                },
                success: function (response) {
                    channelsData = {
                        data: response.validChannels || [],
                        timestamp: Date.now(),
                    };
                    sessionStorage.setItem(storageKey, JSON.stringify(channelsData));
                    renderChannels(channelsData);
                },
                error: function () {
                    $channelList.append(
                        '<div class="text-danger">Failed to load channels. Try again later.</div>'
                    );
                },
                complete: function () {
                    isChecking = false;
                    $loadingIndicator.hide();
                },
            });
        });

        function renderChannels(data) {
            const $channelList = $(".channel-list");
            $channelList.children().not(":first").remove();

            if (!data.data || !data.data.length) {
                $channelList.append(
                    '<div class="text-muted">No additional channels found.</div>'
                );
                return;
            }
            data.data.forEach((channel, index) => {
                const listItem = `
                        <div class="list-group-item py-1" style="display:none;">
                            <a href="${channel.url}"
                               class="text-decoration-none text-primary fw-bold redirect-channel"
                                data-url="${channel.url}"
                                data-token="${channel.access_token}">
                                ${channel.name}
                            </a>
                        </div>`;
                const $item = $(listItem);
                $channelList.append($item);
                $item.fadeIn(150 * (index + 1));
            });
        }
        $(document)
            .on("mouseenter", ".redirect-channel", function () {
                const cleanUrl = $(this).attr("href");
                window.status = cleanUrl;
            })
            .on("mouseleave", ".redirect-channel", function () {
                window.status = "";
            });
        $(document).on("click", ".redirect-channel", function (e) {
            e.preventDefault();
            const url = $(this).data("url");
            const token = $(this).data("token");
            // Verify session before redirecting
            // $.get('/api/check-session', function(response) {
            //     if (response.valid) {
            // Append token to URL and redirect
            window.location.href = `${url}?access_token=${encodeURIComponent(
                token
            )}`;
            // } else {
            //     toastr.error('Your session has expired - please login again');
            //     window.location.href = '/login';
            // }
            // }).fail(function() {
            //     toastr.error('Could not verify session status');
            // });
        });
    });
</script>
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
                    "fa-solid",
                    "fa-square-check",
                    "selected-enelop"
                );
                emailHeader.classList.add("d-none");
            } else {
                defaultActions.classList.remove("d-none");
                selectedActions.classList.add("d-none");
                emailIcon.classList.remove(
                    "fa-solid",
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

<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
</body>
</html>
