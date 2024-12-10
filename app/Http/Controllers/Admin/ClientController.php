<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientSchedules;
use App\Models\PaymentScheduleData;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = User::role('Client')
            ->where('is_archived', 0)
            ->get();
        return view('admin.clients.index', compact('clients'));
    }


    public function archive_clients()
    {
        $clients = User::role('Client')
            ->where('is_archived', 1)
            ->get();
        return view('admin.clients.archived', compact('clients'));
    }


    public function show(string $id)
    {
        $client = User::find($id);
        $clientsRecord = ClientSchedules::with(['service', 'schedule', 'user'])->where('user_id', $id)->get();
        $totalRecord = ClientSchedules::where('user_id', $id)->count();
        return view('admin.clients.record', compact('clientsRecord', 'totalRecord', 'client'));
    }


    public function getTransaction($id)
    {
        $transaction = ClientSchedules::with(['service', 'schedule', 'user'])->find($id);
        if ($transaction) {
            return response()->json([
                'transaction_id' => 'INV-' . $transaction->id,
                'client_name' => $transaction->user->first_name . ' ' . $transaction->user->last_name,
                'service' => $transaction->service->name,
                'appointment_date' => date('F d, Y', strtotime($transaction->schedule->date_added)) . " " . date('h:i A', strtotime($transaction->start_time)) . ' - ' . date('h:i A', strtotime($transaction->end_time)),
                'clinic_name' => config('app.name'),
                'payment_method' => '',
                'amount' => $transaction->service->price,
                'status' => $transaction->status,
                'remarks' => 'Thanks'
            ]);
        }
    }


    public function info($id)
    {
        $data = User::find($id);
        return view('admin.clients.info', compact('data'));
    }


    public function archive(Request $request, $id)
    {
        $client = User::findOrFail($id);
        $client->is_archived = 1;
        $client->save();

        return response()->json(['success' => true]);
    }


    public function restore(Request $request, $id)
    {
        $client = User::findOrFail($id);
        $client->is_archived = 0;
        $client->save();

        return response()->json(['success' => true]);
    }


    public function user_data(Request $request)
    {
        $email = $request->query('email');

        $user = User::where('email', $email)->first();

        if ($user) {
            $user_fullname = $user->first_name . " " . $user->middle_name . " " . $user->last_name;
            return response()->json([
                'user_fullname' => $user_fullname
            ]);
        } else {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }


    public function paid(Request $request)
    {
        $validatedData = $request->validate([
            'transactionID' => 'required|exists:client_schedules,id',
            'payment' => 'required|string',
            'remarks' => 'nullable|string|max:255',
            'paymentDate' => 'required|date',
        ]);

        $record = ClientSchedules::findOrFail($validatedData['transactionID']);
        $record->update(['status' => 'Success']);

        PaymentScheduleData::create([
            'client_schedule_id' => $validatedData['transactionID'],
            'payment_method' => $validatedData['payment'],
            'remarks' => $validatedData['remarks'],
            'payment_date' => $validatedData['paymentDate'],
        ]);

        return redirect()->back()->with('success', 'Payment added successfully');
    }
}
