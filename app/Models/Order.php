<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'shop_orders';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'shop_customer_id',
        'number',
        'total_price',
        'status',
        'currency',
        'shipping_price',
        'shipping_method',
        'notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
            'status' => OrderStatus::class,
            'shipping_price' => 'decimal:2',
        ];
    }

    /** @return MorphOne<OrderAddress> */
    public function address(): MorphOne
    {
        return $this->morphOne(OrderAddress::class, 'addressable');
    }

    /** @return BelongsTo<Customer, self> */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'shop_customer_id');
    }

    /** @return HasMany<OrderItem> */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'shop_order_id');
    }
}