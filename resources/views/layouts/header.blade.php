<style>
  .brand-link .brand-image {
    margin-top: -8px;
    margin-bottom: -18px;
    max-height: 45px;
}
</style>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-user"></i>
                {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-lg">
                <a href="{{ route('users.changePassword') }}" class="dropdown-item">
                    <i class="fas fa-arrow-right"></i>
                    Change Password
                </a>
                <div class="dropdown-divider"></div>
                @can('general-setting')
                    <a href="{{ route('setting.index') }}" class="dropdown-item">
                        <i class="fas fa-arrow-right"></i>
                        General Setting
                    </a>
                    <div class="dropdown-divider"></div>
                @endcan

                <a href="{{ route('logout') }}" class="dropdown-item"
                    onclick="event.preventDefault();
             document.getElementById('logout-form').submit();">
                    <i class="fas fa-arrow-right"></i>
                    Logout
                </a>
                <div class="dropdown-divider"></div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
