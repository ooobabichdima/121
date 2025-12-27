<?php
require __DIR__.'/functions.php';
$errors = [];$message='';
[$items, $subtotal] = cart_items();
if ($_SERVER['REQUEST_METHOD']==='POST') {
    if (!$items) { $errors[]='Корзина пуста'; }
    $name = trim($_POST['customer_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $delivery = $_POST['delivery_method'] ?? 'nova_poshta';
    $payment = $_POST['payment_method'] ?? 'cod';
    $promo = strtoupper(trim($_POST['promo_code'] ?? ''));
    $upsellQty = max(0, min(10, (int)($_POST['upsell_mag_qty'] ?? 0)));
    if ($upsellQty>0) { cart_add(101, $upsellQty); [$items,$subtotal]=cart_items(); }
    if ($name==='') $errors[]='Имя обязательно';
    if ($phone==='') $errors[]='Телефон обязателен';
    $shippingCost = $delivery==='courier'?200:($delivery==='pickup'?0:150);
    $discount = promo_discount($promo, $subtotal);
    $total = max(0, $subtotal - $discount + $shippingCost);
    if (!$errors) {
        $order = [
            'number' => 'ORD-'.date('ymd').'-'.rand(1000,9999),
            'customer_name' => $name,
            'phone' => $phone,
            'email' => $email,
            'delivery' => $delivery,
            'payment' => $payment,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shippingCost,
            'total' => $total,
            'items' => array_map(fn($i)=>['name'=>$i['product']['name'],'sku'=>$i['product']['sku'],'qty'=>$i['qty'],'price'=>$i['product']['price']], $items),
            'created_at' => date('c'),
        ];
        save_order($order);
        cart_set([]);
        $message = 'Заказ оформлен: '.$order['number'].' (demo оплата)';
    }
}
[$items, $subtotal] = cart_items();
$shippingDemo = 150;
$discountDemo = promo_discount($_POST['promo_code'] ?? '', $subtotal);
$totalDemo = max(0, $subtotal - $discountDemo + $shippingDemo);
base_layout('Checkout', function () use ($items, $subtotal, $errors, $message, $discountDemo, $shippingDemo, $totalDemo) {
?>
<div class="section-title"><div><h2>Оформление</h2><p>Контакты, доставка, оплата</p></div></div>
<?php if($message): ?><div class="card" style="padding:12px; border-color:rgba(88,255,122,.35)"><?= htmlspecialchars($message) ?></div><?php endif; ?>
<?php if($errors): ?><div class="card" style="padding:12px; border-color:rgba(255,77,77,.35)"><ul><?php foreach($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post" class="grid" style="grid-template-columns:1.1fr .9fr; gap:14px;">
  <div class="card" style="padding:14px; display:grid; gap:12px;">
    <div class="grid" style="grid-template-columns:1fr 1fr; gap:10px;">
      <label>Имя<input class="btn small" name="customer_name" required></label>
      <label>Телефон<input class="btn small" name="phone" required></label>
      <label>Email<input class="btn small" name="email"></label>
      <label>Промокод<input class="btn small" name="promo_code" placeholder="START10/BBS50"></label>
    </div>
    <div class="card" style="padding:12px; background:rgba(0,0,0,.18);">
      <b>Доставка</b>
      <div class="row" style="flex-wrap:wrap; gap:10px; margin-top:8px;">
        <label class="pill"><input type="radio" name="delivery_method" value="nova_poshta" checked> Нова Пошта</label>
        <label class="pill"><input type="radio" name="delivery_method" value="courier"> Курьер</label>
        <label class="pill"><input type="radio" name="delivery_method" value="pickup"> Самовывоз</label>
      </div>
    </div>
    <div class="card" style="padding:12px; background:rgba(0,0,0,.18);">
      <b>Оплата</b>
      <div class="row" style="flex-wrap:wrap; gap:10px; margin-top:8px;">
        <label class="pill"><input type="radio" name="payment_method" value="cod" checked> Наложенный</label>
        <label class="pill"><input type="radio" name="payment_method" value="monobank"> Monobank (demo)</label>
        <label class="pill"><input type="radio" name="payment_method" value="parts"> Оплата частями (demo)</label>
      </div>
    </div>
    <div class="card" style="padding:12px;">
      <b>Upsell: Магазины M4</b>
      <div class="row" style="gap:10px; margin-top:8px;">
        <label>Кол-во 0-10<input type="number" class="btn small" name="upsell_mag_qty" min="0" max="10" value="0" style="width:120px"></label>
        <span class="muted">390 грн/шт</span>
      </div>
    </div>
  </div>
  <div class="card" style="padding:14px; display:grid; gap:10px; height:fit-content;">
    <b>Состав заказа</b>
    <?php foreach ($items as $item): $p=$item['product']; ?>
      <div class="row" style="justify-content:space-between;">
        <span><?= htmlspecialchars($p['name']) ?> × <?= $item['qty'] ?></span>
        <span><?= money($item['line']) ?></span>
      </div>
    <?php endforeach; ?>
    <hr style="width:100%; border:1px solid rgba(255,255,255,.08);">
    <div class="row" style="justify-content:space-between;"><span>Сумма</span><b><?= money($subtotal) ?></b></div>
    <div class="row" style="justify-content:space-between;"><span>Скидка</span><b>-<?= money($discountDemo) ?></b></div>
    <div class="row" style="justify-content:space-between;"><span>Доставка (демо)</span><b><?= money($shippingDemo) ?></b></div>
    <div class="row" style="justify-content:space-between;"><span>Итого</span><b><?= money($totalDemo) ?></b></div>
    <button class="btn primary" type="submit">Подтвердить заказ</button>
  </div>
</form>
<?php });
