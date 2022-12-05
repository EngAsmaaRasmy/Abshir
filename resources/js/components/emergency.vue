<template>
    <div>
        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
                data-toggle="dropdown" aria-expanded="false"><i class="ficon fa fa-bullhorn"></i>
                <span v-if="emergencies.length > 0"
                    class="badge badge-pill badge-danger badge-up badge-glow">{{ emergencies.length }}</span></a>
            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                <li class="dropdown-menu-header">
                    <h6 class="dropdown-header m-0"><span class="grey darken-2">حالة طارئة جديدة </span></h6><span
                        class="notification-tag badge badge-danger float-right m-0">{{ length }} حالة طوارئ</span>
                </li>
                <li class="scrollable-container media-list w-100 ps ps--active-y ps--active-x">

                    <h6 v-if="emergencies.length == 0" class="media-heading " style="text-align: center; margin-top: 2em">
                        لا توجد حالات طارئة
                        </h6>

                    <a v-for="emergency in emergencies" :href="'/admin/emergency/show/' + emergency.id">
                        <div class="media">
                            <div class="media-left align-self-center"><i
                                    class="ft-plus-square icon-bg-circle bg-cyan mr-0"></i></div>
                            <div class="media-body">
                                <h6 class="media-heading">حالة طارئة جديد</h6>
                                <p class="notification-text font-small-3 text-muted" v-if="emergency.trip">
                                    {{ emergency.trip.customerRel.name }}</p>
                                <small>
                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">
                                        {{ new Date(emergency.created_at).toLocaleString() }}
                                    </time>
                                </small>
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
    name: "Emergencies",
    mounted() {
        this.listenToWebSocket();

    },
    methods: {
        listenToWebSocket: function () {
            let self = this;
            window.Echo.channel("emergencies").listen("NewEmergencyEvent", function (data) {
                console.log('new data')
                console.log(data.emergency)
                self.emergencies.unshift(data.emergency)
                console.log("new data ####################");
                console.log(self.emergencies);
                let sound = document.getElementById('xyz')
                sound.play();
                if (window.navigator && window.navigator.vibrate) {
                    navigator.vibrate(1000);
                }
            })
        },

    },
    created() {
        axios
            .get(
                `/admin/emergency/get-all`
            )
            .then((response) => {
                this.emergencies = response.data.data;
                this.length = this.emergencies.length
            });
    },
    data: function () {
        return {
            "emergencies": [],
            "length": ''
        };
    },
}
</script>

<style scoped>
</style>
