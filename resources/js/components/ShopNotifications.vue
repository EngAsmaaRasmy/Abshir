<template>
    <div>
        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown" aria-expanded="false"><i class="ficon ft-mail"></i><span v-if="unreadCount>0" class="badge badge-pill badge-warning badge-up badge-glow">{{unreadCount}}</span></a>
            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                <li class="dropdown-menu-header">
                    <h6 class="dropdown-header m-0"><span class="grey darken-2">رسائل الادراة</span></h6><span class="notification-tag badge badge-warning float-right m-0">{{unreadCount}} جديدة</span>
                </li>
                <li class="scrollable-container media-list w-100 ps"><a href="javascript:void(0)">
                    <h6 v-if="notifications.length===0" class="media-heading " style="text-align: center; margin-top: 2em">لا توجد رسائل جديدة</h6>
                </a><a  v-on:click="read(notification)" v-for="notification in notifications">
                    <div :style="notification.read===0?{'margin-top':'6px', 'background':'#FFD3D9','color':'#ffffff'}:{'background':'#ffffff'}" class="media">
                        <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="/app-assets/images/default_user.jpg" alt="avatar"><i></i></span></div>
                        <div class="media-body">
                            <h6 class="media-heading">{{notification.title}}</h6>
                            <p class="notification-text font-small-3 text-muted">{{notification.content}}</p><small>
                            <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">{{new Date(notification.created_at).toLocaleString()}}</time></small>
                        </div>
                    </div>

                </a>
                </li>
                <li v-if="notifications.length>0" class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" v-on:click="readAll()">تعيين كل الرسائل كمقروءه</a></li>
            </ul>
        </li>
    </div>
</template>

<script>
    import notification from "./notification";

    export default {
        name: "ShopNotifications",
        data:function () {
         return {
             "notifications":[],
             unreadCount:null,
         };
        },
        methods:{
            getNotifications:function () {
               axios.get("/shop/notifications/index").then((response)=>{
                   let data=response.data;
                   if(data.status){
                       this.notifications=data.data;
                       this.notifications.forEach((notification)=>{
                           if(notification.read===0){
                               this.unreadCount++;
                           }
                       });
                   }

               });
            },
            listenForNewMessages: function () {
            let self=this;
            window.Echo.channel("messagesChannel").listen("ReceiveMessageEvent",function (data) {

                console.log(data);
            self.notifications.unshift(data.notification);
            self.unreadCount++;
            let sound = document.getElementById('xyz');

            sound.play();
            if (window.navigator && window.navigator.vibrate) {
                navigator.vibrate(1000);
            }
        })
    },

            read:function (notification) {
               this.unreadCount--;
               notification.read=1;
               axios.get("/shop/notifications/read/"+notification.id).then((data)=>{
                   console.log("readed")
               });
            },
            readAll:function () {
               this.unreadCount=0;
               this.notifications.forEach((notification)=>notification.read=1);
               axios("/shop/notifications/readAll")
            }

        },
        mounted() {
           this.getNotifications();
           this.listenForNewMessages()
        }
    }
</script>


