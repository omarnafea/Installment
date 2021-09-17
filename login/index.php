<html>
<head>
    <title>Login</title>
    <meta charset="utf-8"/>
    <?php include "../include/header.php";?>
    <script src="login.js"> </script>
    <link rel="stylesheet" href="login.css">
</head>

<body>

<div class="login-page col-md-4 mx-auto pt-5">
    <h2 class="text-primary text-center font-weight-bolder">Login</h2>
    <form  method="post" class="login-form">
        <div class="form-group">
            <label class="text-primary font-weight-bolder">Username</label>
            <input type="text" id="username" placeholder="Enter username" name="username" class="form-control">
        </div>
        <div class="form-group">
            <label class="text-primary font-weight-bolder">Password</label>
            <input type="password" id="password" placeholder="Enter password" name="password" class="form-control">
        </div>

        <div class="text-center">
            <input type="button" id="btn_login" value="Login" name="login" class="btn btn-primary" >
        </div>
    </form>

</div>

</body>
</html>


<?php
