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
    $uuid = Str::uuid()->toString();
    $logfile = "supporters/{$uuid}_logfile.log";
    Storage::disk('local')->put($logfile, json_encode(array()));
    $supporter = new Supporter([
        'uuid' => $uuid,
        'logfile' => $logfile
    ]);
    $supporter->save();
    return redirect()->route('supporter.show', ['uuid' => $uuid]);
});

Route::get("s/{uuid}", [SupporterController::class, 'show'])->name("supporter.show");
