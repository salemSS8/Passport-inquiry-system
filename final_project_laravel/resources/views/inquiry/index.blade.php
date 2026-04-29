@extends('layouts.app')

@section('title', 'استعلام عن حالة الجواز')

@section('content')
<div class="search-container">
    <div class="flex-center">
        <img src="/images/logo.png" 
             alt="Logo" 
             class="search-logo">
    </div>
    
    <div style="margin-block-end: 2rem;">
        <h1 style="color: var(--primary);">استعلام عن الجواز</h1>
        <p style="color: var(--text-muted);">تتبع حالة طلب جواز السفر الخاص بك بسهولة</p>
    </div>

    <form action="{{ route('inquiry.show') }}" method="GET" style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div class="form-group" style="text-align: right;">
            <label for="identifier">الرقم التسلسلي</label>
            <div style="position: relative;">
                <input type="text" 
                       name="identifier" 
                       id="identifier" 
                       class="form-input"
                       placeholder="أدخل الرقم التسلسلي الطويل" 
                       required>
            </div>
        </div>
        
        <button type="submit" class="btn-figma-gold" style="width: 100%;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            اسـتـعـلام
        </button>
    </form>

    <div style="margin-block-start: 2rem;">
        <a href="#" style="color: var(--text-muted); font-size: 0.9rem; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.25rem;">
            أين يمكنني العثور على الرقم التسلسلي؟
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
        </a>
    </div>

    <div style="margin-block-start: 2rem; opacity: 0.6;">
        <p style="color: var(--primary); font-size: 0.7rem; font-weight: 500; margin-bottom: 0;">الجمهورية اليمنية - وزارة الداخلية</p>
        <p style="color: var(--text-muted); font-size: 0.7rem; margin-top: 0;">مصلحة الهجرة والجوازات والجنسية</p>
    </div>
</div>
@endsection
