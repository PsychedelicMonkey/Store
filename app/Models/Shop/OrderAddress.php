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
        'id',
        'addressable_type',
        'addressable_id',
        'country',
        'street',
        'city',
        'state',
        'zip',
        'created_at',
        'updated_at',
    ];

    /** @return MorphTo<Model, self> */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
