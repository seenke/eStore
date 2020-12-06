<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Adress extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "address";
    protected $fillable = [
      "street",
      "street_number"
    ];

    public function user () {
        return $this -> belongsTo('App\Models\User');
    }

    public function postOffice () {
        return $this -> belongsTo('\App\Models\PostOffice');
    }





}
