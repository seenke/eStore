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
        "picture",
        "name",
        "description",
    ];

    public function orders ()
    {
        return $this->belongsToMany('App\Models\Order');
    }

}
