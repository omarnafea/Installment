<?php
$customer_id = -1;
$name = "";
$mobile = "";
$email = "";

$update_mode = false; //add customer (not Update)
?>
<html>
<head>
    <title>Add Customer</title>
    <meta charset="utf-8"/>
    <?php include "../include/header.php";?>
    <link rel="stylesheet" href="customers.css">
</head>

<body>
<?php include "../include/navbar.php"?>

<div class="container-fluid pt-5">

<div class="main-form">
        <h2 class="text-primary text-center mt-3">Add New Customer</h2>

        <form id="add_customer_form">
             
        <div class="form-group">
            <label>Name</label>
            <input  type="text" value="<?=$name?>" class="form-control" name="name" id="name" placeholder="Enter customer name" required >
        </div>

        <div class="form-group">
            <label>Email</label>
            <input  type="email" value="<?=$email?>" class="form-control" name="email" id="email" placeholder="Enter customer email" required >
        </div>

        <div class="form-group">
            <label>Mobile</label>
            <input  type="text" value="<?=$mobile?>" class="form-control" name="mobile" id="mobile" placeholder="Enter customer mobile" required >
        </div>
        
        <div class="text-center">
            <input type="submit" class="btn btn-primary submit-btn" value="Save">
        </div>

        <input type="text" name="customer_id" value="<?=$customer_id?>">

        </form>


</div>
<script src="customers.js"> </script>
</body>
</html>

