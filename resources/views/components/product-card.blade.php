@props(['product'])
<article class="card" style="overflow:hidden;display:flex;flex-direction:column;">
    <a class="card" href="{{ route('product.show', $product->slug) }}" style="border:none;box-shadow:none;background:rgba(255,255,255,.03);">
        <div style="padding:14px;min-height:140px;display:grid;place-items:center;background: radial-gradient(120px 120px at 30% 30%, rgba(88,255,122,.16), rgba(56,189,248,.10));border-bottom:1px solid rgba(255,255,255,.08);">
            <span class="muted">IMG</span>
        </div>
        <div style="padding:12px;">
            <div style="font-weight:900;font-size:14.5px;">{{ $product->name }}</div>
            <div class="muted" style="font-size:12.5px;margin-top:4px;">SKU: {{ $product->sku }}</div>
        </div>
    </a>
    <div style="padding:12px;display:flex;justify-content:space-between;align-items:center;border-top:1px solid rgba(255,255,255,.08);">
        <b>{{ money($product->price) }}</b>
        <form method="post" action="{{ route('cart.add') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button class="btn small primary" type="submit">В корзину</button>
        </form>
    </div>
</article>
