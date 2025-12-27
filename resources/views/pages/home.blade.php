@extends('layouts.app')

@section('content')
<div class="section-title">
    <div>
        <h2>Хиты продаж</h2>
        <p>Быстрый старт: готовые подборки</p>
    </div>
</div>
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px,1fr));">
    @foreach($featured as $product)
        <x-product-card :product="$product" />
    @endforeach
</div>

<div class="section-title">
    <div>
        <h2>Новинки</h2>
        <p>Самые свежие модели</p>
    </div>
</div>
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px,1fr));">
    @foreach($new as $product)
        <x-product-card :product="$product" />
    @endforeach
</div>

<div class="section-title">
    <div>
        <h2>Подборка для CQB</h2>
        <p>Привод + АКБ + магазины + шары</p>
    </div>
</div>
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px,1fr));">
    @foreach($bundles as $product)
        <x-product-card :product="$product" />
    @endforeach
</div>

<div class="section-title"><div><h2>Помочь с подбором</h2><p>Оставь контакт и пожелания</p></div></div>
<form method="post" action="{{ route('lead.submit') }}" class="card" style="padding:14px; display:grid; gap:10px; max-width:680px;">
    @csrf
    <label>Контакт (телеграм/телефон)<input class="btn small" name="contact" required></label>
    <label>Что ищешь<textarea class="btn small" name="answers[goal]" rows="3" placeholder="CQB / лес, бюджет, желаемые платформы"></textarea></label>
    <button class="btn primary" type="submit">Отправить</button>
</form>
@endsection
