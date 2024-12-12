<nav id="mainnav-container" class="mainnav">
    <div class="mainnav__inner">

        <!-- Navigation menu -->
        <div class="mainnav__top-content scrollable-content pb-5 pt-2">


            <!-- Profile Widget -->
            <div id="_dm-mainnavProfile" class="mainnav__widget my-3 hv-outline-parent d-none">

                <!-- Profile picture  -->
                <div class="mininav-toggle text-center py-2">
                    <img class="mainnav__avatar img-md rounded-circle hv-oc"
                         src="{{auth()->guard('web')->user()->image && file_exists(public_path('assets/images/employees/'.auth()->guard('web')->user()->image)) ? asset('assets/images/employees/'.auth()->guard('web')->user()->image) : asset('assets/themes/nifty/assets/img/profile-photos/2.png')}}"
                         alt="{{auth()->guard('web')->user()->name}}" title="Dashboard" loading="lazy">
                </div>
                <div class="mininav-content collapse d-mn-max">
                    <span data-popper-arrow class="arrow"></span>
                    <div class="d-grid">

                        <!-- User name and position -->
                        <button class="mainnav-widget-toggle d-block btn border-0 p-2" data-bs-toggle="collapse"
                                data-bs-target="#usernav" aria-expanded="false" aria-controls="usernav">
                           <span class="dropdown-toggle d-flex justify-content-center align-items-center">
                              <h5 class="mb-0 me-3">{{auth()->guard('web')->user()->name}}</h5>
                           </span>
                            <small class="text-body-secondary">{{auth()->guard('web')->user()->designation}}</small>
                        </button>


                        <!-- Collapsed user menu -->
                        <div id="usernav" class="nav flex-column collapse">
                            <a href="#" class="nav-link d-flex justify-content-between align-items-center">
                                    <span><i class="demo-pli-mail fs-5 me-2"></i><span
                                            class="ms-1">Messages</span></span>
                                <span class="badge bg-danger rounded-pill">14</span>
                            </a>
                            <a href="#" class="nav-link">
                                <i class="demo-pli-male fs-5 me-2"></i>
                                <span class="ms-1">Profile</span>
                            </a>
                            <a href="#" class="nav-link">
                                <i class="demo-pli-gear fs-5 me-2"></i>
                                <span class="ms-1">Settings</span>
                            </a>
                            <a href="#" class="nav-link">
                                <i class="demo-pli-computer-secure fs-5 me-2"></i>
                                <span class="ms-1">Lock screen</span>
                            </a>
                            <a class="nav-link" style="cursor: pointer;"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="demo-pli-unlock fs-5 me-2"></i>
                                <span class="ms-1">Logout</span>
                            </a>
                        </div>


                    </div>
                </div>

            </div>
            <!-- End - Profile widget -->


            <!-- Navigation Category Dashboard -->
            <div class="mainnav__categoriy pb-1 pt-3">
                {{--                    <h6 class="mainnav__caption mt-0 fw-bold">Navigation</h6>--}}
                <ul class="mainnav__menu nav flex-column">
                    <!-- Link with submenu -->
                    <li class="nav-item has-sub">
                        <a href="{{route('dashboard')}}" class="mininav-toggle nav-link collapsed"><i
                                class="demo-pli-home fs-5 me-2"></i>
                            <span class="nav-label ms-1">Dashboard</span>
                        </a>
                        <!-- Dashboard submenu list -->
                        <ul class="mininav-content nav collapse">
                            <li data-popper-arrow class="arrow"></li>
                            <li class="nav-item">
                                <a href="{{route('dashboard')}}" class="nav-link">Dashboard 1</a>
                            </li>
                        </ul>
                        <!-- END : Dashboard submenu list -->
                    </li>
                    <!-- END : Link with submenu -->

                    {{--                        <!-- Link with submenu -->--}}
                    {{--                        <li class="nav-item has-sub">--}}
                    {{--                            <a href="#" class="mininav-toggle nav-link collapsed"><i--}}
                    {{--                                    class="demo-pli-split-vertical-2 fs-5 me-2"></i>--}}
                    {{--                                <span class="nav-label ms-1">Layouts</span>--}}
                    {{--                            </a>--}}
                    {{--                            <!-- Layouts submenu list -->--}}
                    {{--                            <ul class="mininav-content nav collapse">--}}
                    {{--                                <li data-popper-arrow class="arrow"></li>--}}
                    {{--                                <li class="nav-item">--}}
                    {{--                                    <a href="../layouts/minimal-navigation/index.html" class="nav-link">Mini--}}
                    {{--                                        Navigation</a>--}}
                    {{--                                </li>--}}
                    {{--                                <li class="nav-item">--}}
                    {{--                                    <a href="../layouts/push-navigation/index.html" class="nav-link">Push Navigation</a>--}}
                    {{--                                </li>--}}
                    {{--                                <li class="nav-item">--}}
                    {{--                                    <a href="../layouts/slide-navigation/index.html" class="nav-link">Slide--}}
                    {{--                                        Navigation</a>--}}
                    {{--                                </li>--}}
                    {{--                                <li class="nav-item">--}}
                    {{--                                    <a href="../layouts/reveal-navigation/index.html" class="nav-link">Reveal--}}
                    {{--                                        Navigation</a>--}}
                    {{--                                </li>--}}
                    {{--                                <li class="nav-item">--}}
                    {{--                                    <a href="../layouts/stuck-sidebar/index.html" class="nav-link">Stuck Sidebar</a>--}}
                    {{--                                </li>--}}
                    {{--                                <li class="nav-item">--}}
                    {{--                                    <a href="../layouts/pinned-sidebar/index.html" class="nav-link">Pinned Sidebar</a>--}}
                    {{--                                </li>--}}
                    {{--                                <li class="nav-item">--}}
                    {{--                                    <a href="../layouts/unite-sidebar/index.html" class="nav-link">Unite Sidebar</a>--}}
                    {{--                                </li>--}}
                    {{--                                <li class="nav-item">--}}
                    {{--                                    <a href="../layouts/sticky-header/index.html" class="nav-link">Sticky Header</a>--}}
                    {{--                                </li>--}}
                    {{--                                <li class="nav-item">--}}
                    {{--                                    <a href="../layouts/sticky-navigation/index.html" class="nav-link">Sticky--}}
                    {{--                                        Navigation</a>--}}
                    {{--                                </li>--}}

                    {{--                            </ul>--}}
                    {{--                            <!-- END : Layouts submenu list -->--}}

                    {{--                        </li>--}}
                    {{--                        <!-- END : Link with submenu -->--}}

                    {{--                        <!-- Regular menu link -->--}}
                    {{--                        <li class="nav-item">--}}
                    {{--                            <a href="{{asset('assets/themes/nifty/widgets/index.html')}}" class="nav-link mininav-toggle"><i--}}
                    {{--                                    class="demo-pli-gear fs-5 me-2"></i>--}}

                    {{--                                <span class="nav-label mininav-content ms-1">--}}
                    {{--                              <span data-popper-arrow class="arrow"></span>--}}
                    {{--                              Widgets--}}
                    {{--                           </span>--}}
                    {{--                            </a>--}}
                    {{--                        </li>--}}
                    {{--                        <!-- END : Regular menu link -->--}}


                </ul>
            </div>
            <!-- END : Navigation Category -->


            <!-- Components Category Crm-->
            <div class="mainnav__categoriy py-1">

                <h6 class="mainnav__caption mt-0 fw-bold">CRM</h6>
                <ul class="mainnav__menu nav flex-column">
                    <!-- Link with submenu -->
                    <li class="nav-item has-sub">
                        <a href="#"
                           class="mininav-toggle nav-link collapsed {{ request()->is('companies*') ? 'active' : '' }}"><i
                                class="demo-pli-address-book fs-5 me-2"></i>
                            <span class="nav-label ms-1">Companies</span>
                        </a>
                        <!-- Ui Elements submenu list -->
                        <ul class="mininav-content nav collapse">
                            <li data-popper-arrow class="arrow"></li>
                            <li class="nav-item">
                                <a href="{{route('company.index')}}"
                                   class="nav-link {{ request()->is('companies*') ? 'active' : '' }}">Lists</a>
                            </li>
                        </ul>
                        <!-- END : Ui Elements submenu list -->
                    </li>
                    <li class="nav-item has-sub">
                        <a href="#"
                           class="mininav-toggle nav-link collapsed {{ request()->is('contacts*') ? 'active' : '' }}"><i
                                class="demo-pli-address-book fs-5 me-2"></i>
                            <span class="nav-label ms-1">Contacts</span>
                        </a>
                        <!-- Ui Elements submenu list -->
                        <ul class="mininav-content nav collapse">
                            <li data-popper-arrow class="arrow"></li>
                            <li class="nav-item">
                                <a href="{{route('contact.index')}}"
                                   class="nav-link {{ request()->is('contacts*') ? 'active' : '' }}">Lists</a>
                            </li>
                        </ul>
                        <!-- END : Ui Elements submenu list -->
                    </li>
                    <!-- END : Link with submenu -->
                </ul>
            </div>
            <!-- END : Components Category -->

            <!-- Server Status Category -->
            <div class="mainnav__widget">

                <!-- Widget buttton form small navigation -->
                <div class="mininav-toggle text-center py-2 d-mn-min">
                    <i class="demo-pli-monitor-2"></i>
                </div>

                <div class="d-mn-max mt-5"></div>

                <!-- Widget content -->
                <div class="mininav-content collapse d-mn-max">
                    <span data-popper-arrow class="arrow"></span>
                    <h6 class="mainnav__caption fw-bold">Server Status</h6>
                    <ul class="list-group list-group-borderless">
                        <li class="list-group-item text-reset">
                            <div class="d-flex justify-content-between align-items-start">
                                <p class="mb-2 me-auto">CPU Usage</p>
                                <span class="badge bg-info rounded">35%</span>
                            </div>
                            <div class="progress progress-md">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 35%"
                                     aria-label="CPU Progress" aria-valuenow="35" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </li>
                        <li class="list-group-item text-reset">
                            <div class="d-flex justify-content-between align-items-start">
                                <p class="mb-2 me-auto">Bandwidth</p>
                                <span class="badge bg-warning rounded">73%</span>
                            </div>
                            <div class="progress progress-md">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 73%"
                                     aria-label="Bandwidth Progress" aria-valuenow="73" aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </li>
                    </ul>
                    <div class="d-grid px-3 mt-3">
                        <a href="#" class="btn btn-sm btn-success">View Details</a>
                    </div>
                </div>
            </div>
            <!-- End : Server Status Category -->


        </div>
        <!-- End - Navigation menu -->


        <!-- Bottom navigation menu -->
        <div class="mainnav__bottom-content border-top pb-2">
            <ul id="mainnav" class="mainnav__menu nav flex-column">
                <li class="nav-item has-sub">
                    <button type="button" class="nav-link"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="demo-pli-unlock fs-5 me-2"></i>
                        <span class="nav-label ms-1">Logout</span>
                    </button>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form"
                          class="d-none">
                        @csrf
                    </form>
                    {{--                        <a href="#" class="nav-link mininav-toggle collapsed" aria-expanded="false">--}}
                    {{--                            <i class="demo-pli-unlock fs-5 me-2"></i>--}}
                    {{--                            <span class="nav-label ms-1">Logout</span>--}}
                    {{--                        </a>--}}
                    {{--                        <ul class="mininav-content nav flex-column collapse">--}}
                    {{--                            <li data-popper-arrow class="arrow"></li>--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="#" class="nav-link">This device only</a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="#" class="nav-link">All Devices</a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Lock screen</a>--}}
                    {{--                            </li>--}}
                    {{--                        </ul>--}}
                </li>
            </ul>
        </div>
        <!-- End - Bottom navigation menu -->


    </div>
</nav>
