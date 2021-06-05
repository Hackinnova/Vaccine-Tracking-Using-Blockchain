<?php 
session_start(); 
$color="navbar-light orange darken-4";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="SHORTCUT ICON" href="images/fibble.png" type="image/x-icon" />
    <link rel="ICON" href="images/fibble.png" type="image/ico" />

    <title>Vaccine Tracker - Add New Vaccines</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mdb.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">

  </head>
  <?php
    if( $_SESSION['role']==0 ){
      $manufactureDate = date("d F Y");
      $mDate = date("d F Y - g:i A");
      $date = date_create($manufactureDate);
      date_add($date, date_interval_create_from_date_string('60 days'));
      $expiryDate = date_format($date, 'd F Y');

  ?>
  <body class="violetgradient">
    <?php include 'navbar.php'; ?>
    <center>
        <div class="customalert">
            <div class="alertcontent">
                <div id="alertText"> &nbsp </div>
                <img id="qrious">
                <div id="bottomText" style="margin-top: 10px; margin-bottom: 15px;"> &nbsp </div>
                <button id="closebutton" class="formbtn"> Done </button>
            </div>
        </div>
    </center>

    <div class="bgrolesadd">
      <center>
        <div class="mycardstyle">
            <!--<div class="greyarea">-->
                <h5 style="font-weight: 600;"> Enter Vaccine Details </h5>
                <form id="form1" autocomplete="off">
                    <div class="formitem">
                        <label style="text-align: left; font-weight: 400px;" type="text" class="formlabel"> Vaccine Name </label>
                        <input type="text" class="forminput" id="prodname" required>

                        <label style="text-align: left; margin-top: 20px; font-weight: 400px;" type="text" class="formlabel"> Manufacturer Name </label>
                        <input type="text" class="forminput" id="man_name" value='<?php echo $_SESSION['username']; ?>' required>

                        <label style="text-align: left; margin-top: 20px; font-weight: 400px;" type="text" class="formlabel"> Manufacturing Date and Time </label>
                        <input type="text" class="forminput" id="man_date" value='<?php echo $mDate; ?>' readonly required>

                        <label style="text-align: left; margin-top: 20px; font-weight: 400px;" type="text" class="formlabel"> Expiry Date (60 Days from Manufacturing Date) </label>
                        <input type="text" class="forminput" id="exp_date" value='<?php echo $expiryDate; ?>' readonly required>

                        <label style="text-align: left; margin-top: 20px; font-weight: 400px;" type="text" class="formlabel"> Batch Number </label>
                        <input type="text" class="forminput" id="batch" required>



                        <input type="hidden" class="forminput" id="user" value=<?php echo $_SESSION['username']; ?> required>
                    </div>
                    <button class="formbtn" id="mansub" type="submit">Add New Batch</button>
                </form>
            <!--</div>-->
        </div>


      </center>
      <?php
        }else{
            include 'redirection.php';
            redirect('index.php');
        }
    ?>
    <div class='box'>
      <div class='wave -one'></div>
      <div class='wave -two'></div>
      <div class='wave -three'></div>
    </div>
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Material Design Bootstrap-->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/mdb.min.js"></script>

    <!-- Web3.js -->
    <script src="web3.min.js"></script>

    <!-- QR Code Library-->
    <script src="./dist/qrious.js"></script>

    <!-- QR Code Reader -->
	<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>

    <script src="app.js"></script>

    <!-- Web3 Injection -->
    <script>
      $(document).ready(function () {
  if (typeof ethereum !== 'undefined') {
    ethereum.enable()
    .catch(console.error)}});

      //var Web3 = require('web3');
