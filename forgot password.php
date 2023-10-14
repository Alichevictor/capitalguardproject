<?php

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

// Check if the form was submitted
if (isset($_POST['email'], $_POST['oldPassword'], $_POST['newPassword'])) {
    // Retrieve user data from the database based on the provided email
    $email = $_POST['email'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];

    $stmt = $con->prepare('SELECT id, password FROM accounts WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();

        // Verify if at least 3 characters match between oldPassword and the stored password
        $matchingChars = similar_text($oldPassword, $password);

        if ($matchingChars >= 3) {
            

            // Update the password in the database
            $updateStmt = $con->prepare('UPDATE accounts SET password = ? WHERE id = ?');
            $updateStmt->bind_param('si', $newPassword, $id);

            if ($updateStmt->execute()) {
                // Password updated successfully
               $errorMsg =  'Password updated successfully.';
            } else {
                // Error occurred while updating the password
               $errorMsg = 'Error: ' . $updateStmt->error;
            }
        } else {
            // Passwords do not match
            $errorMsg =  'Old password does not match the stored password.pls try again';
        }
    } else {
        // User with the provided email not found
        $errorMsg =  'User not found.';
    }

    $stmt->close();
}

// Rest of your login code can follow here...

?>

<!DOCTYPE html>
<html>
    <head>
<!--TITLE-->
<title>forgotten password</title>

<style>
  body{
    font-family: "Inter";
    font-size: 14px;
  }
   .centered-div {
            text-align: center;
    font-size:small;
    color:yellow;
            
        }
        #links{
  display: flex;
  flex-direction: row;
  position: relative;
  margin-top: 10px;
  left: 4%;
}
#links > div{
  margin-right: 5px;
}
#translate-button-wrapper{
  position: relative;
  left: 1%;
 
}
@media only screen and (max-width: 1000px) { 
#upcontainer{
  height: 80px;width: 300px;
  background-color: white;position: absolute;padding: 10px;
  left: 10%;top: 10% !important;   box-shadow: 0 4px 40px 0 rgba(0, 0, 0, 0.998),  0 6px 30px 0 rgba(0, 0, 0, 0.19);border-radius: 5px;
}
#upcontainer3{
  height: 210px;width: 200px;
  background-color: white;position: absolute;padding: 20px;
  left: 6%;top: 10% !important;   box-shadow: 0 4px 40px 0 rgba(0, 0, 0, 0.998),  0 6px 30px 0 rgba(0, 0, 0, 0.19);border-radius: 5px;
  }
  #upcontainer4{height: 150px;width: 200px;padding: 10px;position: absolute;
    left: 6%;top: 8% !important;  }
    
}
@media only screen and (max-width: 600px) {
  #upcontainer3{
    height: 210px;width: 200px;
  background-color: white;position: absolute;padding: 20px;
  left: 6%;top: 10%;   box-shadow: 0 4px 40px 0 rgba(0, 0, 0, 0.998),  0 6px 30px 0 rgba(0, 0, 0, 0.19);border-radius: 5px;
   }

   #upcontainer4{height: 150px;width: 200px;padding: 10px;position: absolute;
    left: 6%;top: 8%;  }  
}

#upcontainer5{height: 100px;width: 300px;
  background-color: white;padding: 20px;
     box-shadow: 0 4px 40px 0 rgba(0, 0, 0, 0.998),  0 6px 30px 0 rgba(0, 0, 0, 0.19);border-radius: 5px;
  position: relative;top: 20% !important;left: 10%;
    }
