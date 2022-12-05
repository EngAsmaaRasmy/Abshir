<template>
<div>
    <div>
        <ul data-v-7962e2ec="" role="group"
            class="nav nav-pills nav-pills-rounded chart-action float-right btn-group"
            style="margin-bottom: 1em;">
            <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab"  href="" v-on:click="getData('/admin/getOrders/'+1)"
                                                       class="nav-link active"> اليوم</a></li>
            <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab" href="" v-on:click="getData('/admin/getOrders/'+2)"
                                                       class="nav-link">هذا الاسبوع</a></li>
            <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab" href="" v-on:click="getData('/admin/getOrders/'+3)"
                                                       class="nav-link">هذا الشهر</a></li>
        </ul>
    </div>
    <div class="card" style="width: 100%">

        <div class="card-content collapse show">
            <div class="card-body">
                <p style="font-weight: bold; font-size: 18px">الطلبات </p>
                <div class="center-layout" >
                    <div class="spinner-border text-primary" role="status" style="position: relative;left: 50%;right: 50%;top: 8em">
                        <span class="sr-only">Loading...</span>
                    </div>

                </div>
                    <div   class="table-responsive-sm"  style="overflow: auto">
                        <table id="static-table"  class="table">
                            <thead class="bg-primary white">
                            <tr>
                                <th>رقم الطلب</th>
                                <th>العميل</th>

                                <th>رقم الهاتف</th>
                                <th>المنتجات</th>
                                <th>المحل</th>
                                <th>السائق</th>

                                <th>التاريخ</th>
                                <th>الحالة</th>

                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="order in rows">
                                <td>{{order.id}}</td>
                                <td>{{order.customer_rel.name}}</td>
                                <td>{{order.customer_rel.phone}}</td>
                                <td>
                                    <table id="prod-tb" class="table table-borderless">
                                        <thead >
                                        <th> اسم المنتج</th>
                                        <th>الكميه</th>
                                        <th>السعر</th>
                                        <th>الحجم</th>
                                        </thead>
                                        <tbody>

                                        <tr v-for="product in order.products">
                                            <td>{{product.product.name_ar}}</td>
                                            <td>{{product.amount}}</td>
                                            <td>{{product.size.price }}  جنيه </td>
                                            <td>{{product.size.name }}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </td>
                                <td>{{order.shop.name}}</td>
                                <td>{{order.driver_rel? order.driver_rel.fullname:""}}</td>
                                <td>{{new Date(order.updated_at).toLocaleString()}}</td>
                                <td>{{order.status_rel.name_ar}}</td>

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
        name: "AdminStatistics",

        data:function () {
         return {
             "rows":[],
             "loading":true,
             "pages":null
         }

         },


        created() {
             this.getData('/admin/getOrders/'+1);
            },
        methods:{
            "getData":function (url) {
                let self=this;
                this.loading=true;
                axios.get(url).then((data)=>{

                    let dataObj=data['data'].data.data;
                    self.pages=data['data'].data;
                    self.rows=dataObj;
                    let table=$("#static-table").dataTable();
                    table.fnDestroy();

                    setTimeout(function(){

                        table.DataTable({ paging:true,
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
