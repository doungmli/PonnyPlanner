<?php

namespace App\Listeners;

use App\Events\InvoicesGenerated;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendInvoicesEmail
{
    /**
     * Create the event listener.
     */
    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * Handle the event.
     */
    public function handle(InvoicesGenerated $event): void
    {
        $invoices = $event->invoices;
        $files = [];

        foreach ($invoices as $invoice) {
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

            // Utilisation de mb_strtoupper pour mettre le statut en majuscule
            $statutMajuscule = mb_strtoupper($invoice->status);

            $pdf = $this->pdf->loadView('invoices.pdf', compact(
                'invoice', 'totalHTVA', 'totalTVAC', 'prixUnitaireHTVA',
                'prixUnitaireTTC', 'dureeTotale', 'quantite', 'statutMajuscule'
            ));
            $output = $pdf->output();
            $fileName = 'facture_' . $invoice->id . '.pdf';
            file_put_contents(storage_path('app/public/' . $fileName), $output);
            $files[] = storage_path('app/public/' . $fileName);
        }

        Mail::send([], [], function ($message) use ($files) {
            $message->to('comptabilite@example.com')
                ->subject('Factures du Mois en Cours')
                ->html('Veuillez trouver en pièces jointes les factures du mois en cours.');

            foreach ($files as $file) {
                $message->attach($file);
            }
        });
    }
}
