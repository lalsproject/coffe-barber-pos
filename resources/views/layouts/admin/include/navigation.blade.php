<div id="app">
    <aside class="sidebar sidebar-left"
        style="box-shadow: 0 1px 1px 1px rgba(18, 106, 211, .08);@php $sidebar_background =$settings->sidebar_background ?? '#ffffff'; @endphp background-color: {{ $sidebar_background }}">
        <div class="sidebar-content"
            style="@php $sidebar_background =$settings->sidebar_background ?? '#ffffff'; @endphp background-color: {{ $sidebar_background }}">
            <div class="aside-toolbar">
                <ul class="site-logo">
                    <li>
                        <a href="{{ route('home') }}">
                            <div class="logo">
                                <img src="{{ isset($settings->logo) ? $settings->getImage() : asset('admin/assets/img/logos/default.jpg') }}"
                                alt="{{ env('APP_NAME') }}" style="width: 90px; height: 50px;" />
                           
                            </div>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Navigation --}}
            <nav class="main-menu">
                <ul class="nav metismenu">
                    @role('admin')
                        <li class="sidebar-header">
                            <span>User Management</span>
                        </li>
                        <li class="{{ url()->current() == route('users.index') ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}"
                                style="{{ url()->current() == route('users.index') ? 'font-weight: bolder;' : '' }}">
                                <i style="{{ url()->current() == route('users.index') ? 'font-weight: bolder;' : '' }}"
                                    class="icon la la-users"></i>
                                <span
                                    style="{{ url()->current() == route('users.index') ? 'font-weight: bolder;' : '' }}">User</span>
                            </a>
                        </li>
                    @endrole

                    @role('admin')
                        <li class="sidebar-header">
                            <span>Master Management</span>
                        </li>
                        <li
                            class="nav-dropdown {{ url()->current() == route('suppliers.index') ||
                            url()->current() == route('brands.index') ||
                            url()->current() == route('categories.index') ||
                            url()->current() == route('units.index') ||
                            url()->current() == route('customers.index') ||
                            url()->current() == route('branch.index') ||
                            url()->current() == route('capsters.index') ||
                            url()->current() == route('services.index')
                                ? 'active'
                                : '' }}">
                            <a class="has-arrow" href="#"
                                aria-expanded="{{ url()->current() == route('suppliers.index') ||
                                url()->current() == route('brands.index') ||
                                url()->current() == route('categories.index') ||
                                url()->current() == route('units.index') ||
                                url()->current() == route('customers.index') ||
                                url()->current() == route('branch.index') ||
                                url()->current() == route('capsters.index') ||
                                url()->current() == route('services.index')
                                    ? 'true'
                                    : 'false' }}"
                                style="{{ url()->current() == route('suppliers.index') ||
                                url()->current() == route('brands.index') ||
                                url()->current() == route('categories.index') ||
                                url()->current() == route('units.index') ||
                                url()->current() == route('customers.index') ||
                                url()->current() == route('branch.index') ||
                                url()->current() == route('capsters.index') ||
                                url()->current() == route('services.index')
                                    ? 'font-weight: bolder;'
                                    : '' }}">
                                <i class="icon dripicons-article"></i>
                                <span
                                    style="{{ url()->current() == route('suppliers.index') ||
                                    url()->current() == route('brands.index') ||
                                    url()->current() == route('categories.index') ||
                                    url()->current() == route('units.index') ||
                                    url()->current() == route('customers.index') ||
                                    url()->current() == route('branch.index') ||
                                    url()->current() == route('capsters.index') ||
                                    url()->current() == route('services.index')
                                        ? 'font-weight: bolder;'
                                        : '' }}">Master</span>
                            </a>
                            <ul class="collapse nav-sub"
                                aria-expanded="{{ url()->current() == route('suppliers.index') ||
                                url()->current() == route('brands.index') ||
                                url()->current() == route('categories.index') ||
                                url()->current() == route('units.index') ||
                                url()->current() == route('customers.index') ||
                                url()->current() == route('branch.index') ||
                                url()->current() == route('capsters.index') ||
                                url()->current() == route('services.index')
                                    ? 'true'
                                    : 'false' }}">
                                @role('admin')
                                    <li class="{{ url()->current() == route('suppliers.index') ? 'active' : '' }}">
                                        <a href="{{ route('suppliers.index') }}"
                                            style="{{ url()->current() == route('suppliers.index') ? 'font-weight: bolder;' : '' }}">
                                            <span
                                                style="{{ url()->current() == route('suppliers.index') ? 'font-weight: bolder;' : '' }}">Supplier</span>
                                        </a>
                                    </li>
                                    <li class="{{ url()->current() == route('brands.index') ? 'active' : '' }}">
                                        <a href="{{ route('brands.index') }}"
                                            style="{{ url()->current() == route('brands.index') ? 'font-weight: bolder;' : '' }}">
                                            <span
                                                style="{{ url()->current() == route('brands.index') ? 'font-weight: bolder;' : '' }}">Brand</span>
                                        </a>
                                    </li>
                                    <li class="{{ url()->current() == route('categories.index') ? 'active' : '' }}">
                                        <a href="{{ route('categories.index') }}"
                                            style="{{ url()->current() == route('categories.index') ? 'font-weight: bolder;' : '' }}">
                                            <span
                                                style="{{ url()->current() == route('categories.index') ? 'font-weight: bolder;' : '' }}">Kategori</span>
                                        </a>
                                    </li>
                                    <li class="{{ url()->current() == route('units.index') ? 'active' : '' }}">
                                        <a href="{{ route('units.index') }}"
                                            style="{{ url()->current() == route('units.index') ? 'font-weight: bolder;' : '' }}">
                                            <span
                                                style="{{ url()->current() == route('units.index') ? 'font-weight: bolder;' : '' }}">Unit</span>
                                        </a>
                                    </li>
                                    <li class="{{ url()->current() == route('customers.index') ? 'active' : '' }}">
                                        <a href="{{ route('customers.index') }}"
                                            style="{{ url()->current() == route('customers.index') ? 'font-weight: bolder;' : '' }}">
                                            <span
                                                style="{{ url()->current() == route('customers.index') ? 'font-weight: bolder;' : '' }}">Pelanggan</span>
                                        </a>
                                    </li>
                                    <li class="{{ url()->current() == route('branch.index') ? 'active' : '' }}">
                                        <a href="{{ route('branch.index') }}"
                                            style="{{ url()->current() == route('branch.index') ? 'font-weight: bolder;' : '' }}">
                                            <span
                                                style="{{ url()->current() == route('branch.index') ? 'font-weight: bolder;' : '' }}">Cabang</span>
                                        </a>
                                    </li>

                                    <li class="{{ url()->current() == route('capsters.index') ? 'active' : '' }}">
                                        <a href="{{ route('capsters.index') }}"
                                            style="{{ url()->current() == route('capsters.index') ? 'font-weight: bolder;' : '' }}">
                                            <span
                                                style="{{ url()->current() == route('capsters.index') ? 'font-weight: bolder;' : '' }}">Capster</span>
                                        </a>
                                    </li>
                                    <li class="{{ url()->current() == route('services.index') ? 'active' : '' }}">
                                        <a href="{{ route('services.index') }}"
                                            style="{{ url()->current() == route('services.index') ? 'font-weight: bolder;' : '' }}">
                                            <span
                                                style="{{ url()->current() == route('services.index') ? 'font-weight: bolder;' : '' }}">Layanan</span>
                                        </a>
                                    </li>
                                @endrole
                            </ul>
                        </li>
                    @endrole

                    @role('admin')
                        <li class="sidebar-header">
                            <span>Inventory Management</span>
                        </li>
                        <li
                            class="nav-dropdown {{ url()->current() == route('products.list') || url()->current() == route('purchase-orders.list-approval')
                                ? 'active'
                                : '' }}">
                            <a href="#" class="has-arrow"
                                aria-expanded="{{ url()->current() == route('products.list') || url()->current() == route('purchase-orders.list-approval')
                                    ? 'true'
                                    : 'false' }}"
                                style="{{ url()->current() == route('products.list') || url()->current() == route('purchase-orders.list-approval')
                                    ? 'font-weight: bolder;'
                                    : '' }}">
                                <i class="la la-cube"></i>
                                <span
                                    style="{{ url()->current() == route('products.list') || url()->current() == route('purchase-orders.list-approval')
                                        ? 'font-weight: bolder;'
                                        : '' }}">Inventory</span>
                            </a>

                            <!-- Product Submenu -->
                            <ul class="collapse nav-sub"
                                aria-expanded="{{ url()->current() == route('products.list') ? 'true' : 'false' }}">
                                @role('admin')
                                    <li class="{{ url()->current() == route('products.list') ? 'active' : '' }}">
                                        <a href="{{ route('products.list') }}"
                                            style="{{ url()->current() == route('products.list') ? 'font-weight: bolder;' : '' }}">
                                            <span
                                                style="{{ url()->current() == route('products.list') ? 'font-weight: bolder;' : '' }}">Produk</span>
                                        </a>
                                    </li>
                                @endrole
                            </ul>

                            <!-- Purchase Order Submenu -->
                            <ul class="collapse nav-sub"
                                aria-expanded="{{ url()->current() == route('purchase-orders.list-approval') ? 'true' : 'false' }}">
                                @role('admin')
                                    <li
                                        class="{{ url()->current() == route('purchase-orders.list-approval') ? 'active' : '' }}">
                                        <a href="{{ route('purchase-orders.list-approval') }}"
                                            style="{{ url()->current() == route('purchase-orders.list-approval') ? 'font-weight: bolder;' : '' }}">
                                            <span
                                                style="{{ url()->current() == route('purchase-orders.list-approval') ? 'font-weight: bolder;' : '' }}">Purchase
                                                Order (PO)</span>
                                        </a>
                                    </li>
                                @endrole
                            </ul>
                        </li>
                    @endrole

                    @role('admin|cashier')
                        <li class="sidebar-header">
                            <span>Order Management</span>
                        </li>

                        <li
                            class="nav-dropdown {{ url()->current() == route('transaction') || url()->current() == route('transaction.capsters.index')
                                ? 'active'
                                : '' }}">
                            <a class="has-arrow" href="{{ route('transaction') }}"
                                aria-expanded="{{ url()->current() == route('transaction') || url()->current() == route('transaction.capsters.index')
                                    ? 'true'
                                    : 'false' }}"
                                style="{{ url()->current() == route('transaction') || url()->current() == route('transaction.capsters.index') ? 'font-weight: bolder;' : '' }}">
                                <i class="la la-money"></i>
                                <span
                                    style="{{ url()->current() == route('transaction') || url()->current() == route('transaction.capsters.index') ? 'font-weight: bolder;' : '' }}">Transaction</span>
                            </a>

                            <!-- POS Submenu -->
                            <ul class="collapse nav-sub"
                                aria-expanded="{{ url()->current() == route('transaction') ? 'true' : 'false' }}">
                                @role('admin|cashier')
                                    <li class="{{ url()->current() == route('transaction') ? 'active' : '' }}">
                                        <a href="{{ route('transaction') }}"
                                            style="{{ url()->current() == route('transaction') ? 'font-weight: bolder;' : '' }}">
                                            <span
                                                style="{{ url()->current() == route('transaction') ? 'font-weight: bolder;' : '' }}">POS</span>
                                        </a>
                                    </li>
                                @endrole
                            </ul>

                            <!-- Capster Submenu -->
                            <ul class="collapse nav-sub"
                                aria-expanded="{{ url()->current() == route('transaction.capsters.index') ? 'true' : 'false' }}">
                                @role('admin|cashier')
                                    <li class="{{ url()->current() == route('transaction.capsters.index') ? 'active' : '' }}">
                                        <a href="{{ route('transaction.capsters.index') }}"
                                            style="{{ url()->current() == route('transaction.capsters.index') ? 'font-weight: bolder;' : '' }}">
                                            <span
                                                style="{{ url()->current() == route('transaction.capsters.index') ? 'font-weight: bolder;' : '' }}">Capster</span>
                                        </a>
                                    </li>
                                @endrole
                            </ul>
                        </li>

                        <li
                            class="nav-dropdown {{ url()->current() == route('report.index') || url()->current() == route('report.list') ? 'active' : '' }}">
                            <a class="has-arrow" href="{{ route('report.index') }}"
                                aria-expanded="{{ url()->current() == route('report.index') || url()->current() == route('report.list') ? 'true' : 'false' }}"
                                style="{{ url()->current() == route('report.index') || url()->current() == route('report.list') ? 'font-weight: bolder;' : '' }}">
                                <i class="la la-clipboard"></i>
                                <span
                                    style="{{ url()->current() == route('report.index') || url()->current() == route('report.list') ? 'font-weight: bolder;' : '' }}">Report
                                    POS</span>
                            </a>

                            <!-- List Struk Submenu -->
                            <ul class="collapse nav-sub"
                                aria-expanded="{{ url()->current() == route('report.list') ? 'true' : 'false' }}">
                                @role('admin|cashier')
                                    <li class="{{ url()->current() == route('report.list') ? 'active' : '' }}">
                                        <a href="{{ route('report.list') }}"
                                            style="{{ url()->current() == route('report.list') ? 'font-weight: bolder;' : '' }}">
                                            <span
                                                style="{{ url()->current() == route('report.list') ? 'font-weight: bolder;' : '' }}">List
                                                Struk</span>
                                        </a>
                                    </li>
                                @endrole
                            </ul>

                            <!-- Daily Revenue Submenu -->
                            <ul class="collapse nav-sub"
                                aria-expanded="{{ url()->current() == route('report.index') ? 'true' : 'false' }}">
                                @role('admin|cashier')
                                    <li class="{{ url()->current() == route('report.index') ? 'active' : '' }}">
                                        <a href="{{ route('report.index') }}"
                                            style="{{ url()->current() == route('report.index') ? 'font-weight: bolder;' : '' }}">
                                            <span
                                                style="{{ url()->current() == route('report.index') ? 'font-weight: bolder;' : '' }}">Daily
                                                Revenue</span>
                                        </a>
                                    </li>
                                @endrole
                            </ul>
                        </li>

                        <li
                            class="nav-dropdown {{ url()->current() == route('capster.report.index') || url()->current() == route('capster.report.list')
                                ? 'active'
                                : '' }}">
                            <a class="has-arrow" href="{{ route('capster.report.index') }}"
                                aria-expanded="{{ url()->current() == route('capster.report.index') || url()->current() == route('capster.report.list')
                                    ? 'true'
                                    : 'false' }}"
                                style="{{ url()->current() == route('capster.report.index') || url()->current() == route('capster.report.list') ? 'font-weight: bolder;' : '' }}">
                                <i class="la la-clipboard"></i>
                                <span
                                    style="{{ url()->current() == route('capster.report.index') || url()->current() == route('capster.report.list') ? 'font-weight: bolder;' : '' }}">Report
                                    Capster</span>
                            </a>

                            <!-- List Struk Submenu -->
                            <ul class="collapse nav-sub"
                                aria-expanded="{{ url()->current() == route('capster.report.list') ? 'true' : 'false' }}">
                                @role('admin|cashier')
                                    <li class="{{ url()->current() == route('capster.report.list') ? 'active' : '' }}">
                                        <a href="{{ route('capster.report.list') }}"
                                            style="{{ url()->current() == route('capster.report.list') ? 'font-weight: bolder;' : '' }}">
                                            <span
                                                style="{{ url()->current() == route('capster.report.list') ? 'font-weight: bolder;' : '' }}">List
                                                Struk</span>
                                        </a>
                                    </li>
                                @endrole
                            </ul>

                            <!-- Daily Revenue Submenu -->
                            <ul class="collapse nav-sub"
                                aria-expanded="{{ url()->current() == route('capster.report.index') ? 'true' : 'false' }}">
                                @role('admin|cashier')
                                    <li class="{{ url()->current() == route('capster.report.index') ? 'active' : '' }}">
                                        <a href="{{ route('capster.report.index') }}"
                                            style="{{ url()->current() == route('capster.report.index') ? 'font-weight: bolder;' : '' }}">
                                            <span
                                                style="{{ url()->current() == route('capster.report.index') ? 'font-weight: bolder;' : '' }}">Daily
                                                Revenue</span>
                                        </a>
                                    </li>
                                @endrole
                            </ul>
                        </li>
                    @endrole


                    @role('admin')
                        <li class="sidebar-header">
                            <span>Settings Management</span>
                        </li>
                        <li class="{{ url()->current() == route('settings.index') ? 'active' : '' }}">
                            <a href="{{ route('settings.index') }}"
                                style="{{ url()->current() == route('settings.index') ? 'font-weight: bolder;' : '' }}">
                                <i style="{{ url()->current() == route('settings.index') ? 'font-weight: bolder;' : '' }}"
                                    class="icon la la-cog"></i>
                                <span
                                    style="{{ url()->current() == route('settings.index') ? 'font-weight: bolder;' : '' }}">Settings</span>
                            </a>
                        </li>
                    @endrole
                </ul>
            </nav>

        </div>
    </aside>
    <!-- END MENU SIDEBAR WRAPPER -->
    <div class="content-wrapper">
        <!-- TOP TOOLBAR WRAPPER -->
        <nav class="top-toolbar navbar navbar-mobile navbar-tablet">
            <ul class="navbar-nav nav-left">
                <li class="nav-item">
                    <a href="javascript:void(0)" data-toggle-state="aside-left-open">
                        <i class="icon dripicons-align-left"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav nav-center site-logo">
                <li>
                    <a href="{{ route('home') }}">
                        <span class="brand-text button-font-size">{{ env('APP_NAME') }}</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav nav-right">
                <li class="nav-item">
                    <a href="javascript:void(0)" data-toggle-state="mobile-topbar-toggle">
                        <i class="icon dripicons-dots-3 rotate-90"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <nav class="top-toolbar navbar navbar-desktop flex-nowrap"
            style="@php $navbar_background =$settings->navbar_background ?? '#ffffff'; @endphp background-color: {{ $navbar_background }}">
            <ul class="navbar-nav nav-right">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-pill user-avatar" data-toggle="dropdown" href="#" role="button"
                        aria-haspopup="true" aria-expanded="false"
                        style="font-weight: bold; margin-top: -1em;
                        margin-right: 4em;">
                        <i class="la la-user"></i>
                        {{ ucfirst(Auth::user()->name) }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-accout">
                        <div class="dropdown-header pb-3">
                            <div class="media d-user">
                                <div class="media-body">
                                    <h5 class="mt-0 mb-0">{{ ucfirst(Auth::user()->name) }}</h5>
                                    <span>{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                        </div>
                        <a class="dropdown-item" href="{{ route('users.change-password') }}">
                            <i class="zmdi zmdi-lock-open zmdi-hc-fw"></i> Change Password
                        </a>
                        <a class="dropdown-item" href="{{ route('users.change-profile') }}">
                            <i class="la la-user"></i> Change Profile
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="icon dripicons-lock-open"></i>
                            Sign Out
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
