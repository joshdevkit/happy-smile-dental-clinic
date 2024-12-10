<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentScheduleData extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_schedule_id',
        'payment_method',
        'remarks',
        'payment_date'
    ];


    public function schedule()
    {
        return $this->belongsTo(ClientSchedules::class, 'client_schedule_id');
    }
}
