@extends('layouts.app')

@section('content')
<div class="section-title"><div><h2>Корзина</h2><p>Измени количество или удали позиции</p></div></div>
<form method="post" action="{{ route('cart.update') }}">
    @csrf
    <div class="grid" style="gap:12px;">
        @foreach($items as $item)
            <div class="card" style="padding:12px; display:flex; justify-content:space-between; gap:12px; align-items:center; flex-wrap:wrap;">
                <div>
                    <b>{{ $item['product']->name }}</b><br>
                    <span class="muted">SKU: {{ $item['product']->sku }}</span>
                </div>
                <div class="row" style="align-items:center; gap:10px;">
                    <input type="number" name="items[{{ $item['product']->id }}]" value="{{ $item['qty'] }}" min="1" max="99" class="btn small" style="width:80px; text-align:center;">
                    <span>{{ money($item['line']) }}</span>
                    <button class="btn small" type="submit" formaction="{{ route('cart.remove') }}" formmethod="post" name="product_id" value="{{ $item['product']->id }}">Удалить</button>
                </div>
            </div>
        @endforeach
    </div>
    <div class="card" style="padding:14px; margin-top:12px; display:flex; justify-content:space-between;">
        <div>Итого: <b>{{ money($totals['total']) }}</b></div>
        <div class="row" style="gap:10px;">
            <button class="btn" type="submit">Пересчитать</button>
            <a class="btn primary" href="{{ route('checkout') }}">Оформить заказ</a>
        </div>
    </div>
</form>
@endsection
