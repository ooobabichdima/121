<?php
require __DIR__.'/functions.php';
$slug = $_GET['category'] ?? 'privody';
$categories = data_store()['categories'];
$current = array_values(array_filter($categories, fn($c) => $c['slug'] === $slug))[0] ?? $categories[0];
$q = trim($_GET['q'] ?? '');
$sort = $_GET['sort'] ?? '';
$products = products_by_category($current['slug']);
if ($q !== '') {
    $products = array_values(array_filter($products, fn($p) => stripos($p['name'], $q) !== false || stripos($p['sku'], $q) !== false));
}
if ($sort === 'price_asc') usort($products, fn($a,$b) => $a['price'] <=> $b['price']);
if ($sort === 'price_desc') usort($products, fn($a,$b) => $b['price'] <=> $a['price']);
if ($sort === 'new') usort($products, fn($a,$b) => ($b['new']??false) <=> ($a['new']??false));

base_layout('Категория', function () use ($current, $products, $q, $sort) {
?>
<div class="section-title">
  <div><h2><?= htmlspecialchars($current['name']) ?></h2><p>Фильтры и поиск</p></div>
  <form method="get" class="row" style="gap:8px;flex-wrap:wrap;">
    <input type="hidden" name="category" value="<?= htmlspecialchars($current['slug']) ?>">
    <input class="btn small" type="search" name="q" placeholder="Поиск" value="<?= htmlspecialchars($q) ?>">
    <select name="sort" class="btn small">
      <option value="">Сортировка</option>
      <option value="price_asc" <?= $sort==='price_asc'?'selected':'' ?>>Цена ↑</option>
      <option value="price_desc" <?= $sort==='price_desc'?'selected':'' ?>>Цена ↓</option>
      <option value="new" <?= $sort==='new'?'selected':'' ?>>Новинки</option>
    </select>
    <button class="btn small" type="submit">Применить</button>
  </form>
</div>
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px,1fr));">
<?php foreach ($products as $p): include __DIR__.'/partials/card.php'; endforeach; ?>
</div>
<?php });
