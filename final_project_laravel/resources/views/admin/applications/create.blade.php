@extends('layouts.app')

@section('title', 'إصدار جواز سفر جديد - جوازات اليمن')
@section('header_title', 'إضافة طلب إصدار جديد')

@section('content')
<div style="max-inline-size: 1100px; margin-inline: auto;">
    <form action="{{ route('admin.applications.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-grid">
            <!-- Right Column: Personal Information -->
            <div class="form-card">
                <div style="display: flex; align-items: center; gap: 12px; margin-block-end: 24px; padding-block-end: 16px; border-block-end: 1px solid #F3F4F6;">
                    <div style="inline-size: 40px; block-size: 40px; border-radius: 50%; background: rgba(200, 165, 95, 0.1); color: var(--accent); display: flex; align-items: center; justify-content: center;">
                        <svg style="inline-size: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 style="margin: 0; font-size: 1.1rem; color: var(--primary);">البيانات الشخصية لمقدم الطلب</h3>
                </div>

                <div class="form-group" style="margin-block-end: 20px;">
                    <label for="full_name">الاسم الكامل (كما هو في البطاقة الشخصية)</label>
                    <input type="text" name="full_name" id="full_name" class="form-input" required placeholder="أدخل الاسم الرباعي واللقب" value="{{ old('full_name') }}">
                </div>

                <div class="form-group" style="margin-block-end: 20px;">
                    <label for="mother_name">اسم الأم (للتأكد من الهوية)</label>
                    <input type="text" name="mother_name" id="mother_name" class="form-input" placeholder="أدخل اسم الأم الكامل" value="{{ old('mother_name') }}">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-block-end: 20px;">
                    <div class="form-group">
                        <label for="date_of_birth">تاريخ الميلاد</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" class="form-input" required value="{{ old('date_of_birth') }}">
                    </div>
                    <div class="form-group">
                        <label for="gender">الجنس</label>
                        <select name="gender" id="gender" class="form-input" required>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" style="margin-block-end: 20px;">
                    <label for="national_id">الرقم الوطني (11 خانة)</label>
                    <input type="text" name="national_id" id="national_id" class="form-input" required placeholder="001-XXXXXX-X" value="{{ old('national_id') }}">
                </div>

                <div class="form-group">
                    <label for="address">العنوان الحالي بالتفصيل</label>
                    <textarea name="address" id="address" class="form-input" style="block-size: 100px; padding-block: 12px;" placeholder="المحافظة - المديرية - الشارع">{{ old('address') }}</textarea>
                </div>
            </div>

            <!-- Left Column: Media & Submission -->
            <div style="display: flex; flex-direction: column; gap: var(--space-lg);">
                <!-- Photo Upload -->
                <div class="form-card" style="padding: 24px;">
                    <h3 style="margin: 0 0 16px 0; font-size: 1rem; color: var(--primary);">الصورة الشخصية</h3>
                    <div class="photo-upload-box" onclick="document.getElementById('photo').click()">
                        <input type="file" name="photo" id="photo" hidden accept="image/*" onchange="previewImage(this)">
                        <div id="photo-preview-container">
                            <div class="photo-preview-placeholder">
                                <svg style="inline-size: 32px; color: var(--placeholder);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <p style="margin: 0; font-size: 0.85rem; color: var(--text-muted);">اسحب الصورة هنا أو <span style="color: var(--accent); font-weight: 700;">تصفح</span></p>
                            <p style="margin: 8px 0 0 0; font-size: 0.75rem; color: var(--placeholder);">خلفية بيضاء - 4x6 - Max 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Application Meta -->
                <div class="form-card" style="padding: 24px;">
                    <h3 style="margin: 0 0 16px 0; font-size: 1rem; color: var(--primary);">جهة الإصدار</h3>
                    <div class="form-group" style="margin-block-end: 16px;">
                        <label for="branch_id">فرع تقديم الطلب</label>
                        <select name="branch_id" id="branch_id" class="form-input" required>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pickup_branch_id">فرع استلام الجواز</label>
                        <select name="pickup_branch_id" id="pickup_branch_id" class="form-input" required>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Action Button -->
                <div style="margin-block-start: auto;">
                    <button type="submit" class="btn-figma-gold" style="inline-size: 100%; block-size: 64px; box-shadow: 0 10px 15px -3px rgba(200, 165, 95, 0.3);">
                        <svg style="inline-size: 24px; margin-inline-end: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        حفظ الطلب وإصدار الرقم
                    </button>
                    <a href="{{ route('admin.applications.index') }}" style="display: block; text-align: center; margin-block-start: 16px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">إلغاء والعودة للقائمة</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.getElementById('photo-preview-container');
                container.innerHTML = `
                    <img src="${e.target.result}" style="inline-size: 120px; block-size: 160px; object-fit: cover; border-radius: 8px; margin-inline: auto; margin-block-end: 12px; border: 4px solid white; box-shadow: var(--shadow-md);">
                    <p style="margin: 0; font-size: 0.85rem; color: var(--accent); font-weight: 700;">تم اختيار الصورة</p>
                    <button type="button" onclick="resetImage()" style="background: none; border: none; color: #EF4444; font-size: 0.75rem; cursor: pointer; margin-block-start: 4px;">حذف</button>
                `;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetImage() {
        document.getElementById('photo').value = '';
        const container = document.getElementById('photo-preview-container');
        container.innerHTML = `
            <div class="photo-preview-placeholder">
                <svg style="inline-size: 32px; color: var(--placeholder);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <p style="margin: 0; font-size: 0.85rem; color: var(--text-muted);">اسحب الصورة هنا أو <span style="color: var(--accent); font-weight: 700;">تصفح</span></p>
            <p style="margin: 8px 0 0 0; font-size: 0.75rem; color: var(--placeholder);">خلفية بيضاء - 4x6 - Max 2MB</p>
        `;
    }
</script>
@endsection
