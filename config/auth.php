<?php

return [

    // 🌟 DEFAULT GUARD DAN PASSWORD BROKER
    'default' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],


    // 🛡️ DEFINISI GUARD
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // 🔐 Tambahan jika pakai Laravel Sanctum untuk API
        'api' => [
            'driver' => 'sanctum',
            'provider' => 'users',
        ],
    ],

    // 👥 DEFINISI PROVIDER USER
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,

        ],

        // Kalau pakai manual DB driver (tidak disarankan)
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    // 🔐 PENGATURAN RESET PASSWORD
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    // ⏳ WAKTU KONFIRMASI ULANG PASSWORD (SESSION UI)
    'password_timeout' => 10800,

];
