@extends('layouts.app')

@section('content')
<div class="section-title"><div><h2>Редактирование: {{ $product->name }}</h2></div></div>
<form method="post" action="{{ route('admin.products.update', $product) }}" class="card" style="padding:14px; display:grid; gap:10px;">
    @csrf @method('put')
    @include('admin.products.partials.form')
    <button class="btn primary" type="submit">Обновить</button>
</form>
<form method="post" action="{{ route('admin.products.destroy', $product) }}" style="margin-top:8px;">
    @csrf @method('delete')
    <button class="btn" type="submit">Удалить</button>
</form>
@endsection
