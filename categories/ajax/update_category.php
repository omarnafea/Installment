<?php

include "../../db_connect.php";



//check if this name elready used
$query = "SELECT * FROM categories WHERE category_name = ? AND category_id != ?"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute([$_POST['category_name'] , $_POST['category_id']]);
$check_category = $statement->fetch(PDO::FETCH_ASSOC);

//check if $check_category is araay or is false
if(is_array($check_category) ){
    die(json_encode(['success'=>false , 'message'=>'This name elready exist']));
}



$update = $con->prepare("UPDATE categories set category_name = :category_name where category_id =:category_id");
$update->execute([
":category_name"         => $_POST['category_name'],
":category_id"         => $_POST['category_id'],
]);

die(json_encode(['success'=>true , 'message'=>'category data updated successfully']));

