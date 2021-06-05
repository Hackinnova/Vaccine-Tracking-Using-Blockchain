<?php session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="SHORTCUT ICON" href="images/fibble.png" type="image/x-icon" />
    <link rel="ICON" href="images/fibble.png" type="image/ico" />

    <title>Vaccine Tracker</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mdb.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">

  </head>
  <body class="violetgradient">
  <?php
  if( !isset($_SESSION['role']) ){
  ?>
  <center>
      <div class="customalert">
          <div class="alertcontent">
              <div id="alertText"> &nbsp </div>
              <img id="qrious">
              <div id="bottomText" style="margin-top: 10px; margin-bottom: 15px;"> &nbsp </div>
              <button id="closebutton" class="formbtn"> OK </button>
          </div>
      </div>
  </center>
    <div style="width: 100%">
      <center>
      <div class="loginformcard" id="card1">
            <h4 style="font-weight:800;"> Vaccine Tracker DApp</h4>
            <p style="max-width: 80%; margin-top: 15px;">
            Vaccine Tracker is a Decentralized Logistics Application that stores the whereabouts of vaccines at every freight hub on the Blockchain. At consumer end, customers can simply scan the QR CODE of a vaccine and get complete information about the provenance of that vaccine hence empowering consumers to only purchase genuine and high quality vaccines.
            </p>
                <div class="cardbtnarea">
                    <button class="col-md-5 rolebtn" id="login">Login</button>
                    <button class="col-md-5 rolebtn" id="signup">Signup</button>
                </div>
      </div>


      <div class="loginformcard" id="maincard3">
            <h4 style="font-weight:800;"> Create A New Account</h4>
            <form style="margin-top: 30px; margin-bottom: 30px;" action="registration.php" method="POST" onsubmit="return checkSecondForm(this);">

            <label type="text" class="formlabel" style="margin-top: 10px; text-align:left; font-weight: 400;"> Select A Role </label>
            <select class="formselect" name="role" id="role" onchange="customUsername()">
              <option value="0">Manufacturer</option>
              <option value="1">Airport</option>
              <option value="1">Vaccine Warehouse</option>
              <option value="1">Hospital</option>
              <option value="2">Consumer</option>
            </select>  

            <label type="text" class="formlabel" style="margin-top: 15px; text-align:left; font-weight: 400;"> Your Email </label>
            <input type="text" class="forminput" name="email" id="email" onkeypress="isNotChar(event)" required>

            <label type="text" class="formlabel" id="username-label" style="margin-top: 15px; text-align:left; font-weight: 400;"> Username </label>
            <input type="text" class="forminput" name="username" id="username" onkeypress="blockSpaces(event)" required>

            <label type="text" class="formlabel" style="margin-top: 15px; text-align:left; font-weight: 400;"> Password </label>
            <input type="password" class="forminput" name="pw" id="pw" onkeypress="isNotChar(event)" required>

            <label type="text" class="formlabel" style="margin-top: 15px; text-align:left; font-weight: 400;"> Confirm Password </label>
            <input type="password" class="forminput" name="cpw" id="cpw" onkeypress="isNotChar(event)" required>

            <button class="formbtn" name="loginsubmit" value="submitted!" type="submit">Register</button>

            <br>
            <a href="#" id="gotologin" style="font-weight: 400;"> Have an Existing Account? Login </a>
            </form>
      </div>


      <div class="loginformcard" id="maincard2">
      <h4 style="font-weight:800;"> Login to An Existing Account</h4>
            <form style="margin-top: 30px; margin-bottom: 30px;" action="login.php" method="POST" onsubmit="return checkFirstForm(this);">

            <label type="text" class="formlabel" style="text-align:left; font-weight: 400;"> Email </label>
            <input type="text" class="forminput" name="email" id="email" onkeypress="isNotChar(event)" required>

            <label type="text" class="formlabel" style="margin-top: 15px; text-align:left; font-weight: 400;"> Password </label>
            <input type="password" class="forminput" name="pw" id="pw" onkeypress="isNotChar(event)" required>

            <button class="formbtn" name="loginsubmit" type="submit">Login</button>

            <br>
            <a href="#" id="gotosignup" style="font-weight: 400;"> Haven't Registered Yet? Sign Up</a>
            </form>
                
      </div>
      </center>
    </div>
    <?php
    }else{
      include 'redirection.php';
      redirect('checkproduct.php');
    }
    ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/mdb.min.js"></script>
    <script>
  
    function isInputNumber(evt){
      var ch = String.fromCharCode(evt.which);
      if(!(/[0-9]/.test(ch))){
          evt.preventDefault();
      }
    }
    function isNotChar(evt){
      var ch = String.fromCharCode(evt.which);
      if(ch=="'"){
        evt.preventDefault();
      }
    }

    function blockSpaces(evt){
      var ch = String.fromCharCode(evt.which);
      if(ch=="'" || ch==" "){
        evt.preventDefault();
      }
    }

    function customUsername(){
      var u = document.getElementById('username-label');
      var r = document.getElementById('role');
      console.log(r.value);
      if (r.value == 0){
        u.innerHTML = "Enter Manufacturer Name";
      }
      else if(r.value == 1){
        u.innerHTML = "Enter Organization Name";
      }
      else{
        u.innerHTML = "Enter Consumer Name";
      }
    }

    //Function to Detect Special Character
    function blockSpecialChar(e){
      var k;
      document.all ? k = e.keyCode : k = e.which;
      return ((k >= 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 46|| k == 42|| k == 33 || k == 32 || (k >= 48 && k <= 57));
    }

    $("#login").on("click", function(){
      $("#card1").hide("fast","linear");
      $("#maincard3").hide("fast","linear");
      $("#maincard2").show("fast","linear");
    });

    $("#gotologin").on("click", function(){
      $("#card1").hide("fast","linear");
      $("#maincard3").hide("fast","linear");
      $("#maincard2").show("fast","linear");
    });

    $("#openlogin").on("click", function(){
      $("#card1").hide("fast","linear");
      $("#maincard3").hide("fast","linear");
      $("#maincard2").show("fast","linear");
    });

    $("#signup").on("click", function(){
      $("#card1").hide("fast","linear");
      $("#maincard2").hide("fast","linear");
      $("#maincard3").show("fast","linear");
    });

    $("#gotosignup").on("click", function(){
      $("#card1").hide("fast","linear");
      $("#maincard2").hide("fast","linear");
      $("#maincard3").show("fast","linear");
    });

    $("#opensignup").on("click", function(){
      $("#card1").hide("fast","linear");
      $("#maincard2").hide("fast","linear");
      $("#maincard3").show("fast","linear");
    });

    $("#closebutton").on("click", function(){
        $(".customalert").hide("fast","linear");
    });

    function checkSecondForm(theform){
      var email = theform.email.value;
      var pw = theform.pw.value;
      var cpw = theform.cpw.value;

      if (!validateEmail(email)) {
        showAlert("Invalid Email address");
        return false;
      }

      if (pw!=cpw) {
        showAlert("Please check your password");
        return false;
      } 
      return true;
    }

    function checkFirstForm(theform){
      var email = theform.email.value;

      if (!validateEmail(email)) {
        showAlert("Invalid Email address");
        return false;
      }
      return true;
    }

    function showAlert(message){
      $("#alertText").html(message);
      $("#qrious").hide();
      $("#bottomText").hide();
      $(".customalert").show("fast","linear");
    }

    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
    
    </script>
  </body>
</html>