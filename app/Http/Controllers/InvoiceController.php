<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
/*    public function index()
    {
        $invoices = Invoice::with('group')->get();
        $months = Invoice::distinct()->pluck('month');
        return view('invoices.index', compact('invoices', 'months'));
    }

    public function show($id)
    {
        $invoice = Invoice::with('appointments.group.client')->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    public function summary($month)
    {
        $appointments = Invoice::with('appointments.group.client')
            ->where('month', $month)
            ->get()
            ->flatMap(function ($invoice) {
                return $invoice->appointments;
            });

        return response()->json($appointments);
    }

    public function download($id)
    {
        $invoice = Invoice::with('appointments.group.client')->findOrFail($id);
        $pdf = PDF::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download('invoice_' . $invoice->id . '.pdf');
    }*/

    public function index()
    {
        $invoices = Invoice::with('group')->get();
        $months = Invoice::distinct()->pluck('month');
        return view('invoices.index', compact('invoices', 'months'));
    }

    public function show($id)
    {
        $invoice = Invoice::with('appointments.group.client')->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    public function download($id)
    {
        $invoice = Invoice::with('appointments.group.client')->findOrFail($id);
        $pdf = PDF::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download('invoice_' . $invoice->id . '.pdf');
    }
}
