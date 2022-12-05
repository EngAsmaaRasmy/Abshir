//map 
// Initialize and add the map

var marker;


function initMap() {
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;
    // The location of 30.013056, 31.208853
    const myLatLng = { lat: 30.013056, lng: 31.208853 };
    // The map, centered at Uluru
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 13,
        center: myLatLng,
        mapTypeId: google.maps.MapTypeId.roadMap
    });


    // Create the search box for start point and link it to the UI element.
    const startInput = document.getElementById("start-input")
    const startSearchBox = new google.maps.places.SearchBox(startInput);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(startInput);

    // Create the search box for end point and link it to the UI element.
    const endInput = document.getElementById("end-input")
    const endSearchBox = new google.maps.places.SearchBox(endInput);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(endInput);

    // Bias the start point SearchBox results towards current map's viewport.
    map.addListener("bounds_changed", function() {
        startSearchBox.setBounds(map.getBounds());
    });

    // Bias the end point SearchBox results towards current map's viewport.
    map.addListener("bounds_changed", function() {
        endSearchBox.setBounds(map.getBounds());
    });

    var markers = [];
    startSearchBox.addListener("places_changed", function() {
        var places = startSearchBox.getPlaces();
        if (places.length == 0) {
            return;
        }

        // Clear out the old markers.
        markers.forEach(function(marker) {
            marker.setMap(null);
        });

        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry || !place.geometry.location) {
                console.log("Returned place contains no geometry");
                return;
            }
            startLat = place.geometry.location.lat()
            startLong = place.geometry.location.lng()
            markerStart(map, new google.maps.LatLng(startLat, startLong), );
            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
                console.log(place.geometry.location.lat(), place.geometry.location.lng());
            } else {
                bounds.extend(place.geometry.location);
                startLat = place.geometry.location.lat()
                startLong = place.geometry.location.lng()
            }
        });
        map.fitBounds(bounds);
    });

    endSearchBox.addListener("places_changed", function() {
        var places = endSearchBox.getPlaces();
        if (places.length == 0) {
            return;
        }

        // Clear out the old markers.
        markers.forEach(function(marker) {
            marker.setMap(null);
        });

        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry || !place.geometry.location) {
                console.log("Returned place contains no geometry");
                return;
            }
            endLat = place.geometry.location.lat()
            endLong = place.geometry.location.lng()
            markerEnd(map, new google.maps.LatLng(endLat, endLong), );
            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
                console.log(place.geometry.location.lat(), place.geometry.location.lng());
            } else {
                bounds.extend(place.geometry.location);
                startLat = place.geometry.location.lat()
                startLong = place.geometry.location.lng()
            }
        });
        map.fitBounds(bounds);
    });

}

function markerStart(map, startPoint) {
    var anchor = new google.maps.Point(20, 41),
        size = new google.maps.Size(41, 41),
        origin = new google.maps.Point(0, 0),
        icon = new google.maps.MarkerImage('http://maps.google.com/mapfiles/ms/micons/blue.png', size, origin, anchor);
    marker = new google.maps.Marker({
        icon: icon,
        draggable: true,
        animation: google.maps.Animation.DROP,
        map: map,
        position: startPoint
    });
    marker.addListener("click", toggleBounce);
}

function toggleBounce() {
    if (marker.getAnimation() !== null) {
        marker.setAnimation(null);
    } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}

function markerEnd(map, endPoint) {
    var anchor = new google.maps.Point(20, 41),
        size = new google.maps.Size(41, 41),
        origin = new google.maps.Point(0, 0),
        icon = new google.maps.MarkerImage('http://maps.google.com/mapfiles/ms/micons/green.png', size, origin, anchor);
    marker = new google.maps.Marker({
        icon: icon,
        draggable: true,
        animation: google.maps.Animation.DROP,
        map: map,
        position: endPoint
    });
    marker.addListener("click", toggleBounce);

}


// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.8.1/firebase-app.js";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// const firebaseConfig = {
//     apiKey: "AIzaSyBKpKadD7o7TOqyFsrg2dTRfdhwfDbjodo",
//     authDomain: "test-project-519d6.firebaseapp.com",
//     projectId: "test-project-519d6",
//     storageBucket: "test-project-519d6.appspot.com",
//     messagingSenderId: "476520377091",
//     appId: "1:476520377091:web:84b8879c77c070bbe01736"
// };

// Your web app 's Firebase configuration
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
from "https://www.gstatic.com/firebasejs/9.8.1/firebase-firestore.js";

const db = getFirestore();

