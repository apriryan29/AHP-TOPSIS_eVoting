<?php

namespace App\Http\Controllers\Api;

use App\Models\Vote;
use App\Models\VoteDetail;
use App\Models\Kandidat;
use App\Http\Controllers\Controller;
use App\Mail\VotingTokenMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class VotingController extends Controller
{
    public function kirimToken(Request $request)
    {
        $request->validate([
            'user_id' => ['required'],
            'email' => ['required', 'email'],
        ]);

        $vote = Vote::find($request->user_id);

        if (!$vote) {
            return response()->json([
                'message' => 'Data pemilih tidak ditemukan.'
            ], 404);
        }

        if ($vote->email !== $request->email) {
            return response()->json([
                'message' => 'Email tidak sesuai dengan akun login.'
            ], 422);
        }

        if ($vote->status_memilih == 1) {
            return response()->json([
                'message' => 'Anda sudah menggunakan hak suara.'
            ], 422);
        }

        Mail::to($vote->email)
            ->send(new VotingTokenMail($vote->token));

        $vote->status_verifikasi = 1;
        $vote->save();

        return response()->json([
            'success' => true,
            'message' => 'Token berhasil dikirim ke email.'
        ]);
    }

    public function cekVerifikasi($id)
    {
        $vote = Vote::find($id);

        if (!$vote) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            // status_verifikasi = 1 artinya pemilih sudah minta token (email terkirim).
            // Validitas TOKEN itu sendiri baru benar-benar dicek di verifikasiToken().
            'verified' => (bool) $vote->status_verifikasi
        ]);
    }

    /**
     * Cocokkan token yang diinput user dengan token di database (kolom Vote.token).
     * Dipanggil dari TokenPage setelah user mengetik 6 digit token dari email.
     *
     * PENTING: method ini HANYA mencocokkan token, tidak mengubah status apapun.
     * status_memilih baru di-set 1 nanti di simpanPilihan(), saat user benar-benar
     * submit pilihan kandidat (titik akhir yang sebenarnya tidak bisa kembali).
     */
    public function verifikasiToken(Request $request)
    {
        $request->validate([
            'user_id' => ['required'],
            'token'   => ['required', 'string'],
        ]);

        $vote = Vote::find($request->user_id);

        if (!$vote) {
            return response()->json([
                'success' => false,
                'message' => 'Data pemilih tidak ditemukan.'
            ], 404);
        }

        if ($vote->status_memilih == 1) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah menggunakan hak suara.'
            ], 422);
        }

        if ($vote->status_verifikasi != 1) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan verifikasi email.'
            ], 422);
        }

        if ((string) $vote->token !== (string) $request->token) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak sesuai. Periksa kembali email Anda.'
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Token valid.'
        ]);
    }

    /**
     * Simpan pilihan kandidat (submit final) ke tabel vote_details.
     * Ini titik akhir yang tidak bisa kembali: status_memilih di-set 1 di sini,
     * sehingga token otomatis "terbakar" / tidak bisa dipakai lagi setelah vote tersimpan.
     */
    public function simpanPilihan(Request $request)
    {
        $request->validate([
            'user_id'      => ['required'],
            'kandidat_ids' => ['required', 'string'], // JSON-encoded array dari Flutter
        ]);

        $vote = Vote::find($request->user_id);

        if (!$vote) {
            return response()->json([
                'success' => false,
                'message' => 'Data pemilih tidak ditemukan.'
            ], 404);
        }

        if ($vote->status_memilih == 1) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah menggunakan hak suara.'
            ], 422);
        }

        if ($vote->status_verifikasi != 1) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan verifikasi token.'
            ], 422);
        }

        $kandidatIds = json_decode($request->kandidat_ids, true);

        if (!is_array($kandidatIds) || count($kandidatIds) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Pilihan kandidat tidak valid.'
            ], 422);
        }

        // Pastikan tidak ada id duplikat dan semua berupa integer
        $kandidatIds = array_values(array_unique(array_map('intval', $kandidatIds)));

        DB::transaction(function () use ($vote, $kandidatIds) {
            foreach ($kandidatIds as $candidateId) {
                VoteDetail::create([
                    'vote_id'      => $vote->id,
                    'candidate_id' => $candidateId,
                ]);
            }

            $vote->status_memilih = 1;
            $vote->save();
        });

        return response()->json([
            'success' => true,
            'message' => 'Pilihan berhasil disimpan.'
        ]);
    }
    public function hasilSuara()
    {
        $hasil = Kandidat::leftJoin('vote_details', 'kandidats.id', '=', 'vote_details.candidate_id')
            ->where('kandidats.status', 'layak')
            ->select('kandidats.id', 'kandidats.nama')
            ->selectRaw('COUNT(vote_details.id) as suara')
            ->groupBy('kandidats.id', 'kandidats.nama')
            ->orderByDesc('suara')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $hasil,
        ]);
    }
}