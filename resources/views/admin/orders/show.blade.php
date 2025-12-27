@extends('layouts.app')

@section('content')
<div class="section-title"><div><h2>Заказ {{ $order->number }}</h2><p>Статус: {{ $order->status }}</p></div></div>
<div class="grid" style="grid-template-columns:1.1fr .9fr; gap:12px;">
    <div class="card" style="padding:12px;">
        <b>Позиции</b>
        <div class="grid" style="gap:8px; margin-top:8px;">
            @foreach($order->items as $item)
                <div class="card" style="padding:10px; display:flex; justify-content:space-between;">
                    <span>{{ $item->name_snapshot }} × {{ $item->qty }}</span>
                    <b>{{ money($item->price_snapshot * $item->qty) }}</b>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card" style="padding:12px; display:grid; gap:10px;">
        <b>Оплата</b>
        @foreach($order->payments as $pay)
            <div class="card" style="padding:10px;">{{ $pay->provider }} — {{ $pay->status }} — {{ money($pay->amount) }}</div>
        @endforeach
        <form method="post" action="{{ route('admin.orders.update', $order) }}">
            @csrf @method('put')
            <label>Статус
                <select name="status" class="btn small">
                    @foreach(['new','confirmed','paid','shipped','delivered','canceled'] as $status)
                        <option value="{{ $status }}" @selected($order->status===$status)>{{ $status }}</option>
                    @endforeach
                </select>
            </label>
            <label>Комментарий<textarea class="btn small" name="note"></textarea></label>
            <button class="btn primary" type="submit">Сохранить</button>
        </form>
    </div>
</div>
@endsection
