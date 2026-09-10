<template>

    <div
        class="datetime-dashboard"
        :class="currentTheme"
    >

        <!-- =====================================================
             HEADER
        ====================================================== -->

        <div class="dashboard-header">

            <div>

                <h1>
                    🕐 Laravel Server Date & Time
                </h1>

                <p>
                    Advanced Laravel 12 + Vue 3 Date & Time Dashboard
                </p>

            </div>

            <button
                class="theme-button"
                @click="toggleTheme"
            >
                {{ currentTheme === 'dark-theme' ? '☀️ Light' : '🌙 Dark' }}
            </button>

        </div>


        <!-- =====================================================
             MAIN SERVER CLOCK
        ====================================================== -->

        <div class="main-clock-card">

            <div class="clock-icon">
                🕐
            </div>

            <h2>
                Server Date & Time
            </h2>

            <div class="main-time">
                {{ dateTime || 'Loading...' }}
            </div>

            <div class="server-timezone">

                Server Timezone:

                <strong>
                    {{ serverTimezone }}
                </strong>

            </div>

            <button
                class="copy-button"
                @click="copyText(dateTime)"
            >
                📋 Copy Date & Time
            </button>

        </div>


        <!-- =====================================================
             SYNC STATUS
        ====================================================== -->

        <div class="status-card">

            <div class="status-left">

                <span
                    class="status-dot"
                    :class="apiStatus ? 'online' : 'offline'"
                ></span>

                <div>

                    <strong>
                        {{
                            apiStatus
                                ? 'Server Connected'
                                : 'Connection Error'
                        }}
                    </strong>

                    <p>

                        Last synchronized:

                        {{ lastSyncTime || 'Waiting...' }}

                    </p>

                </div>

            </div>


            <div class="sync-info">

                <div>

                    <strong>
                        {{ refreshCount }}
                    </strong>

                    <span>
                        Sync Requests
                    </span>

                </div>


                <div>

                    <strong>
                        {{ responseTime }} ms
                    </strong>

                    <span>
                        Response Time
                    </span>

                </div>

            </div>

        </div>


        <!-- =====================================================
             AUTO REFRESH CONTROL
        ====================================================== -->

        <div class="section-card">

            <div class="section-title">

                <h2>
                    🔄 Auto Refresh Control
                </h2>

                <p>
                    Control automatic Laravel API synchronization.
                </p>

            </div>


            <div class="control-grid">

                <div>

                    <label>
                        Auto Refresh
                    </label>

                    <button
                        class="control-button"
                        @click="toggleAutoRefresh"
                    >

                        {{
                            autoRefresh
                                ? '🟢 Enabled'
                                : '🔴 Disabled'
                        }}

                    </button>

                </div>


                <div>

                    <label>
                        Refresh Interval
                    </label>

                    <select
                        v-model.number="refreshInterval"
                        @change="restartTimer"
                    >

                        <option :value="1000">
                            Every 1 second
                        </option>

                        <option :value="2000">
                            Every 2 seconds
                        </option>

                        <option :value="5000">
                            Every 5 seconds
                        </option>

                        <option :value="10000">
                            Every 10 seconds
                        </option>

                    </select>

                </div>

            </div>

        </div>


        <!-- =====================================================
             MULTIPLE TIMEZONE
        ====================================================== -->

        <div class="section-card">

            <div class="section-title">

                <h2>
                    🌍 Multiple Timezone Clock
                </h2>

                <p>
                    Select a timezone and view its current time.
                </p>

            </div>


            <div class="timezone-controls">

                <label>
                    Select Timezone
                </label>

                <select
                    v-model="selectedTimezone"
                    @change="fetchTimezoneTime"
                >

                    <option
                        v-for="timezone in timezones"
                        :key="timezone"
                        :value="timezone"
                    >

                        {{ timezone }}

                    </option>

                </select>

            </div>


            <div class="timezone-result">

                <div class="timezone-name">
                    {{ selectedTimezone }}
                </div>

                <div class="timezone-time">
                    {{ timezoneDateTime || 'Loading...' }}
                </div>

                <div class="timezone-details">

                    <span>
                        📅 {{ timezoneDay }}
                    </span>

                    <span>
                        🕓 UTC {{ timezoneOffset }}
                    </span>

                </div>

                <button
                    class="copy-button"
                    @click="copyText(timezoneDateTime)"
                >
                    📋 Copy Time
                </button>

            </div>

        </div>


        <!-- =====================================================
             WORLD CLOCK
        ====================================================== -->

        <div class="section-card">

            <div class="section-title">

                <h2>
                    🌐 World Clock
                </h2>

                <p>
                    Live time in major cities calculated by Laravel.
                </p>

            </div>


            <div class="world-clock-grid">

                <div
                    v-for="city in worldClocks"
                    :key="city.city"
                    class="world-clock-card"
                >

                    <div class="city-icon">
                        🌍
                    </div>

                    <h3>
                        {{ city.city }}
                    </h3>

                    <div class="world-time">
                        {{ city.time }}
                    </div>

                    <div class="world-date">
                        {{ city.date }}
                    </div>

                    <div class="world-day">
                        {{ city.day }}
                    </div>

                    <small>
                        UTC {{ city.offset }}
                    </small>

                </div>

            </div>

        </div>


        <!-- =====================================================
             DATE INFORMATION
        ====================================================== -->

        <div class="section-card">

            <div class="section-title">

                <h2>
                    📊 Date & Time Information
                </h2>

                <p>
                    Detailed information generated by Laravel.
                </p>

            </div>


            <div class="info-grid">

                <div class="info-box">
                    <span>📅 Date</span>
                    <strong>{{ serverDate }}</strong>
                </div>

                <div class="info-box">
                    <span>📆 Day</span>
                    <strong>{{ serverDay }}</strong>
                </div>

                <div class="info-box">
                    <span>🗓️ Month</span>
                    <strong>{{ serverMonth }}</strong>
                </div>

                <div class="info-box">
                    <span>📌 Year</span>
                    <strong>{{ serverYear }}</strong>
                </div>

                <div class="info-box">
                    <span>📈 Day of Year</span>
                    <strong>{{ dayOfYear }}</strong>
                </div>

                <div class="info-box">
                    <span>📊 Week of Year</span>
                    <strong>{{ weekOfYear }}</strong>
                </div>

                <div class="info-box">
                    <span>⏱️ Unix Timestamp</span>
                    <strong>{{ unixTimestamp }}</strong>
                </div>

                <div class="info-box">
                    <span>📐 Leap Year</span>
                    <strong>{{ isLeapYear ? 'Yes' : 'No' }}</strong>
                </div>

                <div class="info-box">
                    <span>📅 Days In Month</span>
                    <strong>{{ daysInMonth }}</strong>
                </div>

                <div class="info-box">
                    <span>🔢 Quarter</span>
                    <strong>{{ quarter }}</strong>
                </div>

                <div class="info-box">
                    <span>📍 Day Number</span>
                    <strong>{{ dayOfWeekNumber }}</strong>
                </div>

                <div class="info-box">
                    <span>🏖️ Weekend</span>
                    <strong>
                        {{ isWeekend ? 'Yes' : 'No' }}
                    </strong>
                </div>

            </div>

        </div>


        <!-- =====================================================
             FORMAT SWITCHER
        ====================================================== -->

        <div class="section-card">

            <div class="section-title">

                <h2>
                    ⏰ Date & Time Format Switcher
                </h2>

                <p>
                    Select different Laravel date/time formats.
                </p>

            </div>


            <div class="format-controls">

                <label>
                    Select Format
                </label>

                <select
                    v-model="selectedFormat"
                    @change="fetchFormattedTime"
                >

                    <option value="long_12">
                        Long Date - 12 Hour
                    </option>

                    <option value="long_24">
                        Long Date - 24 Hour
                    </option>

                    <option value="short_date">
                        Short Date
                    </option>

                    <option value="short_datetime_12">
                        Short Date & Time - 12 Hour
                    </option>

                    <option value="short_datetime_24">
                        Short Date & Time - 24 Hour
                    </option>

                    <option value="iso">
                        ISO Date & Time
                    </option>

                    <option value="readable">
                        Full Readable Date & Time
                    </option>

                </select>

            </div>


            <div class="format-result">

                <div class="format-icon">
                    ⏱️
                </div>

                <div class="format-label">
                    {{ selectedFormatLabel }}
                </div>

                <div class="formatted-time">
                    {{ formattedDateTime || 'Loading...' }}
                </div>

                <button
                    class="copy-button"
                    @click="copyText(formattedDateTime)"
                >
                    📋 Copy
                </button>

            </div>

        </div>


        <!-- =====================================================
             BROWSER VS SERVER TIME
        ====================================================== -->

        <div class="section-card">

            <div class="section-title">

                <h2>
                    💻 Browser vs Server Time
                </h2>

                <p>
                    Compare your browser clock with Laravel server time.
                </p>

            </div>


            <div class="comparison-grid">

                <div class="comparison-box">

                    <span>
                        💻 Browser Local Time
                    </span>

                    <strong>
                        {{ browserTime }}
                    </strong>

                </div>


                <div class="comparison-box">

                    <span>
                        🖥️ Laravel Server Time
                    </span>

                    <strong>
                        {{ dateTime }}
                    </strong>

                </div>

            </div>

        </div>


        <!-- =====================================================
             STOPWATCH
        ====================================================== -->

        <div class="section-card">

            <div class="section-title">

                <h2>
                    ⏱️ Stopwatch
                </h2>

                <p>
                    Start, pause and reset the stopwatch.
                </p>

            </div>


            <div class="stopwatch">

                <div class="stopwatch-time">
                    {{ formattedStopwatch }}
                </div>

                <div class="button-group">

                    <button
                        class="success-button"
                        @click="startStopwatch"
                    >
                        ▶ Start
                    </button>

                    <button
                        class="warning-button"
                        @click="pauseStopwatch"
                    >
                        ⏸ Pause
                    </button>

                    <button
                        class="danger-button"
                        @click="resetStopwatch"
                    >
                        🔄 Reset
                    </button>

                </div>

            </div>

        </div>


        <!-- =====================================================
             COUNTDOWN TO MIDNIGHT
        ====================================================== -->

        <div class="section-card">

            <div class="section-title">

                <h2>
                    ⏳ Countdown to Midnight
                </h2>

                <p>
                    Remaining time until the next day.
                </p>

            </div>


            <div class="countdown">

                <div class="countdown-time">
                    {{ countdownToMidnight }}
                </div>

                <div class="countdown-label">
                    Hours : Minutes : Seconds
                </div>

            </div>

        </div>


        <!-- =====================================================
             ALARM
        ====================================================== -->

        <div class="section-card">

            <div class="section-title">

                <h2>
                    🔔 Alarm
                </h2>

                <p>
                    Set a browser alarm based on your local clock.
                </p>

            </div>


            <div class="alarm-controls">

                <input
                    type="time"
                    v-model="alarmTime"
                >

                <button
                    class="control-button"
                    @click="setAlarm"
                >
                    🔔 Set Alarm
                </button>

                <button
                    class="danger-button"
                    @click="clearAlarm"
                >
                    ❌ Clear
                </button>

            </div>


            <div
                v-if="alarmMessage"
                class="alarm-message"
            >
                {{ alarmMessage }}
            </div>

        </div>


        <!-- =====================================================
             UNIX TIMESTAMP CONVERTER
        ====================================================== -->

        <div class="section-card">

            <div class="section-title">

                <h2>
                    🔢 Unix Timestamp Converter
                </h2>

                <p>
                    Convert Unix timestamps into readable dates.
                </p>

            </div>


            <div class="converter-controls">

                <input
                    type="number"
                    v-model="timestampInput"
                    placeholder="Example: 1757480000"
                >

                <button
                    class="control-button"
                    @click="convertTimestamp"
                >
                    Convert
                </button>

            </div>


            <div
                v-if="timestampResult"
                class="converter-result"
            >

                <strong>
                    {{ timestampResult.datetime }}
                </strong>

                <span>
                    {{ timestampResult.day }}
                </span>

                <span>
                    {{ timestampResult.timezone }}
                </span>

            </div>

        </div>


        <!-- =====================================================
             DATE DIFFERENCE CALCULATOR
        ====================================================== -->

        <div class="section-card">

            <div class="section-title">

                <h2>
                    📅 Date Difference Calculator
                </h2>

                <p>
                    Calculate the difference between two dates.
                </p>

            </div>


            <div class="date-calculator">

                <div>

                    <label>
                        Start Date
                    </label>

                    <input
                        type="date"
                        v-model="startDate"
                    >

                </div>


                <div>

                    <label>
                        End Date
                    </label>

                    <input
                        type="date"
                        v-model="endDate"
                    >

                </div>


                <button
                    class="control-button"
                    @click="calculateDateDifference"
                >
                    Calculate Difference
                </button>

            </div>


            <div
                v-if="dateDifference"
                class="difference-result"
            >

                <div>
                    <strong>
                        {{ dateDifference.total_days }}
                    </strong>
                    <span>
                        Total Days
                    </span>
                </div>

                <div>
                    <strong>
                        {{ dateDifference.total_weeks }}
                    </strong>
                    <span>
                        Total Weeks
                    </span>
                </div>

                <div>
                    <strong>
                        {{ dateDifference.years }}
                    </strong>
                    <span>
                        Years
                    </span>
                </div>

                <div>
                    <strong>
                        {{ dateDifference.months }}
                    </strong>
                    <span>
                        Months
                    </span>
                </div>

                <div>
                    <strong>
                        {{ dateDifference.days }}
                    </strong>
                    <span>
                        Days
                    </span>
                </div>

            </div>

        </div>


        <!-- =====================================================
             API INFORMATION
        ====================================================== -->

        <div class="api-card">

            <h2>
                🔗 Server API Information
            </h2>

            <div class="api-row">
                <span>Current Date</span>
                <code>/current-datetime</code>
            </div>

            <div class="api-row">
                <span>DateTime Information</span>
                <code>/datetime-info</code>
            </div>

            <div class="api-row">
                <span>Timezone</span>
                <code>/timezone-datetime?timezone=Asia/Kolkata</code>
            </div>

            <div class="api-row">
                <span>Format</span>
                <code>/formatted-datetime?format=long_12</code>
            </div>

            <div class="api-row">
                <span>World Clock</span>
                <code>/world-clock</code>
            </div>

            <div class="api-row">
                <span>Timestamp Converter</span>
                <code>/timestamp-converter?timestamp=1757480000</code>
            </div>

            <div class="api-row">
                <span>Date Difference</span>
                <code>/date-difference?start=2026-01-01&end=2026-09-10</code>
            </div>

        </div>

    </div>

