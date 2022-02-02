<?php 
include('../db_connect.php');


$statement = $con->prepare("SELECT * FROM customers");  // prepare query
$statement->execute();
$customers = $statement->fetchAll(PDO::FETCH_ASSOC);


$statement = $con->prepare("SELECT * FROM products");  // prepare query
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

/*
echo "<pre>";
print_r($products);
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
    <?php
    include "../include/dashboard.php";
    ?>
<div class="main-form">

    <h2 class="text-primary text-center mt-3">Add Order</h2>

    <form id="add_order_form">
    <div class="form-group col-md-3">
      <label>Select Customer</label>
      <select class="form-control" name="customer_id" id="customer_id">
         <option value="-1">Select Customer</option>
         <?php 
            foreach($customers as $customer){ ?>
                <option value="<?=$customer['customer_id']?>">
                <?=$customer['name']?> / <?=$customer['mobile']?>
                </option>
            <?php }?>
      </select>
    </div>


        <div class="row products-container">
            <?php
            foreach($products as $product){ ?>
                <div class="col-md-3">
                    <div class="card" style="/*width: 10rem;*/">
                        <img src="../products/images/<?=$product['image']?>" height="200" width="200" class="card-img-top img-fluid" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?=$product['product_name']?> / <span class="text-danger"><?=$product['price']?> JOD</span></h5>
                            <a href="javascript:;" class="btn btn-primary btn-select product"
                            data-product-id="<?=$product['product_id']?>"  data-price="<?=$product['price']?>"
                            >Select</a>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>

        <div class="products"></div>

        <div class="row">
            <div class="form-group col-md-4">
                <label>Pay Value</label>
                <input type="number" class="form-control" name="pay_value" id="pay_value" min="1" step="1"
                       onkeypress="return event.charCode >= 48 && event.charCode <= 57">
            </div>
            <div class="col-md-4 calculate-btn-container">
                <button type="button" id="calc_pay_interval" class="btn btn-primary ">Calculate Pay Interval</button>
            </div>

             <div class="col-md-4 mt-2">
                 <table id="schedule_table" class="table table-bordered table-striped">
                     <thead>
                     <tr>
                         <th scope="col">Date</th>
                         <th scope="col">Amount</th>
                     </thead>
                     <tbody>

                     </tbody>
                 </table>

            </div>


        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <h4>Pay Interval : </h4>
                    <h6 id="pay_interval"> </h6>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <h4>Total: </h4>
                    <h6 id="total_price"> </h6>
                </div>
            </div>
        </div>
        <div class="form-group d-none hidden-input">
               <label for="notes">Notes</label>
              <textarea class="form-control" name="notes" rows="3" cols="40"  id="notes"></textarea>
         </div>
        <div class="form-group d-none hidden-input">
               <label for="notes">Promissory Note Image</label>
              <input type="file"  class="form-control" name="promissory_note" required id="promissory_note"
                     title="Promissory note" accept=".jpg , .png , .jpeg"/>
         </div>

        <div class="sponsor-container">
            <h3 class="sponsors-header">Sponsors</h3>

            <div class="row sponsor-row  d-none hidden-input">
                <div class="col-md-6">
                    <label>Sponsor Name</label>
                    <input type="text" class="form-control sponsor-name" name="sponsor1_name">
                </div>
                <div class="col-md-6">
                    <label>Sponsor Mobile</label>
                    <input type="text" class="form-control sponsor-mobile" name="sponsor1_mobile">
                </div>
                <div class="col-md-6">
                    <label>Sponsor ID</label>
                    <input type="file" class="form-control sponsor-id" name="sponsor1_id" accept=".jpg , .png , .jpeg">
                </div>
                <div class="col-md-6">
                    <label>Sponsor Contract</label>
                    <input type="file" class="form-control sponsor-contract" name="sponsor1_contract" accept=".jpg , .png , .jpeg">
                </div>
            </div>

            <div class="row sponsor-row  d-none hidden-input">
                <div class="col-md-6">
                    <label>Sponsor Name</label>
                    <input type="text" class="form-control sponsor-name" name="sponsor2_name">
                </div>
                <div class="col-md-6">
                    <label>Sponsor Mobile</label>
                    <input type="text" class="form-control sponsor-mobile" name="sponsor2_mobile">
                </div>
                <div class="col-md-6">
                    <label>Sponsor ID</label>
                    <input type="file" class="form-control sponsor-id" name="sponsor2_id" accept=".jpg , .png , .jpeg">
                </div>
                <div class="col-md-6">
                    <label>Sponsor Contract</label>
                    <input type="file" class="form-control sponsor-contract" name="sponsor2_contract" accept=".jpg , .png , .jpeg">
                </div>
            </div>

        </div>

        <div class="text-center my-2">
            <button type="submit"  class="submit-btn btn btn-success d-none  hidden-input"   id="test_btn">Save</button>
        </div>

    </form>
</div>
</div>

<script src="orders.js"></script>
</body>
</html>