<?php

include "../../db_connect.php";
session_start();


$params = [
    ":cachier_id"    => $_SESSION['user_id'],
    ":order_id"      => $_POST['order_id'],
    ":amount"        => $_POST['amount']
];
//todo check pay value
$statment = $con->prepare("INSERT INTO installments 
                (cachier_id , order_id , amount) 
                VALUES (:cachier_id , :order_id , :amount)");
$installment = $statment->execute($params);
die(json_encode(['success'=>true]));