</template>


<script>

export default {

    data() {

        return {

            /* =========================================
               SERVER CLOCK
            ========================================= */

            dateTime: '',
            timer: null,

            serverTimezone: '',
            serverDate: '',
            serverDay: '',
            serverMonth: '',
            serverYear: '',

            dayOfYear: 0,
            weekOfYear: 0,
            unixTimestamp: 0,
            isLeapYear: false,

            daysInMonth: 0,
            quarter: 0,
            dayOfWeekNumber: 0,
            isWeekend: false,


            /* =========================================
               TIMEZONE
            ========================================= */

            timezones: [],

            selectedTimezone: 'Asia/Kolkata',

            timezoneDateTime: '',
            timezoneDay: '',
            timezoneOffset: '',


            /* =========================================
               STATUS
            ========================================= */

            apiStatus: false,
            lastSyncTime: '',
            refreshCount: 0,
            responseTime: 0,


            /* =========================================
               FORMAT
            ========================================= */

            selectedFormat: 'long_12',
            formattedDateTime: '',


            /* =========================================
               WORLD CLOCK
            ========================================= */

            worldClocks: [],


            /* =========================================
               AUTO REFRESH
            ========================================= */

            autoRefresh: true,
            refreshInterval: 1000,


            /* =========================================
               BROWSER TIME
            ========================================= */

            browserTime: '',


            /* =========================================
               STOPWATCH
            ========================================= */

            stopwatchSeconds: 0,
            stopwatchTimer: null,
            stopwatchRunning: false,


            /* =========================================
               COUNTDOWN
            ========================================= */

            countdownSeconds: 0,


            /* =========================================
               ALARM
            ========================================= */

            alarmTime: '',
            alarmMessage: '',
            alarmTriggered: false,


            /* =========================================
               TIMESTAMP
            ========================================= */

            timestampInput: '',
            timestampResult: null,


            /* =========================================
               DATE DIFFERENCE
            ========================================= */

            startDate: '',
            endDate: '',
            dateDifference: null,


            /* =========================================
               THEME
            ========================================= */

            currentTheme: 'light-theme',

        };

    },


    computed: {

        selectedFormatLabel() {

            const labels = {

                long_12: 'Long Date - 12 Hour',

                long_24: 'Long Date - 24 Hour',

                short_date: 'Short Date',

                short_datetime_12:
                    'Short Date & Time - 12 Hour',

                short_datetime_24:
                    'Short Date & Time - 24 Hour',

                iso: 'ISO Date & Time',

                readable:
                    'Full Readable Date & Time',

            };

            return labels[this.selectedFormat]
                || 'Selected Format';

        },


        formattedStopwatch() {

            const hours =
                Math.floor(
                    this.stopwatchSeconds / 3600
                );

            const minutes =
                Math.floor(
                    (this.stopwatchSeconds % 3600) / 60
                );

            const seconds =
                this.stopwatchSeconds % 60;

            return [
                hours,
                minutes,
                seconds
            ]
                .map(
                    value =>
                        String(value).padStart(2, '0')
                )
                .join(':');

        },


        countdownToMidnight() {

            const hours =
                Math.floor(
                    this.countdownSeconds / 3600
                );

            const minutes =
                Math.floor(
                    (this.countdownSeconds % 3600) / 60
                );

            const seconds =
                this.countdownSeconds % 60;

            return [
                hours,
                minutes,
                seconds
            ]
                .map(
                    value =>
                        String(value).padStart(2, '0')
                )
                .join(':');

        }

    },


    mounted() {

        this.fetchServerInformation();

        this.fetchTime();

        this.fetchTimezoneTime();

        this.fetchFormattedTime();

        this.fetchWorldClock();

        this.updateBrowserTime();

        this.updateCountdown();

        this.timer = setInterval(
            () => {

                if (this.autoRefresh) {

                    this.fetchTime();

                    this.fetchServerInformation();

                    this.fetchTimezoneTime();

                    this.fetchFormattedTime();

                    this.fetchWorldClock();

                }

                this.updateBrowserTime();

                this.updateCountdown();

                this.checkAlarm();

            },
            this.refreshInterval
        );

    },


    beforeUnmount() {

        clearInterval(this.timer);

        clearInterval(this.stopwatchTimer);

    },


    methods: {


        /* =========================================
           SERVER TIME
        ========================================= */

        async fetchTime() {

            const startTime =
                performance.now();

            try {

                const response =
                    await fetch(
                        '/current-datetime'
                    );

                if (!response.ok) {

                    throw new Error(
                        'Unable to fetch server time'
                    );

                }

                const data =
                    await response.json();

                this.dateTime =
                    data.datetime;

                this.apiStatus = true;

                this.refreshCount++;

                this.lastSyncTime =
                    new Date()
                        .toLocaleTimeString();

                const endTime =
                    performance.now();

                this.responseTime =
                    Math.round(
                        endTime - startTime
                    );

            }

            catch (error) {

                console.error(
                    'Time fetch error:',
                    error
                );

                this.apiStatus = false;

            }

        },


        /* =========================================
           SERVER INFORMATION
        ========================================= */

        async fetchServerInformation() {

            try {

                const response =
                    await fetch(
                        '/datetime-info'
                    );

                const data =
                    await response.json();

                const server =
                    data.server;

                this.serverTimezone =
                    server.timezone;

                this.serverDate =
                    server.date;

                this.serverDay =
                    server.day;

                this.serverMonth =
                    server.month;

                this.serverYear =
                    server.year;

                this.dayOfYear =
                    server.day_of_year;

                this.weekOfYear =
                    server.week_of_year;

                this.unixTimestamp =
                    server.unix_timestamp;

                this.isLeapYear =
                    server.is_leap_year;

                this.daysInMonth =
                    server.days_in_month;

                this.quarter =
                    server.quarter;

                this.dayOfWeekNumber =
                    server.day_of_week_number;

                this.isWeekend =
                    server.weekend;

                if (this.timezones.length === 0) {

                    this.timezones =
                        data.timezones;

                }

            }

            catch (error) {

                console.error(
                    'Server information error:',
                    error
                );

            }

        },


        /* =========================================
           TIMEZONE
        ========================================= */

        async fetchTimezoneTime() {

            try {

                const response =
                    await fetch(
                        `/timezone-datetime?timezone=${encodeURIComponent(
                            this.selectedTimezone
                        )}`
                    );

                const data =
                    await response.json();

                this.timezoneDateTime =
                    data.datetime;

                this.timezoneDay =
                    data.day;

                this.timezoneOffset =
                    data.offset;

            }

            catch (error) {

                console.error(
                    'Timezone error:',
                    error
                );

            }

        },


        /* =========================================
           FORMAT
        ========================================= */

        async fetchFormattedTime() {

            try {

                const response =
                    await fetch(
                        `/formatted-datetime?format=${encodeURIComponent(
                            this.selectedFormat
                        )}`
                    );

                const data =
                    await response.json();

                this.formattedDateTime =
                    data.datetime;

            }

            catch (error) {

                console.error(
                    'Format error:',
                    error
                );

            }

        },


        /* =========================================
           WORLD CLOCK
        ========================================= */

        async fetchWorldClock() {

            try {

                const response =
                    await fetch(
                        '/world-clock'
                    );

                const data =
                    await response.json();

                this.worldClocks =
                    data.cities;

            }

            catch (error) {

                console.error(
                    'World clock error:',
                    error
                );

            }

        },


        /* =========================================
           AUTO REFRESH
        ========================================= */

        toggleAutoRefresh() {

            this.autoRefresh =
                !this.autoRefresh;

        },


        restartTimer() {

            clearInterval(this.timer);

            this.timer =
                setInterval(
                    () => {

                        if (this.autoRefresh) {

                            this.fetchTime();

                            this.fetchServerInformation();

                            this.fetchTimezoneTime();

                            this.fetchFormattedTime();

                            this.fetchWorldClock();

                        }

                        this.updateBrowserTime();

                        this.updateCountdown();

                        this.checkAlarm();

                    },
                    this.refreshInterval
                );

        },


        /* =========================================
           BROWSER TIME
        ========================================= */

        updateBrowserTime() {

            this.browserTime =
                new Date()
                    .toLocaleString();

        },


        /* =========================================
           STOPWATCH
        ========================================= */

        startStopwatch() {

            if (this.stopwatchRunning) {
                return;
            }

            this.stopwatchRunning = true;

            this.stopwatchTimer =
                setInterval(
                    () => {

                        this.stopwatchSeconds++;

                    },
                    1000
                );

        },


        pauseStopwatch() {

            this.stopwatchRunning = false;

            clearInterval(
                this.stopwatchTimer
            );

        },


        resetStopwatch() {

            this.pauseStopwatch();

            this.stopwatchSeconds = 0;

        },


        /* =========================================
           COUNTDOWN TO MIDNIGHT
        ========================================= */

        updateCountdown() {

            const now =
                new Date();

            const midnight =
                new Date(now);

            midnight.setHours(
                24,
                0,
                0,
                0
            );

            this.countdownSeconds =
                Math.max(
                    0,
                    Math.floor(
                        (
                            midnight.getTime()
                            -
                            now.getTime()
                        ) / 1000
                    )
                );

        },


        /* =========================================
           ALARM
        ========================================= */

        setAlarm() {

            if (!this.alarmTime) {

                this.alarmMessage =
                    'Please select an alarm time.';

                return;

            }

            this.alarmTriggered = false;

            this.alarmMessage =
                `Alarm set for ${this.alarmTime}`;

        },


        clearAlarm() {

            this.alarmTime = '';

            this.alarmMessage = '';

            this.alarmTriggered = false;

        },


        checkAlarm() {

            if (
                !this.alarmTime ||
                this.alarmTriggered
            ) {
                return;
            }

            const now =
                new Date();

            const currentTime =
                now.toTimeString()
                    .slice(0, 5);

            if (
                currentTime ===
                this.alarmTime
            ) {

                this.alarmTriggered = true;

                this.alarmMessage =
                    '🔔 Alarm triggered!';

                if (
                    'Notification'
                    in window
                ) {

                    if (
                        Notification.permission
                        === 'granted'
                    ) {

                        new Notification(
                            'Laravel Date & Time Alarm',
                            {
                                body:
                                    'Your alarm time has arrived.'
                            }
                        );

                    }

                }

                alert(
                    '🔔 Alarm triggered!'
                );

            }

        },


        /* =========================================
           TIMESTAMP CONVERTER
        ========================================= */

        async convertTimestamp() {

            if (!this.timestampInput) {

                return;

            }

            try {

                const response =
                    await fetch(
                        `/timestamp-converter?timestamp=${encodeURIComponent(
                            this.timestampInput
                        )}`
                    );

                const data =
                    await response.json();

                if (!data.success) {

                    alert(data.message);

                    return;

                }

                this.timestampResult =
                    data;

            }

            catch (error) {

                console.error(
                    'Timestamp error:',
                    error
                );

            }

        },


        /* =========================================
           DATE DIFFERENCE
        ========================================= */

        async calculateDateDifference() {

            if (
                !this.startDate ||
                !this.endDate
            ) {

                alert(
                    'Please select both dates.'
                );

                return;

            }

            try {

                const response =
                    await fetch(
                        `/date-difference?start=${encodeURIComponent(
                            this.startDate
                        )}&end=${encodeURIComponent(
                            this.endDate
                        )}`
                    );

                const data =
                    await response.json();

                if (!data.success) {

                    alert(data.message);

                    return;

                }

                this.dateDifference =
                    data.difference;

            }

            catch (error) {

                console.error(
                    'Date difference error:',
                    error
                );

            }

        },


        /* =========================================
           COPY
        ========================================= */

        async copyText(text) {

            if (!text) {
                return;
            }

            try {

                await navigator.clipboard.writeText(
                    text
                );

                alert(
                    'Copied successfully!'
                );

            }

            catch (error) {

                console.error(
                    'Copy error:',
                    error
                );

            }

        },


        /* =========================================
           THEME
        ========================================= */

        toggleTheme() {

            this.currentTheme =
                this.currentTheme === 'light-theme'
                    ? 'dark-theme'
                    : 'light-theme';

        }

    }

};

