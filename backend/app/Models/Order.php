<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "order";
    public function storeItems ()
    {
        return $this->belongsToMany('App\Models\StoreItem')
            ->using('\App\Models\OrderStoreItem')
            ->withPivot(['quantity', 'primary_price']);
    }

    public function status ()
    {
        return $this->belongsTo('App\Models\Status');
    }

    public function user ()
    {
        return $this->belongsTo('App\Models\User');
    }


}
