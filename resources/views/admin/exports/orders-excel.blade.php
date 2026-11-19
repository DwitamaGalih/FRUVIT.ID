<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan FRUVIT.ID</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11pt; }
        table { border-collapse: collapse; width: 100%; }
        th { background-color: #15803d; color: #ffffff; font-weight: bold; padding: 8px 12px; border: 1px solid #0f5132; text-align: left; }
        td { padding: 6px 10px; border: 1px solid #cccccc; vertical-align: top; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .header-title { font-size: 16pt; font-weight: bold; color: #15803d; }
        .header-sub { font-size: 10pt; color: #555555; }
        .text-num { mso-number-format: "\@"; }
        .currency { mso-number-format: "#,##0"; text-align: right; }
        .badge-paid { background-color: #d1fae5; color: #065f46; font-weight: bold; }
        .badge-unpaid { background-color: #fee2e2; color: #991b1b; }
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        .total-row { background-color: #f0fdf4; font-weight: bold; }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="12" class="header-title">FRUVIT.ID - LAPORAN PENJUALAN PESANAN</td>
        </tr>
        <tr>
            <td colspan="12" class="header-sub">Waktu Unduh: {{ now()->translatedFormat('d F Y, H:i:s') }} WIB | Total Data: {{ $orders->count() }} Pesanan</td>
        </tr>
        <tr><td colspan="12"></td></tr>
        <thead>
            <tr>
                <th class="text-center" style="width: 40px;">No</th>
                <th style="width: 140px;">No. Pesanan</th>
                <th style="width: 130px;">Tanggal & Waktu</th>
                <th style="width: 140px;">Nama Pelanggan</th>
                <th style="width: 120px;">No. WhatsApp</th>
                <th style="width: 90px;">Metode Ambil</th>
                <th style="width: 250px;">Detail Menu & Add-on (Susu Jelly / Salad)</th>
                <th style="width: 90px;" class="text-right">Subtotal</th>
                <th style="width: 70px;" class="text-right">Ongkir</th>
                <th style="width: 100px;" class="text-right">Total Tagihan</th>
                <th style="width: 90px;">Metode Bayar</th>
                <th style="width: 110px;">Status Bayar</th>
                <th style="width: 110px;">Status Pesanan</th>
                <th style="width: 180px;">Alamat / Catatan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalRevenueAll = 0;
                $totalPaidOnly = 0;
            @endphp
            @forelse($orders as $idx => $order)
                @php
                    $totalRevenueAll += $order->total_amount;
                    if ($order->payment_status === 'paid') {
                        $totalPaidOnly += $order->total_amount;
                    }
                    $itemsDetail = [];
                    foreach ($order->items as $it) {
                        $addons = [];
                        if ($it->pickup_day && $it->pickup_batch) {
                            $addons[] = 'Jadwal: ' . $it->pickup_day . ' (' . $it->pickup_batch . ')';
                        }
                        if ($it->sugar_level) {
                            $addons[] = 'Gula: ' . $it->sugar_level;
                        }
                        if ($it->jelly_topping) {
                            $addons[] = 'Topping: ' . $it->jelly_topping;
                        }
                        $addonStr = !empty($addons) ? ' (' . implode(', ', $addons) . ')' : '';
                        $itemsDetail[] = $it->product_name . $addonStr . ' [x' . $it->quantity . ']';
                    }
                    $itemsText = implode('; ', $itemsDetail);
                @endphp
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="bold text-num">{{ $order->order_number }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td class="text-num">{{ $order->customer_phone }}</td>
                    <td>{{ $order->delivery_method === 'delivery' ? 'Delivery' : 'Pickup' }}</td>
                    <td>{{ $itemsText }}</td>
                    <td class="currency">{{ (float) $order->subtotal }}</td>
                    <td class="currency">{{ (float) $order->delivery_fee }}</td>
                    <td class="currency bold">{{ (float) $order->total_amount }}</td>
                    <td>{{ strtoupper($order->payment_method) }}</td>
                    <td class="{{ $order->payment_status === 'paid' ? 'badge-paid' : ($order->payment_status === 'pending_verification' ? 'badge-pending' : 'badge-unpaid') }}">
                        {{ $order->payment_status_label }}
                    </td>
                    <td>{{ $order->order_status_label }}</td>
                    <td>
                        @if($order->shipping_address)
                            <strong>Alamat:</strong> {{ $order->shipping_address }}<br>
                        @endif
                        @if($order->notes)
                            <strong>Catatan:</strong> {{ $order->notes }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="14" class="text-center" style="padding: 20px;">Tidak ada data pesanan pada filter yang dipilih.</td>
                </tr>
            @endforelse
            <tr class="total-row">
                <td colspan="7" class="text-right bold">TOTAL KESELURUHAN ({{ $orders->count() }} Pesanan):</td>
                <td colspan="3" class="currency bold">Rp {{ number_format($totalRevenueAll, 0, ',', '.') }}</td>
                <td colspan="4"></td>
            </tr>
            <tr class="total-row" style="background-color: #dcfce7;">
                <td colspan="7" class="text-right bold" style="color: #15803d;">TOTAL PENDAPATAN LUNAS (PAID):</td>
                <td colspan="3" class="currency bold" style="color: #15803d;">Rp {{ number_format($totalPaidOnly, 0, ',', '.') }}</td>
                <td colspan="4"></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
