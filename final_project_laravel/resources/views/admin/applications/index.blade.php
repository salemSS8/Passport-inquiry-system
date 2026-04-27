@extends('layouts.app')

@section('title', 'إدارة الطلبات - جوازات اليمن')
@section('header_title', 'إدارة طلبات جواز السفر')

@section('content')
<div style="margin-block-end: var(--space-lg); display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; gap: var(--space-md);">
        <div style="position: relative;">
            <input type="text" placeholder="بحث بالاسم أو رقم التتبع..." class="form-input" style="inline-size: 350px; padding-inline-start: 40px;">
            <svg style="position: absolute; inset-inline-start: 12px; top: 12px; inline-size: 20px; color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <select class="form-input" style="inline-size: 180px;">
            <option value="">كل الحالات</option>
            <option value="pending">قيد الانتظار</option>
            <option value="processing">جاري المعالجة</option>
            <option value="ready">جاهز للاستلام</option>
            <option value="collected">تم التسليم</option>
        </select>
    </div>
    
    <div style="display: flex; gap: var(--space-sm);">
        <button class="btn" style="background: #F3F4F6; color: var(--primary); padding: 10px 20px; border-radius: 8px; font-weight: 600; border: 1px solid #E5E7EB;">
            <svg style="inline-size: 20px; margin-inline-end: 8px; vertical-align: middle;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            تصدير PDF
        </button>
        <a href="{{ route('admin.applications.create') }}" class="btn-figma-gold" style="padding-inline: 24px; text-decoration: none;">
            <svg style="inline-size: 20px; margin-inline-end: 8px; vertical-align: middle;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            إضافة طلب جديد
        </a>
    </div>
</div>

<div class="table-container">
    <table class="table-figma">
        <thead>
            <tr>
                <th style="inline-size: 80px;">الرقم</th>
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
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="inline-size: 32px; block-size: 32px; border-radius: 50%; background: #F3F4F6; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; color: var(--primary);">
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
                        {{ $application->status }}
                    </span>
                </td>
                <td>{{ $application->branch->name ?? 'المركز الرئيسي' }}</td>
                <td style="color: var(--text-muted);">{{ $application->updated_at->format('Y/m/d H:i') }}</td>
                <td>
                    <div style="display: flex; justify-content: center; gap: 8px;">
                        <a href="{{ route('admin.applications.show', $application) }}" class="btn" style="padding: 6px; background: #F9FAFB; border: 1px solid #E5E7EB; color: var(--primary);">
                            <svg style="inline-size: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                        <a href="#" class="btn" style="padding: 6px; background: #F9FAFB; border: 1px solid #E5E7EB; color: var(--accent);">
                            <svg style="inline-size: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding: 100px; text-align: center;">
                    <div style="color: var(--text-muted);">
                        <svg style="inline-size: 64px; margin-block-end: 16px; opacity: 0.2;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p style="font-size: 1.1rem; font-weight: 600;">لا توجد طلبات تطابق معايير البحث</p>
                        <p style="font-size: 0.9rem;">جرب تغيير كلمة البحث أو حالة الطلب</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-block-start: var(--space-lg);">
    {{ $applications->links() }}
</div>
@endsection
