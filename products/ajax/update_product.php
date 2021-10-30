<?php

include "../../db_connect.php";



//check if this product elready used
$query = "SELECT * FROM products WHERE product_name = ? AND product_id != ?"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute([$_POST['product_name'] , $_POST['product_id']]);
$check_product = $statement->fetch(PDO::FETCH_ASSOC);

if(is_array($check_product) ){
    die(json_encode(['success'=>false , 'message'=>'This product elready exist']));
}

/*
var_dump($_POST);
var_dump($_FILES);die;*/

$qty = 0;
if(isset($_POST['quantity']) && !empty($_POST['quantity'])){
    $qty = $_POST['quantity'];
}

$params = [
    ":product_name"   => $_POST['product_name'],
    ":cat_id"         => $_POST['category_id'],
    ":quantity"       => $qty,
    ":product_id"     => $_POST['product_id']
];


$image_query = "";
if(!empty( $_FILES['image']['name'])){

        $image = upload_image($_FILES['image']);

        if($image['success'] !== true){
            die(json_encode($image));
        }

        $image_name = $image['image'];
        $params[':image'] = $image_name;
        $image_query = ",image = :image";
}




$update = $con->prepare("UPDATE products set product_name = :product_name , cat_id = :cat_id , 
                          quantity  = quantity + :quantity $image_query WHERE product_id = :product_id");
$update->execute($params);

die(json_encode(['success'=>true , 'message'=>'Product data updated successfully']));





function upload_image($file){
    $output=array();
    $allowed_extension=array('jpeg','jpg','png');

    $imageName=$file['name'];
    $imageSize=$file['size'];
    $imageTempName=$file['tmp_name'];
    $imageType=$file['type'];

    $image_extension=explode('.',$imageName );
   
    $image_extension=strtolower(end($image_extension));  // the capital extension may be make an error

   

    if(!empty($imageName) &&  ! in_array($image_extension, $allowed_extension)){
        $output['success']=false;
        $output['error']='This extension Is Not Allowed';
        return  $output;
    }


    if(!empty($imageName) && $imageSize > 4194304){
        $output['success']=false;
        $output['error']='Image Size Must Be Less Than 4MB';
        return  $output;
    }


    $images_folder =  $_SERVER['DOCUMENT_ROOT'] . "/installment/products/images/";
   


    $Image=rand(0,1000000).'_'.strtolower($imageName);

    $Image=str_replace(' ','',$Image);
    move_uploaded_file($imageTempName,  $images_folder.$Image);
    $output['success']=true;
    $output['image']=$Image;
    return $output;

}
