<?php

include "../../db_connect.php";



//check if this email elready used
$query = "SELECT * FROM customers WHERE email = ? AND customer_id != ?"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute([$_POST['email'] , $_POST['customer_id']]);
$check_customer = $statement->fetch(PDO::FETCH_ASSOC);

//check if $check_customer is araay or is false
if(is_array($check_customer) ){
    die(json_encode(['success'=>false , 'message'=>'This email elready exist']));
}


if(!is_numeric($_POST['mobile']) || strlen($_POST['mobile']) !== 10){
    die(json_encode(['success'=>false , 'message'=>'Invalid mobile']));
}

$update = $con->prepare("UPDATE customers set name = :name , email = :email , mobile = :mobile WHERE customer_id = :customer_id");
$update->execute([
":name"         => $_POST['name'],
":email"        => $_POST['email'],
":mobile"       => $_POST['mobile'],
":customer_id"  => $_POST['customer_id'],
]);

die(json_encode(['success'=>true , 'message'=>'Customer data updated successfully']));
