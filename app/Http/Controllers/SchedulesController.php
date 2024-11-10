<?php

namespace App\Http\Controllers;

use App\Models\ClientSchedules;
use App\Models\Schedules;
use App\Models\Services;
use App\Services\ScheduleService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SchedulesController extends Controller
{
    protected $scheduleService;

    // Inject the ScheduleService via constructor
    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Schedules::with(['record.user', 'record.service'])
            ->whereHas('record', function ($query) {
                $query->where('status', 'Pending');
            })
            ->get();

        return view('admin.schedules.index', compact('records'));
    }


    /**
     * Display all the schedule into a json format (javascript object notation method ito)
     */
    public function fetchSchedules()
    {
        $events = $this->scheduleService->schedules();

        return response()->json($events);
    }


    public function getScheduleData(Request $request)
    {
        $scheduleId = $request->query('id');
        $schedule = Schedules::find($scheduleId);

        if ($schedule) {
            return response()->json([
                'id' => $schedule->id,
                'date_added' => date('M, d Y', strtotime($schedule->date_added)),
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
            ]);
        }
    }


    public function getServiceData(Request $request)
    {
        $sercviceId = $request->query('id');
        $serviceData = Services::find($sercviceId);
        return response()->json($serviceData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        Schedules::create([
            'date_added' => $validatedData['date'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
        ]);

        return redirect()->back()->with('success', 'Schedule created successfully!');
    }


    public function today()
    {
        $today = $this->scheduleService->getTodaySchedules();

        return view('admin.schedules.today-appointment', compact('today'));
    }




    public function unattended()
    {
        $unattended = ClientSchedules::with(['user', 'service', 'schedule'])->where('status', 'Not Attended')->get();
        return view('admin.schedules.unattended-appointment', compact('unattended'));
    }


    public function history()
    {
        $history = ClientSchedules::with(['user', 'service', 'schedule'])->get();
        return view('admin.schedules.history', compact('history'));
    }


    public function date_validation($date)
    {
        $exists = Schedules::where('date_added', $date)->exists();

        if ($exists) {
            return response()->json(['status' => 'exists', 'message' => 'The date already exists.']);
        } else {
            return response()->json(['status' => 'not_exists', 'message' => 'The date is available.']);
        }
    }


    public function resched(Request $request)
    {
        $schedID = $request->query('schedID');
        $schedules = ClientSchedules::find($schedID);

        if ($schedules) {
            $data = Schedules::find($schedules->schedule_id);
        }
    }


    public function check_dates(Request $request)
    {
        $date = $request->query('date');
        $data = Schedules::where('date_added', $date)->get();

        return response()->json([
            'data' => $data
        ]);
    }


    public function user_reschedule(Request $request)
    {

        $data = ClientSchedules::find($request->schedule_id);

        if (!$data) {
            return redirect()->back()->with('error', 'Schedule not found.');
        }

        if ($data->user_id == Auth::id()) {
            $validatedData = $request->validate([
                'new_date_id' => 'required|exists:schedules,id',
            ]);

            $newSchedule = Schedules::find($request->new_date_id);

            if (!$newSchedule) {
                return redirect()->back()->with('error', 'The new schedule ID does not exist.');
            }

            $data->schedule_id = $validatedData['new_date_id'];
            $data->start_time = $request->startTimeData;
            $data->end_time = $request->endTimeData;
            $data->save();

            return redirect()->back()->with('success', 'Schedule updated successfully.');
        } else {
            return redirect()->back()->with('error', 'You are not able to change the date of the appointment that does not belong to you.');
        }
    }


    public function markNotAttended(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:client_schedules,id',
        ]);

        $appointment = ClientSchedules::findOrFail($validated['schedule_id']);
        $appointment->status = "Not Attended";
        $appointment->save();

        return response()->json([
            'success' => true,
            'message' => 'Appointment status updated successfully.',
        ]);
    }
}
