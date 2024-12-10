<nav class="main-header navbar navbar-expand navbar-white navbar-light sticky-top">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">{{ auth()->user()->notifications->count() }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">
                    {{ auth()->user()->notifications->count() }} Notifications
                </span>

                @forelse (auth()->user()->notifications as $notification)
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-bell mr-2"></i> {{ $notification->data['title'] }}
                        <span
                            class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                        <p>{{ $notification->data['message'] }}</p>
                    </a>
                @empty
                    <div class="dropdown-divider"></div>
                    <span class="dropdown-item text-center text-muted">No notifications</span>
                @endforelse

                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>


        <!-- User Profile Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-user-circle"></i>
                {{ Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name }} <i
                    class="right fas fa-angle-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">User Profile</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Profile
                </a>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-cog mr-2"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('custom.logout') }}" class="dropdown-item dropdown-footer"
                    onclick="event.preventDefault(); document.getElementById('custom-logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
                <form id="custom-logout-form" action="{{ route('custom.logout') }}" method="POST"
                    style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
