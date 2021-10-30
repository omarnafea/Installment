<?php


$update_mode = false; //add product (not Update)
include '../db_connect.php';

$product_id = -1;
$product_name = "";
$quantity = "";
$image = "";
$category_id = -1;


$query = "SELECT * FROM categories"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);



if(isset($_GET['product_id'])){
    $update_mode = true;
    $product_id = $_GET['product_id'];
    
$query = "SELECT * FROM products where product_id = ?"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute([$product_id]);
$product = $statement->fetch(PDO::FETCH_ASSOC);

$product_name = $product['product_name'];
$image        = $product['image'];

$category_id  = $product['cat_id'];
//print_r($product);die;


}
/*
print_r($categories);
die;*/

?>
<html>
<head>
    <title>Add Product</title>
    <meta charset="utf-8"/>
    <?php include "../include/header.php";?>
    <link rel="stylesheet" href="products.css">
</head>

<body>
<?php include "../include/navbar.php"?>

<div class="container-fluid pt-5">

<div class="main-form">


         <?php 
                 if($update_mode == false){
                    echo '<h2 class="text-primary text-center mt-3">Add New Product</h2>';
                 }else{
                    echo '<h2 class="text-primary text-center mt-3">Update Product</h2>';
                 }
         ?>
       

        <form id="add_product_form">
             
        <div class="form-group">
            <label>Product Name</label>
            <input  type="text" value="<?=$product_name?>" class="form-control" name="product_name" id="name" placeholder="Enter product name" required >
        </div>

        <div class="form-group">
            <label>Category</label>

            <select id="category_id" name="category_id" class="form-control">
                <option value="-1">Select Category</option>
                <?php 
                  foreach($categories as $category){
                     $selected = "";  
                     
                     if($category['category_id'] == $category_id)
                         $selected = 'selected';
                      ?>
                <option value="<?=$category['category_id']?>" <?=$selected?>><?=$category['category_name']?></option>

                  <?php }?>
            </select>
        </div>

        <div class="form-group">
            <label><?php if($update_mode) echo 'Increase Quantity'; else echo "Quantity";?> </label>
            <input  type="number" value="<?=$quantity?>" class="form-control" name="quantity" id="quantity" placeholder="Enter quantity"  <?php if(!$update_mode) echo 'required' ?> >
        </div>
        
        <div class="form-group">
            <label>Image</label>
            <input  type="file"  class="form-control" name="image" id="image"   accept=".jpg , .png , .jpeg"   <a href="images/<?=$product['image']?>" target="_blank">
                   <img src="images/<?=$product['image']?>" height="80" width="100" class="img-fluid">
                     </a>
            
             <?php if(!$update_mode) echo 'required' ?>>
        </div>
        
        <div class="text-center">
            <input type="submit" class="btn btn-primary submit-btn" value="Save">
        </div>

        <input type="hidden"  id="product_id" name="product_id" value="<?=$product_id?>">

        </form>


</div>
<script src="products.js"> </script>
</body>
</html>

