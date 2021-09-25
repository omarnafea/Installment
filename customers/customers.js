$("#customers_table").dataTable();




$(document).on('submit', '#add_customer_form', function(event){
    event.preventDefault();

   
    let ajax_url = "ajax/add_customer.php";


   /* if($("#cust").val() !== '-1'){
        ajax_url = "ajax/update_user.php";
    }*/
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

           }
        }
    });

});
