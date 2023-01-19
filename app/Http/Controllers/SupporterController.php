<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supporter;

class SupporterController extends Controller
{
    public function show($uuid)
    {
        try {
            $supporter = Supporter::where('uuid', $uuid)->firstOrFail();
        } catch (\Exception $e) {
            return redirect()->route('home');
        }
        try {
            $supporter->readJSON();
        } catch (\Exception $e) {
            return redirect()->route('home');
        }
        return view('supporter.show', ['supporter' => $supporter]);
    }

    public function update() {
        $req = request()->all();
        try {
            $supporter = Supporter::where('uuid', $req['uuid'])->firstOrFail();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __("error.uuid.invalid")
            ]);
        }
        $supporter->readJSON();
        foreach ($req as $key => $value) {
            $supporter->$key = $value;
        }
        $supporter->writeJSON();
        $supporter->determineNext($req["next"] ?? null, $supporter);
        return response()->json([
            'status' => 'success',
            'message' => __("success.supporter.update"),
            'supporter' => $supporter,
            "next" => $supporter->next
        ]);
    }
}