//var web3 = new Web3(Web3.givenProvider || 'http://127.0.0.1:7545');

      // Initialize Web3
      if (typeof web3 !== 'undefined') {
        web3 = new Web3(web3.currentProvider);
        //web3 = new Web3(new Web3.providers.HttpProvider('HTTP://127.0.0.1:7545'));
      } else {
        web3 = new Web3(new Web3.providers.HttpProvider('HTTP://127.0.0.1:7545'));
      }

      // Set the Contract
    var contract = new web3.eth.Contract(contractAbi, contractAddress);

    loadAccount : async () =>{
       window.ethereum.enable().then((account) =>{
           const defaultAccount = account[0];
           web3.eth.defaultAccount = defaultAccount;
           console.log(defaultAccount);

       })
    }



    $("#manufacturer").on("click", function(){
        $("#districard").hide("fast","linear");
        $("#manufacturercard").show("fast","linear");
    });

    $("#distributor").on("click", function(){
        $("#manufacturercard").hide("fast","linear");
        $("#districard").show("fast","linear");
    });

    $("#closebutton").on("click", function(){
        $(".customalert").hide("fast","linear");
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
    function showPosition(position) {
        var autoLocation = position.coords.latitude +", " + position.coords.longitude;
        console.log(autoLocation);
        $("#prodlocation").val(autoLocation);
    }

    var prodid;


    $('#form1').on('submit', function(event) {
        event.preventDefault(); // to prevent page reload when form is submitted
        prodname = "<div class='desc'>Vaccine Name : "+$('#prodname').val()+"</div>";
        username = $('#user').val(); 
        //prodname=prodname+"<br>Registered By: "+username;
        //console.log(prodname);
        manufactureDate = "<div class='desc'>Manufacture Date : "+$('#man_date').val()+"</div>";
        expiryDate = "<div class='desc'>Expiry Date : "+$('#exp_date').val()+"</div>";
        batchNo = "<div class='desc'>Batch No : "+$('#batch').val()+"</div>";
        //temperature = $('#temp').val();
        //location = $('#prodlocation').val();
        //var today = new Date();
        //var thisdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

        console.log("productName : "+prodname);
        console.log("manufactureDate : "+manufactureDate);
        console.log("expiryDate : "+expiryDate);
        console.log("batchNo : "+batchNo);

        web3.eth.getAccounts().then(async function(accounts) {
          var receipt = await contract.methods.newItem(prodname, manufactureDate, expiryDate, batchNo).send({ from: accounts[0], gas: 1000000 })
          .then(receipt => {
              var msg="<h5 style='color: #53D769'><b>Item Added Successfully</b></h5><p>Product ID: "+receipt.events.Added.returnValues[0]+"</p>";
              prodid = receipt.events.Added.returnValues[0];
              qr.value = receipt.events.Added.returnValues[0];
              $bottom="<p style='color: #FECB2E'> You may print the QR Code if required </p>"
              $("#alertText").html(msg);
              $("#qrious").show();
              $("#bottomText").html($bottom);
              $(".customalert").show("fast","linear");
          });

          /*var receipt = await contract.methods.addState(prodid, location, temperature).send({ from: accounts[0], gas: 1000000 })
          .then(receipt => {
              console.log("Added Temperature and Location");
          });*/
          //console.log(receipt);
        });

        $("#prodname").val('');
        
    });

    $('#form2').on('submit', function(event) {
        event.preventDefault(); // to prevent page reload when form is submitted
        prodid = $('#prodid').val();
        prodlocation = $('#prodlocation').val();
        console.log(prodid);
        console.log(prodlocation);
        var today = new Date();
        var thisdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        var info = "<br><br><b>Date: "+thisdate+"</b><br>Location: "+prodlocation;
        web3.eth.getAccounts().then(async function(accounts) {
          var receipt = await contract.methods.addState(prodid, info).send({ from: accounts[0], gas: 1000000 })
          .then(receipt => {
              var msg="Item has been updated ";
              $("#alertText").html(msg);
              $("#qrious").hide();
              $("#bottomText").hide();
              $(".customalert").show("fast","linear");
          });
        });
        $("#prodid").val('');
        $("#prodlocation").val('');
      });


    function isInputNumber(evt){
      var ch = String.fromCharCode(evt.which);
      if(!(/[0-9]/.test(ch))){
          evt.preventDefault();
      }
    }

    (function() {
        var qr = window.qr = new QRious({
            element: document.getElementById('qrious'),
            size: 200,
            value: '0'
        });

        
    })();

    function openQRCamera(node) {
		var reader = new FileReader();
		reader.onload = function() {
			node.value = "";
			qrcode.callback = function(res) {
			if(res instanceof Error) {
				alert("No QR code found. Please make sure the QR code is within the camera's frame and try again.");
			} else {
				node.parentNode.previousElementSibling.value = res;
				document.getElementById('searchButton').click();
			}
			};
			qrcode.decode(reader.result);
		};
		reader.readAsDataURL(node.files[0]);
	}

  function showAlert(message){
      $("#alertText").html(message);
      $("#qrious").hide();
      $("#bottomText").hide();
      $(".customalert").show("fast","linear");
    }

  $("#aboutbtn").on("click", function(){
      showAlert("A Decentralised End to End Logistics Application that stores the whereabouts of product at every freight hub to the Blockchain. At consumer end, customers can easily scan product's QR CODE and get complete information about the provenance of that product hence empowering	consumers to only purchase authentic and quality products.");
  });

    </script>
  </body>
</html>
