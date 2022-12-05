<template>
    <div>
        <div class="modal fade" id="cancel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> إلغاء الرحلة </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body ">
                        <form @submit="cancelTrip" role="form">
                            <div class="">
                                <div class="card">
                                    <div class="card-body">
                                        <input type="hidden" class="form-control" required v-model="tripId">
                                        <div class="form-group">
                                            <label>سبب إنهاء الرحلة</label>
                                            <input type="text" class="form-control" required
                                                v-model="cancellation_reason">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer d-block">
                                    <button class="btn btn-warning float-right">حقظ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="finish" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">إنهاء الرحلة </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body ">
                        <form role="form" @submit="finishTrip">
                            <div class="">
                                <div class="card">
                                    <div class="card-body">
                                        <input type="hidden" class="form-control" required v-model="tripId">
                                        <div class="form-group">
                                            <label>عدد الكيلوهات </label>
                                            <input type="text" class="form-control" required v-model="distance">
                                        </div>
                                        <div class="form-group">
                                            <label> مدة الرحلة</label>
                                            <input type="text" class="form-control" required v-model="trip_time">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer d-block">
                                    <button class="btn btn-warning float-right">حقظ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <ul data-v-7962e2ec="" role="group"
                class="nav nav-pills nav-pills-rounded chart-action float-right btn-group" style="margin-bottom: 1em;">
                <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab" href=""
                        v-on:click="getData('/admin/trips/get-trips/' + 'created')" class="nav-link active"> رحلات تحت
                        الإنشاء </a></li>
                <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab" href=""
                        v-on:click="getData('/admin/trips/get-trips/' + 'approved')" class="nav-link "> رحلات تمت
                        الموافقة
                        عليها من الكابتن </a></li>
                <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab" href=""
                        v-on:click="getData('/admin/trips/get-trips/' + 'arrived')" class="nav-link "> رحلات تم وصول
                        الكابتن إليها </a></li>
                <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab" href=""
                        v-on:click="getData('/admin/trips/get-trips/' + 'started')" class="nav-link "> رحلات تمت بدئها
                    </a></li>
                <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab" href=""
                        v-on:click="getData('/admin/trips/get-trips/' + 'finished')" class="nav-link "> رحلات تمت بنجاح
                    </a></li>
                <li data-v-7962e2ec="" class="nav-item"><a data-v-7962e2ec="" data-toggle="tab" href=""
                        v-on:click="getData('/admin/trips/get-trips/' + 'cancelled')" class="nav-link "> رحلات مٌلغاه
                    </a>
                </li>

            </ul>
        </div>
        <div class="card" style="width: 100%">
            <div class="alert alert-success" role="alert" id="cancelMsg" style="display: none">
                تم إلغاء الرحلة بنجاح
            </div>
            <div class="alert alert-success" role="alert" id="finishMsg" style="display: none">
                تم إنهاء الرحلة بنجاح
            </div>
            <div class="alert alert-danger" role="alert" id="errorMsg" style="display: none">
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="center-layout">
                        <div class="spinner-border text-primary" role="status"
                            style="position: relative;left: 50%;right: 50%;top: 8em">
                            <span class="sr-only">Loading...</span>
                        </div>

                    </div>
                    <div class="table-responsive-sm" style="overflow: auto">
                        <table id="trip-table" class="table text-center">
                            <thead class="bg-primary white">
                                <tr>
                                    <th>#</th>
                                    <th> اسم العميل</th>
                                    <th>اسم السائق</th>
                                    <th> نوع الرحلة</th>
                                    <th>الاجراءات</th>

                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="trip in rows">
                                    <td v-if="trip">{{ trip.id }}</td>
                                    <td v-if="trip.customer_rel">{{ trip.customer_rel.name }}</td>
                                    <td v-else>---------</td>
                                    <td v-if="trip.driver_rel">{{ trip.driver_rel.fullname }}</td>
                                    <td v-else>---------</td>
                                    <td v-if="trip.price_list">{{ trip.price_list.name }}</td>
                                    <td v-else>---------</td> 
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a :href="'/admin/trips/show/' + trip.id"
                                                class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">معاينة</a>
                                            <button type="button"
                                                class="btn btn-outline-success btn-min-width box-shadow-3 mr-1 mb-1"
                                                @click="finish(trip.id)">
                                                إنهاء الرحلة </button>
                                            <button type="button"
                                                class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1"
                                                @click="cancel(trip.id)">
                                                إلغاء الرحلة </button>

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
    name: "Trips",

    data: function () {
        return {
            "rows": [],
            "loading": true,
            "pages": null,
            "tripId": 0,
            "cancellation_reason": "",
            "distance": "",
            "trip_time": ""
        }

    },


    created() {
        this.getData('/admin/trips/get-trips/' + 'created');
    },
    methods: {
        "getData": function (url) {
            let self = this;
            this.loading = true;
            axios.get(url).then((data) => {

                let dataObj = data['data'].data.data;
                self.pages = data['data'].data;
                self.rows = dataObj;
                let table = $("#trip-table").dataTable();
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
        finish(id) {
            this.tripId = id;
            $('#finish').modal('show');
        },
        cancel(id) {
            this.tripId = id;
            $('#cancel').modal('show');
        },
        //-------------------------cancel trip------------------
        cancelTrip(e) {
            e.preventDefault();
            axios.post('/admin/trips/trip-cancel', {
                trip_id: this.tripId,
                cancellation_reason: this.cancellation_reason
            })
                .then(function (response) {
                    console.log(response.data);
                    $('#cancel').modal('hide');
                    $('#cancelMsg').show();
                })

                .catch(function (error) {
                    console.log(error);
                    $('#cancel').modal('hide');
                    $('#errorMsg').show();
                    $('#errorMsg').val(error);
                });

        },

        //------------------------------finish trip ---------------------
        async finishTrip(e) {
            e.preventDefault();
            axios.post('/admin/trips/trip-finish', {
                trip_id: this.tripId,
                distance: this.distance,
                trip_time: this.trip_time
            })
                .then(function (response) {
                    console.log(response.data);
                    $('#finish').modal('hide');
                    $('#finishMsg').show();
                })

                .catch(function (error) {
                    console.log(error);
                    $('#finish').modal('hide');
                    $('#errorMsg').show();
                    $('#errorMsg').val(error);
                });


        },



    },

}
</script>

<style scoped>
</style>
