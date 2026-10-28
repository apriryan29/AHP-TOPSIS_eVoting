<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pemilihan;

class PemilihanController extends Controller
{
    public function pemilihan()
    {
        $pemilihan = Pemilihan::latest()->first();

        return response()->json([
            'success' => true,
            'data' => [
                'nama_pemilihan' => $pemilihan->nama_pemilihan,
                'deskripsi'      => $pemilihan->deskripsi,
                'mulai'          => $pemilihan->mulai->toIso8601String(),
                'selesai'        => $pemilihan->selesai->toIso8601String(),
                'ketua_umum_id'   => $pemilihan->ketua_umum_id,
                'ketua_umum_nama' => $pemilihan->ketuaUmum?->nama,
            ]
        ]);
    }
}