<?php

session_start();

include "../../db_connect.php";

//print_r($_POST);die;
$mobile=$_POST['mobile'];
$password=sha1($_POST['password']);//encrypt password using sha1
$response = [
    "success"=>true
];

$query = "SELECT * FROM customers WHERE mobile = ? AND password = ?  LIMIT 1 ";
$stmt=$con->prepare($query);
$stmt->execute(array($mobile,$password));
$customer =$stmt->fetch();
$count=$stmt->rowCount();
if($count > 0){
    $_SESSION['customer_id']=$customer['customer_id'];      // Register Session Name
    $_SESSION['customer_name']=$customer['name'];  // Register Session ID
    $_SESSION['customer_mobile']=$customer['mobile'];
}
else{
    $response['success'] = false;
    $response['message'] = "Mobile or password not correct";
}
die(json_encode($response));
?>