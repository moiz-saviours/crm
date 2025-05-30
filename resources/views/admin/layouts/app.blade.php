<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-scheme="navy">
<head>
    @if (app()->environment('production') && 1 == 2)
        <script src="{{asset('assets/js/load.js')}}"></script>
        <script>setInterval(function e() {
                (function e() {
                    if (window.outerWidth - window.innerWidth > 200 || window.outerHeight - window.innerHeight > 200) return !0;
                    let n = performance.now();
                    for (let t = 0; t < 1e7; t++) ;
                    return performance.now() - n > 200
                })() && (document.body.innerHTML = "", document.title = "Access Denied", setTimeout(() => {
                    // window.location.href = "about:blank"
                }, 100))
            }, 1e3), document.addEventListener("DOMContentLoaded", function () {
                document.addEventListener("contextmenu", e => e.preventDefault()), document.addEventListener("keydown", e => {
                    (123 === e.keyCode || e.ctrlKey && e.shiftKey && (73 === e.keyCode || 74 === e.keyCode) || e.ctrlKey && 85 === e.keyCode) && e.preventDefault()
                });
                let e = !1;
                function n() {
                    let e = performance.now(), n = performance.now();
                    return n - e > 160
                }
                setTimeout(function e() {
                    n() && (document.body.innerHTML = "", document.title = "Access Denied", document.close())
                }, 100), setInterval(() => {
                    n() && (document.body.innerHTML = "", document.title = "Access Denied")
                }, 1e3), setInterval(() => {
                    let n = window.outerWidth - window.innerWidth > 160,
                        t = window.outerHeight - window.innerHeight > 160;
                    n || t ? (e || (document.body.innerHTML = "", document.title = "Access Denied", document.close()), e = !0) : e = !1
                }, 1e3)
            });</script>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <link rel="icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">
    <meta name="description"
          content="is a responsive admin dashboard template based on Bootstrap 5 framework. There are a lot of useful components.">
    <title>@yield('title')</title>


    <!-- STYLESHEETS -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    @include('admin.layouts.style')
    @stack('style')
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->


</head>

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

