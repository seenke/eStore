<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserAccount extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "name",
        "lastname",
        "email",
        "password"
    ];

    protected $table = "user_account";


    public function user ()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
}
