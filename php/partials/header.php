<?php require_once __DIR__.'/../functions.php'; ?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'Strikeball Shop PHP') ?></title>
  <style>
    :root{--bg:#070a0f;--panel:rgba(255,255,255,.06);--panel2:rgba(255,255,255,.08);--text:rgba(255,255,255,.92);--muted:rgba(255,255,255,.65);--muted2:rgba(255,255,255,.45);--line:rgba(255,255,255,.12);--accent:#58ff7a;--accent2:#22c55e;--danger:#ff4d4d;--shadow:0 18px 60px rgba(0,0,0,.55);--radius:18px;--radius2:24px;--max:1180px;--h1:clamp(24px,2.8vw,38px);--h2:clamp(20px,2.2vw,30px);}
    *{box-sizing:border-box}body{margin:0;font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Arial,"Noto Sans","Helvetica Neue",sans-serif;background:radial-gradient(1200px 600px at 12% -10%, rgba(88,255,122,.22), transparent 60%),radial-gradient(900px 500px at 90% 0%, rgba(56,189,248,.18), transparent 60%),radial-gradient(900px 500px at 20% 110%, rgba(168,85,247,.14), transparent 65%),linear-gradient(180deg, #05070b, #070a0f 20%, #060912);color:var(--text);line-height:1.45;overflow-x:hidden}
    a{color:inherit;text-decoration:none}button,input,select{font:inherit}
    .container{width:min(var(--max), calc(100% - 32px));margin:0 auto}
    .grid{display:grid;gap:16px}.row{display:flex;align-items:center;gap:12px}
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:12px 14px;border-radius:14px;border:1px solid rgba(255,255,255,.14);background:rgba(255,255,255,.06);color:var(--text);cursor:pointer;transition:transform .12s ease, background .12s ease, border-color .12s ease;white-space:nowrap}
    .btn:hover{transform:translateY(-1px);border-color:rgba(255,255,255,.22);background:rgba(255,255,255,.08)}
    .btn.primary{background:linear-gradient(180deg, rgba(88,255,122,.95), rgba(34,197,94,.92));border-color: rgba(88,255,122,.35);color:#031107;font-weight:900;box-shadow:0 16px 40px rgba(34,197,94,.22)}
    .btn.small{padding:10px 12px;border-radius:12px;font-size:14px}
    .pill{display:inline-flex;gap:8px;align-items:center;padding:8px 12px;border-radius:999px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.10);color:var(--muted);font-size:13px}
    .card{border-radius:var(--radius);border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);box-shadow:0 10px 30px rgba(0,0,0,.30)}
    .muted{color:var(--muted)}.muted2{color:var(--muted2)}.star{color:rgba(255,204,0,.9)}
    .section-title{display:flex;align-items:flex-end;justify-content:space-between;gap:16px;margin:18px 0 10px}
    .section-title h2{margin:0;font-size:var(--h2)}.section-title p{margin:0;color:var(--muted);font-size:14px}
    .topbar{position:sticky;top:0;z-index:50;backdrop-filter:blur(14px);background:rgba(6,9,18,.55);border-bottom:1px solid rgba(255,255,255,.10)}
    .topbar-inner{display:flex;align-items:center;justify-content:space-between;padding:12px 0;gap:16px}
    .brand{display:flex;align-items:center;gap:10px;font-weight:900;letter-spacing:.3px}
    .logo{width:34px;height:34px;border-radius:12px;display:grid;place-items:center;color:#04140a;background:radial-gradient(16px 16px at 30% 30%, rgba(255,255,255,.20), transparent 60%),linear-gradient(180deg, rgba(88,255,122,.95), rgba(34,197,94,.85));box-shadow:0 10px 24px rgba(34,197,94,.22);border:1px solid rgba(255,255,255,.22)}
    .nav{display:flex;align-items:center;gap:10px;color:var(--muted);font-size:14px}
    .nav a{padding:10px 10px;border-radius:12px;border:1px solid transparent}
    .nav a:hover{background:rgba(255,255,255,.06);border-color:rgba(255,255,255,.10);color:var(--text)}
    .search{flex:1;display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:16px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);min-width:240px}
    .search input{width:100%;background:transparent;border:none;outline:none;color:var(--text);font-size:14px}
    .search input::placeholder{color:rgba(255,255,255,.45)}
    .actions{display:flex;align-items:center;gap:10px}
    .footer{padding:22px 0 32px;border-top:1px solid rgba(255,255,255,.10);background:rgba(0,0,0,.10);margin-top:18px}
    .footer-grid{display:grid;grid-template-columns: 2fr 1fr 1fr 1fr;gap:16px}
    .footer-grid h5{margin:0 0 10px;font-size:14px}
    .footer-grid a{color:var(--muted);display:block;padding:6px 0;font-size:13px}
    .footer-grid a:hover{color:var(--text)}
    .copyright{margin-top:18px;display:flex;justify-content:space-between;gap:10px;color:rgba(255,255,255,.55);font-size:12px;flex-wrap:wrap}
    .thumb{height:72px;border-radius:14px;border:1px solid rgba(255,255,255,.12);background: rgba(0,0,0,.18);cursor:pointer;display:grid; place-items:center;transition:.12s ease;color:rgba(255,255,255,.80);font-weight:900}
    .thumb:hover{background:rgba(255,255,255,.06); border-color:rgba(255,255,255,.22); transform:translateY(-1px)}
    .thumb.active{border-color:rgba(88,255,122,.35); background:rgba(88,255,122,.10)}
  </style>
</head>
<body>
<div class="topbar">
  <div class="container">
    <div class="topbar-inner">
      <a class="brand" href="/php/index.php">
        <span class="logo" aria-hidden="true"></span>
        <span>Strikeball Shop<small class="muted" style="display:block">PHP версия</small></span>
      </a>
      <nav class="nav" aria-label="Основное меню">
        <a href="/php/index.php">Главная</a>
        <a href="/php/category.php?category=privody">Каталог</a>
        <a href="/php/cart.php">Корзина</a>
        <a href="/php/admin/orders.php">CRM</a>
      </nav>
      <form class="search" action="/php/search.php" method="get">
        <input type="search" name="q" placeholder="Поиск по магазину…" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
      </form>
    </div>
  </div>
</div>
<main class="container" style="padding:10px 0 30px;">
