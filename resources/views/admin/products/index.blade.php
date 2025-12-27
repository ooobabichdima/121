@extends('layouts.app')

@section('content')
<div class="section-title"><div><h2>Admin / Товары</h2></div><a class="btn small" href="{{ route('admin.products.create') }}">Новый</a></div>
<table class="card" style="width:100%; border-collapse:collapse;">
    <thead><tr><th style="padding:10px; text-align:left;">Название</th><th>SKU</th><th>Цена</th><th></th></tr></thead>
    <tbody>
        @foreach($products as $product)
            <tr style="border-top:1px solid rgba(255,255,255,.08);">
                <td style="padding:10px;">{{ $product->name }}</td>
                <td>{{ $product->sku }}</td>
                <td>{{ money($product->price) }}</td>
                <td><a class="btn small" href="{{ route('admin.products.edit', $product) }}">Редактировать</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div style="margin-top:12px;">{{ $products->links() }}</div>
@endsection
