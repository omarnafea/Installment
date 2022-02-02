<?php
include('../db_connect.php');

$customer_id = -1;
$customer_condition = '';
$params = [];

if(isset($_GET['customer_id'])){
    $customer_id = $_GET['customer_id'];
    $customer_condition = ' WHERE o.customer_id = ?';
    $params[] = $customer_id;
}



$query = "SELECT o.*  , c.name as customer_name , c.mobile as customer_mobile , u.name as creator_name ,
(SELECT SUM(sub_price) FROM orders_products WHERE order_id = o.order_id  ) as products_price,
IFNULL((SELECT SUM(amount) FROM installments WHERE order_id = o.order_id  ),0) as sum_paid
from orders as o
INNER JOIN customers as c  ON c.customer_id = o.customer_id
INNER JOIN users as u ON u.id = o.creator_id
$customer_condition
ORDER BY o.order_id DESC
"; // db query


$statement = $con->prepare($query);  // prepare query
$statement->execute($params);
$orders = $statement->fetchAll(PDO::FETCH_ASSOC);

//  print_r($orders);die;

$query = "SELECT * FROM customers"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_ASSOC);


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
    <h2 class="text-primary text-center mt-5">Orders</h2>

    <div class="row">
        <div class="col-md-4">
            <a href="add_order.php" class="btn btn-primary mb-2">Add New order</a>
        </div>
        <div class="form-group col-md-4">
            <select class="form-control" name="customers" id="filter_customer">
                <option value="-1">All Customers</option>
                <?php
                foreach($customers as $customer){
                    $selected = $customer['customer_id'] == $customer_id ? 'selected': '';
                    ?>
                    <option <?=$selected?> value="<?=$customer['customer_id']?>">
                        <?=$customer['name']?> / <?=$customer['mobile']?>
                    </option>
                <?php }?>
            </select>
        </div>
    </div>
    <table id="orders_table" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Customer/Mobile</th>
            <th scope="col">Creator</th>
            <th scope="col">Status</th>
            <th scope="col">Paid Amount</th>
            <th scope="col">Price After</th>
            <th scope="col">Price Before</th>
            <th scope="col">Profit</th>
            <th scope="col">Interval</th>
            <th scope="col">Pay Value</th>
            <th scope="col">Notes</th>
            <th scope="col">Date</th>
            <th scope="col">Action</th>
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

              $pay_interval = floatval($order['pay_interval']);
              $months = floor($pay_interval);

              $interval_text = $months . " M " ;
              
              if(floatval($paid_amount) < floatval($order['pay_value']) * floor($diff_in_month)){
                  $isLate = true;
                  //todo send SMS to this customer
              }
              ?>
               <tr class="<?=$isLate == true ? 'bg-danger': ''?>" id="<?=$order['order_id']?>">
               <td><?=$order['order_id']?></td>
               <td><?=$order['customer_name'] . ' / ' .$order['customer_mobile'] ?></td>
               <td><?=$order['creator_name']?></td>
               <td><?=$order['status']?></td> <!-- FINISHED-->
               <td><?=$paid_amount?> JOD</td>
               <td><?=$order['price']?> JOD</td>
               <td><?=$order['products_price']?> JOD</td>
               <td><?= ($order['price'] - $order['products_price'] )?> JOD</td>
               <td><?=$interval_text?></td>
               <td><?=$order['pay_value']?>JOD</td>
               <td><?=$order['notes']?></td>
               <td><?=$order['creation_date']?></td>
               <td>
                   <?php
                   if(isAdmin() == true && $order['status'] == "ACTIVE"){?>
                       <button class="btn btn-danger cancel"><i class="fas fa-trash-alt"></i></button>
                   <?php } ?>

                   <?php
                   if( $order['status'] == "ACTIVE"){?>
                      <a href="pay.php?order_id=<?=$order['order_id']?>"  class="btn btn-success">PAY <i class="fas fa-cash-register"></i></a>
                   <?php } ?>
               </td>
              </tr>
          <?php }?>
        </tbody>
    </table>
</div>
<script src="orders.js"> </script>
</body>
</html>