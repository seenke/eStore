<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin Builder
 */
class StoreItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "store_item";

    protected $fillable = [
        "price",
        "name",
        "description",
    ];

    public function orders ()
    {
        return $this->belongsToMany('App\Models\Order')
            ->using('\App\Models\OrderStoreItem')
            ->withPivot(['quantity', 'primary_price']);
    }

    public function pictures ()
    {
        return $this->hasMany('App\Models\Picture');
    }

    public function shopping_carts ()
    {
        return $this
            ->belongsToMany('App\Models\ShoppingCart')
            ->using('App\Models\ShoppingCartStoreItem');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }

}
