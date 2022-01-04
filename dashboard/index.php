
<?php
include "../db_connect.php";


$query = "SELECT SUM(i.amount) as amount , u.name as cashier_name 
from installments as i
INNER JOIN users as u ON u.id = i.cachier_id
GROUP BY i.cachier_id
"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute();
$installments = $statement->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT  SUM(o.price - ((SELECT SUM(sub_price) FROM orders_products WHERE order_id = o.order_id ) )) as profit
from orders as o"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute();
$profit = $statement->fetchColumn();

$query = "SELECT  SUM(o.price - ((SELECT SUM(sub_price) FROM orders_products WHERE order_id = o.order_id ) )) as profit
from orders as o
WHERE YEAR(o.creation_date) = YEAR(now())
"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute();
$profit_this_year = $statement->fetchColumn();

$query = "SELECT  SUM(o.price - ((SELECT SUM(sub_price) FROM orders_products WHERE order_id = o.order_id ) )) as profit
from orders as o
WHERE YEAR(o.creation_date) = YEAR(now())
AND MONTH(o.creation_date) = MONTH(now())
"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute();
$profit_this_month = $statement->fetchColumn();


$query = "SELECT o.*  , c.name as customer_name , c.mobile as customer_mobile , u.name as creator_name ,
(SELECT SUM(sub_price) FROM orders_products WHERE order_id = o.order_id  ) as products_price,
IFNULL((SELECT SUM(amount) FROM installments WHERE order_id = o.order_id  ),0) as sum_paid
from orders as o
INNER JOIN customers as c  ON c.customer_id = o.customer_id
INNER JOIN users as u ON u.id = o.creator_id
ORDER BY o.order_id DESC
LIMIT 5 "; // db query

$statement = $con->prepare($query);  // prepare query
$statement->execute();
$orders = $statement->fetchAll(PDO::FETCH_ASSOC);


?>
<html>
<head>
    <title>Dashboard</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="dashboard.css">
    <?php include "../include/header.php";?>
</head>

<body>

<?php include "../include/navbar.php"?>
<div class="container-fluid mt-5 pt-5">
    <?php
    include "../include/dashboard.php";
    ?>


 <?php

 if(isAdmin()){?>
     <div class="row">
         <div class="col-md-6">
             <h4 class="text-info">Amount that cashiers received</h4>
             <table id="categories_table" class="table table-bordered table-striped">
                 <thead>
                 <tr>
                     <th scope="col">#</th>
                     <th scope="col">Cashier name</th>
                     <th scope="col">Received Amount (JOD)</th>
                 </tr>
                 </thead>
                 <tbody>
                 <?php
                 $counter = 1;
                 foreach($installments as $installment)
                 {
                     ?>
                     <tr>
                         <td><?=$counter?></td>
                         <td><?=$installment['cashier_name']?></td>
                         <td><?=$installment['amount']?></td>
                     </tr>
                     <?php $counter++; }?>
                 </tbody>
             </table>
         </div>
         <div class="col-md-6">
             <h4> <span class="text-info">Total Profits :</span>
                 <span class="text-danger"><?=$profit?><small>JOD</small></span></h4>
             <h4> <span class="text-info">Total Profits this Year :</span>  <span class="text-danger"><?=$profit_this_year?><small>JOD</small></span></h4>
             <h4> <span class="text-info">Total Profits this month: </span> <span class="text-danger"><?=$profit_this_month?><small>JOD</small></span></h4>
         </div>
     </div>

 <?php }?>

    <h3 class="text-info text-center mt-5">Last 5 Orders</h3>
    <table id="orders_table" class="table table-bordered table-striped">
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
                <td><?=$order['products_price']?> JOD</td>
                <td><?= ($order['price'] - $order['products_price'] )?> JOD</td>
                <td><?=$interval_text?></td>
                <td><?=$order['pay_value']?>JOD</td>
                <td><?=$order['notes']?></td>
                <td><?=$order['creation_date']?></td>
                <td>
                    <?php
                    if(isAdmin() == true){?>
                        <button class="btn btn-danger cancel mb-1"><i class="fas fa-trash-alt"></i></button>
                    <?php } ?>

                    <a href="pay.php?order_id=<?=$order['order_id']?>"  class="btn btn-success">PAY <i class="fas fa-cash-register"></i></a>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>
</body>
</html>

