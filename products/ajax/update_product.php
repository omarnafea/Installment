<?php

include "../../db_connect.php";


/*
//check if this email elready used
$query = "SELECT * FROM products WHERE email = ? AND customer_id != ?"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute([$_POST['email'] , $_POST['customer_id']]);
$check_customer = $statement->fetch(PDO::FETCH_ASSOC);

//check if $check_customer is araay or is false
if(is_array($check_customer) ){
    die(json_encode(['success'=>false , 'message'=>'This email elready exist']));
}
*/


$update = $con->prepare("UPDATE products set product_name = :product_name , Category = :Cat_id , quantity = :quantity WHERE product_id = :product_id");
$update->execute([
    ":product_name"   => $_POST['product_name'],
    ":cat_id"         => $_POST['category_id'],
    ":quantity"       => $_POST['quantity'],
    ":image"          => $image_name
  
]);

die(json_encode(['success'=>true , 'message'=>'Customer data updated successfully']));
