<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['loggedin'])) {
    header('Location: sign-in.html');
    exit;
}

// Database configuration
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'capitalg';
$DATABASE_PASS = 'Edwards12345@';
$DATABASE_NAME = 'capitalg_capitalguard';

// Connect to the database
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
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
  header('Location: sign-in.html');
  exit;
}


// Initialize error message
$errorMsg = '';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input from the form
    $tacCode = $_POST['tacCode'];

    // Get the user's ID from the session
    $userId = $_SESSION['id'];

    // Query the database to check the code fields in the accounts table for the user
    $query = "SELECT tacCode FROM accounts WHERE id = $userId";

    $result = mysqli_query($con, $query);

    if ($result) {
        // Fetch the database row
        $row = mysqli_fetch_assoc($result);
        
        if ($row) {
            // User account exists
           
            $savedTAC = $row['tacCode'];

            // Check if any of the code fields are empty
            if (empty($tacCode)) {
                $errorMsg .= ' TAC code is required for this transaction to be completed successfully.';
            } else {
                // Check if the input codes match with the saved codes in the database
                if ($cotCode !== $savedCOT || $imfCode !== $savedIMF || $tacCode !== $savedTAC) {
                    $errorMsg .= 'The federal COT, IMF, and TAC code are required for this transaction to be completed successfully. You can visit any of our branches or contact our online customer care representative for details of the codes.';
                }
            }
        } else {
            // No data found in the database (no codes in the table)
            $errorMsg = 'Codes are invalid. Please contact customer support for assistance.';
        }
  

        // If there are no errors, continue with storage retrieval and transfer
        if (empty($errorMsg)) {
            $storageQuery = "SELECT amount, bankName, currentDate, description, accountNumber, accountName FROM storage WHERE account_id = ? ORDER BY currentDate DESC LIMIT 1";

            // Prepare the SQL statement
            $storageStmt = $con->prepare($storageQuery);

            if ($storageStmt) {
                // Assign $_SESSION['id'] to a variable
                $account_id = $_SESSION['id'];

                // Bind the account_id parameter
                $storageStmt->bind_param('i', $account_id);

                // Execute the statement
                $storageStmt->execute();

                // Bind variables to the result columns
                $storageStmt->bind_result($transferredAmount, $bankName, $currentDate, $description, $accountNumber, $accountName);

                // Fetch the result
                if ($storageStmt->fetch()) {
                    // Store the necessary data in session variables
                    $_SESSION['transferredAmount'] = $transferredAmount;
                      $_SESSION['bankName'] = $bankName;
                    $_SESSION['accountNumber'] = $accountNumber;
                    $_SESSION['accountName'] = $accountName;
                    $_SESSION['description'] = $description;

                    // Close the statement
                    $storageStmt->close();

                    // Continue with the transfer script
                    // Retrieve transferred data from session variables
                    $transferredAmount = $_SESSION['transferredAmount'];
                    $accountNumber = $_SESSION['accountNumber'];
                    $accountName = $_SESSION['accountName'];
                    $description = $_SESSION['description'];

                    // Retrieve current user's balance from the database
                    $stmt = $con->prepare("SELECT balance FROM accounts WHERE id = ?");
                    $stmt->bind_param('i', $_SESSION['id']);
                    $stmt->execute();
                    $stmt->bind_result($balance);
                    $stmt->fetch();
                    $stmt->close();

                    // Calculate new balance
                    $newBalance = $balance - $transferredAmount;

                    // Update user's balance in the database
                    $updateStmt = $con->prepare("UPDATE accounts SET balance = ? WHERE id = ?");
                    $updateStmt->bind_param('di', $newBalance, $_SESSION['id']);
                    $updateStmt->execute();
                    $updateStmt->close();

                    // Insert transfer transaction record into the 'transactions' table
                    $transactionType = "Transfer";
                    $userId = $_SESSION['id'];

                    $insertStmt = $con->prepare("INSERT INTO transactions (account_id, transaction_type, amount, transaction_description) VALUES (?, ?, ?, ?)");

                    if (!$insertStmt) {
                        // Handle the SQL error
                        exit('Prepare failed: ' . $con->error);
                    }

                    // Bind parameters with the correct data types
                    $insertStmt->bind_param('isds', $userId, $transactionType, $transferredAmount, $description);

                    if (!$insertStmt->execute()) {
                        // Handle the SQL error
                        exit('Execute failed: ' . $insertStmt->error);
                    }

                    $insertStmt->close();

                    header("Location: successfull.php");
                    exit();
                } else {
                    // Handle if no data found
                    $errorMsg = 'No data found in the storage table for the user.';
                }
            } else {
                // Handle the prepare error
                $errorMsg = 'Prepare Error: ' . $con->error;
            }
        }
    } else {
        // User account not found
        $errorMsg = 'User account not found.';
    }
}
?>



