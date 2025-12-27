@extends('layouts.app')

@section('content')
<div class="section-title"><div><h2>Admin / Dashboard</h2><p>Метрики заказов</p></div></div>
<div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:12px;">
    <div class="card" style="padding:12px;">Сегодня: <b>{{ $stats['today_orders'] }}</b> / {{ money($stats['today_revenue']) }}</div>
    <div class="card" style="padding:12px;">Неделя: <b>{{ $stats['week_orders'] }}</b> / {{ money($stats['week_revenue']) }}</div>
    <div class="card" style="padding:12px;">Paid: {{ $stats['paid'] }}</div>
    <div class="card" style="padding:12px;">Unpaid: {{ $stats['unpaid'] }}</div>
</div>
<div class="section-title"><div><h2>Топ товары</h2></div></div>
<div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:12px;">
    @foreach($topProducts as $p)
        <div class="card" style="padding:12px;">{{ $p->name }} <span class="muted">продано: {{ $p->sold ?? 0 }}</span></div>
    @endforeach
</div>
@endsection
