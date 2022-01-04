<?php
$customer_id = -1;
$name = "";
$mobile = "";
$email = "";

$update_mode = false; //add customer (not Update)

include '../db_connect.php';
if(isset($_GET['customer_id'])){
$update_mode = true;
$customer_id = $_GET['customer_id'];

$statement = $con->prepare("select * from customers where customer_id = ? ");  // prepare query
$statement->execute([$customer_id]);
$customer = $statement->fetch(PDO::FETCH_ASSOC);

$name = $customer["name"];
$mobile =$customer["mobile"];
$email =$customer["email"];
/*
echo '<pre>';
print_r($customer);
echo '</pre>';die;
*/


}

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
    <?php
    include "../include/dashboard.php";
    ?>


    <div class="main-form">


         <?php 
                 if($update_mode == false){
                    echo '<h2 class="text-primary text-center mt-3">Add New Customer</h2>';
                 }else{
                    echo '<h2 class="text-primary text-center mt-3">Update Customer</h2>';
                 }
         ?>
       

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

        <input type="hidden"  id="customer_id" name="customer_id" value="<?=$customer_id?>">

        </form>


</div>
<script src="customers.js"> </script>
</body>
</html>

