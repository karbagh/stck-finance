<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    public function corporation(): BelongsTo
    {
        return $this->belongsTo(Corporation::class);
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'clients_stocks', 'stock_id')->withPivot(['volume', 'bought_price']);
    }
}
