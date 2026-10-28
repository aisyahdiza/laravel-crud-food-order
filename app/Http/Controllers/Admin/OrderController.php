<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $orders = Order::with('user')
            ->withCount('items')
            ->when($status && array_key_exists($status, Order::STATUSES), fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $counts = Order::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.orders.index', compact('orders', 'status', 'counts'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.menu']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Order $order)
    {
        $next = $order->next_status;

        if (! $next) {
            return back()->with('error', 'This order can no longer be moved to another status.');
        }

        $order->update([
            'status' => $next,
            'completed_at' => $next === Order::STATUS_COMPLETED ? now() : null,
        ]);

        return back()->with('success', "Order #{$order->id} is now {$order->status_label}.");
    }

    public function cancel(Order $order)
    {
        if (! $order->canBeCancelled()) {
            return back()->with('error', 'Only pending or processing orders can be cancelled.');
        }

        $order->update(['status' => Order::STATUS_CANCELLED]);

        return back()->with('success', "Order #{$order->id} has been cancelled.");
    }
}