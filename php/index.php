<?php
require __DIR__.'/functions.php';
$products = data_store()['products'];
$featured = array_slice(array_values(array_filter($products, fn($p) => $p['featured'] ?? false)), 0, 8);
$new = array_slice(array_values(array_filter($products, fn($p) => $p['new'] ?? false)), 0, 8);
$bundles = array_slice($products, 0, 8);

base_layout('Главная', function () use ($featured, $new, $bundles) {
?>
<div class="section-title"><div><h2>Хиты продаж</h2><p>Быстрый старт</p></div></div>
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px,1fr));">
<?php foreach ($featured as $p): include __DIR__.'/partials/card.php'; endforeach; ?>
</div>
<div class="section-title"><div><h2>Новинки</h2><p>Самое свежее</p></div></div>
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px,1fr));">
<?php foreach ($new as $p): include __DIR__.'/partials/card.php'; endforeach; ?>
</div>
<div class="section-title"><div><h2>Подборки</h2><p>Комплекты под разные задачи</p></div></div>
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px,1fr));">
<?php foreach ($bundles as $p): include __DIR__.'/partials/card.php'; endforeach; ?>
</div>
<div class="section-title"><div><h2>Помочь с подбором</h2><p>Оставь контакт и пожелания</p></div></div>
<form class="card" method="post" action="/php/lead.php" style="padding:14px; display:grid; gap:10px; max-width:680px;">
  <label>Контакт<input class="btn small" name="contact" required></label>
  <label>Что ищешь<textarea class="btn small" name="note" rows="3"></textarea></label>
  <button class="btn primary" type="submit">Отправить</button>
</form>
<?php });
