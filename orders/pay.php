<?php
include('../db_connect.php');

$statement = $con->prepare("
SELECT o.*  , c.name as customer_name , c.mobile as customer_mobile , 
u.name as creator_name ,
(SELECT SUM(sub_price) FROM orders_products WHERE order_id = o.order_id  ) as products_price,
IFNULL((SELECT SUM(amount) FROM installments WHERE order_id = o.order_id  ),0) as sum_paid
from orders as o
INNER JOIN customers as c  ON c.customer_id = o.customer_id
INNER JOIN users as u ON u.id = o.creator_id
AND o.order_id = ?");  // prepare query
$statement->execute([$_GET['order_id']]);
$order = $statement->fetch(PDO::FETCH_ASSOC);

$creation_date = strtotime($order['creation_date']) * 1000;
$current_time =  microtime(true) * 1000;

$time_diff = $current_time - $creation_date;

$diff_in_month = $time_diff / 1000 / 60 / 60 / 24 / 30;
$paid_amount = $order['sum_paid'];

$isLate = false;

if(floatval($paid_amount) < floatval($order['pay_value']) * floor($diff_in_month)){
    $isLate = true;
}

$pay_value = $order['pay_value'];

if(floatval($order['price']) - floatval($paid_amount) <= floatval($order['pay_value'])){
    $pay_value = floatval($order['price']) - floatval($paid_amount);
}

$is_canceled = $order['status'] == 'CANCELED';
$is_finished = $order['status'] == 'FINISHED';

//echo '<pre>';
//print_r($order);
//echo '</pre>';
//
//var_dump($isLate);
//var_dump(floor($diff_in_month));
//var_dump($paid_amount);die;
?>
<html>
<head>
    <title>pay</title>
    <meta charset="utf-8"/>
    <?php include "../include/header.php";?>
    <link rel="stylesheet" href="pay.css">
</head>
<body>
<?php include "../include/navbar.php"?>
<div class="container-fluid">
    <?php
    include "../include/dashboard.php";
    ?>
    <?php
    if($isLate == true){
        echo "<h3 class='alert alert-danger'>This customer has a late installments</h3>";
    }
    ?>
    <?php
    if($is_canceled == true){
        echo "<h3 class='alert alert-danger'>You cannot make a payment for this order because it was canceled</h3>";
    }
    ?>
    <div class="row justify-content-between mb-3">

        <div>
            <span class="text-primary font-weight-bolder">Date   :</span>
            <?=$order['creation_date']?>
        </div>

        <div>
            <span class="text-primary font-weight-bolder">Paid Amount   :</span>
            <?=$paid_amount?> JOD
        </div>

        <div>
            <span class="text-primary font-weight-bolder">Customer   :</span>
            <?=$order['customer_name']?> / <?=$order['customer_mobile']?>
        </div>

        <div>
            <span class="text-primary font-weight-bolder">Total Price   :</span>
            <?=$order['price']?> JOD
        </div>
    </div>

<?php
if($is_canceled == false && $is_finished == false){?>
    <div class="main-form">
        <form id="pay_form" class="">
            <div class="form-group">
                <label>Pay value</label>
                <input type="number"  value="<?=$pay_value?>"  class="form-control" disabled name="amount" id="pay_value">
            </div>

            <input type="hidden"  value="<?=$pay_value?>"  class="form-control" name="amount" id="pay_value">

            <input type="hidden" name="order_id" value="<?=$_GET['order_id']?>">
            <div class="text-center">
                <input type="submit" class="btn btn-primary submit-btn" value="Pay">
            </div>
        </form>
    </div>

<?php
} ?>

</div>
<script src="pay.js"> </script>
</body>


