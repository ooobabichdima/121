<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MonobankService
{
    public function createInvoice(Order $order): array
    {
        $mode = config('services.monobank.mode', 'sandbox');
        $payment = $order->payments()->latest()->first();

        if ($mode === 'sandbox' || ! config('services.monobank.token')) {
            $data = [
                'invoiceId' => 'demo-'.uniqid(),
                'pageUrl' => route('pay.monobank', $order),
                'mode' => 'sandbox',
            ];
            if ($payment) {
                $payment->update(['invoice_id' => $data['invoiceId'], 'payload_json' => $data]);
            }
            return $data;
        }

        $payload = [
            'amount' => (int) round($order->total * 100),
            'orderId' => $order->number,
            'redirectUrl' => route('home'),
            'webHookUrl' => route('pay.monobank.webhook'),
            'merchantPaymInfo' => [
                'reference' => $order->number,
                'destination' => 'Strikeball order '.$order->number,
            ],
        ];

        $response = Http::withToken(config('services.monobank.token'))
            ->post('https://api.monobank.ua/api/merchant/invoice/create', $payload);

        if (! $response->successful()) {
            Log::error('Monobank invoice error', ['body' => $response->body()]);
            throw new \RuntimeException('Не удалось создать инвойс');
        }

        $data = $response->json();
        if ($payment) {
            $payment->update(['invoice_id' => $data['invoiceId'] ?? null, 'payload_json' => $data]);
        }
        return $data;
    }

    public function markPaid(Payment $payment, array $payload = []): void
    {
        $payment->update([
            'status' => 'paid',
            'payload_json' => $payload,
        ]);
        $payment->order?->update(['status' => 'paid']);
    }
}
