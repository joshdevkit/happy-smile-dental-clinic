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
    <a href="{{ route('client.dashboard') }}" class="text-center d-block">
        <img src="{{ asset('client/dist/img/brand.jpg') }}" alt="AdminLTE Logo" class="brand-image mb-2"
            style="opacity: .8; max-width: 100%; height: auto;">
    </a>
    <hr>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('client.dashboard') }}"
                        class="nav-link {{ request()->routeIs('client.dashboard') ? 'active-link' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li
                    class="nav-item {{ request()->routeIs('my-appointment') || request()->routeIs('appointment-history') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link  {{ request()->routeIs('my-appointment') ? 'active-link' : '' }}">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>
                            Appointments
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('my-appointment') }}"
                                class="nav-link {{ request()->routeIs('my-appointment') ? 'active-link' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>My Appointments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('appointment-history') }}"
                                class="nav-link {{ request()->routeIs('appointment-history') ? 'active-link' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Appointment History</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile') }}" class="nav-link">
                        <p>Profile</p>
                    </a>
                </li>
            </ul>
        </nav>

    </div>
</aside>
