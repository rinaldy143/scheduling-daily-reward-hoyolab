<?php

namespace App\Console\Commands;

use App\Models\Reward;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunNodeScript extends Command
{
    protected $signature = 'run:nodescript';
    protected $description = 'Run the Node.js script and process the output';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $output = [];
        $command = "node " . escapeshellarg(base_path('storage/app/public/js/tes1.mjs'));
        exec($command, $output);

        // Parse output JSON dari Node.js
        $rewards = [];
        foreach ($output as $json) {
            $data = json_decode($json, true);


            // Simpan setiap item ke database
            Reward::updateOrCreate(
                [
                    'status' => $data['status'],
                    'code' => $data['code'],
                ],
                [
                    'reward' => json_encode($data['reward']), // Simpan reward sebagai JSON
                    'info' => json_encode($data['info']),     // Simpan info sebagai JSON
                ]
            );


            // Tambahkan ke array rewards untuk dikirim ke view
            $rewards[] = $data;
        }

        // Anda bisa memproses $rewards sesuai kebutuhan di sini
        // Misalnya menyimpan hasil ke database atau menulis ke file
        Log::info('Node.js script output:', $rewards);
    }
}
