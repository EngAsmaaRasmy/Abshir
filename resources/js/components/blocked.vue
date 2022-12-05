<template>
    <div>
        <div>
            <ul data-v-7962e2ec="" role="group"
                class="nav nav-pills nav-pills-rounded chart-action float-right btn-group" style="margin-bottom: 1em;">
                <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab" href=""
                        v-on:click="getData('/admin/drivers/blocked/' + '7')" class="nav-link active"> حظر نهائي </a></li>
                <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab" href=""
                        v-on:click="getData('/admin/drivers/blocked/' + '6')" class="nav-link"> حظر مؤقت </a></li>
            </ul>
        </div>
        <div class="card" style="width: 100%">

            <div class="card-content collapse show">
                <div class="card-body">
                    <p style="font-weight: bold; font-size: 18px"> سائقين تحت الإنشاء</p>
                    <div class="center-layout">
                        <div class="spinner-border text-primary" role="status"
                            style="position: relative;left: 50%;right: 50%;top: 8em">
                            <span class="sr-only">Loading...</span>
                        </div>

                    </div>
                    <div class="table-responsive-sm" style="overflow: auto">
                        <table id="blocked-table" class="table text-center">
                            <thead class="bg-primary white">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>رقم الهاتف</th>

                                    <!-- <th>العنوان</th> -->
                                    <th>رقم الاوردر الحالى</th>
                                    <th>عدد الاوردرات</th>
                                    <th>اجمالى المبلغ</th>
                                    <th>الحالة</th>
                                    <th>الاجراءات</th>

                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="driver in rows">
                                    <td>{{ driver.id }}</td>
                                    <td>{{ driver.fullname }}</td>
                                    <td>{{ driver.phone }}</td>
                                    <!-- <td>{{driver.address}}</td> -->
                                    <td>{{ driver.active_order }}</td>
                                    <td>{{ driver.order_count }}</td>
                                    <td>{{ driver.total_earnings }}</td>
                                    <td class="text-center"><span class="text-danger" v-if="driver.status == '6'">
                                    حظر مؤقت
                                        </span>
                                        <span class="text-danger" v-else-if="driver.status == '7'">
                                        حظر نهائي
                                        </span>

                                    </td>

                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a :href="'/admin/drivers/toggleActive/' + driver.id"
                                                class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">{{ driver.status
                                                        == "5" ? "الغاء التفعيل" : "تفعيل"
                                                }}</a>
                                            <a :href="'/admin/drivers/show/' + driver.id"
                                                class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">معاينة</a>
                                            <a :href="'/admin/drivers/driver-account/' + driver.id"
                                                class="btn btn-outline-success btn-min-width box-shadow-3 mr-1 mb-1">كشف
                                                الحساب</a>
                                            <a :href="'/admin/drivers/wallet/' + driver.id"
                                                class="btn btn-outline-info btn-min-width box-shadow-3 mr-1 mb-1">المحفظة</a>
                                            <a :href="'/admin/drivers/add-comment/' + driver.id"
                                                    class="btn btn-outline-info btn-min-width box-shadow-3 mr-1 mb-1"> إضافة تعليق</a>
                                        </div>
                                    </td>

                                </tr>
                            </tbody>
                        </table>



                    </div>


                    <ul v-if="pages" class="pager pager-flat">

                        <li :class="pages.current_page == 1 ? 'disabled' : 'enabled'">
                            <a href="#"
                                @click="pages.current_page != 1 ? getData(pages.prev_page_url) : () => { return false; }"><i
                                    class="ft-arrow-left"></i> السابق</a>
                        </li>


                        <li :class="pages.next_page_url != null ? 'enabled' : 'disabled'">
                            <a href="#"
                                @click="pages.next_page_url != null ? getData(pages.next_page_url) : () => { return false; }">التالى
                                <i class="ft-arrow-right"></i></a>
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

    data: function () {
        return {
            "rows": [],
            "loading": true,
            "pages": null
        }

    },


    created() {
        this.getData('/admin/drivers/blocked/' + '7');
    },
    methods: {
        "getData": function (url) {
            let self = this;
            this.loading = true;
            axios.get(url).then((data) => {

                let dataObj = data['data'].data.data;


                console.log(data['data'].data);
                self.pages = data['data'].data;
                self.rows = dataObj;
                let table = $("#blocked-table").dataTable();
                table.fnDestroy();

                setTimeout(function () {

                    table.DataTable({
                        paging: true,
                        info: false,
                        "language": {
                            "zeroRecords": "لم نجد نتيجة مطابقه لبحثك",
                            search: 'بحث'
                        }
                    });




                }, 1000);
                self.loading = false;

            }).catch((e) => {
                console.log(e.message)
            });
        },


    },
    routes: [
        { path: 'admin/drivers/toggleActive/:id', }
    ],

}
</script>

<style scoped>
</style>
