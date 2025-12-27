<?php
require __DIR__.'/functions.php';
$slug = $_GET['slug'] ?? '';
$product = find_product_by_slug($slug);
if (!$product) { http_response_code(404); echo 'Not found'; exit; }
$recommended = relations_for($product['id'], 'recommended');
$tuning = relations_for($product['id'], 'tuning_kit');
base_layout($product['name'], function () use ($product, $recommended, $tuning) {
?>
<div class="crumbs" style="padding:18px 0 10px; color:rgba(255,255,255,.62); font-size:13px">
  <a href="/php/index.php">Главная</a> / <a href="/php/category.php?category=<?= urlencode($product['category']) ?>">Категория</a> / <span><?= htmlspecialchars($product['name']) ?></span>
</div>
<section class="product-wrap" style="display:grid;grid-template-columns:1.05fr .95fr;gap:16px;padding-bottom:18px;">
  <div class="card" style="padding:14px;">
    <div class="row" style="justify-content:space-between; flex-wrap:wrap;">
      <span class="pill">★ <?= $product['featured'] ? 'Хит' : 'Товар' ?> • <?= $product['stock']>0?'В наличии':'Нет' ?></span>
      <span class="pill">Гарантия: 6 мес</span>
    </div>
    <div class="main-shot" style="height:360px;border-radius:18px;border:1px solid rgba(255,255,255,.12);background:radial-gradient(160px 160px at 30% 30%, rgba(255,255,255,.10), transparent 60%),linear-gradient(135deg, rgba(88,255,122,.16), rgba(56,189,248,.10));display:grid;place-items:center;overflow:hidden;">
      <svg width="160" height="160" viewBox="0 0 120 120" fill="none" aria-hidden="true">
        <path d="M20 70c20-18 40-26 80-30l5 10-70 16-6 10-9 2Z" stroke="rgba(255,255,255,.92)" stroke-width="3" stroke-linejoin="round"/>
        <path d="M52 66l-7 18" stroke="rgba(255,255,255,.8)" stroke-width="3" stroke-linecap="round"/>
        <path d="M72 60l-4 18" stroke="rgba(255,255,255,.8)" stroke-width="3" stroke-linecap="round"/>
      </svg>
    </div>
    <ul class="bullets" style="margin-top:12px; list-style:none; padding:0; display:grid; gap:8px">
      <li style="padding:10px 12px;border-radius:14px;border:1px solid rgba(255,255,255,.10);background:rgba(255,255,255,.05);color:rgba(255,255,255,.82);">Платформа: <b><?= htmlspecialchars($product['attrs']['platform'] ?? '—') ?></b></li>
      <li style="padding:10px 12px;border-radius:14px;border:1px solid rgba(255,255,255,.10);background:rgba(255,255,255,.05);color:rgba(255,255,255,.82);">Тип: <b><?= htmlspecialchars($product['attrs']['type'] ?? 'AEG') ?></b></li>
      <li style="padding:10px 12px;border-radius:14px;border:1px solid rgba(255,255,255,.10);background:rgba(255,255,255,.05);color:rgba(255,255,255,.82);">FPS: <b><?= htmlspecialchars($product['attrs']['fps'] ?? '—') ?></b></li>
    </ul>
  </div>
  <div class="card" style="padding:16px;">
    <span class="pill"><?= htmlspecialchars($product['brand']) ?></span>
    <h1 style="margin:8px 0 8px; font-size:var(--h1); line-height:1.08"><?= htmlspecialchars($product['name']) ?></h1>
    <div class="rate" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; color:var(--muted); font-size:13px">
      <span><span class="star">★★★★★</span> <b>4.8</b></span>
      <span class="muted2">•</span>
      <span class="sku">SKU: <?= htmlspecialchars($product['sku']) ?></span>
      <span class="muted2">•</span>
      <span class="muted">Доставка 1–3 дня</span>
    </div>
    <div class="pricebox">
      <div>
        <div class="price" style="font-weight:950; font-size:22px;"><?= money($product['price']) ?> <?php if($product['old_price']): ?><span class="strike" style="color:rgba(255,255,255,.45); text-decoration:line-through; font-weight:700; margin-left:8px"><?= money($product['old_price']) ?></span><?php endif; ?></div>
        <div class="stock" style="color:rgba(255,255,255,.80); font-size:13px">Наличие: <b><?= $product['stock']>0?'в наличии':'нет' ?></b> • Осталось: <b><?= $product['stock'] ?></b></div>
      </div>
      <div class="row" style="flex-wrap:wrap; justify-content:flex-end;">
        <form method="post" action="/php/cart.php" class="row" style="flex-wrap:wrap; gap:8px;">
          <input type="hidden" name="action" value="add">
          <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
          <div class="qty" style="display:flex; align-items:center; gap:8px;border:1px solid rgba(255,255,255,.14);background:rgba(255,255,255,.06);padding:8px; border-radius:14px;">
            <input name="qty" type="number" value="1" min="1" max="99" style="width:52px;text-align:center;border:none;outline:none;background:transparent;color:var(--text);font-weight:900" />
          </div>
          <button class="btn primary" type="submit">В корзину</button>
        </form>
      </div>
    </div>
    <div class="tabs" style="margin-top:16px;border-radius:var(--radius2);border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.04);overflow:hidden;">
      <div class="tabbar" style="display:flex; gap:8px; flex-wrap:wrap;padding:10px;border-bottom:1px solid rgba(255,255,255,.10);background: rgba(0,0,0,.14);">
        <button class="tabbtn active" type="button" style="padding:10px 12px;border-radius:14px;border:1px solid rgba(255,255,255,.12);background: rgba(255,255,255,.05);color:rgba(255,255,255,.85);cursor:pointer;font-weight:900;font-size:14px">Описание</button>
      </div>
      <div class="tabpanel" style="padding:14px;">
        <p style="margin:0 0 10px; color:rgba(255,255,255,.84);">Демо описание: параметры подтягиваются из PHP массива.</p>
        <div class="grid" style="grid-template-columns:1fr 1fr;gap:10px;">
          <div class="card" style="padding:12px;">Бренд: <b><?= htmlspecialchars($product['brand']) ?></b></div>
          <div class="card" style="padding:12px;">Категория: <b><?= htmlspecialchars($product['category']) ?></b></div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="section-title"><div><h2>Наборы для тюнинга</h2><p>Готовые пакеты</p></div></div>
<div class="grid" style="gap:12px;">
<?php foreach ($tuning as $kit): ?>
  <div class="card" style="padding:14px; display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap;">
    <div>
      <div style="font-weight:950; font-size:15px;"><?= htmlspecialchars($kit['name']) ?></div>
      <div class="muted2" style="font-size:13px;">Тюнинг пакет</div>
      <div class="kit-price" style="font-weight:950; font-size:18px"><?= money($kit['price']) ?></div>
    </div>
    <form method="post" action="/php/cart.php">
      <input type="hidden" name="action" value="add">
      <input type="hidden" name="product_id" value="<?= $kit['id'] ?>">
      <button class="btn small primary" type="submit">Добавить</button>
    </form>
  </div>
<?php endforeach; ?>
</div>
<div class="section-title"><div><h2>С этим покупают</h2><p>Рекомендации</p></div></div>
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px,1fr));">
<?php foreach ($recommended as $rec): include __DIR__.'/partials/card.php'; endforeach; ?>
</div>
<?php });
