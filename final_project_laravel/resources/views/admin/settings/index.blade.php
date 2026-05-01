@extends('layouts.app')

@section('title', 'إعدادات النظام - جوازات اليمن')
@section('header_title', 'تهيئة إعدادات النظام العام')

@section('content')
<div style="max-inline-size: 800px; margin-inline: auto;">
    <div class="form-card">
        <h3 style="margin-block-end: 24px; color: var(--primary); display: flex; align-items: center; gap: 8px;">
            <svg style="inline-size: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m10 0a2 2 0 100-4m0 4a2 2 0 110-4M14 4h6m4 0h6m-30 8h6m4 0h12m4 0h6m-30 8h6m4 0h12m4 0h6"></path></svg>
            إعدادات الموقع العامة
        </h3>

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-block-end: 24px;">
                <div class="form-group">
                    <label>اسم النظام</label>
                    <input type="text" class="form-input" value="مصلحة الهجرة والجوازات - نظام الاستعلامات" disabled>
                </div>
                <div class="form-group">
                    <label>رابط الموقع</label>
                    <input type="text" class="form-input" value="passport-yemen.gov.ye" disabled>
                </div>
            </div>

            <div class="form-group" style="margin-block-end: 24px;">
                <label>تفعيل وضع الصيانة</label>
                <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: #F9FAFB; border-radius: 8px;">
                    <input type="checkbox" id="maintenance" style="inline-size: 20px; block-size: 20px; accent-color: var(--accent);">
                    <label for="maintenance" style="margin: 0; font-weight: 600;">تعطيل الموقع للعامة مؤقتاً</label>
                </div>
            </div>

            <div class="form-group" style="margin-block-end: 32px;">
                <label>إشعارات البريد</label>
                <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: #F9FAFB; border-radius: 8px;">
                    <input type="checkbox" id="notifications" checked style="inline-size: 20px; block-size: 20px; accent-color: var(--accent);">
                    <label for="notifications" style="margin: 0; font-weight: 600;">إرسال بريد إلكتروني للموظفين عند تغيير الحالة</label>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="btn-figma-gold" style="padding-inline: 40px;">حفظ الإعدادات</button>
            </div>
        </form>
    </div>
</div>
@endsection
