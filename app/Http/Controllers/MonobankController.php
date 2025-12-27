<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\MonobankService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class MonobankController extends Controller
{
    public function __construct(protected MonobankService $mono) {}

    public function pay(Order $order): View
    {
        $invoice = $this->mono->createInvoice($order);
        $payment = $order->payments()->latest()->first();

        return view('pages.pay_monobank', [
            'order' => $order,
            'payment' => $payment,
            'invoice' => $invoice,
        ]);
    }

    public function webhook(Request $request)
    {
        $payload = $request->all();
        $invoiceId = $payload['invoiceId'] ?? null;
        if (! $invoiceId) {
            return response()->json(['ok' => false], 400);
        }

        $payment = Payment::where('invoice_id', $invoiceId)->first();
        if (! $payment) {
            return response()->json(['ok' => false], 404);
        }

        $this->mono->markPaid($payment, $payload);
        return response()->json(['ok' => true]);
    }
}
