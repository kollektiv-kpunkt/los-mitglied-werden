<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\SupporterController;
use App\Models\Supporter;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $cookies = request()->cookie();
    $existingSupporter = array_filter($cookies, function($key) {
        return Str::startsWith($key, "supporter_");
    }, ARRAY_FILTER_USE_KEY);
    if (count($existingSupporter) > 0) {
        $uuid = array_keys($existingSupporter)[0];
        $uuid = str_replace("supporter_", "", $uuid);
        return redirect()->route('supporter.show', ['uuid' => $uuid]);
    } else {
        $uuid = Str::uuid()->toString();
        $logfile = "supporters/{$uuid}_logfile.log";
        Storage::disk('local')->put($logfile, json_encode(array()));
        $supporter = new Supporter([
            'uuid' => $uuid,
            'logfile' => $logfile
        ]);
        cookie()->queue(cookie("supporter_" . $uuid, json_encode(array()), 60));
        $supporter->save();
        return redirect()->route('supporter.show', ['uuid' => $uuid]);
    }
});

Route::get("s/{uuid}", [SupporterController::class, 'show'])->name("supporter.show");
