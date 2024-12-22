<?php

namespace App\Models\Blog;

use App\Enums\PostStatus;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;

class Post extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\Blog\PostFactory> */
    use HasFactory;
    use HasTags;
    use InteractsWithMedia;
    use SoftDeletes;

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

    /** @return MorphMany<Comment> */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Determine if the post is published.
     */
    public function isPublished(): bool
    {
        return $this->status === PostStatus::Published && $this->published_at->isPast();
    }

    /**
     * Published query scope.
     */
    public function scopePublished(Builder $query): void
    {
        $query
            ->where('status', PostStatus::Published)
            ->whereDate('published_at', '<=', Carbon::now());
    }

    /**
     * Get the post's published date in readable form.
     */
    public function getPublishedDate(): string
    {
        return $this->published_at->format('F jS, Y');
    }

    /**
     * Return the first words of the post's content.
     */
    public function getShortContent(int $words = 30): string
    {
        return Str::words(strip_tags($this->content), $words);
    }

    /**
     * Return the post's image object.
     */
    public function getImage(): ?Media
    {
        return $this->getFirstMedia('post-images');
    }

    /**
     * Return the post's image URL.
     */
    public function getImageUrl(string $conversionName = ''): string
    {
        return $this->getFirstMediaUrl('post-images', $conversionName);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('post-images')
            ->singleFile()
            ->withResponsiveImages();
    }
}
