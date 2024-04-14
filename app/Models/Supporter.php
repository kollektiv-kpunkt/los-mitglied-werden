<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupporterWelcome;
use App\Mail\AdminInfo;

class Supporter extends Model
{
    use HasFactory;
    public $table = 'supporters';

    protected $fillable = [
        'uuid',
        'migrated',
        'failed',
        'unfinished',
        'data'
    ];

    protected $casts = [
        'migrated' => 'boolean',
        'failed' => 'boolean',
        'unfinished' => 'boolean',
        'data' => 'array'
    ];

    public function __constructor(array $attributes = [])
    {
        parent::__constructor($attributes);
    }

    public function determineNext($next, $supporter) {
        $next = json_decode($next);
        if (gettype($next) == "string") {
            $this->next = (string)$next;
            return;
        } else if (gettype($next) == "object") {
            foreach ($next as $key => $value) {
                if ($key == "ELSE") {
                    $this->next = $value;
                    return;
                }
                $condition = explode("_", $key)[0];
                $met = explode("_", $key)[1];
                if($supporter->data[$condition] == $met){
                    $this->next = $value;
                    return;
                }
            }
        } else {
            $this->next = null;
            return;
        }
    }

    /**
     * Send E-Mails to supporter and Admin
     *
     * @param array $body
     * @return boolean
     */
    public function sendEmails($body)
    {
        $supporter = Supporter::where('uuid', $body["uuid"])->first();
        $salesforceID = $body["salesforceID"];
        try {
            Mail::to(env("ADMIN_EMAIL"))
                ->send(new AdminInfo($supporter, $salesforceID));
        } catch (\Exception $e) {
            return false;
        }
        $supporterType = isset($supporter->data["membertype"]) ? "member" : "volunteer";
        try {
            Mail::to($supporter->data["email"])
                ->send(new SupporterWelcome($supporter->data["lang"], $supporter, $supporterType));
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}
