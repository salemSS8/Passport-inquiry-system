<x-guest-layout>
    <div style="text-align: center; margin-block-end: 2rem;">
        <h2 style="color: var(--primary); font-family: var(--cairo); font-weight: 800; font-size: 1.75rem; margin-block-end: 0.5rem;">تسجيل الدخول</h2>
        <p style="color: var(--text-muted); font-family: var(--cairo); font-size: 0.95rem;">لوحة إدارة نظام استعلام الجوازات</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 1.5rem;">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" style="display: block; font-family: var(--cairo); font-weight: 700; color: #475569; margin-block-end: 0.5rem;">البريد الإلكتروني</label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   class="form-input" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   placeholder="example@domain.com"
                   style="width: 100%; height: 48px; padding-inline: 1rem; border: 1.5px solid #e2e8f0; border-radius: 12px; font-family: var(--cairo);">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-block-end: 0.5rem;">
                <label for="password" style="font-family: var(--cairo); font-weight: 700; color: #475569;">كلمة المرور</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-family: var(--cairo); font-size: 0.85rem; color: var(--accent); text-decoration: none; font-weight: 600;">
                        نسيت كلمة المرور؟
                    </a>
                @endif
            </div>
            <input id="password" 
                   type="password" 
                   name="password" 
                   class="form-input" 
                   required 
                   autocomplete="current-password"
                   placeholder="••••••••"
                   style="width: 100%; height: 48px; padding-inline: 1rem; border: 1.5px solid #e2e8f0; border-radius: 12px; font-family: var(--cairo);">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <input id="remember_me" type="checkbox" name="remember" style="width: 18px; height: 18px; accent-color: var(--accent); cursor: pointer;">
            <label for="remember_me" style="font-family: var(--cairo); font-size: 0.9rem; color: #64748b; cursor: pointer;">تذكرني على هذا الجهاز</label>
        </div>

        <button type="submit" class="btn-figma-gold" style="width: 100%; height: 52px; font-size: 1.1rem; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(180, 150, 90, 0.3);">
            دخول للنظام
        </button>
    </form>
</x-guest-layout>
