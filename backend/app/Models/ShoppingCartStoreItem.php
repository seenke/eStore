<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ShoppingCartStoreItem extends Pivot
{
    protected $table = "shopping_cart_store_item";
    protected $fillable = [
        "quantity"
    ];

    public function shoppingCart () {
        return $this->belongsTo('\App\Models\ShoppingCart');
    }

    public function storeItem () {
        return $this->belongsTo('\App\Models\StoreItem');
    }

}
