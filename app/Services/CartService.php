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

        foreach ($cart as $key => $item) {
            $productId = $item['product_id'] ?? (is_numeric($key) ? (int) $key : 0);
            $product = Product::find($productId);
            if (! $product || ! $product->is_available) {
                // Item no longer exists or unavailable, remove from cart
                unset($cart[$key]);

                continue;
            }

            $qty = max(1, (int) $item['quantity']);
            $itemSubtotal = $product->price * $qty;
            $subtotal += $itemSubtotal;
            $count += $qty;

            $items[$key] = [
                'cart_key' => (string) $key,
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
                'sugar_level' => $item['sugar_level'] ?? null,
                'jelly_topping' => $item['jelly_topping'] ?? null,
                'pickup_day' => $item['pickup_day'] ?? null,
                'pickup_batch' => $item['pickup_batch'] ?? null,
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
     * Add product to cart with optional addons
     */
    public function add(
        int $productId,
        int $quantity = 1,
        ?string $notes = null,
        ?string $sugarLevel = null,
        ?string $jellyTopping = null,
        ?string $pickupDay = null,
        ?string $pickupBatch = null
    ): array {
        $product = Product::findOrFail($productId);
        if (! $product->is_available) {
            throw new \Exception("Produk {$product->name} saat ini sedang habis.");
        }

        $cart = Session::get(self::SESSION_KEY, []);

        // Unique key for product + add-on configuration + pickup schedule
        $key = (string) $productId;
        if ($sugarLevel || $jellyTopping || $pickupDay || $pickupBatch) {
            $addonSlug = substr(md5(($sugarLevel ?? '').'_'.($jellyTopping ?? '').'_'.($pickupDay ?? '').'_'.($pickupBatch ?? '').'_'.($notes ?? '')), 0, 6);
            $key = "{$productId}_{$addonSlug}";
        }

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
            if ($notes !== null) {
                $cart[$key]['notes'] = $notes;
            }
            if ($sugarLevel !== null) {
                $cart[$key]['sugar_level'] = $sugarLevel;
            }
            if ($jellyTopping !== null) {
                $cart[$key]['jelly_topping'] = $jellyTopping;
            }
            if ($pickupDay !== null) {
                $cart[$key]['pickup_day'] = $pickupDay;
            }
            if ($pickupBatch !== null) {
                $cart[$key]['pickup_batch'] = $pickupBatch;
            }
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'quantity' => max(1, $quantity),
                'notes' => $notes ?? '',
                'sugar_level' => $sugarLevel,
                'jelly_topping' => $jellyTopping,
                'pickup_day' => $pickupDay,
                'pickup_batch' => $pickupBatch,
            ];
        }

        Session::put(self::SESSION_KEY, $cart);

        return $this->getCart();
    }

    /**
     * Update quantity of an item
     */
    public function update(string|int $cartKey, int $quantity, ?string $notes = null): array
    {
        $cart = Session::get(self::SESSION_KEY, []);
        $key = (string) $cartKey;

        if ($quantity <= 0) {
            unset($cart[$key]);
        } elseif (isset($cart[$key])) {
            $cart[$key]['quantity'] = $quantity;
            if ($notes !== null) {
                $cart[$key]['notes'] = $notes;
            }
        }

        Session::put(self::SESSION_KEY, $cart);

        return $this->getCart();
    }

    /**
     * Remove an item from cart
     */
    public function remove(string|int $cartKey): array
    {
        $cart = Session::get(self::SESSION_KEY, []);
        unset($cart[(string) $cartKey]);
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
