<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $appends = ['cover_image_src'];

    protected $fillable = [
        'title','slug','excerpt','body','cover_image_url','status','published_at','author_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Chuyển đổi path thành full URL
     */
    private function buildFullUrl(?string $path): ?string
    {
        if (!$path) return null;

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        $base = rtrim(config('app.url'), '/');

        if (Str::startsWith($path, '/storage/')) {
            return $base . $path;
        }

        return $base . '/storage/' . ltrim($path, '/');
    }

    /**
     * Luôn lưu relative path vào DB (news/xxx.webp)
     */
    public function setCoverImageUrlAttribute($value): void
    {
        if (!$value) {
            $this->attributes['cover_image_url'] = null;
            return;
        }
        if (Str::startsWith($value, ['http://', 'https://'])) {
            $parsed = parse_url($value);
            $value = $parsed['path'] ?? $value;
        }
        if (Str::startsWith($value, '/storage/')) {
            $value = ltrim(Str::after($value, '/storage/'), '/');
        }
        $this->attributes['cover_image_url'] = $value;
    }

    /**
     * Trả về full URL cho API
     */
    public function getCoverImageUrlAttribute($value): ?string
    {
        return $this->buildFullUrl($value);
    }

    /**
     * Alias cho cover_image_url
     */
    public function getCoverImageSrcAttribute(): ?string
    {
        return $this->cover_image_url;
    }
}
