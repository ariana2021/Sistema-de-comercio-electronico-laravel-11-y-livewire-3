<header class="top-header">
    <nav class="navbar navbar-expand align-items-center gap-4">
        <div class="btn-toggle">
            <a href="javascript:;"><i class="material-icons-outlined">menu</i></a>
        </div>
        <div class="search-bar flex-grow-1">

        </div>
        <ul class="navbar-nav gap-1 nav-right-links align-items-center">

            <li class="nav-item dropdown">
                <a href="javascrpt:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">

                    @if (Auth::user()->avatar)
                        <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar" width="45"
                            height="45" class="rounded-circle p-1 border">
                    @else
                        <img src="{{ asset('assets/admin/images/avatars/01.png') }}" class="rounded-circle p-1 border"
                            width="45" height="45" alt="">
                    @endif
                </a>
                <div class="dropdown-menu dropdown-user dropdown-menu-end shadow">
                    <a class="dropdown-item  gap-2 py-2" href="javascript:;">
                        <div class="text-center">
                            @if (Auth::user()->avatar)
                                <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar" width="90"
                                    height="90" class="rounded-circle p-1 shadow mb-3">
                            @else
                                <img src="{{ asset('assets/admin/images/avatars/01.png') }}"
                                    class="rounded-circle p-1 shadow mb-3" width="90" height="90"
                                    alt="">
                            @endif

                            <h5 class="user-name mb-0 fw-bold">Hola, {{ Auth::user()->name }}</h5>
                        </div>
                    </a>
                    <hr class="dropdown-divider">
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                        href="{{ route('usuario.perfil') }}"><i
                            class="material-icons-outlined">person_outline</i>Perfil</a>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('home') }}"><i
                            class="material-icons-outlined">dashboard</i>Tablero</a>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('business.index') }}"><i
                            class="material-icons-outlined">account_balance</i>Empresa</a>

                    <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        href="{{ route('logout') }}"><i
                            class="material-icons-outlined">power_settings_new</i>Salir</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>

    </nav>
</header>
