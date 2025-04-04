<nav class="sidebar sidebar-offcanvas border border-right-dark shadow-sm" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="{{ route('usuario.perfil') }}" class="nav-link">
                <div class="nav-profile-image">
                    @if (Auth::user()->avatar)
                        <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar" width="100">
                    @else
                        <img src="{{ asset('assets/admin/images/faces/face1.jpg') }}" alt="profile" width="100">
                    @endif
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
                    <span class="text-secondary text-small">{{ Auth::user()->email }}</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('home') }}">
                <span class="menu-title">Tablero</span>
                <i class="mdi mdi-view-dashboard menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-administracion"
                aria-expanded="{{ request()->routeIs('users.*') ? 'true' : 'false' }}"
                aria-controls="ui-administracion">
                <span class="menu-title">Administración</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-settings menu-icon"></i>
            </a>
            <div class="collapse {{ request()->routeIs('users.*') ||
            request()->routeIs('coupons.*') ||
            request()->routeIs('business.*') ||
            request()->routeIs('sliders.*')
                ? 'show'
                : '' }}"
                id="ui-administracion">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                            href="{{ route('users.index') }}">
                            Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('business.index') ? 'active' : '' }}"
                            href="{{ route('business.index') }}">
                            Empresa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('coupons.index') ? 'active' : '' }}"
                            href="{{ route('coupons.index') }}">
                            Cupones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('sliders.index') ? 'active' : '' }}"
                            href="{{ route('sliders.index') }}">
                            Sliders
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li
            class="nav-item {{ request()->routeIs('categories.*') || request()->routeIs('brands.*') || request()->routeIs('products.*') ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-inventario"
                aria-expanded="{{ request()->routeIs('categories.*') || request()->routeIs('brands.*') || request()->routeIs('products.*') ? 'true' : 'false' }}"
                aria-controls="ui-inventario">
                <span class="menu-title">Inventario</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-archive menu-icon"></i>
            </a>
            <div class="collapse {{ request()->routeIs('categories.*') || request()->routeIs('brands.*') || request()->routeIs('products.*') ? 'show' : '' }}"
                id="ui-inventario">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}"
                            href="{{ route('categories.index') }}">
                            Categorías
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('brands.index') ? 'active' : '' }}"
                            href="{{ route('brands.index') }}">
                            Marcas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}"
                            href="{{ route('products.index') }}">
                            Productos
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item {{ request()->routeIs('orders*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('orders.index') }}">
                <span class="menu-title">Pedidos</span>
                <i class="mdi mdi-package-variant-closed menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-post"
                aria-expanded="{{ request()->routeIs('admin.posts.*') ? 'true' : 'false' }}" aria-controls="ui-post">
                <span class="menu-title">Entradas</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-folder-outline menu-icon"></i> <!-- 📁 Carpeta -->
            </a>
            <div class="collapse {{ request()->routeIs('admin.posts.*') ? 'show' : '' }}" id="ui-post">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.posts.index') ? 'active' : '' }}"
                            href="{{ route('admin.posts.index') }}">
                            Blog
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.comments.index') ? 'active' : '' }}"
                            href="{{ route('admin.comments.index') }}">
                            Comentarios
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item {{ request()->routeIs('admin.ratings*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.ratings.index') }}">
                <span class="menu-title">Calificaciones</span>
                <i class="mdi mdi-star-circle menu-icon"></i> <!-- ⭐ Estrella -->
            </a>
        </li>



    </ul>

</nav>