</style>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<link rel="shortcut icon" href="images/newlogo.jpg">
<link rel="stylesheet" href="index.css">
<link rel="stylesheet" href="style1.css">
<link rel="stylesheet" href="Responsive.css">
<link href="https://fonts.googleapis.com/icon?family=Inter" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  </head>
  <body>

  <div id="starter">
      <h3 id="needhelp">Contact Us:  <a style="color: white;font-weight: lighter;font-size: small;"  href="mailto:capitalg@capitalguard.cc"> capitalg@capitalguard.cc</a></h3>
     <div id="links">
      <div><button id="botnz"><a href="index.html" style="color: white;">Home</a></button></div>  
     <div><button id="botnz" ><a href="sign-in.html" style="color: white;">Sign in</a></button></div>  
     <div><button id="botnzz" ><a href="register.html" style="color: white;">Sign up</a></button></div>  
     <div id="translate-button-wrapper">
      <div id="google_translate_element"></div>
    </div>
       <script type="text/javascript">
       function googleTranslateElementInit() {
         new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
       }
       </script>
    </div>
      </div>
 
  <div style="position: sticky;top: 0;background-color: #fafafb;height: 80px; z-index: 5000;box-shadow: 0 0px 5px 0 rgba(0, 0, 0, 0.998),  0 0px 5px 0 rgba(0, 0, 0, 0.19)" >
    <img src="images/newlogo.jpg" id="ingo">
    <span style="font-size:30px;cursor:pointer" onclick="openNav()" id="span">&#9776;</span>
    
    <div style="position: absolute;left: 20%;" id="dropID" >
    <ul style="margin-top: 0;margin-bottom:20px ;" >

<li onclick="dropdown(1)">
<p id="color">Banking Services <i class="arrow down"></i></p>
<p id="colorz">Accounts and Services</p>
<li>

<li onclick="dropdown(2)">
  <p id="color">Borrowing  		<i class="arrow down"></i></p>
  <p id="colorz">Loans and Mortgages</p>
</li>

<li onclick="dropdown(3)">
  <p id="color">Investing 	<i class="arrow down"></i> </p>
  <p id="colorz">Products and Analysis</p>
</li>

<li onclick="dropdown(4)">
  <p id="color">Insurance 	<i class="arrow down"></i></p>
  <p id="colorz">Property and family</p>
</li>

<li onclick="dropdown(5)">
  <p id="color" >Life Events 	<i class="arrow down"></i> </p>
  <p id="colorz">Help and Support</p>
</li>
</ul>
</div>


 <!--drop down page 1-->
 <div style="height: 350px;width: 90%; display: none;"  class="stack" id="dropdown1">
  <div id="current" style="border-right: 1px solid #780b54de;position: relative;top:-42%;" >
    <h2 id="bluez">Current Accounts</h2>
    <p><a href="bridgewater_acct.html">Bridgewater account</a></p>
    <p><a href="advance-acc.html">Advance account</a></p>
    <p><a href="student_acc.html">Student account</a></p>
    <p><a href="bank_acc.html">Bank account</a></p>
  </div>
  <div  id="current" style="border-right: 1px solid #780b54de; position: relative;top:-42%;">
    <h2 id="bluez">Savings</h2>
    <p><a href="savings.html">ISAs</a></p>
            <p><a href="savings.html">Online bonus saver</a></p>
            <p><a href="savings.html">flexible saver</a></p><br>
  </div>
  <div id="current" style="position: relative;top:-24%;">
    <h2 id="bluez">Credit cards</h2>
    <p><a href="Credit-cards.html">32 month transfer credit card</a></p>
    <p><a href="Credit-cards.html">Advance Credit Card</a></p>
    <p><a href="Credit-cards.html">Dual credit card </a></p>
    <p><a href="classic credit card"></a></p>
    <p><a href="Credit-cards.html">Bridgewater credit card</a> </p>
    <p><a href="Credit-cards.html">Bridgewater world elite mastercard</a></p>
    <p><a href="Credit-cards.html">Student credit card</a></p>
  </div>
  <div id="current" style="background-color:  #780b54de;color: white; height: 330px;;"class="currentz" >
    <h2 style="margin-top: 25px;" >Services</h2>
    <p><a href="services.html">ways to bank</a></p>
    <p><a href="services.html">Voice ID</a></p>
    <p><a href="services.html">Contact and Support</a></p>
    <p><a href="services.html">Find a branch</a></p>
    <h2>International Services</h2>
    <p ><a href="international_services.html">Currency Account</a></p>
    <p><a href="international_services.html">International payments</a></p>
    <p><a href="international_services.html">Travel money</a></p>
  </div>
  <button onclick="close1()" style="position: absolute;top: 87%;left: 45%;height: 40px;width: 100px;color: white;background-color: #780b54de;border-radius: 15px;">Close</button>
  <script>
    function close1(){
    document.getElementById("dropdown1").style.display="none";
  }
  </script>
