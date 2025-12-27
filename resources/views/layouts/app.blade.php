<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="theme-color" content="#0b0f14" />
    <title>{{ $title ?? 'Strikeball Shop' }}</title>
    <meta name="description" content="{{ $meta ?? 'Страйкбольный магазин: приводы, магазины, шары, тюнинг' }}" />
    <style>
        /* condensed global styles built from provided template */
        :root{
          --bg:#070a0f;--panel:rgba(255,255,255,.06);--panel2:rgba(255,255,255,.08);
          --text:rgba(255,255,255,.92);--muted:rgba(255,255,255,.65);--muted2:rgba(255,255,255,.45);
          --line:rgba(255,255,255,.12);--accent:#58ff7a;--accent2:#22c55e;--danger:#ff4d4d;--warn:#ffcc00;
          --shadow:0 18px 60px rgba(0,0,0,.55);--radius:18px;--radius2:24px;--max:1180px;
          --h1:clamp(24px,2.8vw,38px);--h2:clamp(20px,2.2vw,30px);--p:15px;
        }
        *{box-sizing:border-box}
        body{margin:0;font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Arial,"Noto Sans","Helvetica Neue",sans-serif;background:
            radial-gradient(1200px 600px at 12% -10%, rgba(88,255,122,.22), transparent 60%),
            radial-gradient(900px 500px at 90% 0%, rgba(56,189,248,.18), transparent 60%),
            radial-gradient(900px 500px at 20% 110%, rgba(168,85,247,.14), transparent 65%),
            linear-gradient(180deg, #05070b, #070a0f 20%, #060912);
            color:var(--text);line-height:1.45;overflow-x:hidden;}
        a{color:inherit;text-decoration:none}
        button,input,select{font:inherit}
        .container{width:min(var(--max), calc(100% - 32px));margin:0 auto}
        .grid{display:grid;gap:16px}
        .row{display:flex;align-items:center;gap:12px}
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:12px 14px;border-radius:14px;border:1px solid rgba(255,255,255,.14);background:rgba(255,255,255,.06);color:var(--text);cursor:pointer;transition:transform .12s ease, background .12s ease, border-color .12s ease;white-space:nowrap;}
        .btn:hover{transform:translateY(-1px);border-color:rgba(255,255,255,.22);background:rgba(255,255,255,.08)}
        .btn.primary{background:linear-gradient(180deg, rgba(88,255,122,.95), rgba(34,197,94,.92));border-color: rgba(88,255,122,.35);color:#031107;font-weight:900;box-shadow:0 16px 40px rgba(34,197,94,.22);}
        .btn.small{padding:10px 12px;border-radius:12px;font-size:14px}
        .pill{display:inline-flex;gap:8px;align-items:center;padding:8px 12px;border-radius:999px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.10);color:var(--muted);font-size:13px}
        .card{border-radius:var(--radius);border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);box-shadow:0 10px 30px rgba(0,0,0,.30)}
        .muted{color:var(--muted)}
        .muted2{color:var(--muted2)}
        .star{color:rgba(255,204,0,.9)}
        .section-title{display:flex;align-items:flex-end;justify-content:space-between;gap:16px;margin:18px 0 10px}
        .section-title h2{margin:0;font-size:var(--h2)}
        .section-title p{margin:0;color:var(--muted);font-size:14px}
        .topbar{position:sticky;top:0;z-index:50;backdrop-filter:blur(14px);background:rgba(6,9,18,.55);border-bottom:1px solid rgba(255,255,255,.10)}
        .topbar-inner{display:flex;align-items:center;justify-content:space-between;padding:12px 0;gap:16px}
        .brand{display:flex;align-items:center;gap:10px;font-weight:900;letter-spacing:.3px}
        .logo{width:34px;height:34px;border-radius:12px;display:grid;place-items:center;color:#04140a;background:radial-gradient(16px 16px at 30% 30%, rgba(255,255,255,.20), transparent 60%),linear-gradient(180deg, rgba(88,255,122,.95), rgba(34,197,94,.85));box-shadow:0 10px 24px rgba(34,197,94,.22);border:1px solid rgba(255,255,255,.22);}
        .nav{display:flex;align-items:center;gap:10px;color:var(--muted);font-size:14px}
        .nav a{padding:10px 10px;border-radius:12px;border:1px solid transparent}
        .nav a:hover{background:rgba(255,255,255,.06);border-color:rgba(255,255,255,.10);color:var(--text)}
        .search{flex:1;display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:16px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);min-width:240px;}
        .search input{width:100%;background:transparent;border:none;outline:none;color:var(--text);font-size:14px}
        .search input::placeholder{color:rgba(255,255,255,.45)}
        .actions{display:flex;align-items:center;gap:10px}
        .iconbtn{width:42px;height:42px;border-radius:14px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);display:grid;place-items:center;cursor:pointer;transition:background .12s ease, transform .12s ease, border-color .12s ease;position:relative;}
        .iconbtn:hover{background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.22);transform:translateY(-1px)}
        .badge{position:absolute;top:8px;right:8px;background:linear-gradient(180deg, rgba(255,77,77,.95), rgba(239,68,68,.9));border:1px solid rgba(255,255,255,.18);color:#120202;font-weight:900;border-radius:999px;padding:2px 6px;font-size:11px;line-height:1}
        .footer{padding:22px 0 32px;border-top:1px solid rgba(255,255,255,.10);background:rgba(0,0,0,.10);margin-top:18px}
        .footer-grid{display:grid;grid-template-columns: 2fr 1fr 1fr 1fr;gap:16px}
        .footer-grid h5{margin:0 0 10px;font-size:14px}
        .footer-grid a{color:var(--muted);display:block;padding:6px 0;font-size:13px}
        .footer-grid a:hover{color:var(--text)}
        .copyright{margin-top:18px;display:flex;justify-content:space-between;gap:10px;color:rgba(255,255,255,.55);font-size:12px;flex-wrap:wrap}
        .crumbs{padding:18px 0 10px; color:rgba(255,255,255,.62); font-size:13px}
        .thumbs{display:grid; grid-template-columns: repeat(4, 1fr); gap:10px; margin-top:12px}
        .thumb{height:72px;border-radius:14px;border:1px solid rgba(255,255,255,.12);background: rgba(0,0,0,.18);cursor:pointer;display:grid; place-items:center;transition:.12s ease;color:rgba(255,255,255,.80);font-weight:900;}
        .thumb:hover{background:rgba(255,255,255,.06); border-color:rgba(255,255,255,.22); transform:translateY(-1px)}
        .thumb.active{border-color:rgba(88,255,122,.35); background:rgba(88,255,122,.10)}
        .product-wrap{display:grid; grid-template-columns: 1.05fr .95fr; gap:16px; padding-bottom:18px;}
        .pricebox{margin-top:14px;padding:14px;border-radius:18px;border:1px solid rgba(255,255,255,.12);background: rgba(0,0,0,.18);display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;}
        .qty{display:flex; align-items:center; gap:8px;border:1px solid rgba(255,255,255,.14);background:rgba(255,255,255,.06);padding:8px; border-radius:14px;}
        .tabs{margin-top:16px;border-radius:var(--radius2);border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.04);overflow:hidden;}
        .tabbtn{padding:10px 12px;border-radius:14px;border:1px solid rgba(255,255,255,.12);background: rgba(255,255,255,.05);color:rgba(255,255,255,.85);cursor:pointer;font-weight:900;font-size:14px;}
        .kit{padding:14px;border-radius:18px;border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);display:grid;gap:10px;}
        .bundle{border-radius:var(--radius2);border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.04);overflow:hidden;}
        .addon{padding:12px;border-radius:16px;border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);display:grid; gap:10px;}
        .related{display:grid; grid-template-columns: repeat(auto-fit, minmax(240px,1fr)); gap:16px; padding-bottom:22px}
        @media (max-width:980px){.nav{display:none}.search{min-width:0}.footer-grid{grid-template-columns:1.6fr 1fr 1fr}}
        @media (max-width:560px){.search{display:none}.footer-grid{grid-template-columns:1fr 1fr}}
    </style>
