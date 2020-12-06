<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostOffice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "post_office";
    protected $fillable = [
        "postal_code",
        "post_office"
    ];

    public function addresses () {
        return $this->hasMany('App\Models\Adress');
    }
}