<!-- Add your HTML form here, including the cotCode, imfCode, and tacCode input fields and the submit button -->



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
        padding-left: 20px;
        padding-right: 20px;
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
            border-radius: 2px;
          }
          .close-button {
            margin-top: 10px;
            text-align: center;
            position: absolute;
            top: 86%;
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
      background-color: purple;
      color:white;
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
    .centered-div {
            text-align: center;
            margin-bottom: 10px ;
            border:1px solid black;
            
            padding: 10px;
            
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
<div id="one" class="standby" >
    <div >
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async=""> </script>
    </div>
<div style="height: 120px;border: 1px solid #ec7ac6de ;">
    <marquee  direction="" style="color: rgb(101, 167, 15);background-color: black;">
        <h2 class="nk-block-title fw-normal text-success">PAY FOR GOODS AND SERVICES, TRANSFER MONEY TO FRIENDS AND FAMILY.</h2>
    </marquee>
    <button id="btn2" style="width: 170px;float: right;margin-right: 20px;"><i class="fa fa-exchange"></i> <a href="dashboard4.php" style="color: white;text-decoration: none;">Cross-border Transfer</a></button> 
</div>
<div style="text-align: center;color: #780b54de;">
<h1>Please enter the TAC code to continue</h1>
</div>
<div id="formdiv">
<form method="POST" action=""  id="transferFormz">
        <label for="tacCode">TAC Code:</label><br>
        <input type="text" id="tacCode" name="tacCode" required style="width:200px"><br>
        
        <button style="width:200px" onclick="simulateLoading()" id="continueButtonz"> continue</button><br><br>
        
         <?php if (!empty($errorMsg)) { ?>
            <div class="centered-div">
                <?php echo $errorMsg; ?>
            </div>
        <?php } ?>
    </form>

</div>
<div id="summaryOverlay">
  <div id="summaryContent"></div>
  <div class="close-button">
      <button onclick="clearForm()">Continue</button>
  </div>
</div>

<script>
  function validateForm() {
    var cotCode = document.getElementById("cotCode");
    var imfCode= document.getElementById("imfCode");
    var tacCode = document.getElementsByName("tacCode")[0];
 

    var fieldsToCheck = [
        { field: cotCode, name: "cotCode" },
        { field: imfCode, name: "imfCode" },
        { field: tacCode, name: "tacCode" },
    ];

    var allFieldsFilled = true;

    for (var i = 0; i < fieldsToCheck.length; i++) {
        var fieldObj = fieldsToCheck[i];
        if (fieldObj.field.value === "") {
            fieldObj.field.style.borderColor = "red";
            allFieldsFilled = false;
        } else {
            fieldObj.field.style.borderColor = ""; // Reset the border color
        }
    }

    return allFieldsFilled;
}


     function simulateLoading() {
           if (validateForm()) {
               var continueButton = document.getElementById("continueButtonz");
               continueButton.textContent = "processing...";
               setTimeout(clearForm, 5000);
           }
       }
      
  function clearForm() {
    var transferForm = document.getElementById("transferFormz");
    transferForm.submit();
    }

  
</script>

 </div>
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







