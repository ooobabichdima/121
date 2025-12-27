<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'number','user_id','status','customer_name','phone','email','subtotal','discount','shipping_cost','total','shipping_provider','shipping_city','shipping_ref','shipping_address','comment','promo_code'
    ];

    protected $casts = [
        'subtotal' => 'float',
        'discount' => 'float',
        'shipping_cost' => 'float',
        'total' => 'float'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
