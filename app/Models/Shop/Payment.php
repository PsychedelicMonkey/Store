<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\Shop\PaymentFactory> */
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'shop_payments';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'order_id',
        'reference',
        'provider',
        'method',
        'amount',
        'currency',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    /** @return BelongsTo<Order, self> */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
