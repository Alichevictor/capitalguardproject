<?php
// Change this to your connection info.
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


$requiredFields = [
    'firstName',
    'lastName',
    'otherName',
    'email',
    'phoneNumber',
    'dateOfBirth',
    'residentialAddress',
    'statesecurityNumber',
    'nextofkinName',
    'username',
    'password'
];

foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
     $errorMsg =  'Please complete the registration form';
    }
}

// Validate image fields (required)
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    $errorMsg =  'Please upload a valid image';
}

// Validate image type and size
$allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
$maxImageSize = 5 * 1024 * 1024; // 5 MB

if (
    !in_array($_FILES['image']['type'], $allowedImageTypes) ||
    $_FILES['image']['size'] > $maxImageSize
) {
     $errorMsg =  'Please upload a valid image';
}

// Move the uploaded image to a designated upload directory
$uploadDir = 'uploads/';
$uploadedFilePath = $uploadDir . $_FILES['image']['name'];

if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFilePath)) {
  $errorMsg =  'Failed to move uploaded image to the directory.';  
}

$imagePath = $uploadedFilePath;


if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  $errorMsg =  'Email is not valid!!';
}
if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
   $errorMsg =  'Username is not valid!';
}
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 6) {
      $errorMsg =  'Password must be between 5 and 20 characters long!';
}
// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id FROM accounts WHERE username = ?')) {
    // Bind parameters (s = string), bind the username.
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // Username already exists
       $errorMsg =  'Username exists, please choose another';
    } else {
        // Username doesn't exist, insert new account
        if ($stmt = $con->prepare(
            'INSERT INTO accounts (
                firstName,
                lastName,
                otherName,
                email,
                phoneNumber,
                dateOfBirth,
                residentialAddress,
                statesecurityNumber,
                nextofkinName,
                username,
                password,
                imagePath,     /* New column for storing image path */
                balance
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        )) {
          
            $balance = 0.00; // Initial balance
            
            $stmt->bind_param(
                'ssssssssssssd', // Adjust the data types accordingly
                $_POST['firstName'],
                $_POST['lastName'],
                $_POST['otherName'],
                $_POST['email'],
                $_POST['phoneNumber'],
                $_POST['dateOfBirth'],
                $_POST['residentialAddress'],
                $_POST['statesecurityNumber'],
                $_POST['nextofkinName'],
                $_POST['username'],
                $_POST['password'],
                $imagePath, // Store the image path in the database
                $balance
            );
            
            
            
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    header("refresh:0;url=success.html");
                } else {
                  $errorMsg =  'Registration failed, please try again';
                }
            } else{
            $errorMsg =  '';
            }
            
        } else {
         $errorMsg =  'could not prepare statement';
        }
    }
    $stmt->close();
} else {
   $errorMsg =  'could not prepare statement';
}

$con->close();
?>

<!DOCTYPE html>
<html>
    <head>
<!--TITLE-->
<title>Register</title>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<style>
  body{
    font-family: "Inter";
    font-size: 14px;
  }
 
#innercity1{
  height: 200px;
  border: 2px solid black;
  overflow: scroll;
  padding: 10px;
}

.divzz1{
  display: none;
  margin-left: 8%;
  border-left: 1px solid gray;
  border-right: 1px solid gray;
  border-bottom: 1px solid gray;
  width: 82%;
  padding: 20px;
  margin-bottom: 5%;
}

