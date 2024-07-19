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
    protected $description = 'Migrate Supporters from local database to Salesforce and Mailchimp through one webhook handled by N8N (https://n8n.io/).';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $supporters = Supporter::where('migrated', false)->where('updated_at', '<', \Carbon\Carbon::now()->subMinutes(30))->get();
        if ($supporters->count() == 0) {
            Log::channel('supporters')->info("No supporters to migrate");
            return Command::SUCCESS;
        }
        $supporters->each(function ($supporter) {
            if (!isset($supporter->data["email"]) || $supporter->data["email"] == "") {
                $supporter->migrated = true;
                $supporter->unfinished = true;
                $supporter->save();
                Log::channel('supporters')->info("No email for supporter: " . $supporter->id);
                return;
            }
            if ((!isset($supporter->data["membertype"]) || $supporter->data["membertype"] == "") && (!isset($supporter->data["volunteertype"]) || $supporter->data["volunteertype"] == "")) {
                $supporter->migrated = true;
                $supporter->unfinished = true;
                $supporter->save();
                Log::channel('supporters')->info("Unfinished supporter: " . $supporter->id);
                return;
            }
            $response = Http::withBasicAuth(env("WEBHOOK_USER"), env("WEBHOOK_PW"))->post(env("WEBHOOK_URL"), $supporter->data);
            if ($response->ok()) {
                $body = $response->json();
                if (!$body["success"] == true) {
                    Log::channel('supporters')->error("Failed: " . $supporter->id);
                    Log::channel('supporters')->error($response->body());
                    $supporter->migrated = true;
                    $supporter->failed = true;
                    $supporter->save();
                    return;
                }
                $supporter->migrated = true;
                $supporter->save();
                Log::channel('supporters')->info("Migrated: " . $supporter->id);
                Log::channel('supporters')->info($response->body());
            } else {
                $supporter->migrated = true;
                $supporter->failed = true;
                $supporter->save();
                Log::channel('supporters')->error("Failed: " . $supporter->id);
                Log::channel('supporters')->error($response->body());
            }
            $emailStatus = $supporter->sendEmails($body);
            if (!$emailStatus) {
                Log::channel('supporters')->error("Email sending failed");
            } else {
                Log::channel('supporters')->info("E-Mails sent successfully");
            }
        });
        return Command::SUCCESS;
    }
}
