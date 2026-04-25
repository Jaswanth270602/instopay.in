<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name', 'Instopay') }}</title>
    <!-- web fonts -->
    <link href="//fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <!-- //web fonts -->
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{url('front/css/style-freedom.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/dark-fintech-theme.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<script src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<script src="//m.servedby-buysellads.com/monetization.js" type="text/javascript"></script>

<script src="https://codefund.io/properties/441/funder.js" async="async"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src='https://www.googletagmanager.com/gtag/js?id=UA-149859901-1'></script>

<meta name="robots" content="noindex">
<body>

@if (Auth::guest())

@else
    @if(Auth::user()->role_id <= 7)
        <script type="text/javascript">
            document.location.href = "admin/dashboard";
        </script>
    @else
        <script type="text/javascript">
            document.location.href = "agent/dashboard";
        </script>
    @endif
@endif
{!! $chat_script !!}

<link rel="stylesheet" href="{{url('front/css/demobar_w3_4thDec2019.css')}}">

<!-- //Top Menu 1 -->
<section class="bg-dark">
    <nav class="navbar navbar-expand-lg navbar-light py-lg-2 py-2">
        <div class="container">
            <a class="navbar-brand text-white font-weight-bold" href="{{url('')}}" style="font-size: 34px; letter-spacing: 0.5px;">Instopay</a>
            <!-- if logo is image enable this
            <a class="navbar-brand" href="#index.html">
                <img src="image-path" alt="Your logo" title="Your logo" style="height:35px;" />
            </a> -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon fa fa-bars"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link text-white fw-semibold" href="{{url('')}}">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white fw-semibold" href="{{url('pages')}}/{{$company_id}}/about-us">About Us</a></li>
                    <li class="nav-item"><a class="nav-link text-white fw-semibold" href="{{url('')}}#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link text-white fw-semibold" href="{{url('')}}#how">How It Works</a></li>
                    <li class="nav-item"><a class="nav-link text-white fw-semibold" href="{{url('')}}#stats">Stats</a></li>
                    <li class="nav-item"><a class="nav-link text-white fw-semibold" href="{{url('')}}#testimonials">Testimonials</a></li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="{{url('contact-us')}}">Contact</a>
                    </li>
                </ul>
                <form class="form-inline">
                    <a class="btn btn-secondary btn-theme" href="{{url('login')}}"> Login</a>
                </form>
                   &nbsp; &nbsp;
                @if($registration_status == 1)
                <form class="form-inline">
                    <a class="btn btn-primary btn-theme" href="{{url('sign-up')}}"> Register</a>
                </form>
                @endif
            </div>
        </div>
    </nav>
</section>

<style>
    /* Shared static header + footer modern styling */
    .bg-dark {
        background: linear-gradient(90deg, #4C1D95, #7C3AED, #A855F7) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.16);
        box-shadow: 0 12px 24px rgba(76, 29, 149, 0.22);
    }

    .bg-dark .navbar .nav-link {
        color: #ffffff !important;
        font-weight: 700 !important;
        opacity: 0.95;
    }

    .bg-dark .navbar .nav-link:hover {
        opacity: 1;
        text-decoration: underline;
        text-underline-offset: 4px;
    }

    .bg-dark .btn-theme {
        border-radius: 10px !important;
        border: 1px solid rgba(255, 255, 255, 0.24) !important;
        background: rgba(255, 255, 255, 0.12) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
    }

    .bg-dark .btn-theme:hover {
        background: rgba(255, 255, 255, 0.2) !important;
        color: #ffffff !important;
    }

    .w3l-footer-29-main .footer-29 {
        background: linear-gradient(90deg, #4C1D95, #7C3AED, #A855F7) !important;
    }
</style>

@yield('content')

<section class="w3l-footer-29-main">
    <div class="footer-29 site-footer-modern">
        <div class="container">
            <div class="d-grid grid-col-4 footer-top-29">
                <div class="footer-list-29 footer-1">
                    <h6 class="footer-title-29"><a href="{{url('')}}" style="font-size: 28px; font-weight: 700; color: #ffffff; text-decoration: none;">Instopay</a></h6>
                    <p style="color:#e9ddff; max-width: 280px;">A high-performance payment infrastructure platform built for ambitious businesses.</p>
                </div>
                <div class="footer-list-29 footer-2">
                    <ul>
                        <h6 class="footer-title-29">Platform</h6>
                        <li><a href="{{url('')}}#features">Payments</a></li>
                        <li><a href="{{url('')}}#features">Payouts</a></li>
                        <li><a href="{{url('')}}#features">Fraud Shield</a></li>
                        <li><a href="{{url('')}}#stats">Analytics</a></li>
                    </ul>
                </div>

                <div class="footer-list-29 footer-3">
                    <ul>
                        <h6 class="footer-title-29">Company</h6>
                        <li><a href="{{url('pages')}}/{{$company_id}}/about-us">About</a></li>
                        <li><a href="{{url('')}}#testimonials">Customers</a></li>
                        <li><a href="{{url('contact-us')}}">Contact</a></li>
                    </ul>
                </div>

                <div class="footer-list-29 footer-4">
                    <ul>
                        <h6 class="footer-title-29">Quick Links</h6>
                        <li><a href="{{ route('privacy_policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('refund_policy') }}">Refund Policy</a></li>
                        <li><a href="{{ route('terms_and_conditions') }}">Terms and Conditions</a></li>
                    </ul>
                </div>
            </div>
            <div class="d-grid grid-col-2 bottom-copies">
                <p class="copy-footer-29">© {{ date('Y') }} {{ config('app.name', 'Instopay') }}. All rights reserved </p>
                <ul class="list-btm-29">
                    <li><a href="{{ route('privacy_policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('refund_policy') }}">Refund Policy</a></li>
                    <li><a href="{{ route('terms_and_conditions') }}">Terms and Conditions</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- move top -->
    <button onclick="topFunction()" id="movetop" title="Go to top">
        <span class="fa fa-angle-up"></span>
    </button>
    <style>
        body {
            padding-top:10px !important;
        }
    </style>
    <script>
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function () {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("movetop").style.display = "block";
            } else {
                document.getElementById("movetop").style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
    <!-- /move top -->
</section>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!-- //footer-28 block -->
</section>
<script>
    $(function () {
        $('.navbar-toggler').click(function () {
            $('body').toggleClass('noscroll');
        })
    });
</script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
</script>

<!-- Template JavaScript -->
<script src="{{url('front/js/all.js')}}"></script>
<!-- Smooth scrolling -->
<!-- <script src="assets/js/smoothscroll.js"></script> -->


</body>

</html>
<!-- // grids block 5 -->

