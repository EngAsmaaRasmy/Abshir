@if(Session::has('error')||(isset($errors)&&count($errors)))
<div class="row mr-2 ml-2">
    <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2" id="type-error">{{Session::get('error') ??
        $errors->first()}}
        @if($errors->first() == 'اسم المستخدم موجود بالفعل')
        <P class="m-2">
            <a href="{{ route('get.shop.login') }}"
                style="color: #020201 !important; text-decoration: underline;"> يمكنك تسجيل الدخول من هنا!
                  </a>
        </P>
        @endif
    </button>
</div>
@endif