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
                <li><span>Terms and Conditions</span></li>
            </ul>
            <h1 class="page-title">Terms and Conditions</h1>
        </div>
        <div class="page-card">
            <div class="page-content">
                <p>
                    By accessing or using the Instopay platform, you agree to comply with all terms outlined in this agreement.
                </p>
                <p>→ Instopay offers digital payment services including UPI, credit/debit cards, net banking, wallets, and recurring billing for approved users and merchants.</p>
                <p>→ All users must provide accurate, complete, and verifiable information during registration and while using the platform.</p>
                <p>→ Misuse of the platform, including fraudulent activity, impersonation, or unauthorized access, is strictly prohibited and may lead to legal action and account termination.</p>
                <p>→ Users are responsible for maintaining the confidentiality of their login credentials and for any actions taken under their account.</p>
                <p>→ Instopay reserves the right to verify transactions, suspend accounts, or block payments in case of suspicious, high-risk, or policy-violating activity.</p>
                <p>→ All services are subject to applicable laws and regulations including those mandated by the Reserve Bank of India (RBI).</p>
                <p>→ The platform may undergo maintenance, updates, or changes without prior notice, and Instopay does not guarantee uninterrupted access at all times.</p>
                <p>→ We are not liable for any direct or indirect loss arising from service interruptions, transaction failures, or external service provider delays.</p>
                <p>→ Merchants are responsible for ensuring their own refund, delivery, and product/service policies, which must be clearly disclosed to end-users.</p>
                <p>→ Instopay reserves the right to modify these Terms and Conditions at any time. Updated terms will be posted on this page and will take immediate effect.</p>
                <p>→ Continued use of the platform after any such changes constitutes your acceptance of the revised terms.</p>
                <p>For any queries regarding these terms, please contact us at <strong>support@instopay.in</strong>.</p>
            </div>
        </div>
    </div>
</section>
@endsection

