<?php

namespace App\Http\Controllers;

use App\Models\ClientSchedules;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function getRevenueData()
    {

        $schedules = ClientSchedules::join('services', 'client_schedules.service_id', '=', 'services.id')
            ->selectRaw('MONTH(client_schedules.created_at) as month, SUM(services.price) as total')
            ->where('client_schedules.status', 'Success')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $revenue = [];

        foreach (range(1, 12) as $month) {
            $labels[] = Carbon::create()->month($month)->format('F');
            $revenue[] = $schedules->firstWhere('month', $month)->total ?? 0;
        }

        return response()->json([
            'labels' => $labels,
            'revenue' => $revenue,
        ]);
    }


    public function getVisitorsInsightData()
    {
        $data = DB::table('client_schedules')
            ->selectRaw('MONTH(created_at) as month,
                    SUM(CASE WHEN is_guest = 1 THEN 1 ELSE 0 END) as guests,
                    SUM(CASE WHEN is_guest = 0 THEN 1 ELSE 0 END) as registered_clients')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $guests = [];
        $registeredClients = [];

        foreach (range(1, 12) as $month) {
            $labels[] = Carbon::create()->month($month)->format('F');

            $monthData = $data->firstWhere('month', $month);
            $guests[] = $monthData->guests ?? 0;
            $registeredClients[] = $monthData->registered_clients ?? 0;
        }

        return response()->json([
            'labels' => $labels,
            'guests' => $guests,
            'registered_clients' => $registeredClients,
        ]);
    }
}
