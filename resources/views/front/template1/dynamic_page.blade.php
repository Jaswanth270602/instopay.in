@extends('front.template1.header')
@section('content')
@php
    $sanitizedContent = preg_replace('/d2c[\s-]?pay/i', 'Instopay', $content ?? '');
@endphp
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --purple-deep: #4c1d95;
        --purple-violet: #7c3aed;
        --purple-soft: #a78bfa;
        --ink: #0f172a;
        --muted: #334155;
    }

    .w3l-inner-banner-main {
        margin-top: 26px;
    }

    .page-shell {
        font-family: "Inter", sans-serif;
        color: var(--ink);
        background: linear-gradient(180deg, #f6f3ff 0%, #ffffff 52%, #f4f0ff 100%);
        padding: 20px 0 80px;
    }

    .page-wrap {
        width: min(1080px, 92vw);
        margin: 0 auto;
    }

    .page-hero {
        border-radius: 12px;
        padding: 16px 14px;
        color: #fff;
        background: linear-gradient(125deg, var(--purple-deep), var(--purple-violet), var(--purple-soft));
        box-shadow: 0 8px 14px rgba(76, 29, 149, 0.14);
    }

    .bread {
        display: flex;
        gap: 10px;
        align-items: center;
        margin: 0 0 10px;
        padding: 0;
        list-style: none;
    }

    .bread a {
        color: #ede9fe;
        text-decoration: none;
        font-weight: 600;
    }

    .bread span {
        color: #ddd6fe;
    }

    .page-title {
        font-size: clamp(1.8rem, 3.8vw, 2.7rem);
        font-weight: 800;
        margin: 0;
        letter-spacing: 0.2px;
    }

    .page-card {
        margin-top: 10px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.92);
        border: 1px solid rgba(124, 58, 237, 0.17);
        box-shadow: 0 6px 12px rgba(15, 23, 42, 0.06);
        padding: 16px 14px;
    }

    .page-content {
        color: var(--muted);
        font-size: 1.07rem;
        font-weight: 500;
        line-height: 1.85;
    }

    .page-content h1,
    .page-content h2,
    .page-content h3,
    .page-content h4 {
        color: var(--ink);
        font-weight: 800;
        margin-bottom: 12px;
    }

    .page-content p {
        margin-bottom: 16px;
    }

    .page-content ul,
    .page-content ol {
        padding-left: 22px;
    }

    @media (max-width: 768px) {
        .page-hero,
        .page-card {
            padding: 12px 10px;
        }
    }
</style>

<section class="page-shell">
    <div class="page-wrap">
        <div class="page-hero">
            <ul class="bread">
                <li><a href="{{ url('') }}">Home</a></li>
                <li><span>/</span></li>
                <li><span>{{ $navigation_name }}</span></li>
            </ul>
            <h1 class="page-title">{{ $navigation_name }}</h1>
        </div>
        <div class="page-card">
            <div class="page-content">
                {!! $sanitizedContent !!}
            </div>
        </div>
    </div>
</section>
@endsection
