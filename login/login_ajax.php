<?php

session_start();

include "../db_connect.php";

$username=$_POST['username'];
$password=sha1($_POST['password']);//encrypt password using sha1
$response = [
    "success"=>true
];

$query = "SELECT
      id, user_name,password,privilege_id
     FROM users WHERE user_name = ? AND password = ? 
       AND is_active=1 LIMIT 1 ";

    $stmt=$con->prepare($query);
    $stmt->execute(array($username,$password));
    $user_row=$stmt->fetch();
    $count=$stmt->rowCount();
    if($count>0){
        $_SESSION['username']=$username;      // Register Session Name
        $_SESSION['user_id']=$user_row['id'];  // Register Session ID
        $_SESSION['privilege_id']=$user_row['privilege_id'];
    }
    else{
        $response['success'] = false;
        $response['message'] = "Username or password not correct";
    }
    die(json_encode($response));
?>