<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $product_id
 * @property int $brand_id
 * @property string $model_name
 * @property float $price
 * @property int $stock
 * @property int|null $release_year
 */
class Product extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'product_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'brand_id',
        'model_name',
        'price',
        'image',
        'stock',
        'release_year',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'release_year' => 'integer',
    ];

    protected $attributes = [
        'stock' => 0,
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'brand_id');
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 2, ',', '.');
    }

    public function isAvailable(): bool
    {
        return $this->stock > 0;
    }
}
