<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\OrderItem;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'brand_id', 'name', 'slug', 'sku', 'price', 'old_price', 'stock', 'description', 'specs_json', 'is_active', 'is_featured', 'is_new'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'specs_json' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function recommended(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_relations', 'product_id', 'related_id')->wherePivot('type', 'recommended');
    }

    public function tuningKits(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_relations', 'product_id', 'related_id')->wherePivot('type', 'tuning_kit');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
