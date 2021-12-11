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
    <?php
    include "../include/dashboard.php";
    ?>
<div class="main-form">

    <h2 class="text-primary text-center mt-3">Add Order</h2>

    <form id="add_order_form">
    <div class="form-group col-md-3">
      <label>Select Customer</label>
      <select class="form-control" name="customers" id="customer_id">
         <option value="-1">Select Customer</option>
         <?php 
            foreach($customers as $customer){ ?>
                <option value="<?=$customer['customer_id']?>">
                <?=$customer['name']?> / <?=$customer['mobile']?>
                </option>
            <?php }?>

      </select>
    </div>


        <div class="row products-container">
            <?php
            foreach($products as $product){ ?>
                <div class="col-md-3">
                    <div class="card" style="/*width: 10rem;*/">
                        <img src="../products/images/<?=$product['image']?>" height="200" width="200" class="card-img-top img-fluid" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?=$product['product_name']?> / <span class="text-danger"><?=$product['price']?> JOD</span></h5>
                            <a href="javascript:;" class="btn btn-primary btn-select product"
                            data-product-id="<?=$product['product_id']?>"  data-price="<?=$product['price']?>"
                            >Select</a>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>

        <div class="form-group d-none">
              <label>Select Products</label>
              <select class="form-control" id="select_products"  name="products" multiple>
                 <?php
                    foreach($products as $product){ ?>
                        <option value="<?=$product['product_id']?>" class="product"
                        data-price="<?=$product['price']?>">
                        <?=$product['product_name']?> / <?=$product['price']?> JOD</option>
                    <?php }?>
              </select>
        </div>

        <div class="products"></div>


        <div class="row">

            <div class="form-group col-md-4">
                <label>Pay Value</label>
                <input type="number" class="form-control" name="pay_value" id="pay_value">
            </div>

            <div class="col-md-4 align-self-center">
                <button type="button" id="calc_pay_interval" class="btn btn-primary ">Calculate Pay Interval</button>

            </div>
        </div>


        <div class="row">

            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <h4>Pay Interval : </h4>
                    <h6 id="pay_interval"> </h6>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <h4>Total: </h4>
                    <h6 id="total_price"> </h6>
                </div>
            </div>

        </div>


        <div class="form-group d-none hidden-input">
               <label for="notes">Notes</label>
              <textarea class="form-control" name="noted" rows="3" cols="40" id="notes" id="notes"></textarea>
         </div>


        <button type="submit"  class="submit-btn btn btn-success d-none  hidden-input"   id="test_btn">Save</button>

    </form>
</div>
</div>

<script src="orders.js"></script>
</body>
</html>