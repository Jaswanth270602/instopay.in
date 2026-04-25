@extends('front.template1.header')
@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    :root {
        --purple-deep: #4c1d95;
        --purple-violet: #7c3aed;
        --purple-soft: #a78bfa;
        --ink: #0f172a;
        --muted: #334155;
        --paper: #f8fafc;
        --white: #ffffff;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: "Inter", sans-serif;
        color: var(--ink);
        background: linear-gradient(180deg, #f8f7ff 0%, #ffffff 35%, #f4f1ff 100%);
        overflow-x: hidden;
    }

    .wrap {
        width: min(1180px, 92vw);
        margin: 0 auto;
    }

    .purple-gradient {
        background: linear-gradient(135deg, var(--purple-deep), var(--purple-violet), var(--purple-soft));
    }

    .text-gradient {
        background: linear-gradient(120deg, var(--purple-deep), var(--purple-violet), var(--purple-soft));
        -webkit-background-clip: text;
        color: transparent;
    }

    .section-gap {
        padding: 90px 0;
    }

    .glass-nav {
        position: sticky;
        top: 16px;
        z-index: 120;
        margin: 18px auto;
        border-radius: 20px;
        background: rgba(92, 34, 183, 0.82);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.28);
        box-shadow: 0 20px 40px rgba(76, 29, 149, 0.22);
    }

    .nav-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 24px;
    }

    .brand {
        color: #ffffff !important;
        font-weight: 800;
        letter-spacing: 0.3px;
        text-decoration: none;
        font-size: 1.15rem;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.35);
    }

    .nav-links {
        display: flex;
        gap: 28px;
        align-items: center;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .nav-links a {
        color: #ffffff !important;
        text-decoration: none;
        font-weight: 700;
        position: relative;
        padding-bottom: 5px;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.38);
    }

    .nav-links a::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 100%;
        height: 2px;
        background: #fff;
        transform: scaleX(0);
        transform-origin: right;
        transition: transform 0.35s ease;
    }

    .nav-links a:hover::after {
        transform: scaleX(1);
        transform-origin: left;
    }

    .nav-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .nav-auth {
        border-radius: 10px;
        padding: 9px 14px;
        text-decoration: none;
        color: #ffffff !important;
        font-weight: 700;
        border: 1px solid rgba(255, 255, 255, 0.38);
        background: rgba(255, 255, 255, 0.12);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.28);
        transition: all 0.22s ease;
    }

    .nav-auth:hover {
        background: rgba(255, 255, 255, 0.22);
        color: #ffffff !important;
    }

    .nav-cta {
        border: 0;
        border-radius: 999px;
        padding: 10px 18px;
        color: #ffffff !important;
        font-weight: 700;
        text-decoration: none;
        background: linear-gradient(120deg, #5b21b6, #7c3aed, #a78bfa);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.28);
        box-shadow: 0 0 0 rgba(167, 139, 250, 0.4);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .nav-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(167, 139, 250, 0.58);
    }

    .hero {
        position: relative;
        overflow: hidden;
        padding: 48px 0 88px;
    }

    .hero::before,
    .hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        filter: blur(70px);
        opacity: 0.4;
        z-index: 0;
        animation: glowShift 12s ease-in-out infinite alternate;
    }

    .hero::before {
        width: 360px;
        height: 360px;
        background: #7c3aed;
        top: -80px;
        left: -120px;
    }

    .hero::after {
        width: 400px;
        height: 400px;
        background: #a78bfa;
        bottom: -160px;
        right: -80px;
    }

    @keyframes glowShift {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(25px, -20px) scale(1.08); }
    }

    .hero-grid {
        position: relative;
        z-index: 2;
        display: grid;
        gap: 36px;
        grid-template-columns: 1.05fr 0.95fr;
        align-items: center;
    }

    .hero h1 {
        font-size: clamp(2rem, 4.5vw, 3.6rem);
        line-height: 1.08;
        font-weight: 800;
        margin-bottom: 18px;
    }

    .hero p {
        color: var(--muted);
        font-size: 1.1rem;
        font-weight: 500;
        margin-bottom: 30px;
        max-width: 620px;
    }

    .feature-card p,
    .timeline-item p,
    .testi-card p,
    .cta-block p {
        color: #334155 !important;
    }

    .stats p,
    .stats h2,
    .stats .counter {
        color: #ffffff !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    }

    .btn-row {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }

    .btn-main,
    .btn-ghost {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 12px 24px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .btn-main {
        color: #fff;
        background: linear-gradient(120deg, var(--purple-deep), var(--purple-violet), var(--purple-soft));
        box-shadow: 0 14px 26px rgba(124, 58, 237, 0.36);
    }

    .btn-main:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 35px rgba(124, 58, 237, 0.45);
    }

    .btn-ghost {
        color: var(--purple-violet);
        border: 1px solid rgba(124, 58, 237, 0.45);
        background: rgba(255, 255, 255, 0.7);
    }

    .btn-ghost:hover {
        border-color: var(--purple-violet);
        background: rgba(124, 58, 237, 0.08);
    }

    .float-stack {
        position: relative;
        height: 460px;
    }

    .float-card {
        position: absolute;
        background: rgba(255, 255, 255, 0.78);
        border: 1px solid rgba(167, 139, 250, 0.34);
        backdrop-filter: blur(12px);
        border-radius: 20px;
        box-shadow: 0 20px 45px rgba(30, 41, 59, 0.15);
        padding: 18px 20px;
    }

    .float-success { top: 18px; left: 5%; width: 260px; animation: floaty 5s ease-in-out infinite; }
    .float-graph { top: 155px; right: 0; width: 290px; animation: floaty 6s ease-in-out infinite; }
    .float-wallet { bottom: 0; left: 18%; width: 280px; animation: floaty 5.5s ease-in-out infinite; }

    @keyframes floaty {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-12px); }
    }

    .chip {
        display: inline-flex;
        gap: 8px;
        align-items: center;
        color: #ffffff !important;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 0.78rem;
        font-weight: 700;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.22);
    }

    .chip.green { background: linear-gradient(90deg, #16a34a, #22c55e); }
    .chip.purple { background: linear-gradient(90deg, #6d28d9, #8b5cf6); }

    .mini-graph {
        margin-top: 14px;
        display: grid;
        grid-template-columns: repeat(9, 1fr);
        align-items: end;
        gap: 7px;
        height: 80px;
    }

    .mini-graph span {
        border-radius: 8px 8px 0 0;
        background: linear-gradient(180deg, #a78bfa, #6d28d9);
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
    }

    .feature-card {
        position: relative;
        border-radius: 20px;
        background: linear-gradient(#fff, #fff) padding-box,
            linear-gradient(130deg, rgba(76, 29, 149, 0.85), rgba(124, 58, 237, 0.7), rgba(167, 139, 250, 0.8)) border-box;
        border: 1.5px solid transparent;
        box-shadow: 0 16px 30px rgba(15, 23, 42, 0.1);
        padding: 24px;
        transition: transform 0.28s ease, box-shadow 0.28s ease;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 24px 34px rgba(76, 29, 149, 0.2);
    }

    .icon-glow {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        margin-bottom: 14px;
        color: #fff;
        font-size: 1rem;
        background: linear-gradient(120deg, #5b21b6, #7c3aed, #a78bfa);
        box-shadow: 0 12px 24px rgba(124, 58, 237, 0.38);
    }

    .how-it-works {
        background: linear-gradient(170deg, #ffffff 0%, #f2ecff 100%);
        border-radius: 26px;
        border: 1px solid rgba(124, 58, 237, 0.15);
        padding: 38px 26px;
    }

    .timeline {
        position: relative;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
        margin-top: 24px;
    }

    .timeline::before {
        content: "";
        position: absolute;
        top: 31px;
        left: 8%;
        right: 8%;
        height: 2px;
        background: linear-gradient(90deg, #4c1d95, #7c3aed, #a78bfa);
        z-index: 0;
    }

    .timeline-item {
        position: relative;
        z-index: 2;
        text-align: center;
        padding: 14px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(124, 58, 237, 0.18);
    }

    .timeline-dot {
        width: 64px;
        height: 64px;
        margin: 0 auto 12px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        color: #fff;
        font-size: 1.15rem;
        background: linear-gradient(120deg, #4c1d95, #7c3aed, #a78bfa);
        box-shadow: 0 14px 24px rgba(124, 58, 237, 0.35);
    }

    .stats {
        margin-top: 40px;
        background: linear-gradient(130deg, #1f1147, #3b1476, #4c1d95);
        border-radius: 26px;
        color: #fff;
        padding: 38px 26px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-top: 16px;
    }

    .stat-card {
        border-radius: 16px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.13);
        text-align: center;
    }

    .counter {
        font-size: clamp(1.8rem, 3.4vw, 2.4rem);
        font-weight: 800;
        color: #ddd6fe;
    }

    .testi-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px;
    }

    .testi-card {
        border-radius: 18px;
        border: 1px solid rgba(124, 58, 237, 0.2);
        background: #fff;
        padding: 22px;
        box-shadow: 0 12px 22px rgba(15, 23, 42, 0.1);
        transition: transform 0.28s ease, box-shadow 0.28s ease;
    }

    .testi-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 0 0 1px rgba(167, 139, 250, 0.18), 0 18px 28px rgba(124, 58, 237, 0.24);
    }

    .identity {
        margin-top: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(130deg, #5b21b6, #8b5cf6);
    }

    .cta-block {
        border-radius: 26px;
        padding: 50px 28px;
        color: #fff;
        text-align: center;
        background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 45%, #a78bfa 100%);
        box-shadow: 0 25px 36px rgba(76, 29, 149, 0.35);
    }

    .cta-form {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .cta-form input {
        min-width: min(360px, 90vw);
        border: 1px solid rgba(255, 255, 255, 0.4);
        background: rgba(255, 255, 255, 0.13);
        color: #fff;
        border-radius: 999px;
        padding: 12px 16px;
        outline: 0;
    }

    .cta-form input::placeholder {
        color: rgba(255, 255, 255, 0.8);
    }

    .cta-form button {
        border: 0;
        border-radius: 999px;
        padding: 12px 20px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(120deg, #5b21b6, #7c3aed, #c4b5fd);
        box-shadow: 0 14px 24px rgba(167, 139, 250, 0.45);
        transition: transform 0.25s ease;
    }

    .cta-form button:hover {
        transform: translateY(-2px);
    }

    .site-footer {
        margin-top: 90px;
        padding: 60px 0 28px;
        background: linear-gradient(140deg, #09080f, #190d36, #2a1059);
        color: #d4d4d8;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 1.2fr repeat(3, 1fr);
        gap: 28px;
    }

    .footer-title {
        color: #fff;
        margin-bottom: 12px;
        font-weight: 700;
    }

    .footer-links {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .footer-links li {
        margin-bottom: 10px;
    }

    .footer-links a {
        color: #cbd5e1;
        text-decoration: none;
        transition: color 0.2s ease, transform 0.2s ease;
        display: inline-block;
    }

    .footer-links a:hover {
        color: #ddd6fe;
        transform: translateX(4px);
    }

    .reveal {
        opacity: 0;
        transform: translateY(22px);
        transition: opacity 0.65s ease, transform 0.65s ease;
    }

    .reveal.show {
        opacity: 1;
        transform: translateY(0);
    }

    @media (max-width: 992px) {
        .hero-grid,
        .features-grid,
        .stats-grid,
        .testi-grid,
        .footer-grid,
        .timeline {
            grid-template-columns: 1fr;
        }

        .timeline::before {
            display: none;
        }

        .float-stack {
            height: auto;
            display: grid;
            gap: 14px;
        }

        .float-card {
            position: relative;
            width: 100%;
            left: auto;
            right: auto;
            top: auto;
            bottom: auto;
            animation: none;
        }

        .nav-links {
            display: none;
        }
    }
</style>

<section class="hero" id="home">
    <div class="wrap hero-grid">
        <div class="reveal">
            <h1>Powering the Future of <span class="text-gradient">Digital Payments</span></h1>
            <p>
                Instopay helps modern businesses process payments with speed, security, and clarity.
                Launch quickly, monitor everything in real time, and scale with confidence.
            </p>
            <div class="btn-row">
                <a href="#cta" class="btn-main">Get Started</a>
                <a href="#how" class="btn-ghost">Live Demo</a>
            </div>
        </div>
        <div class="float-stack reveal">
            <div class="float-card float-success">
                <span class="chip green"><i class="fa-solid fa-circle-check"></i> Payment Success</span>
                <h5 style="margin-top:12px; margin-bottom:6px; font-weight:700;">INR 24,800 Received</h5>
                <p style="margin:0; color:#64748b; font-size:0.92rem;">Settlement expected in 6 mins</p>
            </div>
            <div class="float-card float-graph">
                <span class="chip purple"><i class="fa-solid fa-chart-line"></i> Analytics</span>
                <div class="mini-graph">
                    <span style="height:30%"></span><span style="height:42%"></span><span style="height:55%"></span>
                    <span style="height:45%"></span><span style="height:64%"></span><span style="height:72%"></span>
                    <span style="height:68%"></span><span style="height:84%"></span><span style="height:95%"></span>
                </div>
                <p style="margin-top:10px; color:#475569; font-size:0.9rem;">+28% volume growth this week</p>
            </div>
            <div class="float-card float-wallet">
                <p style="margin:0; font-size:0.9rem; color:#64748b;">Wallet Balance</p>
                <h4 style="margin:6px 0 12px; font-size:1.8rem; font-weight:800;">INR 5,42,190</h4>
                <p style="margin:0; font-size:0.92rem; color:#475569;">Available for instant payout</p>
            </div>
        </div>
    </div>
</section>

<section class="section-gap" id="features">
    <div class="wrap">
        <div class="reveal" style="max-width:700px;">
            <h2 style="font-size:2rem; font-weight:800; margin-bottom:10px;">Built for Modern Payment Teams</h2>
            <p style="color:#64748b; margin-bottom:28px;">A premium infrastructure stack designed for scale, security, and flawless checkout experiences.</p>
        </div>
        <div class="features-grid">
            <article class="feature-card reveal"><div class="icon-glow"><i class="fa-solid fa-shield-halved"></i></div><h5>Enterprise Security</h5><p style="color:#64748b;">PCI-grade controls, risk scoring, and continuous fraud shielding.</p></article>
            <article class="feature-card reveal"><div class="icon-glow"><i class="fa-solid fa-bolt"></i></div><h5>Instant Settlements</h5><p style="color:#64748b;">Move funds faster with smart routing and real-time reconciliation.</p></article>
            <article class="feature-card reveal"><div class="icon-glow"><i class="fa-solid fa-code"></i></div><h5>Developer-First APIs</h5><p style="color:#64748b;">Clean APIs, robust docs, and simple SDKs for rapid integration.</p></article>
            <article class="feature-card reveal"><div class="icon-glow"><i class="fa-solid fa-chart-pie"></i></div><h5>Live Intelligence</h5><p style="color:#64748b;">Monitor success rates, volumes, and trends with actionable dashboards.</p></article>
            <article class="feature-card reveal"><div class="icon-glow"><i class="fa-solid fa-layer-group"></i></div><h5>Multi-Method Checkout</h5><p style="color:#64748b;">UPI, cards, wallets, and net banking in one seamless flow.</p></article>
            <article class="feature-card reveal"><div class="icon-glow"><i class="fa-solid fa-headset"></i></div><h5>24/7 Priority Support</h5><p style="color:#64748b;">Dedicated experts to keep your payment stack healthy around the clock.</p></article>
        </div>
    </div>
</section>

<section class="section-gap" id="aboutus">
    <div class="wrap reveal" style="padding: 0 0 20px;">
        <h2 style="font-size:2rem; font-weight:800; margin-bottom:10px;">About Instopay</h2>
        <p style="color:#334155; max-width:860px; font-size:1.05rem; line-height:1.75;">
            Instopay is a modern digital payments platform helping businesses accept payments with reliability,
            speed, and enterprise-grade security. We focus on premium onboarding, robust APIs, and real-time visibility
            so teams can scale confidently.
        </p>
    </div>
</section>

<section class="section-gap" id="how">
    <div class="wrap how-it-works reveal">
        <h2 style="font-size:2rem; font-weight:800; text-align:center; margin-bottom:4px;">How It Works</h2>
        <p style="text-align:center; color:#64748b;">Three simple steps to launch your payment engine.</p>
        <div class="timeline">
            <div class="timeline-item reveal">
                <div class="timeline-dot"><i class="fa-solid fa-user-plus"></i></div>
                <h5>Create Account</h5>
                <p style="color:#64748b;">Complete business onboarding and activate your merchant profile.</p>
            </div>
            <div class="timeline-item reveal">
                <div class="timeline-dot"><i class="fa-solid fa-plug-circle-check"></i></div>
                <h5>Integrate APIs</h5>
                <p style="color:#64748b;">Connect checkout, webhooks, and payouts in just a few lines.</p>
            </div>
            <div class="timeline-item reveal">
                <div class="timeline-dot"><i class="fa-solid fa-rocket"></i></div>
                <h5>Go Live</h5>
                <p style="color:#64748b;">Start accepting payments and track live performance instantly.</p>
            </div>
        </div>
    </div>
</section>

<section class="section-gap" id="stats">
    <div class="wrap stats reveal">
        <h2 style="font-size:2rem; font-weight:800; text-align:center; margin-bottom:0;">Trusted at Scale</h2>
        <p style="text-align:center; color:#ddd6fe;">High-volume reliability for serious businesses.</p>
        <div class="stats-grid">
            <div class="stat-card"><div class="counter" data-target="350">0</div><p>Million+ Transactions</p></div>
            <div class="stat-card"><div class="counter" data-target="120">0</div><p>Thousand+ Active Users</p></div>
            <div class="stat-card"><div class="counter" data-target="99.99">0</div><p>Success Rate (%)</p></div>
        </div>
    </div>
</section>

<section class="section-gap" id="testimonials">
    <div class="wrap">
        <div class="reveal" style="text-align:center; max-width:700px; margin:0 auto 26px;">
            <h2 style="font-size:2rem; font-weight:800;">What Merchants Say</h2>
            <p style="color:#64748b;">Real teams using Instopay to improve checkout performance and reliability.</p>
        </div>
        <div class="testi-grid">
            <article class="testi-card reveal">
                <p>"Instopay cut our payment failures by 31% in the first month and gave us complete control over settlements."</p>
                <div class="identity"><span class="avatar">AR</span><div><strong>Aryan Rana</strong><br><small style="color:#64748b;">CFO, NexCart</small></div></div>
            </article>
            <article class="testi-card reveal">
                <p>"The API experience is clean, fast, and dependable. We moved from integration to production in less than a week."</p>
                <div class="identity"><span class="avatar">SK</span><div><strong>Sneha Kapoor</strong><br><small style="color:#64748b;">CTO, PayOrbit</small></div></div>
            </article>
            <article class="testi-card reveal">
                <p>"From dashboards to support quality, this feels like a premium fintech stack built for high-growth teams."</p>
                <div class="identity"><span class="avatar">RM</span><div><strong>Rohan Mehta</strong><br><small style="color:#64748b;">Founder, BlueWave Commerce</small></div></div>
            </article>
        </div>
    </div>
</section>

<section class="section-gap" id="cta">
    <div class="wrap cta-block reveal">
        <h2 style="font-size:2.1rem; font-weight:800; margin-bottom:8px;">Start Accepting Payments in Minutes</h2>
        <p style="opacity:0.92; margin-bottom:0;">Get onboarding support, launch fast, and scale with confidence.</p>
        <form class="cta-form">
            <input type="email" placeholder="Enter your work email" aria-label="email input">
            <button type="button">Request Access</button>
        </form>
    </div>
</section>

<script>
    const revealEls = document.querySelectorAll(".reveal");
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("show");
            }
        });
    }, { threshold: 0.2 });
    revealEls.forEach((el) => revealObserver.observe(el));

    const counters = document.querySelectorAll(".counter");
    const counterObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const target = parseFloat(el.getAttribute("data-target") || "0");
            const isDecimal = String(target).includes(".");
            let current = 0;
            const step = target / 70;
            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    el.textContent = isDecimal ? target.toFixed(2) : Math.round(target).toLocaleString();
                    clearInterval(timer);
                } else {
                    el.textContent = isDecimal ? current.toFixed(2) : Math.round(current).toLocaleString();
                }
            }, 26);
            observer.unobserve(el);
        });
    }, { threshold: 0.35 });
    counters.forEach((counter) => counterObserver.observe(counter));
</script>
@endsection