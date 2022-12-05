<template>
    <div id="ecommerceChartView">
        <div class="card card-shadow" style="height: 438px;">
            <div class="card-header card-header-transparent py-20">
                <p style="font-weight: bold; font-size: 18px">المنتجات الموصلة عن طريق المحل</p>
                <ul class="nav nav-pills nav-pills-rounded chart-action float-right btn-group" role="group">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" v-on:click="getOrders(1)" href="">اليوم</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" v-on:click="getOrders(2)" href="">هذا الاسبوع</a></li>
                    <li class="nav-item"><a class="nav-link " data-toggle="tab" v-on:click="getOrders(3)" href="">هذا الشهر</a></li>
                </ul>


            </div>
            <div class="center-layout" v-if="loading">
                <div class="spinner-border text-primary" role="status" style="position: relative;left: 50%;right: 50%;top: 8em">
                    <span class="sr-only">Loading...</span>
            </div>

            </div>
            <div v-else class="table-responsive-sm" >
                <table id="prod-tb"  class="table">
                    <thead class="bg-primary white">
                    <tr>
                        <th>رقم الطلب</th>
                        <th>العميل</th>

                        <th>رقم الهاتف</th>
                        <th>التاريخ</th>

                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="order in table_data">
                        <td>{{order.id}}</td>
                        <td>{{order.customer_rel.name}}</td>
                        <td>{{order.customer_rel.phone}}</td>
                        <td>{{new Date(order.created_at).toLocaleString()}}</td>

                    </tr>
                    </tbody>
                </table>



            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "Shop-Delivered-orders",

        data: function () {
            return {
                "table_data": [],
                "todayOrders":[],
                "weekOrders":[],
                "monthOrders":[],
                "loading":true

            };
        },
        mounted() {


            },
        created() {

            this.getOrders(1);

            },
        methods: {
            "getOrders": function (durationIndex) {
                this.loading=true;
                let self = this;
                axios.get("/shop/orders/selfDelivered/" + durationIndex).then((data) => {

                        let dataObj=data['data'].data;
                        if(durationIndex==1) {
                            self.table_data = dataObj.todayOrders;
                        }
                        else if(durationIndex==2){
                            self.table_data = dataObj.weekOrders;
                        }
                        else{
                            self.table_data = dataObj.monthOrders;
                        }
                        self.loading=false;

                    }
                );

            },


        }

    }

</script>

<style scoped>

</style>
