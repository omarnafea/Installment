
 $("#users_table").DataTable(
     
 );


































$(document).on('submit', '#user_add_form', function(event){
    event.preventDefault();
    if($("#privilege_id").val() === '-1'){
        Swal.fire({
            icon: 'warning',
            title: '',
            text: 'Please select a privilege'
        });
        return false;
    }

    let ajax_url = "ajax/add_user.php";

   console.log('user id  : ' , $("#user_id").val());

    if($("#user_id").val() !== '-1'){
        ajax_url = "ajax/update_user.php";
    }
    $.ajax({
        url:ajax_url,
        method:'POST',
        data:new FormData(this),
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
