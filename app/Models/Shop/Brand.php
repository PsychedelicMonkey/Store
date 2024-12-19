<?php

namespace App\Models\Shop;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Brand extends Model
{
    /** @use HasFactory<\Database\Factories\Shop\BrandFactory> */
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'shop_brands';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'website',
        'description',
        'position',
        'is_visible',
        'sort',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'position' => 'integer',
            'is_visible' => 'boolean',
            'sort' => 'integer',
        ];
    }

    /** @return MorphToMany<Address> */
    public function addresses(): MorphToMany
    {
        return $this->morphToMany(Address::class, 'addressable', 'addressables');
    }

    /** @return HasMany<Product> */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'shop_brand_id');
    }
}
