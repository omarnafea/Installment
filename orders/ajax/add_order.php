<?php



include "../../db_connect.php";
session_start();

$params = [
    ":creator_id"     => $_SESSION['user_id'],
    ":customer_id"    => $_POST['customer_id'],
    ":pay_interval"   => $_POST['interval'],
    ":pay_value"      => $_POST['pay_value'],
    ":price"          => $_POST['total_price'],
    ":notes"          => $_POST['notes']
];
$statment = $con->prepare("INSERT INTO orders 
                (creator_id , customer_id , pay_interval , pay_value , price , notes) 
                VALUES (:creator_id , :customer_id , :pay_interval , :pay_value, :price, :notes)");
$order = $statment->execute($params);
$order_id = $con->lastInsertId();

//order id


foreach ($_POST['products'] as $order_product){


    $params = [
        ":order_id"     => $order_id,
        ":product_id"    => $order_product['product_id'],
        ":quantity"   => $order_product['quantity'],
        ":sub_price"      =>  $order_product['price']  * $order_product['quantity']

    ];
    $statment = $con->prepare("INSERT INTO orders_products 
                (order_id , product_id , quantity , sub_price) 
                VALUES (:order_id , :product_id , :quantity , :sub_price)");
     $statment->execute($params);

}

//todo insert into orders products
//todo decrease product quantity

die(json_encode(['success'=>true , 'message'=>'Order added successfully']));