</script>


<style scoped>

* {
    box-sizing: border-box;
}


.datetime-dashboard {

    min-height: 100vh;

    max-width: 1200px;

    margin: 0 auto;

    padding: 30px 20px;

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    transition:
        background 0.3s,
        color 0.3s;

}


/* =====================================================
   LIGHT THEME
===================================================== */

.light-theme {

    background: #f5f7fb;

    color: #1f2937;

}


/* =====================================================
   DARK THEME
===================================================== */

.dark-theme {

    background: #111827;

    color: #f9fafb;

}


/* =====================================================
   HEADER
===================================================== */

.dashboard-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

    margin-bottom: 25px;

}


.dashboard-header h1 {

    margin: 0 0 8px;

    font-size: 32px;

}


.dashboard-header p {

    margin: 0;

    color: #6b7280;

}


.theme-button {

    padding: 10px 18px;

    border: none;

    border-radius: 8px;

    cursor: pointer;

    font-weight: bold;

}


/* =====================================================
   MAIN CLOCK
===================================================== */

.main-clock-card {

    background: white;

    border-radius: 18px;

    padding: 40px;

    text-align: center;

    box-shadow:
        0 10px 30px
        rgba(0, 0, 0, 0.08);

    margin-bottom: 20px;

}


.dark-theme .main-clock-card,
.dark-theme .section-card,
.dark-theme .status-card {

    background: #1f2937;

    color: #f9fafb;

}


