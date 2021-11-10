$("#test_btn").click(function () {


   // var selected_products = $("#select_products").val();


    //$("#select_products").find(':selected').value();

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

            console.log(data);
            console.log(interval);

        }
    });

});


$(document).on('submit', '#add_order_form', function(event){
    event.preventDefault();

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
           '           <div class="row"> <div class="col-6">'+$(products[i]).text()+'</div>\n' +
           '                <div class="ml-4">\n' +
           '                    <div class="form-group">\n' +
           '                        <input type="number" data-product-id="'+$(products[i]).val()+'" class="form-control" placeholder="Quantity" name="quantity" >\n' +
           '                    </div>\n' +
           '                </div>\n' +
           '            </div>')
    }

    console.log($(this).val());


});