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

            foreach ($responseBody as $data) {
                // Temukan record yang sesuai dengan user_id dan code
                $existingReward = Reward::where('user_id', $userId)
                ->where('code', $data['code'])
                ->first();

                if ($existingReward) {
                    // Jika record sudah ada, update
                    $existingReward->update([
                        'status' => $data['status'],
                        'reward' => json_encode($data['reward']),
                        'info' => json_encode($data['info']),
                    ]);
                } else {
                    // Jika record belum ada, buat baru
                    Reward::create([
                        'status' => $data['status'],
                        'code' => $data['code'],
                        'reward' => json_encode($data['reward']),
                        'info' => json_encode($data['info']),
                        'user_id' => $userId,
                    ]);
                }
                // Tambahkan data ke array rewards untuk keperluan lain jika diperlukan
                $rewards[] = $data;
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
