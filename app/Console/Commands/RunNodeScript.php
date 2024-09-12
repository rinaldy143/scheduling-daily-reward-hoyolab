<?php

namespace App\Console\Commands;

use App\Models\Reward;
use App\Models\Cookies;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        $userId = Storage::get('user_id.txt'); // Ambil user ID dari file

        if (!$userId) {
            $this->error('User ID not found in cache.');
            return;
        }
        // dd($userId);
        $command = "node " . escapeshellarg(base_path('storage/app/public/js/tes2.mjs')) . ' ' . escapeshellarg($userId);
        exec($command . ' 2>&1', $output, $return_var); // Redirect stderr ke stdout

        $rewards = [];
        $errors = [];
        Log::debug($errorOutput = json_decode(end($output), true));

        if ($return_var !== 0) {
            // Jika exit code bukan 0, berarti ada error
            $errorOutput = json_decode(end($output), true);
            Log::debug($errorOutput = json_decode(end($output), true));

            Cookies::where('user_id', $userId)->update([
                'status' => $errorOutput['message'] ?? 'Unknown error',
            ]);
            $errors[] = $errorOutput; // Menyimpan error output
        } else {
            Cookies::where('user_id', $userId)->update([
                'status' => 'Logged in',
            ]);
            // Cek apakah tabel Reward kosong
            if (Reward::count() == 0) {
                // Jika kosong, lakukan create untuk setiap data dari foreach
                foreach ($output as $json) {
                    $data = json_decode($json, true);
                    Reward::create([
                        'status' => $data['status'],
                        'code' => $data['code'],
                        'reward' => json_encode($data['reward']),
                        'info' => json_encode($data['info']),
                    ]);
                    $rewards[] = $data;
                }
            } else {
                // Ambil semua record dari database yang sudah ada
                $existingRewards = Reward::all();

                // Pastikan jumlah record di database cukup untuk update
                foreach ($output as $index => $json) {
                    $data = json_decode($json, true);

                    // Update record sesuai urutan dengan record yang ada di database
                    if (isset($existingRewards[$index])) {
                        $existingReward = $existingRewards[$index];
                        $existingReward->update([
                            'status' => $data['status'],
                            'code' => $data['code'],
                            'reward' => json_encode($data['reward']),
                            'info' => json_encode($data['info']),
                        ]);
                    }

                    $rewards[] = $data;
                }
            }

        }

        // Misalnya menyimpan hasil ke database atau menulis ke file
        if (!empty($errors)) {
            Log::error('Node.js script errors:', $errors);
        }
        if (!empty($rewards)) {
            Log::info('Node.js script rewards:', $rewards);
        }
    }
}
