<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Corporation extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($corporation) {
            $corporation->slug = Str::slug($corporation->name);
        });
    }

    protected $fillable = [
        'name',
        'capital',
    ];

    protected $casts = [
        'capital' => 'float',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function stock(): HasOne
    {
        return $this->hasOne(Stock::class);
    }
}
