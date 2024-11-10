<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientSchedules;
use App\Models\Services;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalClients = User::role('Client')->count();
        $totalAppointments = ClientSchedules::count();
        $appointmentsToday = ClientSchedules::whereDate('created_at', today())->count();
        $unattendedAppointments = ClientSchedules::whereDate('created_at', today())
            ->where('status', 'Not Attended')
            ->count();
        $services = Services::all();
        return view('admin.dashboard.index', compact('services', 'totalClients', 'totalAppointments', 'appointmentsToday', 'unattendedAppointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
