<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id','provider','status','amount','currency','invoice_id','payload_json'
    ];

    protected $casts = [
        'payload_json' => 'array',
        'amount' => 'float'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
