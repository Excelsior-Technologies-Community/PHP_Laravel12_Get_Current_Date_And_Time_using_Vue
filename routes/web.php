<?php

use Illuminate\Support\Facades\Route;

Route::get('/current-datetime', function () {
    return response()->json([
        'datetime' => now()->format('d F Y, h:i:s A')
    ]);
});