.clock-icon {

    font-size: 48px;

}


.main-clock-card h2 {

    margin: 10px 0;

}


.main-time {

    font-size: 42px;

    font-weight: bold;

    margin: 20px 0;

}


.server-timezone {

    color: #6b7280;

}


.copy-button {

    margin-top: 15px;

    padding: 10px 16px;

    border: none;

    border-radius: 8px;

    cursor: pointer;

    background: #e5e7eb;

}


/* =====================================================
   STATUS
===================================================== */

.status-card {

    background: white;

    border-radius: 14px;

    padding: 20px;

    margin-bottom: 20px;

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

    box-shadow:
        0 5px 20px
        rgba(0, 0, 0, 0.06);

}


.status-left {

    display: flex;

    align-items: center;

    gap: 12px;

}


.status-left p {

    margin: 5px 0 0;

    color: #6b7280;

}


.status-dot {

    width: 13px;

    height: 13px;

    border-radius: 50%;

}


.status-dot.online {

    background: #22c55e;

}


.status-dot.offline {

    background: #ef4444;

}


.sync-info {

    display: flex;

    gap: 30px;

}


.sync-info div {

    text-align: center;

}


.sync-info strong {

    display: block;

    font-size: 20px;

}


.sync-info span {

    color: #6b7280;

    font-size: 12px;

}


