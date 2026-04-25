<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - {{ config('app.name', 'Instopay') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('assets/css/dark-fintech-theme.css')}}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        :root {
            --pg-primary: #A855F7;
            --pg-secondary: #7C3AED;
            --pg-accent: #C084FC;
            --pg-grad-start: #4C1D95;
            --pg-grad-end: #7C3AED;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Inter", sans-serif;
            background: #f2f5ff;
            color: #0f172a;
        }
        .auth-shell {
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            overflow: hidden;
            background: radial-gradient(circle at 14% 22%, rgba(168,85,247,0.18), transparent 40%),
                        radial-gradient(circle at 82% 78%, rgba(124,58,237,0.2), transparent 38%),
                        linear-gradient(160deg, #f8f9ff 0%, #eef2ff 45%, #f6f4ff 100%);
        }
        .page-back {
            position: absolute;
            top: 18px;
            left: 18px;
            z-index: 5;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #ddd6fe;
            background: rgba(255, 255, 255, 0.9);
            color: #6d28d9;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            border-radius: 12px;
            padding: 9px 13px;
            box-shadow: 0 10px 20px rgba(76, 29, 149, 0.12);
            transition: all 0.2s ease;
        }
        .page-back:hover {
            background: #f3edff;
            color: #5b21b6;
            text-decoration: none;
            transform: translateY(-1px);
        }
        .auth-shell::before,
        .auth-shell::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            filter: blur(2px);
            z-index: 0;
            animation: floatBubble 10s ease-in-out infinite alternate;
        }
        .auth-shell::before {
            width: 260px;
            height: 260px;
            top: -60px;
            left: -30px;
            background: radial-gradient(circle at 30% 30%, rgba(192,132,252,0.55), rgba(124,58,237,0.2));
        }
        .auth-shell::after {
            width: 320px;
            height: 320px;
            bottom: -120px;
            right: -70px;
            background: radial-gradient(circle at 30% 30%, rgba(168,85,247,0.5), rgba(76,29,149,0.15));
            animation-delay: 1.2s;
        }
        .bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(124, 58, 237, 0.12);
            z-index: 0;
            animation: floatBubble 8s ease-in-out infinite alternate;
        }
        .bubble.one { width: 90px; height: 90px; top: 18%; right: 22%; }
        .bubble.two { width: 54px; height: 54px; bottom: 18%; left: 18%; animation-delay: .8s; }
        .bubble.three { width: 36px; height: 36px; top: 32%; left: 26%; animation-delay: 1.4s; }
        .bubble.four { width: 120px; height: 120px; top: 64%; right: 14%; animation-delay: 2.1s; opacity: 0.55; }
        .bubble.five { width: 70px; height: 70px; top: 14%; left: 44%; animation-delay: 2.8s; opacity: 0.45; }
        @keyframes floatBubble {
            0% { transform: translate3d(0, 0, 0); }
            50% { transform: translate3d(8px, -16px, 0); }
            100% { transform: translate3d(-6px, -28px, 0); }
        }
        .auth-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 980px;
            z-index: 2;
        }
        .auth-card {
            width: 100%;
            max-width: 980px;
            background: #fff;
            border: 1px solid rgba(124, 58, 237, 0.15);
            border-radius: 16px;
            box-shadow: 0 24px 48px rgba(76, 29, 149, 0.12);
            padding: 20px 20px 16px;
        }
        .auth-title { margin: 0 0 4px; font-size: 28px; font-weight: 800; color: #0f172a; }
        .auth-subtitle { margin: 0 0 16px; color: #64748b; font-size: 14px; }
        .form-group { margin-bottom: 12px; }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 12px;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #7c3aed;
            font-size: 14px;
            pointer-events: none;
        }
        .form-control {
            height: 44px;
            border-radius: 12px;
            border: 1px solid #d9d6fe;
            background: #f8f8ff;
            padding: 0 12px 0 38px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: var(--pg-secondary);
            background: #fff;
            box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.18);
        }
        .error-text { font-size: 12px; color: #dc2626; margin-top: 6px; display: block; }
        .btn-auth {
            width: 220px;
            border: 0;
            height: 46px;
            border-radius: 12px;
            color: #fff;
            font-weight: 700;
            font-size: 15px;
            background: linear-gradient(90deg, #4C1D95, #7C3AED);
            box-shadow: 0 12px 26px rgba(76, 29, 149, 0.3);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-auth:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 16px 28px rgba(76, 29, 149, 0.38);
        }
        .signup-actions {
            display: flex;
            justify-content: center;
            margin-top: 2px;
        }
        .helper-link {
            margin-top: 10px;
            text-align: center;
            font-size: 14px;
            color: #475569;
        }
        .helper-link a {
            color: #6d28d9;
            font-weight: 700;
            text-decoration: none;
        }
        .helper-link a:hover { text-decoration: underline; }
        @media (max-width: 991px) {
            .auth-panel { padding: 24px 14px 30px; }
            .auth-card { padding: 20px 14px 14px; border-radius: 14px; }
            .form-grid { grid-template-columns: 1fr; }
            .page-back {
                top: 12px;
                left: 12px;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>
<div class="auth-shell">
    <a href="{{ url('') }}" class="page-back"><i class="fa fa-arrow-left"></i> Back</a>
    <span class="bubble one"></span>
    <span class="bubble two"></span>
    <span class="bubble three"></span>
    <span class="bubble four"></span>
    <span class="bubble five"></span>
    <section class="auth-panel">
        <div class="auth-card">
            <h2 class="auth-title">Create account</h2>
            <p class="auth-subtitle">Enter your details to get started.</p>

            <div class="alert alert-success py-2 mb-3" id="successMessage" style="display:none;"></div>

            <form method="POST" onsubmit="return false;">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
                        </div>
                        <span class="error-text" id="first_name_errors"></span>
                    </div>

                    <div class="form-group">
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa fa-user-o"></i></span>
                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
                        </div>
                        <span class="error-text" id="last_name_errors"></span>
                    </div>

                    <div class="form-group">
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa fa-building"></i></span>
                            <input type="text" class="form-control" name="organization_name" id="shop_name" placeholder="Organization Name">
                        </div>
                        <span class="error-text" id="shop_name_errors"></span>
                    </div>

                    <div class="form-group">
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
                        </div>
                        <span class="error-text" id="email_errors"></span>
                    </div>

                    <div class="form-group">
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa fa-phone"></i></span>
                            <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number">
                        </div>
                        <span class="error-text" id="mobile_errors"></span>
                    </div>

                    <div class="form-group">
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa fa-map-marker"></i></span>
                            <input type="text" class="form-control" name="address" id="address" placeholder="Address">
                        </div>
                        <span class="error-text" id="address_errors"></span>
                    </div>

                    <div class="form-group">
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa fa-thumb-tack"></i></span>
                            <input type="text" class="form-control" name="pincode" id="pin_code" placeholder="Pin Code">
                        </div>
                        <span class="error-text" id="pin_code_errors"></span>
                    </div>

                    <div class="form-group">
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa fa-location-arrow"></i></span>
                            <input type="text" class="form-control" name="city" id="city" placeholder="City">
                        </div>
                        <span class="error-text" id="city_errors"></span>
                    </div>
                </div>

                <input type="hidden" class="form-control" id="referral_code" placeholder="Referral Code" value="{{ $referral_code }}">

                <div class="signup-actions">
                    <button type="button" id="registerBtn" onclick="sign_up()" class="btn-auth">Sign Up</button>
                </div>
                <button class="btn btn-success btn-lg btn-block mt-2" type="button" id="registerBtn_loader" disabled style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                </button>
            </form>

            <div class="helper-link">
                Already have an account? <a href="{{ url('login') }}">Sign in</a>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    function sign_up() {
        $("#first_name_errors, #last_name_errors, #mobile_errors, #email_errors, #shop_name_errors, #address_errors, #pin_code_errors, #city_errors").text("");
        $("#registerBtn").hide();
        $("#registerBtn_loader").show();

        var token = $("input[name=_token]").val();
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var mobile = $("#mobile").val();
        var email = $("#email").val();
        var shop_name = $("#shop_name").val();
        var address = $("#address").val();
        var pin_code = $("#pin_code").val();
        var city = $("#city").val();
        var referral_code = $("#referral_code").val();

        var dataString = 'first_name=' + first_name + '&last_name=' + last_name + '&mobile=' + mobile + '&email=' + email + '&shop_name=' + shop_name + '&address=' + address + '&pin_code=' + pin_code + '&city=' + city + '&referral_code=' + referral_code + '&_token=' + token;

        $.ajax({
            type: "POST",
            url: "{{url('sign-up')}}",
            data: dataString,
            success: function (msg) {
                $("#registerBtn").show();
                $("#registerBtn_loader").hide();

                if (msg.status == 'success') {
                    $("#successMessage").text(msg.message).show();
                    window.setTimeout(function () {
                        window.location.href = "{{url('login')}}";
                    }, 3000);
                } else if (msg.status == 'validation_error') {
                    $("#first_name_errors").text(msg.errors.first_name);
                    $("#last_name_errors").text(msg.errors.last_name);
                    $("#mobile_errors").text(msg.errors.mobile);
                    $("#email_errors").text(msg.errors.email);
                    $("#shop_name_errors").text(msg.errors.shop_name);
                    $("#address_errors").text(msg.errors.address);
                    $("#pin_code_errors").text(msg.errors.pin_code);
                    $("#city_errors").text(msg.errors.city);
                } else {
                    alert(msg.message);
                }
            },
            error: function () {
                $("#registerBtn").show();
                $("#registerBtn_loader").hide();
                alert("Something went wrong. Please try again.");
            }
        });
    }
</script>
</body>
</html>
