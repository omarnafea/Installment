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