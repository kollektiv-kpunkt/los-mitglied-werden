<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Supporter extends Model
{
    use HasFactory;
    public $table = 'supporters';

    protected $fillable = [
        'uuid',
        'logfile',
        'migrated'
    ];

    protected $casts = [
        'migrated' => 'boolean'
    ];

    public function __constructor(array $attributes = [])
    {
        parent::__constructor($attributes);
    }

    public function prepare() {
        $db = $this->where('uuid', $this->uuid)->first();
        $this->logfile = "supporters/{$this->uuid}_logfile.json";
        $logfile = Storage::disk('local')->exists($this->logfile);
        if ($db && $logfile) {
            return;
        }
        Storage::disk('local')->put($this->logfile, json_encode(array()));
        $this->save();
    }

    public function readJSON() {
        $json = json_decode(Storage::disk('local')->get($this->logfile));
        foreach ($json as $key => $value) {
            $this->$key = $value;
        }
    }

    public function writeJSON() {
        Storage::disk('local')->put($this->logfile, json_encode($this->attributes, JSON_PRETTY_PRINT));
    }
}
