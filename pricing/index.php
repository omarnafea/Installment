<?php
include('../db_connect.php');

$query = "SELECT * FROM pricing_model ORDER by min_pay_value"; // db query
$statement = $con->prepare($query);  // prepare query
$statement->execute();
$pricing_model = $statement->fetchAll(PDO::FETCH_ASSOC);


//echo "<pre>";
//print_r($pricing_model);
//echo "</pre>";
//die;


?>
<html>
<head>
    <title>categories</title>
    <meta charset="utf-8"/>
    <?php include "../include/header.php";?>
    <link rel="stylesheet" href="pricing.css">
</head>
<body>
<?php include "../include/navbar.php"?>
<div class="container-fluid pt-5">
    <?php
    include "../include/dashboard.php";
    ?>
    <h2 class="text-primary text-center mt-3">Pricing model</h2>
    <a href="javascript:;" class="btn btn-primary mb-2  add-pricing">Add pricing</a>

    <button class="btn btn-success save-btn mb-2">Save <i class="fa fa-save"></i></button>

    <div class="pricing-container">
    <?php
    foreach ($pricing_model as $pricing){?>

        <div class="row pricing-row">
            <div class="col-md-3 <?=$pricing['min_pay_value'] == 0 ? 'd-none': ''?>">
                <div class="form-group">
                    <label>Min pay value</label>
                    <input type="number" class="form-control min-value" value="<?=$pricing['min_pay_value']?>">
                </div>
            </div>

            <div class="col-md-3  <?=$pricing['max_pay_value'] == 0 ? 'd-none': ''?>">
                <div class="form-group">
                    <label>Max pay value</label>
                    <input type="number" class="form-control max-value" value="<?=$pricing['max_pay_value']?>">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label><?=$pricing['min_pay_value'] == 0 ? 'Default percentage': 'Percentage'?></label>
                    <input type="number" class="form-control percentage" value="<?=$pricing['pricing_value']?>">
                </div>
            </div>

            <div class="col-md-3 <?=$pricing['min_pay_value'] == 0 ? 'd-none': ''?>">
                <button class="btn btn-danger delete-btn"><i class="fa fa-times-circle"></i></button>
            </div>

        </div>

    <?php }?>


</div>


</div>
<script src="pricing.js"> </script>
</body>
</html>