
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
