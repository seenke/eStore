<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;
    protected $table = "shopping_cart";
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function items() {
        return $this
            ->belongsToMany('\App\Models\StoreItem')
            ->using('\App\Models\ShoppingCartStoreItem')
            ->withPivot(['quantity']);
    }

}
