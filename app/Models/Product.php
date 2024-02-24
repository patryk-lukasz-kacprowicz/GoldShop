<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** @var array  */
    protected $fillable = [
        'created_by', 'assigned_to', 'is_visible', 'is_available', 'thumbnail', 'amount', 'title', 'price', 'description',
    ];

    public function getVisibleAttribute(): bool {
        return $this->is_visible ?? false;
    }

    public function getAvailableAttribute(): bool {
        return $this->is_available ?? false;
    }

    public function createdBy(): BelongsTo {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignedTo(): BelongsTo {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
