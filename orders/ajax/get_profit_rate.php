<?php
include "../../db_connect.php";


$statement = $con->prepare("SELECT pricing_value as profit_rate FROM pricing_model WHERE ? BETWEEN min_pay_value AND max_pay_value");  // prepare query
$statement->execute([$_POST['pay_value']]);
$pricing_model = $statement->fetch(PDO::FETCH_ASSOC);

if($pricing_model == null){
    $statement = $con->prepare("SELECT pricing_value as profit_rate FROM pricing_model WHERE  pricing_id = 0");  // prepare query
    $statement->execute();
    $pricing_model = $statement->fetch(PDO::FETCH_ASSOC);
}
die(json_encode($pricing_model));
