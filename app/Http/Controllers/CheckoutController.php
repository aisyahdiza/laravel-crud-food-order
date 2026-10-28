<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public const TABLE_COUNT = 20;

    private function cartItems()
    {
        return Cart::with('menu.category')
            ->where('user_id', auth()->id())
            ->get();
    }

    public function index()
    {
        $items = $this->cartItems();

        if ($items->isEmpty()) {
            return redirect()->route('customer.cart')->with('error', 'Cart is empty.');
        }

        if ($items->contains(fn ($i) => ! $i->menu->is_available)) {
            return redirect()->route('customer.cart')
                ->with('error', 'Remove unavailable menu from cart.');
        }

        $totalItems = $items->sum('quantity');
        $subtotal = $items->sum(fn ($i) => $i->menu->price * $i->quantity);
        $tableCount = self::TABLE_COUNT;

        return view('customer.checkout', compact('items', 'totalItems', 'subtotal', 'tableCount'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'table_number' => ['required', 'integer', 'between:1,'.self::TABLE_COUNT],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $items = $this->cartItems();

        if ($items->isEmpty() || $items->contains(fn ($i) => ! $i->menu->is_available)) {
            return redirect()->route('customer.cart')
                ->with('error', 'Empty cart or unavailable menu.');
        }

        DB::transaction(function () use ($data, $items) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'table_number' => $data['table_number'],
                'note' => $data['note'] ?? null,
                'total_price' => $items->sum(fn ($i) => $i->menu->price * $i->quantity),
                'status' => Order::STATUS_PENDING,
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'menu_id' => $item->menu_id,
                    'quantity' => $item->quantity,
                    'price' => $item->menu->price,
                ]);
            }

            Cart::where('user_id', auth()->id())->delete();
        });

        return redirect()->route('customer.order')
            ->with('success', 'Order successfully created for table number '.$data['table_number'].'.');
    }
}