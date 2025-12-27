@extends('layouts.app')

@section('content')
<div class="section-title"><div><h2>Оформление</h2><p>Контакты, доставка, оплата</p></div></div>
<form method="post" action="{{ route('checkout.submit') }}" class="grid" style="grid-template-columns:1.1fr .9fr; gap:14px;">
    @csrf
    <div class="card" style="padding:14px; display:grid; gap:12px;">
        <div class="grid" style="grid-template-columns:1fr 1fr; gap:10px;">
            <label>Имя<input class="btn small" name="customer_name" value="{{ old('customer_name') }}" required></label>
            <label>Телефон<input class="btn small" name="phone" value="{{ old('phone') }}" required></label>
            <label>Email<input class="btn small" name="email" value="{{ old('email') }}"></label>
            <label>Промокод<input class="btn small" name="promo_code" value="{{ old('promo_code') }}" placeholder="START10 / BBS50"></label>
        </div>

        <div class="card" style="padding:12px; background:rgba(0,0,0,.18);">
            <b>Доставка</b>
            <div class="row" style="flex-wrap:wrap; gap:10px; margin-top:8px;">
                <label class="pill"><input type="radio" name="delivery_method" value="nova_poshta" {{ old('delivery_method','nova_poshta')==='nova_poshta'?'checked':'' }}> Нова Пошта</label>
                <label class="pill"><input type="radio" name="delivery_method" value="courier" {{ old('delivery_method')==='courier'?'checked':'' }}> Курьер</label>
                <label class="pill"><input type="radio" name="delivery_method" value="pickup" {{ old('delivery_method')==='pickup'?'checked':'' }}> Самовывоз</label>
            </div>
            <div class="grid" style="grid-template-columns:1fr 1fr; gap:10px; margin-top:8px;">
                <label>Город<input class="btn small" name="city" value="{{ old('city') }}" placeholder="Киев"></label>
                <label>Отделение / адрес<input class="btn small" name="warehouse" value="{{ old('warehouse') }}" placeholder="Отделение"></label>
                <label style="grid-column: span 2;">Адрес курьера<input class="btn small" name="address" value="{{ old('address') }}" placeholder="если выбрали курьер"></label>
            </div>
        </div>

        <div class="card" style="padding:12px; background:rgba(0,0,0,.18);">
            <b>Оплата</b>
            <div class="row" style="flex-wrap:wrap; gap:10px; margin-top:8px;">
                <label class="pill"><input type="radio" name="payment_method" value="cod" {{ old('payment_method','cod')==='cod'?'checked':'' }}> Наложенный платеж</label>
                <label class="pill"><input type="radio" name="payment_method" value="monobank" {{ old('payment_method')==='monobank'?'checked':'' }}> Monobank</label>
                <label class="pill"><input type="radio" name="payment_method" value="parts" {{ old('payment_method')==='parts'?'checked':'' }}> Оплата частями (demo)</label>
            </div>
        </div>

        <div class="card" style="padding:12px;">
            <b>Upsell: Добавить магазины</b>
            <div class="row" style="gap:10px; margin-top:8px;">
                <label>Кол-во (0-10)<input type="number" class="btn small" name="upsell_mag_qty" min="0" max="10" value="{{ old('upsell_mag_qty',2) }}" style="width:120px"></label>
                <span class="muted">Магазины M4 mid-cap по 390 грн/шт.</span>
            </div>
        </div>

        <label>Комментарий<textarea class="btn small" name="comment" rows="3" style="width:100%;"></textarea></label>
    </div>

    <div class="card" style="padding:14px; display:grid; gap:10px; height:fit-content;">
        <b>Состав заказа</b>
        @foreach($items as $item)
            <div class="row" style="justify-content:space-between;">
                <span>{{ $item['product']->name }} × {{ $item['qty'] }}</span>
                <span>{{ money($item['line']) }}</span>
            </div>
        @endforeach
        <hr style="width:100%; border:1px solid rgba(255,255,255,.08);">
        <div class="row" style="justify-content:space-between;"><span>Сумма</span><b>{{ money($totals['subtotal']) }}</b></div>
        <div class="row" style="justify-content:space-between;"><span>Доставка</span><b>рассчитается</b></div>
        <div class="row" style="justify-content:space-between;"><span>Итого</span><b>{{ money($totals['total']) }}</b></div>
        <button class="btn primary" type="submit">Подтвердить заказ</button>
    </div>
</form>
@endsection
