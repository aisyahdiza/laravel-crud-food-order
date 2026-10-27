<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $menus = Menu::with('category')
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->q.'%'))
            ->when($request->filled('category'), fn ($q) => $q->where('category_id', $request->category))
            ->orderByDesc('is_available')
            ->orderBy('name')
            ->get();

        $carts = Cart::where('user_id', auth()->id())->get()->keyBy('menu_id');

        return view('customer.catalog', compact('menus', 'categories', 'carts'));
    }
}