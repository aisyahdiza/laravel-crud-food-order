<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = DB::table('orders')->count();
        $todayOrders = DB::table('orders')->whereDate('created_at', today())->count();
        $activeOrders = DB::table('orders')
            ->whereIn('status', ['pending', 'preparing', 'ready'])->count();
        $revenue = DB::table('orders')->where('status', 'completed')->sum('total_price');

        $topMenus = DB::table('order_items')
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'completed')
            ->select('menus.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('menus.id', 'menus.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        $recentOrders = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.id', 'users.name', 'orders.table_number',
                     'orders.total_price', 'orders.status', 'orders.created_at')
            ->orderByDesc('orders.created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders', 'todayOrders', 'activeOrders', 'revenue', 'topMenus', 'recentOrders'
        ));
    }
}