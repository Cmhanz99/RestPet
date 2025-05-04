<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'forms';

    public function booking(){
        return $this->belongsTo(Booking::class, 'form_id', 'id');
    }
}
