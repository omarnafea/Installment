<?php


include "../../db_connect.php";
$products = [
    [
        'product_id' => 5 ,
        'quantity' =>10 ,
        'price'=> 150
    ],[
        'product_id' => 5 ,
        'quantity' =>10 ,
        'price'=> 150
    ]
];

//todo recalculate pay interval
$params = [
    ":creator_id"     => $_POST['name'],
    ":customer_id"    => $_POST['email'],
    ":pay_interval"   => $_POST['mobile'],
    ":pay_value"      => $_POST['mobile'],
    ":price"          => $_POST['mobile'],
    ":notes"          => $_POST['mobile']
];
$statment = $con->prepare("INSERT INTO orders 
                (creator_id , customer_id , pay_interval , pay_value , price , notes) 
                VALUES (:creator_id , :customer_id , :pay_interval , :pay_value, :price, :notes)");
$statment->execute($params);
//order id


//todo insert into orders products
//todo decrease product quantity

die(json_encode(['success'=>true , 'message'=>'Customer added successfully']));

