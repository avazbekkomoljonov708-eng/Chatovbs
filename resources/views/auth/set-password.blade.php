@extends('layouts.app')

@section('content')
<style>
    .auth-wrapper { min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
    .auth-card {
        width: 100%; max-width: 420px; background: #1e293b; border: 1px solid #334155;
        border-radius: 20px; padding: 40px 36px; box-shadow: 0 20px 60px rgba(0,0,0,0.35);
    }
    .auth-header { text-align: center; margin-bottom: 28px; }
    .auth-header h2 {
        background: linear-gradient(90deg, #22d3ee, #a78bfa);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        font-weight: 800; font-size: 26px; margin-bottom: 6px;
    }
    .auth-header p { color: #94a3b8; font-size: 14px; }
    .field { margin-bottom: 18px; }
    .field label { display: block; font-size: 13px; color: #94a3b8; margin-bottom: 6px; font-weight: 500; }
    .field input {
        width: 100%; background: #0f172a; border: 1.5px solid #334155; color: #f1f5f9;
        border-radius: 12px; padding: 12px 14px; font-size: 15px; outline: none;
    }
    .field input.is-invalid { border-color: #f87171; }
    .invalid-feedback { color: #f87171; font-size: 12.5px; margin-top: 4px; display: block; }
    .submit-btn {
        width: 100%; border: none; border-radius: 12px; padding: 13px; font-weight: 700;
        font-size: 15px; color: #0f172a; background: linear-gradient(90deg, #22d3ee, #a78bfa); cursor: pointer;
    }
</style>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <h2>ChatO'VBS</h2>
            <p>Email tasdiqlandi! Endi o'zingizga parol yarating</p>
        </div>

        <form method="POST" action="{{ route('register.set-password.store') }}">
            @csrf

            <div class="field">
                <label for="password">Parol</label>
                <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autofocus>
                @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="field">
                <label for="password-confirm">Parolni tasdiqlang</label>
                <input id="password-confirm" type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="submit-btn">Parolni saqlash va kirish</button>
        </form>
    </div>
</div>
@endsection