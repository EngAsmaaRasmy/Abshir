

    <nav  class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
        <div  class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <audio id="xyz" src="{{asset("app-assets/sounds/swiftly.mp3")}}"  preload="none" ></audio>

                    <li class="nav-item mobile-menu d-lg-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs is-active" href="#"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item mr-auto"><a class="navbar-brand" href="index.html"><img class="brand-logo" alt="modern admin logo" src="{{asset("app-assets/images/logo.png")}}">
                            <h3 class="brand-text">HMF</h3>
                        </a></li>
                    <li class="nav-item d-lg-none"><a class="nav-link open-navbar-container collapsed" data-toggle="collapse" data-target="#navbar-mobile" aria-expanded="false"><i class="la la-ellipsis-v"></i></a></li>

                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">


                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <order-admin-notification></order-admin-notification>
                        <admin-order-notification></admin-order-notification>
                        <notification-component></notification-component>
                        <emergency-component></emergency-component>
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="mr-1 user-name text-bold-700">{{\Illuminate\Support\Facades\Auth::user()->name}}</span><span class="avatar avatar-online"><img src="../../../app-assets/images/default_user.jpg" alt="avatar"><i></i></span></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{route("get.admin.edit.profile")}}"><i class="ft-user"></i> تعديل الملف الشخصى</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="ft-power"></i> تسجيل خروج</a>

                                <form id="logout-form" action="{{route('admin.logout')}}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>

                            </div>
                        </li>

                    </ul>
                </div>

            </div>
        </div>
    </nav>


