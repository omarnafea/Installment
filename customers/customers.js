$("#customers_table").dataTable();




$(document).on('submit', '#add_customer_form', function(event){
    event.preventDefault();

   
    let ajax_url = "ajax/add_customer.php";

    if($("#customer_id") !== '-1'){
        ajax_url = "ajax/update_customer.php"
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
