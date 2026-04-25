<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - {{ config('app.name', 'Instopay') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('assets/css/dark-fintech-theme.css')}}">

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <title>{{ config('app.name', 'Instopay') }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        function sign_up() {
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
                        $("#successMessage").text(msg.message);
                        $("#successMessage").show();
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
                }
            });
        }
    </script>
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(180deg, #f3efff 0%, #ffffff 100%);
        }

        .signup-container {
            display: flex;
            min-height: 100vh;
            align-items: stretch;
        }

        .left-section {
            background: linear-gradient(145deg, #4c1d95 0%, #6d28d9 50%, #7c3aed 100%);
            color: #fff;
            padding: 60px 48px;
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left-section h2 {
            font-weight: 600;
            margin-bottom: 20px;
        }

        .left-section ul {
            list-style: none;
            padding: 0;
        }

        .left-section ul li {
             list-style: none;
            margin-bottom: 15px;
            position: relative;
            padding-left: 25px;
            font-size: 16px;
        }

        .left-section ul li::before {
            content: '✔';
            font-family: 'Font Awesome 5 Free';
            color: #ddd6fe;
            font-weight: bold;
            font-size: 10px;
            border-radius: 50%;
            position: absolute;
            left: 0;
            top: 6px;
        }

        .right-section {
            background: #f8f5ff;
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px 20px;
        }

        .signup-form {
            width: 100%;
            max-width: 430px;
            background: #ffffff;
            border: 1px solid #e9ddff;
            border-radius: 16px;
            box-shadow: 0 20px 36px rgba(76, 29, 149, 0.12);
            padding: 16px 18px 14px;
            max-height: calc(100vh - 34px);
            overflow-y: auto;
        }

        .form-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .form-header i {
            font-size: 40px;
            color: #7f56d9;
            margin-bottom: 10px;
        }

        .form-header h4 {
            font-size: 22px;
            font-weight: 600;
            color: #333;
        }

        .form-group input {
            font-size: 14px;
            height: 40px;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #d8ccff;
            background: #f2efff;
            color: #1f2937;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group input:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.18);
            background: #ffffff;
        }

        .form-group input::placeholder {
            color: #777;
        }

        .signup-btn {
            background: linear-gradient(120deg, #5b21b6, #7c3aed, #a78bfa);
            color: #fff;
            padding: 9px;
            border-radius: 8px;
            font-size: 14px;
            border: none;
            width: 30%;
            margin-top: 4px;
            margin-left: 35%;
            font-weight: 600;
            box-shadow: 0 12px 20px rgba(124, 58, 237, 0.28);
        }

        .signup-btn:hover {
            background: linear-gradient(120deg, #4c1d95, #6d28d9, #8b5cf6);
        }

        .login-link {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            margin-left: 0;
        }

        .login-link a {
            color: #6d28d9;
            font-weight: 500;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 991px) {
            .signup-container {
                flex-direction: column;
            }

            .left-section,
            .right-section {
                width: 100%;
            }

            .left-section {
                padding: 34px 22px;
            }

            .left-section h2,
            .left-section ul {
                margin-left: 0 !important;
            }

            .right-section {
                padding: 24px 14px 34px;
            }

            .signup-form {
                max-width: 100%;
                padding: 22px 16px 18px;
            }

            .signup-btn {
                width: 100%;
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<div class="signup-container">
    <!-- Left Section -->
    <div class="left-section">
        <h2 style="margin-left:23%;font-size:34px;font-weight:700;letter-spacing:0.5px;">{{ config('app.name', 'Instopay') }}</h2>
        <h2 style= margin-left:23%;font-size:20px;>Why Choose {{ config('app.name', 'Instopay') }}?</h2>
        <ul style= margin-left:23%;>
            <li>Scalable B2B payment gateway</li>
            <li>Fast & secure online transactions</li>
            <li>Quick integration & onboarding</li>
            <li>Analytics and insights tools</li>
            <li>Trusted by 200+ businesses</li>
        </ul>
    </div>

    <!-- Right Section -->
    <div class="right-section">
        <div class="signup-form">
            <form action="/examples/actions/confirmation.php" method="POST">
                @csrf

                
    <div class="form-header">
        <i class="fa fa-user-circle"></i>
        <h4>Register Here</h4>
    </div>

    <div class="form-group">
        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
        <span style="color: red;" id="first_name_errors"></span>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
        <span style="color: red;" id="last_name_errors"></span>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="organization_name" id="shop_name" placeholder="Organization Name">
        <span style="color: red;" id="shop_name_errors"></span>
    </div>
    <div class="form-group">
        <input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
        <span style="color: red;" id="email_errors"></span>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number">
        <span style="color: red;" id="mobile_errors"></span>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="address" id="address" placeholder="Address">
        <span style="color: red;" id="address_errors"></span>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="pincode" id="pin_code" placeholder="Pin Code">
        <span style="color: red;" id="pin_code_errors"></span>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="city" id="city" placeholder="City">
        <span style="color: red;" id="city_errors"></span>
    </div>

    <input type="hidden" class="form-control" id="referral_code" placeholder="Referral Code"
        value="{{ $referral_code }}" @if($referral_code) disabled @endif>

    <button type="button" id="registerBtn" onclick="sign_up()" class="signup-btn">
       sign up
    </button>
      <button class="btn btn-success btn-lg btn-block" type="button" id="registerBtn_loader" disabled
                    style="display: none;"><span class="spinner-border spinner-border-sm" role="status"
                                                 aria-hidden="true"></span> Loading...
            </button>
</form>


            <div class="login-link">
                Already have an account? <a href="{{ url('login') }}">Sign in</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
