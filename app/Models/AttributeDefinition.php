<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttributeDefinition extends Model
{
    use HasFactory;
    protected $table = 'attributes';

    protected $fillable = ['code', 'name', 'type'];

    public function values(): HasMany
    {
        return $this->hasMany(ProductAttribute::class, 'attribute_id');
    }
}
