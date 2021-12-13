

$(".add-pricing").click(function () {
    $(".pricing-container").append(`
    
    <div class="row  pricing-row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Min pay value</label>
                    <input type="number" class="form-control min-value" value="">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Max pay value</label>
                    <input type="number" class="form-control max-value" value="">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Percentage</label>
                    <input type="number" class="form-control percentage" value="">
                </div>
            </div>
            <div class="col-md-3">
                <button class="btn btn-danger delete-btn" onclick="deleteRow(this)"><i class="fa fa-times-circle"></i></button>
            </div>

        </div>
    
    `);
});

$(".delete-btn").click(function () {
    $(this).parent().parent().remove();
});


function deleteRow(element){
    $(element).parent().parent().remove();
}


$(".save-btn").click(function () {

    var pricing_rows = $(".pricing-row");

    var pricing_array = [];
    console.log(pricing_array);

    for(var i  = 0  ; i < pricing_rows.length; i++){
        pricing_array.push(
            {
            min_pay_value : $(pricing_rows[i]).find(".min-value").val(),
            max_pay_value : $(pricing_rows[i]).find(".max-value").val(),
            pricing_value : $(pricing_rows[i]).find(".percentage").val()
        }
        );
    }

    console.log(pricing_array);

    $.ajax({
        url:"ajax/update_pricing.php",
        method:'POST',
        data: {pricing : pricing_array},
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


$(document).on('submit', '#add_category_form', function(event){
    event.preventDefault();

   
    let ajax_url = "ajax/add_category.php";

    if($("#category_id").val() !== '-1'){
        ajax_url = "ajax/update_pricing.php"
    }

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
