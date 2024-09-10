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

        // $output = [];
        // $error_output = [];
        // $command = "node " . escapeshellarg(base_path('storage/app/public/js/tes1.mjs'));
        // exec($command . ' 2>&1', $output, $return_var); // Redirect stderr ke stdout

        // // Parse output JSON dari Node.js
        // $rewards = [];
        // if ($return_var !== 0) {
        //     // Jika exit code bukan 0, berarti ada error
        //     $errorOutput = json_decode(end($output), true);
        //     // Tangkap error dan lakukan sesuatu, seperti menyimpan pesan error ke database
        //     // Misalnya:
        //     ErrorLog::create([
        //         'user_id' => auth()->id(),
        //         // 'cookie' => env('HOYO_COOKIE'),
        //         'status' => $errorOutput['message'] ?? 'Unknown error', // Menangkap pesan error
        //     ]);
        // } else {
        //     foreach ($output as $json) {
        //         $data = json_decode($json, true);

        //         // Simpan setiap item ke database
        //         Reward::updateOrCreate(
        //             [
        //                 'status' => $data['status'],
        //                 'code' => $data['code'],
        //             ],
        //             [
        //                 'reward' => json_encode($data['reward']), // Simpan reward sebagai JSON
        //                 'info' => json_encode($data['info']),     // Simpan info sebagai JSON
        //             ]
        //         );


        //         // Tambahkan ke array rewards untuk dikirim ke view
        //         $rewards[] = $data;
        //     }
        // }
        $userId = auth()->id(); // Ambil ID pengguna yang sedang login
        if ($userId) {
            Storage::put('user_id.txt', $userId); // Simpan user ID ke file
        }
        $error = Cookies::where('user_id', auth()->id())->latest()->first();
        $rewards = Reward::all();

        return view('hoyolab', compact('rewards', 'error'));
    }

}
