# PHP_Laravel12_Get_Current_Date_And_Time_using_Vue

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel">
  <img src="https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vue.js">
  <img src="https://img.shields.io/badge/Vite-Build-blueviolet?style=for-the-badge&logo=vite">
  <img src="https://img.shields.io/badge/Timezone-Asia%2FKolkata-success?style=for-the-badge">
</p>

---

##  Overview

This project demonstrates how to **fetch the current server date and time from Laravel 12**
and display it **live on the frontend using Vue.js (Vue 3)**.

The datetime is generated on the **Laravel backend** (server-side),
so it always respects the **server timezone** and not the client machine time.


---

##  Features

- Laravel 12 backend
- Vue 3 frontend (Vite)
- Live server date & time
- API-based data fetch
- Auto refresh every second
- Timezone support (Asia/Kolkata)
- Beginner friendly

---

##  Folder Structure

```text
laravel-vue-datetime/
│
├── app/
├── bootstrap/
├── config/
│   └── app.php
│
├── resources/
│   └── js/
│       ├── app.js
│       └── components/
│           └── CurrentDateTime.vue
│
├── routes/
│   └── web.php
│
├── .env
├── package.json
├── vite.config.js
└── README.md
```

---

##  STEP 1: Create New Laravel Project

```bash
composer create-project laravel/laravel laravel-vue-datetime
```

---

##  STEP 2: .env File 

```env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

APP_TIMEZONE=Asia/Kolkata
```

Run:

```bash
php artisan config:clear
php artisan config:cache
```

---

##  STEP 3: Install Node Modules

```bash
npm install

npm install vue@3

npm install @vitejs/plugin-vue --save-dev
```

---

##  STEP 4: Vite Configuration

 `vite.config.js`

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
});
```

---

##  STEP 5: Set Timezone (Laravel)

 `config/app.php`

```php
'timezone' => 'Asia/Kolkata',
```

---

##  STEP 6: Create Route (Server DateTime)

 `routes/web.php`

```php
use Illuminate\Support\Facades\Route;

Route::get('/current-datetime', function () {
    return response()->json([
        'datetime' => now()->format('d F Y, h:i:s A')
    ]);
});
```

---

##  STEP 7: Vue Component

 `resources/js/components/CurrentDateTime.vue`

```vue
<template>
    <div>
        <h3>Server Date & Time</h3>
        <p>{{ dateTime }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            dateTime: ''
        }
    },
    mounted() {
        this.fetchTime();
        this.timer = setInterval(this.fetchTime, 1000);
    },
    beforeUnmount() {
        clearInterval(this.timer);
    },
    methods: {
        fetchTime() {
            fetch('/current-datetime')
                .then(res => res.json())
                .then(data => {
                    this.dateTime = data.datetime;
                });
        }
    }
}
</script>
```

---

##  STEP 8: Register Vue App

 `resources/js/app.js`

```js
import { createApp } from 'vue';
import CurrentDateTime from './components/CurrentDateTime.vue';

createApp({})
    .component('current-date-time', CurrentDateTime)
    .mount('#app');
```

---

##🟢 STEP 9: Run Project

Terminal 1:

```bash
php artisan serve
```

Terminal 2:

```bash
npm run dev
```

Open in browser:

```text
http://127.0.0.1:8000/current-datetime
```

---

##  Final Output

```text
26 December 2025, 11:51:24 AM
```
<img width="434" height="152" alt="Screenshot 2025-12-26 115132" src="https://github.com/user-attachments/assets/a915a44c-cdfc-4777-93d5-9ffb94fcfb4e" />

---
