<?php

include '../db_connect.php';

$statement = $con->prepare("select * from privileges");  // prepare query
$statement->execute();
$privileges = $statement->fetchAll();
$update_mode = false;

$name = "";
$user_name = "";
$email = "";
$prev_id = -1;
$user_id  = -1;



if(isset($_GET['user_id'])){

    $user_id  = $_GET['user_id'];

    $update_mode = true;
    $statement = $con->prepare("select * from users WHERE id = ?");  // prepare query
    $statement->execute([$_GET['user_id']]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    $name = $user['name'];
    $user_name = $user['user_name'];
    $email = $user['email'];
    $prev_id = $user['privilege_id'];

}

?>
<html>
<head>
    <title>Add user</title>
    <meta charset="utf-8"/>
    <?php include "../include/header.php";?>
    <link rel="stylesheet" href="users.css">
</head>

<body>
<?php include "../include/navbar.php"?>

<div class="container-fluid pt-5">

    <div class="main-form">
        <h2 class="text-primary text-center mt-3">Add New User</h2>

        <form method="post" id="user_add_form" enctype="multipart/form-data">
            <div class="form-group">
                <label> Name</label>
                <input type="Text" value="<?=$name?>" class="form-control" id="name" name="name" placeholder="Enter name" required>
            </div>

            <div class="form-group">
                <label> User Name</label>
                <input type="Text" value="<?=$user_name?>" class="form-control" id="user_name" name="user_name" placeholder="Enter user username" required>
            </div>

            <div class="form-group">
                <label> Email</label>
                <input type="Text"   value="<?=$email?>" class="form-control" id="email" name="email" placeholder="Enter user email" required>
            </div>

            <div class="form-group">
                <label> Password</label>
                <input type="password" class="form-control" id="password"  autocomplete="new-password" name="password" placeholder="Enter user password" >
            </div>


            <div class="form-group">
                <label> Privilege</label>

                <select class="form-control" id="privilege_id" name="privilege_id" title="clinic">
                    <option value="-1">Select Privilege</option>
                    <?php
                    foreach ($privileges as $privilege){
                        $selected = $privilege['id'] == $prev_id ? 'selected': "";
                        ?>
                        <option <?=$selected?> value="<?=$privilege['id']?>"><?=$privilege['privilege']?></option>
                    <?php } ?>
                </select>
            </div>

            <input type="hidden" name="user_id" value="<?=$user_id?>" id="edit_user_id" />
            <div class="text-center">
                <input type="submit" name="action"  class="btn btn-success submit-btn"  value="Save" />
            </div>
        </form>

    </div>

</div>

<script src="users.js"> </script>

</body>
</html>