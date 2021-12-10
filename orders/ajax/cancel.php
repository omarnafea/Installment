<?php
/**
 * Created by PhpStorm.
 * User: ultimate-pc
 * Date: 2021/12/10
 * Time: 10:27 ص
 */

include "../../db_connect.php";
session_start();

$order_id = $_POST['order_id'];

$query = "SELECT amount FROM installments WHERE order_id = ?"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute([$order_id]);
$check_installments = $statement->fetchAll(PDO::FETCH_ASSOC);


//check if $check_category is araay or is false
if(count($check_installments) > 0 ){
    die(json_encode(['success'=>false , 'message'=>'You cannot cancel this order']));
}

$update = $con->prepare("UPDATE orders set status = 'CANCELED' where order_id =:order_id");
$update->execute([
    ":order_id"         =>$order_id
]);

die(json_encode(['success'=>true , 'message'=>'Order canceled successfully']));


