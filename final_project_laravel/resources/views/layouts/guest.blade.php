<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'نظام الاستعلام عن الجوازات') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Cairo', sans-serif;
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0;
                padding: 20px;
            }

            .glass-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
                border-radius: 24px;
                width: 100%;
                max-width: 440px;
                padding: 40px;
                position: relative;
                overflow: hidden;
            }

            .auth-logo {
                width: 100px;
                height: auto;
                margin-bottom: 24px;
                filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
            }

            .accent-line {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--accent) 0%, #d97706 100%);
            }
        </style>
    </head>
    <body>
        <div class="glass-card">
            <div class="accent-line"></div>
            
            <div style="display: flex; justify-content: center; margin-bottom: 32px;">
                <a href="/">
                    <img src="/images/logo.png" alt="Logo" class="auth-logo" style="margin-bottom: 0;">
                </a>
            </div>

            {{ $slot }}
        </div>
    </body>
</html>
