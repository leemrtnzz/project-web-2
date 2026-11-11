<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'email', 'bio', 'photo_profile', 'password', 'role', 'is_banned', 'banned_at', 'ban_reason'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasUlids, Notifiable;

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
            'is_banned' => 'boolean',
            'banned_at' => 'datetime',
        ];
    }

    public function isMaster(): bool
    {
        return $this->role === 'master';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function isBanned(): bool
    {
        return (bool) $this->is_banned;
    }

    public function ban(?string $reason = null): void
    {
        $this->update([
            'is_banned' => true,
            'banned_at' => now(),
            'ban_reason' => $reason,
        ]);
    }

    public function unban(): void
    {
        $this->update([
            'is_banned' => false,
            'banned_at' => null,
            'ban_reason' => null,
        ]);
    }

    /**
     * @return HasMany<Category, $this>
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * @return HasMany<AffiliateProduct, $this>
     */
    public function affiliateProducts(): HasMany
    {
        return $this->hasMany(AffiliateProduct::class);
    }
}
