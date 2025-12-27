@extends('layouts.app')

@section('content')
<div class="section-title"><div><h2>Admin / Лиды</h2></div></div>
<table class="card" style="width:100%; border-collapse:collapse;">
    <thead><tr><th style="padding:10px; text-align:left;">Контакт</th><th>Дата</th><th></th></tr></thead>
    <tbody>
        @foreach($leads as $lead)
            <tr style="border-top:1px solid rgba(255,255,255,.08);">
                <td style="padding:10px;">{{ $lead->contact }}</td>
                <td>{{ $lead->created_at }}</td>
                <td><a class="btn small" href="{{ route('admin.leads.show', $lead) }}">Открыть</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
<div style="margin-top:12px;">{{ $leads->links() }}</div>
@endsection
