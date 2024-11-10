<?php

namespace App\Http\Controllers;

use App\Models\ClientSchedules;
use App\Models\Services;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{


    public function show($id)
    {
        $service = Services::findOrFail($id);
        return response()->json($service);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'reserve_fee' => 'required|string|min:0',
            'price' => 'required|string|min:0',
            'classification' => 'required',
            'duration' => 'required|string|min:1',
            'availability' => 'required|string|in:available,not available',
        ]);

        Services::create($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Service added successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'serviceId' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'editReserveFee' => 'required|string|min:0',
            'price' => 'required|string|min:0',
            'classification' => 'required',
            'duration' => 'required|string',
            'availability' => 'required|string',
        ]);

        $service = Services::findOrfail($request->input('serviceId'));

        $service->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'reserve_fee' => $request->input('editReserveFee'),
            'price' => $request->input('price'),
            'classification' => $request->input('classification'),
            'duration' => $request->input('duration'),
            'availability' => $request->input('availability'),
        ]);
    }



    public function destroy($id)
    {
        $service = Services::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Service deleted successfully.');
    }


    public function fetch_service(Request $request)
    {
        $classification = $request->input('classification');

        if ($classification == '1') {
            $services = Services::all();
        } else {
            $services = Services::where('classification', $classification)->get();
        }

        return response()->json([
            'services' => $services,
        ]);
    }



    public function admin_walkin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'classification' => 'required|in:0,1',
            'service_id' => 'required|exists:services,id',
            'adminstartTimeData' => 'required',
            'adminendTimeData' => 'required',
            'clientEmail' => [
                'nullable',
                'email',
                'required_if:classification,1'
            ],
            'selectedSchedID' => 'required|exists:schedules,id',
        ], [
            'classification.required' => 'Please specify if the client is registered or unregistered.',
            'classification.in' => 'Invalid classification selection.',
            'service_id.required' => 'Services must be selected after classification is chosen.',
            'service_id.exists' => 'The selected service does not exist.',
            'adminstartTimeData.required' => 'Please enter a start time.',
            'adminendTimeData.required' => 'Please enter an end time.',
            'clientEmail.email' => 'Please enter a valid email address.',
            'clientEmail.required_if' => 'Email is required for unregistered clients.',
            'selectedSchedID.required' => 'Please select a schedule ID.',
            'selectedSchedID.exists' => 'The selected schedule ID is invalid.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation errors occurred',
            ], 422);
        }

        $userId = null;
        if ($request->classification == 0 && $request->clientEmail) {
            $user = User::where('email', $request->clientEmail)->first();
            if ($user) {
                $userId = $user->id;
            } else {
                return response()->json([
                    'message' => 'No user found with the provided email for a registered client.'
                ], 422);
            }
        }

        ClientSchedules::create([
            'user_id' => $userId,
            'service_id' => $request->service_id,
            'schedule_id' => $request->selectedSchedID,
            'start_time' => $request->adminstartTimeData,
            'end_time' => $request->adminendTimeData,
            'walk_in' => 1,
            'walk_in_name' => $request->clientName
        ]);

        return response()->json([
            'message' => 'Client schedule created successfully.'
        ], 200);
    }
}
