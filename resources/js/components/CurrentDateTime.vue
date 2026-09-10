<template>

    <div class="datetime-dashboard">


        <!-- =========================================
             Header
        ========================================= -->

        <div class="dashboard-header">

            <h1>
                Laravel Server Date & Time
            </h1>

            <p>
                Live date and time dashboard powered by
                Laravel 12 + Vue 3
            </p>

        </div>


        <!-- =========================================
             Main Server Clock
        ========================================= -->

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

        </div>


        <!-- =========================================
             Synchronization Status
        ========================================= -->

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


        <!-- =========================================
             Multiple Timezone
        ========================================= -->

        <div class="section-card">

            <div class="section-title">

                <div>

                    <h2>
                        🌍 Multiple Timezone Clock
                    </h2>

                    <p>
                        Select a timezone to view its
                        current server-calculated time.
                    </p>

                </div>

            </div>


            <div class="timezone-controls">

                <label for="timezone">
                    Select Timezone
                </label>


                <select
                    id="timezone"
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

                    {{
                        timezoneDateTime ||
                        'Loading...'
                    }}

                </div>


                <div class="timezone-details">

                    <span>
                        📅 {{ timezoneDay }}
                    </span>

                    <span>
                        🕓 UTC {{ timezoneOffset }}
                    </span>

                </div>

            </div>

        </div>


        <!-- =========================================
             Date & Time Information
        ========================================= -->

        <div class="section-card">

            <div class="section-title">

                <div>

                    <h2>
                        📊 Date & Time Information
                    </h2>

                    <p>
                        Detailed information generated
                        by the Laravel server.
                    </p>

                </div>

            </div>


            <div class="info-grid">


                <div class="info-box">

                    <span>
                        📅 Date
                    </span>

                    <strong>
                        {{ serverDate }}
                    </strong>

                </div>


                <div class="info-box">

                    <span>
                        📆 Day
                    </span>

                    <strong>
                        {{ serverDay }}
                    </strong>

                </div>


                <div class="info-box">

                    <span>
                        🗓️ Month
                    </span>

                    <strong>
                        {{ serverMonth }}
                    </strong>

                </div>


                <div class="info-box">

                    <span>
                        📌 Year
                    </span>

                    <strong>
                        {{ serverYear }}
                    </strong>

                </div>


                <div class="info-box">

                    <span>
                        📈 Day of Year
                    </span>

                    <strong>
                        {{ dayOfYear }}
                    </strong>

                </div>


                <div class="info-box">

                    <span>
                        📊 Week of Year
                    </span>

                    <strong>
                        {{ weekOfYear }}
                    </strong>

                </div>


                <div class="info-box">

                    <span>
                        ⏱️ Unix Timestamp
                    </span>

                    <strong>
                        {{ unixTimestamp }}
                    </strong>

                </div>


                <div class="info-box">

                    <span>
                        📐 Leap Year
                    </span>

                    <strong>
                        {{ isLeapYear ? 'Yes' : 'No' }}
                    </strong>

                </div>

            </div>

        </div>


        <!-- =========================================
             NEW FUNCTIONALITY
             Date & Time Format Switcher
        ========================================= -->

        <div class="section-card">

            <div class="section-title">

                <div>

                    <h2>
                        ⏰ Date & Time Format Switcher
                    </h2>

                    <p>
                        Choose how the Laravel server
                        date and time should be displayed.
                    </p>

                </div>

            </div>


            <div class="format-controls">

                <label for="format">
                    Select Date & Time Format
                </label>


                <select
                    id="format"
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


            <!-- Format Result -->

            <div class="format-result">

                <div class="format-icon">
                    ⏱️
                </div>


                <div class="format-label">

                    {{
                        selectedFormatLabel
                    }}

                </div>


                <div class="formatted-time">

                    {{
                        formattedDateTime ||
                        'Loading...'
                    }}

                </div>


                <div class="format-details">

                    <span>

                        🕓 Timezone:

                        <strong>
                            {{ formattedTimezone }}
                        </strong>

                    </span>


                    <span>

                        🔢 Timestamp:

                        <strong>
                            {{ formattedTimestamp }}
                        </strong>

                    </span>

                </div>

            </div>

        </div>


        <!-- =========================================
             API Information
        ========================================= -->

        <div class="api-card">

            <h2>
                🔗 Server API Information
            </h2>


            <div class="api-row">

                <span>
                    Original API
                </span>

                <code>
                    /current-datetime
                </code>

            </div>


            <div class="api-row">

                <span>
                    DateTime Information API
                </span>

                <code>
                    /datetime-info
                </code>

            </div>


            <div class="api-row">

                <span>
                    Timezone API
                </span>

                <code>
                    /timezone-datetime?timezone=Asia/Kolkata
                </code>

            </div>


            <div class="api-row">

                <span>
                    Format API
                </span>

                <code>
                    /formatted-datetime?format=long_12
                </code>

            </div>

        </div>


    </div>

