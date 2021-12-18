
<?php
session_start();

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="../dashboard/index.php">
        <img src="../products/images/sasha.jpg" width="50" height="35" alt="logo"/>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="container">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item active">
                    <a class="nav-link dashboard-link" href="../dashboard">Dashboard <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../users">Order Now</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../users">Products</a>
                </li>
            </ul>

            <?php
              if(isset( $_SESSION['customer_id'])){?>
                  <ul class="navbar-nav ml-auto">
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <?= isset($_SESSION['customer_name'])  ? $_SESSION['customer_name'] : '' ?>
                          </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="admin.php?page=change_password">change password</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="../logout.php">Logout</a>
                          </div>
                      </li>
                  </ul>

              <?php } ?>


        </div>
    </div>
</nav>