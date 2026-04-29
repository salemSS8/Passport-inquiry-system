@extends('layouts.app')

@section('title', 'لوحة التحكم - جوازات اليمن')
@section('header_title', 'لوحة التحكم الإحصائية')

@section('content')
    <div class="welcome-header" style="margin-block-end: var(--space-lg);">
        <h1 style="font-size: 1.75rem; font-weight: 800; color: var(--primary); margin: 0;">مرحباً بك،
            {{ Auth::user()->name }}</h1>
        <p style="color: var(--text-muted); margin-block-start: 4px;">آخر دخول لك كان:
            {{ now()->subHours(2)->format('Y-m-d h:i A') }}</p>
    </div>

    <!-- Statistics Grid (Bento) -->
    <div class="bento-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg style="inline-size: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ \App\Models\PassportApplication::count() }}</div>
                <div class="stat-label">إجمالي الطلبات</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1); color: #3B82F6;">
                <svg style="inline-size: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <div class="stat-value">
                    {{ \App\Models\PassportApplication::whereIn('status', ['pending', 'processing'])->count() }}</div>
                <div class="stat-label">قيد المعالجة</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">
                <svg style="inline-size: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ \App\Models\PassportApplication::where('status', 'ready')->count() }}</div>
                <div class="stat-label">جاهزة للاستلام</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">
                <svg style="inline-size: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                    </path>
                </svg>
            </div>
            <div>
                <div class="stat-value">{{ \App\Models\PassportApplication::where('status', 'collected')->count() }}</div>
                <div class="stat-label">تم التسليم</div>
            </div>
        </div>
    </div>

    <div class="grid grid-2" style="gap: var(--space-lg); align-items: start;">
        <!-- Recent Activity -->
        <div class="table-container">
            <div
                style="padding: 24px; border-block-end: 1px solid #E5E7EB; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 1.1rem; color: var(--primary);">آخر الطلبات المضافة</h3>
                <a href="{{ route('admin.applications.index') }}"
                    style="color: var(--accent); font-weight: 600; text-decoration: none; font-size: 0.9rem;">عرض الكل</a>
            </div>
            <table class="table-figma">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (\App\Models\PassportApplication::latest()->take(5)->get() as $app)
                        <tr>
                            <td style="font-weight: 600;">{{ $app->full_name }}</td>
                            <td>
                                <span class="status-badge"
                                    style="background: {{ $app->status == 'ready' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(200, 165, 95, 0.1)' }}; color: {{ $app->status == 'ready' ? '#10B981' : 'var(--accent)' }};">
                                    {{ $app->status_label }}
                                </span>
                            </td>
                            <td style="color: var(--text-muted);">{{ $app->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Quick Actions -->
       <div class="card" style="box-sizing: border-box;">
    <div class="card-actions">

        <a href="{{ route('admin.applications.create') }}" class="btn-figma-gold"
            style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 0.7rem; border-radius: 8px; text-decoration: none; width: 100%; box-sizing: border-box;">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span style="font-size: 0.85rem; font-weight: 600;">إضافة طلب جديد</span>
        </a>

        <button class="btn-figma-outline"
            style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 0.7rem; border-radius: 8px; background: #F9FAFB; border: 1px solid #E5E7EB; width: 100%; cursor: pointer; box-sizing: border-box;">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
            </svg>
            <span style="font-size: 0.85rem; font-weight: 600; color: #374151;">تصدير تقرير إحصائي</span>
        </button>

    </div>
</div>
    </div>
    </div>
@endsection