<!-- PAGE CONTAINER -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<div id="root" class="root mn--max tm--primary-mn hd--sticky mn--sticky">

    <!-- CONTENTS -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    @yield('content')
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
                    <a href="{{route('admin.dashboard')}}" class="brand-img stretched-link">
                        <img src="{{asset('assets/img/favicon.png')}}" alt="Logo" class="logo"
                             {{--                             width="16"--}}
                             {{--                             height="16"--}}
                             style="width:110px;height:40px">
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
                    <button type="button" class="nav-toggler header__btn btn btn-icon btn-sm" aria-label="Nav Toggler"
                            disabled>
                        <i class="demo-psi-list-view"></i>
                    </button>

                    <div class="vr mx-1 d-none d-md-block"></div>

                    <!-- Searchbox -->
                    <div class="header-searchbox">

                        <!-- Searchbox toggler for small devices -->
                        <label for="header-search-input"
                               class="header__btn d-md-none btn btn-icon rounded-pill shadow-none border-0 btn-sm"
                               type="button">
                            <i class="demo-psi-magnifi-glass"></i>
                        </label>

                        <!-- Searchbox input -->
                        <form class="searchbox searchbox--auto-expand searchbox--hide-btn input-group">
                            <input id="header-search-input" class="searchbox__input form-control bg-transparent"
                                   type="search" placeholder="Type for search . . ." aria-label="Search">
                            <div class="searchbox__backdrop">
                                <button
                                    class="searchbox__btn header__btn btn btn-icon rounded shadow-none border-0 btn-sm"
                                    type="button">
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
                        <button class="header__btn btn btn-icon btn-sm" type="button" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" aria-label="Megamenu dropdown" aria-expanded="false"
                                disabled>
                            <i class="demo-psi-layout-grid"></i>
                        </button>

                        <!-- Mega Dropdown Menu -->
                        <div class="dropdown-menu dropdown-menu-end p-3 mega-dropdown">
                            <div class="row">
                                <div class="col-md-3">


                                    <!-- Pages List Group -->
                                    <div class="list-group list-group-borderless">
                                        <div class="list-group-item d-flex align-items-center border-bottom mb-2">
                                            <div class="flex-shrink-0 me-2">
                                                <i class="demo-pli-file fs-4"></i>
                                            </div>
                                            <h5 class="flex-grow-1 m-0">Pages</h5>
                                        </div>
                                        <a href="#" class="list-group-item list-group-item-action">Profile</a>
                                        <a href="#" class="list-group-item list-group-item-action">Search Result</a>
                                        <a href="#" class="list-group-item list-group-item-action">FAQ</a>
                                        <a href="#" class="list-group-item list-group-item-action">Screen Lock</a>
                                        <a href="#" class="list-group-item list-group-item-action">Maintenance</a>
                                        <a href="#" class="list-group-item list-group-item-action">Invoices</a>
                                        <a href="#" class="list-group-item list-group-item-action disabled"
                                           tabindex="-1" aria-disabled="true">Disabled Item</a>
                                    </div>


                                </div>
                                <div class="col-md-3">


                                    <!-- Mailbox list group -->
                                    <div class="list-group list-group-borderless mb-3">
                                        <div class="list-group-item d-flex align-items-center border-bottom mb-2">
                                            <div class="flex-shrink-0 me-2">
                                                <i class="demo-pli-mail fs-4"></i>
                                            </div>
                                            <h5 class="flex-grow-1 m-0">Mailbox</h5>
                                        </div>
                                        <a href="#"
                                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            Inbox <span class="badge bg-danger rounded-pill">14</span>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action">Read Messages</a>
                                        <a href="#" class="list-group-item list-group-item-action">Compose</a>
                                        <a href="#" class="list-group-item list-group-item-action">Template</a>
                                    </div>


                                    <!-- News -->
                                    <div class="list-group list-group-borderless bg-warning-subtle py-2">
                                        <div
                                            class="list-group-item d-flex align-items-center border-bottom text-warning-emphasis">
                                            <div class="flex-shrink-0 me-2">
                                                <i class="demo-pli-calendar-4 fs-4"></i>
                                            </div>
                                            <h5 class="flex-grow-1 m-0 text-reset">News</h5>
                                        </div>
                                        <small class="list-group-item text-warning-emphasis">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic dolore unde
                                            autem, molestiae eum laborum aliquid at commodi cum? Blanditiis.
                                        </small>
                                    </div>


                                </div>
                                <div class="col-md-3">


                                    <!-- List Group -->
                                    <div class="list-group list-group-borderless">
                                        <div
                                            class="list-group-item list-group-item-action d-flex align-items-start mb-3">
                                            <div class="flex-shrink-0 me-3">
                                                <i class="demo-pli-data-settings fs-1"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <a href="#"
                                                       class="h5 d-block mb-0 stretched-link text-decoration-none">Data
                                                        Backup</a>
                                                    <span class="badge bg-success rounded-pill ms-auto">40%</span>
                                                </div>
                                                <small class="text-body-secondary">Current usage of disks for
                                                    backups.</small>
                                            </div>
                                        </div>

                                        <div
                                            class="list-group-item list-group-item-action d-flex align-items-start mb-3">
                                            <div class="flex-shrink-0 me-3">
                                                <i class="demo-pli-support fs-1"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <a href="#" class="h5 d-block mb-0 stretched-link text-decoration-none">Support</a>
                                                <small class="text-body-secondary">Have any questions ? please don't
                                                    hesitate to ask.</small>
                                            </div>
                                        </div>

                                        <div
                                            class="list-group-item list-group-item-action d-flex align-items-start mb-3">
                                            <div class="flex-shrink-0 me-3">
                                                <i class="demo-pli-computer-secure fs-1"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <a href="#" class="h5 d-block mb-0 stretched-link text-decoration-none">Security</a>
                                                <small class="text-body-secondary">Our devices are secure and
                                                    up-to-date.</small>
                                            </div>
                                        </div>


                                        <div class="list-group-item list-group-item-action d-flex align-items-start">
                                            <div class="flex-shrink-0 me-3">
                                                <i class="demo-pli-map-2 fs-1"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <a href="#" class="h5 d-block mb-0 stretched-link text-decoration-none">Location</a>
                                                <small class="text-body-secondary">From our location up here, we kept in
                                                    close touch.</small>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-3">

                                    <!-- Simple gallery -->
                                    <div class="d-grid gap-2 pt-4 pt-md-0">
                                        <div class="row g-1 rounded-3 overflow-hidden">
                                            <div class="col-6 mt-0">
                                                <img class="img-fluid"
                                                     src="{{asset('assets/themes/nifty/assets/img/megamenu/img-1.jpg')}}"
                                                     alt="thumbnails" loading="lazy">
                                            </div>
                                            <div class="col-6 mt-0">
                                                <img class="img-fluid"
                                                     src="{{asset('assets/themes/nifty/assets/img/megamenu/img-3.jpg')}}"
                                                     alt="thumbnails" loading="lazy">
                                            </div>
                                            <div class="col-6">
                                                <img class="img-fluid"
                                                     src="{{asset('assets/themes/nifty/assets/img/megamenu/img-2.jpg')}}"
                                                     alt="thumbnails" loading="lazy">
                                            </div>
                                            <div class="col-6">
                                                <img class="img-fluid"
                                                     src="{{asset('assets/themes/nifty/assets/img/megamenu/img-4.jpg')}}"
                                                     alt="thumbnails" loading="lazy">
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
                        <button class="header__btn btn btn-icon btn-sm" type="button" data-bs-toggle="dropdown"
                                aria-label="Notification dropdown" aria-expanded="false" disabled>
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
                                <div class="list-group-item list-group-item-action d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="demo-psi-data-settings text-danger fs-2"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <a href="#"
                                           class="h6 fw-normal d-block mb-0 stretched-link text-decoration-none">Your
                                            storage is full</a>
                                        <small class="text-body-secondary">Local storage is nearly full.</small>
                                    </div>
                                </div>


                                <!-- List item -->
                                <div class="list-group-item list-group-item-action d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="demo-psi-pen-5 text-info fs-2"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <a href="#"
                                           class="h6 fw-normal d-block mb-0 stretched-link text-decoration-none">Writing
                                            a New Article</a>
                                        <small class="text-body-secondary">Wrote a news article for the John
                                            Mike</small>
                                    </div>
                                </div>


                                <!-- List item -->
                                <div class="list-group-item list-group-item-action d-flex align-items-start mb-3">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="demo-psi-speech-bubble-3 text-success fs-2"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <a href="#" class="h6 fw-normal mb-0 stretched-link text-decoration-none">Comment
                                                sorting</a>
                                            <span class="badge bg-info rounded ms-auto">NEW</span>
                                        </div>
                                        <small class="text-body-secondary">You have 1,256 unsorted comments.</small>
                                    </div>
                                </div>


                                <!-- List item -->
                                <div class="list-group-item list-group-item-action d-flex align-items-start mb-3">
                                    <div class="flex-shrink-0 me-3">
                                        <img class="img-xs rounded-circle"
                                             src="{{asset('assets/themes/nifty/assets/img/profile-photos/7.png')}}"
                                             alt="Profile Picture" loading="lazy">
                                    </div>
                                    <div class="flex-grow-1">
                                        <a href="#"
                                           class="h6 fw-normal d-block mb-0 stretched-link text-decoration-none">Lucy
                                            Sent you a message</a>
                                        <small class="text-body-secondary">30 minutes ago</small>
                                    </div>
                                </div>


                                <!-- List item -->
                                <div class="list-group-item list-group-item-action d-flex align-items-start mb-3">
                                    <div class="flex-shrink-0 me-3">
                                        <img class="img-xs rounded-circle"
                                             src="{{asset('assets/themes/nifty/assets/img/profile-photos/3.png')}}"
                                             alt="Profile Picture" loading="lazy">
                                    </div>
                                    <div class="flex-grow-1">
                                        <a href="#"
                                           class="h6 fw-normal d-block mb-0 stretched-link text-decoration-none">Jackson
                                            Sent you a message</a>
                                        <small class="text-body-secondary">1 hours ago</small>
                                    </div>
                                </div>

                                <div class="text-center mb-2">
                                    <a href="#" class="btn-link text-primary icon-link icon-link-hover">
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
                        <button class="header__btn btn btn-icon btn-sm" type="button" data-bs-toggle="dropdown"
                                aria-label="User dropdown" aria-expanded="false" disabled>
                            <i class="demo-psi-male"></i>
                        </button>


                        <!-- User dropdown menu -->
                        <div class="dropdown-menu dropdown-menu-end w-md-450px">

                            <!-- User dropdown header -->
                            <div class="d-flex align-items-center border-bottom px-3 py-2">
                                <div class="flex-shrink-0">
                                    <img class="img-sm rounded-circle"
                                         src="{{asset('assets/themes/nifty/assets/img/profile-photos/4.png')}}"
                                         alt="Profile Picture" loading="lazy">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0">Aaron Chavez</h5>
                                    <span class="text-body-secondary fst-italic">aaron_chavez@example.com</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-7">

                                    <!-- Simple widget and reports -->
                                    <div class="list-group list-group-borderless mb-3">
                                        <div class="list-group-item text-center border-bottom mb-3">
                                            <p class="h1 display-1 text-primary fw-semibold">17</p>
                                            <p class="h6 mb-0"><i class="demo-pli-basket-coins fs-3 me-2"></i> New
                                                orders</p>
                                            <small class="text-body-secondary">You have new orders</small>
                                        </div>
                                        <div
                                            class="list-group-item py-0 d-flex justify-content-between align-items-center">
                                            Today Earning
                                            <small class="fw-bolder">$578</small>
                                        </div>
                                        <div
                                            class="list-group-item py-0 d-flex justify-content-between align-items-center">
                                            Tax
                                            <small class="fw-bolder text-danger">- $28</small>
                                        </div>
                                        <div
                                            class="list-group-item py-0 d-flex justify-content-between align-items-center">
                                            Total Earning
                                            <span class="fw-bolder text-body-emphasis">$6,578</span>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-5">

                                    <!-- User menu link -->
                                    <div class="list-group list-group-borderless h-100 py-3">
                                        <a href="#"
                                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <span><i class="demo-pli-mail fs-5 me-2"></i> Messages</span>
                                            <span class="badge bg-danger rounded-pill">14</span>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <i class="demo-pli-male fs-5 me-2"></i> Profile
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <i class="demo-pli-gear fs-5 me-2"></i> Settings
                                        </a>

                                        <a href="#" class="list-group-item list-group-item-action mt-auto">
                                            <i class="demo-pli-computer-secure fs-5 me-2"></i> Lock screen
                                        </a>
                                        <button type="button" class="list-group-item list-group-item-action"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
                        <input id="headerThemeToggler" class="form-check-input mode-switcher" type="checkbox"
                               role="switch" disabled>
                        <label class="form-check-label ps-1 fw-bold d-none d-md-flex align-items-center "
                               for="headerThemeToggler">
                            <i class="mode-switcher-icon icon-light demo-psi-sun fs-5"></i>
                            <i class="mode-switcher-icon icon-dark d-none demo-psi-half-moon"></i>
                        </label>
                    </div>

                    <div class="vr mx-1 d-none d-md-block"></div>

                    <x-channel-dropdown />







