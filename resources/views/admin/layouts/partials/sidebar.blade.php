<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="logo-icon">
            <img src="{{ asset('assets/principal/img/logo/logo.png') }}" class="logo-img" alt="">
        </div>
        <div class="sidebar-close">
            <span class="material-icons-outlined">close</span>
        </div>
    </div>
    <div class="sidebar-nav">
        <!--navigation-->
        <ul class="metismenu" id="sidenav">
            <li class="{{ request()->routeIs('home') ? 'mm-active' : '' }}">
                <a href="{{ route('home') }}">
                    <div class="parent-icon"><i class="material-icons-outlined">home</i></div>
                    <div class="menu-title">Tablero</div>
                </a>
            </li>

            <li
                class="{{ request()->routeIs('users.*') || request()->routeIs('services.*') || request()->routeIs('business.*') 
                || request()->routeIs('sliders.*') || request()->routeIs('about.*') || request()->is('admin/pages/terminos*') || request()->is('admin/pages/privacidad*') ? 'mm-active' : '' }}">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="material-icons-outlined">settings</i></div>
                    <div class="menu-title">Administración</div>
                </a>
                <ul>
                    <li class="{{ request()->routeIs('users.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('users.index') }}"><i
                                class="material-icons-outlined">arrow_right</i>Usuarios</a>
                    </li>
                    <li class="{{ request()->routeIs('services.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('services.index') }}"><i
                                class="material-icons-outlined">arrow_right</i>Servicios</a>
                    </li>
                    <li class="{{ request()->routeIs('business.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('business.index') }}"><i
                                class="material-icons-outlined">arrow_right</i>Empresa</a>
                    </li>
                    <li class="{{ request()->routeIs('sliders.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('sliders.index') }}"><i
                                class="material-icons-outlined">arrow_right</i>Sliders</a>
                    </li>
                    <li class="{{ request()->routeIs('about.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('about.index') }}"><i
                                class="material-icons-outlined">arrow_right</i>Nosotr@s</a>
                    </li>
                    <li class="{{ request()->is('admin/pages/terminos*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.pages.edit', 'terminos') }}"><i
                                class="material-icons-outlined">arrow_right</i>Términos</a>
                    </li>
                    <li class="{{ request()->is('admin/pages/privacidad*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.pages.edit', 'privacidad') }}"><i
                                class="material-icons-outlined">arrow_right</i>Privacidad</a>
                    </li>
                </ul>
            </li>


            <li class="{{ request()->routeIs('orders.*') ? 'mm-active' : '' }}">
                <a href="{{ route('orders.index') }}">
                    <div class="parent-icon"><i class="material-icons-outlined">local_shipping</i></div>
                    <div class="menu-title">Ordenes</div>
                </a>
            </li>

            <li
                class="{{ request()->routeIs('categories.*') || request()->routeIs('brands.*') || request()->routeIs('products.*') ? 'mm-active' : '' }}">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="material-icons-outlined">inventory_2</i></div>
                    <div class="menu-title">Inventario</div>
                </a>
                <ul>
                    <li class="{{ request()->routeIs('categories.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('categories.index') }}"><i
                                class="material-icons-outlined">arrow_right</i>Categorías</a>
                    </li>
                    <li class="{{ request()->routeIs('brands.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('brands.index') }}"><i
                                class="material-icons-outlined">arrow_right</i>Marcas</a>
                    </li>
                    <li class="{{ request()->routeIs('products.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('products.index') }}"><i
                                class="material-icons-outlined">arrow_right</i>Productos</a>
                    </li>
                </ul>
            </li>

            <li class="{{ request()->routeIs('coupons*') ? 'mm-active' : '' }}">
                <a href="{{ route('coupons.index') }}">
                    <div class="parent-icon"><i class="material-icons-outlined">local_offer</i></div>
                    <div class="menu-title">Cupones</div>
                </a>
            </li>


            <li
                class="{{ request()->routeIs('admin.posts.*') || request()->routeIs('admin.comments.index') ? 'mm-active' : '' }}">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="material-icons-outlined">folder</i></div>
                    <div class="menu-title">Entradas</div>
                </a>
                <ul>
                    <li class="{{ request()->routeIs('admin.posts.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.posts.index') }}"><i
                                class="material-icons-outlined">arrow_right</i>Blog</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.comments.index') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.comments.index') }}"><i
                                class="material-icons-outlined">arrow_right</i>Comentarios</a>
                    </li>
                </ul>
            </li>

            <li class="{{ request()->routeIs('admin.ratings.*') ? 'mm-active' : '' }}">
                <a href="{{ route('admin.ratings.index') }}">
                    <div class="parent-icon"><i class="material-icons-outlined">star</i></div>
                    <div class="menu-title">Calificaciones</div>
                </a>
            </li>
        </ul>

        <!--end navigation-->
    </div>
</aside>
