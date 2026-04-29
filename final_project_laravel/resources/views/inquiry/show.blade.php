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

            <!-- Mini Map Section -->
            <div style="block-size: 140px; background: #e2e8f0; border-radius: 12px; position: relative; overflow: hidden; border: 1px solid #e5e7eb;">
                <div style="position: absolute; inset: 0; background-image: url('https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?auto=format&fit=crop&q=80&w=600&h=200'); background-size: cover; background-position: center; filter: grayscale(0.2) brightness(0.9);"></div>
                <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(15, 23, 42, 0.8), transparent);"></div>
                
                <div style="position: absolute; bottom: 12px; inset-inline: 12px; display: flex; justify-content: space-between; align-items: flex-end;">
                    <div style="color: white;">
                        <div style="font-family: var(--cairo); font-size: 12px; font-weight: 700; opacity: 0.9;">موقع الاستلام</div>
                        <div style="font-family: var(--cairo); font-size: 14px; font-weight: 800;">{{ $application->pickupBranch->name ?? $application->branch->name }}</div>
                    </div>
                    <a href="https://www.google.com/maps/search/{{ urlencode(($application->pickupBranch->name ?? $application->branch->name) . ' اليمن') }}" target="_blank" style="background: white; color: var(--primary); padding: 6px 12px; border-radius: 20px; font-family: var(--cairo); font-weight: 800; font-size: 11px; text-decoration: none; display: flex; align-items: center; gap: 4px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        عرض في الخريطة
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Timeline Section -->
        <div style="padding-inline: 4px;">
            <h3 style="font-family: var(--cairo); font-weight: 700; font-size: 18px; color: #0f172a; text-align: right; margin-block-end: 24px;">سجل التتبع</h3>
            
            <div class="timeline-figma">
                @php
                    $steps = [
                        ['id' => 'pending', 'label' => 'استلام الطلب'],
                        ['id' => 'processing', 'label' => 'جاري المعالجة'],
                        ['id' => 'ready', 'label' => 'جاهز للاستلام'],
                        ['id' => 'collected', 'label' => 'تم التسليم'],
                    ];
                    
                    $statusOrder = ['pending', 'processing', 'ready', 'collected', 'cancelled', 'archived'];
                    $currentIndex = array_search($application->status, $statusOrder);
                    $completedSteps = array_slice($statusOrder, 0, ($currentIndex !== false ? $currentIndex + 1 : 0));
                @endphp

                @foreach($steps as $index => $step)
                    <div class="timeline-step">
                        <div class="timeline-dot {{ in_array($step['id'], $completedSteps) ? 'active' : '' }} {{ $application->status == $step['id'] ? 'current' : '' }}">
                            @if(in_array($step['id'], $completedSteps))
                                <svg width="18" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            @else
                                <div style="width: 8px; height: 8px; background: #d1d5db; border-radius: 50%;"></div>
                            @endif
                        </div>
                        
                        <div style="text-align: right; flex: 1;">
                            <div style="font-family: var(--cairo); font-weight: 700; font-size: 16px; color: {{ in_array($step['id'], $completedSteps) ? 'var(--accent)' : '#0f172a' }};">
                                {{ $step['label'] }}
                            </div>
                            <div style="font-size: 14px; color: #9ca3af;">
                                @php
                                    $update = $application->statusUpdates->where('status', $step['id'])->first();
                                @endphp
                                {{ $update ? $update->created_at->format('Y/m/d') : '--/--/----' }}
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
