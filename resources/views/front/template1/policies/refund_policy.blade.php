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
                <li><span>Refund Policy</span></li>
            </ul>
            <h1 class="page-title">Refund Policy</h1>
        </div>
        <div class="page-card">
            <div class="page-content">
                <p>
                    At Instopay, we aim to ensure transparent and fair transaction handling for all users and merchants.
                    Please read our refund policy carefully:
                </p>
                <p>→ Refunds are only applicable in cases of failed, duplicate, or unauthorized transactions initiated via Instopay's payment gateway.</p>
                <p>→ If a transaction has been debited from your account but not reflected to the intended merchant or beneficiary, a refund will be processed after verification.</p>
                <p>→ Users must report refund-related issues within <strong>7 days</strong> from the transaction date by emailing <strong>support@instopay.in</strong> along with transaction details.</p>
                <p>→ Refunds will be initiated only after internal validation and confirmation from the respective payment processor or bank.</p>
                <p>→ Instopay is not responsible for delays caused by banking networks, weekends, or public holidays.</p>
                <p>→ Once approved, refunds will be credited to the original payment method within <strong>5-10 business days</strong>, depending on the payment source.</p>
                <p>→ No refunds will be entertained for successfully completed transactions or in cases where the services/products have already been delivered.</p>
                <p>→ In the case of merchant-specific refund policies (for goods or services purchased), users are advised to contact the respective merchant directly.</p>
                <p>→ Instopay reserves the right to deny refund requests if any fraudulent, abusive, or suspicious behavior is detected.</p>
                <p>→ This policy is subject to change without prior notice. Updates, if any, will be published on this page.</p>
                <p>For any queries or assistance, please contact us at <strong>support@instopay.in</strong>.</p>
            </div>
        </div>
    </div>
</section>
@endsection

