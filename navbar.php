<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="position: fixed; width: 100%;z-index: 20;">
<a class="navbar-brand" href="checkproduct.php">
<img src="images/logo.png" style="width: 30px;"> &nbsp
</a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
    aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon" style="color: #00B287;"></span>
  </button>

  <div class="collapse navbar-collapse" id="basicExampleNav">
    <ul class="navbar-nav mr-auto">

    <?php
    if ( isset( $_SESSION['role'] ) ){
    ?>
      <li class="nav-item">
        <a class="nav-link" href="checkproduct.php">Get Vaccine Information</a>
      </li>
    <?php
    if ( $_SESSION['role']==0 ){
    ?>
      <li class="nav-item">
        <a class="nav-link" href="addproduct.php">Add a New Vaccine Batch</a>
      </li>
    <?php
        }if ( $_SESSION['role']==1 || $_SESSION['role']==0 ){
    ?>
      <li class="nav-item">
        <a class="nav-link" href="scanshipment.php">Scan a Shipment</a>
      </li>
    <?php
    }
    }
    ?>
    <li class="nav-item">
    <a class="nav-link" id="aboutbtn"> About </a>
    </li>
    </ul>

    <form class="form-inline">
      <div class="md-form my-0">
        <a class="nav-link" href="logout.php" style="padding-left:5px;padding-right:5px;margin-left:0px;"> Logout </a>
      </div>
    </form>

  </div>
</nav>