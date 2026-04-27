@extends('layouts.app')

@section('title', 'استعلام عن حالة الجواز')

@section('content')
<div style="max-inline-size: 448px; margin-inline: auto; text-align: center; padding-block: 50px;">
    <div style="margin-block-end: 32px;">
        <img src="/images/logo.png" 
             alt="Logo" 
             style="block-size: 261px; margin-inline: auto;">
    </div>
    
    <div style="margin-block-end: 46px;">
        <h1 style="color: var(--primary); font-size: 30px; font-weight: 700; margin-block-end: 8px; letter-spacing: -0.75px;">استعلام عن الجواز</h1>
        <p style="color: var(--text-muted); font-size: 14px;">تتبع حالة طلب جواز السفر الخاص بك بسهولة</p>
    </div>

    <form action="{{ route('inquiry.show') }}" method="GET" style="display: flex; flex-direction: column; gap: 24px;">
        <div style="text-align: right;">
            <label for="identifier" style="color: var(--primary); font-weight: 700; font-size: 14px; display: block; margin-block-end: 8px; padding-inline-end: 4px;">الرقم التسلسلي</label>
            <div style="position: relative;">
                <input type="text" 
                       name="identifier" 
                       id="identifier" 
                       placeholder="أدخل الرقم التسلسلي الطويل" 
                       required 
                       style="inline-size: 100%; block-size: 56px; border: 1px solid var(--border); border-radius: 8px; padding-inline: 16px; font-size: 18px; text-align: right; shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <div style="position: absolute; inset-inline-start: 16px; top: 12px; color: var(--primary);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 3H9V9H3V3ZM5 5V7H7V5H5ZM15 3H21V9H15V3ZM17 5V7H19V5H17ZM3 15H9V21H3V15ZM5 17V19H7V17H5ZM15 15H17V17H15V15ZM17 17H19V19H17V17ZM19 15H21V17H19V15ZM15 19H17V21H15V19ZM19 19H21V21H19V19ZM17 19H19V21H17V19ZM11 3H13V5H11V3ZM11 7H13V9H11V7ZM11 11H13V13H11V11ZM11 15H13V17H11V15ZM11 19H13V21H11V19ZM3 11H5V13H3V11ZM7 11H9V13H7V11ZM15 11H17V13H15V11ZM19 11H21V13H19V11Z" fill="currentColor"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <button type="submit" style="inline-size: 100%; block-size: 56px; background: var(--accent); color: var(--primary); border: none; border-radius: 8px; font-size: 18px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 20px -2px rgba(26,59,92,0.05);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            اسـتـعـلام
        </button>
    </form>

    <div style="margin-block-start: 32px;">
        <a href="#" style="color: var(--text-muted); font-size: 14px; text-decoration: none; border-bottom: 1px solid transparent; display: flex; align-items: center; justify-content: center; gap: 4px;">
            أين يمكنني العثور على الرقم التسلسلي؟
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                <path d="M12 16V12M12 8H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </a>
    </div>

    <div style="margin-block-start: 122px; opacity: 0.6; display: flex; flex-direction: column; gap: 4px;">
        <div style="color: var(--primary); font-size: 10px; font-weight: 500; letter-spacing: 0.25px;">
            الجمهورية اليمنية - وزارة الداخلية
        </div>
        <div style="color: var(--text-muted); font-size: 10px;">
            مصلحة الهجرة والجوازات والجنسية
        </div>
    </div>
</div>
@endsection
