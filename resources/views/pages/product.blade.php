@extends('layouts.app')

@section('content')
<div class="crumbs" style="padding:18px 0 10px; color:rgba(255,255,255,.62); font-size:13px">
    <a href="/">Главная</a> / <a href="{{ route('category', $product->category->slug) }}">{{ $product->category->name }}</a> / <span>{{ $product->name }}</span>
</div>

<section class="product-wrap" style="display:grid;grid-template-columns:1.05fr .95fr;gap:16px;padding-bottom:18px;">
    <div class="card gallery" aria-label="Галерея товара" style="padding:14px;">
        <div class="row" style="justify-content:space-between; flex-wrap:wrap;">
            <span class="pill">★ {{ $product->is_featured ? 'Хит' : 'Товар' }} • {{ $product->stock > 0 ? 'В наличии' : 'Нет' }}</span>
            <span class="pill">Гарантия: 6 мес</span>
        </div>
        <div class="main-shot" id="mainShot" aria-label="Основное изображение" style="height:360px;border-radius:18px;border:1px solid rgba(255,255,255,.12);background:radial-gradient(160px 160px at 30% 30%, rgba(255,255,255,.10), transparent 60%),linear-gradient(135deg, rgba(88,255,122,.16), rgba(56,189,248,.10));display:grid;place-items:center;overflow:hidden;">
            <svg width="160" height="160" viewBox="0 0 120 120" fill="none" aria-hidden="true">
                <path d="M20 70c20-18 40-26 80-30l5 10-70 16-6 10-9 2Z" stroke="rgba(255,255,255,.92)" stroke-width="3" stroke-linejoin="round"/>
                <path d="M52 66l-7 18" stroke="rgba(255,255,255,.8)" stroke-width="3" stroke-linecap="round"/>
                <path d="M72 60l-4 18" stroke="rgba(255,255,255,.8)" stroke-width="3" stroke-linecap="round"/>
            </svg>
        </div>
        <div class="thumbs" role="list" aria-label="Миниатюры" style="display:grid; grid-template-columns: repeat(4, 1fr); gap:10px; margin-top:12px">
            @foreach($product->images as $image)
                <button class="thumb {{ $loop->first ? 'active' : '' }}" type="button" aria-label="Фото {{ $loop->iteration }}" style="height:72px;border-radius:14px;border:1px solid rgba(255,255,255,.12);background: rgba(0,0,0,.18);cursor:pointer;display:grid; place-items:center;transition:.12s ease;color:rgba(255,255,255,.80);font-weight:900;">{{ $loop->iteration }}</button>
            @endforeach
            @if($product->images->isEmpty())
                <button class="thumb active" type="button" aria-label="Фото 1" style="height:72px;border-radius:14px;border:1px solid rgba(255,255,255,.12);background: rgba(0,0,0,.18);cursor:pointer;display:grid; place-items:center;transition:.12s ease;color:rgba(255,255,255,.80);font-weight:900;">1</button>
            @endif
        </div>
        <ul class="bullets" style="margin-top:12px; list-style:none; padding:0; display:grid; gap:8px">
            <li style="padding:10px 12px;border-radius:14px;border:1px solid rgba(255,255,255,.10);background:rgba(255,255,255,.05);color:rgba(255,255,255,.82);">Платформа: <b>{{ $product->attributes->firstWhere('attribute.code','platform')->value_string ?? '—' }}</b></li>
            <li style="padding:10px 12px;border-radius:14px;border:1px solid rgba(255,255,255,.10);background:rgba(255,255,255,.05);color:rgba(255,255,255,.82);">Тип: <b>{{ $product->attributes->firstWhere('attribute.code','type')->value_string ?? 'AEG' }}</b></li>
            <li style="padding:10px 12px;border-radius:14px;border:1px solid rgba(255,255,255,.10);background:rgba(255,255,255,.05);color:rgba(255,255,255,.82);">FPS: <b>{{ $product->attributes->firstWhere('attribute.code','fps')->value_number ?? '—' }}</b></li>
        </ul>
    </div>
    <div class="card info" aria-label="Информация о товаре" style="padding:16px;">
        <span class="pill">{{ $product->category->name }}</span>
        <h1 style="margin:8px 0 8px; font-size:var(--h1); line-height:1.08">{{ $product->name }}</h1>
        <div class="rate" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; color:var(--muted); font-size:13px">
            <span><span class="star">★★★★★</span> <b>4.8</b></span>
            <span class="muted2">•</span>
            <span class="sku">SKU: {{ $product->sku }}</span>
            <span class="muted2">•</span>
            <span class="muted">Доставка 1–3 дня</span>
        </div>
        <div class="pricebox" style="margin-top:14px;padding:14px;border-radius:18px;border:1px solid rgba(255,255,255,.12);background: rgba(0,0,0,.18);display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;">
            <div>
                <div class="price" id="basePrice" data-base-price="{{ $product->price }}" style="font-weight:950; font-size:22px">{{ money($product->price) }} @if($product->old_price)<span class="strike" style="color:rgba(255,255,255,.45); text-decoration:line-through; font-weight:700; margin-left:8px">{{ money($product->old_price) }}</span>@endif</div>
                <div class="stock" style="color:rgba(255,255,255,.80); font-size:13px">Наличие: <b>{{ $product->stock > 0 ? 'в наличии' : 'нет' }}</b> • Осталось: <b>{{ $product->stock }}</b></div>
                <div class="muted2" style="margin-top:6px; font-size:13px;">Цена из БД, пересчитывается по количеству.</div>
            </div>
            <div class="row" style="flex-wrap:wrap; justify-content:flex-end;">
                <form method="post" action="{{ route('cart.add') }}" class="row" style="flex-wrap:wrap; gap:8px;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="qty" aria-label="Количество" style="display:flex; align-items:center; gap:8px;border:1px solid rgba(255,255,255,.14);background:rgba(255,255,255,.06);padding:8px; border-radius:14px;">
                        <input name="qty" type="number" value="1" min="1" max="99" style="width:52px;text-align:center;border:none;outline:none;background:transparent;color:var(--text);font-weight:900" />
                    </div>
                    <button class="btn primary" type="submit">В корзину</button>
                </form>
            </div>
        </div>
        <div class="tabs" id="tabs" style="margin-top:16px;border-radius:var(--radius2);border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.04);overflow:hidden;">
            <div class="tabbar" role="tablist" aria-label="Вкладки" style="display:flex; gap:8px; flex-wrap:wrap;padding:10px;border-bottom:1px solid rgba(255,255,255,.10);background: rgba(0,0,0,.14);">
                <button class="tabbtn active" type="button" style="padding:10px 12px;border-radius:14px;border:1px solid rgba(255,255,255,.12);background: rgba(255,255,255,.05);color:rgba(255,255,255,.85);cursor:pointer;font-weight:900;font-size:14px">Описание</button>
            </div>
            <div class="tabpanel" style="padding:14px;">
                <p style="margin:0 0 10px; color:rgba(255,255,255,.84);">{{ $product->description }}</p>
                <div class="grid" style="grid-template-columns:1fr 1fr;gap:10px;">
                    <div class="card" style="padding:12px;">Бренд: <b>{{ optional($product->brand)->name }}</b></div>
                    <div class="card" style="padding:12px;">Категория: <b>{{ $product->category->name }}</b></div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="section-title">
    <div>
        <h2>Наборы для тюнинга</h2>
        <p>Готовые пакеты апгрейда</p>
    </div>
