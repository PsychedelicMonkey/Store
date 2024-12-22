<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Blog\Author;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements FilamentUser, HasAvatar, HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens;
    use HasFactory;
    use InteractsWithMedia;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** @return HasOne<Author> */
    public function author(): HasOne
    {
        return $this->hasOne(Author::class);
    }

    /**
     * Return the user's avatar object.
     */
    public function getAvatar(): ?Media
    {
        return $this->getFirstMedia('user-avatars');
    }

    /**
     * Return the user's avatar URL.
     */
    public function getAvatarUrl(string $conversionName = ''): ?string
    {
        return $this->getFirstMediaUrl('user-avatars', $conversionName);
    }

    /**
     * Determine if the user has permission to access Filament.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * Display the user's avatar in Filament.
     */
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->getAvatarUrl('icon');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('user-avatars')
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
