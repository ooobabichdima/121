<?php
require __DIR__.'/functions.php';
$contact = trim($_POST['contact'] ?? '');
$note = trim($_POST['note'] ?? '');
if ($contact) {
    $file = __DIR__.'/data/leads.json';
    $existing = file_exists($file) ? json_decode(file_get_contents($file), true) ?: [] : [];
    $existing[] = ['contact'=>$contact,'note'=>$note,'created_at'=>date('c')];
    file_put_contents($file, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $msg = 'Заявка отправлена';
} else { $msg = 'Контакт обязателен'; }
header('Location: /php/index.php?msg='.urlencode($msg));
