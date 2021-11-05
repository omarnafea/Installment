<?php
include('../db_connect.php');

$query = "SELECT o.*  , c.name as customer_name , c.mobile as customer_mobile , u.name as creator_name ,
(SELECT SUM(sub_price) FROM orders_products WHERE order_id = o.order_id  ) as products_price
from orders as o
INNER JOIN customers as c  ON c.customer_id = o.customer_id
INNER JOIN users as u ON u.id = o.creator_id"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute();
$orders = $statement->fetchAll(PDO::FETCH_ASSOC);

/*
echo "<pre>";
print_r($orders);
echo "</pre>";
die;*/


?>
<html>
<head>
    <title>Orders</title>
    <meta charset="utf-8"/>
    <?php include "../include/header.php";?>
    <link rel="stylesheet" href="categories.css">
</head>
<body>
<?php include "../include/navbar.php"?>
<div class="container-fluid pt-5">
    <h2 class="text-primary text-center mt-3">Orders</h2>
    <a href="add_category.php" class="btn btn-primary mb-2">Add New order</a>
    <table id="categories_table" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Customer/Mobile</th>
            <th scope="col">Creator</th>
            <th scope="col">Status</th>
            <th scope="col">Is Late</th>
            <th scope="col">Price</th>
            <th scope="col">Product Price</th>
            <th scope="col">Profit</th>
            <th scope="col">Interval</th>
            <th scope="col">Pay Value</th>
            <th scope="col">Notes</th>
            <th scope="col">Date</th>
        </tr>
        </thead>
        <tbody>
          <?php
          foreach($orders as $order)
          { ?>
               <tr>
               <td><?=$order['order_id']?></td>
               <td><?=$order['creator_name'] . ' / ' .$order['customer_mobile'] ?></td>
               <td><?=$order['creator_name']?></td>
               <td><?=$order['status']?></td>
               <td><?='No'?></td>
               <td><?=$order['price']?></td>  
               <td><?=$order['products_price']?></td>
               <td><?= ($order['price'] - $order['products_price'] )?></td>
               <td><?=$order['pay_interval']?></td>
               <td><?=$order['pay_value']?></td>
               <td><?=$order['notes']?></td>
               <td><?=$order['creation_date']?></td>
              
               <td>
                   <a href="add_category.php?category_id"  class="btn btn-primary">Edit</a>
               </td>
              </tr>
          <?php }?>
        </tbody>
    </table>
</div>
<script src="categories.js"> </script>
</body>
</html>