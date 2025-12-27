<?php // expects $p
?>
<article class="card" style="overflow:hidden;display:flex;flex-direction:column;">
  <a class="card" href="/php/product.php?slug=<?= urlencode($p['slug']) ?>" style="border:none;box-shadow:none;background:rgba(255,255,255,.03);">
    <div style="padding:14px;min-height:140px;display:grid;place-items:center;background: radial-gradient(120px 120px at 30% 30%, rgba(88,255,122,.16), rgba(56,189,248,.10));border-bottom:1px solid rgba(255,255,255,.08);">
      <span class="muted">IMG</span>
    </div>
    <div style="padding:12px;">
      <div style="font-weight:900;font-size:14.5px;"><?= htmlspecialchars($p['name']) ?></div>
      <div class="muted" style="font-size:12.5px;margin-top:4px;">SKU: <?= htmlspecialchars($p['sku']) ?></div>
    </div>
  </a>
  <div style="padding:12px;display:flex;justify-content:space-between;align-items:center;border-top:1px solid rgba(255,255,255,.08);">
    <b><?= money($p['price']) ?></b>
    <form method="post" action="/php/cart.php">
      <input type="hidden" name="action" value="add">
      <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
      <button class="btn small primary" type="submit">В корзину</button>
    </form>
  </div>
</article>
