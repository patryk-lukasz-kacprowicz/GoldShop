<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** @var array  */
    protected $fillable = [
        'active', 'country_id', 'city_id', 'manager_id', 'name',
    ];

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo {
        return $this->belongsTo(City::class);
    }

    /**
     * @return BelongsTo
     */
    public function manager(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function workers(): BelongsToMany {
        return $this->belongsToMany(User::class, 'stock_workers');
    }
}
