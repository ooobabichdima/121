<?php
header('Content-Type: application/json; charset=utf-8');
$q = trim($_GET['q'] ?? '');
$cities = [
    ['name' => 'Киев', 'ref' => 'demo-kyiv'],
    ['name' => 'Львов', 'ref' => 'demo-lviv'],
    ['name' => 'Одесса', 'ref' => 'demo-odessa'],
];
if (isset($_GET['cityRef'])) {
    echo json_encode([
        ['name' => 'Отделение №1 (ул. Примерная, 1)', 'ref' => 'wh-1'],
        ['name' => 'Отделение №2 (ул. Игровая, 5)', 'ref' => 'wh-2'],
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
if ($q !== '') {
    $cities = array_values(array_filter($cities, fn($c) => stripos($c['name'], $q)!==false));
}
echo json_encode($cities, JSON_UNESCAPED_UNICODE);
