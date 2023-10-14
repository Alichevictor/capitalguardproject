<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: sign-in.html');
	exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'capitalg';
$DATABASE_PASS = 'Edwards12345@';
$DATABASE_NAME = 'capitalg_capitalguard';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if (isset($_SESSION['id'])) {
  $userId = $_SESSION['id'];

  $stmt = $con->prepare('SELECT imagePath, firstName, lastName, otherName, email, phoneNumber, dateOfBirth, residentialAddress, statesecurityNumber, nextofkinName, username, password, balance FROM accounts WHERE id = ?');

  if ($stmt) {
      $stmt->bind_param('i', $userId);
      $stmt->execute();
      $stmt->bind_result($imagePath, $firstName, $lastName, $otherName, $email, $phoneNumber, $dateOfBirth, $residentialAddress, $statesecurityNumber, $nextofkinName, $username, $password, $balance);
      $stmt->fetch();
      $stmt->close();
  } else {
      // Handle the case when the prepared statement couldn't be created
      echo 'Could not prepare statement!';
  }
} else {
  // Handle the case when the user is not logged in
  header('Location: login.php');
  exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
  <!--TITLE-->
  <title>Deposit</title>
  <style>
    body{
      font-family: "Inter";
      font-size: 14px;
    }
    input {
        height: 20px;
        border: 1px solid #780b54de;
        border-radius: 10px;
        padding: 10px;
        margin: 10px 0;
        font-size: 14px;
    }
    #pic{
        height: 200px;
        width:100%;
        border: 1px solid #780b54de; 
    }

    @media only screen and (max-width: 600px) {

input {
  height: auto;
  border: 1px solid #780b54de;
  border-radius: 10px;
  padding: auto;
  margin: 5px 0;
  font-size: 12px;
}
}
  
  </style>
    <!--ICON-->
    <link rel="shortcut icon" href="images/newlogo.jpg">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="Responsive.css">
    <link href="https://fonts.googleapis.com/icon?family=Inter" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      </head>
      <body>

<div id="dashbod1" >
<div style="height: 70px;border-bottom: 3px solid #780b54de;;">
<img src="images/newlogo.jpg" alt="logo" height="50px" style="padding: 10px;border-radius: 50px;">
</div>
<div style="padding-left: 40px;">
<P>AVAILABLE BALANCE</P>
<div id="balance" style="height: 60px;width: 250px; background-color: aqua;padding-top:1px;padding-left:4px">
<h1>$<?=$balance?></h1>
</div>
<div id="union">
  <div>
    <p>Income</p>
    <p>Debits</p>
  <br>
  <button id="btn1"><i class="fa fa-money"></i> <a href="dashboard3.php" style="color: white;text-decoration: none;"> TRANSFER</a></button>
 </div>
  <div style="text-align: right;">
    <p style="color: rgb(13, 88, 63);">66.12%</p>
    <p style="color: red;">24.12%</p>
  <br>
  <button id="btn2"> <i class="fa fa-credit-card"></i> <a href="deposit.php" style="color: white;text-decoration: none;"> Deposit</a></button>
  
  </div>
</div>
<p>MENU</p>
<ul>
  <li ><a href="dashboard.php"><i class="fa fa-tasks" ></i></i> Dashboard</a></li>
  <li><a href="dashboard2.php"><i class="fa fa-address-card-o"></i> Account summary</a></li>
  <li><a href="dashboard3.php"><i class="fa fa-share-square-o"></i> Transfer</a></li>
  <li><a href="dashboard4.php"><i class="fa fa-exchange"></i> Cross-border Transfer</a></li>
</ul>


</div>
</div>

<div id="dashbod2">
  <div style="height: 70px;background-color: #f5eef3de;;border-bottom: 1px solid #dbcdd6de;" >
  <div id="toggleButton" style="height: 50px;width: 150px;text-align: right;
    background-color: #780b54de;;float: right;margin: 10px;text-align: center;display: block;color:white;border-radius:8px"><p >Welcome <?=$_SESSION['name']?> <br> click me!</p></div>
    <div id="upperbase" style="display: none;">
    <div style="height: 100px;background-color: rgb(194, 202, 202);margin-top:-6%;color:purple;padding:5px;">
         <h2>Balance:$<?=$balance?></h2>
         <h4><?=$firstName?> <?=$lastName?> </h4><br>
        
 </div>
 <ul id="upperli">
  <li><a href="dashboard.php">Dashboard</a></li>
  <li><a href="profile.php">View Profile</a></li>
  
  <li><a href="activity.php">Login Activity</a></li>
  <hr>
  <li><a href="logout.php">Log Out</a></li>
  </ul>
</div>  
 </div>



