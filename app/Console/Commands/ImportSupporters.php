<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Supporter;
use Illuminate\Support\Facades\Log;

class ImportSupporters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supporters:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $supporters = Supporter::where('migrated', false)->where('updated_at', '<', \Carbon\Carbon::now()->subMinutes(15))->get();
        $supporters->each(function ($supporter) {
            $response = Http::withBasicAuth(env("WEBHOOK_USER"), env("WEBHOOK_PW"))->post(env("WEBHOOK_URL"), $supporter->data);
            if ($response->ok()) {
                $supporter->migrated = true;
                $supporter->save();
                Log::channel('supporters')->info("Migrated: " . $supporter->id);
                Log::channel('supporters')->info($response->body());
            } else {
                Log::channel('supporters')->error("Failed: " . $supporter->id);
                Log::channel('supporters')->error($response->body());
            }
        });
        return Command::SUCCESS;
    }
}