/* =====================================================
   SECTION
===================================================== */

.section-card {

    background: white;

    border-radius: 16px;

    padding: 25px;

    margin-bottom: 20px;

    box-shadow:
        0 5px 20px
        rgba(0, 0, 0, 0.06);

}


.section-title {

    margin-bottom: 20px;

}


.section-title h2 {

    margin: 0 0 6px;

}


.section-title p {

    margin: 0;

    color: #6b7280;

}


/* =====================================================
   CONTROLS
===================================================== */

.control-grid {

    display: grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap: 20px;

}


.control-grid label,
.format-controls label,
.timezone-controls label,
.alarm-controls label,
.date-calculator label {

    display: block;

    font-weight: bold;

    margin-bottom: 8px;

}


select,
input {

    width: 100%;

    padding: 12px;

    border:
        1px solid #d1d5db;

    border-radius: 8px;

    background: white;

    font-size: 15px;

}


.control-button {

    margin-top: 10px;

    padding: 11px 18px;

    border: none;

    border-radius: 8px;

    cursor: pointer;

    font-weight: bold;

}


.success-button,
.warning-button,
.danger-button {

    border: none;

    padding: 11px 18px;

    border-radius: 8px;

    cursor: pointer;

    font-weight: bold;

}


.success-button {

    background: #22c55e;

    color: white;

}


