<?php
session_start();     // start the session
session_unset();    //unset the data
session_destroy(); // destroy the session
header('location:login'); // the user will go the the login page ifter he meke logut
exit();
?>