<?php

namespace App\Http\Controllers;

use App\Models\ClientSchedules;
use App\Models\Schedules;
use App\Models\Services;
use App\Services\ClientScheduleService;
use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\isEmpty;

class GuestController extends Controller
{
    protected $scheduleService;
    protected $clientScheduleService;


    public function __construct(ScheduleService $scheduleService, ClientScheduleService $clientScheduleService)
    {
        $this->scheduleService = $scheduleService;
        $this->clientScheduleService = $clientScheduleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('guest.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'GuestemailAddress' => 'required|email',
        ]);

        $otp = random_int(100000, 999999);

        Session::put('otp', $otp);
        Session::put('otp_email', $request->GuestemailAddress);

        Mail::raw("Your OTP is: $otp", function ($message) use ($request) {
            $message->to($request->GuestemailAddress)
                ->subject('Your OTP Verification Code');
        });

        return redirect()->route('verification');
    }


    public function verification()
    {
        return view('guest.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string',
        ]);
        $storedOtp = Session::get('otp');
        if ($storedOtp && $storedOtp == $request->otp) {
            Session::forget('otp');
            return redirect()->route('guest.homepage');
        }

        return redirect()->back()->with('message', 'Invalid OTP, please double check the otp we have sent to your email.');
    }

    public function homepage()
    {
        if (Session::has('otp_email') && !empty(Session::get('otp_email'))) {
            return view('guest.homepage');
        } else {
            return redirect('/');
        }
    }


    public function current_sched()
    {
        $events = $this->scheduleService->schedules();

        return response()->json($events);
    }


    public function current_users(Request $request)
    {
        $scheduleId = $request->input('id');
        $schedules = ClientSchedules::with('user')->where('schedule_id', $scheduleId);

        return response()->json($schedules->get());
    }

    public function guest_fetch($SchedId)
    {
        $formattedData = $this->clientScheduleService->getAdminScheduleDetails($SchedId);

        if ($formattedData) {
            return response()->json($formattedData);
        }

        return response()->json(['error' => 'Schedule not found'], 404);
    }


    public function appointment($id)
    {
        $services = Services::where('for_guest', 1)->get();
        return view('guest.make-appointment', compact('services'));
    }


    public function sched(Request $request)
    {
        $schedId = $request->query('id');

        $schedulDetails = Schedules::find($schedId);

        return response()->json($schedulDetails);
    }


    public function appointment_store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|integer|exists:services,id',
            'sched_id' => 'required|integer|exists:schedules,id',
            'start_time' => 'required',
            'end_time' => 'required',
            'firstname' => 'required',
            'middlename' => 'nullable|string',
            'lastname' => 'required',
            'contact' => 'required',
        ]);

        $existingSchedule = ClientSchedules::where('schedule_id', $validated['sched_id'])
            ->where(function ($query) use ($validated) {
                $query->where(function ($query) use ($validated) {
                    $query->where('start_time', '=', $validated['start_time'])
                        ->where('end_time', '=', $validated['start_time']);
                });
            })
            ->exists();

        if ($existingSchedule) {
            return back()->withErrors(['error' => 'The selected time overlaps with an existing schedule.']);
        }



        $guest = ClientSchedules::create([
            'service_id' => $validated['service_id'],
            'schedule_id' => $validated['sched_id'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_guest' => 1,
            'guest_name' => trim($validated['firstname'] . ' ' . $validated['middlename'] . ' ' . $validated['lastname']),
            'guest_contact' => $validated['contact'],
            'guest_email' => Session::get('otp_email')
        ]);

        return redirect()->route('retrieve', ['id' => $guest->id])->with('success', 'Appointment has been sent');
    }


    public function retrieve($id)
    {
        $data = ClientSchedules::find($id);
        return view('guest.show', compact('data'));
    }


    public function searchAppointment(Request $request)
    {
        $trackingNumber = $request->get('tracking_number');

        if (empty($trackingNumber)) {
            return response()->json(['success' => false, 'message' => 'Tracking number is required']);
        }

        $appointmentId = str_replace('HSDC00', '', $trackingNumber);
        $appointment = ClientSchedules::find($appointmentId);

        if ($appointment) {
            $otpEmail = Session::get('otp_email');

            if ($otpEmail === $appointment->guest_email) {
                return response()->json([
                    'success' => true,
                    'appointment' => [
                        'guest_name' => $appointment->guest_name,
                        'status' => $appointment->status,
                        'start_time' => $appointment->start_time,
                        'end_time' => $appointment->end_time,
                    ],
                    'url' => route('retrieve', ['id' => $appointment->id])
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Email does not match the guest email']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Appointment not found']);
    }
}
