$("#customers_table").dataTable();




$(document).on('submit', '#add_product_form', function(event){
    event.preventDefault();


    if($("#quantity").val().trim() !== '' &&  $("#quantity").val() < 1){
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text:  'Invalid Quantity'
        })

        return false;
    }

    if($("#price").val() < 1){
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text:  'Invalid Price'
        })

        return false;
    }

   
    let ajax_url = "ajax/add_product.php";

    if($("#product_id").val() !== '-1'){
        ajax_url = "ajax/update_product.php"
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
