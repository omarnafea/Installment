<?php


include "../../db_connect.php";



$image = upload_image($_FILES['image']);

if($image['success'] !== true){
    die(json_encode($image));
}

$image_name = $image['image'];


//check if this product name elready used

$query = "SELECT * FROM products WHERE product_name = ?"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute([$_POST['product_name']]);
$check_product = $statement->fetch(PDO::FETCH_ASSOC);

//check if $check_customer is araay or is false
if(is_array($check_product)){
    die(json_encode(['success'=>false , 'message'=>'This product elready exist']));
}




$params = [
    ":product_name"   => $_POST['product_name'],
    ":cat_id"         => $_POST['category_id'],
    ":quantity"       => $_POST['quantity'],
    ":image"          => $image_name
];

$statment = $con->prepare("INSERT INTO products (product_name , cat_id , quantity , image) 
                VALUES (:product_name , :cat_id , :quantity , :image)");
$statment->execute($params);

die(json_encode(['success'=>true , 'message'=>'Product added successfully']));



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


