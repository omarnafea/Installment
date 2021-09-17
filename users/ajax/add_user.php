<?php

include('../../db_connect.php');

$statement = $con->prepare("
   INSERT INTO users (name, email,user_name,password,privilege_id) 
   VALUES (:name, :email, :user_name,:password,:privilege_id )");
$result = $statement->execute(
    array(
        ':name'            => $_POST["name"],
        ':email'           => $_POST["email"],
        ':user_name'       => $_POST["user_name"],
        ':password'        => sha1($_POST["password"]),
        ':privilege_id'    => $_POST["privilege_id"]
    )
);

die(json_encode(['success' => true , 'message'=>'User added successfully'] ));