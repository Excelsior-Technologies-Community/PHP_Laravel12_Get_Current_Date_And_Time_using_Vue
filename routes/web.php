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
| Detailed Date & Time Information
|--------------------------------------------------------------------------
*/

Route::get(
    '/datetime-info',
    [DateTimeController::class, 'dateTimeInfo']
);

/*
|--------------------------------------------------------------------------
| Multiple Timezone
|--------------------------------------------------------------------------
*/

Route::get(
    '/timezone-datetime',
    [DateTimeController::class, 'timezoneDateTime']
);

/*
|--------------------------------------------------------------------------
| Date & Time Format
|--------------------------------------------------------------------------
*/

Route::get(
    '/formatted-datetime',
    [DateTimeController::class, 'formattedDateTime']
);

/*
|--------------------------------------------------------------------------
| NEW: World Clock
|--------------------------------------------------------------------------
*/

Route::get(
    '/world-clock',
    [DateTimeController::class, 'worldClock']
);

/*
|--------------------------------------------------------------------------
| NEW: Unix Timestamp Converter
|--------------------------------------------------------------------------
*/

Route::get(
    '/timestamp-converter',
    [DateTimeController::class, 'timestampConverter']
);

/*
|--------------------------------------------------------------------------
| NEW: Date Difference Calculator
|--------------------------------------------------------------------------
*/

Route::get(
    '/date-difference',
    [DateTimeController::class, 'dateDifference']
);