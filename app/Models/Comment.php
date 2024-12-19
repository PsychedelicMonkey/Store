<?php

namespace App\Models;

use App\Models\Shop\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'comments';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'customer_id',
        'commentable_type',
        'commentable_id',
        'title',
        'content',
        'is_visible',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
        ];
    }

    /** @return MorphTo<Model, self>> */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /** @return BelongsTo<Customer, self> */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
