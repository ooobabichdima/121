@extends('layouts.app')

@section('content')
<div class="section-title"><div><h2>Новый товар</h2></div></div>
<form method="post" action="{{ route('admin.products.store') }}" class="card" style="padding:14px; display:grid; gap:10px;">
    @csrf
    @include('admin.products.partials.form')
    <button class="btn primary" type="submit">Сохранить</button>
</form>
@endsection
