<?php

if (! function_exists('money')) {
    function money(int|float $value, string $suffix = 'грн') : string
    {
        return number_format($value, 0, '.', ' ').' '.$suffix;
    }
}

if (! function_exists('promo_discount')) {
    function promo_discount(string $code, float $subtotal): float
    {
        $normalized = strtoupper(trim($code));
        return match ($normalized) {
            'START10' => $subtotal * 0.10,
            'BBS50' => 50.0,
            default => 0.0,
        };
    }
}
