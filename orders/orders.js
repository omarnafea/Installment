$("#test_btn").click(function () {


   // var selected_products = $("#select_products").val();


    //$("#select_products").find(':selected').value();

    var products = $(".product:selected");


    var total = 0;
    for(var i = 0 ; i < products.length ; i++){
        total +=  parseFloat($(products[i]).data('price'));
    }


    var profitRate = 0.2;

    var payValue =  parseFloat($("#pay_value").val());
    var price = total + total * profitRate;
    var interval  = price / payValue;

    console.log(interval);
});