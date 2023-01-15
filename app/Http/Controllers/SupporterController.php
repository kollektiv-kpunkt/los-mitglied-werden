<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supporter;
use Illuminate\Support\Facades\App;

class SupporterController extends Controller
{
    public function create(array $data)
    {
        return Supporter::create([
            'uuid' => $data['uuid'],
            'logfile' => $data['logfile']
        ]);
    }

    public function show($uuid)
    {
        App::setLocale("de");
        $supporter = Supporter::where('uuid', $uuid)->firstOrFail();
        return view('supporter.show', ['supporter' => $supporter]);
    }
}
