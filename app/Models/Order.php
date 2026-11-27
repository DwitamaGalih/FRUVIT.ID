<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_phone',
        'delivery_method',
        'shipping_address',
        'notes',
        'subtotal',
        'delivery_fee',
        'total_amount',
        'payment_method',
        'payment_status',
        'payment_proof',
        'payment_confirmed_at',
        'order_status',
        'po_batch',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'payment_confirmed_at' => 'datetime',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp '.number_format((float) $this->subtotal, 0, ',', '.');
    }

    public function getFormattedDeliveryFeeAttribute(): string
    {
        return 'Rp '.number_format((float) $this->delivery_fee, 0, ',', '.');
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp '.number_format((float) $this->total_amount, 0, ',', '.');
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'paid' => 'Lunas',
            'pending_verification' => 'Menunggu Verifikasi',
            'unpaid' => 'Belum Dibayar',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->payment_status),
        };
    }

    public function getPaymentStatusColorAttribute(): string
    {
        return match ($this->payment_status) {
            'paid' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'pending_verification' => 'bg-amber-100 text-amber-800 border-amber-300',
            'unpaid' => 'bg-rose-100 text-rose-800 border-rose-300',
            default => 'bg-gray-100 text-gray-800 border-gray-300',
        };
    }

    public function getOrderStatusLabelAttribute(): string
    {
        return match ($this->order_status) {
            'new' => 'Pesanan Baru',
            'processing' => 'Sedang Disiapkan',
            'ready' => $this->delivery_method === 'delivery' ? 'Sedang Dikirim' : 'Siap Diambil',
            'completed' => 'Pesanan Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->order_status),
        };
    }

    public function getOrderStatusColorAttribute(): string
    {
        return match ($this->order_status) {
            'new' => 'bg-blue-100 text-blue-800 border-blue-300',
            'processing' => 'bg-amber-100 text-amber-800 border-amber-300',
            'ready' => 'bg-purple-100 text-purple-800 border-purple-300',
            'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'cancelled' => 'bg-rose-100 text-rose-800 border-rose-300',
            default => 'bg-gray-100 text-gray-800 border-gray-300',
        };
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'qris' => 'QRIS (Gopay/OVO/Dana/BCA/dll)',
            'transfer_bank' => 'Transfer Bank (BCA / Mandiri / BRI)',
            'cash' => 'Tunai / Cash saat Ambil',
            default => ucfirst($this->payment_method),
        };
    }

    public function getDeliveryMethodLabelAttribute(): string
    {
        return match ($this->delivery_method) {
            'delivery' => 'Delivery (Antar ke Alamat)',
            'pickup' => 'Pickup (Ambil Sendiri di Outlet)',
            default => ucfirst($this->delivery_method),
        };
    }

    public function getPaymentProofUrlAttribute(): ?string
    {
        if (! $this->payment_proof) {
            return null;
        }

        if (str_starts_with($this->payment_proof, 'http://') || str_starts_with($this->payment_proof, 'https://')) {
            return $this->payment_proof;
        }

        // Stream via dedicated image route to prevent bloating HTML response payload (avoids Vercel 4.5MB limit)
        return route('order.payment-proof', $this->order_number);
    }

    /**
     * Generate WhatsApp confirmation message link
     */
    public function getWhatsAppUrlAttribute(): string
    {
        $adminPhone = Setting::get('wa_admin', '6281234567890');
        // Clean phone number (replace leading 0 with 62)
        $cleanPhone = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $adminPhone));

        $itemsSummary = '';
        foreach ($this->items as $item) {
            $addonInfo = '';
            if ($item->sugar_level || $item->jelly_topping) {
                $addons = array_filter([$item->sugar_level, $item->jelly_topping]);
                $addonInfo = ' ['.implode(', ', $addons).']';
            }
            $itemsSummary .= "- {$item->product_name}{$addonInfo} ({$item->quantity}x) = Rp ".number_format((float) $item->subtotal, 0, ',', '.')."\n";
        }

        $msg = "Halo Admin FRUVIT.ID,\n\n";
        $msg .= "Saya ingin konfirmasi pesanan saya:\n";
        $msg .= "*Order ID:* {$this->order_number}\n";
        $msg .= "*Nama Pemesan:* {$this->customer_name}\n";
        $msg .= "*No. WhatsApp:* {$this->customer_phone}\n";
        $msg .= '*Metode:* '.($this->delivery_method === 'delivery' ? 'Delivery' : 'Pickup')."\n";
        if ($this->delivery_method === 'delivery') {
            $msg .= "*Alamat:* {$this->shipping_address}\n";
        }
        $msg .= '*Metode Bayar:* '.strtoupper($this->payment_method)."\n";
        $msg .= "*Status Bayar:* {$this->payment_status_label}\n\n";
        $msg .= "*Detail Menu:*\n{$itemsSummary}\n";
        if ($this->delivery_fee > 0) {
            $msg .= 'Ongkir: Rp '.number_format((float) $this->delivery_fee, 0, ',', '.')."\n";
        }
        $msg .= '*Total Tagihan: Rp '.number_format((float) $this->total_amount, 0, ',', '.')."*\n\n";
        if ($this->notes) {
            $msg .= "Catatan: {$this->notes}\n\n";
        }
        $msg .= 'Mohon segera diproses ya kak. Terima kasih!';

        return "https://api.whatsapp.com/send?phone={$cleanPhone}&text=".urlencode($msg);
    }
}
