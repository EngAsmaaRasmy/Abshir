<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:image:src" content="">
    <meta property="og:image" content="">
    <meta name="twitter:title" content="Home">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="shortcut icon" href="{{asset('favicon.ico') }}">
    <link rel="icon" href="{{asset('assets/images/group-1079-406x366.png')}}" type="image/png">
    <meta name="description" content="">

    <script src="https://www.merchant.geidea.net/hpp/geideapay.min.js" defer></script>

    <title>Geidea Pay</title>
    <link rel="stylesheet" href="{{asset('assets/web/assets/mobirise-icons/mobirise-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/icon54/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/iconsMind/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/tether/tether.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap-grid.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap-reboot.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/chatbutton/floating-wpp.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dropdown/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/socicon/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('assets/theme/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/recaptcha.css')}}">
    <link href="{{asset('assets/fonts/style.css" rel="stylesheet')}}">
    <link rel="preload"
        href="{{asset('https://fonts.googleapis.com/css?family=Cairo:200,300,400,500,600,700,800,900&display=swap')}}"
        as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet"
            href="{{asset('https://fonts.googleapis.com/css?family=Cairo:200,300,400,500,600,700,800,900&display=swap')}}">
    </noscript>
    <link rel="preload" as="style" href="{{asset('assets/mobirise/css/mbr-additional.css')}}">
    <link rel="stylesheet" href="{{asset('assets/mobirise/css/mbr-additional.css')}}" type="text/css">

</head>


<body>
    <section class="menu menu02 photom4_menu02 cid-t3UYHf2a47" once="menu" id="menu02-1">
        <nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
            <div class="navbar-brand">

                <span class="navbar-caption-wrap"><a class="navbar-caption text-white text-primary display-5"
                        href="index.html#top">ABSHIR</a></span>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <div class="icons-menu">
                    <a href="https://twitter.com/Abshirapp1?t=lHSFrMp4srYjMxWsHNHnEg&s=08" target="_blank">
                        <span class="p-2 mbr-iconfont icon54-v1-twitter-1"></span>
                    </a>
                    <a href="#" data-toggle="modal" data-bs-toggle="modal" data-target="#mbr-popup-b"
                        data-bs-target="#mbr-popup-b">
                        <span class="p-2 mbr-iconfont socicon-tiktok socicon"></span>
                    </a>
                    <a href="https://www.facebook.com/Abshirapp1" target="_blank">
                        <span class="p-2 mbr-iconfont icon54-v1-facebook-1"></span>
                    </a>



                </div>
                <div class="navbar-buttons mbr-section-btn">
                    <a class="btn btn-sm btn-warning display-4" href="tel:00201154446018">
                        <span class="imind-telephone mbr-iconfont mbr-iconfont-btn">
                        </span>&nbsp;Call&nbsp; US!
                    </a>
                </div>
            </div>
        </nav>
    </section>
    <section data-bs-version="5.1" class="header3 cid-t3V203Nyaf mbr-fullscreen" id="header3-9">

        <div class="container-fluid">
            <div class="row justify-content-center">


                <div class="navbar-buttons mbr-section-btn">
                    <a type="button" class="btn btn-sm btn-warning display-4" id="geidea_payment"
                        onclick="pay()">Pay</a>
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                </div>

            </div>
        </div>
    </section>

    <script>
        let token = document.getElementById('token')
        function pay(){
            var customer_id = '{{ $customer->id }}';
            var amount = '{{ $amount }}';          
            amount = parseInt(amount);  
            var merchantKey = 'e5d3aa2c-2414-4004-8af6-acb3b496d783';
            var onSuccess = function () {

                $.ajax({
                    url: "/done",
                    type: "POST",
                    data: function() {
                        var data = new FormData();
                        data.append("_token", token.value);
                        data.append("customer_id", customer_id);
                        data.append("amount", amount);
                        console.log(data.get('customer_id'),data.get('amount'));
                        return data;
                    }(),
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#successMsg').show();
                        console.log(' ** onSuccess **')
                        window.location.href = "/payment-success";
                        apiResponseِ("success");                        
                    },
                    error: function(jqXHR, textStatus, errorMessage) {
                        console.log(errorMessage);
                        $('#errorMsg').show();
                        $('#errorMsg').val(errorMessage);
                    }
                });

            };
            var onError = function () {
                window.location.href = "/payment-failed";
                console.log(' ** onError **')
                
            };
            var onCancel = function () {
                window.location.href = "/payment-failed";
                console.log(' ** onCancel **')
            };

            const payment = new GeideaApi(merchantKey, onSuccess, onError, onCancel);
        
            payment.configurePayment({

                "amount": amount, 
                "currency": "EGP", 
                /*
                "callbackUrl": "string", 
                "merchantReferenceId": "string", 
                "merchantLogoUrl": "string", 
                "cardOnFile": "boolean", 
                "initiatedBy": "string", 
                "agreementId": "string", 
                "agreementType": "string", 
                "eInvoiceId": "string", 
                */
                "paymentOperation": "Pay", 
                /*
                "styles": { 
                    "headerColor": "hexadecimalCode", 
                    "hppProfile": "string" 
                }, 
                "address": { 
                    "showAddress": "boolean", 
                    "billing": { 
                        "country": "string", 
                        "city": "string", 
                        "street": "string", 
                        "postcode": "string" 
                    }, 
                    "shipping": { 
                        "country": "string", 
                        "city": "string", 
                        "street": "string", 
                        "postcode": "string" 
                    } 
                }, 
                    "email": {
                    "email": "string",
                    "showEmail": "boolean"
                }
                */
            });
            
            payment.startPayment();
            console.log();
        }

    </script>

    <script src="{{asset('assets/web/assets/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/popper/popper.min.js')}}"></script>
    <script src="{{asset('assets/tether/tether.min.js')}}"></script>
    <script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/smoothscroll/smooth-scroll.js')}}"></script>
    <script src="{{asset('assets/chatbutton/floating-wpp.js')}}"></script>
    <script src="{{asset('assets/chatbutton/script.js')}}"></script>
    <script src="{{asset('assets/dropdown/js/nav-dropdown.js')}}"></script>
    <script src="{{asset('assets/dropdown/js/navbar-dropdown.js')}}"></script>
    <script src="{{asset('assets/touchswipe/jquery.touch-swipe.min.js')}}"></script>
    <script src="{{asset('assets/popup-plugin/script.js')}}"></script>
    <script src="{{asset('assets/popup-overlay-plugin/script.js')}}"></script>
    <script src="{{asset('assets/countdown/jquery.countdown.min.js')}}"></script>
    <script src="{{asset('assets/ytplayer/jquery.mb.ytplayer.min.js')}}"></script>
    <script src="{{asset('assets/vimeoplayer/jquery.mb.vimeo_player.js')}}"></script>
    <script src="{{asset('assets/theme/js/script.js')}}"></script>
    <script src="{{asset('assets/formoid.min.js')}}"></script>


</body>

</html>