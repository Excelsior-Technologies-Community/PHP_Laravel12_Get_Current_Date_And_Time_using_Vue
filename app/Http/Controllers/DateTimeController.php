<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DateTimeController extends Controller
{
    /**
     * Supported timezones for the application.
     */
    private function availableTimezones(): array
    {
        return [
            'Asia/Kolkata',
            'Asia/Dubai',
            'Asia/Tokyo',
            'Asia/Singapore',
            'Europe/London',
            'Europe/Paris',
            'America/New_York',
            'America/Los_Angeles',
            'Australia/Sydney',
        ];
    }

    /**
     * Get current server date and time.
     */
    public function currentDateTime()
    {
        return response()->json([
            'success' => true,
            'datetime' => now()->format('d F Y, h:i:s A'),
            'timezone' => config('app.timezone'),
        ]);
    }

    /**
     * Get detailed server date and time information.
     */
    public function dateTimeInfo()
    {
        $now = now();

        return response()->json([
            'success' => true,

            'server' => [
                'datetime' => $now->format('d F Y, h:i:s A'),
                'timezone' => config('app.timezone'),

                'day' => $now->format('l'),
                'date' => $now->format('d'),
                'month' => $now->format('F'),
                'year' => $now->format('Y'),

                'day_of_year' => $now->dayOfYear,
                'week_of_year' => $now->weekOfYear,
                'unix_timestamp' => $now->timestamp,
                'is_leap_year' => $now->isLeapYear(),
            ],

            'timezones' => $this->availableTimezones(),
        ]);
    }

    /**
     * Get current date and time for selected timezone.
     */
    public function timezoneDateTime(Request $request)
    {
        $timezone = $request->query(
            'timezone',
            'Asia/Kolkata'
        );

        $availableTimezones = $this->availableTimezones();

        if (!in_array($timezone, $availableTimezones, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid timezone selected.',
                'available_timezones' => $availableTimezones,
            ], 422);
        }

        $dateTime = Carbon::now($timezone);

        return response()->json([
            'success' => true,
            'timezone' => $timezone,
            'datetime' => $dateTime->format('d F Y, h:i:s A'),
            'day' => $dateTime->format('l'),
            'date' => $dateTime->format('d'),
            'month' => $dateTime->format('F'),
            'year' => $dateTime->format('Y'),
            'offset' => $dateTime->format('P'),
            'unix_timestamp' => $dateTime->timestamp,
        ]);
    }

    /**
     * Format current server date and time using the selected format.
     */
    public function formattedDateTime(Request $request)
    {
        $formats = [
            'long_12' => 'd F Y, h:i:s A',
            'long_24' => 'd F Y, H:i:s',
            'short_date' => 'd/m/Y',
            'short_datetime_12' => 'd/m/Y h:i A',
            'short_datetime_24' => 'd/m/Y H:i:s',
            'iso' => 'Y-m-d H:i:s',
            'readable' => 'l, d F Y h:i:s A',
        ];

        $format = $request->query('format', 'long_12');

        if (!array_key_exists($format, $formats)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid date-time format selected.',
                'available_formats' => array_keys($formats),
            ], 422);
        }

        $now = now();

        return response()->json([
            'success' => true,
            'format' => $format,
            'datetime' => $now->format($formats[$format]),
            'timezone' => config('app.timezone'),
            'unix_timestamp' => $now->timestamp,
        ]);
    }
}