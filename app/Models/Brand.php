<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $brand_id
 * @property string $brand_name
 */
class Brand extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'brand_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'brand_name',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id', 'brand_id');
    }

    public function scopeOrdered(Builder $query)
    {
        return $query->orderBy('brand_name');
    }

    public static function findOrCreateByName(string $name): self
    {
        return static::firstOrCreate(['brand_name' => $name]);
    }

    public function __toString(): string
    {
        return $this->brand_name;
    }
}
