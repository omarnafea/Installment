

$(document).ready(function () {
   $("#orders_table").DataTable( {
       "order": [[ 0, "desc" ]]
   } );
});

var interval  , total_price = 0 , priceAfterRate;
$("#calc_pay_interval").click(function () {

    total_price= 0;
    var products =$(".qty");

    var qty , price ;

    for(var i = 0 ; i < products.length  ; i++ ){
        qty = $(products[i]).val();

        if(qty < 1){
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Quantity ' + qty,
                text: ""
            });
            return false;
        }

        price = $(products[i]).data('price');
        total_price += qty * price;
    }

    var payValue =  parseFloat($("#pay_value").val());

    if(isNaN(payValue) || payValue < 1){
        Swal.fire({
            icon: 'warning',
            title: 'Invalid Pay value ',
            text: ""
        });
        return false;
    }

    $.ajax({
        url: "ajax/get_profit_rate.php",
        method:'POST',
        data: {pay_value  : payValue},
        dataType : "json",
        success:function(data)
        {
            var profitRate = parseFloat(data.profit_rate);

             priceAfterRate = total_price + (total_price * profitRate);
             interval  = parseFloat(priceAfterRate / payValue) ;

             console.log(total_price);
             console.log(priceAfterRate);
             console.log(interval);


             var days = (interval - Math.floor(interval)) * 30;
             var months= Math.floor(interval);

            var interval_text = months + " M " ;

            if(days != 0)
                interval_text += Math.round(days)  + " D";
            $("#pay_interval").html(interval_text);

            $("#total_price").html(priceAfterRate+ ' JOD' );
            $(".hidden-input").removeClass('d-none');

        }
    });
});


$(document).on('submit', '#add_order_form', function(event){
    event.preventDefault();

    var data = new FormData(this);


    var customer_id = $("#customer_id").val();

    if(customer_id == '-1'){
        Swal.fire({
            icon: 'warning',
            title: 'Please select a customer',
            text: ""
        });
        return false;
    }

    var pay_value = $("#pay_value").val();

    if(isNaN(pay_value) || pay_value < 1) {
        Swal.fire({
            icon: 'warning',
            title: 'Invalid pay value ' ,
            text: ""
        });
        return;
    }

    var notes = $("#notes").val();

    // data.append('customer_id' , customer_id);
    // data.append('pay_value' , pay_value);
    // data.append('notes' , notes);
    data.append('interval' , interval);
    data.append('total_price' , priceAfterRate);


    var product_quantity = $(".qty");

    var products = [];
    for(var i = 0  ; i < product_quantity.length ; i++){

        if($(product_quantity[i]).val() < 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Quantity ' + $(product_quantity[i]).val(),
                text: ""
            });
            return;
        }

        products.push(
            {
            product_id : $(product_quantity[i]).data('product-id'),
            price : $(product_quantity[i]).data('price') ,
            quantity :$(product_quantity[i]).val()
          }
        );
    }

    // console.log(products);return;
    data.append('products' , JSON.stringify(products));

    $.ajax({
        url:"ajax/add_order.php",
        method:'POST',
        data: data,
        dataType : "json",
        contentType:false,
        processData:false,
        success:function(data)
        {
            if(data.success){
                Swal.fire({
                    icon: 'success',
                    title: '',
                    text: data.message
                }).then(function () {
                    window.location.href = "index.php";
                });
            }else{
                Swal.fire({
                    icon: 'warning',
                    title: '',
                    text: data.message
                })
            }
        }
    });

});


$("#select_products").change(function () {

    var products = $(".product:selected");
    $(".products").html('');


    for(var i = 0 ; i < products.length ; i++){

       $(".products").append(
       '           <div class="row"> ' +
                    '<div class="col-6">'+$(products[i]).text()+'</div>\n' +
       '                 <div class="ml-4">\n' +
       '                    <div class="form-group">\n' +
       '                        <input type="number" data-product-id="'+$(products[i]).val()+'"  data-price="'+$(products[i]).data('price')+'" class="form-control product-quantity" value="1" placeholder="Quantity" name="quantity" >\n' +
       '                    </div>\n' +
       '                </div>\n' +
       '            </div>')
    }



});






$(document).on('click', '.cancel', function(event){
    var order_id = $(this).parent().parent().attr('id');


    Swal.fire({
        title: 'Are you sure?',
        text: "You want to cancel this order!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, calncel it!'
    }).then((result) => {
        if (result.isConfirmed) {

        $.ajax({
            url:'ajax/cancel.php',
            method:'POST',
            data: {order_id :  order_id},
            dataType : "json",
            success:function(data)
            {
                if(data.success){
                    Swal.fire({
                        icon: 'success',
                        title: '',
                        text: data.message
                    }).then(function () {
                        window.location.reload();
                    });
                }else{
                    Swal.fire({
                        icon: 'warning',
                        title: '',
                        text: data.message
                    })
                }
            }
        });

    }
});
});

$(".btn-select").click(function () {

    if($(this).hasClass('pro-selected')){
         $(this).removeClass('pro-selected');
         $(this).removeClass('btn-success');
         $(this).addClass('btn-primary');
         $(this).text('Select');
        $(this).parent().parent().find('.qty').remove();
    }else{
        $(this).addClass('pro-selected');
        $(this).removeClass('btn-primary');
        $(this).addClass('btn-success');
        $(this).text('Selected');
        $(this).parent().append(`<input type="number" class="qty form-control mt-2" placeholder="QTY" 
                data-product-id="${$(this).data('product-id')}"  data-price="${$(this).data('price')}">`);
    }
});


$("#filter_customer").change(function () {
   let customer_id = $(this).val();
   if(customer_id == '-1'){
       window.location.href = 'index.php';
   }else{
       window.location.href = 'index.php?customer_id=' + customer_id;

   }

});
