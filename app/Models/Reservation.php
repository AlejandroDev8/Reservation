<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'distribution_id',
        'start_date',
        'end_date',
        'status',
        'notes',
        'answer',
    ];
}
