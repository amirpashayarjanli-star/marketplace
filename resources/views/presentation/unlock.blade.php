@extends('presentation.layout')

@section('title', 'ارائه — رمز را وارد کنید')

@section('styles')
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 16px;
        background:
            radial-gradient(circle at 85% 15%, var(--brand-soft), transparent 45%),
            radial-gradient(circle at 10% 90%, #fce7f3, transparent 40%),
            var(--paper);
    }

    .gate {
        width: 100%;
        max-width: 420px;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 24px;
        padding: 40px 32px 32px;
        box-shadow: 0 20px 50px -20px rgba(15, 23, 42, .25);
        text-align: center;
    }

    .gate-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 20px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        background: var(--brand-soft);
        color: var(--brand);
    }

    .gate h1 { margin: 0 0 6px; font-size: 1.5rem; font-weight: 800; }

    .gate p { margin: 0 0 28px; color: var(--ink-soft); font-size: 1rem; }

    .gate input {
        width: 100%;
        padding: 14px 16px;
        font-size: 1.1rem;
        text-align: center;
        letter-spacing: .08em;
        border: 2px solid var(--line);
        border-radius: 14px;
        outline: none;
        background: var(--paper);
        color: var(--ink);
        direction: ltr;
    }

    .gate input:focus { border-color: var(--brand); background: #fff; }

    .gate .error { margin: 10px 0 0; color: #dc2626; font-size: .95rem; }

    .gate button {
        width: 100%;
        margin-top: 18px;
        padding: 14px;
        font-size: 1.05rem;
        font-weight: 700;
        color: #fff;
        background: var(--brand);
        border: 0;
        border-radius: 14px;
        cursor: pointer;
    }

    .gate button:hover { background: #1d4ed8; }
@endsection

@section('content')
    <form class="gate" method="POST" action="{{ route('presentation.unlock') }}">
        @csrf

        <div class="gate-icon" aria-hidden="true">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="11" width="16" height="10" rx="2"/>
                <path d="M8 11V7a4 4 0 0 1 8 0v4"/>
            </svg>
        </div>

        <h1>مدل‌های لایه‌ای شبکه</h1>
        <p>برای شروع ارائه، رمز را وارد کنید.</p>

        <input id="password" name="password" type="password" aria-label="رمز" autocomplete="off" autofocus required>

        @error('password')
            <p class="error">{{ $message }}</p>
        @enderror

        <button type="submit">شروع ارائه</button>
    </form>
@endsection
