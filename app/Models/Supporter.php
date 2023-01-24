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
        'migrated',
        'data'
    ];

    protected $casts = [
        'migrated' => 'boolean',
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
}
