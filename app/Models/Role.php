<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Role extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = "role";
    protected $fillable = [
        "role"
    ];
    public function usersAccounts()
    {
        return $this->hasMany('App\Models\UserAccount');
    }
}
