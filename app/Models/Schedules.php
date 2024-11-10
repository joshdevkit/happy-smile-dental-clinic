<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{
    use HasFactory;


    protected $fillable = [
        'date_added',
        'start_time',
        'end_time'
    ];


    public function record()
    {
        return $this->hasMany(ClientSchedules::class, 'schedule_id', 'id');
    }
}
