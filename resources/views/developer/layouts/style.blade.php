<link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
<link rel="icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">

<!--     Fonts and icons     -->
<link href="{{asset('assets/fonts/google-fonts-css.css')}}" rel="stylesheet"/>
<!-- Nucleo Icons -->
<link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet"/>
<link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet"/>
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{asset('assets/fonts/all.min.css')}}"/>
<!-- CSS Files -->
<link id="pagestyle" href="{{asset('assets/css/dashboard.css')}}?v=2.1.0" rel="stylesheet"/>

<!-- Choices Css For Select Searchable-->
<link href="{{asset('assets/css/choices.min.css')}}" rel="stylesheet"/>

<!-- Toastr CSS -->
<link rel="stylesheet" href="{{asset('assets/toaster/css/toastr.min.css')}}">

<!-- Scripts -->
{{--@vite(['resources/css/app.css', 'resources/js/app.js'])--}}


<style>
    .choices[data-type*="select-one"] select.choices__input {
        display: block !important;
        opacity: 0;
        pointer-events: none;
        position: absolute;
        left: 0;
        bottom: 0;
    }
    .choices__list .is-selected{
        background-color:#ebebeb;
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

    /* Full-screen loader styles */
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

    /* Loader spinner */
    .spinner {
        border: 5px solid #f3f3f3; /* Light grey background */
        border-top: 5px solid #6c757d; /* Blue color for the top section */
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite;
    }

    /* Animation for the spinner */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    /* Hidden loader after the time interval */
    #loader.hidden {
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.3s ease, visibility 0s ease 0s;
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
        padding: 6px 9px;
        background-color: #fff;
    }

    .dt-buttons .btn.btn-secondary span {
        color: #8392ab;
    }

    .dt-buttons .btn.btn-secondary:hover {
        background-color: #8392ab;
    }

    .dt-buttons .btn.btn-secondary span:hover {
        color: var(--bs-primary);
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

    .table > :not(caption) > * > * {
        /*padding: .5rem .5rem;*/
    }
    button.btn.btn-sm {
        /*padding: 0px;*/
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

    .dropdown-item:focus, .dropdown-item:hover {
        color: var(--bs-primary-color);
        background-color: var(--bs-primary);
    }

    div.dt-button-background {
        position: absolute !important;
        z-index: 11 !important;;
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
</style>
