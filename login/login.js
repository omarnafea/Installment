
$(document).on('click', '#btn_login', function(){

    var username = $("#username").val();
    var password = $("#password").val();

    if(username.length === 0 || password.length === 0){
        Swal.fire({
            icon: 'warning',
            title: '',
            text: 'Please your username and password'
        });
        return false;
    }else{
        $.ajax({
            type : 'POST',
            url  : 'login_ajax.php',
            data : {username:username,password:password},
            dataType : "json",
            success : function(data){
                if (data.success === false) {
                    Swal.fire({
                        icon: 'warning',
                        title: '',
                        text: data.message
                    });
                }else{
                    window.location = "../dashboard";
                }
            }
        });
    }
});