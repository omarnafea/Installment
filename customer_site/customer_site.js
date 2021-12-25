
$(document).on('click', '#btn_login', function(){

    var mobile = $("#mobile").val();
    var password = $("#password").val();
    if(mobile.length === 0 || password.length === 0){
        Swal.fire({
            icon: 'warning',
            title: '',
            text: 'Please your mobile and password'
        });
        return false;
    }else{
        $.ajax({
            type : 'POST',
            url  : 'ajax/login.php',
            data : {mobile:mobile,password:password},
            dataType : "json",
            success : function(data){
                if (data.success === false) {
                    Swal.fire({
                        icon: 'warning',
                        title: '',
                        text: data.message
                    });
                }else{
                    window.location = "my_orders.php";
                }
            }
        });
    }
});


$(document).on('click', '.pay-now-btn', function() {
    $(".pay-online-form").removeClass('d-none');
    window.location.href="#username";
});


$(document).on('submit', '#pay_form', function(event){
    event.preventDefault();

    $.ajax({
        url:"ajax/pay.php",
        method:'POST',
        data: new FormData(this),
        contentType:false,
        processData:false,
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

});


var interval  , total_price = 0 , priceAfterRate;
$("#calc_pay_interval").click(function () {

    total_price= 0;
    var products =$(".qty");

    var qty , price ;

    if(products.length < 1){
        Swal.fire({
            icon: 'warning',
            title: 'Please select at least one product ',
            text: ""
        });
        return false;
    }


    for(var i = 0 ; i < products.length  ; i++ ){
        qty = $(products[i]).val();

        if(isNaN(qty) || qty < 1){
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
        url: "../orders/ajax/get_profit_rate.php",
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

            var interval_text = months + " Months " ;

            if(days != 0)
                interval_text += Math.round(days)  + " Days";
            $("#pay_interval").html(interval_text);

            $("#total_price").html(priceAfterRate+ ' JOD' );
            $(".hidden-input").removeClass('d-none');

            Swal.fire({
                icon: 'info',
                title: " ",
                text:  'You will pay ' + payValue + ' JD for ' + interval_text
            });
            return false;


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

