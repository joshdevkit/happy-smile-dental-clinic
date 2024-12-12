<?php

namespace App\Http\Controllers;

use App\Models\ClientSchedules;
use App\Models\FollowUp;
use App\Models\User;
use App\Notifications\FollowUpResponseNotification;
use App\Notifications\FollowUpScheduleNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowUpController extends Controller
{

    public function store(Request $request)
    {
        $record = ClientSchedules::find($request->input('record_id'));

        if (!$record) {
            return redirect()->back()->with('error', 'Client schedule not found.');
        }

        $validatedData = $request->validate([
            'record_id' => 'required|integer|exists:client_schedules,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'service_id' => 'required|integer|exists:services,id',
            'description' => 'required|string|max:255',
        ]);
        $user = User::find($record->user_id);

        if ($user) {
            Notification::send($user, new FollowUpScheduleNotification([
                'title' => 'Follow Up Request',
                'message' =>
                date('F d, Y', strtotime($validatedData['date'])) . ' -
                ' . date('h:i A', strtotime($validatedData['start_time'])) . ' to
                ' . date('h:i A', strtotime($validatedData['end_time'])) . '
                ',
            ]));
        }

        // Store the follow-up
        FollowUp::create($validatedData);

        return redirect()->back()->with('success', 'Follow-up schedule sent to the Client.');
    }


    public function user()
    {
        $data = FollowUp::with('schedule.service')
            ->get();

        $dataWithFollowups = $data->filter(function ($record) {
            return $record->followup && $record->followup->service;
        });

        if ($dataWithFollowups->isNotEmpty()) {
            foreach ($dataWithFollowups as $record) {
                $followUpCreatedAt = Carbon::parse($record->followup->created_at);
                $currentTime = Carbon::now();

                if ($followUpCreatedAt->diffInMinutes($currentTime) > 60) {
                    $record->followup->delete();
                }
            }
        }

        // $data = [];

        return view('client.appointments.follow-up', compact('data'));
    }




    public function accept(Request $request)
    {
        $followUp = FollowUp::findOrFail($request->input('id'));
        $followUp->update(['is_accepted' => 1]);
        $admins = User::role('Admin')->get();
        Notification::send($admins, new FollowUpResponseNotification([
            'title' => 'Followup Request Accepted',
            'message' =>  'The follow-up request for record ID ' . $followUp->id . ' has been accepted.'
        ]));
    }

    public function reject(Request $request)
    {
        $followUp = FollowUp::findOrFail($request->input('id'));
        $followUp->update(['is_accepted' => 2]);
        $admins = User::role('Admin')->get();
        Notification::send($admins, new FollowUpResponseNotification([
            'title' => 'Followup Request Decline',
            'message' => 'The follow-up request for record ID ' . $followUp->id . ' has been rejected.'
        ]));
    }
}
