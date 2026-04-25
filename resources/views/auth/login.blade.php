<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In - {{ config('app.name', 'Instopay') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('assets/css/dark-fintech-theme.css')}}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --pg-primary: #A855F7;
            --pg-secondary: #7C3AED;
            --pg-accent: #C084FC;
            --pg-grad-start: #4C1D95;
            --pg-grad-end: #7C3AED;
        }
        * { box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            margin: 0;
            font-family: "Inter", sans-serif;
            background: #f3f4f8;
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
            background: radial-gradient(circle at 15% 20%, rgba(168,85,247,0.18), transparent 40%),
                        radial-gradient(circle at 85% 80%, rgba(124,58,237,0.2), transparent 38%),
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
            max-width: 540px;
            z-index: 2;
        }
        .auth-card {
            width: 100%;
            max-width: 460px;
            background: #fff;
            border: 1px solid rgba(124, 58, 237, 0.14);
            border-radius: 16px;
            box-shadow: 0 24px 48px rgba(76, 29, 149, 0.12);
            padding: 34px 30px 26px;
        }
        .auth-title { margin: 0 0 4px; font-size: 28px; font-weight: 800; color: #0f172a; }
        .auth-subtitle { margin: 0 0 20px; color: #64748b; font-size: 14px; }
        .form-group { margin-bottom: 14px; }
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
            height: 48px;
            border-radius: 12px;
            border: 1px solid #d9d6fe;
            background: #f8f8ff;
            padding: 0 44px 0 38px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: var(--pg-secondary);
            background: #fff;
            box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.18);
        }
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #7c3aed;
            font-size: 13px;
            cursor: pointer;
            font-weight: 600;
        }
        .form-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 4px 0 14px;
            font-size: 13px;
        }
        .form-meta a {
            color: #6d28d9;
            text-decoration: none;
            font-weight: 600;
        }
        .form-meta a:hover { text-decoration: underline; }
        .btn-auth {
            width: 100%;
            border: 0;
            height: 48px;
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
        .helper-link {
            margin-top: 14px;
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
        .error-text { font-size: 12px; color: #dc2626; margin-top: 6px; display: block; }
        @media (max-width: 991px) {
            .auth-panel { padding: 24px 14px 30px; }
            .auth-card { padding: 24px 16px 18px; border-radius: 14px; }
            .page-back {
                top: 12px;
                left: 12px;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>
@php($brandName = config('app.name', 'Instopay'))
<div class="auth-shell">
    <a href="{{ url('') }}" class="page-back"><i class="fa fa-arrow-left"></i> Back</a>
    <span class="bubble one"></span>
    <span class="bubble two"></span>
    <span class="bubble three"></span>
    <span class="bubble four"></span>
    <span class="bubble five"></span>
    <section class="auth-panel">
        <div class="auth-card">
            <h2 class="auth-title">Sign in to {{ $brandName }}</h2>
            <p class="auth-subtitle">Welcome back. Enter your credentials to continue.</p>

            <form action="{{ url('login-now') }}" method="post" id="login-form">
                {!! csrf_field() !!}
                <input type="hidden" name="company_id" value="{{ $company_id }}">
                <input type="hidden" name="latitude" id="inputLatitude" value="0.00">
                <input type="hidden" name="longitude" id="inputLongitude" value="0.00">

                @if($errors->any())
                    <div class="alert alert-danger py-2 mb-3">{{ $errors->first() }}</div>
                @endif

                <div class="form-group">
                    <div class="input-wrap">
                        <span class="input-icon"><i class="fa fa-user"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Mobile number" maxlength="10" value="{{ old('username') }}">
                    </div>
                    @if ($errors->has('username'))
                        <span class="error-text">{{ $errors->first('username') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <div class="input-wrap">
                        <span class="input-icon"><i class="fa fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" id="passwordField" placeholder="Password">
                        <button class="password-toggle" type="button" id="togglePassword">Show</button>
                    </div>
                    @if ($errors->has('password'))
                        <span class="error-text">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <div class="form-meta">
                    <label class="mb-0 d-flex align-items-center">
                        <input type="checkbox" id="remember" class="mr-2">
                        <span>Remember me</span>
                    </label>
                    <a href="{{ url('forgot-password') }}">Forgot password?</a>
                </div>

                <div class="alert alert-danger location-div mt-2" style="display: none;">
                    <span class="locationMessage"></span>
                </div>

                <button type="submit" class="btn-auth" onclick="return validateLocation();">Sign In</button>

                <div class="helper-link">
                    Don’t have an account? <a href="{{ url('sign-up') }}">Sign up</a>
                </div>
            </form>
        </div>
    </section>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        getLocation();
        $("#togglePassword").on("click", function () {
            const field = $("#passwordField");
            const isPassword = field.attr("type") === "password";
            field.attr("type", isPassword ? "text" : "password");
            $(this).text(isPassword ? "Hide" : "Show");
        });
    });

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, handleError);
        } else {
            $(".locationMessage").text("Geolocation not supported.");
            $(".location-div").show();
        }
    }

    function showPosition(position) {
        $("#inputLatitude").val(position.coords.latitude);
        $("#inputLongitude").val(position.coords.longitude);
    }

    function handleError() {
        $(".location-div").show();
        $(".locationMessage").text("Location access denied.");
    }

    function validateLocation() {
        const lat = $("#inputLatitude").val();
        const lng = $("#inputLongitude").val();
        if (lat && lng && lat !== "0.00" && lng !== "0.00") return true;
        $(".location-div").show();
        $(".locationMessage").text("Please allow location access.");
        return false;
    }
</script>
</body>
</html>
