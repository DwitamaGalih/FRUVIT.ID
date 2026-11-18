<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected const SESSION_KEY = 'fruvit_cart';

    /**
     * Get all cart items and totals
     */
    public function getCart(): array
    {
        $cart = Session::get(self::SESSION_KEY, []);
        $items = [];
        $subtotal = 0;
        $count = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if (! $product || ! $product->is_available) {
                // Item no longer exists or unavailable, remove from cart
                unset($cart[$productId]);

                continue;
            }

            $qty = max(1, (int) $item['quantity']);
            $itemSubtotal = $product->price * $qty;
            $subtotal += $itemSubtotal;
            $count += $qty;

            $items[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'formatted_price' => $product->formatted_price,
                'quantity' => $qty,
                'subtotal' => (float) $itemSubtotal,
                'formatted_subtotal' => 'Rp '.number_format($itemSubtotal, 0, ',', '.'),
                'image_url' => $product->image_url,
                'badge' => $product->badge,
                'notes' => $item['notes'] ?? '',
                'category_name' => $product->category?->name ?? 'Menu',
            ];
        }

        Session::put(self::SESSION_KEY, $cart);

        return [
            'items' => $items,
            'count' => $count,
            'subtotal' => $subtotal,
            'formatted_subtotal' => 'Rp '.number_format($subtotal, 0, ',', '.'),
        ];
    }

    /**
     * Add product to cart
     */
    public function add(int $productId, int $quantity = 1, ?string $notes = null): array
    {
        $product = Product::findOrFail($productId);
        if (! $product->is_available) {
            throw new \Exception("Produk {$product->name} saat ini sedang habis.");
        }

        $cart = Session::get(self::SESSION_KEY, []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
            if ($notes !== null) {
                $cart[$productId]['notes'] = $notes;
            }
        } else {
            $cart[$productId] = [
                'product_id' => $product->id,
                'quantity' => max(1, $quantity),
                'notes' => $notes ?? '',
            ];
        }

        Session::put(self::SESSION_KEY, $cart);

        return $this->getCart();
    }

    /**
     * Update quantity of an item
     */
    public function update(int $productId, int $quantity, ?string $notes = null): array
    {
        $cart = Session::get(self::SESSION_KEY, []);

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } elseif (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            if ($notes !== null) {
                $cart[$productId]['notes'] = $notes;
            }
        }

        Session::put(self::SESSION_KEY, $cart);

        return $this->getCart();
    }

    /**
     * Remove an item from cart
     */
    public function remove(int $productId): array
    {
        $cart = Session::get(self::SESSION_KEY, []);
        unset($cart[$productId]);
        Session::put(self::SESSION_KEY, $cart);

        return $this->getCart();
    }

    /**
     * Clear the whole cart
     */
    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }
}
