@extends('admin.layouts.app')

@section('title', 'Panel de Administración')

@section('content')

    <div class="row">
        <!-- Ventas semanales -->
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/admin/images/dashboard/circle.svg') }}" class="card-img-absolute"
                        alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Ventas Semanales <i
                            class="mdi mdi-chart-line mdi-24px float-right"></i></h4>
                    <h2 class="">$ {{ number_format($weeklySales, 2) }}</h2>
                </div>
            </div>
        </div>

        <!-- Pedidos semanales -->
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/admin/images/dashboard/circle.svg') }}" class="card-img-absolute"
                        alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Pedidos Semanales <i
                            class="mdi mdi-cart-outline mdi-24px float-right"></i></h4>
                    <h2 class="">{{ number_format($weeklyOrders) }}</h2>
                </div>
            </div>
        </div>

        <!-- Visitantes en línea -->
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/admin/images/dashboard/circle.svg') }}" class="card-img-absolute"
                        alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Visitantes en Línea <i
                            class="mdi mdi-account-group-outline mdi-24px float-right"></i></h4>
                    <h2 class="">{{ number_format($onlineVisitors) }}</h2>
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
    <script src="{{ asset('assets/admin/vendors/chartjs/js/Chart.min.js') }}"></script>
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
                    maintainAspectRatio: true,
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
