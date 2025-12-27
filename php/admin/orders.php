<?php
require __DIR__.'/../functions.php';
$orders = array_reverse(read_orders());
base_layout('Admin / Orders', function () use ($orders) {
?>
<div class="section-title"><div><h2>Admin / Заказы</h2><p>Демо CRM</p></div></div>
<table class="card" style="width:100%; border-collapse:collapse;">
  <thead><tr><th style="padding:10px; text-align:left;">Номер</th><th>Клиент</th><th>Сумма</th><th>Дата</th></tr></thead>
  <tbody>
  <?php foreach ($orders as $o): ?>
    <tr style="border-top:1px solid rgba(255,255,255,.08);">
      <td style="padding:10px;"><?= htmlspecialchars($o['number']) ?></td>
      <td><?= htmlspecialchars($o['customer_name']) ?> / <?= htmlspecialchars($o['phone']) ?></td>
      <td><?= money($o['total']) ?></td>
      <td><?= htmlspecialchars($o['created_at']) ?></td>
    </tr>
  <?php endforeach; ?>
  <?php if(!$orders): ?><tr><td colspan="4" style="padding:10px;">Пока нет заказов</td></tr><?php endif; ?>
  </tbody>
</table>
<?php });
