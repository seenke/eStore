<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Status extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "status"
    ];
    protected $table = "status";
    public function orders () {
        return $this->hasMany('App\Models\Order');
    }
    use HasFactory;
}
