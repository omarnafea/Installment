<?php

if(!isset($_SESSION))
   session_start();


include '../db_connect.php';

$customer_id = $_SESSION['customer_id'];

$statement = $con->prepare("SELECT o.*  , c.name as customer_name , c.mobile as customer_mobile , u.name as creator_name ,
(SELECT SUM(sub_price) FROM orders_products WHERE order_id = o.order_id  ) as products_price,
IFNULL((SELECT SUM(amount) FROM installments WHERE order_id = o.order_id  ),0) as sum_paid
from orders as o
INNER JOIN customers as c  ON c.customer_id = o.customer_id
INNER JOIN users as u ON u.id = o.creator_id
WHERE o.customer_id = ?
ORDER BY o.order_id DESC");  // prepare query
$statement->execute([$customer_id]);
$orders = $statement->fetchAll(PDO::FETCH_ASSOC);


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
<div class="container-fluid pt-5 mt-5">

    <table id="orders_table" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Customer/Mobile</th>
            <th scope="col">Creator</th>
            <th scope="col">Status</th>
            <th scope="col">Paid Amount</th>
            <th scope="col">Price</th>
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
            $days = ($pay_interval - floor($pay_interval))*30;
            $months = floor($pay_interval);

            $interval_text = $months . " M " ;
            if($days != 0)
                $interval_text .= $days . " D";

            if(floatval($paid_amount) < floatval($order['pay_value']) * floor($diff_in_month)){
                $isLate = true;
                //todo send SMS to this customer
            }
            ?>
            <tr class="<?=$isLate ? 'bg-danger': ''?>" id="<?=$order['order_id']?>">
                <td><?=$order['order_id']?></td>
                <td><?=$order['customer_name'] . ' / ' .$order['customer_mobile'] ?></td>
                <td><?=$order['creator_name']?></td>
                <td><?=$order['status']?></td>
                <td><?=$paid_amount?> JOD</td>
                <td><?=$order['price']?> JOD</td>
                <td><?=$interval_text?></td>
                <td><?=$order['pay_value']?>JOD</td>
                <td><?=$order['notes']?></td>
                <td><?=$order['creation_date']?></td>
                <td>
                    <a href="pay.php?order_id=<?=$order['order_id']?>"  class="btn btn-success"> <i class="fas fa-cash-register"></i></a>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>
<script src="customer_site.js"></script>


</body>
</html>