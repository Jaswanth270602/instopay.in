@extends('front.template1.header')
@section('content')
<style>
    :root {
        --purple-deep: #4c1d95;
        --purple-violet: #7c3aed;
        --purple-soft: #a78bfa;
        --ink: #0f172a;
        --muted: #334155;
    }
    .page-shell {
        font-family: "Inter", sans-serif;
        color: var(--ink);
        background: linear-gradient(180deg, #f6f3ff 0%, #ffffff 52%, #f4f0ff 100%);
        padding: 20px 0 80px;
    }
    .page-wrap { width: min(1080px, 92vw); margin: 0 auto; }
    .page-hero {
        border-radius: 12px;
        padding: 16px 14px;
        color: #fff;
        background: linear-gradient(125deg, var(--purple-deep), var(--purple-violet), var(--purple-soft));
        box-shadow: 0 8px 14px rgba(76, 29, 149, 0.14);
    }
    .bread { display: flex; gap: 10px; align-items: center; margin: 0 0 10px; padding: 0; list-style: none; }
    .bread a { color: #ede9fe; text-decoration: none; font-weight: 600; }
    .bread span { color: #ddd6fe; }
    .page-title { font-size: clamp(1.8rem, 3.8vw, 2.7rem); font-weight: 800; margin: 0; }
    .page-card {
        margin-top: 10px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.92);
        border: 1px solid rgba(124, 58, 237, 0.17);
        box-shadow: 0 6px 12px rgba(15, 23, 42, 0.06);
        padding: 16px 14px;
    }
    .page-content { color: var(--muted); font-size: 1.04rem; font-weight: 500; line-height: 1.85; }
    .page-content p { margin-bottom: 16px; }
    @media (max-width: 768px) {
        .page-hero, .page-card { padding: 12px 10px; }
    }
</style>
<section class="page-shell">
    <div class="page-wrap">
        <div class="page-hero">
            <ul class="bread">
                <li><a href="{{ url('') }}">Home</a></li>
                <li><span>/</span></li>
                <li><span>Privacy Policy</span></li>
            </ul>
            <h1 class="page-title">Privacy Policy</h1>
        </div>
        <div class="page-card">
            <div class="page-content">
                <p>
                    Instopay is a modern payment gateway that enables secure digital transactions such as UPI,
                    debit/credit cards, net banking, wallets, and more. By using our services, you agree to the
                    collection and use of personal information in accordance with this Privacy Policy.
                </p>
                <p>
                    We may collect your name, contact number, email, address, business details, and KYC information
                    to verify identity, process transactions, and provide customer support. Log data such as your IP
                    address, browser version, device info, pages visited, and timestamps may also be collected to
                    improve system reliability and security. We use cookies to store user preferences, maintain sessions,
                    and analyze traffic - you can choose to disable them via your browser settings.
                </p>
                <p>
                    We may share your data with trusted third-party providers who assist us with payment processing,
                    fraud detection, hosting, or customer service, but they are contractually obligated to use it only
                    for those purposes.
                </p>
                <p>
                    We implement strong security measures including SSL encryption, PCI-DSS compliant systems, and
                    secure servers to protect your data, though no system can guarantee 100% security. Our services are
                    not meant for individuals under 18, and we do not knowingly collect data from minors.
                </p>
                <p>
                    If you believe a child has shared information, please contact us for immediate removal. Our platform
                    may contain links to external websites - we are not responsible for their privacy practices and
                    recommend reviewing their policies. We may update this Privacy Policy from time to time, and any
                    changes will be posted on this page with immediate effect.
                </p>
                <p>
                    For questions or concerns, you can contact us at <strong>support@instopay.in</strong>. By continuing
                    to use Instopay, you acknowledge and accept this policy.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection

