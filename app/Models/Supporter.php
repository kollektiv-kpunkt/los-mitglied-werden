<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
