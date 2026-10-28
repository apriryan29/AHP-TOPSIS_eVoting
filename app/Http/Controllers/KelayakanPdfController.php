<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kandidat;
use App\Models\ValidasiKandidat;

class KelayakanPdfController extends Controller
{
    public function generate()
    {
        $kriterias = ValidasiKandidat::all();
        $kandidats = Kandidat::with('penilaian')->get();

        $hasil = [];

        foreach ($kandidats as $kandidat) {

            $preferensi = 0; // sesuaikan dengan hasil perhitungan TOPSIS Anda

            $hasil[] = [
                'nama' => $kandidat->nama,
                'nia' => $kandidat->nia,
                'komisariat' => $kandidat->asal_komisariat,
                'status' => $kandidat->status,
                'preferensi' => $preferensi,
            ];
        }

        $pdf = Pdf::loadView('pdf.kelayakan', [
            'hasil' => $hasil,
        ]);

        return $pdf->stream('laporan-kelayakan.pdf');
    }
}