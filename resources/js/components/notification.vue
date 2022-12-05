<template>
    <div>

        <li   id="notification" class="dropdown dropdown-notification nav-item " >
            <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i  class="ficon ft-bell"></i><span v-if="unreadCount>0"  id="unread-notifications" class="badge badge-pill badge-danger badge-up badge-glow">{{unreadCount}}</span></a>
            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right"  >
                <li class="dropdown-menu-header" >
                    <h6 class="dropdown-header m-0"><span class="grey darken-2">الاشعارات</span></h6><span class="notification-tag badge badge-danger float-right m-0"> اشعارات جديدة</span>
                </li>


                <li class="scrollable-container media-list w-100 ps"><a href="javascript:void(0)">
                    <h6 v-if="notifications.length===0" class="media-heading " style="text-align: center; margin-top: 2em">لا توجد اشعارات جديدة</h6>
                </a><a href="javascript:void(0)" >

                        <div v-for="notification in notifications" v-on:click="read($event,notification)" :style="notification.read===0?{'margin-top':'6px', 'background':'#FFD3D9','color':'#ffffff'}:{'background':'#ffffff'}" class="media">

                            <div class="media-body" >

                                <h6 class="media-heading">{{notification.title}}</h6>
                                <h6 style="font-size: 13px;color: red; padding-left: 10px" class="media-heading">
                                    {{notification.content}}</h6>


                                <p class="notification-text font-small-3 text-muted" v-if="notification.customer">{{notification.customer.name}}</p>
                                <p class="notification-text font-small-3 text-muted" v-if="notification.customer">{{notification.customer.phone}}</p>

                                <small>

                                <p class="notification-text font-small-3 text-muted">{{new Date(notification.created_at).toLocaleString()}}</p><small>
                            </small>
                            </small>

                            </div>  

                        </div>
                </a><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; left: -5px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></li>

                <li v-if="notifications.length>0" class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" v-on:click="readAll()">تعيين كل الاشعارات كمقروءه</a></li>
            </ul>
        </li>

</div>






</template>

<script>
   export default {
       mounted(){
           this.getNotifications()
           this.listenForNewNotifications()
       },
       methods:{
         read:function (event,notification) {
             let self=this;
             notification.read=1;

             self.unreadCount--;

             axios.get("/admin/notifications/read/"+notification.id)

         },
           listenForNewNotifications: function () {
               let self=this;
               window.Echo.channel("adminNotification").listen("SendAdminNotificationEvent",function (data) {

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

           readAll:function () {
               this.unreadCount=0;
               this.notifications.forEach((notification)=>notification.read=1);
               axios("/admin/notifications/readAll")
           },


           getNotifications:function () {
           let self=this;
             axios.get("/admin/notifications/index").then((data)=>{
               self.notifications=  data.data.data;
               self.notifications.forEach((notification)=>{
                   if(notification.read===0){
                       self.unreadCount++;
                   }
               });

           })
         }
       },

       data:function () {
         return {
             "notifications":[],
             "unreadCount":null
         };
       }
   }
</script>

