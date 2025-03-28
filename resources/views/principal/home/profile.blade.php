@extends('layouts.app')

@section('content')
    <section class="profile__area pt-120 pb-120">
        <div class="container">
            <div class="profile__inner p-relative">
                <div class="profile__shape">
                    <img class="profile__shape-3" src="{{ asset('assets/principal/img/login/login-shape-1.png') }}"
                        alt="">
                    <img class="profile__shape-4" src="{{ asset('assets/principal/img/login/login-shape-2.png') }}"
                        alt="">
                    <img class="profile__shape-5" src="{{ asset('assets/principal/img/login/login-shape-3.png') }}"
                        alt="">
                    <img class="profile__shape-6" src="{{ asset('assets/principal/img/login/login-shape-4.png') }}"
                        alt="">
                </div>
                <div class="row">
                    <div class="col-xxl-4 col-lg-4">
                        <div class="profile__tab mr-40">
                            <nav>
                                <div class="nav nav-tabs tp-tab-menu flex-column" id="profile-tab" role="tablist">
                                    <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-profile" type="button" role="tab"
                                        aria-controls="nav-profile" aria-selected="false">
                                        <span><i class="fa-regular fa-user-pen"></i></span> Perfil
                                    </button>
                                    <button class="nav-link" id="nav-information-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-information" type="button" role="tab"
                                        aria-controls="nav-information" aria-selected="false">
                                        <span><i class="fa-regular fa-circle-info"></i></span> Información
                                    </button>
                                    <button class="nav-link" id="nav-order-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-order" type="button" role="tab" aria-controls="nav-order"
                                        aria-selected="false">
                                        <span><i class="fa-light fa-clipboard-list-check"></i></span> Mis Pedidos
                                    </button>
                                    <button class="nav-link" id="nav-password-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-password" type="button" role="tab"
                                        aria-controls="nav-password" aria-selected="false">
                                        <span><i class="fa-regular fa-lock"></i></span> Cambiar Contraseña
                                    </button>
                                    <span id="marker-vertical" class="tp-tab-line d-none d-sm-inline-block"></span>
                                </div>
                            </nav>

                        </div>
                    </div>
                    <div class="col-xxl-8 col-lg-8">
                        <div class="profile__tab-content">
                            <div class="tab-content" id="profile-tabContent">
                                <div class="tab-pane fade show active" id="nav-profile" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <div class="profile__main">
                                        <div class="profile__main-top pb-80">
                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <div class="profile__main-inner d-flex flex-wrap align-items-center">
                                                        <div class="profile__main-thumb">
                                                            <img src="{{ asset('assets/principal/img/users/user-10.jpg') }}"
                                                                alt="">
                                                            <div class="profile__main-thumb-edit">
                                                                <input id="profile-thumb-input" class="profile-img-popup"
                                                                    type="file">
                                                                <label for="profile-thumb-input"><i
                                                                        class="fa-light fa-camera"></i></label>
                                                            </div>
                                                        </div>
                                                        <div class="profile__main-content">
                                                            <h4 class="profile__main-title">Bienvenido
                                                                {{ auth()->user()->name }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="profile__main-logout text-sm-end">
                                                        <form action="{{ route('logout') }}" method="POST"
                                                            style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="tp-logout-btn">Salir</button>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="profile__main-info">
                                            <div class="row gx-3">
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="profile__main-info-item">
                                                        <div class="profile__main-info-icon">
                                                            <span>
                                                                <span
                                                                    class="profile-icon-count profile-order">{{ $ordersCount }}</span>
                                                                <svg viewBox="0 0 512 512">
                                                                    <path
                                                                        d="M472.916,224H448.007a24.534,24.534,0,0,0-23.417-18H398V140.976a6.86,6.86,0,0,0-3.346-6.062L207.077,26.572a6.927,6.927,0,0,0-6.962,0L12.48,134.914A6.981,6.981,0,0,0,9,140.976V357.661a7,7,0,0,0,3.5,6.062L200.154,472.065a7,7,0,0,0,3.5.938,7.361,7.361,0,0,0,3.6-.938L306,415.108v41.174A29.642,29.642,0,0,0,335.891,486H472.916A29.807,29.807,0,0,0,503,456.282v-202.1A30.2,30.2,0,0,0,472.916,224Zm-48.077-4A10.161,10.161,0,0,1,435,230.161v.678A10.161,10.161,0,0,1,424.839,241H384.161A10.161,10.161,0,0,1,374,230.839v-.678A10.161,10.161,0,0,1,384.161,220ZM203.654,40.717l77.974,45.018L107.986,185.987,30.013,140.969ZM197,453.878,23,353.619V153.085L197,253.344Zm6.654-212.658-81.668-47.151L295.628,93.818,377.3,140.969ZM306,254.182V398.943l-95,54.935V253.344L384,153.085V206h.217A24.533,24.533,0,0,0,360.8,224H335.891A30.037,30.037,0,0,0,306,254.182Zm183,202.1A15.793,15.793,0,0,1,472.916,472H335.891A15.628,15.628,0,0,1,320,456.282v-202.1A16.022,16.022,0,0,1,335.891,238h25.182a23.944,23.944,0,0,0,23.144,17H424.59a23.942,23.942,0,0,0,23.143-17h25.183A16.186,16.186,0,0,1,489,254.182Z" />
                                                                    <path
                                                                        d="M343.949,325h7.327a7,7,0,1,0,0-14H351V292h19.307a6.739,6.739,0,0,0,6.655,4.727A7.019,7.019,0,0,0,384,289.743v-4.71A7.093,7.093,0,0,0,376.924,278H343.949A6.985,6.985,0,0,0,337,285.033v32.975A6.95,6.95,0,0,0,343.949,325Z" />
                                                                    <path
                                                                        d="M344,389h33a7,7,0,0,0,7-7V349a7,7,0,0,0-7-7H344a7,7,0,0,0-7,7v33A7,7,0,0,0,344,389Zm7-33h19v19H351Z" />
                                                                    <path
                                                                        d="M351.277,439H351V420h18.929a7.037,7.037,0,0,0,14.071.014v-6.745A7.3,7.3,0,0,0,376.924,406H343.949A7.191,7.191,0,0,0,337,413.269v32.975A6.752,6.752,0,0,0,343.949,453h7.328a7,7,0,1,0,0-14Z" />
                                                                    <path
                                                                        d="M393.041,286.592l-20.5,20.5-6.236-6.237a7,7,0,1,0-9.9,9.9l11.187,11.186a7,7,0,0,0,9.9,0l25.452-25.452a7,7,0,0,0-9.9-9.9Z" />
                                                                    <path
                                                                        d="M393.041,415.841l-20.5,20.5-6.236-6.237a7,7,0,1,0-9.9,9.9l11.187,11.186a7,7,0,0,0,9.9,0l25.452-25.452a7,7,0,0,0-9.9-9.9Z" />
                                                                    <path
                                                                        d="M464.857,295H420.891a7,7,0,0,0,0,14h43.966a7,7,0,0,0,0-14Z" />
                                                                    <path
                                                                        d="M464.857,359H420.891a7,7,0,0,0,0,14h43.966a7,7,0,0,0,0-14Z" />
                                                                    <path
                                                                        d="M464.857,423H420.891a7,7,0,0,0,0,14h43.966a7,7,0,0,0,0-14Z" />
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <h4 class="profile__main-info-title">Ordenes</h4>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="profile__main-info-item">
                                                        <div class="profile__main-info-icon">
                                                            <span>
                                                                <span
                                                                    class="profile-icon-count profile-wishlist">{{ $wishlistCount }}</span>
                                                                <svg viewBox="0 -20 480 480"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="m348 0c-43 .0664062-83.28125 21.039062-108 56.222656-24.71875-35.183594-65-56.1562498-108-56.222656-70.320312 0-132 65.425781-132 140 0 72.679688 41.039062 147.535156 118.6875 216.480469 35.976562 31.882812 75.441406 59.597656 117.640625 82.625 2.304687 1.1875 5.039063 1.1875 7.34375 0 42.183594-23.027344 81.636719-50.746094 117.601563-82.625 77.6875-68.945313 118.726562-143.800781 118.726562-216.480469 0-74.574219-61.679688-140-132-140zm-108 422.902344c-29.382812-16.214844-224-129.496094-224-282.902344 0-66.054688 54.199219-124 116-124 41.867188.074219 80.460938 22.660156 101.03125 59.128906 1.539062 2.351563 4.160156 3.765625 6.96875 3.765625s5.429688-1.414062 6.96875-3.765625c20.570312-36.46875 59.164062-59.054687 101.03125-59.128906 61.800781 0 116 57.945312 116 124 0 153.40625-194.617188 266.6875-224 282.902344zm0 0" />
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <h4 class="profile__main-info-title">Lista de deseos</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-information" role="tabpanel"
                                    aria-labelledby="nav-information-tab">
                                    <div class="profile__info">
                                        <h3 class="profile__info-title">Detalles Personales</h3>
                                        <div class="profile__info-content">
                                            <form id="profileForm">
                                                <div class="row">
                                                    <div class="col-xxl-6 col-md-6">
                                                        <div class="profile__input-box">
                                                            <div class="profile__input">
                                                                <input type="text" id="name"
                                                                    placeholder="Ingrese su nombre de usuario"
                                                                    value="{{ old('name', Auth::user()->name) }}" required>
                                                                <span><i class="fa-solid fa-user"></i></span>
                                                                <small class="error-message text-danger"></small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xxl-6 col-md-6">
                                                        <div class="profile__input-box">
                                                            <div class="profile__input">
                                                                <input type="email" id="email"
                                                                    placeholder="Ingrese su correo electrónico"
                                                                    value="{{ old('email', Auth::user()->email) }}"
                                                                    required>
                                                                <span><i class="fa-solid fa-envelope"></i></span>
                                                                <small class="error-message text-danger"></small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xxl-6 col-md-6">
                                                        <div class="profile__input-box">
                                                            <div class="profile__input">
                                                                <input type="url" id="website"
                                                                    placeholder="Ingrese su sitio web"
                                                                    value="{{ old('website', Auth::user()->website) }}">
                                                                <span><i class="fa-solid fa-globe"></i></span>
                                                                <small class="error-message text-danger"></small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xxl-6 col-md-6">
                                                        <div class="profile__input-box">
                                                            <div class="profile__input">
                                                                <input type="tel" id="phone"
                                                                    placeholder="Ingrese su número"
                                                                    value="{{ old('phone', Auth::user()->phone) }}"
                                                                    required>
                                                                <span><i class="fa-solid fa-phone"></i></span>
                                                                <small class="error-message text-danger"></small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xxl-12">
                                                        <div class="profile__input-box">
                                                            <div class="profile__input">
                                                                <input type="text" id="address"
                                                                    placeholder="Ingrese su dirección"
                                                                    value="{{ old('address', Auth::user()->address) }}"
                                                                    required>
                                                                <span><i class="fa-solid fa-location-dot"></i></span>
                                                                <small class="error-message text-danger"></small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xxl-12">
                                                        <div class="profile__btn">
                                                            <button type="submit" class="tp-btn">Actualizar
                                                                Perfil</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="nav-password" role="tabpanel"
                                    aria-labelledby="nav-password-tab">
                                    <div class="profile__password">
                                        <form id="passwordForm">
                                            <div class="row">
                                                <div class="col-xxl-12">
                                                    <div class="tp-profile-input-box">
                                                        <div class="tp-contact-input">
                                                            <input name="old_pass" id="old_pass" type="password">
                                                            <small class="error-message text-danger"></small>
                                                        </div>
                                                        <div class="tp-profile-input-title">
                                                            <label for="old_pass">Contraseña Actual</label>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-xxl-6 col-md-6">
                                                    <div class="tp-profile-input-box">
                                                        <div class="tp-profile-input">
                                                            <input name="new_pass" id="new_pass" type="password">
                                                            <small class="error-message text-danger"></small>
                                                        </div>
                                                        <div class="tp-profile-input-title">
                                                            <label for="new_pass">Nueva Contraseña</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xxl-6 col-md-6">
                                                    <div class="tp-profile-input-box">
                                                        <div class="tp-profile-input">
                                                            <input name="con_new_pass" id="con_new_pass" type="password">
                                                            <small class="error-message text-danger"></small>
                                                        </div>
                                                        <div class="tp-profile-input-title">
                                                            <label for="con_new_pass">Confirmar Contraseña</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xxl-6 col-md-6">
                                                    <div class="profile__btn">
                                                        <button type="submit" class="tp-btn">Actualizar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>


                                <div class="tab-pane fade" id="nav-order" role="tabpanel"
                                    aria-labelledby="nav-order-tab">
                                    <div class="profile__ticket table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Producto</th>
                                                    <th scope="col">Estado</th>
                                                    <th scope="col">Factura</th>
                                                    <th scope="col">Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($orders as $order)
                                                    <tr>
                                                        <th scope="row">#{{ $order->id }}</th>
                                                        <td data-info="title">
                                                            @if (is_array($order->items) || is_object($order->items))
                                                                <ul>
                                                                    @foreach ($order->items as $item)
                                                                        <li>{{ $item->product->name ?? 'Producto no disponible' }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                {{ __('Sin productos') }}
                                                            @endif
                                                        </td>
                                                        <td data-info="status {{ strtolower($order->status) }}">
                                                            {{ ucfirst($order->status) }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('order.invoice.pdf', Crypt::encrypt($order->id)) }}"
                                                                target="_blank" class="tp-logout-btn">
                                                                Factura
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('order.status', Crypt::encrypt($order->id)) }}"
                                                                class="tp-logout-btn">
                                                                Estado
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">No tienes órdenes
                                                            registradas.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('passwordForm').addEventListener('submit', async function(event) {
                event.preventDefault();

                // Limpiar mensajes de error previos
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

                // Obtener valores
                const oldPass = document.getElementById('old_pass').value.trim();
                const newPass = document.getElementById('new_pass').value.trim();
                const confirmPass = document.getElementById('con_new_pass').value.trim();

                let isValid = true;

                // Validaciones básicas
                if (oldPass.length < 6) {
                    showError('old_pass', 'La contraseña actual debe tener al menos 6 caracteres.');
                    isValid = false;
                }

                if (newPass.length < 8) {
                    showError('new_pass', 'La nueva contraseña debe tener al menos 8 caracteres.');
                    isValid = false;
                }

                if (!newPass.match(/[A-Z]/) || !newPass.match(/[0-9]/)) {
                    showError('new_pass', 'Debe contener al menos una mayúscula y un número.');
                    isValid = false;
                }

                if (newPass !== confirmPass) {
                    showError('con_new_pass', 'Las contraseñas no coinciden.');
                    isValid = false;
                }

                if (!isValid) return;

                try {
                    const response = await fetch("{{ route('profile.update.password') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: JSON.stringify({
                            old_password: oldPass,
                            new_password: newPass,
                            new_password_confirmation: confirmPass
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        alertSweet(data.message, 'success');
                        document.getElementById('passwordForm').reset();
                    } else {
                        alertSweet('Error al actualizar la contraseña.', 'error');
                    }
                } catch (error) {
                    alertSweet('Error de conexión. Inténtelo de nuevo.', 'error');
                }
            });

            document.getElementById('profileForm').addEventListener('submit', async function(event) {
                event.preventDefault();

                // Limpiar mensajes de error previos
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

                const formData = {
                    name: document.getElementById('name').value.trim(),
                    email: document.getElementById('email').value.trim(),
                    website: document.getElementById('website').value.trim(),
                    phone: document.getElementById('phone').value.trim(),
                    address: document.getElementById('address').value.trim()
                };

                // Validaciones básicas
                let isValid = true;

                if (formData.name.length < 3) {
                    showError('name', 'El nombre de usuario debe tener al menos 3 caracteres.');
                    isValid = false;
                }

                if (!formData.email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                    showError('email', 'Ingrese un correo electrónico válido.');
                    isValid = false;
                }

                if (formData.website && !formData.website.match(/^https?:\/\/[^\s$.?#].[^\s]*$/)) {
                    showError('website', 'Ingrese una URL válida.');
                    isValid = false;
                }

                if (!formData.phone.match(/^\d{9,15}$/)) {
                    showError('phone', 'El número de teléfono debe contener entre 9 y 15 dígitos.');
                    isValid = false;
                }

                if (formData.address.length < 5) {
                    showError('address', 'La dirección debe tener al menos 5 caracteres.');
                    isValid = false;
                }

                if (!isValid) return;

                try {
                    const response = await fetch("{{ route('profile.updateProfile') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute(
                                    'content')
                        },
                        body: JSON.stringify(formData)
                    });

                    const data = await response.json();

                    if (response.ok) {
                        alertSweet(data.message, 'success');
                    } else {
                        alertSweet('Hubo un error al actualizar el perfil.', 'warning');
                    }
                } catch (error) {
                    alertSweet('Error de conexión. Inténtelo de nuevo.', 'error');
                }
            });

            function showError(fieldId, message) {
                document.getElementById(fieldId).nextElementSibling.textContent = message;
            }
        });
    </script>
@endpush
