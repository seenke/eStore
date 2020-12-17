<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory, Notifiable;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     *
     *
     */
    use SoftDeletes;

    protected $table = "user";
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function userAccount()
    {
        return $this->hasOne('App\Models\UserAccount');
    }

    public function address()
    {
        return $this->hasOne('App\Models\Adress');
    }

    public function orders ()
    {
        return $this -> hasMany('\App\Models\Order');
    }

    public function shoppingCart()
    {
        return $this -> hasOne('\App\Models\ShoppingCart');
    }

    public function ratings()
    {
        return $this->hasMany('\App\Models\Rating');
    }








}
