<?php

include '../db_connect.php';

$statement = $con->prepare("SELECT * FROM products");  // prepare query
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<html>
<head>
    <title>Welcome</title>
    <meta charset="utf-8"/>
    <?php include "../include/header.php";?>
    <link rel="stylesheet" href="customer_site.css">
</head>
<body>
<?php include "../include/customers_navbar.php"?>
<h2 class="container-fluid pt-5 mt-5">

    <div class="row">

        <div class="col-md-2">
            <button class="btn btn-success">
                Calculate
            </button>

        </div>
        <div class="col-md-10">
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
    </div>
</div>

    <h2 class="text-center">Powered By Ghufran JUST</h2>
</div>


</body>
</html>