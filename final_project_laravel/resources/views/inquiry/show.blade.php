@extends('layouts.app')

@section('title', 'حالة الجواز')

@section('content')
<div class="mobile-container">
    <!-- Top Bar -->
    <div style="background: white; border-bottom: 1px solid #f9fafb; padding: 16px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 10;">
        <div style="flex: 1; text-align: center; padding-inline-start: 40px;">
            <h2 style="font-family: var(--cairo); font-weight: 700; font-size: 20px; color: #0f172a; margin: 0;">حالة الجواز</h2>
        </div>
        <a href="{{ route('inquiry.index') }}" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; text-decoration: none; color: var(--primary);">
            <svg width="34" height="28" viewBox="0 0 28 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 11L13 17L19 23" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    </div>

    @if($application)
    <div style="padding: 20px;">
        <!-- Status Card -->
        <div class="status-card" style="margin-block-end: 56px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-block-end: 16px;">
                <div class="status-badge">محدث الآن</div>
                <div style="color: #64748b; font-family: var(--cairo); font-weight: 700; font-size: 12px; text-transform: uppercase;">الحالة الحالية</div>
            </div>
            
            <div style="color: var(--accent); font-family: var(--cairo); font-weight: 700; font-size: 20px; text-align: right; margin-block-end: 12px;">
                {{ $application->status_label }}
            </div>

            <div style="display: flex; align-items: center; gap: 8px; margin-block-end: 16px;">
                <svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 21C9 21 16 13.5 16 8C16 4.13401 12.866 1 9 1C5.13401 1 2 4.13401 2 8C2 13.5 9 21 9 21Z" stroke="currentColor" stroke-width="2"/>
                </svg>
                <div style="color: #0f172a; font-family: var(--cairo); font-weight: 600; font-size: 14px;">
                    مكان التسليم: {{ $application->pickupBranch->name ?? $application->branch->name }}
                </div>
            </div>

            <!-- Mini Map Placeholder -->
            <div style="block-size: 128px; background: #eee; border-radius: 8px; position: relative; overflow: hidden; background-image: url('https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/44.2075,15.3503,13/366x128?access_token=pk.placeholder'); background-size: cover;">
                <div style="position: absolute; inset: 0; background: linear-gradient(0deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0) 100%);"></div>
                <div style="position: absolute; bottom: 12px; inset-inline-end: 12px; display: flex; align-items: center; gap: 4px; color: white; font-family: var(--cairo); font-weight: 700; font-size: 12px;">
                    عرض في الخريطة
                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 1L1 4L1 12L7 15L13 12L13 4L7 1Z" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Timeline Section -->
        <div style="padding-inline: 4px;">
            <h3 style="font-family: var(--cairo); font-weight: 700; font-size: 18px; color: #0f172a; text-align: right; margin-block-end: 24px;">سجل التتبع</h3>
            
            <div class="timeline-figma">
                @php
                    $steps = [
                        ['id' => 'printed', 'label' => 'تمت الطباعة'],
                        ['id' => 'waiting', 'label' => 'في انتظار الترحيل'],
                        ['id' => 'arrived', 'label' => 'وصل الفرع'],
                        ['id' => 'delivered', 'label' => 'تم التسليم'],
                    ];
                    
                    // Basic mapping logic for demo - in production this would be more robust
                    $currentStatus = $application->status;
                    $completedSteps = [];
                    if (str_contains($currentStatus, 'تمت الطباعة')) $completedSteps = ['printed'];
                    if (str_contains($currentStatus, 'انتظار') || str_contains($currentStatus, 'ترحيل')) $completedSteps = ['printed', 'waiting'];
                    if (str_contains($currentStatus, 'وصل') || str_contains($currentStatus, 'جاهز')) $completedSteps = ['printed', 'waiting', 'arrived'];
                    if (str_contains($currentStatus, 'تسليم') || str_contains($currentStatus, 'استلام')) $completedSteps = ['printed', 'waiting', 'arrived', 'delivered'];
                @endphp

                @foreach($steps as $index => $step)
                    <div class="timeline-step">
                        <div class="timeline-dot {{ in_array($step['id'], $completedSteps) ? 'active' : '' }} {{ end($completedSteps) == $step['id'] ? 'current' : '' }}">
                            @if(in_array($step['id'], $completedSteps))
                                <svg width="18" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            @else
                                <div style="width: 8px; height: 8px; background: #d1d5db; border-radius: 50%;"></div>
                            @endif
                        </div>
                        
                        <div style="text-align: right;">
                            <div style="font-family: var(--cairo); font-weight: 700; font-size: 16px; color: {{ in_array($step['id'], $completedSteps) ? 'var(--accent)' : '#0f172a' }};">
                                {{ $step['label'] }}
                            </div>
                            <div style="font-size: 14px; color: #9ca3af;">
                                @php
                                    $update = $application->statusUpdates->first(fn($u) => str_contains($u->status, $step['label']));
                                @endphp
                                {{ $update ? $update->created_at->format('d/m/Y') : '--/--/----' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Bottom Action Bar -->
    @if(str_contains($application->status, 'جاهز للاستلام'))
    <div style="background: rgba(255,255,255,0.95); border-top: 1px solid #f3f4f6; padding: 16px; position: sticky; bottom: 0; backdrop-filter: blur(2px);">
        <button class="btn-figma-gold" style="border-radius: 12px; height: 56px;">
            حجز موعد للاستلام
        </button>
    </div>
    @endif

    @else
    <div style="padding: 100px 20px; text-align: center;">
        <div style="font-size: 64px; margin-block-end: 24px;">🔍</div>
        <h3 style="font-family: var(--cairo); font-weight: 700;">لم يتم العثور على نتائج</h3>
        <p style="color: var(--text-muted);">يرجى التأكد من الرقم والمحاولة مرة أخرى</p>
        <a href="{{ route('inquiry.index') }}" class="btn-figma-gold" style="margin-block-start: 24px; text-decoration: none;">عودة للبحث</a>
    </div>
    @endif
</div>
@endsection
