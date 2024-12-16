<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderAddress extends Model
{
    /** @use HasFactory<\Database\Factories\Shop\OrderAddressFactory> */
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'shop_order_addresses';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'addressable_type',
        'addressable_id',
        'country',
        'street',
        'city',
        'state',
        'zip',
    ];

    /** @return MorphTo<Model, self> */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
