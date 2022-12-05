<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>forget password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 550px">
        <div class="alert alert-danger" id="error" style="display: none;"></div>
        <h3>أضف رقم الهاتف  </h3>
        <div class="alert alert-success" id="successAuth" style="display: none;"></div>
        <form>
            <label>رقم الهاتف :</label>
            <input type="text" id="number" class="form-control my-1" placeholder="010 ********">
            <div id="recaptcha-container"></div>
            <button type="button" class="btn btn-primary mt-3" onclick="sendOTP();">إرسال الكود </button>
        </form>

        <div class="mb-5 mt-5">
            <h3>الكود  </h3>
            <div class="alert alert-success" id="successOtpAuth" style="display: none;"></div>
            <form>
                <input type="text" id="verification" class="form-control" placeholder="Verification code">
                <button type="button" class="btn btn-danger mt-3" onclick="verify()">Verify code</button>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

    <script>
        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        var  firebaseConfig = {
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
        window.onload = function () {
            render();
        };
        function render() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
            recaptchaVerifier.render();
        }
        function sendOTP() {
            var number = '+2'+ $("#number").val();
            firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
                window.confirmationResult = confirmationResult;
                coderesult = confirmationResult;
                $("#successAuth").text("Message sent");
                $("#successAuth").show();
            }).catch(function (error) {
                $("#error").text(error.message);
                $("#error").show();
            });
        }
        function verify() {
            var code = $("#verification").val();
            coderesult.confirm(code).then(function (result) {
                var user = result.user;
                console.log(user);
                $("#successOtpAuth").text("Auth is successful");
                $("#successOtpAuth").show();
            }).catch(function (error) {
                $("#error").text(error.message);
                $("#error").show();
            });
        }
    </script>
</body>
</html>