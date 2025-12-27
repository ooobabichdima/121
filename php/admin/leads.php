<?php
require __DIR__.'/../functions.php';
$file = __DIR__.'/../data/leads.json';
$leads = file_exists($file) ? array_reverse(json_decode(file_get_contents($file), true) ?: []) : [];
base_layout('Admin / Leads', function () use ($leads) {
?>
<div class="section-title"><div><h2>Admin / Лиды</h2><p>Заявки "Помочь с подбором"</p></div></div>
<table class="card" style="width:100%; border-collapse:collapse;">
  <thead><tr><th style="padding:10px; text-align:left;">Контакт</th><th>Комментарий</th><th>Дата</th></tr></thead>
  <tbody>
  <?php foreach ($leads as $lead): ?>
    <tr style="border-top:1px solid rgba(255,255,255,.08);">
      <td style="padding:10px;"><?= htmlspecialchars($lead['contact']) ?></td>
      <td><?= htmlspecialchars($lead['note'] ?? '') ?></td>
      <td><?= htmlspecialchars($lead['created_at'] ?? '') ?></td>
    </tr>
  <?php endforeach; ?>
  <?php if(!$leads): ?><tr><td colspan="3" style="padding:10px;">Нет заявок</td></tr><?php endif; ?>
  </tbody>
</table>
<?php });
