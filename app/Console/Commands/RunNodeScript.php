<?php

namespace App\Console\Commands;

use App\Models\Reward;
use App\Models\Cookies;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
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
        // Ambil user ID dari file
        $userId = Storage::get('user_id.txt');

        if (!$userId) {
            $this->error('User ID not found in cache.');
            return;
        }

        // Melakukan HTTP POST request ke API
        $response = Http::post('https://daily-reward-api.vercel.app/api/claim-rewards', [
            'userId' => $userId,
        ]);

        // Mendapatkan response body dan status code
        $responseBody = $response->json();
        $statusCode = $response->status();

        // Menyimpan data reward dan error ke database
        $rewards = [];
        $errors = [];

        if ($statusCode !== 200) {
            // Jika status code bukan 200, berarti ada error
            $errorOutput = $responseBody;
            Log::debug($errorOutput);

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
                // Jika kosong, lakukan create untuk setiap data dari response
                foreach ($responseBody as $data) {
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
                foreach ($responseBody as $data) {
                    $existingReward = Reward::where('code', $data['code'])->first();

                    // Update record sesuai urutan dengan record yang ada di database
                    if ($existingReward) {
                        $existingReward->update([
                            'status' => $data['status'],
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
            Log::error('API errors:', $errors);
        }
        if (!empty($rewards)) {
            Log::info('API rewards:', $rewards);
        }
    }
}
