(function($) {

    "use strict";

    var password = document.getElementById("password"),
        Repassword = document.getElementById("rePassword");

    function validatePassword() {
        if (password.value != Repassword.value) {
            Repassword.setCustomValidity("Passwords Don't Match");
        } else {
            Repassword.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    Repassword.onkeyup = validatePassword;


    // Form
    var contactForm = function() {
        if ($('#contactForm').length > 0) {
            $("#contactForm").validate({
                rules: {
                    name: "required",
                    phone: "required",
                    phone: "min:11",
                    open_at: "required",
                    closed_at: "required",
                    logo: "required",
                    address: "required",
                    username: "required",
                    password: "required",
                },
                messages: {
                    name: "من فضلك قم بكتابه اسم المحل",
                    phone: "من فضلك فم بكتابة رقم هاتف صحيح",
                    username: "من فضللك قم بكتابة اسم المستخدم هنا",
                    password: "من فضلك قم بكتابة كلمة سر صحيحة",
                    open_at: "من فضلك قم بكتابة معاد فتح المتجر ",
                    closed_at: "من فضلك قم بكتابه معاد اغلاق المتجر",
                    logo: "من فضلك قم بتحميل شعار المتجر",
                    address: "من فضلك قم بكتابة عنوان المتجر بالتفصيل",
                },

            });
        }
    };

    var submit = function() {
        $("#contactForm").submit(function() {
            var isFormValid = true;

            var lat = document.getElementById('lat').value;
            var long = document.getElementById('long').value;
            var area = document.getElementById('area').value;
            if(lat == '' && long == '' && area == '') {
                isFormValid = false;
            }
            if (!isFormValid) alert("من فضلك حدد موقعك علي الخريطة");

            return isFormValid;
        });
    }
    submit();
    contactForm();

})(jQuery);