<?php 

include('../db_connect.php');


$statement = $con->prepare("SELECT * FROM customers");  // prepare query
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($customers);
echo "</pre>";
die;
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
    <h2 class="text-primary text-center mt-3">Add Order</h2>

</div>
</body>
</html>