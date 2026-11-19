<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function ($query) {
                $query->where('is_available', true)->where('stock', '>', 0);
            }])
            ->orderBy('sort_order')
            ->get();

        $bestSellers = Product::whereNotNull('badge')
            ->with('category')
            ->orderByRaw('CASE WHEN is_available = 1 AND stock > 0 THEN 0 ELSE 1 END')
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $allProducts = Product::with('category')
            ->orderByRaw('CASE WHEN is_available = 1 AND stock > 0 THEN 0 ELSE 1 END')
            ->orderBy('sort_order')
            ->get();

        $storeStatus = Setting::get('store_status', 'open');
        $storeAddress = Setting::get('store_address', 'Stand Kewirausahaan FRUVIT.ID');
        $waAdmin = Setting::get('wa_admin', '081234567890');

        return view('pages.home', compact(
            'categories',
            'bestSellers',
            'allProducts',
            'storeStatus',
            'storeAddress',
            'waAdmin'
        ));
    }
}
