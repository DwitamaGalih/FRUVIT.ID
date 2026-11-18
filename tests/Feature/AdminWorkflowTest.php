<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected Category $category;

    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin FRUVIT',
            'email' => 'admin@fruvit.id',
            'password' => Hash::make('password123'),
        ]);

        $this->category = Category::create([
            'name' => 'Susu Jelly',
            'slug' => 'susu-jelly',
            'icon' => '🥤',
            'is_active' => true,
        ]);

        $this->product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Susu Jelly Pisang',
            'slug' => 'susu-jelly-pisang',
            'price' => 12500,
            'is_available' => true,
            'stock' => 50,
        ]);
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_login_successfully(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@fruvit.id',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->admin);
    }

    public function test_admin_can_view_dashboard_and_orders(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard Pengelola FRUVIT.ID');
    }

    public function test_admin_can_update_order_status(): void
    {
        $order = Order::create([
            'order_number' => 'FRV-TEST-9999',
            'customer_name' => 'Rina Gunawan',
            'customer_phone' => '089912345678',
            'delivery_method' => 'pickup',
            'subtotal' => 12500,
            'delivery_fee' => 0,
            'total_amount' => 12500,
            'payment_method' => 'qris',
            'payment_status' => 'pending_verification',
            'order_status' => 'new',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.orders.status', $order), [
            'payment_status' => 'paid',
            'order_status' => 'processing',
        ]);

        $response->assertSessionHas('success');

        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('processing', $order->order_status);
        $this->assertNotNull($order->payment_confirmed_at);
    }

    public function test_admin_can_toggle_product_status(): void
    {
        $this->assertTrue($this->product->is_available);

        $response = $this->actingAs($this->admin)->post(route('admin.products.toggle', $this->product));
        $response->assertSessionHas('success');

        $this->product->refresh();
        $this->assertFalse($this->product->is_available);
    }

    public function test_admin_can_export_orders_to_excel(): void
    {
        Order::create([
            'order_number' => 'FRV-EXCEL-001',
            'customer_name' => 'Fajar Pratama',
            'customer_phone' => '081299998888',
            'delivery_method' => 'pickup',
            'subtotal' => 12500,
            'delivery_fee' => 0,
            'total_amount' => 12500,
            'payment_method' => 'qris',
            'payment_status' => 'paid',
            'order_status' => 'completed',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.reports.excel'));

        $response->assertStatus(200);
        $this->assertStringContainsString('application/vnd.ms-excel', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('Laporan_Penjualan_FRUVIT_', $response->headers->get('Content-Disposition'));
    }
}
