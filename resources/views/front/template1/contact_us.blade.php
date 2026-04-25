@extends('front.template1.header')
@section('content')
@php
    $displayCompanyEmail = str_ireplace(['d2cpay', 'd2c-pay', 'd2c pay'], 'instopay', $company_email ?? '');
    $displayAddress = str_ireplace(['d2cpay', 'd2c-pay', 'd2c pay'], 'Instopay', $company_address ?? '');
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

    .contact-shell {
        font-family: "Inter", sans-serif;
        color: var(--ink);
        background: linear-gradient(180deg, #f5f2ff 0%, #ffffff 50%, #f3efff 100%);
        padding: 20px 0 80px;
    }

    .contact-wrap {
        width: min(1120px, 92vw);
        margin: 0 auto;
    }

    .contact-hero {
        border-radius: 24px;
        color: #fff;
        padding: 34px 28px;
        background: linear-gradient(125deg, var(--purple-deep), var(--purple-violet), var(--purple-soft));
        box-shadow: 0 22px 38px rgba(76, 29, 149, 0.28);
    }

    .bread {
        display: flex;
        gap: 10px;
        align-items: center;
        margin: 0 0 8px;
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

    .contact-title {
        margin: 0;
        font-size: clamp(1.8rem, 3.8vw, 2.7rem);
        font-weight: 800;
    }

    .contact-grid {
        margin-top: 22px;
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 22px;
    }

    .panel {
        border-radius: 22px;
        background: rgba(255, 255, 255, 0.93);
        border: 1px solid rgba(124, 58, 237, 0.16);
        box-shadow: 0 18px 30px rgba(15, 23, 42, 0.08);
        padding: 28px 24px;
    }

    .panel h4 {
        font-weight: 800;
        color: var(--ink);
        margin-bottom: 12px;
    }

    .panel p {
        color: var(--muted);
        font-weight: 500;
        line-height: 1.7;
    }

    .notice {
        margin-bottom: 16px;
        border-radius: 12px;
        padding: 10px 12px;
        background: #eef2ff;
        border: 1px solid #c7d2fe;
    }

    .form-stack {
        display: grid;
        gap: 12px;
    }

    .form-input {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 12px 14px;
        color: var(--ink);
        font-weight: 500;
        background: #fff;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-input:focus {
        border-color: var(--purple-violet);
        box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.12);
    }

    .help-error {
        color: #dc2626;
        font-size: 0.82rem;
        font-weight: 600;
        margin-top: 6px;
        display: block;
    }

    .submit-btn {
        border: 0;
        border-radius: 999px;
        padding: 11px 20px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(120deg, var(--purple-deep), var(--purple-violet), var(--purple-soft));
        box-shadow: 0 14px 24px rgba(124, 58, 237, 0.35);
        transition: transform 0.25s ease;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
    }

    .info-item {
        display: grid;
        grid-template-columns: 44px 1fr;
        gap: 10px;
        margin-bottom: 14px;
    }

    .icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        color: #fff;
        background: linear-gradient(120deg, #5b21b6, #7c3aed, #a78bfa);
        box-shadow: 0 10px 18px rgba(124, 58, 237, 0.25);
    }

    .info-title {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--ink);
    }

    .info-text,
    .info-text a {
        margin: 2px 0 0;
        color: var(--muted);
        text-decoration: none;
        font-weight: 500;
        word-break: break-word;
    }

    @media (max-width: 900px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="contact-shell">
    <div class="contact-wrap">
        <div class="contact-hero">
            <ul class="bread">
                <li><a href="{{ url('') }}">Home</a></li>
                <li><span>/</span></li>
                <li><span>Contact</span></li>
            </ul>
            <h1 class="contact-title">Have a Question? Let’s Talk.</h1>
        </div>

        <div class="contact-grid">
            <div class="panel">
                <h4>Send us a message</h4>
                <p>Share your query and our team will respond quickly with the right solution.</p>

                @if(Session::has('success'))
                    <div class="notice">{!! Session::get('success') !!}</div>
                @endif

                <form role="form" action="{{ url('save-contact-enquiry') }}" method="post" class="form-stack">
                    {!! csrf_field() !!}

                    <div>
                        <input type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="Your Name">
                        @if ($errors->has('name'))
                            <span class="help-error">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <div>
                        <input type="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="Email Address">
                        @if ($errors->has('email'))
                            <span class="help-error">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div>
                        <input type="tel" name="mobile_number" class="form-input" value="{{ old('mobile_number') }}" placeholder="Phone / Mobile Number">
                        @if ($errors->has('mobile_number'))
                            <span class="help-error">{{ $errors->first('mobile_number') }}</span>
                        @endif
                    </div>

                    <div>
                        <textarea name="message" class="form-input" placeholder="Message" rows="4">{{ old('message') }}</textarea>
                        @if ($errors->has('message'))
                            <span class="help-error">{{ $errors->first('message') }}</span>
                        @endif
                    </div>

                    <div style="text-align:right;">
                        <button type="submit" class="submit-btn">Submit Now</button>
                    </div>
                </form>
            </div>

            <div class="panel">
                <h4>Contact Information</h4>
                <p>Reach us through your preferred channel for onboarding, support, or partnership queries.</p>

                <div class="info-item">
                    <div class="icon-box"><span class="fa fa-map-marker"></span></div>
                    <div>
                        <p class="info-title">Office</p>
                        <p class="info-text">{{ $displayAddress }}</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon-box"><span class="fa fa-envelope"></span></div>
                    <div>
                        <p class="info-title">Email</p>
                        <p class="info-text"><a href="mailto:{{ $displayCompanyEmail }}">{{ $displayCompanyEmail }}</a></p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon-box"><span class="fa fa-phone"></span></div>
                    <div>
                        <p class="info-title">Support Number</p>
                        <p class="info-text"><a href="tel:{{ $support_number }}">{{ $support_number }}</a></p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon-box"><span class="fa fa-whatsapp"></span></div>
                    <div>
                        <p class="info-title">Whatsapp Number</p>
                        <p class="info-text"><a href="tel:{{ $whatsapp_number }}">{{ $whatsapp_number }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
