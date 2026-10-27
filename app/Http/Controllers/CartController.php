<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::with('menu.category')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $totalItems = $items->sum('quantity');
        $subtotal = $items->sum(fn ($item) => $item->menu->price * $item->quantity);

        return view('customer.cart', compact('items', 'totalItems', 'subtotal'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'menu_id' => ['required', 'exists:menus,id'],
        ]);

        $menu = Menu::findOrFail($data['menu_id']);

        if (! $menu->is_available) {
            return back()->with('error', "{$menu->name} currently not available.");
        }

        $cart = Cart::firstOrNew([
            'user_id' => auth()->id(),
            'menu_id' => $menu->id,
        ]);
        $cart->quantity = ($cart->quantity ?? 0) + 1;
        $cart->save();

        return back()->with('success', "{$menu->name} added to cart.");
    }

    public function update(Request $request, Cart $cart)
    {
        abort_unless($cart->user_id === auth()->id(), 403);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        if ((int) $data['quantity'] === 0) {
            $cart->delete();
        } else {
            $cart->update($data);
        }

        return back();
    }

    public function destroy(Cart $cart)
    {
        abort_unless($cart->user_id === auth()->id(), 403);

        $cart->delete();

        return back()->with('success', 'item deleted from cart.');
    }
}