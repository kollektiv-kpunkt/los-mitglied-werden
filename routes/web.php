<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\SupporterController;
use App\Models\Supporter;

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
    $existingCookie = array_keys(array_filter($cookies, function($key) {
        return Str::startsWith($key, "supporter_");
    }, ARRAY_FILTER_USE_KEY))[0] ?? Str::uuid()->toString();
    $uuid = str_replace("supporter_", "", $existingCookie);
    if (Supporter::where('uuid', $uuid)->exists()) {
        $supporter = Supporter::where('uuid', $uuid)->first();
    } else {
        $langs = [
            "de" => "German",
            "fr" => "French",
            "it" => "Italian",
            "en" => "English"
        ];
        $supporter = new Supporter([
            'uuid' => $uuid,
            "data" => [
                "lang" => $langs[request()->getPreferredLanguage(array_keys($langs))],
            ],
        ]);
        $supporter->save();
    }
    cookie()->queue(cookie("supporter_" . $supporter->uuid, json_encode(array()), 15));
    return view("supporter.show", ["supporter" => $supporter]);
})->name('home');

Route::post("s/update", [SupporterController::class, 'update'])->name("supporter.update");
Route::post("s/destroy", [SupporterController::class, 'destroy'])->name("supporter.destroy");
