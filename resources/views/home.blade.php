@extends('admin.layouts.app')

@section('title', 'Panel de Administración')

@section('content')

    <div class="row">
        <div class="col-xxl-8 d-flex align-items-stretch">
            <div class="card w-100 overflow-hidden rounded-4">
                <div class="card-body position-relative p-4">
                    <div class="row">
                        <div class="col-12 col-sm-7">
                            <div class="d-flex align-items-center gap-3 mb-5">
                                @if (Auth::user()->avatar)
                                    <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar" width="60"
                                        height="60" class="rounded-circle bg-grd-info p-1">
                                @else
                                    <img src="{{ asset('assets/admin/images/avatars/01.png') }}"
                                        class="rounded-circle bg-grd-info p-1" width="60" height="60" alt="">
                                @endif
                                <div>
                                    <p class="mb-0 fw-semibold">Bienvenido de nuevo</p>
                                    <h4 class="fw-semibold mb-0 fs-4 mb-0">{{ Auth::user()->name }}</h4>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-5">
                                <!-- Ventas -->
                                <div>
                                    <h4 class="mb-1 fw-semibold d-flex align-items-center">
                                        {{ number_format($weeklySales, 2) }}
                                        <i
                                            class="ti {{ $weeklySales >= $lastWeekSales ? 'ti-arrow-up-right text-success' : 'ti-arrow-down-right text-danger' }} fs-5 lh-base ms-1"></i>
                                    </h4>
                                    <p class="mb-3">Ventas Semanales</p>
                                    <div class="progress mb-0" style="height:5px;">
                                        <div class="progress-bar bg-grd-success" role="progressbar"
                                            style="width: {{ min($salesPercentage, 100) }}%"
                                            aria-valuenow="{{ $salesPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>

                                <div class="vr"></div>

                                <!-- Pedidos -->
                                <div>
                                    <h4 class="mb-1 fw-semibold d-flex align-items-center">
                                        {{ number_format($weeklyOrders, 2) }}
                                        <i
                                            class="ti {{ $weeklyOrders >= $lastWeekOrders ? 'ti-arrow-up-right text-success' : 'ti-arrow-down-right text-danger' }} fs-5 lh-base ms-1"></i>
                                    </h4>
                                    <p class="mb-3">Pedidos Semanales</p>
                                    <div class="progress mb-0" style="height:5px;">
                                        <div class="progress-bar bg-grd-danger" role="progressbar"
                                            style="width: {{ min($ordersPercentage, 100) }}%"
                                            aria-valuenow="{{ $ordersPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-5">
                            <div class="welcome-back-img pt-4">
                                <img src="{{ asset('assets/admin/images/gallery/welcome-back-3.png') }}" height="180"
                                    alt="">
                            </div>
                        </div>
                    </div><!--end row-->
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 col-xxl-3 d-flex flex-column">
            <div class="card rounded-4 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <p class="mb-1">Posts</p>
                            <h3 class="mb-0">{{ $currentPosts }}</h3>
                        </div>
                        <div class="wh-42 d-flex align-items-center justify-content-center rounded-circle bg-primary">
                            <span class="material-icons-outlined fs-5 text-white">article</span>
                        </div>
                    </div>
                    <div class="progress mb-0" style="height:6px;">
                        <div class="progress-bar bg-success" role="progressbar"
                            style="width: {{ min($postPercentage, 100) }}%" aria-valuenow="{{ $postPercentage }}"
                            aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3 gap-2">
                        <div class="card-lable bg-success bg-opacity-10">
                            <p class="text-success mb-0">
                                {{ $lastMonthPosts > 0 ? number_format((($currentPosts - $lastMonthPosts) / $lastMonthPosts) * 100, 1) : '0.0' }}%
                            </p>
                        </div>
                        <p class="mb-0 font-13">del mes pasado</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 col-xxl-3 d-flex flex-column">
            <div class="card rounded-4 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <p class="mb-1">Calificaciones</p>
                            <h3 class="mb-0">{{ $currentCalificaciones }}</h3>
                        </div>
                        <div class="wh-42 d-flex align-items-center justify-content-center rounded-circle bg-warning">
                            <span class="material-icons-outlined fs-5 text-white">grade</span>
                        </div>
                    </div>
                    <div class="progress mb-0" style="height:6px;">
                        <div class="progress-bar bg-warning" role="progressbar"
                            style="width: {{ min($calificacionPercentage, 100) }}%"
                            aria-valuenow="{{ $calificacionPercentage }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3 gap-2">
                        <div class="card-lable bg-warning bg-opacity-10">
                            <p class="text-warning mb-0">
                                {{ $lastMonthCalificaciones > 0
                                    ? number_format((($currentCalificaciones - $lastMonthCalificaciones) / $lastMonthCalificaciones) * 100, 1)
                                    : '0.0' }}%
                            </p>
                        </div>
                        <p class="mb-0 font-13">del mes pasado</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 col-xxl-3 d-flex flex-column">
            <div class="card rounded-4 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <p class="mb-1">Comentarios</p>
                            <h3 class="mb-0">{{ $currentComentarios }}</h3>
                        </div>
                        <div class="wh-42 d-flex align-items-center justify-content-center rounded-circle bg-success">
                            <span class="material-icons-outlined fs-5 text-white">comment</span>
                        </div>
                    </div>
                    <div class="progress mb-0" style="height:6px;">
                        <div class="progress-bar bg-success" role="progressbar"
                            style="width: {{ min($comentarioPercentage, 100) }}%"
                            aria-valuenow="{{ $comentarioPercentage }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3 gap-2">
                        <div class="card-lable bg-success bg-opacity-10">
                            <p class="text-success mb-0">
                                {{ $lastMonthComentarios > 0
                                    ? number_format((($currentComentarios - $lastMonthComentarios) / $lastMonthComentarios) * 100, 1)
                                    : '0.0' }}%
                            </p>
                        </div>
                        <p class="mb-0 font-13">del mes pasado</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-12 col-xxl-8 d-flex align-items-stretch">
            <div class="card w-100 rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="">
                            <h5 class="mb-0">Pedidos recientes</h5>
                        </div>
                        {{-- <div class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                                data-bs-toggle="dropdown">
                                <span class="material-icons-outlined fs-5">more_vert</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Reporte PDF</a></li>
                                <li><a class="dropdown-item" href="javascript:;">Reporte Excel</a></li>
                            </ul>
                        </div> --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Nombre del artículo</th>
                                    <th>Precio</th>
                                    <th>Cliente</th>
                                    <th>Estado</th>
                                    <th>Calificación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentOrders as $order)
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="">
                                                        <img src="{{ Storage::url($item->product->image) }}"
                                                            class="rounded-circle" width="50" height="50"
                                                            alt="{{ $item->product->name }}">
                                                    </div>
                                                    <p class="mb-0">{{ \Str::limit($item->product->name, 30) }}</p>
                                                </div>
                                            </td>
                                            <td>{{ config('app.currency_symbol') }}{{ number_format($item->total, 2) }}
                                            </td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>
                                                <p
                                                    class="dash-lable mb-0 bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }} bg-opacity-10 text-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }} rounded-2">
                                                    {{ ucfirst($order->status) }}
                                                </p>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-1">
                                                    <p class="mb-0">{{ $item->product->average_rating }}</p>
                                                    <i class="material-icons-outlined text-warning fs-6">star</i>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <h6 class="mb-0 text-uppercase">Pedidos</h6>
            <hr />
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="chart-container1">
                        <canvas id="orderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <h6 class="mb-0 text-uppercase">Ventas</h6>
            <hr />
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="chart-container1">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <h6 class="mb-0 text-uppercase">Stock de Productos por Categoría</h6>
            <hr />
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="chart-container1">
                        <canvas id="stockCategoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <h6 class="mb-0 text-uppercase">Promedio de Calificación por Producto</h6>
            <hr />
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="chart-container1">
                        <canvas id="ratingChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <h6 class="mb-0 text-uppercase">Cupones</h6>
            <hr />
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="chart-container1">
                        <canvas id="cuoponChart"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6 mb-4">
            <h6 class="mb-0 text-uppercase">Métodos de Pagos</h6>
            <hr />
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="chart-container1">
                        <canvas id="paymentChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/admin/plugins/chartjs/js/Chart.min.js') }}"></script>
    <script>
        $(function() {
            "use strict";
            // chart 1
            var ctx = document.getElementById('salesChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($salesByMonth->pluck('month')),
                    datasets: [{
                        label: 'Total Ventas',
                        data: @json($salesByMonth->pluck('total_sales')),
                        backgroundColor: generateColors(@json($salesByMonth->count())),
                        pointRadius: "0",
                        borderWidth: 4
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: true,
                        labels: {
                            fontColor: '#585757',
                            boxWidth: 40
                        }
                    },
                    tooltips: {
                        enabled: false
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: true,
                                fontColor: '#585757'
                            },
                            gridLines: {
                                display: true,
                                color: "rgba(0, 0, 0, 0.07)"
                            },
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                fontColor: '#585757'
                            },
                            gridLines: {
                                display: true,
                                color: "rgba(0, 0, 0, 0.07)"
                            },
                        }]
                    }
                }
            });


            // chart 2
            var ctx = document.getElementById("orderChart").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($ordersByStatus->pluck('status')),
                    datasets: [{
                        label: 'Pedidos',
                        data: @json($ordersByStatus->pluck('count')),
                        barPercentage: .5,
                        backgroundColor: generateColors(@json($ordersByStatus->count())),
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: true,
                        labels: {
                            fontColor: '#585757',
                            boxWidth: 40
                        }
                    },
                    tooltips: {
                        enabled: true
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: true,
                                fontColor: '#585757'
                            },
                            gridLines: {
                                display: true,
                                color: "rgba(0, 0, 0, 0.07)"
                            },
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                fontColor: '#585757'
                            },
                            gridLines: {
                                display: true,
                                color: "rgba(0, 0, 0, 0.07)"
                            },
                        }]
                    }
                }
            });
            // chart 3
            new Chart(document.getElementById("paymentChart"), {
                type: 'pie',
                data: {
                    labels: @json($ordersByPaymentMethod->pluck('payment_method')),
                    datasets: [{
                        label: "Pagos",
                        backgroundColor: generateColors(@json($ordersByPaymentMethod->count())),
                        data: @json($ordersByPaymentMethod->pluck('count')),
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    title: {
                        display: true,
                        text: 'Métodos de Pagos'
                    }
                }
            });

            new Chart(document.getElementById("stockCategoryChart"), {
                type: 'bar',
                data: {
                    labels: @json($stockByCategory->pluck('category.name')),
                    datasets: [{
                        label: "Stock por Categoría",
                        backgroundColor: generateColors(@json($stockByCategory->count())),
                        data: @json($stockByCategory->pluck('total_stock'))
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    title: {
                        display: true,
                        text: 'Stock de Productos por Categoría'
                    }
                }
            });

            // chart 5
            new Chart(document.getElementById("cuoponChart"), {
                type: 'polarArea',
                data: {
                    labels: @json($couponUsage->pluck('code')),
                    datasets: [{
                        label: "Total",
                        backgroundColor: generateColors(@json($couponUsage->count())),
                        data: @json($couponUsage->pluck('used_count')),
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    title: {
                        display: true,
                        text: 'Total Cupones'
                    }
                }
            });

            new Chart(document.getElementById("ratingChart"), {
                type: 'horizontalBar',
                data: {
                    labels: @json($productRatings->pluck('product.name')),
                    datasets: [{
                        label: "Promedio de Calificación",
                        backgroundColor: generateColors(@json($productRatings->count())),
                        data: @json($productRatings->pluck('avg_rating'))
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Promedio de Calificación por Producto'
                    }
                }
            });
        });

        function generateColors(count) {
            const materialColors = [
                "#F44336", "#E91E63", "#9C27B0", "#673AB7", "#3F51B5",
                "#2196F3", "#03A9F4", "#00BCD4", "#009688", "#4CAF50",
                "#8BC34A", "#CDDC39", "#FFEB3B", "#FFC107", "#FF9800",
                "#FF5722", "#795548", "#607D8B", "#212529", "#0d6efd"
            ]; // 20 colores Material Design

            const colors = [];
            for (let i = 0; i < count; i++) {
                colors.push(materialColors[i % materialColors.length]); // Rotar colores si hay más datos
            }
            return colors;
        }
    </script>
@endpush
