<?php

namespace App\Http\Controllers;

use App\Events\InvoicesGenerated;
use App\Http\Requests\CreateInvoiceRequest;
use App\Models\Group;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('viewAny', Invoice::class);
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $currentMonthInvoices = Invoice::whereHas('group.appointments', function ($query) use ($currentMonth, $currentYear) {
            $query->whereMonth('appointment_date', $currentMonth)
                ->whereYear('appointment_date', $currentYear);
        })
            ->with('group.client')
            ->get();

        $allInvoices = Invoice::with(['group.appointments' => function ($query) {
            $query->orderBy('appointment_date', 'asc'); // Trier par date croissante
        }, 'group.client'])
            ->get()
            ->filter(function ($invoice) {
                return $invoice->group && $invoice->group->appointments->isNotEmpty();
            })
            ->sortBy(function ($invoice) {
                return Carbon::parse($invoice->group->appointments->first()->appointment_date)->format('Y-m');
            })
            ->groupBy(function ($invoice) {
                return Carbon::parse($invoice->group->appointments->first()->appointment_date)->format('Y-m');
            });

        $selectedMonth = $request->input('month');
        $selectedYear = $request->input('year');
        $selectedMonthInvoices = collect();

        if ($selectedMonth && $selectedYear) {
            $selectedMonthInvoices = Invoice::whereHas('group.appointments', function ($query) use ($selectedMonth, $selectedYear) {
                $query->whereMonth('appointment_date', $selectedMonth)
                    ->whereYear('appointment_date', $selectedYear);
            })
                ->with('group.client')
                ->get();
        }

        return view('invoices.index', compact('currentMonthInvoices', 'allInvoices', 'selectedMonthInvoices', 'selectedMonth', 'selectedYear'));
    }


    public function create(Request $request)
    {
        $this->authorize('create', Invoice::class);
        $groups = Group::with('client', 'appointments')->get();
        $selectedGroup = null;
        $appointments = collect(); // Initialise $appointments avec une collection vide
        $selectedAppointment = null;
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        if ($request->has('group_id')) {
            $selectedGroup = Group::with('client', 'appointments')->find($request->group_id);
            $appointments = $selectedGroup->appointments;
            if ($appointments->isNotEmpty()) {
                $selectedAppointment = $appointments->first(); // Par défaut, le premier rendez-vous
                if ($request->has('appointment_id')) {
                    $selectedAppointment = $appointments->find($request->appointment_id);
                }
                if ($selectedAppointment) {
                    $currentMonth = Carbon::parse($selectedAppointment->appointment_date)->month;
                    $currentYear = Carbon::parse($selectedAppointment->appointment_date)->year;
                }
            }
        }

        return view('invoices.create', compact('groups', 'selectedGroup', 'appointments', 'selectedAppointment', 'currentMonth', 'currentYear'));
    }


    public function store(CreateInvoiceRequest $request)
    {

        $this->authorize('create', Invoice::class);
        $prixUnitaireTVAC = $request->input('prix_unitaire_tvac') ?: null;

        $group = Group::find($request->group_id);
        $totalAmount = $group->calculateTotalAmount($request->month, $request->year, $prixUnitaireTVAC);
        $reference = Str::uuid(); // Générer une référence unique

        Invoice::create([
            'month' => $request->month,
            'year' => $request->year,
            'total_amount' => $totalAmount,
            'group_id' => $request->group_id,
            'prix_unitaire_tvac' => $prixUnitaireTVAC ?: 30.00, // Stocker le prix unitaire TVAC
            'status' => $request->status,
            'reference' => $reference,
        ]);

        return redirect()->route('invoices.index')->with('success', 'Facture créée avec succès.');
    }

    public function show($id)
    {
        $invoice = Invoice::find($id);
        return view('invoices.show', compact('invoice'));
    }


    public function downloadPDF($id)
    {
        $invoice = Invoice::with('group.client', 'group.appointments')->findOrFail($id);

        $prixUnitaireTTC = $invoice->prix_unitaire_tvac;
        $tva = 21; // Exemple de taux de TVA à 21%
        $prixUnitaireHTVA = $prixUnitaireTTC / (1 + $tva / 100);
        $quantite = $invoice->group->number_of_people;

        // Calcul du nombre total d'heures
        $dureeTotale = $invoice->group->appointments->reduce(function ($carry, $appointment) {
            $start = Carbon::createFromFormat('H:i:s', $appointment->start_time);
            $end = Carbon::createFromFormat('H:i:s', $appointment->end_time);

            // Si l'heure de fin est plus petite que l'heure de début, cela traverse minuit
            if ($end < $start) {
                $end->addDay();
            }

            return $carry + $start->diffInHours($end);
        }, 0);

        // Récupération du totalAmount (TVAC)
        $totalTVAC = $invoice->total_amount;
        $totalHTVA = $totalTVAC / (1 + $tva / 100);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice', 'totalHTVA', 'totalTVAC', 'prixUnitaireHTVA', 'prixUnitaireTTC', 'dureeTotale', 'quantite'));
        return $pdf->download('facture_' . $invoice->id . '.pdf');
    }


    public function edit($id)
    {
        $invoice = Invoice::find($id);
        $this->authorize('update', $invoice);
        $groups = Group::all();
        return view('invoices.edit', compact('invoice', 'groups'));
    }

    public function update(Request $request, $id)
    {
        {
            $request->validate([
                'month' => 'required|string|max:255',
                'year' => 'required|integer',
                'group_id' => 'required|exists:groups,id',
                'status' => 'required|string',
            ]);

            $invoice = Invoice::find($id);
            $this->authorize('update', $invoice);

            $invoice->month = $request->month;
            $invoice->year = $request->year;
            $invoice->group_id = $request->group_id;
            $invoice->status = $request->status;
            $invoice->save();

            return redirect()->route('invoices.show', $id)->with('success', 'Facture mise à jour avec succès.');
        }
    }

    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $this->authorize('delete', $invoice);

        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Facture supprimée avec succès.');
    }

    public function sendCurrentMonth()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $invoices = Invoice::with('group.client', 'group.appointments')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->get();

        event(new InvoicesGenerated($invoices));

        return redirect()->route('invoices.index')->with('success', 'Factures envoyées à la comptabilité.');
    }


}
