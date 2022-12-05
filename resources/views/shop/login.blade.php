<!DOCTYPE html>
<html class="loading" dir="rtl" lang="ar">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords"
        content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>HMF Shop</title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors-rtl.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/icheck.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/custom.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/custom-rtl.css') }}">
    <!-- END: Theme CSS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@200&display=swap" rel="stylesheet">



    <!-- Style -->
    {{-- <link rel="stylesheet" href="{{asset("assets/css/shopLogin/css/style.css")}}"> --}}
</head>

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu 1-column   blank-page" data-open="click" data-menu="vertical-menu"
    data-col="1-column" style="font-family: 'Noto Kufi Arabic', sans-serif;">



    <section class="vh-100" style="background-color: #F6C163;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                @if (Session::has('success'))
                    <button type="text" class="btn btn-lg btn-block btn-success"
                        id="type-error">{{ Session::get('success') }}
                    </button>
                @endif
                @error('not-found')
                    <div class="alert bg-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong>{{ $message }}
                    </div>
                @enderror
                <div class="card" style="border-radius: 1rem;">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-6 d-none d-md-block">
                            <img src="{{ asset('app-assets/images/login.png') }}" alt="login form" class="img-fluid"
                                style="border-radius: 0rem 1rem 1rem 0rem; height: 550px;" />
                        </div>
                        <div class="col-md-6 col-lg-6 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">
                                <form method="post" action="{{ route('shop.login') }}">
                                    @csrf
                                    <h2 class="mb-1" style="">تسجيل الدخول كمتجر </h5>


                                        <div class="form-outline mb-4">
                                            <input required type="text" class="form-control form-control-lg"
                                                placeholder=" رقم الهاتف" name="phone" value="{{ old('phone') }}">
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input required type="password" class="form-control form-control-lg"
                                                name="password" placeholder="كلمة السر">
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-6 col-12 text-center text-sm-left">
                                                <fieldset>
                                                    <input type="checkbox" id="remember" name="remember"
                                                        class="chk-remember">
                                                    <label for="remember-me"> تذكرنى</label>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <a data-toggle="modal" data-target="#exampleModalCenter"
                                            style="color: #F6C163 !important; text-decoration: underline;">هل نسيت
                                            كلمة السر؟ </a>

                                        <button type="submit" class="btn btn-info btn-block my-1"
                                            style="background-color: #F6C163 !important; border-color: #F6C163 !important;"><i
                                                class="ft-unlock"></i> تسجيل دخول</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-header" style="border: none; text-align: right;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4 px-5">
                        <div class="main-content text-center">

                            <a href="#" class="close-btn" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><span class="icon-close2"></span></span>
                            </a>

                            <div class="warp-icon mb-4">
                                <span class="icon-lock2"></span>
                            </div>
                            <div class="alert alert-danger" id="error"
                                style="display: none;  color: #fff !important;"></div>
                            <div class="alert alert-danger" id="phoneError"
                                style="display: none; color: #fff !important;">رقم الهاتف غير مُسجل من قبل</div>
                            <div class="alert alert-success" id="successAuth" style="display: none;"></div>
                            <div class="alert alert-success" id="successOtpAuth" style="display: none;"></div>
                            <div id="phonecheck">
                                <h3>أضف رقم الهاتف </h3>
                                <form method="post">
                                    <input type="text" id="number" class="form-control my-1"
                                        placeholder="010 ********">
                                    <input type="hidden" name="_token" id="token"
                                        value="{{ csrf_token() }}">
                                    <div id="recaptcha-container"></div>
                                    <button type="button" class="btn btn-primary mt-3" onclick="checkPhone();">إرسال
                                        الكود </button>
                                </form>
                            </div>
                            <div class="mb-5 mt-5" id="otp" style="display: none;">
                                <h3>الكود </h3>
                                <form>
                                    <input type="text" id="verification" class="form-control"
                                        placeholder="الكود ">
                                    <button type="button" class="btn btn-danger mt-3" onclick="verify()">تأكيد الكود
                                    </button>
                                </form>
                            </div>

                            <div class="mb-5 mt-5" id="resetPassword" style="display: none;">
                                <h3>تغيير كلمة السر </h3>
                                <form method="post" action="{{ route('forgetPassword') }}">
                                    @csrf
                                    <input type="hidden" name="phone" id="phone">
                                    <div class="form-outline mb-4">
                                        <input required type="password" class="form-control form-control-lg"
                                            id="form2Example27" name="password" placeholder="كلمة السر">
                                    </div>

                                    <button type="submit" class="btn btn-info btn-block my-1"
                                        style="background-color: #F6C163 !important; border-color: #F6C163 !important;"><i
                                            class="ft-unlock"></i> تغيير كلمة السر</button>
                                </form>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Content-->

    <script src="{{ asset('assets/js/shopLogin/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/shopLogin/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/shopLogin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/shopLogin/js/main.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

    <script>
        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        var firebaseConfig = {
            apiKey: "AIzaSyA_DCkuIWrydDmrVlt_hmqgIp9zndSvVN4",
            authDomain: "hmf-project-9049a.firebaseapp.com",
            databaseURL: "https://hmf-project-9049a-default-rtdb.firebaseio.com",
            projectId: "hmf-project-9049a",
            storageBucket: "hmf-project-9049a.appspot.com",
            messagingSenderId: "559175099856",
            appId: "1:559175099856:web:cc4b88c17c080ef20045d5",
            measurementId: "G-EYLQD83G5K"
        };

        firebase.initializeApp(firebaseConfig);
    </script>
    <script type="text/javascript">
        var phone = document.getElementById('phone');
        var number = document.getElementById('number');
        var token = document.getElementById('token');

        window.onload = function() {
            render();
        };

        function render() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
            recaptchaVerifier.render();
        }

        function changePhone() {
            console.log('adijefgi');
            $('#phoneError').hide();
            $("#successAuth").hide();
        }

        number.onchange = changePhone();

        function checkPhone() {
            $.ajax({
                url: "/shop/check-phone",
                type: "POST",
                data: function() {
                    var data = new FormData();
                    data.append("_token", token.value);
                    data.append("phone", number.value);
                    return data;
                }(),
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == false) {
                        $('#phoneError').show();
                    } else {
                        sendOTP();
                    }
                    console.log(response.error);
                },
                error: function(jqXHR, textStatus, errorMessage) {
                    console.log(errorMessage);
                    $('#error').show();
                    $('#error').val(errorMessage);
                }
            });

        };

        function sendOTP() {
            var number = '+2' + $("#number").val();
            firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult) {
                window.confirmationResult = confirmationResult;
                coderesult = confirmationResult;
                $("#successAuth").text("تم إرسال الكود بنجاح");
                $("#successAuth").show();
                $("#phonecheck").css('display', 'none');
                $("#otp").show();
                phone.value = $("#number").val();
            }).catch(function(error) {
                $("#error").text(error.message);
                $("#error").show();
            });
        }

        function verify() {
            var code = $("#verification").val();
            coderesult.confirm(code).then(function(result) {
                var user = result.user;
                console.log(user);
                $("#successOtpAuth").text("تم تأكيد الكود بنجاح");
                $("#successAuth").hide();
                $("#successOtpAuth").show();
                $("#otp").hide();
                $("#resetPassword").show();
            }).catch(function(error) {
                $("#error").text(error.message);
                $("#error").show();
            });
        }
    </script>

</body>

</html>
