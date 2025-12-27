@extends('layouts.app')

@section('content')
<div class="section-title"><div><h2>Лид: {{ $lead->contact }}</h2></div></div>
<div class="card" style="padding:14px;">
    <pre style="white-space:pre-wrap;">{{ json_encode($lead->answers_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
</div>
<form method="post" action="{{ route('admin.leads.destroy', $lead) }}" style="margin-top:8px;">
    @csrf @method('delete')
    <button class="btn" type="submit">Удалить</button>
</form>
@endsection