//------------References------------------
let token = document.getElementById('token')
let id = document.getElementById('vehicleId')
let name = document.getElementById('vehicleName');
let kiloPrice = document.getElementById('kiloPrice');
let minutePrice = document.getElementById('minutePrice');
let startPrice = document.getElementById('startPrice');


//--------------trips attributes-------------------
let priceListId = document.getElementById('price_list_id');
let startLat = document.getElementById('start_lat');
let startLong = document.getElementById('start_long');
let endLat = document.getElementById('end_lat');
let endLong = document.getElementById('end_long');
let clint;
let tripId;

//-------------- customer attributes ----------------
let clientId = document.getElementById('clientId');
let clientName = document.getElementById('clientName');
let clientPhone = document.getElementById('clientPhone');


$("#clint").change(function() {
    clint = $("#clint").val();
});

let drivers;

$('#insertBtn').on('click', function() {
    addColumn();
});

$('#updateBtn').on('click', function() {
    updateColumn();

});

//-------------adding Client-------------
$('#addClint').on('click', function() {
    addClintDoc();

});

//-------------adding trip-------------
$('#addTrip').on('click', function() {
    addTrip();
});




//------------Adding Documents------------------
async function addColumn() {
    var ref = doc(db, "price_lists", id.value);

    const docRef = await setDoc(
            ref, {
                id: id.value,
                name: name.value,
                kilo_price: kiloPrice.value,
                minute_price: minutePrice.value,
                start_price: startPrice.value
            }
        )
        .then(() => {
            console.log("data added Successfully");
            addPriceList();
        })
        .catch((error) => {
            alert("Unsccessful, error:" + error);
        })
}

function addPriceList() {
    $.ajax({
        url: "/admin/settings/priceLists-save",
        type: "POST",
        data: function() {
            var data = new FormData();
            data.append("_token", token.value);
            data.append("name", name.value);
            data.append("kilo_price", kiloPrice.value);
            data.append("minute_price", minutePrice.value);
            data.append("start_price", startPrice.value);
            return data;
        }(),
        contentType: false,
        processData: false,
        success: function(response) {
            $('#successMsg').show();
            window.location.href = "/admin/settings/price-lists-index";
        },
        error: function(jqXHR, textStatus, errorMessage) {
            console.log(errorMessage);
            $('#errorMsg').show();
            $('#errorMsg').val(errorMessage);
        }
    });

};



//------------Updating Documents------------------
async function updateColumn() {
    var ref = doc(db, "price_lists", id.value);

    await updateDoc(
            ref, {
                name: name.value,
                kilo_price: kiloPrice.value,
                minute_price: minutePrice.value,
                start_price: startPrice.value
            }
        )
        .then(() => {
            console.log("data updated Successfully");
            updatePriceList();
        })
        .catch((error) => {
            alert("Unsccessful, error:" + error);
        })
}

function updatePriceList() {
    $.ajax({
        url: "/admin/settings/priceLists-update",
        type: "POST",
        data: function() {
            var data = new FormData();
            data.append("_token", token.value);
            data.append("id", id.value);
            data.append("name", name.value);
            data.append("kilo_price", kiloPrice.value);
            data.append("minute_price", minutePrice.value);
            data.append("start_price", startPrice.value);
            return data;
        }(),
        contentType: false,
        processData: false,
        success: function(response) {
            $('#successMsg').show();
            window.location.href = "/admin/settings/price-lists-index";
        },
        error: function(jqXHR, textStatus, errorMessage) {
            console.log(errorMessage);
            $('#errorMsg').show();
            $('#errorMsg').val(errorMessage);
        }
    });

};




//------------Adding clients Documents------------------
async function addClintDoc() {
    var ref = doc(db, "lemozen_clients", clientId.value);
    const docRef = await setDoc(
            ref, {
                client_id: clientId.value,
                captain_id: null,
                trip_status: 0,
                fcm_token: " ",
            }
        )
        .then(() => {
            console.log("clint added Successfully");
            addClint();
        })
        .catch((error) => {
            alert("Unsccessful, error:" + error);
        })
}


function addClint() {
    $.ajax({
        url: "/admin/trips/customer-add",
        type: "POST",
        data: function() {
            var data = new FormData();
            data.append("_token", token.value);
            data.append("name", clientName.value);
            data.append("phone", clientPhone.value);
            data.append("active", 1);
            return data;
        }(),
        contentType: false,
        processData: false,
        success: function(response) {
            console.log("customer added")
            $('#customer').modal('hide');
        },
        error: function(jqXHR, textStatus, errorMessage) {
            console.log(errorMessage);
            $('#errorMsg').show();
            $('#errorMsg').val(errorMessage);
        }
    });

};