.ul{
display: flex;
flex-direction: row;
flex-wrap: wrap;
color: white;
margin: 20px;
width: 100%;
}
.ul > div{
padding: 10px;
text-align: center;
width: 22%;
}
#ul > div:hover{
background-color: rgb(236, 106, 145);
}
#div11{
    border-left: 1px solid gray;
    border-bottom: 1px solid;
    margin: 20px;
    padding: 30px;
}
 .centered-div {
            text-align: center;
            margin-bottom: 10px ;
            border:1px solid black;
            width: 50%;
            padding: 10px;
            
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
  left: 10%;top: 10%;   box-shadow: 0 4px 40px 0 rgba(0, 0, 0, 0.998),  0 6px 30px 0 rgba(0, 0, 0, 0.19);border-radius: 5px;
}
#upcontainer3{
  height: 210px;width: 200px;
  background-color: white;position: absolute;padding: 20px;
  left: 6%;top: 10%;   box-shadow: 0 4px 40px 0 rgba(0, 0, 0, 0.998),  0 6px 30px 0 rgba(0, 0, 0, 0.19);border-radius: 5px;
  }
  #upcontainer4{height: 150px;width: 200px;padding: 10px;position: absolute;
    left: 6%;top: 8%
    ;  }
    
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
  position: relative;top: 20%;left: 10%;
    }

</style>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<!--ICON-->
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
    <p><a href="capitalguard_acc.html">CapitalGuard account</a></p>
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
    <p><a href="Credit-cards.html">CapitalGuard credit card</a> </p>
    <p><a href="Credit-cards.html">CapitalGuard world elite mastercard</a></p>
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
    <p><a href="capitalguard-loan.html">CapitalGuard personal loan</a></p>
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
            <p><a href="Credit-cards.html">CapitalGuard credit card</a> </p>
            <p><a href="Credit-cards.html">CapitalGuard world elite mastercard</a></p>
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
              <p><a href="financial advice.html">CapitalGuard financial advice</a></p>
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
        <h2 style="margin-top: 25px;" >CapitalGuard Customers</h2>
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


<div style="height: 350px;background-image: url(images/morning-coffee.jpg);background-repeat: no-repeat;background-size: cover;">
    <div style="height: 100px;width: 270px;
    background-color: white;position: absolute;padding: 10px;
    left: 10%;top: 55%;   box-shadow: 0 4px 40px 0 rgba(0, 0, 0, 0.998),  0 6px 30px 0 rgba(0, 0, 0, 0.19);border-radius: 5px;">
    <h2 id="bluez" style="font-weight:30px;">OPEN AN ACCOUNT</h2>
    <P style="font-size: larger;font-weight:30px;">A bank with your needs in mind</P>
    </div>
    </div>
<div>
    <div style="width: 82%;background-color:#780b54de ;" class="ul" >
      <div >Online Registration</div>
      <div >Terms & conditions</div>
      <div style="background-color:rgb(236, 106, 145) ;">User Information</div>
      <div >Completed</div>
    </div>


<div   id="div11">
 <h2>Account Information</h2> 
<p>Please enter your information and proceed to the next step so we can build your accounts.</p>
<br>
<h2 style="color: #780b54de;">Basis User Information</h2>


<div id="register">
<div><label for="Zip code">Zip Code:</label><br>
<input type="text" name="Zip code" placeholder="Zip/Postal code" id="input"></div>

<div>
  <label for="title">Title</label><br>
  <select name="Title" id="input">
    <option value="mr">Mr</option>
    <option value="Mrs">Mrs</option>
    <option value="Mr & Mrs">Mr&Mrs</option>
    <option value="ms">Ms</option>
    <option value="miss">Miss</option>
  </select>
  
</div>

<div>
  <label for="gender">Gender</label><br>
  <select name="Gender" id="input">
    <option value="Male">Male</option>
    <option value="female">Female</option>
    <option value="Other">Other</option>
  </select>
</div>

<div><label for="country">Enter Country:</label><br>
<input type="text" name="Country" placeholder="Country" id="input"></div>

<div><label for="State">Enter State:</label><br>
<input type="text" name="State" placeholder="State" id="input"></div>

<div><label>City Name:</label><br>
<input type="text" name="City" id="input"></div>

<div><label for="Currency Type">Currency Type:</label><br>
  <select id="currencySelect" class="input">
    <option value="">Select a currency</option>
  </select>
  </div>

