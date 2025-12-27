@extends('layouts.app')

@section('content')
<div class="section-title">
    <div>
        <h2>{{ $category->name }}</h2>
        <p>Фильтры: платформа, бренд, цена</p>
    </div>
    <form method="get" class="row" style="flex-wrap:wrap;gap:8px;">
        <input type="hidden" name="q" value="{{ request('q') }}">
        <select name="sort" class="btn small" onchange="this.form.submit()">
            <option value="">Сортировать</option>
            <option value="price_asc" @selected(request('sort')==='price_asc')>Цена ↑</option>
            <option value="price_desc" @selected(request('sort')==='price_desc')>Цена ↓</option>
            <option value="new" @selected(request('sort')==='new')>Новинки</option>
        </select>
        <button class="btn small" type="submit">Применить</button>
    </form>
</div>
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px,1fr));">
    @foreach($products as $product)
        <x-product-card :product="$product" />
    @endforeach
</div>
<div style="margin:16px 0;">{{ $products->links() }}</div>
@endsection
