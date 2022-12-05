<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl" style="font-family:'Almarai', sans-serif; ">
@include("admin.login-layout.head")

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu 1-column   blank-page" data-open="click" data-menu="vertical-menu" data-col="1-column">
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="row flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
                        <div class="card border-grey border-lighten-3 m-0">
                            <div class="card-header border-0">
                                <div class="card-title text-center">
                                    <div class="p-1"><img src="{{asset("app-assets/images/logo.png")}}" alt="branding logo" style="width:5em ;" ></div>
                                </div>
                                <h6 style="font-family: 'Almarai', sans-serif;" class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>مرحبا بك مجددا فى HMF</span>
                                </h6>
                            </div>
                            <div class="card-content">
                                <div class="card-body">

                                    @error("not-found")
                                    <div class="alert bg-danger alert-dismissible mb-2" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <strong>{{$message}}
                                    </div>
                                    @enderror
                                    <form class="form-horizontal form-simple" method="post" action="{{route("admin.login")}}" novalidate>
                                        @csrf
                                        <fieldset class="form-group position-relative has-icon-left mb-0">
                                            <input type="text" class="form-control" id="email" placeholder="البريد الاليكترونى" name="email" value="{{old("email")}}" required>
                                            <div class="form-control-position">
                                                <i class="la la-user"></i>
                                            </div>
                                        </fieldset>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="كلمة السر" required>
                                            <div class="form-control-position">
                                                <i class="la la-key"></i>
                                            </div>
                                        </fieldset>
                                        <div class="form-group row">
                                            <div class="col-sm-6 col-12 text-center text-sm-left">
                                                <fieldset>
                                                    <input type="checkbox" id="remember" name="remember" class="chk-remember">
                                                    <label for="remember-me"> تذكرنى</label>
                                                </fieldset>
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-info btn-block"><i class="ft-unlock"></i> تسجيل دخول</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
<script src="{{asset("app-assets/vendors/js/vendors.min.js")}}"></script>


<script src="{{asset("app-assets/vendors/js/forms/icheck/icheck.min.js")}}"></script>
<script src="{{asset("app-assets/vendors/js/forms/validation/jqBootstrapValidation.js")}}"></script>

<script src="{{asset("app-assets/js/core/app-menu.js")}}"></script>
<script src="{{asset("app-assets/js/core/app.js")}}"></script>

<script src="{{asset("app-assets/js/form-login-register.js")}}"></script>
</body>
<!-- END: Body-->

</html>
