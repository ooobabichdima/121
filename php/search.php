<?php
require __DIR__.'/functions.php';
$q = trim($_GET['q'] ?? '');
$results = [];
if ($q !== '') {
    $results = array_values(array_filter(data_store()['products'], fn($p) => stripos($p['name'], $q) !== false || stripos($p['sku'], $q) !== false));
}
base_layout('Поиск', function () use ($q, $results) {
?>
<div class="section-title"><div><h2>Поиск</h2><p>Запрос: "<?= htmlspecialchars($q) ?>"</p></div></div>
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px,1fr));">
<?php if(!$results): ?><div class="card" style="padding:14px;">Ничего не найдено.</div><?php endif; ?>
<?php foreach ($results as $p): include __DIR__.'/partials/card.php'; endforeach; ?>
</div>
<?php });
