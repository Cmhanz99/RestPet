<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lots extends Model
{
    protected $table = 'lots';

    protected $fillable =
     [
        'title', 'image',
        'type', 'size',
        'area', 'marker',
        'slots', 'price',
        'description', 'owner_id'
    ];

    public function owner(){
        return $this->belongsTo(Owner::class, 'owner_id', 'id');
    }
    public function pets(){
        return $this->hasMany(Pet::class, 'lots_id', 'id');
    }
    public function status(){
        return $this->hasMany(Status::class, 'lots_id', 'id');
    }
}
