<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Pony;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculer le nombre de rendez-vous aujourd'hui
        $today = Carbon::today()->toDateString();
        $appointmentsTodayCount = Appointment::where('appointment_date', $today)->count();

        // Calculer le nombre de poneys
        $poniesCount = Pony::count();

        // Calculer le nombre de factures clôturées ce mois-ci
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $invoicesClosedCount = Invoice::where('status', 'payé')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        return view('dashboard', compact('appointmentsTodayCount', 'poniesCount', 'invoicesClosedCount'));    }
}
