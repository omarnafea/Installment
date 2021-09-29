<?php


include "../../db_connect.php";

//check if this email elready used

$query = "SELECT * FROM customers WHERE email = ?"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute([$_POST['email']]);
$check_customer = $statement->fetch(PDO::FETCH_ASSOC);

//check if $check_customer is araay or is false
if(is_array($check_customer)){
    die(json_encode(['success'=>false , 'message'=>'This email elready exist']));
}




$params = [
    ":name"     => $_POST['name'],
    ":email"    => $_POST['email'],
    ":mobile"   => $_POST['mobile'],
    ":password" => sha1($_POST['mobile'])
];

$statment = $con->prepare("INSERT INTO customers (name , email , mobile , password) 
                VALUES (:name , :email , :mobile , :password)");
$statment->execute($params);

die(json_encode(['success'=>true , 'message'=>'Customer added successfully']));

