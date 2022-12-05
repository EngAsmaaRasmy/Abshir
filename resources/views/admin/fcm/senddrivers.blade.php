@extends('admin.app')
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
            </div>
            <div class="content-body">

                <div class="card form-card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">ارسال اشعار للسائقين </h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include('alert.success')
                            @include('alert.error')
                            <div class="alert alert-success" role="alert" id="successMsg" style="display: none" >
                                تم    ارسال الإشعار الي السائقين بنجاح 
                            </div>
                            <div class="alert alert-danger" role="alert" id="errorMsg" style="display: none" >
                            </div>
                            <form class="form" method="post" >
                                @csrf
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <div class="form-body">
                                    <h4 class="form-section"><i class="fa fa-bell-o"></i> تفاصيل الاشعار</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="title">العنوان</label>
                                                <input type="text" id="title"
                                                    class="form-control @error('title') is-invalid @enderror"
                                                    placeholder="عنوان الاشعار" name="title">
                                                @error('title')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="body">التفاصيل</label>
                                                <input type="text" id="body"
                                                    class="form-control @error('body') is-invalid @enderror"
                                                    placeholder="محتوى الاشعار" name="body">
                                                @error('body')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="hide" value="drivers" id="type" name="topic">
                                    <div class="form-actions">
                                        <a href="{{ route('admin.home') }}" type="button" class="btn btn-warning mr-1"
                                            style="color: white">
                                            <i class="ft-x"></i> الغاء
                                        </a>
                                        <button id="addNotification" type="button" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i>ارسال
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>

    <script type="module">
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.9.2/firebase-app.js";
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries
  
    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
    apiKey: "AIzaSyA_DCkuIWrydDmrVlt_hmqgIp9zndSvVN4",
    authDomain: "hmf-project-9049a.firebaseapp.com",
    projectId: "hmf-project-9049a",
    storageBucket: "hmf-project-9049a.appspot.com",
    messagingSenderId: "559175099856",
    appId: "1:559175099856:web:cc4b88c17c080ef20045d5",
    };
  
    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    import {
        getFirestore,
        doc,
        getDoc,
        setDoc,
        collection,
        query,
        where,
        addDoc,
        getDocs,
        updateDoc,
        deleteDoc,
        deleteField
    }
    from "https://www.gstatic.com/firebasejs/9.9.2/firebase-firestore.js";
    const db = getFirestore();
    //-------------adding room-------------

    //------------References------------------
    let token = document.getElementById('token')
    let type = document.getElementById('type')
    let title = document.getElementById('title');
    let body = document.getElementById('body');
    var timestamp = Date.now();


    $('#addNotification').on('click', function() {
        addNewNotification();
    });
    //------------Adding Documents------------------
    async function addNewNotification() {
        var ref = doc(db, "generalNotifications", timestamp.toString());

        const docRef = await setDoc(
                ref, {
                    type: type.value,
                    title: title.value,
                    body: body.value,
                    created_at: '{{ now() }}'
                }
            )
            .then(() => {
                console.log("data added Successfully");
                addNotification();
            })
            .catch((error) => {
                alert("Unsccessful, error:" + error);
            })
    }

    function addNotification() {
        $.ajax({
            url: "/admin/notifications/send",
            type: "POST",
            data: function() {
                var data = new FormData();
                data.append("_token", token.value);
                data.append("topic", type.value);
                data.append("title", title.value);
                data.append("body", body.value);
                return data;
            }(),
            contentType: false,
            processData: false,
            success: function(response) {
                // window.location.href = "/admin/notifications/users";
                $('#successMsg').show();
                title.value = '';
                body.value = '';
            },
            error: function(jqXHR, textStatus, errorMessage) {
                console.log(errorMessage);
                $('#errorMsg').show();
                $('#errorMsg').val(errorMessage);
            }
        });

    };
  </script>
@endsection
