<?php
require __DIR__.'/functions.php';
$order = $_GET['order'] ?? 'demo';
$paid = isset($_GET['paid']);
if ($paid) {
    $msg = 'Оплата подтверждена (demo) для заказа '.$order;
} else {
    $msg = 'Нажмите для подтверждения оплаты (sandbox)';
}
base_layout('Оплата', function () use ($order, $msg) {
?>
<div class="card" style="padding:16px; margin-top:16px;">
  <h2>Оплата Monobank (demo)</h2>
  <p class="muted"><?= htmlspecialchars($msg) ?></p>
  <?php if(strpos($msg,'подтверждена')===false): ?>
    <a class="btn primary" href="/php/pay.php?order=<?= urlencode($order) ?>&paid=1">Оплачено (demo)</a>
  <?php endif; ?>
</div>
<?php });
