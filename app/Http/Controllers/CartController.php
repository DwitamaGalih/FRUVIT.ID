<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function index(): View
    {
        $cart = $this->cartService->getCart();

        return view('pages.cart', compact('cart'));
    }

    public function getJson(): JsonResponse
    {
        $cart = $this->cartService->getCart();

        return response()->json($cart);
    }

    public function add(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'notes' => 'nullable|string|max:255',
            'sugar_level' => 'nullable|string|max:50',
            'jelly_topping' => 'nullable|string|max:50',
            'pickup_day' => 'nullable|string|max:50',
            'pickup_batch' => 'nullable|string|max:50',
        ]);

        $quantity = $validated['quantity'] ?? 1;
        $notes = $validated['notes'] ?? null;
        $sugarLevel = $validated['sugar_level'] ?? null;
        $jellyTopping = $validated['jelly_topping'] ?? null;
        $pickupDay = $validated['pickup_day'] ?? null;
        $pickupBatch = $validated['pickup_batch'] ?? null;

        $cart = $this->cartService->add(
            (int) $validated['product_id'],
            $quantity,
            $notes,
            $sugarLevel,
            $jellyTopping,
            $pickupDay,
            $pickupBatch
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang!',
                'cart' => $cart,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'cart_key' => 'nullable|string',
            'product_id' => 'nullable',
            'quantity' => 'required|integer|min:0',
            'notes' => 'nullable|string|max:255',
        ]);

        $cartKey = $validated['cart_key'] ?? $validated['product_id'];

        $cart = $this->cartService->update(
            $cartKey,
            (int) $validated['quantity'],
            $validated['notes'] ?? null
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'cart' => $cart,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function remove(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'cart_key' => 'nullable|string',
            'product_id' => 'nullable',
        ]);

        $cartKey = $validated['cart_key'] ?? $validated['product_id'];

        $cart = $this->cartService->remove($cartKey);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk dihapus dari keranjang.',
                'cart' => $cart,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang.');
    }

    public function clear(Request $request): JsonResponse|RedirectResponse
    {
        $this->cartService->clear();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Keranjang dikosongkan.',
            ]);
        }

        return redirect()->route('menu.index')->with('success', 'Keranjang telah dikosongkan.');
    }
}
