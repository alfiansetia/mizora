<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{ route('dashboard') }}">
            <div class="logo-img">
                <img height="30" src="{{ asset('img/logo_white.png') }}" class="header-brand-img" title="RADMIN">
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
    @endphp

    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-item {{ $segment1 == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}"><i
                            class="ik ik-bar-chart-2"></i><span>{{ __('Dashboard') }}</span></a>
                </div>
                <div class="nav-lavel">{{ __('Layouts') }} </div>
                <!--<div class="nav-item {{ $segment1 == 'pos' ? 'active' : '' }}">
                    <a href="{{ url('inventory') }}"><i class="ik ik-shopping-cart"></i><span>{{ __('Inventory') }}</span> </a>
                </div>
                <div class="nav-item {{ $segment1 == 'pos' ? 'active' : '' }}">
                    <a href="{{ url('pos') }}"><i class="ik ik-printer"></i><span>{{ __('POS') }}</span> </a>
                </div>
                <div class="nav-item {{ $segment1 == 'accounting' ? 'active' : '' }}">
                    <a href="{{ url('accounting') }}"><i class="ik ik-printer"></i><span>{{ __('Accounting') }}</span> <span class=" badge badge-success badge-right">{{ __('New') }}</span></a>
                </div>-->
                <div
                    class="nav-item {{ $segment1 == 'users' || $segment1 == 'roles' || $segment1 == 'permission' || $segment1 == 'user' ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-user"></i><span>{{ __('Adminstrator') }}</span></a>
                    <div class="submenu-content">
                        <!-- only those have manage_user permission will get access -->
                        @can('manage_user')
                            <a href="{{ url('users') }}"
                                class="menu-item {{ $segment1 == 'users' ? 'active' : '' }}">{{ __('Users') }}</a>
                            <a href="{{ url('user/create') }}"
                                class="menu-item {{ $segment1 == 'user' && $segment2 == 'create' ? 'active' : '' }}">{{ __('Add User') }}</a>
                        @endcan
                        <!-- only those have manage_role permission will get access -->
                        @can('manage_roles')
                            <a href="{{ url('roles') }}"
                                class="menu-item {{ $segment1 == 'roles' ? 'active' : '' }}">{{ __('Roles') }}</a>
                        @endcan
                        <!-- only those have manage_permission permission will get access -->
                        @can('manage_permission')
                            <a href="{{ url('permission') }}"
                                class="menu-item {{ $segment1 == 'permission' ? 'active' : '' }}">{{ __('Permission') }}</a>
                        @endcan
                    </div>
                </div>

                <div class="nav-item {{ $segment1 == 'Member' ? 'active' : '' }}">
                    <a href="{{ url('member') }}"><i class="ik ik-list"></i><span>{{ __('Member') }}</span></a>
                </div>
                <div class="nav-item {{ $segment1 == 'member' || $segment1 == 'level' ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-star"></i><span>{{ __('Membership') }}</span></a>
                    <div class="submenu-content">
                        <a href="{{ url('level') }}"
                            class="menu-item {{ $segment1 == 'level' ? 'active' : '' }}">{{ __('Level Membership') }}</a>
                    </div>
                </div>
                <div class="nav-item {{ $segment1 == 'products' ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-headphones"></i><span>{{ __('Products') }}</span></a>
                    <div class="submenu-content">
                        <a href="{{ url('products/create') }}"
                            class="menu-item {{ $segment1 == 'products' && $segment2 == 'create' ? 'active' : '' }}">{{ __('Add Product') }}</a>
                        <a href="{{ url('products') }}"
                            class="menu-item {{ $segment1 == 'products' && $segment2 == '' ? 'active' : '' }}">{{ __('List Producs') }}</a>
                    </div>
                </div>
                <div class="nav-item {{ $segment1 == 'rewards' ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-headphones"></i><span>{{ __('Reward') }}</span></a>
                    <div class="submenu-content">
                        <a href="{{ route('rewards.create') }}"
                            class="menu-item {{ $segment1 == 'rewards' && $segment2 == 'create' ? 'active' : '' }}">{{ __('Add Reward') }}</a>
                        <a href="{{ route('rewards.index') }}"
                            class="menu-item {{ $segment1 == 'rewards' && $segment2 == '' ? 'active' : '' }}">{{ __('List Reward') }}</a>
                        <a href="{{ route('reward-category.index') }}"
                            class="menu-item {{ $segment1 == 'reward-category' && $segment2 == '' ? 'active' : '' }}">{{ __('Category Reward') }}</a>
                    </div>
                </div>

                <div
                    class="nav-item {{ $segment1 == 'member' || $segment1 == 'message' ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-message-square"></i><span>{{ __('Notifications') }}</span></a>
                    <div class="submenu-content">
                        <a href="{{ url('message') }}"
                            class="menu-item {{ $segment1 == 'message' ? 'active' : '' }}">{{ __('Messages Category') }}</a>
                    </div>
                </div>
                <div class="nav-item {{ $segment1 == 'categories' ? 'active' : '' }}">
                    <a href="{{ url('categories') }}"><i
                            class="ik ik-list"></i><span>{{ __('Categories') }}</span></a>
                </div>
                <div class="nav-item {{ $segment1 == 'page' ? 'active' : '' }}">
                    <a href="{{ route('page.index') }}"><i class="ik ik-list"></i><span>{{ __('Pages') }}</span></a>
                </div>
                <div class="nav-item {{ $segment1 == 'location' ? 'active' : '' }}">
                    <a href="{{ route('location.index') }}"><i
                            class="ik ik-map"></i><span>{{ __('Location') }}</span></a>
                </div>

                <!-- Include demo pages inside sidebar start-->
                @include('pages.sidebar-menu')
                <!-- Include demo pages inside sidebar end-->

            </nav>

        </div>
    </div>
</div>
