<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class UserAccount extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "name",
        "lastname",
        "email",
        "password",
        "api_token"
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
