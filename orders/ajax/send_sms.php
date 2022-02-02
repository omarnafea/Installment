<?php
include('../db_connect.php');


$query = "SELECT o.*  , c.name as customer_name , c.mobile as customer_mobile , u.name as creator_name ,
(SELECT SUM(sub_price) FROM orders_products WHERE order_id = o.order_id  ) as products_price,
IFNULL((SELECT SUM(amount) FROM installments WHERE order_id = o.order_id  ),0) as sum_paid
from orders as o
INNER JOIN customers as c  ON c.customer_id = o.customer_id
INNER JOIN users as u ON u.id = o.creator_id
ORDER BY o.order_id DESC
"; // db query


$statement = $con->prepare($query);  // prepare query
$statement->execute($params);
$orders = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach($orders as $order)
{

    $creation_date = strtotime($order['creation_date']) * 1000;//get order time in senonds
    $current_time =  microtime(true) * 1000; //get current time in seconds
    $time_diff = $current_time - $creation_date; //the different between order creation time and current time
    $diff_in_month = $time_diff / 1000 / 60 / 60 / 24 / 30; //convert the different to months
    $paid_amount = $order['sum_paid'];//get sum paid amount
        
    if(floatval($paid_amount) < floatval($order['pay_value']) * floor($diff_in_month)){
       
        sendSMSToCustomer($orders['customer_mobile'] , 'You have a late installments, please pay it.');
    }
}




function sendSMSToCustomer($mobile , $message){
        //todo send SMS to this customer
}

?>