<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSchedules extends Model
{
    use HasFactory;

    protected $fillable  = [
        'user_id',
        'service_id',
        'schedule_id',
        'start_time',
        'end_time',
        'walk_in',
        'walk_in_name'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }


    public function schedule()
    {
        return $this->belongsTo(Schedules::class, 'schedule_id');
    }


    public function patient()
    {
        return $this->belongsTo(User::class);
    }
}
