<?php
header('Content-Type: application/json; charset=utf-8');
$action = $_GET['action'] ?? 'invoice';
if ($action === 'invoice') {
    $order = $_GET['order'] ?? 'demo';
    echo json_encode([
        'invoiceId' => 'demo-'.uniqid(),
        'pageUrl' => '/php/pay.php?order='.urlencode($order),
        'mode' => 'sandbox'
    ]);
    exit;
}
echo json_encode(['ok'=>true]);
