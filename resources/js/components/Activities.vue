<template>
<div>
    <div>
        <ul data-v-7962e2ec="" role="group"
            class="nav nav-pills nav-pills-rounded chart-action float-right btn-group"
            style="margin-bottom: 1em;">
            <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab"  href="" v-on:click="getData('/admin/getActivity/'+1)"
                                                       class="nav-link active"> اليوم</a></li>
            <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab" href="" v-on:click="getData('/admin/getActivity/'+2)"
                                                       class="nav-link">هذا الاسبوع</a></li>
            <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab" href="" v-on:click="getData('/admin/getActivity/'+3)"
                                                       class="nav-link">هذا الشهر</a></li>
        </ul>
    </div>
    <div class="card" style="width: 100%">

        <div class="card-content collapse show">
            <div class="card-body">
                <p style="font-weight: bold; font-size: 18px">أنشطة المستخدمين</p>
                <div class="center-layout" >
                    <div class="spinner-border text-primary" role="status" style="position: relative;left: 50%;right: 50%;top: 8em">
                        <span class="sr-only">Loading...</span>
                    </div>

                </div>
                    <div   class="table-responsive-sm"  style="overflow: auto">
                        <table id="activity-table"  class="table">
                            <thead class="bg-primary white">
                            <tr>
                                <th>#</th>
                                    <th>الاسم</th>
                                    <th>  نوع التغيير</th>
                                    <th>المكان الذى حدث فيه التغيير</th>
                                    <th>ما حدث تغيير فيه</th>
                                    <th>القيمة القديمة</th>
                                    <th>القيمة الجديدة </th>

                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="activity in rows">
                                <td>{{activity.id}}</td>
                                <td>{{activity.log_name}}</td>
                                <td>{{activity.description}}</td>
                                <td>{{activity.subject_type}}</td>
                                 <td>
                                    <label  class="badge badge-info px-1" style="font-size: 16px;" v-for="(index, diff) in activity.changes">{{index}}</label>
                                </td>
                                <!-- <td>{{order.driver_rel? order.driver_rel.fullname:""}}</td>
                                <td>{{new Date(order.updated_at).toLocaleString()}}</td>
                                <td>{{order.status_rel.name_ar}}</td> -->

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
             "loading":false,
             "pages":null
         }

         },


        created() {
             this.getData('/admin/getActivity/'+1);
            },
        methods:{
            "getData":function (url) {
                let self=this;
                this.loading=true;
                axios.get(url).then((data)=>{

                    let dataObj=data['data'].data.data;


                    console.log(data['data'].data);
                    self.pages=data['data'].data;
                    self.rows=dataObj;
                    let table=$("#activity-table").dataTable();
                    table.fnDestroy();

                    setTimeout(function(){

                        table.DataTable({ 
                            paging:true,
                            search:true,
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
