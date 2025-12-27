<?php
session_start();

function data_store(): array
{
    static $data = null;
    if ($data === null) {
        $data = require __DIR__.'/data/catalog.php';
    }
    return $data;
}

function money($value, $suffix = 'грн'): string
{
    return number_format((float)$value, 0, '.', ' ').' '.$suffix;
}

function find_product_by_slug(string $slug): ?array
{
    foreach (data_store()['products'] as $p) {
        if ($p['slug'] === $slug) return $p;
    }
    return null;
}

function find_product(int $id): ?array
{
    foreach (data_store()['products'] as $p) {
        if ($p['id'] === $id) return $p;
    }
    return null;
}

function products_by_category(string $slug): array
{
    return array_values(array_filter(data_store()['products'], fn($p) => $p['category'] === $slug));
}

function relations_for(int $productId, string $type): array
{
    $list = data_store()['relations'][$type] ?? [];
    $ids = array_column(array_filter($list, fn($rel) => $rel['product'] === $productId), 'related');
    return array_values(array_filter(data_store()['products'], fn($p) => in_array($p['id'], $ids)));
}

function promo_discount(string $code, float $subtotal): float
{
    $map = ['START10' => fn($sum) => $sum * 0.1, 'BBS50' => fn($sum) => 50];
    $code = strtoupper(trim($code));
    return isset($map[$code]) ? $map[$code]($subtotal) : 0;
}

function cart_get(): array
{
    return $_SESSION['cart'] ?? [];
}

function cart_set(array $cart): void
{
    $_SESSION['cart'] = $cart;
}

function cart_add(int $productId, int $qty = 1): void
{
    $cart = cart_get();
    $cart[$productId] = ($cart[$productId] ?? 0) + max(1, min($qty, 99));
    cart_set($cart);
}

function cart_update(array $items): void
{
    $cart = [];
    foreach ($items as $pid => $qty) {
        $qty = (int)$qty;
        if ($qty > 0) $cart[(int)$pid] = min($qty, 99);
    }
    cart_set($cart);
}

function cart_remove(int $productId): void
{
    $cart = cart_get();
    unset($cart[$productId]);
    cart_set($cart);
}

function cart_items(): array
{
    $cart = cart_get();
    $items = [];
    $subtotal = 0;
    foreach ($cart as $pid => $qty) {
        $product = find_product((int)$pid);
        if (! $product) continue;
        $line = $product['price'] * $qty;
        $subtotal += $line;
        $items[] = ['product' => $product, 'qty' => $qty, 'line' => $line];
    }
    return [$items, $subtotal];
}

function save_order(array $order): void
{
    $file = __DIR__.'/data/orders.json';
    $existing = file_exists($file) ? json_decode(file_get_contents($file), true) ?: [] : [];
    $existing[] = $order;
    file_put_contents($file, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function read_orders(): array
{
    $file = __DIR__.'/data/orders.json';
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?: [];
}

function base_layout(string $title, callable $content): void
{
    include __DIR__.'/partials/header.php';
    $content();
    include __DIR__.'/partials/footer.php';
}