.warning-button {

    background: #f59e0b;

    color: white;

}


.danger-button {

    background: #ef4444;

    color: white;

}


/* =====================================================
   TIMEZONE
===================================================== */

.timezone-controls {

    margin-bottom: 20px;

}


.timezone-controls select,
.format-controls select {

    max-width: 550px;

}


.timezone-result {

    padding: 25px;

    background: #f3f4f6;

    border-radius: 12px;

    text-align: center;

}


.timezone-name {

    font-size: 18px;

    font-weight: bold;

}


.timezone-time {

    font-size: 30px;

    font-weight: bold;

    margin: 12px 0;

}


.timezone-details {

    display: flex;

    justify-content: center;

    gap: 25px;

    color: #6b7280;

}


/* =====================================================
   WORLD CLOCK
===================================================== */

.world-clock-grid {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 15px;

}


.world-clock-card {

    padding: 22px;

    text-align: center;

    border-radius: 12px;

    background: #f8fafc;

    border: 1px solid #e5e7eb;

}


.dark-theme .world-clock-card,
.dark-theme .info-box,
.dark-theme .comparison-box {

    background: #374151;

    border-color: #4b5563;

}


.city-icon {

    font-size: 30px;

}


.world-clock-card h3 {

    margin: 8px 0;

}


