<?php 
include('../db_connect.php');


$statement = $con->prepare("SELECT * FROM customers");  // prepare query
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_ASSOC);

/*
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<pre>";
print_r($customers);
echo "</pre>";
die;*/
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
<div class="main-form">

    <h2 class="text-primary text-center mt-3">Add Order</h2>

    <form>

    <div class="form-group">
      <label>Select Customer</label>
      <select class="form-control">
         <option value="-1">Select Customer</option>
         <?php 
            foreach($customers as $customer){ ?>
                <option value="<?=$customer['customer_id']?>">
                <?=$customer['name']?> / <?=$customer['mobile']?></option>
            <?php }?>

      </select>

    </div>


    </form>
</div>
</div>
</body>
</html>