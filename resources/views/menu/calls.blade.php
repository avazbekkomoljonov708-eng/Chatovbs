@extends('layouts.app')

@section('content')
<style>
    .calls-page {
        min-height: 100vh;
        padding: 32px;
        background: #0a0a0a;
        color: #faf9f6;
        font-family: 'Inter', sans-serif;
    }
    .calls-page__back {
        display: inline-flex;
        margin-bottom: 28px;
        color: #60a5fa;
        text-decoration: none;
        font-size: 14px;
    }
    .calls-page__content {
        max-width: 760px;
        padding: 28px;
        border: 1px solid #2a2a22;
        border-radius: 18px;
        background: #14140f;
    }
    .calls-page h1 {
        margin: 0 0 8px;
        font-family: 'Sora', sans-serif;
        font-size: 28px;
    }
    .calls-page__intro {
        margin: 0 0 24px;
        color: #8a8a80;
    }
    .calls-page__empty {
        padding: 32px 20px;
        border: 1px dashed #34342b;
        border-radius: 12px;
        color: #8a8a80;
        text-align: center;
    }
    .calls-page__empty strong {
        display: block;
        margin-bottom: 8px;
        color: #d8d8ce;
    }
</style>

<main class="calls-page">
    <a class="calls-page__back" href="{{ route('home') }}">&larr; Chatlarga qaytish</a>
    <section class="calls-page__content">
        <h1>Qo'ng'iroqlar</h1>
        <p class="calls-page__intro">Barcha ovozli va video qo'ng'iroqlar shu yerda ko'rinadi.</p>

        <div class="calls-page__empty">
            <strong>Hozircha qo'ng'iroqlar yo'q</strong>
            Birinchi qo'ng'iroq amalga oshirilgach, u shu ro'yxatda chiqadi.
        </div>
    </section>
</main>
@endsection