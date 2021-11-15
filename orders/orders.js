$("#calc_pay_interval").click(function () {



    var products =$(".product-quantity");

    var qty , price , total_price = 0;

    for(var i = 0 ; i < products.length  ; i++ ){
        qty = $(products[i]).val();
        price = $(products[i]).data('price');
        total_price += qty * price;
    }

    console.log(total_price);


    return;



    var products = $(".product:selected");

    var total = 0;
    for(var i = 0 ; i < products.length ; i++){
        total +=  parseFloat($(products[i]).data('price'));
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

            var price = total + total * profitRate;
            var interval  = price / payValue;

            $("#pay_interval").html(interval + ' Months' );
            $("#total_price").html(price+ ' JOD' );
            $(".hidden-input").removeClass('d-none');

           /* console.log(data);
            console.log(interval);*/
        }
    });

});


$(document).on('submit', '#add_order_form', function(event){
    event.preventDefault();

    var data = {};

    var custoemr_id = $("#customer_id").val();
    var pay_value = $("#pay_value").val();
    var notes = $("#notes").val();

    data.custoemr_id = custoemr_id;
    data.pay_value    = pay_value;
    data.notes = notes;

    var product_quantity = $(".product-quantity");

    var products = [];
    for(var i = 0  ; i < product_quantity.length ; i++){
        products.push({
            product_id : $(product_quantity[i]).data('product-id'),
            price : $(product_quantity[i]).data('price') ,
            quantity :$(product_quantity[i]).val()
        });
    }

    data.products = products;
    //console.log(products);
    console.log(data);
    return;
   

    /*
    if($("#price").val() < 1){
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text:  'Invalid Price'
        })

        return false;
    }*/


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