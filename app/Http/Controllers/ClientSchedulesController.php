<?php

namespace App\Http\Controllers;

use App\Models\ClientSchedules;
use App\Services\ClientScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClientSchedulesController extends Controller
{
    protected $clientScheduleService;

    public function __construct(ClientScheduleService $clientScheduleService)
    {
        $this->clientScheduleService = $clientScheduleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $scheduleId = $request->input('id');
        $schedules = ClientSchedules::with('user')->where('schedule_id', $scheduleId);

        return response()->json($schedules->get());
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'selectedSchedID' => 'required|exists:schedules,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        ClientSchedules::create([
            'user_id' => Auth::user()->id,
            'service_id' => $request->input('service_id'),
            'schedule_id' => $request->input('selectedSchedID'),
            'start_time' => $request->input('startTimeData'),
            'end_time' => $request->input('endTimeData'),
        ]);


        return redirect()->back()->with('success', 'Reservation Submitted Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($SchedId)
    {
        $formattedData = $this->clientScheduleService->getScheduleDetails($SchedId);

        if ($formattedData) {
            return response()->json($formattedData);
        }

        return response()->json(['error' => 'Schedule not found'], 404);
    }

    /**
     * Fetch schedule details for admin with walk-in handling
     *
     * @param int $SchedId
     * @return \Illuminate\Http\JsonResponse
     */
    public function admin_fetch($SchedId)
    {
        $formattedData = $this->clientScheduleService->getAdminScheduleDetails($SchedId);

        if ($formattedData) {
            return response()->json($formattedData);
        }

        return response()->json(['error' => 'Schedule not found'], 404);
    }

    public function appointments()
    {
        $userId = Auth::user()->id;

        $appointment = ClientSchedules::with('service')->where('user_id', $userId)->get();

        return view('client.appointments.index', compact('appointment'));
    }

    public function history()
    {
        $userId = Auth::user()->id;

        $appointment = ClientSchedules::with('service')->where('user_id', $userId)->get();

        return view('client.appointments.history', compact('appointment'));
    }
}
