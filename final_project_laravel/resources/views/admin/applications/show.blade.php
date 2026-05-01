@extends('layouts.app')

@section('title', 'تفاصيل الطلب - جوازات اليمن')
@section('header_title', 'تفاصيل ملف مقدم الطلب')

@section('content')
<div style="max-inline-size: 1100px; margin-inline: auto;">
    <div style="margin-block-end: var(--space-lg); display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: var(--space-md);">
            <div style="inline-size: 64px; block-size: 64px; border-radius: 50%; background: var(--accent); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 900;">
                {{ substr($application->full_name, 0, 2) }}
            </div>
            <div>
                <h1 style="margin: 0; font-size: 1.5rem; color: var(--primary);">{{ $application->full_name }}</h1>
                <p style="margin: 0; color: var(--text-muted);">رقم التتبع: <span style="font-weight: 700; color: var(--accent);">{{ $application->tracking_number }}</span></p>
            </div>
        </div>
        <div style="display: flex; gap: var(--space-sm);">
            <a href="{{ route('admin.applications.edit', $application) }}" class="btn" style="background: white; border: 1px solid #D1D5DB; padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; color: var(--primary);">تعديل البيانات</a>
            <button class="btn btn-primary" style="padding: 10px 20px; border-radius: 8px; font-weight: 600;">طباعة الإيصال</button>
        </div>
    </div>

    <div class="form-grid">
        <!-- Main Data -->
        <div style="display: flex; flex-direction: column; gap: var(--space-lg);">
            <div class="form-card">
                <h3 style="margin-block-end: 24px; color: var(--primary); font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                    <svg style="inline-size: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100 4 2 2 0 000-4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                    المعلومات الشخصية
                </h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div>
                        <label style="display: block; font-size: 0.8rem; color: var(--text-muted); margin-block-end: 4px;">الاسم الرباعي</label>
                        <p style="font-weight: 700; margin: 0;">{{ $application->full_name }}</p>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.8rem; color: var(--text-muted); margin-block-end: 4px;">اسم الأم</label>
                        <p style="font-weight: 700; margin: 0;">{{ $application->mother_name ?? '---' }}</p>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.8rem; color: var(--text-muted); margin-block-end: 4px;">الرقم الوطني</label>
                        <p style="font-weight: 700; margin: 0; font-family: monospace; font-size: 1.1rem;">{{ $application->national_id }}</p>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.8rem; color: var(--text-muted); margin-block-end: 4px;">تاريخ الميلاد</label>
                        <p style="font-weight: 700; margin: 0;">{{ $application->date_of_birth ? $application->date_of_birth->format('Y/m/d') : '---' }}</p>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.8rem; color: var(--text-muted); margin-block-end: 4px;">الجنس</label>
                        <p style="font-weight: 700; margin: 0;">{{ $application->gender == 'male' ? 'ذكر' : 'أنثى' }}</p>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.8rem; color: var(--text-muted); margin-block-end: 4px;">الفرع المختار</label>
                        <p style="font-weight: 700; margin: 0;">{{ $application->branch->name ?? '---' }}</p>
                    </div>
                </div>
                <div style="margin-block-start: 24px;">
                    <label style="display: block; font-size: 0.8rem; color: var(--text-muted); margin-block-end: 4px;">العنوان</label>
                    <p style="font-weight: 700; margin: 0;">{{ $application->address ?? '---' }}</p>
                </div>
            </div>

            <!-- Status History -->
            <div class="form-card">
                <h3 style="margin-block-end: 24px; color: var(--primary); font-size: 1.1rem;">سجل الحالات</h3>
                <div class="timeline-figma">
                    @foreach($application->statusUpdates as $update)
                    <div class="timeline-step">
                        <div class="timeline-dot active">
                            <svg style="inline-size: 14px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <h4 style="margin: 0; font-size: 1rem; color: var(--primary);">{{ \App\Models\PassportApplication::STATUS_LABELS[$update->status] ?? $update->status }}</h4>
                                <p style="margin: 4px 0 0 0; font-size: 0.85rem; color: var(--text-muted);">{{ $update->comment }}</p>
                            </div>
                            <span style="font-size: 0.75rem; color: var(--placeholder);">{{ $update->created_at->format('Y/m/d h:i A') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div style="display: flex; flex-direction: column; gap: var(--space-lg);">
            <div class="form-card" style="padding: 24px; text-align: center;">
                @if($application->photo_path)
                    <img src="{{ asset('storage/' . $application->photo_path) }}" alt="Applicant" style="inline-size: 100%; aspect-ratio: 4/6; object-fit: cover; border-radius: 12px; box-shadow: var(--shadow-md);">
                @else
                    <div style="inline-size: 100%; aspect-ratio: 4/6; background: #F3F4F6; border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--placeholder);">
                        <svg style="inline-size: 48px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p style="margin-block-start: 12px; font-size: 0.85rem;">لا توجد صورة</p>
                    </div>
                @endif
                <p style="margin-block-start: 16px; font-weight: 700; color: var(--primary);">صورة مقدم الطلب</p>
            </div>

            <div class="form-card" style="padding: 24px; background: var(--primary); color: white;">
                <h3 style="color: white; margin: 0 0 16px 0; font-size: 1rem;">تحديث الحالة بسرعة</h3>
                <form action="{{ route('admin.applications.update-status', $application) }}" method="POST">
                    @csrf
                    <select name="status" class="form-input" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: white; margin-block-end: 16px;">
                        <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="processing" {{ $application->status == 'processing' ? 'selected' : '' }}>جاري المعالجة</option>
                        <option value="ready" {{ $application->status == 'ready' ? 'selected' : '' }}>جاهز للاستلام</option>
                        <option value="collected" {{ $application->status == 'collected' ? 'selected' : '' }}>تم التسليم</option>
                    </select>
                    <textarea name="comment" class="form-input" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: white; margin-block-end: 16px; block-size: 80px;" placeholder="أضف ملاحظة..."></textarea>
                    <button type="submit" class="btn-figma-gold" style="inline-size: 100%; block-size: 48px; font-size: 1rem;">تحديث</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
