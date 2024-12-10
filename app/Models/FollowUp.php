<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_id',
        'date',
        'start_time',
        'end_time',
        'service_id',
        'description',
        'is_accepted'
    ];


    public function schedule()
    {
        return $this->belongsTo(ClientSchedules::class, 'record_id');
    }


    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }
}