.world-time {

    font-size: 25px;

    font-weight: bold;

}


.world-date {

    margin-top: 5px;

}


.world-day {

    color: #6b7280;

    margin: 5px 0;

}


/* =====================================================
   INFORMATION
===================================================== */

.info-grid {

    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 15px;

}


.info-box {

    padding: 18px;

    border-radius: 10px;

    background: #f8fafc;

    border: 1px solid #e5e7eb;

}


.info-box span {

    display: block;

    color: #6b7280;

    font-size: 13px;

    margin-bottom: 8px;

}


.info-box strong {

    font-size: 18px;

}


/* =====================================================
   FORMAT
===================================================== */

.format-result {

    padding: 30px;

    border-radius: 12px;

    background: #f3f4f6;

    text-align: center;

}


.format-icon {

    font-size: 40px;

}


.format-label {

    color: #6b7280;

    font-weight: bold;

}


.formatted-time {

    font-size: 32px;

    font-weight: bold;

    margin: 15px 0;

}


/* =====================================================
   COMPARISON
===================================================== */

.comparison-grid {

    display: grid;

    grid-template-columns:
        repeat(2, 1fr);

    gap: 20px;

}


.comparison-box {

    padding: 25px;

    background: #f8fafc;

    border: 1px solid #e5e7eb;

    border-radius: 12px;

    text-align: center;

}


