@extends('layouts.app')

@section('title', 'تعديل موظف - جوازات اليمن')
@section('header_title', 'تعديل بيانات الموظف')

@section('content')
<div style="max-inline-size: 600px; margin-inline: auto;">
    <div class="card form-card">
        <h3 style="margin-block-end: 24px; color: var(--primary); display: flex; align-items: center; gap: 8px;">
            <svg style="inline-size: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            تعديل بيانات الموظف: {{ $employee->name }}
        </h3>

        <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group" style="margin-block-end: 20px;">
                <label for="name">الاسم الكامل</label>
                <input type="text" name="name" id="name" class="form-input" required value="{{ old('name', $employee->name) }}">
                @error('name') <span style="color: #EF4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-block-end: 20px;">
                <label for="email">البريد الإلكتروني (اسم المستخدم)</label>
                <input type="email" name="email" id="email" class="form-input" required value="{{ old('email', $employee->email) }}">
                @error('email') <span style="color: #EF4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-block-end: 20px;">
                <label for="password">كلمة المرور الجديدة <span style="color: var(--text-muted); font-size: 0.8rem; font-weight: normal;">(اتركه فارغاً إذا لم ترد تغيير كلمة المرور)</span></label>
                <input type="password" name="password" id="password" class="form-input">
                @error('password') <span style="color: #EF4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group" style="margin-block-end: 32px;">
                <label for="password_confirmation">تأكيد كلمة المرور الجديدة</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" class="btn-figma-gold" style="flex: 1;">تحديث البيانات</button>
                <a href="{{ route('admin.employees.index') }}" class="btn" style="flex: 1; display: flex; align-items: center; justify-content: center; background: #F3F4F6; color: var(--text-muted); text-decoration: none; border-radius: 0.5rem; font-weight: 700;">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
