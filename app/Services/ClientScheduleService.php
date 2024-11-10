<?php

namespace App\Services;

use App\Models\ClientSchedules;
use Carbon\Carbon;

class ClientScheduleService
{
    /**
     * Fetch schedule details for a specific schedule ID
     *
     * @param int $SchedId
     * @return array|null
     */
    public function getScheduleDetails($SchedId)
    {
        $data = ClientSchedules::with(['schedule', 'service', 'user'])->find($SchedId);

        $currentUserId = auth()->id();
        $fullName = ($data->user_id == $currentUserId)
            ? trim("{$data->user->first_name} {$data->user->middle_name} {$data->user->last_name}")
            : "Unknown";

        return [
            'id' => $data->id,
            'user_id' => $data->user_id,
            'service_id' => $data->service_id,
            'schedule_id' => $data->schedule_id,
            'start_time' => $data->start_time,
            'end_time' => $data->end_time,
            'created_at' => $data->created_at,
            'schedule' => [
                'id' => $data->schedule->id,
                'date_added' => Carbon::parse($data->schedule->date_added)->format('M/d/Y'),
                'start_time' => date('h:i A', strtotime($data->schedule->start_time)),
                'end_time' => date('h:i A', strtotime($data->schedule->end_time)),
            ],
            'service' => [
                'id' => $data->service->id,
                'name' => $data->service->name,
                'description' => $data->service->description,
                'price' => $data->service->price,
            ],
            'user' => [
                'full_name' => $fullName,
            ]
        ];
    }

    /**
     * Fetch schedule details for admin, considering walk-in clients
     *
     * @param int $SchedId
     * @return array|null
     */
    public function getAdminScheduleDetails($SchedId)
    {
        $data = ClientSchedules::with(['schedule', 'service', 'user'])->find($SchedId);

        $fullName = $data->user_id
            ? trim("{$data->user->first_name} {$data->user->middle_name} {$data->user->last_name}")
            : $data->walk_in_name;

        return [
            'id' => $data->id,
            'user_id' => $data->user_id,
            'service_id' => $data->service_id,
            'schedule_id' => $data->schedule_id,
            'start_time' => $data->start_time,
            'end_time' => $data->end_time,
            'created_at' => $data->created_at,
            'schedule' => [
                'id' => $data->schedule->id,
                'date_added' => Carbon::parse($data->schedule->date_added)->format('M/d/Y'),
                'start_time' => date('h:i A', strtotime($data->start_time)),
                'end_time' => date('h:i A', strtotime($data->end_time)),
            ],
            'service' => [
                'id' => $data->service->id,
                'name' => $data->service->name,
                'description' => $data->service->description,
                'price' => $data->service->price,
            ],
            'user' => [
                'full_name' => $fullName,
            ]
        ];
    }
}
