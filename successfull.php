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
  <title>Transfer</title>
  <style>
    body{
      font-family: "Inter";
      font-size: 14px;
    }
    #formdiv {
        text-align: center;
        padding: 20px;
    }

    input {
        width: 400px;
        height: 20px;
        border: 1px solid #780b54de;
        border-radius: 10px;
        padding: 10px;
        margin: 10px 0;
        font-size: 14px;
    }


    button {
        background-color:#780b54de;
        color: white;
        border: none;
        cursor: pointer;
        height: 30px;
        border-radius: 8px;
    }
    button:hover{
        background-color: #d23b9fde;
    }
    #summaryOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        #summaryContent {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            height: 400px;
            width: 300px;
          }
          .close-button {
            margin-top: 10px;
            text-align: center;
            position: absolute;
            top: 75%;
        }

        .close-button > button{
            border-radius: 8px;
        }
    #successMessage{
      position: absolute;
      top: 30%;
      left: 40%;
      z-index: 2000;
      height: 200px;
      width: 200px;
      text-align: center;
      padding-top: 30px;
      background-color: white;
    }

    #successMessage > button{
      border-radius: 8px;
    }

    @media only screen and (max-width: 600px) {

      input {
        width: 100%;
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
  <li><a href="setting.php">Account Settings</a></li>
  <li><a href="activity.php">Login Activity</a></li>
  <hr>
  <li><a href="logout.php">Log Out</a></li>
  </ul>
</div>  
 </div>


 <div id="underdash">
    <div id="one" class="standby">
        <div style="text-align:center;">
            <img src="images/tick.png" width="70px">
            <h2 style="color:purple">Transaction successful!</h2>
            <p>You successfully transferred <?php echo $_SESSION['transferredAmount']; ?> USD to <?php echo $_SESSION['accountName']; ?></p><br>
            <b>Details of your transaction are shown below</b><br><br>
            <div style="border:1px solid grey; text-align:left;padding:10px;border-radius:5px">
                <div style="border-bottom:1px solid grey">Amount Debited: <?php echo $_SESSION['transferredAmount']; ?> USD</div><br><br>
                <div style="border-bottom:1px solid grey">Account holder: <?php echo $_SESSION['accountName']; ?></div><br><br>
                <div style="border-bottom:1px solid grey">Account Number: <?php echo $_SESSION['accountNumber']; ?></div><br><br>
                <div id="dateElement" style="border-bottom:1px solid grey"></div><br><br>
                <div style="border-bottom:1px solid grey">Description: <?php echo $_SESSION['description']; ?></div><br><br>
                <button id="completeButton" onclick="handleCompleteClick()" style="color:white;text-decoration:none">Complete</button> </div>
        </div>
    </div>
</div>

<script>
     function getCurrentDateInWords() {
  const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
  const monthsOfYear = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

  const currentDate = new Date();
  const dayOfWeek = daysOfWeek[currentDate.getDay()];
  const month = monthsOfYear[currentDate.getMonth()];
  const day = currentDate.getDate();
  const year = currentDate.getFullYear();

  return `${dayOfWeek}, ${month} ${day}, ${year}`;
}
    // Set the date within the "dateElement" div
    var dateElement = document.getElementById("dateElement");
    dateElement.innerHTML = "Date: " + getCurrentDateInWords();


    function handleCompleteClick() {
        // Clear session variables
        <?php
        unset($_SESSION['transferredAmount']);
        unset($_SESSION['accountNumber']);
        unset($_SESSION['accountName']);
        unset($_SESSION['description']);
        unset($_SESSION['bankName']);
        unset($_SESSION['currentDate']);
        ?>

        // Redirect to dashboard.php
        window.location.href = "dashboard.php";
    }
</script>

<div style="border-bottom: 1px solid #ec7ac6de;;margin-top: 10px;"></div>
<div style="color: #1f0516de;">
    <p>© 2023 CapitalGuard Financial Union - All rights reserved.</p>
    </div>
</div>
</div>
</div>



<script src="dashboard.js"></script>
      </body>
      </html>