<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HoyolabController extends Controller
{
    public function index()
    {

        $output = [];
        $command = "node " . escapeshellarg(base_path('storage/app/public/js/tes1.mjs'));
        exec($command, $output);

        // Parse output JSON dari Node.js
        $rewards = [];
        foreach ($output as $json) {
            $rewards[] = json_decode($json, true);
        }

        return view('hoyolab', compact('rewards'));
    }

}
