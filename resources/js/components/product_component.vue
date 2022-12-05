<template>

    <div class="p-2" style="background-color: rgb(213, 226, 224)">

        <div class=row v-for="i in newProducts" id="products_table">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="projectinput1">المنتج</label>
                    <select :name="'product[]'" class="form-control" id="product" required>
                        <option value="">-- اختار منتج --</option>

                    </select>

                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="projectinput2">الحجم</label>
                    <select :name="'size[]'" class="form-control" id="size" required>
                        <option value="">-- اختار الحجم --</option>
                    </select>
                </div>

            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="projectinput2">الكمية</label>
                    <input type="number" id="product_quantity" min="1" class="form-control amount" placeholder="الكمية"
                        :name="'amount[]'" required>
                </div>

            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="projectinput2">السعر</label>
                    <input type="text" id="product_price" class="form-control price" placeholder="السعر" :name="'price[]'" required>
                </div>

            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="projectinput2">المجموع</label>
                    <input type="number" class="form-control total" readonly />
                </div>

            </div>

            <input style="display: none" type="text" class="form-control " placeholder="الحجم" name="sizesLength"
                :value="newProducts">
        </div>



        <div class="row" style="margin-right: 0.5em;margin-bottom: 2em">
            <a v-on:click="addNewProduct()" type="button" class="btn btn-success mr-1" style="color: white;width: 20%">
                <i class="ft-plus"></i>اضافة منتج
            </a>
            <a v-on:click="removeProduct()" type="button" class="btn btn-danger mr-1" style="color: white;width: 20%;">
                <i class="ft-x"></i>ازالة
            </a>
        </div>

        <div class="row clearfix" style="margin-top:20px">
            <div class="pull-right col-md-6">
                <table class="table table-bordered table-hover" id="tab_logic_total">
                    <tbody>
                        <tr>
                            <th class="text-center">النسبة</th>
                            <td class="text-center">
                                <div class="input-group mb-2 mb-sm-0">
                                    <input type="number" class="form-control" readonly id="tax" placeholder="0">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">المجموع </th>
                            <td class="text-center"><input type="number" name='total' id="total_amount"
                                    placeholder='0.00' class="form-control" readonly /></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</template>

<script>
export default {
    name: "sizes_component",

    data: function () {
        return {
            "newProducts": 1
        };
    },

    methods: {
        addNewProduct: function () {

            this.newProducts++;

        },
        removeProduct: function (value) {

            if (this.newProducts > 1)
                this.newProducts--;

        },
    }
}
</script>

<style scoped>
</style>
