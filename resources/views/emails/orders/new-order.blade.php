<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Baru Masuk - FRUVIT.ID</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f1f5f9; padding: 24px 12px;">
        <tr>
            <td align="center">
                <!-- Email Container -->
                <table role="presentation" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #2563eb, #1d4ed8); padding: 32px 24px; text-align: center;">
                            <div style="display: inline-block; background-color: #fef08a; color: #854d0e; font-size: 11px; font-weight: 900; letter-spacing: 1px; text-transform: uppercase; padding: 4px 12px; border-radius: 9999px; margin-bottom: 12px;">
                                FRUVIT.ID NOTIFIKASI
                            </div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 800; line-height: 1.3;">
                                Ada Pesanan Baru Masuk! 🎉
                            </h1>
                            <p style="margin: 8px 0 0; color: #dbeafe; font-size: 13px;">
                                Halo Tim FRUVIT, pembeli baru saja melakukan checkout di website.
                            </p>
                        </td>
                    </tr>

                    <!-- Order Summary Pill -->
                    <tr>
                        <td style="padding: 20px 24px 0;">
                            <table role="presentation" width="100%" style="background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 14px; padding: 14px 18px;">
                                <tr>
                                    <td>
                                        <div style="font-size: 11px; color: #64748b; font-weight: 600;">Nomor Pesanan</div>
                                        <div style="font-size: 16px; color: #1e3a8a; font-weight: 900; letter-spacing: 0.5px;">{{ $order->order_number }}</div>
                                    </td>
                                    <td align="right">
                                        <div style="font-size: 11px; color: #64748b; font-weight: 600;">Waktu Pemesanan</div>
                                        <div style="font-size: 13px; color: #0f172a; font-weight: 700;">{{ $order->created_at->format('d M Y, H:i') }} WIB</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Customer Details -->
                    <tr>
                        <td style="padding: 20px 24px 10px;">
                            <h2 style="margin: 0 0 12px; font-size: 14px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">
                                👤 Informasi Pembeli
                            </h2>
                            <table role="presentation" width="100%" style="font-size: 13px; line-height: 1.6;">
                                <tr>
                                    <td width="38%" style="color: #64748b; font-weight: 600; padding: 4px 0;">Nama Pemesan</td>
                                    <td style="color: #0f172a; font-weight: 700; padding: 4px 0;">: {{ $order->customer_name }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; font-weight: 600; padding: 4px 0;">Nomor WhatsApp</td>
                                    <td style="color: #059669; font-weight: 700; padding: 4px 0;">
                                        : <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $order->customer_phone)) }}" style="color: #059669; text-decoration: underline;">{{ $order->customer_phone }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; font-weight: 600; padding: 4px 0;">Metode Penerimaan</td>
                                    <td style="color: #0f172a; font-weight: 700; padding: 4px 0;">: {{ $order->delivery_method_label }}</td>
                                </tr>
                                @if($order->shipping_address)
                                    <tr>
                                        <td style="color: #64748b; font-weight: 600; padding: 4px 0; vertical-align: top;">Alamat Kirim</td>
                                        <td style="color: #0f172a; padding: 4px 0;">: {{ $order->shipping_address }}</td>
                                    </tr>
                                @endif
                                @if($order->notes)
                                    <tr>
                                        <td style="color: #64748b; font-weight: 600; padding: 4px 0; vertical-align: top;">Catatan</td>
                                        <td style="color: #475569; font-style: italic; padding: 4px 0;">: "{{ $order->notes }}"</td>
                                    </tr>
                                @endif
                            </table>
                        </td>
                    </tr>

                    <!-- Order Items Table -->
                    <tr>
                        <td style="padding: 10px 24px 15px;">
                            <h2 style="margin: 0 0 12px; font-size: 14px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">
                                🛒 Menu yang Dipesan
                            </h2>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse; font-size: 13px;">
                                <thead>
                                    <tr style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569; font-size: 11px; text-transform: uppercase;">
                                        <th align="left" style="padding: 10px 8px; font-weight: 800;">Menu & Keterangan</th>
                                        <th align="center" style="padding: 10px 8px; font-weight: 800;" width="60">Qty</th>
                                        <th align="right" style="padding: 10px 8px; font-weight: 800;" width="100">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr style="border-bottom: 1px solid #f1f5f9;">
                                            <td style="padding: 10px 8px; vertical-align: top;">
                                                <div style="font-weight: 800; color: #0f172a;">{{ $item->product_name }}</div>
                                                <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                                    @if($item->pickup_day)
                                                        <span style="display: inline-block; background-color: #f1f5f9; padding: 1px 6px; border-radius: 4px; margin-right: 4px;">📅 {{ $item->pickup_day }} ({{ $item->pickup_batch ?? 'Batch 1' }})</span>
                                                    @endif
                                                    @if($item->sugar_level)
                                                        <span style="display: inline-block; background-color: #dbeafe; color: #1d4ed8; padding: 1px 6px; border-radius: 4px; font-weight: 600; margin-right: 4px;">🍬 {{ $item->sugar_level }}</span>
                                                    @endif
                                                    @if($item->jelly_topping)
                                                        <span style="display: inline-block; background-color: #fef3c7; color: #b45309; padding: 1px 6px; border-radius: 4px; font-weight: 600;">🧋 {{ $item->jelly_topping }}</span>
                                                    @endif
                                                </div>
                                                @if($item->notes)
                                                    <div style="font-size: 11px; color: #94a3b8; font-style: italic; margin-top: 2px;">
                                                        Catatan: {{ $item->notes }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td align="center" style="padding: 10px 8px; font-weight: 800; color: #0f172a; vertical-align: top;">
                                                x{{ $item->quantity }}
                                            </td>
                                            <td align="right" style="padding: 10px 8px; font-weight: 800; color: #0f172a; vertical-align: top;">
                                                {{ $item->formatted_subtotal }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <!-- Payment & Totals -->
                    <tr>
                        <td style="padding: 10px 24px 20px;">
                            <table role="presentation" width="100%" style="background-color: #f8fafc; border-radius: 14px; padding: 16px; border: 1px solid #e2e8f0; font-size: 13px;">
                                <tr>
                                    <td style="color: #64748b; padding: 4px 0;">Subtotal Menu:</td>
                                    <td align="right" style="color: #0f172a; font-weight: 700; padding: 4px 0;">
                                        Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; padding: 4px 0;">Ongkos Kirim:</td>
                                    <td align="right" style="color: #0f172a; font-weight: 700; padding: 4px 0;">
                                        Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; padding: 4px 0;">Metode Pembayaran:</td>
                                    <td align="right" style="color: #0284c7; font-weight: 800; padding: 4px 0;">
                                        {{ $order->payment_method_label }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; padding: 4px 0;">Status Pembayaran:</td>
                                    <td align="right" style="padding: 4px 0;">
                                        @if($order->payment_status === 'paid')
                                            <span style="background-color: #dcfce7; color: #15803d; font-size: 11px; font-weight: 900; padding: 2px 8px; border-radius: 6px;">LUNAS</span>
                                        @else
                                            <span style="background-color: #fee2e2; color: #b91c1c; font-size: 11px; font-weight: 900; padding: 2px 8px; border-radius: 6px;">BELUM BAYAR</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="border-top: 1px dashed #cbd5e1; padding-top: 10px; margin-top: 6px;">
                                        <table role="presentation" width="100%">
                                            <tr>
                                                <td style="font-size: 15px; font-weight: 900; color: #0f172a;">TOTAL PEMBAYARAN:</td>
                                                <td align="right" style="font-size: 18px; font-weight: 900; color: #16a34a;">
                                                    {{ $order->formatted_total }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- CTA Button -->
                    <tr>
                        <td align="center" style="padding: 0 24px 30px;">
                            <a href="{{ route('admin.orders.show', $order->id) }}" style="display: inline-block; background-color: #16a34a; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 800; padding: 14px 28px; border-radius: 12px; box-shadow: 0 2px 4px rgba(22, 163, 74, 0.3);">
                                📋 Kelola & Proses Pesanan Ini &rarr;
                            </a>
                            <div style="font-size: 11px; color: #94a3b8; margin-top: 10px;">
                                Atau buka langsung melalui panel Admin FRUVIT.ID di browser Anda.
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 24px; text-align: center; font-size: 11px; color: #94a3b8;">
                            Email ini dibuat secara otomatis oleh sistem toko <strong>FRUVIT.ID</strong>.<br>
                            Stand Kewirausahaan Mahasiswa — Fresh Fruits & Healthy Drinks.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
