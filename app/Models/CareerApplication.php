<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'career_id',
        'name',
        'phone',
        'email',
        'position',
        'address',
        'cv_path',
    ];

    public function career()
    {
        return $this->belongsTo(Career::class);
    }
}

