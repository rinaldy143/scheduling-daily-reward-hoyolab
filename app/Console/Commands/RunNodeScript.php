<?php

namespace App\Console\Commands;

use App\Models\Reward;
use App\Models\ErrorLog;
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
        exec($command . ' 2>&1', $output, $return_var); // Redirect stderr ke stdout

        $rewards = [];
        if ($return_var !== 0) {
            // Jika exit code bukan 0, berarti ada error
            $errorOutput = json_decode(end($output), true);

            ErrorLog::create([
                'user_id' => auth()->id(),
                // 'cookie' => env('HOYO_COOKIE'),
                'status' => $errorOutput['message'] ?? 'Unknown error',
            ]);
        } else {
            foreach ($output as $json) {
                $data = json_decode($json, true);

                Reward::updateOrCreate(
                    [
                        'status' => $data['status'],
                        'code' => $data['code'],
                    ],
                    [
                        'reward' => json_encode($data['reward']),
                        'info' => json_encode($data['info']),
                    ]
                );

                $rewards[] = $data;
            }
        }

        // Misalnya menyimpan hasil ke database atau menulis ke file
        Log::info('Node.js script output:', $rewards);
    }
}
