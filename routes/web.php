<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DateTimeController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Current Server Date & Time
|--------------------------------------------------------------------------
*/

Route::get(
    '/current-datetime',
    [DateTimeController::class, 'currentDateTime']
);

/*
|--------------------------------------------------------------------------
| Date & Time Information
|--------------------------------------------------------------------------
*/

Route::get(
    '/datetime-info',
    [DateTimeController::class, 'dateTimeInfo']
);

/*
|--------------------------------------------------------------------------
| Multiple Timezone Clock
|--------------------------------------------------------------------------
*/

Route::get(
    '/timezone-datetime',
    [DateTimeController::class, 'timezoneDateTime']
);

/*
|--------------------------------------------------------------------------
| Date & Time Format Switcher
|--------------------------------------------------------------------------
*/

Route::get(
    '/formatted-datetime',
    [DateTimeController::class, 'formattedDateTime']
);