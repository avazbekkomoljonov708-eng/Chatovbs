@extends('layouts.app')

@section('content')
<style>
    .menu-page {
        min-height: 100vh;
        padding: 32px;
        background: #0a0a0a;
        color: #faf9f6;
        font-family: 'Inter', sans-serif;
    }
    .menu-page__back {
        display: inline-flex;
        margin-bottom: 28px;
        color: #2dd4bf;
        text-decoration: none;
        font-size: 14px;
    }
    .menu-page__back:hover { color: #faf9f6; }
    .menu-page__content {
        max-width: 720px;
        padding: 28px;
        border: 1px solid #2a2a22;
        border-radius: 18px;
        background: #14140f;
    }
    .menu-page h1 {
        margin: 0 0 12px;
        font-family: 'Sora', sans-serif;
        font-size: 28px;
    }
    .menu-page p { margin: 0; color: #8a8a80; }
</style>

<main class="menu-page">
    <a class="menu-page__back" href="{{ route('home') }}">&larr; Chatlarga qaytish</a>
    <section class="menu-page__content">
        <h1>{{ $title }}</h1>
        <p>{{ $title }} bo'limi tayyor. Bu sahifaga kerakli ma'lumot va amallarni qo'shishingiz mumkin.</p>
    </section>
</main>
@endsection
