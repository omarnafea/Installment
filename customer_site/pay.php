<?php
if(!isset($_SESSION))
    session_start();


include '../db_connect.php';

$customer_id = $_SESSION['customer_id'];

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



$statement = $con->prepare("SELECT i.* , u.name as cashier_name FROM installments as i
LEFT JOIN users as u on u.id  = i.cachier_id 
where i.order_id = ?");  // prepare query
$statement->execute([$_GET['order_id']]);
$installments = $statement->fetchall(PDO::FETCH_ASSOC);
//print_r($installments);die;


$creation_date = strtotime($order['creation_date']) * 1000;
$current_time =  microtime(true) * 1000;


$time_diff = $current_time - $creation_date;


$diff_in_month = $time_diff / 1000 / 60 / 60 / 24 / 30;
$paid_amount = $order['sum_paid'];



$pay_amount = $order['pay_value'];

if(($order['price'] - $paid_amount) < $pay_amount){
    $pay_amount = $order['price'] - $paid_amount;
}


$isLate = false;

if(floatval($paid_amount) < floatval($order['pay_value']) * floor($diff_in_month)){
    $isLate = true;
}

$is_canceled = $order['status'] == 'CANCELED';


$needToPay = false;

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

    <?php
    if($isLate == true){
        echo "<h3 class='alert alert-danger'>You Have a late installments</h3>";
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


    <h2 class="text-info">Installments</h2>

    <table id="orders_table" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Amount</th>
            <th scope="col">Date</th>
            <th scope="col">Paid By</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $counter = 1;
        foreach ($installments as $installment){ ?>
            <tr>
                <td><?=$counter?></td>
                <td><?=$installment['amount']?></td>
                <td><?=$installment['creation_date']?></td>
                <td><?=$installment['cashier_name'] != null ? $installment['cashier_name']  : "Online"?></td>
            </tr>
        <?php

        $counter ++;
        }?>


        </tbody>
    </table>
</div>

<div class="container-fluid pt-5 mt-5">

    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card ">
                <div class="card-header">
                    <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                        <!-- Credit card form tabs -->
                        <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                            <li class="nav-item"> <a data-toggle="pill" href="#credit-card" class="nav-link active pay-now-btn">
                                    <i class="fas fa-credit-card mr-2"></i> Pay Now <?=$pay_amount?>JD</a>
                            </li>
                        </ul>
                    </div> <!-- End -->
                    <!-- Credit card form content -->
                    <div class="tab-content pay-online-form d-none">
                        <!-- credit card info-->
                        <div id="credit-card" class="tab-pane fade show active pt-3">
                            <form role="form" id="pay_form">
                                <input type="hidden" value="<?=$_GET['order_id']?>" name="order_id">
                                <input type="hidden" value="<?=$pay_amount?>" name="amount">
                                <div class="form-group"> <label for="username">
                                        <h6>Card Owner</h6>
                                    </label> <input type="text" id="username" name="username" placeholder="Card Owner Name" required class="form-control "> </div>
                                <div class="form-group"> <label for="cardNumber">
                                        <h6>Card number</h6>
                                    </label>
                                    <div class="input-group"> <input type="number" name="cardNumber" placeholder="Valid card number" class="form-control " required>
                                        <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fab fa-cc-visa mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group"> <label><span class="hidden-xs">
                                                    <h6>Expiration Date</h6>
                                                </span></label>
                                            <div class="input-group"> <input type="number" placeholder="MM" name="" class="form-control" required> <input type="number" placeholder="YY" name="" class="form-control" required> </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group mb-4"> <label data-toggle="tooltip" title="Three digit CV code on the back of your card">
                                                <h6>CVV <i class="fa fa-question-circle d-inline"></i></h6>
                                            </label> <input type="text" required class="form-control"> </div>
                                    </div>
                                </div>
                                <div class="card-footer"> <button type="submit" class="subscribe btn btn-primary btn-block shadow-sm"> Confirm Payment </button>
                            </form>
                        </div>
                    </div> <!-- End -->

                </div>
            </div>
        </div>
    </div>


</div>

<script src="customer_site.js"></script>

</body>
</html>