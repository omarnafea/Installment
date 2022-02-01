
<?php
session_start();

include "auth.php";

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="../dashboard/index.php">
        <img src="../products/images/logo.jpeg" width="45" height="45" alt="logo" class="img-fluid"/>
    </a>

    <a class="nav-link dashboard-list close" href="#"><i class="fas fa-list fa-xs"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="container">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item active">
                    <a class="nav-link dashboard-link" href="../dashboard">DASHBOARD <span class="sr-only">(current)</span></a>
                </li>


                <?php
                if(isAdmin() == true){?>
                    <li class="nav-item">
                        <a class="nav-link" href="../users">USERS</a>
                    </li>

                <?php } ?>

                <li class="nav-item">
                    <a class="nav-link" href="../products">PRODUCTS</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../orders">ORDERS</a>
                </li>


            </ul>

            <ul class="navbar-nav ml-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?=$_SESSION['username'] ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>