<?php

namespace App\Services;

use App\Models\Schedules;
use Illuminate\Support\Facades\DB;

class ScheduleService
{
    /**
     * Get today's schedules, excluding 'Not Attended' status
     *
     * @return \Illuminate\Support\Collection
     */
    public function getTodaySchedules()
    {
        return DB::table('client_schedules')
            ->leftJoin('services', 'client_schedules.service_id', '=', 'services.id')
            ->leftJoin('schedules', 'client_schedules.schedule_id', '=', 'schedules.id')
            ->leftJoin('users', 'client_schedules.user_id', '=', 'users.id')
            ->leftJoin('payment_schedule_data as p', 'client_schedules.id', '=', 'p.client_schedule_id')
            ->select(
                'client_schedules.id as schedule_id',
                'client_schedules.created_at',
                'client_schedules.user_id',
                'client_schedules.is_guest',
                'client_schedules.guest_name',
                'client_schedules.walk_in_name',
                'services.name as service_name',
                'services.price as service_price',
                'schedules.date_added',
                'client_schedules.start_time',
                'client_schedules.end_time',
                'client_schedules.walk_in',
                'client_schedules.status',
                'p.client_schedule_id as client_sched_id',
                DB::raw("CONCAT(users.first_name, ' ', IFNULL(users.middle_name, ''), ' ', users.last_name, ' ', IFNULL(users.suffix, '')) as full_name")
            )
            ->whereDate('client_schedules.created_at', today())
            ->where('client_schedules.status', '!=', 'Not Attended')
            ->get();
    }


    public function schedules()
    {
        $schedules = Schedules::all();
        return  $schedules->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'title' => 'Schedule',
                'start' => $schedule->date_added . ' ' . $schedule->start_time,
                'end' => $schedule->date_added . ' ' . $schedule->end_time,
                'status' => $schedule->status,
                'headerTitle' => date('M/d/Y', strtotime($schedule->date_added)) . " " . date('h:i A', strtotime($schedule->start_time)) . " - " . date('h:i A', strtotime($schedule->end_time)),

                'date_dedicated' => date('M/d/Y', strtotime($schedule->date_added))
            ];
        });
    }
}