<div><label for="Account Type">Account Type:</label><br>
<select name="Account Type" id="input">
  <option value="">Checking Account</option>
  <option value="">Savings account</option>
  <option value="">Fixed Deposit Account</option>
  <option value="">Student Account</option>
  <option value="">Current Account</option>
  <option value="">Advance Account</option>
  <option value="">Investment Account</option>
  <option value="">Non Resident Account</option>
  <option value="">Corporate Business Account</option>
</select></div>
</div>

<div id="underdiva">
<h2 style="color: #780b54de;">Employment Information (Incase of Loan/Facility)</h2><br>

<div><label >Type Of Employment</label><br>
<select name="Employment" id="input">
  <option value="">Self Employed</option>
  <option value="">public/Government Office</option>
  <option value="">private/Partnership</option>
  <option value="">Business/Sale</option>
  <option value="">Market/Trading</option>
  <option value="">Military/Paramilitary</option>
  <option value="">Politician/Celebrity</option>
</select>

</div>

<div><label for="Annual income Range">Annual income Range</label><br>
<select name="Salary Range" id="input">
  <option value="">$100 - $500</option>
  <option value="">$700 - $1000</option>
  <option value="">$1000 - $2000</option>
  <option value="">$2000 - $5000</option>
  <option value="">$5000 - $10,000</option>
  <option value="">$15,000 - $20,000</option>
  <option value="">$25,000 - $50,000</option>
  <option value="">$30,000 - 70,000</option>
  <option value="">$80,000 - 140,000</option>
  <option value="">$150,000 - $300,000</option>
  <option value="">$300,000 - $1,000,000</option>
</select>
</div>



<div>
  <label for="Please select Relationship">Please select Relationship</label><br>
<select name="Relationship" id="input">
  <option value="">Son</option>
  <option value="">Daughter</option>
  <option value="">Father</option>
  <option value="">Mother</option>
  <option value="">Spouse</option>
  <option value="">Other Relative</option>
</select>
</div>

<div>
  <label for="age">Age</label><br>
 <select name="Age" id="input">
  <option value="">18-25yrs</option>
  <option value="">25-35yrs</option>
  <option value="">35-50yrs</option>
  <option value="">50yrs and above</option>
 </select>
</div><br>


<div>
  <label for="question">Security Question</label><br>
 <select name="question" id="input">
  <option value="">What is your pet name?</option>
  <option value="">What is your nick name?</option>
  <option value="">What is your mother's maiden name</option>
  <option value="">what is the name of your first Car</option>
  <option value="">what state were your born in</option>
 </select>
</div>
<div>
  <label for="">Answer To The Question</label><br>
  <input type="text" name="answer" id="input">
</div>

<div id="underdiva1">
<form action="" method="post" autocomplete="off" enctype="multipart/form-data">
  <h2 for="password" style="color: #780b54de;">More information</h2>
  <div><label for="firstName">First Name:</label><br>
  <input type="text" name="firstName" required id="input"><br></div><br>
  
  <div><label for="lastName">Last Name:</label><br>
  <input type="text" name="lastName" required id="input"><br></div><br>
  
  
  <div><label for="otherName">Other Name:</label><br>
  <input type="text" name="otherName" required id="input"><br></div><br>
  
  <div><label for="email">Email:</label><br>
  <input type="email" name="email" required id="input"><br></div><br>
  
 <div><label for="phoneNumber">Phone Number:</label><br>
  <input type="tel" name="phoneNumber" required id="input"><br></div> <br>
  
  <div>
    <label for="Date of birth">Date Of Birth:</label><br>
    <input type="date" name="dateOfBirth" id="input">
</div><br>

  
 <div><label for="residentialAddress">Residential Address:</label><br>
  <input type="text" name="residentialAddress" required id="input"><br></div> <br>

  <div><label for="statesecurityNumber">State Security Number:</label><br>
  <input type="text" name="statesecurityNumber" required id="input"><br></div><br>
  
  <div><label for="nextofkinName">Next of Kin Name:</label><br>
  <input type="text" name="nextofkinName" required id="input"><br></div><br>
  
 <div><label for="username">Username:</label><br>
  <input type="text" name="username" required id="input"><br></div> <br>
  
 <div><label for="password">Password:</label><br>
  <input type="password" name="password" placeholder="please enter a strong password"  required id="input"><br></div> <br>