</div>



 <!--drop down page2-->
 <div style="height: 350px;width: 90%; display: none;"  class="stack" id="dropdown2">
  <div id="current" style="border-right: 1px solid #780b54de;position: relative;top:-20%;">
    <h2 id="bluez">Loan</h2>
    <p><a href="personal-loans.html">personal loan</a></p>
    <p><a href="car-loans.html">Car loan</a></p>
    <p><a href="flexible-loan.html">flexiloan</a></p>
    <p><a href="bridgewater-loan.html">Bridgewater personal loan</a></p>
    <p><a href="graduate-loan.html">Graduate loan</a></p>
  </div>
  <div  id="current" style="border-right: 1px solid #780b54de; position: relative;top:-10%;">
    <h2 id="bluez">Mortgages</h2>
    <p><a href="First time buyer.html">First time buyer</a></p>
    <p><a href="95percent-Mortgages.html">95% Mortgages</a></p>
    <p><a href="Remortgage.html">Remortgage</a></p>
    <p><a href="buy to let.html">Buy to let</a></p>
    <p><a href="mortgage rates.html">Mortgage rates</a></p>
    <p><a href="armed forces.html">Armed forces personel</a></p>
  </div>
  <div id="current" style="position: relative;top:-10%;">
    <h2 id="bluez">Credit cards</h2>
    <p><a href="Credit-cards.html">32 month transfer credit card</a></p>
            <p><a href="Credit-cards.html">Advance Credit Card</a></p>
            <p><a href="Credit-cards.html">Dual credit card </a></p>
            <p><a href="classic credit card"></a></p>
            <p><a href="Credit-cards.html">Bridgewater credit card</a> </p>
            <p><a href="Credit-cards.html">Bridgewater world elite mastercard</a></p>
            <p><a href="Credit-cards.html">Student credit card</a></p>
  </div>
  <div id="current" style="background-color:  #780b54de;color: white; height: 330px;position: relative;top:-2%;;" class="currentz">
    <h2 style="margin-top: 25px;" >Services</h2>
    <p><a href="borrowingService.html">Help & Support</a></p>
    <p><a href="borrowingService.html">Money worries</a></p>
    <h2><a href="borrowingService.html">Tools & Guides</a></h2>
    <p><a href="borrowingService.html">Overpayment calculator</a></p>
    <p><a href="borrowingService.html">Base rate information</a></p> 
    <br><br> 
  </div>
  <button onclick="close2()" style="position: absolute;top: 87%;left: 45%;height: 40px;width: 100px;color: white;background-color: #780b54de;border-radius: 15px;">Close</button>
  <script>
    function close2(){
    document.getElementById("dropdown2").style.display="none";
  }
  </script>
