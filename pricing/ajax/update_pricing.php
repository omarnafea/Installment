<?php
include "../../db_connect.php";


//print_r($_POST['pricing']);die;
//check overlap

// 1 20
// 21 40
// 25 30
foreach ($_POST['pricing'] as $main_index => $main_pricing) {
//    var_dump($main_index);
//    var_dump($main_pricing);


    if($main_pricing['min_pay_value'] <0 || $main_pricing['max_pay_value'] < 0){
        die(json_encode(['success' => false, 'message' => 'Min pay value and max pay value must be not in minus']));
    }

    if($main_pricing['min_pay_value'] == $main_pricing['max_pay_value'] &&
        $main_pricing['min_pay_value'] != 0 && $main_pricing['max_pay_value'] != 0){
        die(json_encode(['success' => false, 'message' => 'Min pay value and max pay value must be not equal']));
    }

    //check overlap 
    foreach ($_POST['pricing'] as $check_index => $check_pricing) {

        if ($check_index == $main_index) continue;

        if ($check_pricing['min_pay_value'] >= $main_pricing['min_pay_value']
            && $check_pricing['min_pay_value'] <= $main_pricing['max_pay_value']
        ) {
            die(json_encode(['success' => false, 'message' => 'There is an overlap in pricing']));
        }

        // main 25 100    ////  20 >= 25 && 20 <= 100
        //check 20 50

        // main 20 50
        // check 25 100  /// 25 >= 20 && 25 <= 100
    }

}
$statement = $con->prepare("DELETE FROM pricing_model");  // prepare query
$statement->execute();

foreach ($_POST['pricing'] as $pricing){

$insert = $con->prepare("INSERT INTO pricing_model  (min_pay_value , max_pay_value , pricing_value)

                                        VALUES (:min_pay_value , :max_pay_value , :pricing_value)");
    $insert->execute([
":min_pay_value"    => $pricing['min_pay_value'],
":max_pay_value"      => $pricing['max_pay_value'],
":pricing_value"    => $pricing['pricing_value']
]);

}

die(json_encode(['success'=>true , 'message'=>'Pricing data updated successfully']));



