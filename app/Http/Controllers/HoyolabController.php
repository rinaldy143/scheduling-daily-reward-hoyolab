<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\Cookies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HoyolabController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); // Ambil ID pengguna yang sedang login
        if ($userId) {
            Storage::put('user_id.txt', $userId); // Simpan user ID ke file
        }
        $error = Cookies::where('user_id', auth()->id())->latest()->first();
        $rewards = Reward::all();

        return view('hoyolab', compact('rewards', 'error'));
    }

}
