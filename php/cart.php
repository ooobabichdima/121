<?php
require __DIR__.'/functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        cart_add((int)$_POST['product_id'], (int)($_POST['qty'] ?? 1));
    } elseif ($action === 'update') {
        cart_update($_POST['items'] ?? []);
    } elseif ($action === 'remove' || isset($_POST['remove'])) {
        $pid = isset($_POST['remove']) ? (int)$_POST['remove'] : (int)$_POST['product_id'];
        cart_remove($pid);
    }
    header('Location: /php/cart.php');
    exit;
}
[$items, $subtotal] = cart_items();
$shipping = 0;
$total = $subtotal + $shipping;
base_layout('Корзина', function () use ($items, $subtotal, $total) {
?>
<div class="section-title"><div><h2>Корзина</h2><p>Управляй количеством</p></div></div>
<form method="post" action="/php/cart.php">
  <input type="hidden" name="action" value="update">
  <div class="grid" style="gap:12px;">
    <?php foreach ($items as $item): $p=$item['product']; ?>
      <div class="card" style="padding:12px; display:flex; justify-content:space-between; gap:12px; align-items:center; flex-wrap:wrap;">
        <div>
          <b><?= htmlspecialchars($p['name']) ?></b><br>
          <span class="muted">SKU: <?= htmlspecialchars($p['sku']) ?></span>
        </div>
        <div class="row" style="align-items:center; gap:10px;">
          <input type="number" name="items[<?= $p['id'] ?>]" value="<?= $item['qty'] ?>" min="1" max="99" class="btn small" style="width:80px; text-align:center;">
          <span><?= money($item['line']) ?></span>
          <button class="btn small" type="submit" name="remove" value="<?= $p['id'] ?>" formaction="/php/cart.php" formmethod="post">Удалить</button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="card" style="padding:14px; margin-top:12px; display:flex; justify-content:space-between;">
    <div>Итого: <b><?= money($total) ?></b></div>
    <div class="row" style="gap:10px;">
      <button class="btn" type="submit">Пересчитать</button>
      <a class="btn primary" href="/php/checkout.php">Оформить заказ</a>
    </div>
  </div>
</form>
<?php });
