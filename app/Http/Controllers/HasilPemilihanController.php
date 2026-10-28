<?php
namespace App\Http\Controllers;

use App\Models\Kandidat;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class HasilPemilihanController extends Controller
{
    public function exportPdf()
    {
        $data = Kandidat::query()
            ->where('status', 'Layak')
            ->leftJoin('vote_details', 'vote_details.candidate_id', '=', 'kandidats.id')
            ->select(
                'kandidats.nama',
                'kandidats.asal_komisariat',
                DB::raw('COUNT(vote_details.id) as total_suara')
            )
            ->groupBy(
                'kandidats.id',
                'kandidats.nama',
                'kandidats.asal_komisariat'
            )
            ->orderByDesc('total_suara')
            ->get();

        $pdf = Pdf::loadView('pdf.hasil-pemilihan', [
            'data' => $data
        ]);

        return $pdf->download('hasil-pemilihan.pdf');
    }
}