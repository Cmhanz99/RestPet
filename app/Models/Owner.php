<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $table = 'owners';

    protected $fillable = ['name', 'email', 'password', 'profile','phone'];

    public function lots(){
        return $this->hasMany(Lots::class, 'owner_id', 'id');
    }
}
