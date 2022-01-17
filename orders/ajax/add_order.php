<?php
include "../../db_connect.php";
session_start();


//print_r($_POST);
//print_r($_FILES);
//die;
$image = upload_image($_FILES['promissory_note']);

if($image['success'] !== true){
    die(json_encode($image));
}

$promissory_note = $image['image'];


$params = [
    ":creator_id"      => $_SESSION['user_id'],
    ":customer_id"     => $_POST['customer_id'],
    ":pay_interval"    => $_POST['interval'],
    ":pay_value"       => $_POST['pay_value'],
    ":price"           => $_POST['total_price'],
    ":notes"           => $_POST['notes'],
    ":promissory_note" => $promissory_note
];

$statment = $con->prepare("INSERT INTO orders 
                (creator_id , customer_id , pay_interval , pay_value , price , notes , promissory_note) 
                VALUES (:creator_id , :customer_id , :pay_interval , :pay_value, :price, :notes , :promissory_note)");
$order = $statment->execute($params);
$order_id = $con->lastInsertId();

//order id

$products = json_decode($_POST['products'] , true);

foreach ($products as $order_product){
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

    $statment = $con->prepare("UPDATE products set quantity = quantity  - ? where product_id =  ?");
    $statment->execute([$order_product['quantity'] , $order_product['product_id']]);
}


$sponsor1_name = $_POST['sponsor1_name'];
$sponsor2_name = $_POST['sponsor2_name'];
$sponsor1_mobile = $_POST['sponsor1_mobile'];
$sponsor2_mobile = $_POST['sponsor2_mobile'];



if(!is_numeric($_POST['sponsor1_mobile']) || strlen($_POST['sponsor1_mobile']) !== 10){
    die(json_encode(['success'=>false , 'message'=>'Invalid Sponsor 1 mobile']));
}

if(!is_numeric($_POST['sponsor2_mobile']) || strlen($_POST['sponsor2_mobile']) !== 10){
    die(json_encode(['success'=>false , 'message'=>'Invalid Sponsor 2 mobile']));
}

$sponsor1_id = upload_image($_FILES['sponsor1_id']);
if($sponsor1_id['success'] !== true){
    die(json_encode($sponsor1_id));
}
$sponsor1_id_image = $sponsor1_id['image'];

$sponsor1_contract = upload_image($_FILES['sponsor1_contract']);
if($sponsor1_contract['success'] !== true){
    die(json_encode($sponsor1_contract));
}
$sponsor1_contract_image = $sponsor1_contract['image'];

$sponsor2_id = upload_image($_FILES['sponsor2_id']);
if($sponsor2_id['success'] !== true){
    die(json_encode($sponsor2_id));
}
$sponsor2_id_image = $sponsor2_id['image'];


$sponsor2_contract = upload_image($_FILES['sponsor2_contract']);
if($sponsor2_contract['success'] !== true){
    die(json_encode($sponsor2_contract));
}
$sponsor2_contract_image = $sponsor2_contract['image'];



$params = [
    ":order_id"          => $order_id,
    ":sponsor_id_image"  => $sponsor1_id_image,
    ":sponsor_name"      => $sponsor1_name,
    ":sponsor_mobile"    => $sponsor1_mobile,
    ":sponsor_contract"  => $sponsor1_contract_image

];
$statment = $con->prepare("INSERT INTO sponsors 
                (order_id , sponsor_id_image , sponsor_name , sponsor_mobile , sponsor_contract) 
                VALUES (:order_id , :sponsor_id_image , :sponsor_name , :sponsor_mobile , :sponsor_contract)");
$statment->execute($params);

$params = [
    ":order_id"          => $order_id,
    ":sponsor_id_image"  => $sponsor2_id_image,
    ":sponsor_name"      => $sponsor2_name,
    ":sponsor_mobile"    => $sponsor2_mobile,
    ":sponsor_contract"  => $sponsor2_contract_image

];
$statment = $con->prepare("INSERT INTO sponsors 
                (order_id , sponsor_id_image , sponsor_name , sponsor_mobile , sponsor_contract) 
                VALUES (:order_id , :sponsor_id_image , :sponsor_name , :sponsor_mobile , :sponsor_contract)");
$statment->execute($params);


die(json_encode(['success'=>true , 'message'=>'Order added successfully']));



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


    $images_folder =  $_SERVER['DOCUMENT_ROOT'] . "/installment/orders/images/";



    $Image=rand(0,1000000).'_'.strtolower($imageName);

    $Image=str_replace(' ','',$Image);
    move_uploaded_file($imageTempName,  $images_folder.$Image);
    $output['success']=true;
    $output['image']=$Image;
    return $output;

}


