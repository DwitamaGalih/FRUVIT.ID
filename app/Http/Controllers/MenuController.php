<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $selectedCategory = $request->query('kategori');
        $search = $request->query('cari');

        $productsQuery = Product::with('category');

        if ($selectedCategory && $selectedCategory !== 'semua') {
            $productsQuery->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory);
            });
        }

        if ($search) {
            $productsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $productsQuery
            ->orderByRaw('CASE WHEN is_available = 1 AND stock > 0 THEN 0 ELSE 1 END')
            ->orderBy('sort_order')
            ->get();
        $storeStatus = Setting::get('store_status', 'open');

        return view('pages.menu', compact('categories', 'products', 'selectedCategory', 'search', 'storeStatus'));
    }

    public function detail(Product $product): JsonResponse
    {
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => (float) $product->price,
            'formatted_price' => $product->formatted_price,
            'image_url' => $product->image_url,
            'badge' => $product->badge,
            'category' => $product->category?->name ?? 'Menu',
            'category_slug' => $product->category?->slug ?? '',
            'stock' => $product->stock,
            'is_available' => (bool) $product->is_available,
            'is_sold_out' => $product->is_sold_out,
        ]);
    }
}
