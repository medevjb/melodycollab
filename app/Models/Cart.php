<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];


    /**
     * Get CartItems that owns the Cart
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class)->with('pack');
    }
}
