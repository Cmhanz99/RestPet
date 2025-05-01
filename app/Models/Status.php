<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';

    public function lotsActive(){
        return $this->belongsTo(Lots::class, 'lots_id', 'id');
    }
}
