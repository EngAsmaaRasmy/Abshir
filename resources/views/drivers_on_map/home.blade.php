<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords"
        content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title> عرض الخريطة</title>

    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic&family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors-rtl.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/datatables.min.css') }}">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">


    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/bootstrap-extended.css') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/custom-rtl.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/css-rtl/core/menu/menu-types/vertical-menu-modern.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/pages/single-page.css') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/HomeStyle.css') }}">

</head>

<body>
    <div id="driverMap" style="height: 100%; width:100%;"></div>



    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>


    <script src="{{ asset('app-assets/js/vendors.min.js') }}"></script>

    <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/jquery.repeater.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>


    <script type="module">
        var location;
        let largeMap;
        var features = [];
        var features_length = 0;
        var type;
        var iconBase;
        var icon;

        // Import the functions you need from the SDKs you need
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/9.8.1/firebase-app.js";
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
            onSnapshot,
            updateDoc,
            deleteDoc,
            deleteField
        }
        from "https://www.gstatic.com/firebasejs/9.8.1/firebase-firestore.js";

        const db = getFirestore();
        async function selectAllDrivers() {
            const driversRef = query(collection(db, "lemozen_drivers"));
            // const querySnapshot = await getDocs(driversRef);
            const unsubscribe = onSnapshot(driversRef, (querySnapshot) => {
                querySnapshot.forEach((doc) => {
                    // doc.data() is never undefined for query doc snapshots
                    var drivers = doc.data();
                    location = {
                        lat: drivers.lat,
                        lng: drivers.lng
                    };
                    console.log(location);

                    //-------------icon color -----------
                    var anchor = new google.maps.Point(20, 41),
                        size = new google.maps.Size(41, 41),
                        origin = new google.maps.Point(0, 0),
                        iconUrl = new google.maps.MarkerImage(iconBase, size, origin, anchor);
                    //----------------check driver status----------------------
                    if (drivers.trip_id != -1) {
                        iconBase = 'http://maps.google.com/mapfiles/ms/micons/green.png'
                    } else if (drivers.status == false) {
                        iconBase = 'http://maps.google.com/mapfiles/ms/micons/yellow.png'
                    } else {
                        iconBase = 'http://maps.google.com/mapfiles/ms/micons/red.png'
                    }
                    // ------------------push location and icon in features array ----------
                    features.push({
                        location: location,
                        type: iconUrl
                    });
                })
                features_length = features.length;
                showMap();
            });
            unsubscribe();
        }

        function showMap() {
            largeMap = new google.maps.Map(document.getElementById("driverMap"), {
                center: new google.maps.LatLng(30.033333, 31.233334),
                zoom: 11,
            });
            // Create markers.
            for (let i = 0; i < features_length; i++) {

                const marker = new google.maps.Marker({
                    icon: features[i].type,
                    position: features[i].location,
                    animation: google.maps.Animation.DROP,
                    map: largeMap,

                });
            }

        }
        $(document).ready(function(event) {
            selectAllDrivers();
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYWRfCUWOYMBlEDyM6dlXft2Fl4KIeWNk&language=ar">
    </script>

</body>

</html>