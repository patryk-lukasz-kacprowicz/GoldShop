<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    /** @var array  */
    protected $fillable = [
        'patron_id', 'category_id', 'stock_id', 'type',
        'is_active', 'is_in_stock', 'is_trend',
        'has_max_cart', 'min_cart', 'max_cart', 'has_stock_alert', 'min_stock', 'max_stock', 'has_unlimited_stock',
        'name', 'slug', 'sku', 'barcode', 'price', 'vat', 'discount',
        'image', 'description', 'details',
    ];

    /** @var array  */
    protected $casts = [
        'gallery' => 'array',
        'is_active' => 'boolean',
        'is_shipped' => 'boolean',
        'is_in_stock' => 'boolean',
        'is_trend' => 'boolean',
        'price' => 'float',
        'vat' => 'float',
        'discount' => 'float',
    ];

    /**
     * @return BelongsTo
     */
    public function patron(): BelongsTo {
        return $this->belongsTo(User::class, 'patron_id');
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * @return BelongsTo
     */
    public function stock(): BelongsTo {
        return $this->belongsTo(Stock::class, 'stock_id');
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }
}