{{--                    @php--}}
{{--                        $host = request()->getHost();--}}
{{--                        $host = preg_replace('/^www\./', '', $host);--}}
{{--                        $parts = explode('.', $host);--}}
{{--                        $mainDomain = (count($parts) >= 2) ? $parts[count($parts) - 2] : $host;--}}

{{--                        $channels = [--}}
{{--                            'payusinginvoice' => 'Channel 1',--}}
{{--                            'paymentbyinvoice' => 'Channel 2',--}}
{{--                            'paymentviainvoice' => 'Channel 3',--}}
{{--                            'paythroughinvoice' => 'Channel 4',--}}
{{--                            'payviainvoice' => 'Channel 5',--}}
{{--                            'localhost' => 'Channel 8000',--}}
{{--                        ];--}}

{{--                        $currentChannel = array_key_exists($mainDomain, $channels) ? $channels[$mainDomain] : 'Unknown Channel';--}}
{{--                    @endphp--}}
{{--                    <!-- Channel Dropdown -->--}}
{{--                    <div class="dropdown">--}}
{{--                        <!-- Toggler -->--}}
{{--                        <button class="header__btn channels btn" type="button" id="channelDropdown" data-bs-toggle="dropdown"--}}
{{--                                aria-label="Channel dropdown" aria-expanded="false">--}}
{{--        <span class="d-block position-relative">--}}
{{--            {{ $currentChannel }}--}}
{{--        </span>--}}
{{--                        </button>--}}

