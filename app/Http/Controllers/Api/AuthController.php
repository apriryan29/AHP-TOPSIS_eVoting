<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = Vote::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'nama' => $user->nama,
                'email' => $user->email,
                'status_memilih' => $user->status_memilih,
            ]
        ]);
    }


    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $email = $request->input('email');

        $user = Vote::where('email', $email)->first();

        // Catatan keamanan: jangan beri tahu apakah email terdaftar atau tidak,
        // supaya tidak bisa dipakai untuk enumerasi akun.
        // Tapi untuk kemudahan debugging awal, kita beri pesan jelas dulu.
        if (!$user) {
            return response()->json([
                'message' => 'Email tidak ditemukan dalam sistem.',
            ], 404);
        }

        // Generate token random
        $token = Str::random(60);

        // Simpan / replace token di tabel password_reset_tokens
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => Hash::make($token), // simpan dalam bentuk hash
            'created_at' => Carbon::now(),
        ]);

        // Bangun deep link / app link
        // Ganti dengan domain App Link kamu yang sudah didaftarkan ke app Flutter
        // Ganti bagian ini di method forgotPassword()
        $resetUrl = 'votingapp://reset-password?token=' . $token . '&email=' . urlencode($email);

        Mail::to($email)->send(new ResetPasswordMail($resetUrl, $token, $user->nama ?? $user->name ?? ''));

        return response()->json([
            'message' => 'Link reset password telah dikirim ke email Anda.',
        ], 200);
    }

    /**
     * POST /api/reset-password
     * Body: { "email", "token", "password", "password_confirmation" }
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $email = $request->input('email');
        $token = $request->input('token');

        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$record) {
            return response()->json([
                'message' => 'Token tidak valid atau email tidak ditemukan.',
            ], 400);
        }

        // Cek token cocok
        if (!Hash::check($token, $record->token)) {
            return response()->json([
                'message' => 'Token reset password tidak valid.',
            ], 400);
        }

        // Cek expiry (60 menit)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return response()->json([
                'message' => 'Token sudah kedaluwarsa. Silakan minta link baru.',
            ], 400);
        }

        $user = Vote::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Pengguna tidak ditemukan.',
            ], 404);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Hapus token setelah dipakai
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return response()->json([
            'message' => 'Password berhasil diubah. Silakan login kembali.',
        ], 200);
    }
}