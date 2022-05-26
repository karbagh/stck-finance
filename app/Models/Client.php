<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
    ];

    protected $casts = [
        'budget' => 'float'
    ];

    public function getFullNameAttribute(): string
    {
        return "$this->first_name $this->last_name";
    }

    public function getTotalRangeAttribute(): float
    {
        return ((float) $this->stocks()
                ->sum(
                    DB::raw('price * volume')) - (float) $this->stocks()
                                                                    ->sum(DB::raw('bought_price * volume')));
    }

    public function entrepreneur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function stocks(): BelongsToMany
    {
        return $this->belongsToMany(Stock::class, 'clients_stocks', 'client_id')
            ->withPivot(['volume', 'bought_price', 'id']);
    }
}
