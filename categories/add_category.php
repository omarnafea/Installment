<?php
$category_id = -1;
$name = "";

$update_mode = false; //add category (not Update)

include '../db_connect.php';
if(isset($_GET['category_id'])){
$update_mode = true;
$category_id = $_GET['category_id'];

$statement = $con->prepare("select * from categories where category_id = ? ");  // prepare query
$statement->execute([$category_id]);
$category = $statement->fetch(PDO::FETCH_ASSOC);

$name = $category["category_name"];

/*
echo '<pre>';
print_r($category);
echo '</pre>';die;
*/


}

?>
<html>
<head>
    <title>Add category</title>
    <meta charset="utf-8"/>
    <?php include "../include/header.php";?>
    <link rel="stylesheet" href="categories.css">
</head>

<body>
<?php include "../include/navbar.php"?>

<div class="container-fluid pt-5">
    <?php
    include "../include/dashboard.php";
    ?>


    <div class="main-form">


         <?php 
                 if($update_mode == false){
                    echo '<h2 class="text-primary text-center mt-3">Add New category</h2>';
                 }else{
                    echo '<h2 class="text-primary text-center mt-3">Update category</h2>';
                 }
         ?>
       

        <form id="add_category_form">
             
        <div class="form-group">
            <label>Name</label>
            <input  type="text" value="<?=$name?>" class="form-control" name="category_name" id="name" placeholder="Enter category name" required >
        </div>

        
        <div class="text-center">
            <input type="submit" class="btn btn-primary submit-btn" value="Save">
        </div>

        <input type="hidden"  id="category_id" name="category_id" value="<?=$category_id?>">

        </form>


</div>
<script src="categories.js"> </script>
</body>
</html>
