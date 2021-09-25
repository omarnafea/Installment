<?php


include "../../db_connect.php";

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

