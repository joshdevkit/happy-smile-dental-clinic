<style>
    .active-link {
        background-color: green !important;
        color: #fff !important;
    }

    .nav-link {
        transition: background-color 0.3s ease, color 0.3s ease;
        color: #000;
        text-decoration: none;
    }

    .nav-link:hover {
        background-color: darkgreen !important;
        color: white !important;
    }

    .nav-link.active-link:hover {
        background-color: green !important;
    }
</style>

<aside class="main-sidebar bg-white sidebar-white elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="text-center d-block">
        <img src="{{ asset('client/dist/img/brand.jpg') }}" alt="AdminLTE Logo" class="brand-image mb-2"
            style="opacity: .8; max-width: 100%; height: auto;">
    </a>
    <hr>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active-link' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li
                    class="nav-item {{ request()->routeIs('clients.index') || request()->routeIs('archive-client') || request()->routeIs('client-info') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('clients.index') || request()->routeIs('client-info') ? 'active-link' : '' }}">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>
                            About Clients
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('clients.index') }}"
                                class="nav-link {{ request()->routeIs('clients.index') || request()->routeIs('client-info') ? 'active-link' : '' }}">
                                •
                                <p>Registered Clients</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('archive-client') }}"
                                class="nav-link {{ request()->routeIs('archive-client') ? 'active-link' : '' }}">
                                •
                                <p>Archived Clients</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item {{ request()->routeIs('schedule.index') ||
                    request()->routeIs('schedule.today') ||
                    request()->routeIs('schedule.unattended') ||
                    request()->routeIs('schedule.history')
                        ? 'menu-open'
                        : '' }}">
                    <a href="#"
                        class="nav-link  {{ request()->routeIs('schedule.index') ||
                        request()->routeIs('schedule.today') ||
                        request()->routeIs('schedule.unattended') ||
                        request()->routeIs('schedule.history')
                            ? 'active-link'
                            : '' }} ">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            About Appointments
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('schedule.index') }}"
                                class="nav-link {{ request()->routeIs('schedule.index') ? 'active-link' : '' }}">
                                •
                                <p>Appointment Schedule</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('schedule.today') }}"
                                class="nav-link {{ request()->routeIs('schedule.today') ? 'active-link' : '' }}">
                                •
                                <p>Today Appointments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('schedule.unattended') }}"
                                class="nav-link {{ request()->routeIs('schedule.unattended') ? 'active-link' : '' }}">
                                •
                                <p>Unattended Appointment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('schedule.history') }}"
                                class="nav-link {{ request()->routeIs('schedule.history') ? 'active-link' : '' }}">
                                •
                                <p>Appointment History</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile') }}" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Profile</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
