<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $table = "rating";
    protected $fillable = [
        "rating"
    ];
    public function user () {
        return $this->belongsTo('App\Models\User');
    }

    public function storeItem() {
        return $this->belongsTo('App\Models\StoreItem');
    }
}
