<?php
include('../db_connect.php');

$query = "SELECT o.*  , c.name as customer_name , c.mobile as customer_mobile , u.name as creator_name ,
(SELECT SUM(sub_price) FROM orders_products WHERE order_id = o.order_id  ) as products_price,
IFNULL((SELECT SUM(amount) FROM installments WHERE order_id = o.order_id  ),0) as sum_paid
from orders as o
INNER JOIN customers as c  ON c.customer_id = o.customer_id
INNER JOIN users as u ON u.id = o.creator_id
ORDER BY o.creation_date ASC
"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute();
$orders = $statement->fetchAll(PDO::FETCH_ASSOC);



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
    <h2 class="text-primary text-center mt-3">Orders</h2>
    <a href="add_order.php" class="btn btn-primary mb-2">Add New order</a>
    <table id="categories_table" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Customer/Mobile</th>
            <th scope="col">Creator</th>
            <th scope="col">Status</th>
            <th scope="col">Paid Amount</th>
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
          {

              $creation_date = strtotime($order['creation_date']) * 1000;
              $current_time =  microtime(true) * 1000;
              $time_diff = $current_time - $creation_date;
              $diff_in_month = $time_diff / 1000 / 60 / 60 / 24 / 30;
              $paid_amount = $order['sum_paid'];
              $isLate = false;

              if(floatval($paid_amount) < floatval($order['pay_value']) * floor($diff_in_month)){
                  $isLate = true;
                  //todo send SMS to this customer
              }
              ?>
               <tr class="<?=$isLate ? 'bg-danger': ''?>" id="<?=$order['order_id']?>">
               <td><?=$order['order_id']?></td>
               <td><?=$order['creator_name'] . ' / ' .$order['customer_mobile'] ?></td>
               <td><?=$order['creator_name']?></td>
               <td><?=$order['status']?></td>
               <td><?=$paid_amount?> JOD</td>
               <td><?=$order['price']?> JOD</td>
               <td><?=$order['products_price']?> JOD</td>
               <td><?= ($order['price'] - $order['products_price'] )?> JOD</td>
               <td><?=$order['pay_interval']?> Months</td>
               <td><?=$order['pay_value']?>JOD</td>
               <td><?=$order['notes']?></td>
               <td><?=$order['creation_date']?></td>
               <td>
                   <button class="btn btn-danger cancel"><i class="fas fa-trash-alt"></i></button>
                   <a href="pay.php?order_id=<?=$order['order_id']?>"  class="btn btn-success"> <i class="fas fa-cash-register"></i></a>
               </td>
              </tr>
          <?php }?>
        </tbody>
    </table>
</div>
<script src="orders.js"> </script>
</body>
</html>