</div>

  <!--drop down pages3-->
  <div style="height: 350px;width: 90%; display: none;"  class="stack" id="dropdown3">
    <div id="current" style="border-right: 1px solid #780b54de;position: relative;top:1%;" >
      <h2 id="bluez"> Investments</h2>
      <p><a href="investmentfund.html">Investment Funds</a></p>
              <p><a href="WorldselectionISA.html">World Selection ISA</a></p>
              <p><a href="sharedealing.html">Sharedealing</a></p>
              <p><a href="financial advice.html">Bridgewater financial advice</a></p>
              <p><a href="onshoreinvestment.html">Onshore investment bond</a></p>
              <p><a href="child trust fund.html">Child trust fund</a></p>
    </div>
    <div  id="current" style="border-right: 1px solid #780b54de;position: relative;top:-45%;">
      <h2 id="bluez">Why invest in us</h2>
      <p><a href="why invest.html">Find out more</a></p>
    </div>
    <div id="current" style="position: relative;top:0%">

    </div>
    <div id="current" style="background-color:  #780b54de;color: white; height: 330px;position: relative;top:-50%;;" class="currentz">
      <h2 style="margin-top: 25px;" >Customer Support</h2>
      <p><a href="services.html">Getting Started with Investing</a></p>
    </div>
    <button onclick="close3()" style="position: absolute;top: 87%;left: 45%;height: 40px;width: 100px;color: white;background-color: #780b54de;border-radius: 15px;">Close</button>
    <script>
      function close3(){
      document.getElementById("dropdown3").style.display="none";
    }
    </script>
  </div>

     <!--drop down page4-->
     <div style="height: 350px;width: 90%; display: none;"   class="stack" id="dropdown4">
      <div id="current" style="border-right: 1px solid #780b54de;position: relative;top:-10%">
        <h2 id="bluez">Insurance</h2>
        <p><a href="home insurance.html">Home Insurance</a></p>
        <p><a href="travel insurance.html">Travel Insurance</a></p>
        <p><a href="student insurance.html">Student Insurance</a></p>
      </div>
      <div  id="current" style="border-right: 1px solid #780b54de;">
        <h2 id="bluez">Life Insurance</h2>
        <p><a href="life insurance.html">Life Cover</a></p>
        <p><a href="life insurance.html">Critical Illness Cover</a></p>
        <p><a href="life insurance.html">Income Cover</a></p>
        <p><a href="protection telephone advice.html">Telephone Protection Advice</a></p>
      </div>
      <div id="current" style="position: relative;top:-9%" >
        <h2 id="bluez">Insurance Claims</h2>
        <p><a href="home insurance.html">Home insurance claims</a></p>
        <p><a href="travel insurance.html">Travel insurance claims</a></p>
        <p><a href="car insurance.html">Car insurance claims</a></p>
      </div>
      <div id="current" style="background-color:  #780b54de;color: white; height: 330px;position: relative;top:-11%" class="currentz">
        <h2 style="margin-top: 25px;" >Bridgewater Customers</h2>
        <p><a href="travel insurance.html">Travel insurance claims</a></p>
        <p><a href="car insurance.html">Car insurance claims</a></p>
      </div>
      <button onclick="close4()" style="position: absolute;top: 87%;left: 45%;height: 40px;width: 100px;color: white;background-color: #780b54de;border-radius: 15px;">Close</button>
      <script>
        function close4(){
        document.getElementById("dropdown4").style.display="none";
      }
      </script>
    </div>

    <!--drop down page 5-->
    <div style="height: 350px;width: 90%; display: none;"  class="stack" id="dropdown5">
      <div id="current" style="border-right: 1px solid #780b54de;position: relative;top:-40%">
        <h2 id="bluez">Life Event</h2>
       <p><a href="berievement.html">Bereavement Support</a></p> 
        <p><a href="seperation.html">Separation Support</a></p>
      </div>
      <div  id="current" style="border-right: 1px solid #780b54de;position: relative;top:-48%">
        <h2 id="bluez">Planning Tools</h2>
       <p><a href="review.html">Financial Health Check</a> </p>
     
      </div>
      <div id="current" style="position: relative;top:-55%">
       
      </div>
      <div id="current" style="background-color:  #780b54de;color: white; height: 330px;position: relative;top:-10%" class="currentz">
        <h2 style="margin-top: 25px;" >Customer Support</h2>
        <p><a href="services.html">Ways we can help</a></p>
      
        <h2 >Individual Review</h2>
        <p><a href="review.html">Book Your Review Today For a quick <br> <br> Financial Checkup</a></p>
      </div>
      <button onclick="close5()" style="position: absolute;top: 87%;left: 45%;height: 40px;width: 100px;color: white;background-color: #780b54de;border-radius: 15px;">Close</button>
      <script>
        function close5(){
        document.getElementById("dropdown5").style.display="none";
      }
      </script>
    </div>
  </div>


<div class="password" id="p">
<div style="margin-right: 30px;color: white;text-align: center;margin-top: 15%;" >
<h1>FORGOT PASSWORD?</h1>
<h3>Please enter the last password your can remember and your new password to set</h3>
 <?php if (!empty($errorMsg)) { ?>
            <div class="centered-div">
                <?php echo $errorMsg; ?>
            </div>
        <?php } ?>
</div>
<div>
   
<form action="" id="forgotten" method="post">
    
  <input type="text" name="email" placeholder="email" style="width: 200px;height: 30px;border-radius: 7px;"><br><br>
  <input type="number" name="oldPassword" placeholder="Old Password" style="width: 200px;height: 30px;border-radius: 7px;"><br><br>
  <input type="number" name="newPassword" placeholder="New PassWord" style="width: 200px;height: 30px;border-radius: 7px;"><br><br>
  <button type="submit">Submit</button>
  
