<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DateTimeController extends Controller
{
    /**
     * Supported timezones.
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
            'Pacific/Auckland',
        ];
    }

    /**
     * Current server date and time.
     */
    public function currentDateTime()
    {
        $now = now();

        return response()->json([
            'success' => true,
            'datetime' => $now->format('d F Y, h:i:s A'),
            'timezone' => config('app.timezone'),
            'timestamp' => $now->timestamp,
        ]);
    }

    /**
     * Detailed server date and time information.
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

                'day_of_week_number' => $now->dayOfWeek,
                'days_in_month' => $now->daysInMonth,
                'quarter' => $now->quarter,
                'weekend' => $now->isWeekend(),
            ],

            'timezones' => $this->availableTimezones(),
        ]);
    }

    /**
     * Current date and time for selected timezone.
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
     * Format current server date and time.
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

        $format = $request->query(
            'format',
            'long_12'
        );

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

    /**
     * World clock.
     */
    public function worldClock()
    {
        $cities = [
            [
                'city' => 'India',
                'timezone' => 'Asia/Kolkata',
            ],
            [
                'city' => 'Dubai',
                'timezone' => 'Asia/Dubai',
            ],
            [
                'city' => 'Tokyo',
                'timezone' => 'Asia/Tokyo',
            ],
            [
                'city' => 'Singapore',
                'timezone' => 'Asia/Singapore',
            ],
            [
                'city' => 'London',
                'timezone' => 'Europe/London',
            ],
            [
                'city' => 'Paris',
                'timezone' => 'Europe/Paris',
            ],
            [
                'city' => 'New York',
                'timezone' => 'America/New_York',
            ],
            [
                'city' => 'Los Angeles',
                'timezone' => 'America/Los_Angeles',
            ],
            [
                'city' => 'Sydney',
                'timezone' => 'Australia/Sydney',
            ],
        ];

        $result = [];

        foreach ($cities as $city) {
            $time = Carbon::now($city['timezone']);

            $result[] = [
                'city' => $city['city'],
                'timezone' => $city['timezone'],
                'time' => $time->format('h:i:s A'),
                'date' => $time->format('d M Y'),
                'day' => $time->format('l'),
                'offset' => $time->format('P'),
            ];
        }

        return response()->json([
            'success' => true,
            'cities' => $result,
        ]);
    }

    /**
     * Unix timestamp converter.
     */
    public function timestampConverter(Request $request)
    {
        $timestamp = $request->query('timestamp');

        if (!is_numeric($timestamp)) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid Unix timestamp.',
            ], 422);
        }

        try {
            $date = Carbon::createFromTimestamp(
                (int) $timestamp,
                config('app.timezone')
            );

            return response()->json([
                'success' => true,
                'timestamp' => (int) $timestamp,
                'datetime' => $date->format('d F Y, h:i:s A'),
                'date' => $date->format('d/m/Y'),
                'time' => $date->format('h:i:s A'),
                'day' => $date->format('l'),
                'timezone' => config('app.timezone'),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to convert timestamp.',
            ], 422);
        }
    }

    /**
     * Date difference calculator.
     */
    public function dateDifference(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        if (!$start || !$end) {
            return response()->json([
                'success' => false,
                'message' => 'Both start and end dates are required.',
            ], 422);
        }

        try {
            $startDate = Carbon::parse($start);
            $endDate = Carbon::parse($end);

            $diff = $startDate->diff($endDate);

            return response()->json([
                'success' => true,
                'start_date' => $startDate->format('d F Y'),
                'end_date' => $endDate->format('d F Y'),

                'difference' => [
                    'years' => $diff->y,
                    'months' => $diff->m,
                    'days' => $diff->d,
                    'total_days' => $startDate->diffInDays($endDate),
                    'total_weeks' => round(
                        $startDate->diffInDays($endDate) / 7,
                        2
                    ),
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid date provided.',
            ], 422);
        }
    }
}