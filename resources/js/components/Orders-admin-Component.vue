<template>
    <div>

        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown" aria-expanded="false"><i class="ficon ft-shopping-bag"></i><span v-if="orders.length>0" class="badge badge-pill badge-danger badge-up badge-glow">{{orders.length}}</span></a>
            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                <li class="dropdown-menu-header">
                    <h6 class="dropdown-header m-0"><span class="grey darken-2">طلبات جديده</span></h6><span class="notification-tag badge badge-danger float-right m-0">{{orders.length}} طلب</span>
                </li>
                <li class="scrollable-container media-list w-100 ps ps--active-y ps--active-x">

                    <h6 v-if="orders.length===0" class="media-heading " style="text-align: center; margin-top: 2em">لا توجد طلبات جديدة</h6>

                    <a v-for="order in orders" :href="'/admin/orders/shop/details/'+order.id+'/'+order.type" >
                        <div class="media">
                            <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan mr-0"></i></div>
                            <div class="media-body">
                                <h6 class="media-heading">طلب جديد</h6>
                                <p class="notification-text font-small-3 text-muted" v-if="order.customer_rel">{{order.customer_rel.name}}</p>
                                <p class="notification-text font-small-3 text-muted" v-else>{{order.customer_name}}</p><small>
                                <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">{{new Date(order.created_at).toLocaleString()}}</time></small>
                            </div>
                        </div>
                    </a>
                </li>

            </ul>
        </li>

    </div>
</template>

<script>
    export default {
        name: "OrdersComponent",
        mounted() {

          this.getNewOrders();
          this.listenToWebSocket();

        },
        methods:{
            getNewOrders:function () {
                let self=this;
                axios.get("/admin/orders/shop/index").then((response)=>{
                    self.orders=response.data['data'];
                    console.log(self.orders);
                    console.log(self.orders.length);
                });
            },

            listenToWebSocket:function () {
                let self=this;
                window.Echo.channel("ordersChannel").listen("ReceiveOrderEvent",function (data) {
                   console.log('new data')
                   console.log(data)
                       self.orders.unshift(data.order)
                       console.log("new data ####################");
                       console.log(self.orders);
                       let sound = document.getElementById('xyz')

                       sound.play();
                       if (window.navigator && window.navigator.vibrate) {
                           navigator.vibrate(1000);
                       }

                })
            },

        },
        data:function () {
           return {
               "orders":[]
           };
        },


    }
</script>


