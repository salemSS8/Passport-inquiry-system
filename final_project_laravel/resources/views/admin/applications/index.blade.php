@extends('layouts.app')

@section('title', 'إدارة الطلبات - جوازات اليمن')
@section('header_title', 'إدارة طلبات جواز السفر')

@section('content')
<div style="margin-block-end: var(--space-lg); display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem;">
    <form action="{{ route('admin.applications.index') }}" method="GET" style="display: flex; flex-wrap: wrap; gap: 1rem; flex: 1;">
        <div style="position: relative; flex: 1; min-width: 250px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث بالاسم أو رقم التتبع..." class="form-input" style="padding-inline-start: 2.5rem;">
            <svg style="position: absolute; inset-inline-start: 0.75rem; top: 0.75rem; width: 1.25rem; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <select name="status" class="form-input" style="width: 150px;" onchange="this.form.submit()">
            <option value="">كل الحالات</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>جاري المعالجة</option>
            <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>جاهز للاستلام</option>
            <option value="collected" {{ request('status') == 'collected' ? 'selected' : '' }}>تم التسليم</option>
        </select>
    </form>
    
    <div style="display: flex; gap: 0.5rem; width: 100%; justify-content: flex-end; margin-top: 0.5rem;" class="mobile-full-width">
        <style>
            @media (min-width: 768px) { .mobile-full-width { width: auto; margin-top: 0; } }
        </style>
        <button class="btn-figma-outline">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            تصدير
        </button>
        <a href="{{ route('admin.applications.create') }}" class="btn-figma-gold" style="text-decoration: none;">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            إضافة جديد
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table-figma">
        <thead>
            <tr>
                <th style="width: 80px;">الرقم</th>
                <th>الاسم الكامل</th>
                <th>رقم التتبع</th>
                <th>الحالة</th>
                <th>الفرع</th>
                <th>آخر تحديث</th>
                <th style="text-align: center;">الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $application)
            <tr>
                <td style="color: var(--text-muted);">#{{ $application->id }}</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 2rem; height: 2rem; border-radius: 50%; background: #F3F4F6; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; color: var(--primary);">
                            {{ substr($application->full_name, 0, 2) }}
                        </div>
                        <span style="font-weight: 600;">{{ $application->full_name }}</span>
                    </div>
                </td>
                <td style="font-family: monospace; font-size: 1.1rem; color: var(--primary);">{{ $application->tracking_number }}</td>
                <td>
                    <span class="status-badge" style="background: {{ 
                        $application->status == 'ready' ? 'rgba(16, 185, 129, 0.1)' : 
                        ($application->status == 'processing' ? 'rgba(59, 130, 246, 0.1)' : 'rgba(200, 165, 95, 0.1)') 
                    }}; color: {{ 
                        $application->status == 'ready' ? '#10B981' : 
                        ($application->status == 'processing' ? '#3B82F6' : 'var(--accent)') 
                    }};">
                        {{ $application->status_label }}
                    </span>
                </td>
                <td>{{ $application->branch->name ?? 'المركز الرئيسي' }}</td>
                <td style="color: var(--text-muted);">{{ $application->updated_at->format('Y/m/d H:i') }}</td>
                <td>
                    <div style="display: flex; justify-content: center; gap: 0.5rem;">
                        <a href="{{ route('admin.applications.show', $application) }}" class="btn" style="padding: 0.4rem; background: #F9FAFB; border: 1px solid #E5E7EB; color: var(--primary); border-radius: 0.4rem;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                        <a href="{{ route('admin.applications.edit', $application) }}" class="btn" style="padding: 0.4rem; background: #F9FAFB; border: 1px solid #E5E7EB; color: var(--accent); border-radius: 0.4rem;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding: 4rem; text-align: center;">
                    <div style="color: var(--text-muted);">
                        <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-block-end: 1rem; opacity: 0.2;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p style="font-size: 1.1rem; font-weight: 600;">لا توجد طلبات تطابق معايير البحث</p>
                        <p style="font-size: 0.9rem;">جرب تغيير كلمة البحث أو حالة الطلب</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-block-start: var(--space-lg); display: flex; justify-content: center;">
    {{ $applications->links() }}
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="search"]');
        const filterForm = searchInput ? searchInput.closest('form') : null;
        let debounceTimer;

        if (searchInput && filterForm) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    filterForm.submit();
                }, 500); // 500ms debounce
            });

            // Focus at end of text
            if (searchInput.value) {
                const len = searchInput.value.length;
                searchInput.focus();
                searchInput.setSelectionRange(len, len);
            }
        }
    });
</script>
@endpush
@endsection