.comparison-box span {

    display: block;

    color: #6b7280;

    margin-bottom: 10px;

}


.comparison-box strong {

    font-size: 22px;

}


/* =====================================================
   STOPWATCH
===================================================== */

.stopwatch,
.countdown {

    text-align: center;

    padding: 30px;

    background: #f3f4f6;

    border-radius: 12px;

}


.stopwatch-time,
.countdown-time {

    font-size: 48px;

    font-weight: bold;

    letter-spacing: 2px;

}


.button-group {

    display: flex;

    justify-content: center;

    gap: 10px;

    margin-top: 20px;

}


/* =====================================================
   COUNTDOWN
===================================================== */

.countdown-label {

    margin-top: 10px;

    color: #6b7280;

}


/* =====================================================
   ALARM
===================================================== */

.alarm-controls {

    display: flex;

    align-items: center;

    gap: 12px;

}


.alarm-controls input {

    max-width: 250px;

}


.alarm-message {

    margin-top: 15px;

    padding: 15px;

    border-radius: 8px;

    background: #fef3c7;

    color: #92400e;

    font-weight: bold;

}


/* =====================================================
   TIMESTAMP
===================================================== */

.converter-controls {

    display: flex;

    gap: 12px;

}


.converter-controls input {

    max-width: 500px;

}


.converter-result {

    margin-top: 20px;

    padding: 20px;

    background: #f3f4f6;

    border-radius: 10px;

}


.converter-result strong,
.converter-result span {

    display: block;

    margin-bottom: 8px;

}


/* =====================================================
   DATE DIFFERENCE
===================================================== */

.date-calculator {

    display: grid;

    grid-template-columns:
        1fr 1fr auto;

    align-items: end;

    gap: 15px;

}


.difference-result {

    display: grid;

    grid-template-columns:
        repeat(5, 1fr);

    gap: 12px;

    margin-top: 20px;

}


.difference-result div {

    padding: 18px;

    text-align: center;

    background: #f3f4f6;

    border-radius: 10px;

}


.difference-result strong {

    display: block;

    font-size: 24px;

}


.difference-result span {

    color: #6b7280;

    font-size: 13px;

}


/* =====================================================
   API
===================================================== */

.api-card {

    background: #111827;

    color: white;

    border-radius: 14px;

    padding: 25px;

}


.api-card h2 {

    margin-top: 0;

}


.api-row {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

    padding: 12px 0;

    border-bottom:
        1px solid #374151;

}


.api-row:last-child {

    border-bottom: none;

}


.api-row code {

    background: #1f2937;

    padding: 7px 10px;

    border-radius: 6px;

    color: #d1d5db;

    word-break: break-word;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 900px) {

    .info-grid {

        grid-template-columns:
            repeat(2, 1fr);

    }

    .world-clock-grid {

        grid-template-columns:
            repeat(2, 1fr);

    }

    .difference-result {

        grid-template-columns:
            repeat(3, 1fr);

    }

}


@media (max-width: 700px) {

    .dashboard-header {

        flex-direction: column;

        align-items: flex-start;

    }

    .status-card {

        flex-direction: column;

        align-items: flex-start;

    }

    .control-grid,
    .comparison-grid {

        grid-template-columns: 1fr;

    }

    .date-calculator {

        grid-template-columns: 1fr;

    }

    .alarm-controls,
    .converter-controls {

        flex-direction: column;

        align-items: stretch;

    }

}


@media (max-width: 500px) {

    .datetime-dashboard {

        padding: 15px;

    }

    .main-time {

        font-size: 27px;

    }

    .stopwatch-time,
    .countdown-time {

        font-size: 35px;

    }

    .timezone-time {

        font-size: 22px;

    }

    .formatted-time {

        font-size: 22px;

    }

    .info-grid,
    .world-clock-grid {

        grid-template-columns: 1fr;

    }

    .sync-info {

        flex-direction: column;

        gap: 10px;

    }

    .timezone-details {

        flex-direction: column;

        gap: 5px;

    }

    .button-group {

        flex-direction: column;

    }

    .difference-result {

        grid-template-columns:
            repeat(2, 1fr);

    }

    .api-row {

        flex-direction: column;

        align-items: flex-start;

    }

}

</style>