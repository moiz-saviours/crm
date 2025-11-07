<nav id="mainnav-container" class="mainnav">
    <div class="mainnav__inner">

        <!-- Navigation menu -->
        <div class="mainnav__top-content scrollable-content pb-5 pt-2">


            <!-- Profile Widget -->
            <div id="_dm-mainnavProfile" class="mainnav__widget my-3 hv-outline-parent d-none">

                <!-- Profile picture  -->
                <div class="mininav-toggle text-center py-2">
                    <img class="mainnav__avatar img-md rounded-circle hv-oc profile-image"
                         style="background-color: var(--bs-secondary);"
                         src="{{auth()->guard('web')->user()->image ? (filter_var(auth()->guard('web')->user()->image, FILTER_VALIDATE_URL) ? auth()->guard('web')->user()->image : (file_exists(public_path('assets/images/employees/'.auth()->guard('web')->user()->image)) ? asset('assets/images/employees/'.auth()->guard('web')->user()->image) : asset('assets/themes/nifty/assets/img/profile-photos/2.png'))) : asset('assets/themes/nifty/assets/img/profile-photos/2.png')}}"
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
                        </button>
                        <div class="text-center pb-1">
                            <small class="text-body-secondary d-block">{{ auth()->guard('web')->user()->email }}</small>
                            <small
                                class="text-body-secondary d-block text-capitalize">{{ auth()->guard('web')->user()->designation }}</small>
                        </div>


                        <!-- Collapsed user menu -->
                        <div id="usernav" class="nav flex-column collapse">
                            {{--                            <a href="#" class="nav-link d-flex justify-content-between align-items-center">--}}
                            {{--                                    <span><i class="demo-pli-mail fs-5 me-2"></i><span--}}
                            {{--                                            class="ms-1">Messages</span></span>--}}
                            {{--                                <span class="badge bg-danger rounded-pill">14</span>--}}
                            {{--                            </a>--}}
                            <a href="{{route('user.profile')}}" class="nav-link">
                                <i class="demo-pli-male fs-5 me-2"></i>
                                <span class="ms-1">Profile</span>
                            </a>
                            {{--                            <a href="#" class="nav-link">--}}
                            {{--                                <i class="demo-pli-gear fs-5 me-2"></i>--}}
                            {{--                                <span class="ms-1">Settings</span>--}}
                            {{--                            </a>--}}
                            {{--                            <a href="#" class="nav-link">--}}
                            {{--                                <i class="demo-pli-computer-secure fs-5 me-2"></i>--}}
                            {{--                                <span class="ms-1">Lock screen</span>--}}
                            {{--                            </a>--}}
                            {{--                            <a class="nav-link" style="cursor: pointer;"--}}
                            {{--                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">--}}
                            {{--                                <i class="demo-pli-unlock fs-5 me-2"></i>--}}
                            {{--                                <span class="ms-1">Logout</span>--}}
                            {{--                            </a>--}}
                        </div>


                    </div>
                </div>

            </div>
            <!-- End - Profile widget -->
            {{--            @can('dashboard_view')--}}
            @if(\App\Helpers\NavigationHelper::hasAccess('user.dashboard'))

                <!-- Navigation Category Dashboard -->
                <div class="mainnav__categoriy pb-1">
                    {{--                    <h6 class="mainnav__caption mt-0 fw-bold">Navigation</h6>--}}
                    <ul class="mainnav__menu nav flex-column">


                        <!-- Link with submenu -->
                        <li class="nav-item">
                            <a href="{{route('user.dashboard')}}"
                               class="nav-link mininav-toggle {{ request()->is('dashboard*') ? 'active' : '' }}">
                                <i class="demo-pli-home fs-5 me-2"></i>

                                <span class="nav-label mininav-content ms-1 collapse" style="">
                              <span data-popper-arrow="" class="arrow"></span>
                              Dashboard
                           </span>
                            </a>
                        </li>
                        <!-- Has Sub -->
                        {{--                        <li class="nav-item has-sub">--}}
                        {{--                            <a href="{{route('user.dashboard')}}" class="mininav-toggle nav-link collapsed"><i--}}
                        {{--                                    class="demo-pli-home fs-5 me-2"></i>--}}
                        {{--                                <span class="nav-label ms-1">Dashboard</span>--}}
                        {{--                            </a>--}}
                        {{--                            <!-- Dashboard submenu list -->--}}
                        {{--                            <ul class="mininav-content nav collapse">--}}
                        {{--                                <li data-popper-arrow class="arrow"></li>--}}
                        {{--                                <li class="nav-item">--}}
                        {{--                                    <a href="{{route('user.dashboard')}}" class="nav-link">Dashboard 1</a>--}}
                        {{--                                </li>--}}
                        {{--                            </ul>--}}
                        {{--                            <!-- END : Dashboard submenu list -->--}}
                        {{--                        </li>--}}
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
            @endif
            {{--            @endcan--}}
            @if(\App\Helpers\NavigationHelper::hasAccess('customer.company.index') || \App\Helpers\NavigationHelper::hasAccess('customer.contact.index') || \App\Helpers\NavigationHelper::hasAccess('team-member.index') || \App\Helpers\NavigationHelper::hasAccess('brand.index') || \App\Helpers\NavigationHelper::hasAccess('lead.index') || \App\Helpers\NavigationHelper::hasAccess('invoice.index') || \App\Helpers\NavigationHelper::hasAccess('user.payment.index') || \App\Helpers\NavigationHelper::hasAccess('user.client.contact.index') || \App\Helpers\NavigationHelper::hasAccess('user.client.company.index') || \App\Helpers\NavigationHelper::hasAccess('user.client.account.index'))

                {{--            @canany(['viewAny', App\Models\CustomerCompany::class,'viewAny', App\Models\CustomerContact::class,'viewAny', App\Models\AssignTeamMember::class,'viewAny', App\Models\Brand::class,'viewAny', App\Models\Lead::class,'viewAny', App\Models\Invoice::class,'viewAny', App\Models\Payment::class,'viewAny', App\Models\ClientContact::class,'viewAny', App\Models\ClientCompany::class,'viewAny', App\Models\PaymentMerchant::class])--}}
                <!-- Components Category Crm-->
                <div class="mainnav__categoriy py-1">

                    <h6 class="mainnav__caption mt-0 fw-bold">CRM</h6>
                    <ul class="mainnav__menu nav flex-column">
                        @if(\App\Helpers\NavigationHelper::hasAccess('customer.company.index'))
                            {{--                            @can('viewAny', App\Models\CustomerCompany::class)--}}
                            <li class="nav-item">
                                <a href="{{route('customer.company.index')}}"
                                   class="nav-link mininav-toggle {{ request()->is('companies*') ? 'active' : '' }}">
                                    <i class="demo-pli-address-book fs-5 me-2"></i>

                                    <span class="nav-label mininav-content ms-1 collapse" style="">
                              <span data-popper-arrow="" class="arrow"></span>
                              Companies
                           </span>
                                </a>
                            </li>
                            <!-- Link with submenu -->
                            {{--                    <li class="nav-item has-sub">--}}
                            {{--                        <a href="#"--}}
                            {{--                           class="mininav-toggle nav-link collapsed {{ request()->is('companies*') ? 'active' : '' }}"><i--}}
                            {{--                                class="demo-pli-address-book fs-5 me-2"></i>--}}
                            {{--                            <span class="nav-label ms-1">Companies</span>--}}
                            {{--                        </a>--}}
                            {{--                        <!-- Ui Elements submenu list -->--}}
                            {{--                        <ul class="mininav-content nav collapse">--}}
                            {{--                            <li data-popper-arrow class="arrow"></li>--}}
                            {{--                            <li class="nav-item">--}}
                            {{--                                <a href="{{route('customer.company.index')}}"--}}
                            {{--                                   class="nav-link {{ request()->is('companies*') ? 'active' : '' }}">Lists</a>--}}
                            {{--                            </li>--}}
                            {{--                        </ul>--}}
                            {{--                        <!-- END : Ui Elements submenu list -->--}}
                            {{--                    </li>--}}

                            {{--                            @endcan--}}
                        @endif
                        @if(\App\Helpers\NavigationHelper::hasAccess('customer.contact.index'))
                            {{--                            @can('viewAny', App\Models\CustomerContact::class)--}}
                            <li class="nav-item">
                                <a href="{{route('customer.contact.index')}}"
                                   class="nav-link mininav-toggle {{ request()->is('contact*') ? 'active' : '' }}">
                                    <i class="demo-pli-address-book fs-5 me-2"></i>

                                    <span class="nav-label mininav-content ms-1 collapse" style="">
                              <span data-popper-arrow="" class="arrow"></span>
                              Contacts
                           </span>
                                </a>
                            </li>
                            {{--                    <li class="nav-item has-sub">--}}
                            {{--                        <a href="#"--}}
                            {{--                           class="mininav-toggle nav-link collapsed {{ request()->is('contact*') ? 'active' : '' }}"><i--}}
                            {{--                                class="demo-pli-address-book fs-5 me-2"></i>--}}
                            {{--                            <span class="nav-label ms-1">Contacts</span>--}}
                            {{--                        </a>--}}
                            {{--                        <!-- Ui Elements submenu list -->--}}
                            {{--                        <ul class="mininav-content nav collapse">--}}
                            {{--                            <li data-popper-arrow class="arrow"></li>--}}
                            {{--                            <li class="nav-item">--}}
                            {{--                                <a href="{{route('customer.contact.index')}}"--}}
                            {{--                                       class="nav-link {{ request()->is('contact*') ? 'active' : '' }}">Lists</a>--}}
                            {{--                            </li>--}}
                            {{--                        </ul>--}}
                            {{--                        <!-- END : Ui Elements submenu list -->--}}
                            {{--                    </li>--}}
                            {{--                            @endcan--}}
                        @endif
                        @if(\App\Helpers\NavigationHelper::hasAccess('team-member.index'))
                            {{--                            @can('viewAny', App\Models\AssignTeamMember::class)--}}
                            <li class="nav-item">
                                <a href="{{route('team-member.index')}}"
                                   class="nav-link mininav-toggle {{ request()->is('team-members*') ? 'active' : '' }}">
                                    <i class="demo-pli-add-user fs-5 me-2"></i>

                                    <span class="nav-label mininav-content ms-1 collapse" style="">
                              <span data-popper-arrow="" class="arrow"></span>
                              Team Members
                           </span>
                                </a>
                            </li>

                            {{--                    <li class="nav-item has-sub">--}}
                            {{--                        <a href="#"--}}
                            {{--                           class="mininav-toggle nav-link collapsed {{ request()->is('team-members*') ? 'active' : '' }}"><i--}}
                            {{--                                class="demo-pli-add-user fs-5 me-2"></i>--}}
                            {{--                            <span class="nav-label ms-1">Team Members</span>--}}
                            {{--                        </a>--}}
                            {{--                        <!-- Ui Elements submenu list -->--}}
                            {{--                        <ul class="mininav-content nav collapse">--}}
                            {{--                            <li data-popper-arrow class="arrow"></li>--}}
                            {{--                            <li class="nav-item">--}}
                            {{--                                <a href="{{route('team-member.index')}}"--}}
                            {{--                                   class="nav-link {{ request()->is('team-members*') ? 'active' : '' }}">Lists</a>--}}
                            {{--                            </li>--}}
                            {{--                        </ul>--}}
                            {{--                        <!-- END : Ui Elements submenu list -->--}}
                            {{--                    </li>--}}

                            {{--                            @endcan--}}
                        @endif
                        @if(\App\Helpers\NavigationHelper::hasAccess('brand.index'))
                            {{--                            @can('viewAny', App\Models\Brand::class)--}}
                            <li class="nav-item">
                                <a href="{{route('brand.index')}}"
                                   class="nav-link mininav-toggle {{ request()->is('brand*') ? 'active' : '' }}">
                                    <i class="demo-pli-tag fs-5 me-2"></i>

                                    <span class="nav-label mininav-content ms-1 collapse" style="">
                              <span data-popper-arrow="" class="arrow"></span>
                              Brands
                           </span>
                                </a>
                            </li>
                            {{--                    <li class="nav-item has-sub">--}}
                            {{--                        <a href="#"--}}
                            {{--                           class="mininav-toggle nav-link collapsed {{ request()->is('brand*') ? 'active' : '' }}"><i--}}
                            {{--                                class="demo-pli-tag fs-5 me-2"></i>--}}
                            {{--                            <span class="nav-label ms-1">Brands</span>--}}
                            {{--                        </a>--}}
                            {{--                        <!-- Ui Elements submenu list -->--}}
                            {{--                        <ul class="mininav-content nav collapse">--}}
                            {{--                            <li data-popper-arrow class="arrow"></li>--}}
                            {{--                            <li class="nav-item">--}}
                            {{--                                <a href="{{route('brand.index')}}"--}}
                            {{--                                   class="nav-link {{ request()->is('brand*') ? 'active' : '' }}">Lists</a>--}}
                            {{--                            </li>--}}
                            {{--                        </ul>--}}
                            {{--                        <!-- END : Ui Elements submenu list -->--}}
                            {{--                    </li>--}}

                            {{--                            @endcan--}}
                        @endif
                        @if(\App\Helpers\NavigationHelper::hasAccess('lead.index'))
                            {{--                            @can('viewAny', App\Models\Lead::class)--}}
                            <li class="nav-item">
                                <a href="{{route('lead.index')}}"
                                   class="nav-link mininav-toggle {{ request()->is('leads*') ? 'active' : '' }}">
                                    <i class="demo-pli-mine fs-5 me-2"></i>

                                    <span class="nav-label mininav-content ms-1 collapse" style="">
                              <span data-popper-arrow="" class="arrow"></span>
                              Leads
                           </span>
                                </a>
                            </li>
                            {{--                    <li class="nav-item has-sub">--}}
                            {{--                        <a href="#"--}}
                            {{--                           class="mininav-toggle nav-link collapsed {{ request()->is('leads*') ? 'active' : '' }}"><i--}}
                            {{--                                class="demo-pli-mine fs-5 me-2"></i>--}}
                            {{--                            <span class="nav-label ms-1">Leads</span>--}}
                            {{--                        </a>--}}
                            {{--                        <!-- Ui Elements submenu list -->--}}
                            {{--                        <ul class="mininav-content nav collapse">--}}
                            {{--                            <li data-popper-arrow class="arrow"></li>--}}
                            {{--                            <li class="nav-item">--}}
                            {{--                                <a href="{{route('lead.index')}}"--}}
                            {{--                                   class="nav-link {{ request()->is('leads*') ? 'active' : '' }}">Lists</a>--}}
                            {{--                            </li>--}}
                            {{--                        </ul>--}}
                            {{--                        <!-- END : Ui Elements submenu list -->--}}
                            {{--                    </li>--}}
                            {{--                    <li class="nav-item has-sub">--}}
                            {{--                        <a href="#"--}}
                            {{--                           class="mininav-toggle nav-link collapsed {{ request()->is('lead-status*') ? 'active' : '' }}"><i--}}
                            {{--                                class="demo-pli-gears fs-5 me-2"></i>--}}
                            {{--                            <span class="nav-label ms-1">Lead Status</span>--}}
                            {{--                        </a>--}}
                            {{--                        <!-- Ui Elements submenu list -->--}}
                            {{--                        <ul class="mininav-content nav collapse">--}}
                            {{--                            <li data-popper-arrow class="arrow"></li>--}}
                            {{--                            <li class="nav-item">--}}
                            {{--                                <a href="{{route('lead-status.index')}}"--}}
                            {{--                                   class="nav-link {{ request()->is('lead-status*') ? 'active' : '' }}">Lists</a>--}}
                            {{--                            </li>--}}
                            {{--                        </ul>--}}
                            {{--                        <!-- END : Ui Elements submenu list -->--}}
                            {{--                    </li>--}}

                            {{--                            @endcan--}}
                        @endif
                        @if(\App\Helpers\NavigationHelper::hasAccess('invoice.index'))
                            {{--                            @can('viewAny', App\Models\Invoice::class)--}}
                            <li class="nav-item">
                                <a href="{{route('invoice.index')}}"
                                   class="nav-link mininav-toggle {{ request()->is('invoices*') ? 'active' : '' }}">
                                    <i class="demo-pli-file fs-5 me-2"></i>

                                    <span class="nav-label mininav-content ms-1 collapse" style="">
                              <span data-popper-arrow="" class="arrow"></span>
                              Invoices
                           </span>
                                </a>
                            </li>
                            {{--                    <li class="nav-item has-sub">--}}
                            {{--                        <a href="#"--}}
                            {{--                           class="mininav-toggle nav-link collapsed {{ request()->is('invoices*') ? 'active' : '' }}"><i--}}
                            {{--                                class="demo-pli-file fs-5 me-2"></i>--}}
                            {{--                            <span class="nav-label ms-1">Invoices</span>--}}
                            {{--                        </a>--}}
                            {{--                        <!-- Ui Elements submenu list -->--}}
                            {{--                        <ul class="mininav-content nav collapse">--}}
                            {{--                            <li data-popper-arrow class="arrow"></li>--}}
                            {{--                            <li class="nav-item">--}}
                            {{--                                <a href="{{route('invoice.index')}}"--}}
                            {{--                                   class="nav-link {{ request()->is('invoice*') ? 'active' : '' }}">Lists</a>--}}
                            {{--                            </li>--}}
                            {{--                        </ul>--}}
                            {{--                        <!-- END : Ui Elements submenu list -->--}}
                            {{--                    </li>--}}

                            {{--                            @endcan--}}
                        @endif

                         @if(\App\Helpers\NavigationHelper::hasAccess('employee.index'))
                            {{--                            @can('viewAny', App\Models\ClientContact::class)--}}
                            <li class="nav-item">
                                <a href="{{route('employee.index')}}"
                                    class="nav-link mininav-toggle {{ request()->is('employees/employees*') ? 'active' : '' }}">
                                    <i class="demo-pli-add-user-star fs-5 me-2"></i>

                                    <span class="nav-label mininav-content ms-1 collapse" style="">
                        <span data-popper-arrow="" class="arrow"></span>
                        Employees
                        </span>
                                </a>
                            </li>
                            {{--                            @endcan--}}
                        @endif

                        @if(\App\Helpers\NavigationHelper::hasAccess('user.client.contact.index'))
                            {{--                            @can('viewAny', App\Models\ClientContact::class)--}}
                            <li class="nav-item">
                                <a href="{{route('user.client.contact.index')}}"
                                   class="nav-link mininav-toggle {{ request()->is('client/contact*') ? 'active' : '' }}">
                                    <i class="demo-pli-add-user-star fs-5 me-2"></i>

                                    <span class="nav-label mininav-content ms-1 collapse" style="">
                              <span data-popper-arrow="" class="arrow"></span>
                              Contacts
                           </span>
                                </a>
                            </li>
                            {{--                            @endcan--}}
                        @endif
                        @if(\App\Helpers\NavigationHelper::hasAccess('user.client.company.index'))
                            {{--                            @can('viewAny', App\Models\ClientCompany::class)--}}
                            <li class="nav-item">
                                <a href="{{route('user.client.company.index')}}"
                                   class="nav-link mininav-toggle {{ request()->is('client/company*') || request()->is('client/companies*') ? 'active' : '' }}">
                                    <i class="demo-pli-building fs-5 me-2"></i>

                                    <span class="nav-label mininav-content ms-1 collapse" style="">
                              <span data-popper-arrow="" class="arrow"></span>
                              Companies
                           </span>
                                </a>
                            </li>
                            {{--                            @endcan--}}
                        @endif
                        @if(\App\Helpers\NavigationHelper::hasAccess('user.client.account.index'))
                            {{--                            @can('viewAny', App\Models\PaymentMerchant::class)--}}
                            <li class="nav-item">
                                <a href="{{route('user.client.account.index')}}"
                                   class="nav-link mininav-toggle {{ request()->is('client/account*') ? 'active' : '' }}">
                                    <i class="demo-pli-wallet-2 fs-5 me-2"></i>

                                    <span class="nav-label mininav-content ms-1 collapse" style="">
                              <span data-popper-arrow="" class="arrow"></span>
                              Accounts
                           </span>
                                </a>
                            </li>
                            {{--                            @endcan--}}
                        @endif
                        @if(\App\Helpers\NavigationHelper::hasAccess('user.payment.index'))
                            {{--                            @can('viewAny', App\Models\Payment::class)--}}
                            <li class="nav-item">
                                <a href="{{route('user.payment.index')}}"
                                   class="nav-link mininav-toggle {{ request()->is('payments*') ? 'active' : '' }}">
                                    <i class="demo-pli-wallet-2 fs-5 me-2"></i>

                                    <span class="nav-label mininav-content ms-1 collapse" style="">
                              <span data-popper-arrow="" class="arrow"></span>
                              Payments
                           </span>
                                </a>
                            </li>
                            {{--                    <li class="nav-item has-sub">--}}
                            {{--                        <a href="#"--}}
                            {{--                           class="mininav-toggle nav-link collapsed {{ request()->is('payments*') ? 'active' : '' }}"><i--}}
                            {{--                                class="demo-pli-wallet-2 fs-5 me-2"></i>--}}
                            {{--                            <span class="nav-label ms-1">Payments</span>--}}
                            {{--                        </a>--}}
                            {{--                        <!-- Ui Elements submenu list -->--}}
                            {{--                        <ul class="mininav-content nav collapse">--}}
                            {{--                            <li data-popper-arrow class="arrow"></li>--}}
                            {{--                            <li class="nav-item">--}}
                            {{--                                <a href="{{route('payment.index')}}"--}}
                            {{--                                   class="nav-link {{ request()->is('payment*') ? 'active' : '' }}">Lists</a>--}}
                            {{--                            </li>--}}
                            {{--                        </ul>--}}
                            {{--                        <!-- END : Ui Elements submenu list -->--}}
                            {{--                    </li>--}}

                            {{--                            @endcan--}}
                        @endif
                        <!-- END : Link with submenu -->
                    </ul>
                </div>
                <!-- END : Components Category -->
                {{--            @endcanany--}}
            @endif
            <!-- Server Status Category -->
            {{--            <div class="mainnav__widget">--}}

            {{--                <!-- Widget buttton form small navigation -->--}}
            {{--                <div class="mininav-toggle text-center py-2 d-mn-min">--}}
            {{--                    <i class="demo-pli-monitor-2"></i>--}}
            {{--                </div>--}}

            {{--                <div class="d-mn-max mt-5"></div>--}}

            {{--                <!-- Widget content -->--}}
            {{--                <div class="mininav-content collapse d-mn-max">--}}
            {{--                    <span data-popper-arrow class="arrow"></span>--}}
            {{--                    <h6 class="mainnav__caption fw-bold">Server Status</h6>--}}
            {{--                    <ul class="list-group list-group-borderless">--}}
            {{--                        <li class="list-group-item text-reset">--}}
            {{--                            <div class="d-flex justify-content-between align-items-start">--}}
            {{--                                <p class="mb-2 me-auto">CPU Usage</p>--}}
            {{--                                <span class="badge bg-info rounded">35%</span>--}}
            {{--                            </div>--}}
            {{--                            <div class="progress progress-md">--}}
            {{--                                <div class="progress-bar bg-info" role="progressbar" style="width: 35%"--}}
            {{--                                     aria-label="CPU Progress" aria-valuenow="35" aria-valuemin="0"--}}
            {{--                                     aria-valuemax="100"></div>--}}
            {{--                            </div>--}}
            {{--                        </li>--}}
            {{--                        <li class="list-group-item text-reset">--}}
            {{--                            <div class="d-flex justify-content-between align-items-start">--}}
            {{--                                <p class="mb-2 me-auto">Bandwidth</p>--}}
            {{--                                <span class="badge bg-warning rounded">73%</span>--}}
            {{--                            </div>--}}
            {{--                            <div class="progress progress-md">--}}
            {{--                                <div class="progress-bar bg-warning" role="progressbar" style="width: 73%"--}}
            {{--                                     aria-label="Bandwidth Progress" aria-valuenow="73" aria-valuemin="0"--}}
            {{--                                     aria-valuemax="100"></div>--}}
            {{--                            </div>--}}
            {{--                        </li>--}}
            {{--                    </ul>--}}
            {{--                    <div class="d-grid px-3 mt-3">--}}
            {{--                        <a href="#" class="btn btn-sm btn-success">View Details</a>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <!-- End : Server Status Category -->


        </div>
        <!-- End - Navigation menu -->


        <!-- Bottom navigation menu -->
        <div class="mainnav__bottom-content border-top pb-2 pt-2">
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
