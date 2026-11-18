<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FruvitOrderFlowTest extends TestCase
{
    use RefreshDatabase;

    protected Product $product;

    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::create([
            'name' => 'Salad Buah',
            'slug' => 'salad-buah',
            'icon' => '🥗',
            'description' => 'Salad buah segar',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Salad Buah Creamy Cheese',
            'slug' => 'salad-buah-creamy-cheese',
            'description' => 'Salad buah manis creamy gurih',
            'price' => 13000,
            'badge' => 'Best Seller',
            'is_available' => true,
            'stock' => 50,
        ]);
    }

    public function test_can_view_home_page(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('FRUVIT.ID');
        $response->assertSee('Salad Buah Creamy Cheese');
    }

    public function test_can_view_menu_page_and_filter(): void
    {
        $response = $this->get(route('menu.index'));

        $response->assertStatus(200);
        $response->assertSee('Salad Buah Creamy Cheese');

        // Test filter by category
        $filteredResponse = $this->get(route('menu.index', ['kategori' => 'salad-buah']));
        $filteredResponse->assertStatus(200);
        $filteredResponse->assertSee('Salad Buah Creamy Cheese');
    }

    public function test_can_add_item_to_cart_via_json(): void
    {
        $response = $this->postJson(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity' => 2,
            'notes' => 'Ekstra keju',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'cart' => [
                'count' => 2,
                'subtotal' => 26000,
            ],
        ]);
    }

    public function test_can_checkout_and_create_order(): void
    {
        // Add to cart first
        $this->postJson(route('cart.add'), [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        // Proceed to checkout process
        $checkoutResponse = $this->post(route('checkout.process'), [
            'customer_name' => 'Budi Santoso',
            'customer_phone' => '081298765432',
            'delivery_method' => 'pickup',
            'payment_method' => 'qris',
            'notes' => 'Tolong sediakan sendok garpu ya kak',
        ]);

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Budi Santoso',
            'customer_phone' => '081298765432',
            'delivery_method' => 'pickup',
            'payment_method' => 'qris',
            'payment_status' => 'unpaid',
            'order_status' => 'new',
            'subtotal' => 26000,
            'total_amount' => 26000,
        ]);

        $order = Order::where('customer_phone', '081298765432')->first();
        $this->assertNotNull($order);
        $this->assertCount(1, $order->items);

        $checkoutResponse->assertRedirect(route('order.show', $order->order_number));
    }

    public function test_can_upload_payment_proof(): void
    {
        Storage::fake('public');

        $order = Order::create([
            'order_number' => 'FRV-TEST-0001',
            'customer_name' => 'Siti Nurhaliza',
            'customer_phone' => '081300000000',
            'delivery_method' => 'pickup',
            'subtotal' => 13000,
            'delivery_fee' => 0,
            'total_amount' => 13000,
            'payment_method' => 'transfer_bank',
            'payment_status' => 'unpaid',
            'order_status' => 'new',
        ]);

        $file = UploadedFile::fake()->create('bukti_transfer.jpg', 100, 'image/jpeg');

        $response = $this->post(route('order.upload-proof', $order->order_number), [
            'payment_proof' => $file,
        ]);

        $response->assertRedirect(route('order.show', $order->order_number));

        $order->refresh();
        $this->assertEquals('pending_verification', $order->payment_status);
        $this->assertNotNull($order->payment_proof);
        Storage::disk('public')->assertExists($order->payment_proof);
    }

    public function test_can_track_order(): void
    {
        $order = Order::create([
            'order_number' => 'FRV-TRACK-1234',
            'customer_name' => 'Dewi Lestari',
            'customer_phone' => '085712345678',
            'delivery_method' => 'pickup',
            'subtotal' => 13000,
            'delivery_fee' => 0,
            'total_amount' => 13000,
            'payment_method' => 'qris',
            'payment_status' => 'paid',
            'order_status' => 'processing',
        ]);

        $response = $this->get(route('order.track', ['q' => 'FRV-TRACK-1234']));

        $response->assertStatus(200);
        $response->assertSee('FRV-TRACK-1234');
        $response->assertSee('Dewi Lestari');
    }
}
