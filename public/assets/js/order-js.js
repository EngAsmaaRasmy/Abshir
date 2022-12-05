$(document).ready(function(event) {
    var productsArray ;
    var sizesArray;
    var sizePrice;
    var total = ''

    // Add new row
    $("#add-row").click(function(){
        console.log(productsArray);
        var selectedProduct = [];
        var selectedSize = [];
        var productArray = [];
        var sizeArray = [];
        for (var option of document.getElementById('product').options) {
            if (option.selected) {
                selectedProduct.push(option.value, option.text);
            }
        }
        if (productsArray) {
            for (var product of productsArray) {
                if (product.id == selectedProduct[0]) {
                    productArray.push(product.id,product.name_ar);
                }
            }
        } else {
            productArray = selectedProduct;
        }

        for (var option of document.getElementById('size').options) {
            if (option.selected) {
                selectedSize.push(option.value, option.text);
            }
        }
        if (sizesArray) {
            for (var size of sizesArray) {
                if (size.id == selectedSize[0]) {
                    sizeArray.push(size.id,size.name);
                }
            }
        } else {
            sizeArray = selectedSize;
        }

        var product = $("#product").val();
        var size = $("#size").val();
        var quantity = $("#quantity").val();
        $("#products_table tbody tr").last().after(
            '<tr class="fadetext">'+
                '<td><input type="checkbox" id="select-row"></td>'+
                '<td>'+'<input class="form-control" name="product[]" value="'+productArray[0]+'" hidden>'+productArray[1]+'</td>'+
                '<td>'+'<input class="form-control" name="size[]" value="'+sizeArray[0]+'" hidden>'+sizeArray[1]+'</td>'+
                '<td>'+'<input class="form-control amount" name="amount[]" value="'+quantity+'" hidden>'+quantity+'</td>'+
                '<td>'+'<input class="form-control price" name="price[]" value="'+sizePrice+'" hidden>'+sizePrice+'</td>'+
                '<td>'+'<input class="form-control total" value="'+quantity * sizePrice+'" hidden>'+quantity * sizePrice+'</td>'+
            '</tr>'
        );
        calc();
    })

     // Select all checkbox
     $("#select-all").click(function(){
        var isSelected = $(this).is(":checked");
        if(isSelected){
            $(".table tbody tr").each(function(){
                $(this).find('input[type="checkbox"]').prop('checked', true);
            })
        }else{
            $(".table tbody tr").each(function(){
                $(this).find('input[type="checkbox"]').prop('checked', false);
            })
        }
    });
    
    // Remove selected rows
    $("#remove-row").click(function(){
        $(".table tbody tr").each(function(){
            var isChecked = $(this).find('input[type="checkbox"]').is(":checked");
            var tableSize = $(".table tbody tr").length;
            if(tableSize == 1){
                alert('All rows cannot be deleted.');
            }else if(isChecked){
                $(this).remove();
            }
        });
    });

    function calc() {
        $('#products_table tbody tr').each(function(i, element) {
            var html = $(this).html();
            if (html != '') {
                var amount = $(this).find('.amount').val();
                var price = $(this).find('.price').val();
                var total = $(this).find('.total').val();

                calc_total();
            }
        });
    }

    function calc_total() {
        total = 0;
        var tax_sum = 0;
        $('.total').each(function() {
            total += parseInt($(this).val());
        });
        tax_sum = total / 100 * $('#tax').val();
        $('#total_amount').val((tax_sum + total).toFixed(2));
    }

    $('#category').on('change', function() {
        var idCategory = this.value;
        $.ajax({
            url: '/admin/orders/fetch-shops/' + idCategory,
            type: "GET",
            dataType: 'json',
            success: function(result) {
                $('#shop').html('<option value="">من فضلك اختار المحل</option>');
                $.each(result.shops, function(key, value) {
                    $("#shop").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    });

    $('#shop').on('change', function() {
        var idShop = this.value;
        $.ajax({
            url: '/admin/orders/fetch-products/' + idShop,
            type: "GET",
            dataType: 'json',
            success: function(result) {
                $('#product').html('<option value="">من فضلك اختار المنتج</option>');
                productsArray = result.products;
                $.each(result.products, function(key, value) {
                    $("#product").append('<option value="' + value
                        .id+ '">' + value.name_ar + '</option>');

                });
            }
        });
    });
    
    $('#product').on('change', function() {
        var idProduct = this.value;
        $.ajax({
            url: '/admin/orders/fetch-sizes/' + idProduct,
            type: "GET",
            dataType: 'json',
            success: function(result) {
                $('#size').html('<option value="">من فضلك اختار الحجم</option>');
                sizesArray = result.sizes;
                $.each(result.sizes, function(key, value) {
                    $("#size").append('<option value="' + value
                        .id + '">' + value.name +'</option>');
                });
            }
        });
    });

    $('#size').on('change', function() {
        var idSize = this.value;
        $.ajax({
            url: '/admin/orders/fetch-price/' + idSize,
            type: "GET",
            dataType: 'json',
            success: function(result) {
                sizePrice = result.price
            }
        })
    });


    $(".table:not(#prod-tb)").DataTable({
        paging: false,
        info: false,
        "language": {
            "zeroRecords": "لم نجد نتيجة مطابقه لبحثك",
            search: 'بحث'
        }
    });


    $("#prod-tb").on("draw.dt", function() {
        $(this).find(".dataTables_empty").parents('tbody').empty();
    }).DataTable({
        "paging": true,
        "ordering": false,
        "info": false,
        searching: false,

    });





});