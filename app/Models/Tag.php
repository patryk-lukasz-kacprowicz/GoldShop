<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** @var array  */
    protected $fillable = [
        'is_active', 'name'
    ];

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class, 'product_tags');
    }
}
