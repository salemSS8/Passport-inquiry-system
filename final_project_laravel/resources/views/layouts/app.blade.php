<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'نظام الاستعلام عن الجوازات'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header-accent"></div>
    
    @auth
        <div class="admin-layout">
            @include('layouts.navigation')
            
            <div class="main-content-wrapper">
                <header class="topbar-figma">
                    <div style="display: flex; align-items: center; gap: var(--space-md);">
                        <h2 style="margin: 0; font-size: 1.25rem;">@yield('header_title', 'لوحة التحكم')</h2>
                    </div>
                    <div style="display: flex; align-items: center; gap: var(--space-md);">
                        <div style="position: relative;">
                            <input type="text" placeholder="بحث سريع..." class="form-input" style="inline-size: 300px; padding-inline-start: 40px;">
                            <svg style="position: absolute; inset-inline-start: 12px; top: 12px; inline-size: 20px; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <button class="btn btn-primary" style="padding: 10px 20px; border-radius: 8px;">دعم فني</button>
                    </div>
                </header>

                <main style="padding: var(--space-lg) var(--space-xl);">
                    @yield('content')
                    {{ $slot ?? '' }}
                </main>
            </div>
        </div>
    @else
        <div class="header-accent"></div>
        <nav class="card" style="margin-bottom: 0; border-radius: 0; padding: var(--space-sm) var(--space-md);">
            <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: var(--space-sm);">
                    <img src="/images/logo.png" alt="Emblem" style="block-size: 50px;">
                    <h3 style="margin: 0;">الجمهورية اليمنية</h3>
                </div>
                <div>
                    <a href="{{ route('inquiry.index') }}" style="text-decoration: none; color: var(--primary); font-weight: 600;">الرئيسية</a>
                    <a href="/login" style="margin-inline-start: var(--space-md); text-decoration: none; color: var(--primary);">دخول الموظفين</a>
                </div>
            </div>
        </nav>

        <main class="main-content">
            <div class="container" style="max-inline-size: 1200px; margin-inline: auto; padding: var(--space-lg);">
                @yield('content')
                {{ $slot ?? '' }}
            </div>
        </main>
    @endauth

    @guest
    <footer style="text-align: center; padding-block: var(--space-lg); color: var(--text-muted);">
        <p>مصلحة الهجرة والجوازات والجنسية &copy; {{ date('Y') }}</p>
    </footer>
    @endguest
</body>
</html>
</body>
</html>
