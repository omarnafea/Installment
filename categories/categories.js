$("#categories_table").dataTable();




$(document).on('submit', '#add_category_form', function(event){
    event.preventDefault();

   
    let ajax_url = "ajax/add_category.php";

    if($("#category_id").val() !== '-1'){
        ajax_url = "ajax/update_category.php"
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
