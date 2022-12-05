<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abshir verification mail </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
</head>
<body style="background: #F0F0F0; font-family:Tajawal !important;">

<table>
    <tbody>
        <td style="font-family:Tajawal;display:block;max-width:750px;padding:10px;margin:0 auto!important">
    <div style="box-sizing:border-box;display:block;margin:0 auto;max-width:750px; padding:10px;">

        <table>
            <img src="{{asset('assets/emails/header.jpg')}}" style=" border-collapse:separate; height: auto; max-width:750px; margin: 0 auto; display: block; background-repeat:no-repeat;background-size:100% 100%;border-radius:0px;border-spacing:0px;width:100%" width="100%"/>
            <tbody>
                <tr>
                    <td style="font-family:Tajawal;font-size:14px;vertical-align:top;box-sizing:border-box;padding:0px" widht="100%">

                    </td>
                </tr>
            </tbody>
        </table>
    <!-- header  -->
    <table style=" border-collapse:separate;background:#fff;border-radius:0px;width:100%;margin-bottom:0px; ">
        <tbody>
            <tr>
                <td style="font-family:Verdana,sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:20px">

                    <table style="border-collapse:separate;width:100%">
                        <tbody>
                                <tr>
                                    <td style="font-family:Tajawal;font-size:14px;vertical-align:top">
                                    <p dir="rtl" style="margin-bottom:15px;list-style-type:disc">مرحبًا،</p>
                                    <p style="margin-bottom:15px;list-style-type:disc">&nbsp;</p>
                                    <p dir="rtl" style="margin-bottom:15px;list-style-type:disc">هذا رمز التحقق المؤقت لحسابك في تطبيق ابشـــــــــــر :</p>
                                    <p dir="rtl" style="font-size:15px;margin-bottom:15px;list-style-type:disc"><span style="font-size:20px; font-weight: 700;"> {{$verification_code}}</span></p>
                                    <p style="margin-bottom:15px;list-style-type:disc"><span style="background-color:transparent">&nbsp;</span></p>
                                    <p dir="rtl" style="margin-bottom:15px;list-style-type:disc">هل وصلك هذا البريد الالكتروني دون وجود أي طلب لذلك ؟<a style="color:#3498db;text-decoration:underline" href="#">تواصل معنا الان </a></p>
                                    <p style="margin-bottom:15px;list-style-type:disc">&nbsp;</p>
                                    <p dir="rtl" style="margin-bottom:15px;list-style-type:disc"><span style="background-color:transparent">تحياتنا،</span></p>
                                    <p dir="rtl" style="margin-bottom:15px;list-style-type:disc; font-weight:600;"><span style="background-color:transparent">فريق ابشـــر</span></p>
                                    </td>
                                </tr>
                        </tbody>
                        
                    </table>

                </td>
            </tr>
        </tbody>
    </table>
</div>
</td>
</tbody>
</table>
</body>
</html>