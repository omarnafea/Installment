<?php

include "../../db_connect.php";
session_start();


$params = [
    ":cachier_id"    => $_SESSION['user_id'],
    ":order_id"      => $_POST['order_id'],
    ":amount"        => $_POST['amount']
];


$query = "SELECT o.pay_value from orders as o WHERE o.order_id = ?"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute([$_POST['order_id']]);
$order= $statement->fetch(PDO::FETCH_ASSOC);

if(floatval($_POST['amount']) != $order['pay_value']){
    die(json_encode(['success'=>false , 'message'=> 'Invalid amount'] ));
}

//todo check if the order totally paid then finish it
$statment = $con->prepare("INSERT INTO installments 
                (cachier_id , order_id , amount) 
                VALUES (:cachier_id , :order_id , :amount)");
$installment = $statment->execute($params);
die(json_encode(['success'=>true , 'message'=> 'Amount paid successfully'] ));