</head>
<body>
<div class="topbar">
    <div class="container">
        <div class="topbar-inner">
            <a class="brand" href="/">
                <span class="logo" aria-hidden="true"></span>
                <span>Strikeball Shop<small class="muted" style="display:block">MVP магазин</small></span>
            </a>
            <nav class="nav" aria-label="Основное меню">
                <a href="/category/privody">Каталог</a>
                <a href="/category/privody">Приводы</a>
                <a href="/category/akb">АКБ</a>
                <a href="/category/magaziny">Магазины</a>
            </nav>
            <form class="search" action="{{ route('search') }}" method="get">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="rgba(255,255,255,.75)" stroke-width="2"/><path d="M16.5 16.5 21 21" stroke="rgba(255,255,255,.75)" stroke-width="2" stroke-linecap="round"/></svg>
                <input type="search" name="q" placeholder="Поиск по магазину…" value="{{ request('q') }}" />
            </form>
            <div class="actions">
                @auth
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn small" type="submit">Выйти ({{ auth()->user()->name }})</button>
                    </form>
                    <a class="btn small" href="/admin/dashboard">Админка</a>
                @else
                    <a class="btn small" href="{{ route('login') }}">Войти</a>
                @endauth
                <a class="btn small" href="{{ route('cart') }}">Корзина</a>
            </div>
        </div>
    </div>
</div>

<main class="container">
    @if(session('status'))
        <div class="card" style="padding:12px;margin:12px 0;border-color:rgba(88,255,122,.35)">{{ session('status') }}</div>
    @endif
    @if($errors->any())
        <div class="card" style="padding:12px;margin:12px 0;border-color:rgba(255,77,77,.35)">
            <b>Ошибки:</b>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="row" style="gap:10px; margin-bottom:10px;">
                    <span class="logo" aria-hidden="true" style="width:38px;height:38px;border-radius:14px;"></span>
                    <div><b>Strikeball Shop</b><br/><small class="muted">Доставка • Гарантия • Сервис</small></div>
                </div>
                <p style="margin:0; color:var(--muted); font-size:13px; max-width:60ch;">Страйкбольный интернет-магазин: приводы, расходники, тюнинг и CRM для заказов.</p>
            </div>
            <div><h5>Каталог</h5><a href="/category/privody">Приводы</a><a href="/category/magaziny">Магазины</a><a href="/category/akb">АКБ</a><a href="/category/tyuning">Тюнинг</a></div>
            <div><h5>Покупателям</h5><a href="#">Доставка</a><a href="#">Оплата</a><a href="#">Гарантия</a><a href="#">Возврат</a></div>
            <div><h5>Компания</h5><a href="#">О нас</a><a href="#">Контакты</a><a href="#">Партнёрам</a><a href="#">Оферта</a></div>
        </div>
        <div class="copyright"><div>© {{ now()->year }} Strikeball Shop</div><div>MVP</div></div>
    </div>
</footer>
</body>
</html>
