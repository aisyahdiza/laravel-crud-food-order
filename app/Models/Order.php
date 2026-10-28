<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
    public function review(): HasOne {
        return $this->hasOne(Review::class);
    }
    
    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_READY = 'ready';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_PROCESSING => 'Processing',
        self::STATUS_READY => 'Ready to Serve',
        self::STATUS_COMPLETED => 'Completed',
        self::STATUS_CANCELLED => 'Cancelled',
    ];

    public const NEXT_STATUS = [
        self::STATUS_PENDING => self::STATUS_PROCESSING,
        self::STATUS_PROCESSING => self::STATUS_READY,
        self::STATUS_READY => self::STATUS_COMPLETED,
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    public function getNextStatusAttribute(): ?string
    {
        return self::NEXT_STATUS[$this->status] ?? null;
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_PROCESSING]);
    }
}
