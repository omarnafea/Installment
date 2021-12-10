
var interval  , total_price = 0 , priceAfterRate;
$("#calc_pay_interval").click(function () {



    var products =$(".product-quantity");

    var qty , price ;

    for(var i = 0 ; i < products.length  ; i++ ){
        qty = $(products[i]).val();
        price = $(products[i]).data('price');
        total_price += qty * price;
    }

    var payValue =  parseFloat($("#pay_value").val());


    $.ajax({
        url: "ajax/get_profit_rate.php",
        method:'POST',
        data: {pay_value  : payValue},
        dataType : "json",
        success:function(data)
        {
            var profitRate = parseFloat(data.profit_rate);

             priceAfterRate = total_price + (total_price * profitRate);

             interval  = priceAfterRate / payValue;

            $("#pay_interval").html(interval + ' Months' );
            $("#total_price").html(priceAfterRate+ ' JOD' );
            $(".hidden-input").removeClass('d-none');

            /* console.log(data);
             console.log(interval);*/
        }
    });
});


$(document).on('submit', '#add_order_form', function(event){
    event.preventDefault();

    var data = {};

    var customer_id = $("#customer_id").val();
    var pay_value = $("#pay_value").val();
    var notes = $("#notes").val();

    data.customer_id = customer_id;
    data.pay_value    = pay_value;
    data.notes = notes;
    data.interval = interval;
    data.total_price = priceAfterRate;

    var product_quantity = $(".product-quantity");

    var products = [];
    for(var i = 0  ; i < product_quantity.length ; i++){
        products.push(
            {
            product_id : $(product_quantity[i]).data('product-id'),
            price : $(product_quantity[i]).data('price') ,
            quantity :$(product_quantity[i]).val()
          }
        );
    }

    data.products = products;


    let ajax_url = "ajax/add_order.php";

    $.ajax({
        url:ajax_url,
        method:'POST',
        data: data,
        dataType : "json",
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

    console.log($(this).val());


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
