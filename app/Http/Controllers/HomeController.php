<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Coupon;
use App\Models\Finance;
use App\Models\Member;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Post;
use App\Models\Product;
use App\Models\Rating;
use App\Models\TemporaryCart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Total de Ventas por Mes
        $salesByMonth = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total_sales')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($sale) {
                return [
                    'month' => ucfirst(Carbon::create()->month($sale->month)->locale('es')->translatedFormat('F')),
                    'total_sales' => $sale->total_sales
                ];
            });

        // Cantidad de Pedidos por Estado
        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Pedidos por Método de Pago
        $ordersByPaymentMethod = Order::selectRaw('payment_method, COUNT(*) as count')
            ->groupBy('payment_method')
            ->get();

        // Tasa de Conversión Carrito → Compra
        $totalCartItems = DB::table('temporary_carts')->count();
        $totalOrders = Order::count();
        $cartConversionRate = $totalCartItems > 0 ? ($totalOrders / $totalCartItems) * 100 : 0;

        // Top Productos Más Vendidos
        $topProducts = OrderItem::selectRaw('product_id, SUM(quantity) as total_sold')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product')
            ->take(5)
            ->get();

        // Stock de Productos por Categoría
        $stockByCategory = Product::selectRaw('category_id, SUM(stock) as total_stock')
            ->groupBy('category_id')
            ->with('category')
            ->get();

        $productRatings = Rating::select('product_id', DB::raw('AVG(rating) as avg_rating'))
            ->groupBy('product_id')
            ->having('avg_rating', '>=', 4)
            ->with('product:id,name')
            ->inRandomOrder()
            ->limit(10)
            ->get();

        // Uso de Cupones de Descuento
        $couponUsage = Coupon::selectRaw('code, used_count')
            ->get();

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek();
        $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek();

        // Ventas completadas esta semana
        $weeklySales = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('total');

        // Ventas completadas la semana pasada
        $lastWeekSales = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->sum('total');

        // Pedidos totales esta semana
        $weeklyOrders = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();

        // Pedidos totales la semana pasada
        $lastWeekOrders = Order::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])->count();

        // Porcentajes
        $salesPercentage = $lastWeekSales > 0 ? ($weeklySales / $lastWeekSales) * 100 : ($weeklySales > 0 ? 100 : 0);
        $ordersPercentage = $lastWeekOrders > 0 ? ($weeklyOrders / $lastWeekOrders) * 100 : ($weeklyOrders > 0 ? 100 : 0);

        $now = Carbon::now();
        $startOfCurrentMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        // Posts
        $currentPosts = Post::whereBetween('created_at', [$startOfCurrentMonth, $now])->count();
        $lastMonthPosts = Post::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $postPercentage = $lastMonthPosts > 0 ? ($currentPosts / $lastMonthPosts) * 100 : ($currentPosts > 0 ? 100 : 0);

        // Calificaciones
        $currentCalificaciones = Rating::whereBetween('created_at', [$startOfCurrentMonth, $now])->count();
        $lastMonthCalificaciones = Rating::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $calificacionPercentage = $lastMonthCalificaciones > 0 ? ($currentCalificaciones / $lastMonthCalificaciones) * 100 : ($currentCalificaciones > 0 ? 100 : 0);

        // Comentarios
        $currentComentarios = Comment::whereBetween('created_at', [$startOfCurrentMonth, $now])->count();
        $lastMonthComentarios = Comment::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $comentarioPercentage = $lastMonthComentarios > 0 ? ($currentComentarios / $lastMonthComentarios) * 100 : ($currentComentarios > 0 ? 100 : 0);

        // Últimas 10 órdenes
        $recentOrders = Order::orderBy('created_at', 'desc')
            ->take(5)
            ->get();


        return view('home', compact(
            'salesByMonth',
            'ordersByStatus',
            'ordersByPaymentMethod',
            'cartConversionRate',
            'topProducts',
            'stockByCategory',
            'productRatings',
            'couponUsage',
            'weeklySales',
            'lastWeekSales',
            'salesPercentage',
            'weeklyOrders',
            'lastWeekOrders',
            'ordersPercentage',
            'currentPosts',
            'lastMonthPosts',
            'postPercentage',
            'currentCalificaciones',
            'lastMonthCalificaciones',
            'calificacionPercentage',
            'currentComentarios',
            'lastMonthComentarios',
            'comentarioPercentage',
            'recentOrders'
        ));
    }
}
