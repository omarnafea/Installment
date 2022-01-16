<?php

include('../../db_connect.php');


$pass='';

$params =    array(
    ':name'              => $_POST["name"],
    ':email'             => $_POST["email"],
    ':user_name'         => $_POST["user_name"],
    ':privilege_id'      => $_POST["privilege_id"],
    ':user_id'           => $_POST["user_id"],
);

if(trim($_POST['password'])  !== ""){
    
if($_POST['password'] != $_POST['confirm_password']){
    die(json_encode(['success' => false , 'message'=>'Passwords not matches'] ));
}

    $pass=',password = :password';
    $params[':password'] = sha1($_POST["password"]);
}

$statement = $con->prepare(
    "UPDATE users 
    SET name = :name,email = :email ,user_name = :user_name {$pass},privilege_id=:privilege_id
    WHERE id = :user_id");
$result = $statement->execute($params);
die(json_encode(['success' => true , 'message'=>'User data updated successfully'] ));






?>