<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    public $table = 'replies';

    protected $fillable = ['name', 'reply'];
}