{{--                        <!-- Channel dropdown menu -->--}}
{{--                        <div class="dropdown-menu dropdown-menu-end w-md-300px" aria-labelledby="channelDropdown">--}}
{{--                            <div class="border-bottom px-3 py-2 mb-2">--}}
{{--                                <h5>Channels</h5>--}}
{{--                            </div>--}}
{{--                            <div class="list-group list-group-borderless channel-list px-3">--}}
{{--                                <!-- Current channel will be shown immediately -->--}}
{{--                                <div class="list-group-item py-1">--}}
{{--                <span class="text-decoration-none text-primary fw-bold">--}}
{{--                    {{ $currentChannel }} (Current)--}}
{{--                </span>--}}
{{--                                </div>--}}
{{--                                <!-- Loading indicator for other channels -->--}}
{{--                                <div class="list-group-item py-1 text-muted loading-channels" style="display: none;">--}}
{{--                                    Checking available channels...--}}
{{--                                </div>--}}
{{--                                <!-- Channels will be appended here -->--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    @push('script')--}}
{{--                        <script>--}}
{{--                            $(document).ready(function () {--}}
{{--                                // Use sessionStorage to persist channel data--}}
{{--                                const storageKey = 'channelsData_{{ auth()->id() }}';--}}
{{--                                let channelsData = JSON.parse(sessionStorage.getItem(storageKey)) || null;--}}
{{--                                let isChecking = false;--}}

{{--                                // Initialize with cached data if available--}}
{{--                                if (channelsData) {--}}
{{--                                    renderChannels(channelsData);--}}
{{--                                }--}}

{{--                                $('.header__btn.channels.btn').on('click', function() {--}}
{{--                                    const $channelList = $(this).closest('.dropdown').find('.channel-list');--}}
{{--                                    const $loadingIndicator = $channelList.find('.loading-channels');--}}

{{--                                    // Clear previous results except current channel--}}
{{--                                    $channelList.children().not(':first').remove();--}}

{{--                                    // If we have valid cached data, use it--}}
{{--                                    if (channelsData && channelsData.timestamp > Date.now() - 300000) { // 5 minute cache--}}
{{--                                        renderChannels(channelsData);--}}
{{--                                        return;--}}
{{--                                    }--}}

{{--                                    // Prevent duplicate requests--}}
{{--                                    if (isChecking) {--}}
{{--                                        $loadingIndicator.show();--}}
{{--                                        return;--}}
{{--                                    }--}}

{{--                                    // Start new check--}}
{{--                                    isChecking = true;--}}
{{--                                    $loadingIndicator.show();--}}

{{--                                    $.ajax({--}}
{{--                                        url: '{{ route("admin.check.channels") }}',--}}
{{--                                        method: 'POST',--}}
{{--                                        headers: {--}}
{{--                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
{{--                                        },--}}
{{--                                        success: function (response) {--}}
{{--                                            channelsData = {--}}
{{--                                                data: response.validChannels || [],--}}
{{--                                                timestamp: Date.now()--}}
{{--                                            };--}}
{{--                                            sessionStorage.setItem(storageKey, JSON.stringify(channelsData));--}}
{{--                                            renderChannels(channelsData);--}}
{{--                                        },--}}
{{--                                        error: function () {--}}
{{--                                            $channelList.append('<div class="text-danger">Failed to load channels. Try again later.</div>');--}}
{{--                                        },--}}
{{--                                        complete: function() {--}}
{{--                                            isChecking = false;--}}
{{--                                            $loadingIndicator.hide();--}}
{{--                                        }--}}
{{--                                    });--}}
{{--                                });--}}

{{--                                function renderChannels(data) {--}}
{{--                                    const $channelList = $('.channel-list');--}}
{{--                                    const currentPath = window.location.pathname;--}}

{{--                                    $channelList.children().not(':first').remove();--}}

{{--                                    if (!data.data || !data.data.length) {--}}
{{--                                        $channelList.append('<div class="text-muted">No additional channels found.</div>');--}}
{{--                                        return;--}}
{{--                                    }--}}

{{--                                    @php--}}
{{--                                        $server_url = '/crm-development';--}}
{{--                                        if (app()->environment('development')) {--}}
{{--                                            $server_url = '/crm-development';--}}
{{--                                        }--}}
{{--                                    @endphp--}}
{{--                                    data.data.forEach((channel, index) => {--}}
{{--                                        const listItem = `--}}
{{--                    <div class="list-group-item py-1" style="display:none;">--}}
{{--                        <a href="https://${channel.domain}.com{{$server_url}}${currentPath}" target="_blank"--}}
{{--                           class="text-decoration-none text-primary fw-bold">--}}
{{--                            ${channel.name}--}}
{{--                        </a>--}}
{{--                    </div>`;--}}
{{--                                        const $item = $(listItem);--}}
{{--                                        $channelList.append($item);--}}
{{--                                        $item.fadeIn(150 * (index + 1));--}}
{{--                                    });--}}
{{--                                }--}}
{{--                            });--}}
{{--                        </script>--}}
{{--                    @endpush--}}


{{--                    <!-- Channel Dropdown -->--}}
{{--                    <div class="dropdown">--}}

{{--                        <!-- Toggler -->--}}
{{--                        <button class="header__btn channels btn" type="button" data-bs-toggle="dropdown"--}}
{{--                                aria-label="Channel dropdown" aria-expanded="false">--}}
{{--                        <span class="d-block position-relative">--}}
{{--                           @php--}}
{{--                               $host = $_SERVER['HTTP_HOST'];--}}
{{--                               $host = preg_replace('/^www\./', '', $host);--}}
{{--                               $parts = explode('.', $host);--}}
{{--                               if (count($parts) >= 2) {--}}
{{--                                   $mainDomain = $parts[count($parts) - 2];--}}
{{--                               } else {--}}
{{--                                   $mainDomain = $host;--}}
{{--                               }--}}
{{--                               $channels = [--}}
{{--                                   'payusinginvoice' => 'Channel 1',--}}
{{--                                   'paymentbyinvoice' => 'Channel 2',--}}
{{--                                   'paymentviainvoice' => 'Channel 3',--}}
{{--                                   'paythroughinvoice' => 'Channel 4',--}}
{{--                                   'payviainvoice' => 'Channel 5',--}}
{{--                                   'localhost:8000' => 'Channel 00',--}}
{{--                               ];--}}
{{--                                if (array_key_exists($mainDomain, $channels)) {--}}
{{--                                   echo $channels[$mainDomain];--}}
{{--                                }--}}
{{--                           @endphp--}}

{{--                               <!-- Set custom Channel count -->--}}
{{--                        </span>--}}
{{--                        </button>--}}


{{--                        --}}{{--                        <!-- Channel dropdown menu -->--}}
{{--                        --}}{{--                        <div class="dropdown-menu dropdown-menu-end w-md-300px">--}}
{{--                        --}}{{--                            <div class="border-bottom px-3 py-2 mb-3">--}}
{{--                        --}}{{--                                <h5>Channels</h5>--}}
{{--                        --}}{{--                            </div>--}}


{{--                        --}}{{--                            <div class="list-group list-group-borderless">--}}

{{--                        --}}{{--                                <!-- List item -->--}}
{{--                        --}}{{--                                <div class="list-group-item list-group-item-action d-flex align-items-start mb-3">--}}
{{--                        --}}{{--                                    <div class="flex-shrink-0 me-3">--}}
{{--                        --}}{{--                                        <img class="img-xs rounded-circle"--}}
{{--                        --}}{{--                                             src="{{asset('assets/themes/nifty/assets/img/profile-photos/3.png')}}"--}}
{{--                        --}}{{--                                             alt="Profile Picture" loading="lazy">--}}
{{--                        --}}{{--                                    </div>--}}
{{--                        --}}{{--                                    <div class="flex-grow-1">--}}
{{--                        --}}{{--                                        <a href="#"--}}
{{--                        --}}{{--                                           class="h6 fw-normal d-block mb-0 stretched-link text-decoration-none">Jackson--}}
{{--                        --}}{{--                                            Sent you a message</a>--}}
{{--                        --}}{{--                                        <small class="text-body-secondary">1 hours ago</small>--}}
{{--                        --}}{{--                                    </div>--}}
{{--                        --}}{{--                                </div>--}}
{{--                        --}}{{--                            </div>--}}
{{--                        --}}{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- End - Channel dropdown -->--}}

{{--                    @push('script')--}}
{{--                        <script>--}}
{{--                            $(document).ready(function () {--}}
{{--                                $(".header__btn.channels.btn").on("click", function () {--}}
{{--                                    const $dropdownBtn = $('.header__btn.channels.btn > span.d-block');--}}
{{--                                    const $dropdownMenu = $('.dropdown-menu');--}}

{{--                                    // Clear existing channel name in button while loading--}}
{{--                                    $dropdownBtn.text('Loading channels...');--}}

{{--                                    // Send AJAX POST to check-channels endpoint--}}
{{--                                    $.ajax({--}}
{{--                                        url: '{{ route("check.channels") }}',--}}
{{--                                        method: 'POST',--}}
{{--                                        headers: {--}}
{{--                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
{{--                                        },--}}
{{--                                        data: {email: `{{auth()->user()->email}}`, 'type': 999},--}}
{{--                                        success: function (channels) {--}}
{{--                                            if (channels.length === 0) {--}}
{{--                                                $dropdownBtn.text('');--}}
{{--                                                return;--}}
{{--                                            }--}}
{{--                                            $dropdownBtn.text(channels[0].name);--}}
{{--                                            const $listGroup = $dropdownMenu.find('.list-group');--}}
{{--                                            $listGroup.empty();--}}
{{--                                            $.each(channels, function (i, channel) {--}}
{{--                                                const listItem = `--}}
{{--                <div class="list-group-item list-group-item-action d-flex align-items-start mb-3" style="display:none;">--}}
{{--                    <div class="flex-shrink-0 me-3">--}}
{{--                        <img class="img-xs rounded-circle"--}}
{{--                             src="{{ asset('assets/themes/nifty/assets/img/profile-photos/3.png') }}"--}}
{{--                             alt="Channel Icon" loading="lazy">--}}
{{--                    </div>--}}
{{--                    <div class="flex-grow-1">--}}
{{--                        <a href="https://${channel.domain}.com" target="_blank"--}}
{{--                           class="h6 fw-normal d-block mb-0 stretched-link text-decoration-none">${channel.name}</a>--}}
{{--                        <small class="text-body-secondary">Visit channel</small>--}}
{{--                    </div>--}}
{{--                </div>`;--}}
{{--                                                const $item = $(listItem);--}}
{{--                                                $listGroup.append($item);--}}
{{--                                                $item.fadeIn(600 + i * 200);--}}
{{--                                            });--}}
{{--                                        },--}}
{{--                                        error: function () {--}}
{{--                                            $dropdownBtn.text('Error loading channels');--}}
{{--                                        }--}}
{{--                                    });--}}
{{--                                });--}}
{{--                            });--}}
{{--                        </script>--}}
{{--                    @endpush--}}


                    <div class="vr mx-1 d-none d-md-block"></div>

                    <!-- Sidebar Toggler -->
                    <button class="sidebar-toggler header__btn btn btn-icon btn-sm" type="button"
                            aria-label="Sidebar button" disabled>
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
    @include('admin.layouts.navigation')
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- END - MAIN NAVIGATION -->


    <!-- SIDEBAR -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <aside class="sidebar">
        <div class="sidebar__inner scrollable-content">


            <!-- This element is only visible when sidebar Stick mode is active. -->
            <div class="sidebar__stuck align-items-center mb-3 px-3">
                <button type="button" class="sidebar-toggler btn-close btn-lg rounded-circle"
                        aria-label="Close"></button>
                <p class="m-0 text-danger fw-bold">&lt;= Close the sidebar</p>
            </div>


            <!-- Sidebar tabs nav -->
            <div class="sidebar__wrap">
                <nav>
                    <div class="nav nav-underline nav-fill nav-component flex-nowrap border-bottom" id="nav-tab"
                         role="tablist">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#nav-chat" type="button"
                                role="tab" aria-controls="nav-chat" aria-selected="true">
                            <i class="d-block demo-pli-speech-bubble-5 fs-3 mb-2"></i>
                            <span>Chat</span>
                        </button>

                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#nav-reports" type="button"
                                role="tab" aria-controls="nav-reports" aria-selected="false">
                            <i class="d-block demo-pli-information fs-3 mb-2"></i>
                            <span>Reports</span>
                        </button>

                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#nav-settings" type="button"
                                role="tab" aria-controls="nav-settings" aria-selected="false">
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
                <div id="nav-chat" class="tab-pane fade py-4 show active" role="tabpanel"
                     aria-labelledby="nav-chat-tab">

                    <!-- Family list group -->
                    <h5 class="px-3">Family</h5>
                    <div class="list-group list-group-borderless">

                        <div class="list-group-item list-group-item-action d-flex align-items-start mb-2">
                            <div class="flex-shrink-0 me-3">
                                <img class="img-xs rounded-circle"
                                     src="{{asset('assets/themes/nifty/assets/img/profile-photos/2.png')}}"
                                     alt="Profile Picture"
                                     loading="lazy">
                            </div>
                            <div class="flex-grow-1 ">
                                <a href="#" class="h6 d-block mb-0 stretched-link text-decoration-none">Stephen Tran</a>
                                <small class="text-body-secondary">Available</small>
                            </div>
                        </div>


                        <div class="list-group-item list-group-item-action d-flex align-items-start mb-2">
                            <div class="flex-shrink-0 me-3">
                                <img class="img-xs rounded-circle"
                                     src="{{asset('assets/themes/nifty/assets/img/profile-photos/8.png')}}"
                                     alt="Profile Picture" loading="lazy">
                            </div>
                            <div class="flex-grow-1 ">
                                <a href="#" class="h6 d-block mb-0 stretched-link text-decoration-none">Betty Murphy</a>
                                <small class="text-body-secondary">Iddle</small>
                            </div>
                        </div>


                        <div class="list-group-item list-group-item-action d-flex align-items-start mb-2">
                            <div class="flex-shrink-0 me-3">
                                <img class="img-xs rounded-circle"
                                     src="{{asset('assets/themes/nifty/assets/img/profile-photos/7.png')}}"
                                     alt="Profile Picture"
                                     loading="lazy">
                            </div>
                            <div class="flex-grow-1 ">
                                <a href="#" class="h6 d-block mb-0 stretched-link text-decoration-none">Brittany
                                    Meyer</a>
                                <small class="text-body-secondary">I think so!</small>
                            </div>
                        </div>


                        <div class="list-group-item list-group-item-action d-flex align-items-start mb-2">
                            <div class="flex-shrink-0 me-3">
                                <img class="img-xs rounded-circle"
                                     src="{{asset('assets/themes/nifty/assets/img/profile-photos/4.png')}}"
                                     alt="Profile Picture"
                                     loading="lazy">
                            </div>
                            <div class="flex-grow-1 ">
                                <a href="#" class="h6 d-block mb-0 stretched-link text-decoration-none">Jack George</a>
                                <small class="text-body-secondary">Last seen 2 hours ago</small>
                            </div>
                        </div>

                    </div>
                    <!-- End - Family list group -->


                    <!-- Friends Group -->
                    <h5 class="d-flex mt-5 px-3">Friends <span class="badge bg-success ms-auto">587 +</span></h5>
                    <div class="list-group list-group-borderless">
                        <a href="#" class="list-group-item list-group-item-action">
                            <span class="d-inline-block bg-success rounded-circle p-1 me-2"></span>
                            Joey K. Greyson
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <span class="d-inline-block bg-info rounded-circle p-1 me-2"></span>
                            Andrea Branden
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <span class="d-inline-block bg-warning rounded-circle p-1 me-2"></span>
                            Johny Juan
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <span class="d-inline-block bg-secondary rounded-circle p-1 me-2"></span>
                            Susan Sun
                        </a>
                    </div>
                    <!-- End - Friends Group -->


                    <!-- Simple news widget -->
                    <div class="p-3 mt-5 rounded bg-info-subtle text-info-emphasis">
                        <h5 class="text-info-emphasis">News</h5>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui consequatur ipsum porro a
                            repellat eaque exercitationem necessitatibus esse voluptate corporis.</p>
                        <small class="fst-italic">Last Update : Today 13:54</small>
                    </div>
                    <!-- End - Simple news widget -->

                </div>
                <!-- End - Chat tab content -->


                <!-- Reports tab content -->
                <div id="nav-reports" class="tab-pane fade py-4" role="tabpanel" aria-labelledby="nav-reports-tab">

                    <!-- Billing and Resports -->
                    <div class="px-3">
                        <h5 class="mb-3">Billing &amp; Reports</h5>
                        <p>Get <span class="badge bg-danger">$15.00 off</span> your next bill by making sure your full
                            payment reaches us before August 5th.</p>

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
                        <p class="h5 mb-0"> (415) 234-53454 </p>
                        <small><em>We are here 24/7</em></small>
                    </div>
                    <!-- End - Contact widget -->

                </div>
                <!-- End - Reports tab content -->


                <!-- Settings content -->
                <div id="nav-settings" class="tab-pane fade py-4" role="tabpanel" aria-labelledby="nav-settings-tab">

                    <!-- Account settings -->
                    <h5 class="px-3">Account Settings</h5>
                    <div class="list-group list-group-borderless">

                        <div class="list-group-item mb-1">
                            <div class="d-flex justify-content-between mb-1">
                                <label class="form-check-label text-body-emphasis stretched-link"
                                       for="_dm-sbPersonalStatus">Show my personal status</label>
                                <div class="form-check form-switch">
                                    <input id="_dm-sbPersonalStatus" class="form-check-input" type="checkbox" checked>
                                </div>
                            </div>
                            <small class="text-body-secondary">Lorem ipsum dolor sit amet, consectetuer adipiscing
                                elit.</small>
                        </div>

                        <div class="list-group-item mb-1">
                            <div class="d-flex justify-content-between mb-1">
                                <label class="form-check-label text-body-emphasis stretched-link"
                                       for="_dm-sbOfflineContact">Show offline contact</label>
                                <div class="form-check form-switch">
                                    <input id="_dm-sbOfflineContact" class="form-check-input" type="checkbox">
                                </div>
                            </div>
                            <small class="text-body-secondary">Aenean commodo ligula eget dolor. Aenean massa.</small>
                        </div>

                        <div class="list-group-item mb-1">
                            <div class="d-flex justify-content-between mb-1">
                                <label class="form-check-label text-body-emphasis stretched-link"
                                       for="_dm-sbInvisibleMode">Invisible Mode</label>
                                <div class="form-check form-switch">
                                    <input id="_dm-sbInvisibleMode" class="form-check-input" type="checkbox">
                                </div>
                            </div>
                            <small class="text-body-secondary">Cum sociis natoque penatibus et magnis dis parturient
                                montes, nascetur ridiculus mus.</small>
                        </div>

                    </div>
                    <!-- End - Account settings -->


                    <!-- Public Settings -->
                    <h5 class="mt-5 px-3">Public Settings</h5>
                    <div class="list-group list-group-borderless">

                        <div class="list-group-item d-flex justify-content-between mb-1">
                            <label class="form-check-label" for="_dm-sbOnlineStatus">Online Status</label>
                            <div class="form-check form-switch">
                                <input id="_dm-sbOnlineStatus" class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>

                        <div class="list-group-item d-flex justify-content-between mb-1">
                            <label class="form-check-label" for="_dm-sbMuteNotifications">Mute Notifications</label>
                            <div class="form-check form-switch">
                                <input id="_dm-sbMuteNotifications" class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>

                        <div class="list-group-item d-flex justify-content-between mb-1">
                            <label class="form-check-label" for="_dm-sbMyDevicesName">Show my device name</label>
                            <div class="form-check form-switch">
                                <input id="_dm-sbMyDevicesName" class="form-check-input" type="checkbox" checked>
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
    <a href="javascript:void(0)" class="scroll-page ratio ratio-1x1" aria-label="Scroll button"></a>
</div>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- END - SCROLL TO TOP BUTTON -->


<!-- BOXED LAYOUT : BACKGROUND IMAGES CONTENT [ DEMO ] -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<div id="_dm-boxedBgContent" class="_dm-boxbg offcanvas offcanvas-bottom" data-bs-scroll="true" tabindex="-1">
    <div class="offcanvas-body px-4">

        <!-- Content Header -->
        <div class="offcanvas-header border-bottom p-0 pb-3">
            <div>
                <h4 class="offcanvas-title">Background Images</h4>
                <span class="text-body-secondary">Add an image to replace the solid background color</span>
            </div>
            <button type="button" class="btn-close btn-lg text-reset shadow-none" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
        </div>
        <!-- End - Content header -->


        <!-- Collection Of Images -->
        <div id="_dm-boxedBgContainer" class="row mt-3">

            <!-- Blurred Background Images -->
            <div class="col-lg-4">
                <h5 class="mb-2">Blurred</h5>
                <div class="_dm-boxbg__img-container d-flex flex-wrap">
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/1.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/2.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/3.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/4.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/5.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/6.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/7.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/8.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/9.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/10.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/11.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/12.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/13.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/14.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/15.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/blurred/thumbs/16.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                </div>
            </div>
            <!-- End - Blurred Background Images -->


            <!-- Polygon Background Images -->
            <div class="col-lg-4">
                <h5 class="mb-2">Polygon &amp; Geometric</h5>
                <div class="_dm-boxbg__img-container d-flex flex-wrap mb-4">
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/1.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/2.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/3.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/4.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/5.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/6.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/7.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/8.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/9.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/10.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/11.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/12.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/13.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/14.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/15.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/polygon/thumbs/16.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                </div>
            </div>
            <!-- End - Polygon Background Images -->


            <!-- Abstract Background Images -->
            <div class="col-lg-4">
                <h5 class="mb-2">Abstract</h5>
                <div class="_dm-boxbg__img-container d-flex flex-wrap">
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/1.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/2.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/3.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/4.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/5.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/6.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/7.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/8.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/9.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/10.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/11.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/12.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/13.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/14.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/15.jpg')}}"
                             alt="Background Image" loading="lazy">
                    </a>
                    <a href="#" class="_dm-boxbg__thumb ratio ratio-16x9">
                        <img class="img-responsive"
                             src="{{asset('assets/themes/nifty/assets/premium/boxed-bg/abstract/thumbs/16.jpg')}}"
                             alt="Background Image" loading="lazy">
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
<div id="_dm-settingsContainer" class="_dm-settings-container offcanvas offcanvas-end rounded-start" tabindex="-1">
    <button id="_dm-settingsToggler"
            class="_dm-btn-settings btn btn-sm btn-primary p-2 rounded-0 rounded-start shadow-none" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#_dm-settingsContainer" aria-label="Customization button"
            aria-controls="#_dm-settingsContainer">
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
                        <label class="form-check-label flex-fill" for="_dm-fluidLayoutRadio">Fluid Layout</label>
                        <div class="form-check form-switch">
                            <input id="_dm-fluidLayoutRadio" class="form-check-input ms-0" type="radio"
                                   name="settingLayouts" autocomplete="off" checked>
                        </div>
                    </div>


                    <!-- OPTION : Boxed layout -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label class="form-check-label flex-fill" for="_dm-boxedLayoutRadio">Boxed Layout</label>
                        <div class="form-check form-switch">
                            <input id="_dm-boxedLayoutRadio" class="form-check-input ms-0" type="radio"
                                   name="settingLayouts" autocomplete="off">
                        </div>
                    </div>


                    <!-- OPTION : Boxed layout with background images -->
                    <div id="_dm-boxedBgOption" class="opacity-50 d-flex align-items-center pt-1 mb-2">
                        <label class="form-label flex-fill mb-0">BG for Boxed Layout</label>

                        <button id="_dm-boxedBgBtn" class="btn btn-icon btn-primary btn-xs" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#_dm-boxedBgContent" disabled>
                            <i class="demo-psi-dot-horizontal"></i>
                        </button>
                    </div>


                    <!-- OPTION : Centered Layout -->
                    <div class="d-flex align-items-start pt-1 pb-3 mb-2">
                        <label class="form-check-label flex-fill text-nowrap" for="_dm-centeredLayoutRadio">Centered
                            Layout</label>
                        <div class="form-check form-switch">
                            <input id="_dm-centeredLayoutRadio" class="form-check-input ms-0" type="radio"
                                   name="settingLayouts" autocomplete="off">
                        </div>
                    </div>


                    <!-- OPTION : Transition timing -->
                    <h6 class="mt-4 mb-2 py-1">Transitions</h6>
                    <div class="d-flex align-items-center pt-1 pb-3 mb-2">
                        <select id="_dm-transitionSelect" class="form-select" aria-label="select transition timing">
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
                        <label class="form-check-label flex-fill" for="_dm-stickyHeaderCheckbox">Sticky header</label>
                        <div class="form-check form-switch">
                            <input id="_dm-stickyHeaderCheckbox" class="form-check-input ms-0" type="checkbox"
                                   autocomplete="off" checked>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-md btn-primary">Save</button>

                    <!-- OPTION : Additional Offcanvas -->
                    {{--                <h6 class="mt-4 mb-2 py-1">Additional Offcanvas</h6>--}}
                    {{--                <p>Select the offcanvas placement.</p>--}}
                    {{--                <div class="text-nowrap">--}}
                    {{--                    <button type="button" class="_dm-offcanvasBtn btn btn-sm btn-primary" value="offcanvas-top">Top--}}
                    {{--                    </button>--}}
                    {{--                    <button type="button" class="_dm-offcanvasBtn btn btn-sm btn-primary" value="offcanvas-end">Right--}}
                    {{--                    </button>--}}
                    {{--                    <button type="button" class="_dm-offcanvasBtn btn btn-sm btn-primary" value="offcanvas-bottom">Btm--}}
                    {{--                    </button>--}}
                    {{--                    <button type="button" class="_dm-offcanvasBtn btn btn-sm btn-primary" value="offcanvas-start">Left--}}
                    {{--                    </button>--}}
                    {{--                </div>--}}


                </div>
                <div class="col-lg-3 p-4 bg-body">

                    <h4 class="fw-bold pb-3 mb-2">Sidebars</h4>


                    <!-- OPTION : Sticky Navigation -->
                    <h6 class="mb-2 pb-1">Navigation</h6>
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label class="form-check-label flex-fill" for="_dm-stickyNavCheckbox">Sticky navigation</label>
                        <div class="form-check form-switch">
                            <input id="_dm-stickyNavCheckbox" class="form-check-input ms-0" type="checkbox"
                                   autocomplete="off" checked>
                        </div>
                    </div>


                    <!-- OPTION : Navigation Profile Widget -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label class="form-check-label flex-fill" for="_dm-profileWidgetCheckbox">Widget Profile</label>
                        <div class="form-check form-switch">
                            <input id="_dm-profileWidgetCheckbox" class="form-check-input ms-0 enabled" type="checkbox"
                                   autocomplete="off">
                        </div>
                    </div>


                    <!-- OPTION : Mini navigation mode -->
                    <div class="d-flex align-items-center pt-3 mb-2">
                        <label class="form-check-label flex-fill" for="_dm-miniNavRadio">Min / Collapsed Mode</label>
                        <div class="form-check form-switch">
                            <input id="_dm-miniNavRadio" class="form-check-input ms-0" type="radio"
                                   name="navigation-mode"
                                   autocomplete="off">
                        </div>
                    </div>


                    <!-- OPTION : Maxi navigation mode -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label class="form-check-label flex-fill" for="_dm-maxiNavRadio">Max / Expanded Mode</label>
                        <div class="form-check form-switch">
                            <input id="_dm-maxiNavRadio" class="form-check-input ms-0" type="radio"
                                   name="navigation-mode"
                                   autocomplete="off" checked>
                        </div>
                    </div>


                    <!-- OPTION : Push navigation mode -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label class="form-check-label flex-fill" for="_dm-pushNavRadio">Push Mode</label>
                        <div class="form-check form-switch">
                            <input id="_dm-pushNavRadio" class="form-check-input ms-0" type="radio"
                                   name="navigation-mode"
                                   autocomplete="off">
                        </div>
                    </div>


                    <!-- OPTION : Slide on top navigation mode -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label class="form-check-label flex-fill" for="_dm-slideNavRadio">Slide on top</label>
                        <div class="form-check form-switch">
                            <input id="_dm-slideNavRadio" class="form-check-input ms-0" type="radio"
                                   name="navigation-mode"
                                   autocomplete="off">
                        </div>
                    </div>


                    <!-- OPTION : Slide on top navigation mode -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label class="form-check-label flex-fill" for="_dm-revealNavRadio">Reveal Mode</label>
                        <div class="form-check form-switch">
                            <input id="_dm-revealNavRadio" class="form-check-input ms-0" type="radio"
                                   name="navigation-mode"
                                   autocomplete="off">
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between gap-3 py-3">
                        <button class="nav-toggler btn btn-primary btn-sm" type="button">
                            Navigation
                        </button>
                        <button class="sidebar-toggler btn btn-primary btn-sm" type="button">
                            Sidebar
                        </button>
                    </div>


                    <h6 class="mt-3 mb-2 py-1">Sidebar</h6>


                    <!-- OPTION : Disable sidebar backdrop -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label class="form-check-label flex-fill" for="_dm-disableBackdropCheckbox">Disable
                            backdrop</label>
                        <div class="form-check form-switch">
                            <input id="_dm-disableBackdropCheckbox" class="form-check-input ms-0" type="checkbox"
                                   autocomplete="off">
                        </div>
                    </div>


                    <!-- OPTION : Static position -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label class="form-check-label flex-fill" for="_dm-staticSidebarCheckbox">Static
                            position</label>
                        <div class="form-check form-switch">
                            <input id="_dm-staticSidebarCheckbox" class="form-check-input ms-0" type="checkbox"
                                   autocomplete="off">
                        </div>
                    </div>


                    <!-- OPTION : Stuck sidebar -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label class="form-check-label flex-fill" for="_dm-stuckSidebarCheckbox">Stuck Sidebar </label>
                        <div class="form-check form-switch">
                            <input id="_dm-stuckSidebarCheckbox" class="form-check-input ms-0" type="checkbox"
                                   autocomplete="off">
                        </div>
                    </div>


                    <!-- OPTION : Unite Sidebar -->
                    <div class="d-flex align-items-center pt-1 mb-2">
                        <label class="form-check-label flex-fill" for="_dm-uniteSidebarCheckbox">Unite Sidebar</label>
                        <div class="form-check form-switch">
                            <input id="_dm-uniteSidebarCheckbox" class="form-check-input ms-0" type="checkbox"
                                   autocomplete="off">
                        </div>
                    </div>


                    <!-- OPTION : Pinned Sidebar -->
                    <div class="d-flex align-items-start pt-1 mb-2">
                        <label class="form-check-label flex-fill" for="_dm-pinnedSidebarCheckbox">Pinned Sidebar</label>
                        <div class="form-check form-switch">
                            <input id="_dm-pinnedSidebarCheckbox" class="form-check-input ms-0" type="checkbox"
                                   autocomplete="off">
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 p-4">
                    <h4 class="fw-bold pb-3 mb-2">Colors</h4>

                    <div class="d-flex mb-4 pb-4">
                        <div class="d-flex flex-column">
                            <h5 class="h6">Modes</h5>
                            <div class="form-check form-check-alt form-switch">
                                <input id="settingsThemeToggler" class="form-check-input mode-switcher" type="checkbox"
                                       role="switch">
                                <label class="form-check-label ps-3 fw-bold d-none d-md-flex align-items-center "
                                       for="settingsThemeToggler">
                                    <i class="mode-switcher-icon icon-light demo-psi-sun fs-3"></i>
                                    <i class="mode-switcher-icon icon-dark d-none demo-psi-half-moon fs-5"></i>
                                </label>
                            </div>
                        </div>
                        <div class="vr mx-4"></div>
                        <div class="_dm-colorSchemesMode__colors">
                            <h5 class="h6">Color Schemes</h5>
                            <div id="dm_colorSchemesContainer" class="d-flex flex-wrap justify-content-center">
                                <button class="_dm-colorSchemes _dm-box-xs _dm-bg-gray" type="button"
                                        data-color="gray"></button>
                                <button class="_dm-colorSchemes _dm-box-xs _dm-bg-navy" type="button"
                                        data-color="navy"></button>
                                <button class="_dm-colorSchemes _dm-box-xs _dm-bg-ocean" type="button"
                                        data-color="ocean"></button>
                                <button class="_dm-colorSchemes _dm-box-xs _dm-bg-lime" type="button"
                                        data-color="lime"></button>

                                <button class="_dm-colorSchemes _dm-box-xs _dm-bg-violet" type="button"
                                        data-color="violet"></button>
                                <button class="_dm-colorSchemes _dm-box-xs _dm-bg-orange" type="button"
                                        data-color="orange"></button>
                                <button class="_dm-colorSchemes _dm-box-xs _dm-bg-teal" type="button"
                                        data-color="teal"></button>
                                <button class="_dm-colorSchemes _dm-box-xs _dm-bg-corn" type="button"
                                        data-color="corn"></button>

                                <button class="_dm-colorSchemes _dm-box-xs _dm-bg-cherry" type="button"
                                        data-color="cherry"></button>
                                <button class="_dm-colorSchemes _dm-box-xs _dm-bg-coffee" type="button"
                                        data-color="coffee"></button>
                                <button class="_dm-colorSchemes _dm-box-xs _dm-bg-pear" type="button"
                                        data-color="pear"></button>
                                <button class="_dm-colorSchemes _dm-box-xs _dm-bg-night" type="button"
                                        data-color="night"></button>
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
                                    <button type="button" class="_dm-colorModeBtn btn p-1 shadow-none"
                                            data-color-mode="tm--expanded-hd">
                                        <img
                                            src="{{asset('assets/themes/nifty/assets/img/color-schemes/expanded-header.png')}}"
                                            alt="color scheme illusttration" loading="lazy">
                                    </button>

                                </div>
                            </div>


                            <!-- Fair Header -->
                            <div class="col-md-4">
                                <h6 class="m-0">Fair Header</h6>
                                <div class="_dm-colorShcemesMode">

                                    <!-- Scheme Button -->
                                    <button type="button" class="_dm-colorModeBtn btn p-1 shadow-none"
                                            data-color-mode="tm--fair-hd">
                                        <img
                                            src="{{asset('assets/themes/nifty/assets/img/color-schemes/fair-header.png')}}"
                                            alt="color scheme illusttration" loading="lazy">
                                    </button>

                                </div>
                            </div>


                            <div class="col-md-4">
                                <h6 class="m-0">Full Header</h6>

                                <div class="_dm-colorShcemesMode">

                                    <!-- Scheme Button -->
                                    <button type="button" class="_dm-colorModeBtn btn p-1 shadow-none"
                                            data-color-mode="tm--full-hd">
                                        <img
                                            src="{{asset('assets/themes/nifty/assets/img/color-schemes/full-header.png')}}"
                                            alt="color scheme illusttration" loading="lazy">
                                    </button>

                                </div>
                            </div>
                        </div>


                        <div class="row text-center mb-2">
                            <div class="col-md-4">
                                <h6 class="m-0">Primary Nav</h6>

                                <div class="_dm-colorShcemesMode">

                                    <!-- Scheme Button -->
                                    <button type="button" class="_dm-colorModeBtn btn p-1 shadow-none"
                                            data-color-mode="tm--primary-mn">
                                        <img
                                            src="{{asset('assets/themes/nifty/assets/img/color-schemes/navigation.png')}}"
                                            alt="color scheme illusttration" loading="lazy">
                                    </button>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <h6 class="m-0">Brand</h6>

                                <div class="_dm-colorShcemesMode">

                                    <!-- Scheme Button -->
                                    <button type="button" class="_dm-colorModeBtn btn p-1 shadow-none"
                                            data-color-mode="tm--primary-brand">
                                        <img src="{{asset('assets/themes/nifty/assets/img/color-schemes/brand.png')}}"
                                             alt="color scheme illusttration" loading="lazy">
                                    </button>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <h6 class="m-0">Tall Header</h6>
                                <div class="_dm-colorShcemesMode">

                                    <!-- Scheme Button -->
                                    <button type="button" class="_dm-colorModeBtn btn p-1 shadow-none"
                                            data-color-mode="tm--tall-hd">
                                        <img
                                            src="{{asset('assets/themes/nifty/assets/img/color-schemes/tall-header.png')}}"
                                            alt="color scheme illusttration" loading="lazy">
                                    </button>

                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="pt-3">

                        <h5 class="fw-bold mt-2">Miscellaneous</h5>

                        <div class="d-flex gap-3 my-3">
                            <label for="_dm-fontSizeRange" class="form-label flex-shrink-0 mb-0">Root Font sizes</label>
                            <div class="position-relative flex-fill">
                                <input type="range" class="form-range" min="9" max="19" step="1" value="16"
                                       id="_dm-fontSizeRange">
                                <output id="_dm-fontSizeValue" class="range-bubble"></output>
                            </div>
                        </div>

                        <h5 class="fw-bold mt-4">Scrollbars</h5>
                        <p class="mb-2">Hides native scrollbars and creates custom styleable overlay scrollbars.</p>
                        <div class="row">
                            <div class="col-5">

                                <!-- OPTION : Apply the OverlayScrollBar to the body. -->
                                <div class="d-flex align-items-center pt-1 mb-2">
                                    <label class="form-check-label flex-fill" for="_dm-bodyScrollbarCheckbox">Body
                                        scrollbar</label>
                                    <div class="form-check form-switch">
                                        <input id="_dm-bodyScrollbarCheckbox" class="form-check-input ms-0"
                                               type="checkbox"
                                               autocomplete="off">
                                    </div>
                                </div>


                                <!-- OPTION : Apply the OverlayScrollBar to content containing class .scrollable-content. -->
                                <div class="d-flex align-items-center pt-1 mb-2">
                                    <label class="form-check-label flex-fill" for="_dm-sidebarsScrollbarCheckbox">Navigation
                                        and Sidebar</label>
                                    <div class="form-check form-switch">
                                        <input id="_dm-sidebarsScrollbarCheckbox" class="form-check-input ms-0"
                                               type="checkbox" autocomplete="off">
                                    </div>
                                </div>

                            </div>
                            <div class="col-7">

                                <div class="alert alert-warning mb-0" role="alert">
                                    Please consider the performance impact of using any scrollbar plugin.
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
        <button type="button" class="btn-close btn-lg text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
    </div>

    <!-- Offcanvas content -->
    <div class="offcanvas-body">
        <h5>Content Here</h5>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente eos nihil earum aliquam quod in dolor,
            aspernatur obcaecati et at. Dicta, ipsum aut, fugit nam dolore porro non est totam sapiente animi recusandae
            obcaecati dolorum, rem ullam cumque. Illum quidem reiciendis autem neque excepturi odit est accusantium,
            facilis provident molestias, dicta obcaecati itaque ducimus fuga iure in distinctio voluptate nesciunt
            dignissimos rem error a. Expedita officiis nam dolore dolores ea. Soluta repellendus delectus culpa quo. Ea
            tenetur impedit error quod exercitationem ut ad provident quisquam omnis! Nostrum quasi ex delectus vero,
            facilis aut recusandae deleniti beatae. Qui velit commodi inventore.</p>
    </div>

</div>
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- END - OFFCANVAS [ DEMO ] -->


<!-- JAVASCRIPTS -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
@include('admin.layouts.script')
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- END - LAYOUT [ SCRIPT ] -->
@stack('script')
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
</body>
</html>

