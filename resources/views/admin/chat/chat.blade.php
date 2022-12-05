@extends('admin.app')
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper ">
          
            <div class="content-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="card card-row card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    غرف الدردشة
                                </h3>
                            </div>
                            <div id="rooms" style="height: 80vh ;overflow-y: scroll;">

                            </div>

                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="card direct-chat direct-chat-primary">
                            <div class="card-header ui-sortable-handle" style="cursor: move;">
                                <div class="card-tools">

                                </div>
                            </div>
                            @if ($id == NUll)
                            <div class="card-body">
                                <div class="direct-chat-messages"  style="height: 500px;">
                                    <img src="{{ asset('app-assets/images/Group 75156.png') }}" alt="login form" class="img-fluid" />
                                </div>

                            </div>
                            @else

                            <div class="card-body">
                                <div class="direct-chat-messages" id="chat_board" style="height: 700px; overflow-x: scroll ">
                                </div>

                            </div>
                            <div class="card-footer">
                                <form action="#" method="post">
                                    <div class="input-group">
                                        <input type="text" name="message" id="data_message"
                                            placeholder="اكتب رسالتك هنا  ..." class="form-control" />
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="send">إرسال</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            @endif
                           
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="module">
    import { initializeApp } from 'https://www.gstatic.com/firebasejs/9.1.0/firebase-app.js'
    import { getFirestore, collection, getDocs ,addDoc ,getDoc , doc,setDoc,updateDoc ,query, orderBy ,where , onSnapshot } from 'https://www.gstatic.com/firebasejs/9.1.0/firebase-firestore.js'
    const firebaseConfig = {
        apiKey: "AIzaSyA_DCkuIWrydDmrVlt_hmqgIp9zndSvVN4",
        authDomain: "hmf-project-9049a.firebaseapp.com",
        databaseURL: "https://hmf-project-9049a-default-rtdb.firebaseio.com",
        projectId: "hmf-project-9049a",
        storageBucket: "hmf-project-9049a.appspot.com",
        messagingSenderId: "559175099856",
        appId: "1:559175099856:web:cc4b88c17c080ef20045d5",
        measurementId: "G-EYLQD83G5K"
    };

    // Initialize Firebase
    const firebase = initializeApp(firebaseConfig);
    const db = getFirestore(firebase);
    const Room = await collection(db,'room');
    const OneRoom = await doc(db,'room' , "0YzfoJgUUGQuIMtQNRnA");
    const GetOnRoom = await getDoc(OneRoom);
    const GetAllRoom = await getDocs(Room);
    const GetDocs = await GetAllRoom.docs;
    let app = document.querySelector('#rooms');
    var RoomList = [];

    // message
    const  room_id = '{{ $id }}';
    console.log(room_id);

   

    const messages = await collection(db,'messages');
    const querymessage = await query(messages , where("roomId" , "==" , room_id), orderBy('createdAt'));
    // const querymessage = await query(messages , where("roomId" , "==" , room_id))
    const GetAllMessage = await getDocs(querymessage);
    const GetAllMessageDocs = await GetAllMessage.docs;
    var MessageList = [];
    let chatboard = document.querySelector('#chat_board');
    let btnsend = document.querySelector('#send');
    var inputMessage = document.querySelector('#data_message');

    async  function SendMessage() {
        await addDoc(messages,{
            createdAt: "{{now()}}",
            roomId: room_id.toString(),   
            msg: inputMessage.value,
            senderPhone: "00000000",
            senderId: {{ Auth::user()->id }},
            senderName: "{{ Auth::user()->name }}",
         }).then(()=>{ 
         console.log("done") 
         inputMessage.value = '';
       }) 

    }
    if(btnsend) {
        btnsend.addEventListener('click' , SendMessage);
    }

    onSnapshot(querymessage ,(querySnapshot)=>{
        emptyArray();
        Messages_load(querySnapshot);
        AddMessageHtml();

    });
    // <span class="direct-chat-name float-left">${item.data()['senderName']}</span>
    async function Messages_load(querySnapshot) {

        querySnapshot.forEach(item => {
            var created_at = item.data()['createdAt'];
            created_at = new Date(created_at);
            var date = created_at.getFullYear()+'-'+(created_at.getMonth()+1)+'-'+created_at.getDate();
            var time = created_at.getHours() + ":" + created_at.getMinutes() + ":" + created_at.getSeconds();
            var dateTime = date+' '+time; 
            console.log(item.data()['createdAt'], dateTime);
            if (item.data()['senderPhone'] == "00000000") {
                MessageList.push(`
            <div class="direct-chat-msg right" style="border: 2px solid #dedede;
                    background-color: #666EE8;
                    color:#fff;
                    border-radius: 5px;
                    padding: 10px;
                    margin: 10px 0;">
                                <p>
                                    ${item.data()['msg']}
                                </p> 
                                <span class="direct-chat-timestamp">${dateTime}</span>
                            </div>`)
            }
            else
            {
                MessageList.push(`<div style="border: 2px solid #ccc;
                    background-color: #ddd;
                    border-radius: 5px;
                    padding: 10px;
                    margin: 10px 0;">
                                <p>
                                    ${item.data()['msg']}
                                </p> 
                                <span class="direct-chat-timestamp">${dateTime}</span>
                            </div>`)
            }
        });
    }

    async function AddMessageHtml() {
        MessageList.forEach(item => {
            chatboard.innerHTML += item;

        });
    }

    function emptyArray () {
        MessageList = [];
        MessageList.length = 0;
        MessageList.splice(0,MessageList.length);

        while (MessageList.length > 0) {
            MessageList.pop();
        }
        chatboard.innerHTML = "";

    }





    // console.log(GetAllRoom);
    // console.log(GetDocs);

    if (GetOnRoom.exists()) {
        console.log(GetOnRoom.data());
    }
    // fetch room
    GetDocs.forEach(doc => {

        RoomList.push(`<div class="card-body pr-2 pl-2" style="padding: 0 ">
                            <div class="card card-primary " style=" box-shadow: none !important;">
                                <div class="card-header m-0"><a href='/admin/chats/chat/${doc.id}'>
                                    <h5 class="card-title pt-1">
                                        <span class="badge rounded-pill text-bg-info">
                                            ${doc.data()['isDriver'] == true ? 'سائق': 'مٌستخدم'}
                                        </span>
                                        ${doc.data()['userName']}
                                        <span class="text-light">
                                            ${doc.data()['userPhone']}
                                        </span>
                                      
                                        </h5></a>
                                    <br>
                                </div>
                            </div>
                        </div>`)


        // console.log(doc.id, '=>', doc.data()['name1'] , '--' ,doc.data()['name1']);
    });
    RoomList.forEach(item => {
        app.innerHTML += item;

    });

    GetAllMessage.forEach((doc) => {
        // doc.data() is never undefined for query doc snapshots
        // console.log(doc.id, " => ", doc.data());
    });

    // get message



    // const analytics = getAnalytics(db);
    // const db = firebase.database();

    //
    // const GetAllRoom = collection('rooms');
    // const snapshot = await GetAllRoom.get();
    // if (snapshot.empty) {
    //     console.log('No matching documents.');
    // }
    // snapshot.forEach(doc => {
    //     console.log(doc.id, '=>', doc.data());
    // });

    //
    // console.log(GetAllRoom);
    // const querySnapshot = await getDocs(GetAllRoom);
    // querySnapshot.forEach((doc) => {
    //     // doc.data() is never undefined for query doc snapshots
    //     console.log(doc.id, " => ", doc.data());
    // });
    // const unsubscribe = onSnapshot(GetAllRoom, (snapshot) => {
    //     snapshot.docChanges().forEach((change) => {
    //         console.log(change);
    //     });
    // });

</script>
@endsection
