<?php

include "../../db_connect.php";





$params =[
    ":product_name"   => $_POST['product_name'],
    ":cat_id"         => $_POST['category_id'],
    ":quantity"       => $_POST['quantity'],
    ":image"          => $image_name
  
];

$update = $con->prepare("UPDATE products set product_name = :product_name , Cat_id = :Cat_id , quantity = :quantity WHERE product_id = :product_id");
$update->execute($params);

die(json_encode(['success'=>true , 'message'=>'Customer data updated successfully']));
