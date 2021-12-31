<?php
include('../db_connect.php');

$query = "SELECT products.* , categories.category_name FROM `products`
INNER JOIN categories ON categories.category_id = products.cat_id"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

/*
echo "<pre>";
print_r($products);
echo "</pre>";
die;
*/
?>
<html>
<head>
    <title>Products</title>
    <meta charset="utf-8"/>
    <?php include "../include/header.php";?>
    <link rel="stylesheet" href="products.css">
</head>
<body>
<?php include "../include/navbar.php"?>
<div class="container-fluid pt-5">

     <?php
       include "../include/dashboard.php";
      ?>
    <h2 class="text-primary text-center mt-5">Products</h2>
    <a href="add_product.php" class="btn btn-primary mb-2">Add New Product</a>
    <table id="customers_table" class="table table-bordered table-striped">
        <thead>
        <tr>
          
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Category</th>
            <th scope="col">Quantity</th>
            <th scope="col">Image</th>
            <th scope="col">Edit</th>
        </tr>
        </thead>
        <tbody>
          <?php
          foreach($products as $product)
          { ?>
               <tr>
               <td><?=$product['product_id']?></td>
               <td><?=$product['product_name']?></td>
               <td><?=$product['price']?></td>
               <td><?=$product['category_name']?></td>
               <td><?=$product['quantity']?></td>
               <td> 
                   <a href="images/<?=$product['image']?>" target="_blank">
                   <img src="images/<?=$product['image']?>" height="80" width="100" class="img-fluid">
                     </a>
                  
               <td>
                   <a href="add_product.php?product_id=<?=$product['product_id']?>"  class="btn btn-primary">Edit</a>
               </td>
              </tr>
          <?php }?>
        </tbody>
    </table>
</div>
<script src="products.js"> </script>
</body>
</html>
