<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kandidat;

class KandidatController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Kandidat::where('status', 'layak')->get()
        ]);
    }
}