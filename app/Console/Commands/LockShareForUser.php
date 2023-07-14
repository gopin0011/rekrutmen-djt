<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Application;
use Carbon\Carbon;

class LockShareForUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:lock-share-for-user {argument?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Logika untuk eksekusi perintah
        $argument = $this->argument('argument');

        $now = Carbon::now()->subDay()->format('Y-m-d');

        $timeNow = Carbon::now()->format('Y-m-d H:i:s');

        $data = Application::where('is_lock_for_view', 0)->where('jadwalinterview', '<=', $now)->whereNull('lock_date')->orderBy('jadwalinterview', 'desc')->get();
        // dd($data);
        foreach($data as $row) {
            $row->update([
                'is_lock_for_view' => 1,
                'lock_date' => $timeNow,
            ]);
        }

        // $this->info('Perintah berhasil dijalankan dengan argumen: ' . $argument);

        return 0;
    }
}
