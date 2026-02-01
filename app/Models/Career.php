<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'position', 'number', 'expiration_date', 'description', 'is_open',
    ];

    protected $casts = [
        'number' => 'integer',
        'expiration_date' => 'date',
        'is_open' => 'boolean',
    ];

    public function scopeOpen($q)    { return $q->where('is_open', true); }
    public function scopeActive($q)  { return $q->whereDate('expiration_date', '>=', now()->toDateString()); }
    public function scopeSearch($q, ?string $kw) {
        if (!$kw) return $q;
        $kw = trim($kw);
        return $q->where(function($qq) use ($kw) {
            $qq->where('position', 'like', "%{$kw}%")
               ->orWhere('description', 'like', "%{$kw}%");
        });
    }
}
