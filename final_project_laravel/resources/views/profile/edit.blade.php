@extends('layouts.app')

@section('title', 'الملف الشخصي - جوازات اليمن')
@section('header_title', 'إدارة حسابك الشخصي')

@section('content')
<div style="max-inline-size: 800px; margin-inline: auto; display: flex; flex-direction: column; gap: var(--space-lg);">
    
    <!-- Profile Information -->
    <div class="form-card">
        <h3 style="margin-block-end: 24px; color: var(--primary); display: flex; align-items: center; gap: 8px;">
            <svg style="inline-size: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            معلومات الحساب
        </h3>
        
        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="form-group" style="margin-block-end: 20px;">
                <label for="name">الاسم</label>
                <input id="name" name="name" type="text" class="form-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name') <span style="color: #EF4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-block-end: 20px;">
                <label for="email">البريد الإلكتروني</label>
                <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email') <span style="color: #EF4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div style="display: flex; align-items: center; gap: 16px;">
                <button type="submit" class="btn-figma-gold" style="padding-inline: 32px;">حفظ التغييرات</button>
                @if (session('status') === 'profile-updated')
                    <p style="margin: 0; font-size: 0.85rem; color: #10B981; font-weight: 600;">تم الحفظ بنجاح.</p>
                @endif
            </div>
        </form>
    </div>

    <!-- Update Password -->
    <div class="form-card">
        <h3 style="margin-block-end: 24px; color: var(--primary); display: flex; align-items: center; gap: 8px;">
            <svg style="inline-size: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            تغيير كلمة المرور
        </h3>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="form-group" style="margin-block-end: 20px;">
                <label for="current_password">كلمة المرور الحالية</label>
                <input id="current_password" name="current_password" type="password" class="form-input" autocomplete="current-password">
                @error('current_password', 'updatePassword') <span style="color: #EF4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-block-end: 20px;">
                <label for="password">كلمة المرور الجديدة</label>
                <input id="password" name="password" type="password" class="form-input" autocomplete="new-password">
                @error('password', 'updatePassword') <span style="color: #EF4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-block-end: 32px;">
                <label for="password_confirmation">تأكيد كلمة المرور الجديدة</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-input" autocomplete="new-password">
            </div>

            <div style="display: flex; align-items: center; gap: 16px;">
                <button type="submit" class="btn-figma-gold" style="padding-inline: 32px;">تحديث كلمة المرور</button>
                @if (session('status') === 'password-updated')
                    <p style="margin: 0; font-size: 0.85rem; color: #10B981; font-weight: 600;">تم التحديث.</p>
                @endif
            </div>
        </form>
    </div>

    <!-- Delete Account -->
    <div class="form-card" style="border-inline-start: 4px solid #EF4444;">
        <h3 style="margin-block-end: 12px; color: #EF4444;">حذف الحساب</h3>
        <p style="font-size: 0.85rem; color: var(--text-muted); margin-block-end: 20px;">
            بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته بشكل دائم. قبل حذف حسابك، يرجى تنزيل أي بيانات أو معلومات ترغب في الاحتفاظ بها.
        </p>
        <button class="btn" style="background: #FEE2E2; color: #B91C1C; padding: 10px 20px; border-radius: 8px; font-weight: 600; border: none; cursor: pointer;">
            حذف الحساب نهائياً
        </button>
    </div>
</div>
@endsection
