@extends('layouts.app')

@section('content')
<div class="section-title"><div><h2>Admin / Заказы</h2></div></div>
<table class="card" style="width:100%; border-collapse:collapse;">
    <thead>
        <tr style="text-align:left;">
            <th style="padding:10px;">#</th>
            <th>Статус</th>
            <th>Покупатель</th>
            <th>Сумма</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr style="border-top:1px solid rgba(255,255,255,.08);">
                <td style="padding:10px;">{{ $order->number }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->customer_name }} / {{ $order->phone }}</td>
                <td>{{ money($order->total) }}</td>
                <td><a class="btn small" href="{{ route('admin.orders.show', $order) }}">Открыть</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div style="margin-top:12px;">{{ $orders->links() }}</div>
@endsection