//-----------------------add trip------------
function addTrip() {
    $.ajax({
        url: "/admin/trips/trip-add",
        type: "POST",
        data: function() {
            var data = new FormData();
            data.append("_token", token.value);
            data.append("price_list_id", priceListId.value);
            data.append("start_lat", startLat);
            data.append("start_long", startLong);
            data.append("end_lat", endLat);
            data.append("end_long", endLong);
            data.append("clint_id", clint);
            return data;
        }(),
        contentType: false,
        processData: false,
        success: function(response) {
            selectDrivers();
            tripId = response.data.id
            window.location.href = "/admin/trips/index";
        },
        error: function(jqXHR, textStatus, errorMessage) {
            console.log(errorMessage);
            $('#errorMsg').show();
            $('#errorMsg').val(errorMessage);
        }
    });

};



//--------update driver data-----------------------
async function updateDriver(id, tripId) {
    var ref = doc(db, "lemozen_drivers", id.toString());
    console.log('ref', ref)

    await updateDoc(
            ref, {
                notified: tripId,
                trip_id: tripId,
            }
        )
        .then(() => {
            console.log("driver updated Successfully");
        })
        .catch((error) => {
            alert("Unsccessful, error:" + error);
        })
}


//------------------------send notification to driver------------
function sendNotification(id, tripId) {
    $.ajax({
        url: "/admin/trips/send-notification/" + id + "/" + tripId,
        type: "get",
        contentType: false,
        processData: false,
        success: function(response) {
            console.log('success');
            console.log('id', id, 'trip', tripId);
            updateDriver(id, tripId);
        },
        error: function(jqXHR, textStatus, errorMessage) {
            console.log(errorMessage);
        }
    });

};

//--------------------------compare date------------------------
function dateCompare(d2) {
    var today = new Date(); //2022/05/30
    const date2 = new Date(d2);
    console.log(date2, today)
    if (today > date2) {
        return false
    } else if (today <= date2) {
        return true
    } else {
        return false
    }
}

//-----------------------connect to firebase and select nearest 5 drivers------------
async function selectDrivers() {
    const driversRef = query(collection(db, "lemozen_drivers"), where("status", "==", true, ),
        where("verified", "==", true), where("notified", "==", 0), where("trip_status", "==", 0));
    const querySnapshot = await getDocs(driversRef);
    console.log(querySnapshot)
    var distance;
    const ids = [];
    querySnapshot.forEach((doc) => {
        // doc.data() is never undefined for query doc snapshots
        drivers = doc.data();
        var driverLicense = dateCompare(drivers.driver_license_expiry_date);
        var vehicleLicense = dateCompare(drivers.vehicle_license_expiry_date)
        distance = calcCrow(drivers.lat, drivers.lng, startLat.value, startLong.value);
        if (distance <= 5 && driverLicense == true && vehicleLicense == true) {
            console.log(drivers.id);
            ids.push(drivers.id);
        }
    })
    for (let i = 0; i <= ids.length - 1; i++) {
        sendNotification(ids[i], tripId);
    }

}


//This function takes in latitude and longitude of two location and returns the distance between them as the crow flies (in km)
function calcCrow(lat1, lon1, lat2, lon2) {
    var R = 6371; // km
    var dLat = toRad(lat2 - lat1);
    var dLon = toRad(lon2 - lon1);
    var lat1 = toRad(lat1);
    var lat2 = toRad(lat2);

    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.sin(dLon / 2) * Math.sin(dLon / 2) * Math.cos(lat1) * Math.cos(lat2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c;
    return d;
}

// Converts numeric degrees to radians
function toRad(Value) {
    return Value * Math.PI / 180;
}


//---------------select all drivers (lat -long)---------




$('#select-all').click(function(event) {
    if (this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;
        });
    } else {
        $(':checkbox').each(function() {
            this.checked = false;
        });
    }
});


$(document).ready(function(event) {
    $(".table:not(#prod-tb)").DataTable({
        paging: false,
        info: false,
        "language": {
            "zeroRecords": "لم نجد نتيجة مطابقه لبحثك",
            search: 'بحث'
        }
    });


    $("#prod-tb").on("draw.dt", function() {
        $(this).find(".dataTables_empty").parents('tbody').empty();
    }).DataTable({
        "paging": true,
        "ordering": false,
        "info": false,
        searching: false,

    });

    initMap();

    $('select').selectpicker({
        liveSearch: true,
    });


});