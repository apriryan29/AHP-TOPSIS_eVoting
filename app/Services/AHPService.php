<?php

namespace App\Services;

use App\Models\Kriteria;
use App\Models\PerbandinganKriteria;

class AHPService
{
    public function hitungBobot()
    {
        $kriteria = Kriteria::all();
        $n = $kriteria->count();

        if ($n === 0) {
            return [];
        }

        // =========================
        // 1. BUAT MATRIX PERBANDINGAN
        // =========================
        $matrix = [];

        foreach ($kriteria as $i => $k1) {
            foreach ($kriteria as $j => $k2) {

                if ($i == $j) {
                    $matrix[$i][$j] = 1;
                    continue;
                }

                // cek A vs B
                $data = PerbandinganKriteria::where('kriteria_a_id', $k1->id)
                    ->where('kriteria_b_id', $k2->id)
                    ->first();

                if ($data) {
                    $matrix[$i][$j] = $data->nilai_perbandingan;
                } else {
                    // cek kebalikannya (B vs A)
                    $reverse = PerbandinganKriteria::where('kriteria_a_id', $k2->id)
                        ->where('kriteria_b_id', $k1->id)
                        ->first();

                    $matrix[$i][$j] = $reverse
                        ? 1 / $reverse->nilai_perbandingan
                        : 1;
                }
            }
        }

        // =========================
        // 2. JUMLAH KOLOM
        // =========================
        $colSum = [];

        for ($j = 0; $j < $n; $j++) {
            $colSum[$j] = 0;

            for ($i = 0; $i < $n; $i++) {
                $colSum[$j] += $matrix[$i][$j];
            }
        }

        // =========================
        // 3. NORMALISASI MATRIX
        // =========================
        $normalized = [];

        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $normalized[$i][$j] = $matrix[$i][$j] / $colSum[$j];
            }
        }

        // =========================
        // 4. HITUNG BOBOT (EIGENVECTOR)
        // =========================
        $weights = [];

        for ($i = 0; $i < $n; $i++) {
            $weights[$i] = array_sum($normalized[$i]) / $n;
        }

        // =========================
        // 5. SIMPAN KE DATABASE
        // =========================
        foreach ($kriteria as $i => $item) {
            $item->update([
                'bobot' => $weights[$i]
            ]);
        }

        return [
            'kriteria' => $kriteria,
            'weights' => $weights,
        ];
    }
}