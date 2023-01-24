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
                'message' => __("error.uuid.invalid"),
                "r" => $req
            ]);
        }
        $supporter->data = array_merge($supporter->data, $req);
        $supporter->save();
        $supporter->determineNext($req["next"] ?? null, $supporter);
        return response()->json([
            'status' => 'success',
            'message' => __("success.supporter.update"),
            "r" => $req,
            'supporter' => $supporter,
            "next" => $supporter->next
        ]);
    }

    public function destroy() {
        $req = request()->all();
        try {
            $supporter = Supporter::where('uuid', $req['uuid'])->firstOrFail();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __("error.uuid.invalid")
            ]);
        }
        cookie()->queue(cookie()->forget("supporter_" . $supporter->uuid));
        return response()->json([
            'status' => 'success',
            'message' => __("success.supporter.destroy"),
            'supporter' => $supporter
        ]);
    }
}
