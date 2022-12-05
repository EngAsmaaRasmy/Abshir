<template>

    <div>

        <div>
            <ul data-v-7962e2ec="" role="group"
                class="nav nav-pills nav-pills-rounded chart-action float-right btn-group"
                style="margin-bottom: 1em;">
                <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab"  href="" v-on:click="getData('/admin/getAdminOrders/'+1)"
                                                           class="nav-link active"> اليوم</a></li>
                <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab" href="" v-on:click="getData('/admin/getAdminOrders/'+2)"
                                                           class="nav-link">هذا الاسبوع</a></li>
                <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab" href="" v-on:click="getData('/admin/getAdminOrders/'+3)"
                                                           class="nav-link">هذا الشهر</a></li>
            </ul>
        </div>
    <div class="card" style="width: 100%">

        <div class="card-content collapse show">
            <div class="card-body">
                <p style="font-weight: bold; font-size: 18px">الطلبات الخاصة </p>

                <div   class="table-responsive-sm"  style="overflow: auto">
                    <table id="admin-order-table"  class="table">
                        <thead class="bg-primary white">
                        <tr>
                            <th>رقم الطلب</th>
                            <th>العميل</th>
                            <th>رقم الهاتف</th>
                            <th>العنوان</th>
                            <th>التفاصيل</th>
                            <th>التاريخ</th>

                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="order in rows">
                            <td>{{order.id}}</td>
                            <td>{{order.customer_name }}</td>
                            <td>{{order.customer_phone}}</td>
                            <td>{{order.customer_address}}</td>

                            <td>
                                <div style="width:20em;">
                                    {{order.details}}
                            </div>
                            </td>
                            <td>{{new Date(order.updated_at).toLocaleString()}}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>


                <ul v-if="pages  " class="pager pager-flat">

                    <li :class="pages.current_page==1?'disabled':'enabled'">
                        <a href="#"
                           @click="pages.current_page!=1?getData(pages.prev_page_url):()=>{return false;}"><i
                            class="ft-arrow-left"></i> السابق</a>
                    </li>


                    <li :class="pages.next_page_url!=null?'enabled':'disabled' ">
                        <a href="#"
                           @click="pages.next_page_url!=null?getData(pages.next_page_url):()=>{return false;}">التالى <i
                            class="ft-arrow-right"></i></a>
                    </li>


                </ul>


            </div>
        </div>
    </div>

    </div>
</template>

<script>
    export default {
        name: "Admin_orders_table",
        data:function () {
            return {
                "rows":[],
                "loading":true,
                "pages":null
            }

        },
        created() {
            this.getData('/admin/getAdminOrders/'+1);
        },
        methods:{
            "getData":function (url) {
                let self=this;
                this.loading=true;
                axios.get(url).then((data)=>{

                    let dataObj=data['data'].data.data;
                    self.pages=data['data'].data;
                    self.rows=dataObj;
                    let table=$("#admin-order-table").dataTable();
                    table.fnDestroy();

                    setTimeout(function(){

                        table.DataTable({ 
                            paging:true,
                            info:false,
                            "language": {
                                "zeroRecords": "لم نجد نتيجة مطابقه لبحثك",
                                search: 'بحث'
                            }});


                    }, 1000);
                    self.loading=false;

                }).catch((e)=>{
                    console.log(e.message)
                });
            },


        }

    }
</script>

<style scoped>

</style>
