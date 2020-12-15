<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderStoreItem extends Pivot
{
    protected $table = "order_store_item";
    protected $fillable = [
        "quantity",
        "primary_price"
    ];

    public function order () {
        return $this->belongsTo('\App\Models\Order');
    }

    public function storeItem () {
        return $this->belongsTo('\App\Models\StoreItem');
    }
}
