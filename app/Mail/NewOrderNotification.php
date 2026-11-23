<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
        $this->order->load('items');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📦 Pesanan Baru Masuk #' . $this->order->order_number . ' (' . $this->order->customer_name . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.orders.new-order',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
