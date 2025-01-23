<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Models\Cookies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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

    public function fetchUsers()
    {
        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_KEY');

        $url = $supabaseUrl . '/rest/v1/users?select=*';

        $headers = [
            'Content-Type: application/json',
            'apikey: ' . $supabaseKey,
            'Authorization: Bearer ' . $supabaseKey,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return response()->json(['error' => $error], 400);
        }

        $data = json_decode($response, true);
        return response()->json($data);
    }

    public function runNodeScript()
    {
        // Menjalankan perintah artisan
        $exitCode = Artisan::call('run:nodescript');
        // Mengecek hasil eksekusi dan mengembalikan respons
        if ($exitCode === 0) {
            return response()->json([
                'message' => 'Command executed successfully'
            ], 200);
        } else {
            return response()->json([
                'error' => 'Failed to execute command',
                'exit_code' => $exitCode
            ], 500);
        }
    }

}