</template>


<script>

export default {

    data() {

        return {


            // =========================================
            // Original Server Clock
            // =========================================

            dateTime: '',

            timer: null,


            // =========================================
            // Server Information
            // =========================================

            serverTimezone: '',

            serverDate: '',

            serverDay: '',

            serverMonth: '',

            serverYear: '',

            dayOfYear: 0,

            weekOfYear: 0,

            unixTimestamp: 0,

            isLeapYear: false,


            // =========================================
            // Multiple Timezone
            // =========================================

            timezones: [],

            selectedTimezone: 'Asia/Kolkata',

            timezoneDateTime: '',

            timezoneDay: '',

            timezoneOffset: '',


            // =========================================
            // Synchronization Status
            // =========================================

            apiStatus: false,

            lastSyncTime: '',

            refreshCount: 0,

            responseTime: 0,


            // =========================================
            // NEW - Date & Time Format Switcher
            // =========================================

            selectedFormat: 'long_12',

            formattedDateTime: '',

            formattedTimezone: '',

            formattedTimestamp: 0,


        }

    },


    /*
    |--------------------------------------------------------------------------
    | Computed Properties
    |--------------------------------------------------------------------------
    */

    computed: {

        selectedFormatLabel() {

            const labels = {

                long_12:
                    'Long Date - 12 Hour',

                long_24:
                    'Long Date - 24 Hour',

                short_date:
                    'Short Date',

                short_datetime_12:
                    'Short Date & Time - 12 Hour',

                short_datetime_24:
                    'Short Date & Time - 24 Hour',

                iso:
                    'ISO Date & Time',

                readable:
                    'Full Readable Date & Time',

            };


            return labels[this.selectedFormat]
                || 'Selected Format';

        }

    },


    /*
    |--------------------------------------------------------------------------
    | Component Mounted
    |--------------------------------------------------------------------------
    */

    mounted() {


        // Fetch initial information

        this.fetchServerInformation();

        this.fetchTime();

        this.fetchTimezoneTime();

        this.fetchFormattedTime();


        /*
        |--------------------------------------------------------------------------
        | Refresh every second
        |--------------------------------------------------------------------------
        */

        this.timer = setInterval(() => {

            this.fetchTime();

            this.fetchServerInformation();

            this.fetchTimezoneTime();

            this.fetchFormattedTime();

        }, 1000);

    },


    /*
    |--------------------------------------------------------------------------
    | Component Destroyed
    |--------------------------------------------------------------------------
    */

    beforeUnmount() {

        clearInterval(this.timer);

    },


    methods: {


        /*
        |--------------------------------------------------------------------------
        | Original Server Date & Time
        |--------------------------------------------------------------------------
        */

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


                this.apiStatus =
                    true;


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


                this.apiStatus =
                    false;

            }

        },


        /*
        |--------------------------------------------------------------------------
        | Server Date & Time Information
        |--------------------------------------------------------------------------
        */

        async fetchServerInformation() {

            try {

                const response =
                    await fetch(
                        '/datetime-info'
                    );


                if (!response.ok) {

                    throw new Error(
                        'Unable to fetch datetime information'
                    );

                }


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


                /*
                |--------------------------------------------------------------------------
                | Load timezone list once
                |--------------------------------------------------------------------------
                */

                if (
                    this.timezones.length === 0
                ) {

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


        /*
        |--------------------------------------------------------------------------
        | Selected Timezone
        |--------------------------------------------------------------------------
        */

        async fetchTimezoneTime() {

            try {

                const response =
                    await fetch(
                        `/timezone-datetime?timezone=${encodeURIComponent(
                            this.selectedTimezone
                        )}`
                    );


                if (!response.ok) {

                    throw new Error(
                        'Unable to fetch timezone time'
                    );

                }


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
                    'Timezone fetch error:',
                    error
                );

            }

        },


        /*
        |--------------------------------------------------------------------------
        | NEW - Date & Time Format
        |--------------------------------------------------------------------------
        */

        async fetchFormattedTime() {

            try {

                const response =
                    await fetch(
                        `/formatted-datetime?format=${encodeURIComponent(
                            this.selectedFormat
                        )}`
                    );


                if (!response.ok) {

                    throw new Error(
                        'Unable to fetch formatted date and time'
                    );

                }


                const data =
                    await response.json();


                this.formattedDateTime =
                    data.datetime;


                this.formattedTimezone =
                    data.timezone;


                this.formattedTimestamp =
                    data.unix_timestamp;

            }


            catch (error) {

                console.error(
                    'Formatted time error:',
                    error
                );

            }

        }

    }

}

