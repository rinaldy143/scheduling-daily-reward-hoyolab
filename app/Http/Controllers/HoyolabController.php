<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;

class HoyolabController extends Controller
{
    public function index()
    {

        // $output = [];
        // $command = "node " . escapeshellarg(base_path('storage/app/public/js/tes1.mjs'));
        // exec($command, $output);

        // // Parse output JSON dari Node.js
        // $rewards = [];
        // foreach ($output as $json) {
        //     $data = json_decode($json, true);


        //     // Simpan setiap item ke database
        //     Reward::updateOrCreate(
        //         [
        //             'status' => $data['status'],
        //             'code' => $data['code'],
        //         ],
        //         [
        //             'reward' => json_encode($data['reward']), // Simpan reward sebagai JSON
        //             'info' => json_encode($data['info']),     // Simpan info sebagai JSON
        //         ]
        //     );


        //     // Tambahkan ke array rewards untuk dikirim ke view
        //     $rewards[] = $data;
        // }

        $rewards = Reward::all();

        return view('hoyolab', compact('rewards'));
    }

}
