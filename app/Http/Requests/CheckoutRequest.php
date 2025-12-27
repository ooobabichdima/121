<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:150',
            'phone' => 'required|string|max:32',
            'email' => 'nullable|email',
            'delivery_method' => 'required|string|in:nova_poshta,courier,pickup',
            'city' => 'nullable|string|max:150',
            'warehouse' => 'nullable|string|max:150',
            'address' => 'nullable|string|max:255',
            'payment_method' => 'required|string|in:cod,monobank,parts',
            'promo_code' => 'nullable|string|max:20',
            'comment' => 'nullable|string|max:500',
            'upsell_mag_qty' => 'nullable|integer|min:0|max:10',
        ];
    }
}
