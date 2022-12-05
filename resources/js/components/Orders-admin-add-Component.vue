<template>
<div class="card" data-repeater-list="order" style="background-color: beige">
                                            <div class="card-header">
                                                <h3>المنتجات</h3>
                                            </div>
                                    
                                            <div class="card-body">
                                                <table class="table" id="products_table">
                                                    <thead>
                                                        <tr>
                                                            <th width="25%">المنتج</th>
                                                            <th width="25%">الحجم</th>
                                                            <th width="25%">الكمية</th>
                                                            <th width="25%">السعر</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody >
                                                        <tr id="product0" >
                                                            <td>
                                                                <select name="products[]" class="form-control" id="product">
                                                                    <option value="">-- اختار منتج --</option>
                                                                   
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="sizes[]" class="form-control" id="size">
                                                                    <option value="">-- اختار الحجم --</option>
                                                                    </select>

                                                            </td>
                                                            <td>
                                                                <input type="number" name="amounts[]" class="form-control" value="1" />
                                                            </td>
                                                            <td>
                                                                <input type="number" name="prices[]" class="form-control" value="1" />
                                                            </td>
                                                        </tr>
                                                        <tr id="product1"></tr>
                                                    </tbody>
                                                </table>
                                    
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button id="add_row" class="btn btn-default pull-left btn btn-blue" @click="addOrder">+ إضافة</button>
                                                        <button id='delete_row' class="pull-right btn btn-danger">- حذف</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
               
        
</template>
<script>
import $ from 'jquery'
export default {
  name: 'CreateOrder',
  data: function () {
    return {
      order: {},
      orders: [],
    }
  },
  // change route to push category id and supplier Id
  methods: {
    addOrder () {
      this.orders.push({
        product: {
          id: null,
          size: null,
        },
        id: (this.orders.length + 1),
        amount: 1,
        price: null,
      })
    },
    removeOrder (index) {
      this.orders.splice(index, 1)
    },
    calcTotal ($event, index) {
      this.products[index].total = parseFloat($event) * parseFloat(this.products[index].price)
    },
    calcPrice ($event, index) {
      this.products[index].total = parseFloat($event) * parseFloat(this.products[index].quantity)
    },
    // createOrder: function (e) {
    //   e.preventDefault()
    //   const formData = new FormData()
    //   formData.append('order_type_id', this.selectedTypeOfOrder.id)
    //   if (this.selectedCustomer.id) {
    //     formData.append('customer_id', this.selectedCustomer.id)
    //   }
    //   if (this.selectedSupplier.id) {
    //     formData.append('supplier_id', this.selectedSupplier.id)
    //   }
    //   this.sendProducts = []
    //   for (let i = 0; i <= this.products.length - 1; i++) {
    //     this.sendProducts.push({ product_id: this.products[i].product.id, price: this.products[i].price, quantity: this.products[i].quantity, transfer_number: this.products[i].transferNumber ?? '', total: this.products[i].total })
    //   }
    //   formData.append('products', JSON.stringify(this.sendProducts))
    //   this.postRequest(formData, this.$hostUrl + 'orders', '/orders')
    // }
  }
}
</script>


