<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supporter;

class SupporterController extends Controller
{
    public function show($uuid)
    {
        $supporter = Supporter::where('uuid', $uuid)->firstOrFail();
        return view('supporter.show', ['supporter' => $supporter]);
    }
}
