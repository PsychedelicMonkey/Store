<?php

namespace App\Models\Blog;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;

class Post extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\Blog\PostFactory> */
    use HasFactory, HasTags, InteractsWithMedia, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'blog_posts';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'blog_author_id',
        'blog_category_id',
        'title',
        'slug',
        'content',
        'published_at',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'status' => PostStatus::class,
        ];
    }

    /** @return BelongsTo<Author, self> */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'blog_author_id');
    }

    /** @return BelongsTo<Category, self> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'blog_category_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('post-images')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('icon')
            ->fit(Fit::Crop, 80, 80)
            ->sharpen(10)
            ->nonQueued();
    }
}
