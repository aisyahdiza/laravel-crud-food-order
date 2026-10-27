<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.menu', 'review'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('customer.order', compact('orders'));
    }
}