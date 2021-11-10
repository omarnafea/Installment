<?php 
include('../db_connect.php');


$statement = $con->prepare("SELECT * FROM customers");  // prepare query
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_ASSOC);


$statement = $con->prepare("SELECT * FROM products");  // prepare query
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

/*
echo "<pre>";
print_r($products);
echo "</pre>";
die;*/
?>

<html>
<head>
    <title>Orders</title>
    <meta charset="utf-8"/>
    <?php include "../include/header.php";?>
    <link rel="stylesheet" href="orders.css">
</head>
<body>
<?php include "../include/navbar.php"?>
<div class="container-fluid pt-5">
<div class="main-form">

    <h2 class="text-primary text-center mt-3">Add Order</h2>

    <form id="add_order_form">

    <div class="form-group">
      <label>Select Customer</label>
      <select class="form-control" name="customers">
         <option value="-1">Select Customer</option>
         <?php 
            foreach($customers as $customer){ ?>
                <option value="<?=$customer['customer_id']?>">
                <?=$customer['name']?> / <?=$customer['mobile']?></option>
            <?php }?>

      </select>

    </div>

        <div class="form-group">
              <label>Select Products</label>
              <select class="form-control" id="select_products"  name="products" multiple>
                 <option value="-1">Select Products</option>
                 <?php
                    foreach($products as $product){ ?>
                        <option value="<?=$product['product_id']?>" class="product"
                        data-price="<?=$product['price']?>"
                        >
                        <?=$product['product_name']?> / <?=$product['price']?> JOD</option>
                    <?php }?>
              </select>
        </div>

        <div class="products">


        </div>

          <div class="form-group">
              <label>Pay Value</label>
               <input type="number" class="form-control" name="pay_value" id="pay_value">
         </div>

        <div class="form-group">
               <label for="notes">Notes</label>
              <textarea class="form-control" name="noted" rows="3" cols="40" id="notes"></textarea>
         </div>

        <button type="button" id="test_btn">test</button>


        <button type="submit"  class="submit-btn d-none"  id="test_btn">Save</button>

    </form>
</div>
</div>

<script src="orders.js"></script>
</body>
</html>