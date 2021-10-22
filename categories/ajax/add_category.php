<?php


include "../../db_connect.php";
//check if this name elready used
$query = "SELECT * FROM categories WHERE category_name = ?"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute([$_POST['category_name']]);
$check_category = $statement->fetch(PDO::FETCH_ASSOC);

//check if $check_category is araay or is false
if(is_array($check_category) ){
    die(json_encode(['success'=>false , 'message'=>'This name elready exist']));
}






$params = [
    ":category_name"     => $_POST['category_name'], 
];

$statment = $con->prepare("INSERT INTO categories (category_name ) 
                VALUES (:category_name)");
$statment->execute($params);

die(json_encode(['success'=>true , 'message'=>'category added successfully']));

