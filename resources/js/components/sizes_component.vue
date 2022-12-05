<template>

    <div>

        <div class=row v-for="i in newSizes">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="projectinput1">الحجم</label>
                    <input type="text" id="projectinput1" class="form-control " placeholder="الحجم" :name="'size' + i">

                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="projectinput2">السعر</label>
                    <input type="text" id="projectinput2" class="form-control " placeholder="السعر" :name="'price' + i">

                </div>

            </div>



            <input style="display: none" type="text" class="form-control " placeholder="الحجم" name="sizesLength"
                :value="newSizes">


        </div>



        <div class="row" style="margin-right: 0.5em;margin-bottom: 2em">
            <a v-on:click="addNewSize()" type="button" class="btn btn-success mr-1" style="color: white;width: 20%">
                <i class="ft-plus"></i>اضافة حجم
            </a>
            <a v-on:click="removeSize()" type="button" class="btn btn-danger mr-1" style="color: white;width: 20%;">
                <i class="ft-x"></i>ازالة
            </a>
        </div>

    </div>

</template>

<script>
export default {
    name: "sizes_component",

    data: function () {
        return {
            "newSizes": 1
        };
    },

    methods: {
        addNewSize: function () {

            this.newSizes++;

        },
        removeSize: function (value) {

            if (this.newSizes > 1)
                this.newSizes--;

        },
    }
}
</script>

<style scoped>
</style>
