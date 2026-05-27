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
        <li class="nav-item">
            <a href="{{ route('category.index') }}" class="nav-link">
                <i class="nav-icon fas fa-th-large"></i>
                <p>Categories</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('subcategory.index') }}" class="nav-link">
                <i class="nav-icon fas fa-tags"></i>
                <p>Subcategories</p>
            </a>
        </li>

        @canany(['gallery-create','gallery-edit','gallery-delete','gallery-publish'])
        <li class="nav-item">
            <a href="{{ route('gallery.index') }}" class="nav-link">
                <i class="nav-icon fas fa-images"></i>
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

        <li class="nav-item">
            <a href="{{ route('setting.index') }}" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                    Settings
                    <i class="fas fa-angle-left right"></i>

                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('setting.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>General Setting</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                    Administrators
                    <i class="fas fa-angle-left right"></i>

                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('roles.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Roles</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('permission.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Permission</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Users</p>
                    </a>
                </li>

            </ul>
        </li>
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