@extends('layouts.app')

@section('title', 'إضافة موظف - جوازات اليمن')
@section('header_title', 'إضافة موظف جديد للنظام')

@section('content')
<div style="max-inline-size: 600px; margin-inline: auto;">
    <div class="form-card">
        <h3 style="margin-block-end: 24px; color: var(--primary); display: flex; align-items: center; gap: 8px;">
            <svg style="inline-size: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            بيانات الموظف الجديد
        </h3>

        <form action="{{ route('admin.employees.store') }}" method="POST">
            @csrf
            
            <div class="form-group" style="margin-block-end: 20px;">
                <label for="name">الاسم الكامل</label>
                <input type="text" name="name" id="name" class="form-input" required value="{{ old('name') }}">
                @error('name') <span style="color: #EF4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-block-end: 20px;">
                <label for="email">البريد الإلكتروني (اسم المستخدم)</label>
                <input type="email" name="email" id="email" class="form-input" required value="{{ old('email') }}">
                @error('email') <span style="color: #EF4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-block-end: 20px;">
                <label for="password">كلمة المرور</label>
                <input type="password" name="password" id="password" class="form-input" required>
                @error('password') <span style="color: #EF4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-block-end: 32px;">
                <label for="password_confirmation">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" class="btn-figma-gold" style="flex: 1;">حفظ البيانات</button>
                <a href="{{ route('admin.employees.index') }}" class="btn" style="flex: 1; display: flex; align-items: center; justify-content: center; background: #F3F4F6; color: var(--text-muted); text-decoration: none;">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
