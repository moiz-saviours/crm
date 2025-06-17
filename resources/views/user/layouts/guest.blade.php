<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="7199">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="{{asset('assets/fonts/css2.css')}}" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">

    <!--     Fonts and icons     -->
    <link href="{{asset('assets/fonts/google-fonts-css.css')}}" rel="stylesheet"/>
    <!-- Nucleo Icons -->
    <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet"/>
    <!-- Font Awesome Icons -->
    <script src="{{asset('assets/fonts/fontawsome.js')}}" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('assets/css/dashboard.css')}}?v=2.1.0" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('assets/toaster/css/toastr.min.css')}}">
</head>
<body class="font-sans text-gray-900 antialiased">
@yield('content')


<!--   Core JS Files   -->
<script src="{{asset('assets/js/core/popper.min.js')}}"></script>
<script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<script async defer src="{{asset('assets/js/buttons.js')}}"></script>
<script src="{{asset('assets/js/dashboard.min.js')}}?v=2.1.0"></script>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>

<!-- Toaster1 -->
<script src="{{asset('assets/toaster/js/toastr.min.js')}}"></script>
<script>
    // Toastr options
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "3000", // 5 seconds
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    @if(session('errors') && session('errors')->any())
    let errorMessages = {!! json_encode(session('errors')->all()) !!};
    let displayedCount = 0;

    setTimeout(function () {
        errorMessages.forEach((message, index) => {
            if (displayedCount < 5) {
                toastr.error(message);
                displayedCount++;
            } else {
                setTimeout(() => toastr.error(message), index * 1000);
            }
        });
    }, 1500);

    @php session()->forget('errors'); @endphp
    @endif

    @if(session('message'))
    let message = {!! json_encode(session('message')) !!};
        toastr.info(message);
    @php session()->forget('message'); @endphp
    @endif

</script>
<script>
    let inactivityTimeout;
    // const maxInactivityTime = 2 * 60 * 60 * 1000; // 2 hours in milliseconds
    const maxInactivityTime = 15 * 60 * 1000;
    function refreshPage() {
        location.reload();
    }

    function resetInactivityTimer() {
        clearTimeout(inactivityTimeout);
        inactivityTimeout = setTimeout(refreshPage, maxInactivityTime);
    }
    window.addEventListener('mousemove', resetInactivityTimer);
    window.addEventListener('keypress', resetInactivityTimer);
    resetInactivityTimer();
</script>
</body>
</html>
