<?php

namespace App\Models\Shop;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\Shop\ProductFactory> */
    use HasFactory;
    use InteractsWithMedia;

    /**
     * @var string
     */
    protected $table = 'shop_products';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'shop_brand_id',
        'name',
        'slug',
        'sku',
        'barcode',
        'description',
        'qty',
        'security_stock',
        'featured',
        'is_visible',
        'old_price',
        'price',
        'cost',
        'type',
        'backorder',
        'requires_shipping',
        'published_at',
        'weight_value',
        'weight_unit',
        'height_value',
        'height_unit',
        'width_value',
        'width_unit',
        'depth_value',
        'depth_unit',
        'volume_value',
        'volume_unit',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'qty' => 'integer',
            'security_stock' => 'integer',
            'featured' => 'boolean',
            'is_visible' => 'boolean',
            'old_price' => 'decimal:2',
            'price' => 'decimal:2',
            'cost' => 'decimal:2',
            'backorder' => 'boolean',
            'requires_shipping' => 'boolean',
            'published_at' => 'date',
            'weight_value' => 'decimal:2',
            'height_value' => 'decimal:2',
            'width_value' => 'decimal:2',
            'depth_value' => 'decimal:2',
            'volume_value' => 'decimal:2',
        ];
    }

    /** @return BelongsTo<Brand, self> */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'shop_brand_id');
    }

    /** @return BelongsToMany<Category> */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'shop_category_product', 'shop_product_id', 'shop_category_id');
    }

    /** @return MorphMany<Comment> */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product-images');
    }
}
