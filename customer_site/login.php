<html>
<head>
    <title>Welcome</title>
    <meta charset="utf-8"/>
    <?php include "../include/header.php";?>
    <link rel="stylesheet" href="customer_site.css">
</head>
<body>
<?php include "../include/customers_navbar.php"?>
<div class="container-fluid pt-5 mt-5">
    <div class="login-page col-md-4 mx-auto pt-5">
        <h2 class="text-primary text-center font-weight-bolder">Login</h2>
        <form  method="post" class="login-form">
            <div class="form-group">
                <label class="text-primary font-weight-bolder">Mobile</label>
                <input type="text" id="mobile" placeholder="Enter Mobile" name="mobile" class="form-control">
            </div>
            <div class="form-group">
                <label class="text-primary font-weight-bolder">Password</label>
                <input type="password" id="password" placeholder="Enter password" name="password" class="form-control">
            </div>

            <div class="text-center">
                <input type="button" id="btn_login" value="Login" name="login" class="btn btn-primary w-75" >
            </div>
        </form>
    </div>
</div>
<script src="customer_site.js"></script>


</body>
</html>