</div>
<div class="kits" aria-label="Наборы тюнинга" style="display:grid; grid-template-columns: 1fr; gap:12px">
    @foreach($tuningKits as $kit)
    <div class="kit" style="padding:14px;border-radius:18px;border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);display:grid;gap:10px;">
        <div class="kit-top" style="display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; align-items:flex-start">
            <div>
                <div class="kit-name" style="font-weight:950; font-size:15px">{{ $kit->name }}</div>
                <div class="muted2" style="font-size:13px;">Тюнинг пакет</div>
            </div>
            <span class="kit-tag" style="display:inline-flex; align-items:center; gap:6px;padding:6px 10px; border-radius:999px;border:1px solid rgba(255,255,255,.12);background:rgba(0,0,0,.18);color:rgba(255,255,255,.78); font-size:12px; font-weight:950;">тюнинг</span>
        </div>
        <div class="kit-foot" style="display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; align-items:center">
            <div>
                <div class="kit-price" style="font-weight:950; font-size:18px">{{ money($kit->price) }}</div>
                <div class="kit-note" style="color:rgba(255,255,255,.55); font-size:12.5px; max-width:70ch">Добавь тюнинг в заказ, мы учтём в CRM.</div>
            </div>
            <form method="post" action="{{ route('cart.add') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $kit->id }}">
                <button class="btn small primary" type="submit">Добавить пакет</button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<div class="bundle" style="margin-top:16px;border-radius:var(--radius2);border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.04);overflow:hidden;" aria-label="Рекомендованные товары">
    <div class="bundle-head" style="padding:12px 14px;border-bottom:1px solid rgba(255,255,255,.10);background:rgba(0,0,0,.14);display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; align-items:flex-end;">
        <div>
            <b>С этим автоматом покупают</b>
            <div class="muted" style="font-size:13px; margin-top:4px;">Собери комплект — сумма считается автоматически.</div>
        </div>
    </div>
    <div class="bundle-body" style="padding:14px; display:grid; gap:12px">
        <div class="bundle-items" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:12px">
            @foreach($recommended as $rec)
            <div class="addon" style="padding:12px;border-radius:16px;border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);display:grid; gap:10px;">
                <div class="addon-top" style="display:flex; justify-content:space-between; gap:10px; align-items:flex-start">
                    <div>
                        <div class="addon-title" style="font-weight:950; font-size:14px">{{ $rec->name }}</div>
                        <div class="addon-meta" style="color:rgba(255,255,255,.60); font-size:12.5px">SKU: {{ $rec->sku }}</div>
                    </div>
                    <form method="post" action="{{ route('cart.add') }}" class="addon-controls" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; justify-content:flex-end">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $rec->id }}">
                        <input type="number" name="qty" value="1" min="1" max="10" class="mini-qty" style="width:64px; border-radius:10px; border:1px solid rgba(255,255,255,.12); background:rgba(255,255,255,.06); color:var(--text); text-align:center;">
                        <button class="btn small primary" type="submit">+ {{ money($rec->price) }}</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="section-title">
    <div>
        <h2>Похожие товары</h2>
        <p>Кросс-селл рядом с карточкой</p>
    </div>
</div>
<section class="related" aria-label="Похожие товары" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px,1fr)); gap:16px; padding-bottom:22px">
    @foreach($recommended as $rec)
        <x-product-card :product="$rec" />
    @endforeach
</section>
@endsection
