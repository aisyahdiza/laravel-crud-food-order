<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    private function guard(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        if ($order->status !== 'completed') {
            return redirect()->route('customer.order')
                ->with('error', 'Order can only be reviewed after completed.');
        }

        if ($order->review()->exists()) {
            return redirect()->route('customer.order')
                ->with('error', 'Order already reviewed.');
        }

        return null;
    }

    public function create(Order $order)
    {
        if ($redirect = $this->guard($order)) {
            return $redirect;
        }

        $order->load('items.menu');

        return view('customer.review', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        if ($redirect = $this->guard($order)) {
            return $redirect;
        }

        $data = $request->validate([
            'rating' => ['required', 'numeric', 'between:0.5,5', 'multiple_of:0.5'],
            'comment' => ['nullable', 'string', 'max:255'],
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);

        return redirect()->route('customer.order')
            ->with('success', 'Thank you for the review!');
    }
}