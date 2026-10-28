<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $categoryId = $request->query('category');
        $availability = $request->query('status');
        $sort = $request->query('sort', 'name_asc');

        $sorts = [
            'name_asc' => ['name', 'asc'],
            'name_desc' => ['name', 'desc'],
            'price_asc' => ['price', 'asc'],
            'price_desc' => ['price', 'desc'],
            'newest' => ['created_at', 'desc'],
        ];
        [$column, $direction] = $sorts[$sort] ?? $sorts['name_asc'];

        $menus = Menu::with('category')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->when($availability === 'available', fn ($query) => $query->where('is_available', true))
            ->when($availability === 'sold_out', fn ($query) => $query->where('is_available', false))
            ->orderBy($column, $direction)
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();
        $total = Menu::count();

        return view('admin.menus.index', compact(
            'menus', 'categories', 'total', 'search', 'categoryId', 'availability', 'sort'
        ));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.menus.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if($request->hasFile('image')){
            $data['image_link'] = $request->file('image')->store('menus', 'public');
        }

        Menu::create($data);

        return redirect()->route('admin.menus.index')->with('success', 'Menu added successfully.');
    }

    public function edit(Menu $menu)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $this->validated($request);

        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
        ], [
            'category_id.required' => 'Please choose a category.',
        ]);

        if ($request->hasFile('image')){
            $this->deleteImage($menu);
            $data['image_link'] = $request->file('image')->store('menus', 'public');
        } elseif ($request->boolean('remove_image')){
            $this->deleteImage($menu);
            $data['image_link'] = null;
        }

        $menu->update($data);

        return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->orderItems()->exists()) {
            return redirect()->route('admin.menus.index')->with('error', 'This menus is part of existing orders and cannot be deleted. Mark it as sold out instead.');
        }

        $this->deleteImage($menu);
        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted successfully.');
    }

    public function toggle(Menu $menu)
    {
        $menu->update(['is_available' => ! $menu->is_available]);
        return redirect()->back()->with('success', $menu->is_available ? 'Menu marked as available.' : 'Menu marked as sold out.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        $data['is_available'] = $request->boolean('is_available');
        unset($data['image'], $data['remove_image']);
        return $data;
    }

    private function deleteImage(Menu $menu): void
    {
        if ($menu->image_link) {
            Storage::disk('public')->delete($menu->image_link);
        }
    }
}
