<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends \TomatoPHP\FilamentLocations\Models\City
{
    /**
     * @return HasMany
     */
    public function stock(): HasMany {
        return $this->hasMany(Stock::class);
    }
}
