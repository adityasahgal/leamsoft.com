<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        @canany(['banner-create','banner-edit','banner-delete','banner-publish'])
        <li class="nav-item">
            <a href="{{ route('banner.index') }}" class="nav-link">
                <i class="nav-icon fas fa-image"></i>
                <p>Banners</p>
            </a>
        </li>
        @endcanany
        @canany(['service-create','service-edit','service-delete','service-publish'])
        <li class="nav-item">
            <a href="{{ route('service.index') }}" class="nav-link">
                <i class="nav-icon fas fa-building"></i>
                <p>Properties</p>
            </a>
        </li>
        @endcanany
        @canany(['blog-create','blog-edit','blog-delete','blog-publish'])
        <li class="nav-item">
            <a href="{{ route('gallery.index') }}" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>Gallery</p>
            </a>
        </li>
        @endcanany

        @canany(['blog-create','blog-edit','blog-delete','blog-publish'])
        <li class="nav-item">
            <a href="{{ route('blog.index') }}" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>Blogs</p>
            </a>
        </li>
        @endcanany

        @can('enquiry-read')
        <li class="nav-item">
            <a href="{{ route('enquiry.index') }}" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>Enquiry</p>
            </a>
        </li>
        @endcanany

        @hasanyrole('CEO|Admin|Super Admin')
        <li class="nav-item">
            <a href="{{ route('setting.index') }}" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                    Settings
                    <i class="fas fa-angle-left right"></i>

                </p>
            </a>
            <ul class="nav nav-treeview">
                @can('general-setting')
                <li class="nav-item">
                    <a href="{{ route('setting.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>General Setting</p>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endhasanyrole

        @hasrole('CEO')
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                    Administrators
                    <i class="fas fa-angle-left right"></i>

                </p>
            </a>
            <ul class="nav nav-treeview">
                @canany(['role-create','role-edit','role-delete','role-publish'])
                <li class="nav-item">
                    <a href="{{ route('roles.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Roles</p>
                    </a>
                </li>
                @endcanany
                @canany(['permission-create','permission-edit','permission-delete','permission-publish'])
                <li class="nav-item">
                    <a href="{{ route('permission.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Permission</p>
                    </a>
                </li>
                @endcanany
                @canany(['user-create','user-edit','user-delete','user-publish'])
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Users</p>
                    </a>
                </li>
                @endcanany
            </ul>
        </li>
        @endhasrole
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ __('Logout') }}</p>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</nav>