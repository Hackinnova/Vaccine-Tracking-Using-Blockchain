<?php 
session_start(); 
$color="navbar-dark cyan darken-3";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="SHORTCUT ICON" href="images/fibble.png" type="image/x-icon" />
    <link rel="ICON" href="images/fibble.png" type="image/ico" />

    <title>Vaccine Tracker - Scan Vaccine Shipments</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mdb.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">

  </head>
  <?php
    if( $_SESSION['role']==0 || $_SESSION['role']==1  ){
      $recvdate = date("d F Y - g:i A");
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

    <div class="bgroles">
      <center>
        <div class="mycardstyle">
            <div class="greyarea" style="background-color: white;">
                <h5 style="font-weight: 600;"> Fill the Details of the Recieved Vaccine Shipment  </h5>
                <form id="form2" autocomplete="off">
                    <div class="formitem">
                        <label type="text" style="text-align:left;" class="formlabel"> Received Vaccine Shipment ID </label>
                        <input type="text" class="forminput" id="prodid" onkeypress="isInputNumber(event)" required>
                        <label class=qrcode-text-btn style="text-align:left;width:4%;display:none;">
                            <input type=file accept="image/*" id="selectedFile" style="display:none" capture=environment onchange="openQRCamera(this);" tabindex=-1>
                        </label>
                        <button class="qrbutton2" onclick="document.getElementById('selectedFile').click();" style="margin-bottom: 5px;margin-top: 5px;">
                        <i class='fa fa-qrcode'></i> Scan QR
		                </button>
                    </div>
                    <div class="formitem">
                        <label type="text" style="text-align:left;" class="formlabel"> Freight Hub Name </label>
                        <input type="text" class="forminput" id="prodname" value="<?php echo $_SESSION['username']; ?>" required>

                        <label style="margin-top: 20px; text-align:left;" type="text" class="formlabel"> Recieved Date </label>
                        <input type="text" class="forminput" id="recvdate" value="<?php echo $recvdate; ?>" readonly required>

                        <label style="margin-top: 20px; text-align:left;" type="text" class="formlabel"> Current Temperature </label>
                        <input type="text" class="forminput" id="temp" required>

                        <label style="margin-top: 20px; text-align:left;" type="text" class="formlabel"> Freight Hub Location </label>
                        <input type="text" class="forminput" id="prodlocation" readonly required>
                    </div>

                    <div class="formitem">
                      <div style="width: 400px; height: 300px;" id="map"></div>
                    </div>
                      
                    <button class="formbtn" id="mansub" type="submit">Update Vaccine Information</button>
                </form>
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

  <!-- Google Maps API -->
  <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZGW-pCcEjGsQRwyJmRsxUAlHJoPA-8Zc&callback=initMap&libraries=&v=weekly"
      async
    ></script>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>  

    <script src="app.js"></script>

    <!-- Web3 Injection -->
    <script>

      $(document).ready(function () {
  if (typeof ethereum !== 'undefined') {
    ethereum.enable()
    .catch(console.error)}});
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


    $('#form1').on('submit', function(event) {
        event.preventDefault(); // to prevent page reload when form is submitted
        prodname = $('#prodname').val();
        console.log(prodname);

        //var today = new Date();
        //var thisdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

        web3.eth.getAccounts().then(async function(accounts) {
          var receipt = await contract.methods.newItem(prodname, thisdate).send({ from: accounts[0], gas: 1000000 })
          .then(receipt => {
              var msg="<h5 style='color: #53D769'><b>Item Added Successfully</b></h5><p>Product ID: "+receipt.events.Added.returnValues[0]+"</p>";
              qr.value = receipt.events.Added.returnValues[0];
              $bottom="<p style='color: #FECB2E'> You may print the QR Code if required </p>"
              $("#alertText").html(msg);
              $("#qrious").show();
              $("#bottomText").html($bottom);
              $(".customalert").show("fast","linear");
          });
          //console.log(receipt);
        });
        $("#prodname").val('');
        
    });

    // Code for detecting location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }

    var lat, long; 

    function showPosition(position) {
        var autoLocation = position.coords.latitude +", " + position.coords.longitude;
        lat = position.coords.latitude;
        long = position.coords.longitude;
        $("#prodlocation").val(autoLocation);
    }

    $('#form2').on('submit', function(event) {
        event.preventDefault(); // to prevent page reload when form is submitted
        prodid = $('#prodid').val();
        prodlocation = $('#prodlocation').val();
        date = $('#recvdate').val();
        prodname = $('#prodname').val();
        prodname = prodname + "</span>";
        temperature = "<div class='desc'>Temperature : "+$('#temp').val()+"</div>";
        //console.log(prodid);
        //console.log(prodlocation);
        mapsLink = 'https://maps.google.com/?q=' + lat + ',' + long;

        //var today = new Date();
        //var thisdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        var info = "<span class='time-wrapper'><span class='time'>"+date+"</span></span></div><div class='desc'>Location : "+ prodlocation+"<br><a href="+mapsLink+" target='_blank'>Open in Google Maps</a></div>";

        console.log("productID : "+prodid);
        console.log("desciption : "+info);
        console.log("temperature : "+temperature);
        console.log("locationName : "+prodname);

        web3.eth.getAccounts().then(async function(accounts) {
          var receipt = await contract.methods.addState(prodid, info, temperature, prodname).send({ from: accounts[0], gas: 1000000 })
          .then(receipt => {
              var msg="Item has been updated ";
              $("#alertText").html(msg);
              $("#qrious").hide();
              $("#bottomText").hide();
              $(".customalert").show("fast","linear");
          });
        });
        $("#prodid").val('');
      });


    function isInputNumber(evt){
      var ch = String.fromCharCode(evt.which);
      if(!(/[0-9]/.test(ch))){
          evt.preventDefault();
      }
    }

    function initMap() {
      const myLatlng = { lat: 17.3932544, lng: 78.4433152 };
      const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 16,
        center: myLatlng,
      });
      // Create the initial InfoWindow.
      let infoWindow = new google.maps.InfoWindow({
        content: "Click the map to get Lat/Lng!",
        position: myLatlng,
      });
      infoWindow.open(map);
      // Configure the click listener.
      map.addListener("click", (mapsMouseEvent) => {
        // Close the current InfoWindow.
        infoWindow.close();
        // Create a new InfoWindow.
        infoWindow = new google.maps.InfoWindow({

          position: mapsMouseEvent.latLng,
        });
        gmaps_loc = mapsMouseEvent.latLng.toJSON();
        gmaps_lat = parseFloat(gmaps_loc['lat']).toFixed(7);
        console.log(gmaps_lat);
        gmaps_long = parseFloat(gmaps_loc['lng']).toFixed(7);
        loc_string = gmaps_lat + ", " +gmaps_long;
        displayString = "Marker Placed Here<br>Latitude : "+ gmaps_lat + "<br>Longitude : " +gmaps_long;
        infoWindow.setContent(
          displayString
        );
        infoWindow.open(map);
        console.log(mapsMouseEvent.latLng.toJSON());
  
        $('#prodlocation').val(loc_string);
      });
    }


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
        showAlert("A Decentralised End to End Logistics Application that stores the whereabouts of the Vaccine at every freight hub to the Blockchain. At consumer end, customers can easily scan product's QR CODE and get complete information about the provenance of that product hence empowering consumers to only purchase authentic and quality products.");
    });

    </script>
  </body>
</html>