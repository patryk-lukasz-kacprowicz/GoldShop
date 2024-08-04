<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    /** @var array  */
    protected $fillable = [
        'parent_id', 'title', 'slug'
    ];

    public function subCategory(): HasMany {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parentCategory(): BelongsTo {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class, 'product_categories');
    }
}
