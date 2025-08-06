<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="7199">

    <title>{{ config('app.name', 'Laravel') }}</title>
    {{--    <link rel="stylesheet" href="./style.css/">--}}
    <link rel="stylesheet" href="{{asset ('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/toaster/css/toastr.min.css')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('assets/img/favicon2.png')}}">

    @include('admin.auth.style')

</head>

<body>

<section class="login-section">
    <div class="container" style="min-width: 100%;">
        <div class="main-login-row">
            <div class="row justify-content-end">
                <div class="col-lg-4">
                    {{--                    <div class="text-center">--}}
                    {{--                        <img src="{{asset('assets/images/aim-logo.png')}}" class="img-fluid logo-h" >--}}
                    {{--                        <h1 class="main-logo-heading">CRM</h1>--}}

                    {{--                    </div>--}}
                    <div class="left-side-box">

                        <h4> Admin Login </h4>
                        <p>Enter your email and password to login</p>
                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf

                            <x-input-label for="email" class="login-labels" :value="__('Email')"/>
                            <x-text-input id="email" class="login-inputs" type="email" name="email"
                                          :value="old('email')" required autofocus
                                          autocomplete="username"/>
                            {{--                            <x-input-error :messages="$errors->get('email')" class="mt-2"/>--}}
                            <x-input-label for="password" class="login-labels" :value="__('Password')"/>

                            <x-text-input id="password" class="login-inputs"
                                          type="password"
                                          name="password"
                                          required autocomplete="current-password"/>

                            <x-input-error :messages="$errors->get('password')" class="mt-2"/>

                            <div class="forgot-password-div">
                                <div class="save-password-div">
                                    <label class="switch">
                                        <input id="remember" type="checkbox" name="remember" checked>
                                        <span class="slider round"></span>
                                    </label>
                                    <x-input-label for="remember" class="login-labels" :value="__('Remember Me')"/>
                                </div>
                                {{--                                <a href="{{ route('password.request') }}" class="password-link">--}}
                                {{--                                    @if (Route::has('password.request'))--}}
                                {{--                                        {{ __('Forgot your password?') }}--}}
                                {{--                                    @endif--}}

                                {{--                                </a>--}}
                            </div>
                            <button type="submit" class="login-btn">
                                {{ __('Log in') }}
                            </button>
                            <div class="float-end">
                                <a href="{{ route('login') }}" class="" style="color: #fff;text-decoration: none;">
                                    @if (Route::has('login'))
                                        {{ __('Go to User Login') }} >
                                    @endif
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>


<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
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
    toastr.error(message);
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

@stack('script')

</body>

</html>