<!--  -->
<div id="underdash" >
    <div id="one" class="standby" style="height: 1100px;"> 
       <div style="height: 80px;background-color: #780b54de;color: white;padding: 20px;margin-bottom: 10px;"> <h1 >Deposit a check</h1>
     </div>
  
    
    <div style="border: 0.5px solid #780b54de;border-radius: 7px;padding: 10px;color: rgb(207, 79, 19);">
        <h3>Check Deposit tips</h3>
       <p>the account to deposit the check and the check amount.</p>
       
       <p>Ensure the check has been properly endorsed and that it is flat, on a dark, well-lit surface. Then snap pictures of both the front and back of the check, keeping it in the correct parameters. Don’t forget to endorse and write ‘for mobile deposit only’ on the back.
 </p>       
       <p> Submit your check for deposit! We’ll send you an email confirmation that we’ve received your deposit and an email confirmation once it is accepted. Be sure to hold on to your check until you receive this confirmation, once received, destroy the check!
   </p></div>
    <div style=";margin-top: 20px;">
      <form action="process-deposit.php" method="post" enctype="multipart/form-data" id="depositForm">
        <label for="checkAmount">Enter Check Amount</label><br>
        <input type="text" name="amount"  id="mce-AMOUNT" placeholder="Check Amount"> 
        <br>
        <label for="frontImage">Front of Your Check</label>
        <div id="frontPreview" class="preview" style="height: 140px; border: 1px solid black; width: 100px;"></div>
        <input type="file" id="frontImage" name="frontImage" onchange="previewImage('frontImage', 'frontPreview')">
        <br>
        <label for="backImage">Back of Your Check</label>
        <div id="backPreview" class="preview" style="height: 140px; border: 1px solid black; width: 100px;"></div>
        <input type="file" id="backImage" name="backImage" onchange="previewImage('backImage', 'backPreview')"><br>
        <button type="button" id="submitButton" onclick="simulateLoading()" style="height: 40px; width: 100px; background-color: #780b54de; color: white;border-radius:8px;border:0px solid #780b54de">Deposit </button>
    </form>
    </div>

    <script>
      const frontInput = document.getElementById('frontImage');
      const backInput = document.getElementById('backImage');
      const frontPreview = document.getElementById('frontPreview');
      const backPreview = document.getElementById('backPreview');
      const submitButton = document.getElementById('submitButton');
      
      submitButton.addEventListener('click', function(event) {
          if (!frontInput.files[0]) {
              frontInput.classList.add('input-error');
              frontPreview.style.border = "1.5px solid red";
              event.preventDefault(); // Prevent form submission
          } else {
              frontInput.classList.remove('input-error');
              frontPreview.style.border = "1.5px solid black";
          }

          if (!backInput.files[0]) {
              backInput.classList.add('input-error');
              backPreview.style.border = "1.5px solid red";
              event.preventDefault(); // Prevent form submission
          } else {
              backInput.classList.remove('input-error');
              backPreview.style.border = "1.5px solid black";
          }
      });
      function simulateLoading() {
               var continueButton = document.getElementById("submitButton");
               continueButton.textContent = "processing...";
               setTimeout(subm, 4000); 
           }
       

function subm(){
  var transferForm = document.getElementById("depositForm");
            transferForm.submit(); 
}
      function previewImage(inputId, previewId) {
          const input = document.getElementById(inputId);
          const preview = document.getElementById(previewId);
          
          if (input.files && input.files[0]) {
              const reader = new FileReader();
              reader.onload = function (e) {
                  const img = new Image();
                  img.src = e.target.result;
                  img.onload = function() {
                      const canvas = document.createElement('canvas');
                      const context = canvas.getContext('2d');

                      // Calculate new dimensions to fit the display div
                      const maxWidth = preview.offsetWidth;
                      const maxHeight = preview.offsetHeight;
                      const aspectRatio = img.width / img.height;

                      let newWidth = maxWidth;
                      let newHeight = newWidth / aspectRatio;

                      if (newHeight > maxHeight) {
                          newHeight = maxHeight;
                          newWidth = newHeight * aspectRatio;
                      }

                      canvas.width = newWidth;
                      canvas.height = newHeight;

                      context.drawImage(img, 0, 0, newWidth, newHeight);

                      preview.style.backgroundImage = `url('${canvas.toDataURL()}')`;
                  };
              };
              reader.readAsDataURL(input.files[0]);
              preview.style.border = "1px solid black";
          } else {
              preview.style.backgroundImage = "none";
              preview.style.border = "1px solid black";
          }
      }
  </script>
    </div>
    <div style="border-bottom: 1px solid #ec7ac6de;;margin-top: 30px;"></div>
    <div style="color: #1f0316de;">
    <p>© 2023 CapitalGuard Financial Union - All rights reserved.</p>
    </div>
    
    </div>
    </div>
    </div>
    
    








 
<script src="dashboard.js"></script>
 </body>
 </html>