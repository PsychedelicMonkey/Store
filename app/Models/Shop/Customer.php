<?php

namespace App\Models\Shop;

use App\Models\Address;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\Shop\CustomerFactory> */
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'shop_customers';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'gender',
        'phone',
        'birthday',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'birthday' => 'date',
        ];
    }

    /** @return MorphToMany<Address> */
    public function addresses(): MorphToMany
    {
        return $this->morphToMany(Address::class, 'addressable', 'addressables');
    }

    /** @return HasMany<Comment> */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /** @return HasMany<Order> */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'shop_customer_id');
    }

    /** @return HasManyThrough<Payment> */
    public function payments(): HasManyThrough
    {
        return $this->hasManyThrough(Payment::class, Order::class, 'shop_customer_id');
    }

    /** @return BelongsTo<User, self> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
