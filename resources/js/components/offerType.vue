<template>




    <div>
        <div  class="col-md-6">
            <div class="form-group">
                <label for="offer_type"> نوع العرض </label>
                <select  id="offer_type" @change="selected($event)"  name="type" class="select2 form-control">
                    <optgroup label="من فضلك اختر نوع العرض ">

                        <option :selected="selected_type===type.id.toString()" v-for="type in jsonTypes" :value="type.id" >{{type.name}}</option>



                    </optgroup>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="offer_name">اسم العرض</label>
                <input :value="jsonOffer? jsonOffer.name:''" type="text" id="offer_name" class="form-control "
                       placeholder="اسم العرض" name="name">

                <span class="invalid-feedback" role="alert">
                                        <strong>{{  }}</strong>
                                    </span>

            </div>

        </div>
        <div v-if="selected_type==='1' || !selected_type " class="col-md-6">
            <div class="form-group">
                <label for="offer_percentage">نسبه الخصم</label>
                <input :value="jsonOffer? jsonOffer.percentage:''" type="text" id="offer_percentage" class="form-control "
                       placeholder="نسبة الخصم على سعر المنتج" name="percentage">

                <span  class="invalid-feedback" role="alert">
                                        <strong>{{  }}</strong>
                                    </span>

            </div>

        </div>


        <div v-if="selected_type==='2'">
            <div  class="col-md-6">
                <div class="form-group">
                    <label for="amount">كمية العرض</label>
                    <input :value="jsonOffer?jsonOffer.amount:''" type="text" id="amount" class="form-control "
                           placeholder="كمية العرض" name="amount">

                    <span class="invalid-feedback" role="alert">
                                        <strong>{{  }}</strong>
                                    </span>

                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="value">عدد القطع الهدية</label>
                    <input :value="jsonOffer?jsonOffer.gift_amount:''" type="text" id="value" class="form-control "
                           placeholder="عدد قطع الهدية" name="gift_amount">

                    <span class="invalid-feedback" role="alert">
                                        <strong>{{  }}</strong>
                                    </span>

                </div>

            </div>

        </div>


        <div v-if="selected_type==='3'" class="col-md-6">
            <div class="form-group">
                <label for="offer_value">خصم مبلغ</label>
                <input :value="jsonOffer?jsonOffer.value:''" type="text" id="offer_value" class="form-control "
                       placeholder="خصم مبلغ على سعر المنتج" name="value">

                <span  class="invalid-feedback" role="alert">
                                        <strong>{{  }}</strong>
                                    </span>

            </div>

        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="offer_expireDate">تاريخ انتهاء العرض</label>
                <input :value="jsonOffer?jsonOffer.expire_date:''" type="date" id="offer_expireDate" class="form-control" name="expire_date" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Fixed" data-original-title="" title="">
            </div>
        </div>
    </div>





</template>

<script>
    export default {
        name: "offerType",
       props:[
           "offer",
           "types",
       ],
        data (){
            return {
                "jsonOffer":this.offer? JSON.parse(this.offer):null,
                "jsonTypes":JSON.parse(this.types),
                "selected_type":1,

            };
        },

        methods:{
            "selected":function (e) {
                let self=this;
                self.selected_type=e.target.value;
                console.log(self.selected_type);
            }
        },

        mounted() {
            this.selected_type=this.jsonOffer? this.jsonOffer.type.toString():'1';
            console.log(this.selected_type);
        }

    }
</script>


