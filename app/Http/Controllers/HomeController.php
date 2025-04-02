<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Finance;
use App\Models\Member;
use App\Models\Order;
use App\Models\OrderItem;
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

        $weeklySales = Order::where('status', 'completed')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('total');

        $weeklyOrders = Order::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

        $onlineVisitors = rand(50, 500);

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
            'weeklyOrders',
            'onlineVisitors'
        ));
    }
}