</form>
</div>
</div>

<div class="password1">
  <div style="margin:20px;color: white;text-align: center;" >
  <h1>FORGOT PASSWORD?</h1>
  <h3>Please enter the last password your can remember and your new password to set</h3>
 
  <form action="" id="forgotten1" method="post">
    <input type="text" name="email" placeholder="email" style="width: 200px;height: 30px;border-radius: 7px;"><br><br>
    <input type="number" name="oldPassword" placeholder="Old Password" style="width: 200px;height: 30px;border-radius: 7px;"><br><br>
    <input type="number" name="newPassword" placeholder="New PassWord" style="width: 200px;height: 30px;border-radius: 7px;"><br><br>
    <button type="submit">Submit</button>
     <?php if (!empty($errorMsg)) { ?>
            <div class="centered-div">
                <?php echo $errorMsg; ?>
            </div>
        <?php } ?>
  </form>
  </div>
  </div>












<div id="mySidenav" class="sidenav">
  <h3 style="color: white;text-align: center;">Menu</h3>
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <button onclick="smallscreen(1)" id="but1" ><p><b>Banking Services (Accounts and Services)</b></p></button>
  <div id="smalla1" class="divas2" >
<div >
      <p style="color: #1af33bde;">Current Accounts</p>
      <p><a style="font-size: smaller;padding: 0;margin-left: 10px;"  href="bridgewater_acct.html">Bridgewater account</a></p>
      <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="advance-acc.html">Advance account</a></p>
      <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="student_acc.html">Student account</a></p>
      <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="bank_acc.html">Bank account</a></p>
    <hr>
      <p style="color: #1af33bde;">Savings</p>
      <p> <a style="font-size: smaller;padding: 0;margin-left: 10px;" href="savings.html">ISAs</a></p>
              <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="savings.html">Online bonus saver</a></p>
              <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="savings.html">flexible saver</a></p><br>
   <hr>
      <p style="color: #1af33bde;">Credit cards</p>
      <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="Credit-cards.html">32 month transfer credit card</a></p>
      <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="Credit-cards.html">Advance Credit Card</a></p>
      <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="Credit-cards.html">Dual credit card </a></p>
      <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="classic credit card"></a></p>
      <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="Credit-cards.html">Bridgewater credit card</a> </p>
      <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="Credit-cards.html">Bridgewater world elite mastercard</a></p>
      <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="Credit-cards.html">Student credit card</a></p>
   <hr>
      <p  style="color: #1af33bde;">Services</p>
      <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="services.html">ways to bank</a></p>
      <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="services.html">Voice ID</a></p>
      <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="services.html">Contact and Support</a></p>
      <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="services.html">Find a branch</a></p>
      <p style="color: #1af33bde;">International Services</p>
      <p ><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="international_services.html">Currency Account</a></p>
      <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="international_services.html">International payments</a></p>
      <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="international_services.html">Travel money</a></p>

    </div>
  </div>
  
    <button onclick="smallscreen(2)"  id="but1" ><p><b>Borrowing ( Loans and Mortgages) </b></p></button>
    <div id="smalla2" class="divas2">
      <div >
        <p style="color: #1af33bde;">Loan</p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="personal-loans.html">personal loan</a></p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="car-loans.html">Car loan</a></p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="flexible-loan.html">flexiloan</a></p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="bridgewater-loan.html">Bridgewater personal loan</a></p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="graduate-loan.html">Graduate loan</a></p>
     <hr>
      <p style="color: #1af33bde;">Mortgages</p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="First time buyer.html">First time buyer</a></p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="95percent-Mortgages.html">95% Mortgages</a></p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="Remortgage.html">Remortgage</a></p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="buy to let.html">Buy to let</a></p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="mortgage rates.html">Mortgage rates</a></p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="armed forces.html">Armed forces personel</a></p>
   
     <hr>
        <p style="color: #1af33bde;">Credit cards</p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="Credit-cards.html">32 month transfer credit card</a></p>
                <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="Credit-cards.html">Advance Credit Card</a></p>
                <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="Credit-cards.html">Dual credit card </a></p>
                <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="classic credit card"></a></p>
                <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="Credit-cards.html">Bridgewater credit card</a> </p>
                <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="Credit-cards.html">Bridgewater world elite mastercard</a></p>
                <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="Credit-cards.html">Student credit card</a></p>
     <hr>
     <p style="color: #1af33bde;" >Services</p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="borrowingService.html">Help & Support</a></p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="borrowingService.html">Money worries</a></p>
        <p style="color: #1af33bde;" >Tools & Guides</p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="borrowingService.html">Overpayment calculator</a></p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="borrowingService.html">Base rate information</a></p> 
        
      </div>
    </div>

      <button onclick="smallscreen(3)"  id="but1"><p><b> Investing  (Products and Analysis) </b></p></button>
      <div id="smalla3" class="divas2">
        <p style="color: #1af33bde;"> Investments</p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;"  href="investmentfund.html">Investment Funds</a></p>
                <p><a style="font-size: smaller;padding: 0;margin-left: 10px;"  href="WorldselectionISA.html">World Selection ISA</a></p>
                <p><a style="font-size: smaller;padding: 0;margin-left: 10px;"  href="sharedealing.html">Sharedealing</a></p>
                <p><a style="font-size: smaller;padding: 0;margin-left: 10px;"  href="financial advice.html">Bridgewater financial advice</a></p>
                <p><a style="font-size: smaller;padding: 0;margin-left: 10px;"  href="onshoreinvestment.html">Onshore investment bond</a></p>
                <p><a style="font-size: smaller;padding: 0;margin-left: 10px;"  href="child trust fund.html">Child trust fund</a></p>
    
    <hr>
        <p style="color: #1af33bde;">Why invest in us</p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;"  href="why invest.html">Find out more</a></p>
    
      <hr>
       <p style="color: #1af33bde;" >Customer Support</p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;"  href="services.html">Getting Started with Investing</a></p>
  
      </div>

        <button onclick="smallscreen(4)"  id="but1" ><p><b> Insurance  (Property and family) </b></p>  </button>
        <div id="smalla4" class="divas2">
          <p style="color: #1af33bde;">Insurance</p>
          <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="home insurance.html">Home Insurance</a></p>
          <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="travel insurance.html">Travel Insurance</a></p>
          <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="student insurance.html">Student Insurance</a></p>

        <hr>
          <p style="color: #1af33bde;">Life Insurance</p>
          <p><a style="font-size: smaller;padding: 0;margin-left: 10px;"  href="life insurance.html">Life Cover</a></p>
          <p><a style="font-size: smaller;padding: 0;margin-left: 10px;"  href="life insurance.html">Critical Illness Cover</a></p>
          <p><a style="font-size: smaller;padding: 0;margin-left: 10px;"  href="life insurance.html">Income Cover</a></p>
          <p><a style="font-size: smaller;padding: 0;margin-left: 10px;"  href="protection telephone advice.html">Telephone Protection Advice</a></p>
      
      <hr>
      <p style="color: #1af33bde;">Insurance Claims</p>
          <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="home insurance.html">Home insurance claims</a></p>
          <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="travel insurance.html">Travel insurance claims</a></p>
          <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="car insurance.html">Car insurance claims</a></p>
    
       <hr>
       <p style="color: #1af33bde;">Bridgewater Customers</p>
          <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="travel insurance.html">Travel insurance claims</a></p>
          <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="car insurance.html">Car insurance claims</a></p>
       
        </div>
          <button onclick="smallscreen(5)"  id="but1" ><p><b> Life Events   ( Help and Support) </b></p> </button>
          <div id="smalla5" class="divas2">
            <p style="color: #1af33bde;">Life Event</p>
            <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="berievement.html">Bereavement Support</a></p> 
            <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="seperation.html">Separation Support</a></p>
          <hr>
          <p style="color: #1af33bde;">Planning Tools</p>
          <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="review.html">Financial Health Check</a> </p>
          
            <p style="color: #1af33bde;">Customer Support</p>
            <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="services.html">Ways we can help</a></p>
           
             <p style="color: #1af33bde;">Individual Review</p>
             <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="review.html">Book Your Review Today For a quick <br> <br> Financial Checkup</a></p>
    </div>







    <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="1e587ef1-2546-44bf-a34f-91dd266b8881";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>

<script src="index.js"></script>
<script src="student.js"></script>
            </body>
            </html>
