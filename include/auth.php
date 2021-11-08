<?php 
// 1= > admin
// 2=> cashies
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function isAdmin(){
    if($_SESSION['privilege_id'] == 1)
       return true;

    return false;
}

function isCashier(){
    if($_SESSION['privilege_id'] == 2)
       return true;

       return false;
}
