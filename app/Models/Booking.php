<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    public function pet(){
        return $this->hasMany(Pet::class, 'booking_id', 'id');
    }
}
