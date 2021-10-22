<?php
include('../db_connect.php');

$query = "SELECT * FROM customers"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_ASSOC);

/*
echo "<pre>";
print_r($customers);
echo "</pre>";
die;*/
/*
foreach($customers as $customer){
   echo $customer['name']   . " <br>";
   echo $customer['email']   . " <br>";
   echo $customer['mobile']   . " <br>";
   print_r($customer);
}
die;*/


//die;

?>
<html>
<head>
    <title>Customers</title>
    <meta charset="utf-8"/>
    <?php include "../include/header.php";?>
    <link rel="stylesheet" href="customers.css">
</head>
<body>
<?php include "../include/navbar.php"?>
<div class="container-fluid pt-5">

     <?php
       include "../include/dashboard.php";
      ?>
    <h2 class="text-primary text-center mt-3">Customers</h2>
    <a href="add_customer.php" class="btn btn-primary mb-2">Add New Customer</a>
    <table id="customers_table" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Mobile</th>
            <th scope="col">Email</th>
            <th scope="col">Edit</th>
        </tr>
        </thead>
        <tbody>
          <?php
          foreach($customers as $customer)
          { ?>
               <tr>
               <td><?=$customer['name']?></td>
               <td><?=$customer['mobile']?></td>
               <td><?=$customer['email']?></td>
               <td>
                   <a href="add_customer.php?customer_id=<?=$customer['customer_id']?>"  class="btn btn-primary">Edit</a>
               </td>
              </tr>
          <?php }?>
        </tbody>
    </table>
</div>
<script src="customers.js"> </script>
</body>
</html>
