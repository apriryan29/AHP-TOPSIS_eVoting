<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // ── GET PROFILE ─────────────────────────
    public function show(Request $request, $id)
    {
        $user = Vote::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data profile berhasil diambil',
            'data' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'email' => $user->email,
                'komisariat' => $user->komisariat,
                'status_verifikasi' => $user->status_verifikasi,
                'status_memilih'=>$user->status_memilih,
            ]
        ]);
    }

    // ── UPDATE PROFILE ───────────────────────
    public function update(Request $request, $id)
    {
        $user = Vote::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:votes,email,' . $user->id],
            'komisariat' => ['required', 'string', 'max:150'],
        ]);

        $user->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Profile berhasil diperbarui',
            'data' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'email' => $user->email,
                'komisariat' => $user->komisariat,
            ]
        ]);
    }

    // ── CHANGE PASSWORD ──────────────────────
    public function changePassword(Request $request, $id)
    {
        $user = Vote::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'old_password' => ['required'],
            'new_password' => ['required', 'confirmed', Password::min(6)],
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Password lama tidak sesuai'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password berhasil diubah'
        ]);
    }
}