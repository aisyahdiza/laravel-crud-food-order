<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'total_price', 'status', 'table_number', 'note', 'completed_at',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function items(): HasMany {
        return $this->hasMany(OrderItem::class);
    }
    public function reviews(): HasMany {
        return $this->hasMany(Review::class);
    }
}