</script>


<style scoped>

* {
    box-sizing: border-box;
}


.datetime-dashboard {

    max-width: 1100px;

    margin: 40px auto;

    padding: 20px;

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    color: #1f2937;

    background: #f5f7fb;

}


/* =========================================
   Header
========================================= */

.dashboard-header {

    text-align: center;

    margin-bottom: 25px;

}


.dashboard-header h1 {

    margin-bottom: 8px;

    font-size: 32px;

}


.dashboard-header p {

    margin: 0;

    color: #6b7280;

}


/* =========================================
   Main Clock
========================================= */

.main-clock-card {

    background: white;

    border-radius: 16px;

    padding: 35px;

    text-align: center;

    box-shadow:
        0 8px 25px
        rgba(0, 0, 0, 0.08);

    margin-bottom: 20px;

}


.clock-icon {

    font-size: 45px;

    margin-bottom: 10px;

}


.main-clock-card h2 {

    margin: 5px 0 15px;

}


.main-time {

    font-size: 42px;

    font-weight: bold;

    letter-spacing: 1px;

    margin: 15px 0;

}


.server-timezone {

    color: #6b7280;

}


/* =========================================
   Synchronization Status
========================================= */

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

    font-size: 14px;

}


.status-dot {

    width: 13px;

    height: 13px;

    border-radius: 50%;

    display: inline-block;

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


/* =========================================
   Section Card
========================================= */

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


/* =========================================
   Timezone
========================================= */

.timezone-controls {

    margin-bottom: 20px;

}


.timezone-controls label,
.format-controls label {

    display: block;

    font-weight: bold;

    margin-bottom: 8px;

}


.timezone-controls select,
.format-controls select {

    width: 100%;

    max-width: 500px;

    padding: 12px;

    border: 1px solid #d1d5db;

    border-radius: 8px;

    font-size: 15px;

    background: white;

}


.timezone-result {

    padding: 25px;

    border-radius: 12px;

    background: #f3f4f6;

    text-align: center;

}


.timezone-name {

    font-weight: bold;

    font-size: 18px;

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


/* =========================================
   Information Grid
========================================= */

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


/* =========================================
   NEW - Format Switcher
========================================= */

.format-controls {

    margin-bottom: 20px;

}


.format-result {

    padding: 30px;

    border-radius: 12px;

    background: #f3f4f6;

    text-align: center;

}


.format-icon {

    font-size: 40px;

    margin-bottom: 8px;

}


.format-label {

    color: #6b7280;

    font-size: 14px;

    font-weight: bold;

    margin-bottom: 10px;

}


.formatted-time {

    font-size: 32px;

    font-weight: bold;

    margin: 15px 0;

    word-break: break-word;

}


.format-details {

    display: flex;

    justify-content: center;

    gap: 30px;

    color: #6b7280;

    font-size: 14px;

}


.format-details strong {

    color: #1f2937;

}


/* =========================================
   API Card
========================================= */

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


/* =========================================
   Responsive
========================================= */

@media (max-width: 800px) {

    .info-grid {

        grid-template-columns:
            repeat(2, 1fr);

    }


    .status-card {

        flex-direction: column;

        align-items: flex-start;

    }

}


@media (max-width: 600px) {

    .format-details {

        flex-direction: column;

        gap: 8px;

    }

}


@media (max-width: 500px) {

    .main-time {

        font-size: 27px;

    }


    .timezone-time {

        font-size: 22px;

    }


    .formatted-time {

        font-size: 22px;

    }


    .info-grid {

        grid-template-columns: 1fr;

    }


    .timezone-details {

        flex-direction: column;

        gap: 5px;

    }


    .api-row {

        flex-direction: column;

        align-items: flex-start;

    }

}

</style>