<div><h2 for="password" style="color: #780b54de;">Please Upload a clear passport photograph of you.</h2>
  <label for="image">Profile Image:</label><br>
  <input type="file" name="image" accept="image/*" required ><br></div> <br>
  
    <?php if (!empty($errorMsg)) { ?>
            <div class="centered-div">
                <?php echo $errorMsg; ?>
            </div>
        <?php } ?>
  
  <input type="submit" value="Complete" style="height: 40px;width: 100px;background-color: #780b54de;color:white;border-radius: 7px;">
</form>
</div>
<div>


  

 <p><a href="sign-in.html">Already registered? Login Here</a></p></div>

</div>






</div>
<div style="height: 150px;box-shadow: 0 4px 15px 0 rgba(0, 0, 0, 0.998),  0 6px 15px 0 rgba(0, 0, 0, 0.19);display: none;">
  <div style="margin-left: 8%;padding-top: 20px;">
    <h1 style="color:#780b54de">Connect with us</h1>
<p>Listening to what you have to say about our services matters to us.</p></div>

</div>

<div id="foots" style="display: none;">
  <div id="footer" >
  <div>
  <h3>HELP AND SUPPORT </h3>
  <p>Got a question? We are here to help <br>you</p>
</div>
    
<div>
  <h3>OUR PERFORMANCE</h3>
  <p>Get information about our <br> performance</p>
</div>
  
<div>
 <h3>ABOUT CAPITALGUARD BANK</h3>
  <p>Careers, media, investor and corporate information</p>
</div>
</div>
  
  <div>
      <p style="text-align: center;">
        Federally-insured by the National Credit Administration. we do business in accordance with the Fair Law and Equal oppurtunity Credit Act.
      </p>
      <br>
      <p style="text-align: center;margin-top: 0%;">PO Box: Ermyn Way, Leatherhead KT24 6UX</p>
    </div>
    <img id="imago" src="images/newlogo.jpg" alt="logo" style="height: 80px;width: 80px; position: relative;top: -15%;left: 12%;">
  
  <p style="text-align: center; margin-top: -3%;color: rgb(216, 211, 211);">© 2023 CapitalGuard Bank- All rights reserved.</p>
  </div>





  <div id="mySidenav" class="sidenav">
    <h3 style="color: white;text-align: center;">Menu</h3>
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <button onclick="smallscreen(1)" id="but1" ><p><b>Banking Services (Accounts and Services)</b></p></button>
    <div id="smalla1" class="divas2" >
<div >
        <p style="color: #1af33bde;">Current Accounts</p>
        <p><a style="font-size: smaller;padding: 0;margin-left: 10px;"  href="capitalguard_acc.html">CapitalGuard account</a></p>
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
        <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="Credit-cards.html">CapitalGuard credit card</a> </p>
        <p><a  style="font-size: smaller;padding: 0;margin-left: 10px;"  href="Credit-cards.html">CapitalGuard world elite mastercard</a></p>
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
          <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="capitalguard-loan.html">CapitalGuard personal loan</a></p>
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
                  <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="Credit-cards.html">CapitalGuard credit card</a> </p>
                  <p><a style="font-size: smaller;padding: 0;margin-left: 10px;" href="Credit-cards.html">CapitalGuard world elite mastercard</a></p>
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
                  <p><a style="font-size: smaller;padding: 0;margin-left: 10px;"  href="financial advice.html">CapitalGuard financial advice</a></p>
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
         <p style="color: #1af33bde;">CapitalGuard Customers</p>
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

<script src="student.js"></script>
<script src="register.js"></script>
    <script src="index.js"></script>

    <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="1e587ef1-2546-44bf-a34f-91dd266b8881";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>

      
                </body>
                </html>