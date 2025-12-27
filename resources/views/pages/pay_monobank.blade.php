@extends('layouts.app')

@section('content')
<div class="card" style="padding:16px; margin-top:16px;">
    <h2>Оплата заказа {{ $order->number }}</h2>
    <p class="muted">Сумма: {{ money($order->total) }}. Режим: {{ $invoice['mode'] ?? 'live' }}</p>
    @if(($invoice['mode'] ?? '') === 'sandbox')
        <form method="post" action="{{ route('pay.monobank.webhook') }}">
            @csrf
            <input type="hidden" name="invoiceId" value="{{ $invoice['invoiceId'] ?? 'demo' }}">
            <button class="btn primary" type="submit">Оплачено (demo)</button>
        </form>
    @else
        <a class="btn primary" href="{{ $invoice['pageUrl'] ?? '#' }}" target="_blank">Перейти к оплате</a>
    @endif
</div>
@endsection
