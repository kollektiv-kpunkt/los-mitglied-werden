<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

use function Laravel\Prompts\text;
use function Laravel\Prompts\confirm;

class ExportSupportersToEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supporters:export2email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export supporters to email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startdate = text(
            'Enter the date from which you want to export the supporters',
            '2021-01-01, today, -2weeks',
            "",
            true,
            validate: function ($value) {
                if (strtotime($value) === false) {
                    return 'Please enter a valid date';
                }
                return null;
            }
        );
        $enddate = text(
            'Enter the date to which you want to export the supporters',
            '2021-01-01, today, -2weeks',
            "today",
            true,
            validate: function ($value) {
                if (strtotime($value) === false) {
                    return 'Please enter a valid date';
                }
                return null;
            }
        );
        $email = text(
            'Enter the email address to which you want to send the supporters',
            "required",
            "",
            true,
            validate: function ($value) {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return 'Please enter a valid email address';
                }
                return null;
            }
        );
        $startdate = date("Y-m-d", strtotime($startdate));
        $enddate = date("Y-m-d", strtotime($enddate));
        $this->info("Will export supporters with following parameters:");
        $this->info("Start date: $startdate");
        $this->info("End date: $enddate");
        $this->info("Email: $email");
        if (confirm('Do you want to proceed?')) {
            $this->info("Exporting supporters...");
            $supportersCSV = $this->exportSupporters($startdate, $enddate);
            $this->info("Supporters exported successfully");
            $this->info("Sending email to $email...");
            $this->sendEmail($email, $supportersCSV);
            $this->info("Email sent successfully");
        } else {
            $this->error("Export cancelled");
            return 1;
        }
        return 0;
    }

    private function exportSupporters($startdate, $enddate)
    {
        $fields = [];
        $fieldKeys = \App\Models\Supporter::whereDate('created_at', '>=', $startdate)
            ->whereDate('created_at', '<=', $enddate)
            ->each(function ($supporter) use (&$fields) {
                $fields = array_merge($fields, array_keys($supporter->data));
            });
        $fields = array_unique($fields);
        $fields = array_merge(["id", "created_at", "updated_at"], $fields);
        $fields = array_diff($fields, ["history", "next"]);
        $supporters = \App\Models\Supporter::whereDate('created_at', '>=', $startdate)
            ->whereDate('created_at', '<=', $enddate)
            ->get()
            ->toArray();
        $supportersCSV = implode(",", $fields) . "\n";
        foreach ($supporters as $supporter) {
            $supporterData = [];
            foreach ($fields as $field) {
                if (in_array($field, ["id", "created_at", "updated_at"])) {
                    $supporterData[$field] = $supporter[$field];
                } else {
                    $supporterData[$field] = $supporter["data"][$field] ?? "";
                }
            }
            if (isset($supporterData["volunteertype"]) && is_array($supporterData["volunteertype"])) {
                $supporterData["volunteertype"] = implode(",", $supporterData["volunteertype"]);
            }
            if (isset($supporterData["locations"]) && is_array($supporterData["locations"])) {
                $supporterData["locations"] = implode(",", $supporterData["locations"]);
            }
            $supportersCSV .= implode(",", $supporterData) . "\n";
        }
        return $supportersCSV;
    }

    private function sendEmail($email, $supportersCSV)
    {
        Mail::raw("Supporters export", function ($message) use ($email, $supportersCSV) {
            $message->to($email)
                ->subject('Supporters export')
                ->attachData($supportersCSV, 'supporters.csv')
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });
    }
}
