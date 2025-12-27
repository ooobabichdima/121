@extends('layouts.app')

@section('content')
<div class="section-title"><div><h2>Вход</h2><p>Используйте учётку админа из .env</p></div></div>
<form method="post" action="{{ route('login') }}" class="card" style="padding:14px; max-width:420px; display:grid; gap:10px;">
    @csrf
    <label>Email<input class="btn small" type="email" name="email" required></label>
    <label>Пароль<input class="btn small" type="password" name="password" required></label>
    <label class="row" style="gap:8px;"><input type="checkbox" name="remember"> <span class="muted">Запомнить</span></label>
    <button class="btn primary" type="submit">Войти</button>
</form>
@endsection
