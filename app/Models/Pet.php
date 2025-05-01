<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $table = 'pets';

    public function bookings(){
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }
    public function lots(){
        return $this->belongsTo(Lots::class, 'lots_id', 'id');
    }

    public function payment(){
        return $this->hasMany(Payment::class, 'pet_id', 'id');
    }
}
