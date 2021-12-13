
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
?>
<html>
<head>
    <title>Dashboard</title>
    <meta charset="utf-8"/>
    <?php include "../include/header.php";?>
</head>

<body>

<?php include "../include/navbar.php"?>
<div class="container-fluid mt-5 pt-5">
    <?php
    include "../include/dashboard.php";
    ?>

<div class="row">
    <div class="col-md-6">
        <h3 class="text-info">Amount that cashiers received</h3>
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
        <h3 class="text-info">Total Profits : <?=$profit?> JOD</h3>
        <h3 class="text-info">Total Profits this Year : <?=$profit_this_year?> JOD</h3>
        <h3 class="text-info">Total Profits this month: <?=$profit_this_month?> JOD</h3>
    </div>
</div>


</div>
</body>
</html>

