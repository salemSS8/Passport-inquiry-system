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
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Noto+Sans+Arabic:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header-accent"></div>
    
    @if(auth()->check() && !request()->routeIs('inquiry.*'))
        <div class="admin-layout">
            <div class="sidebar-overlay" id="sidebarOverlay"></div>
            @include('layouts.navigation')
            
            <div class="main-content-figma">
                <header class="mobile-topbar">
                    <button class="hamburger" id="menuToggle">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
                    </button>
                    <h2 class="h3" style="margin: 0;">@yield('header_title', 'لوحة التحكم')</h2>
                    <div style="width: 40px;"></div> <!-- Spacer -->
                </header>

                <header class="topbar-figma desktop-only" style="display: none;">
                    <h2 style="margin: 0;">@yield('header_title', 'لوحة التحكم')</h2>
                </header>

                <main style="padding: var(--space-md);">
                    @yield('content')
                    {{ $slot ?? '' }}
                </main>
            </div>
        </div>
    @else
        <nav class="card" style="margin-bottom: 0; border-radius: 0;">
            <div class="container" style="display: flex; justify-content: space-between; align-items: center; padding-block: var(--space-xs);">
                <div style="display: flex; align-items: center; gap: var(--space-xs);">
                    <img src="/images/logo.png" alt="Emblem" style="height: 40px;">
                    <h3 style="margin: 0; font-size: 1rem;">الجمهورية اليمنية</h3>
                </div>
                <div class="desktop-nav">
                    <a href="{{ route('inquiry.index') }}" class="btn-figma-outline" style="border: none;">الرئيسية</a>
                    <a href="/login" class="btn-figma-gold">دخول الموظفين</a>
                </div>
                <button class="hamburger mobile-only" id="guestMenuToggle" style="display: none;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
                </button>
            </div>
        </nav>

        <main class="main-content">
            <div class="container">
                @yield('content')
                {{ $slot ?? '' }}
            </div>
        </main>
    @endauth

    @guest
    <footer style="text-align: center; padding-block: var(--space-md); color: var(--text-muted); font-size: 0.8rem;">
        <p>مصلحة الهجرة والجوازات والجنسية &copy; {{ date('Y') }}</p>
    </footer>
    @endguest

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.querySelector('.sidebar-figma');
            const overlay = document.getElementById('sidebarOverlay');

            if (menuToggle && sidebar && overlay) {
                menuToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                });

                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
