@extends('layouts.app')

@section('content')
<div class="section-title"><div><h2>Поиск</h2><p>Результаты по запросу “{{ $q }}”</p></div></div>
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px,1fr));">
    @forelse($results as $product)
        <x-product-card :product="$product" />
    @empty
        <div class="card" style="padding:14px;">Ничего не найдено.</div>
    @endforelse
</div>
@endsection
