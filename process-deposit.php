<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'capitalg';
$DATABASE_PASS = 'Edwards12345@';
$DATABASE_NAME = 'capitalg_capitalguard';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$depositedAmount = $_POST['amount'];

// Handle file uploads for front and back images
$frontImageName = $_FILES['frontImage']['name'];
$backImageName = $_FILES['backImage']['name'];
$uploadsDirectory = 'uploads/';

// Check if the directory already exists
if (!is_dir($uploadsDirectory)) {
    // Attempt to create the directory
    if (!mkdir($uploadsDirectory, 0755)) {
        exit('Failed to create directory');
    }
}

if (isset($_FILES['frontImage']) && is_uploaded_file($_FILES['frontImage']['tmp_name'])) {
    $frontImageName = $_FILES['frontImage']['name'];
    $frontImagePath = $uploadsDirectory . $frontImageName;
    if (!move_uploaded_file($_FILES['frontImage']['tmp_name'], $frontImagePath)) {
        exit('Failed to move front image');
    }
} else {
    exit('Front image was not uploaded or not uploaded via HTTP POST');
}

if (isset($_FILES['backImage']) && is_uploaded_file($_FILES['backImage']['tmp_name'])) {
    $backImageName = $_FILES['backImage']['name'];
    $backImagePath = $uploadsDirectory . $backImageName;
    if (!move_uploaded_file($_FILES['backImage']['tmp_name'], $backImagePath)) {
        exit('Failed to move back image');
    }
} else {
    exit('Back image was not uploaded or not uploaded via HTTP POST');
}

$stmt = $con->prepare("SELECT balance FROM accounts WHERE id = ?");
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($balance);
$stmt->fetch();
$stmt->close();

$newBalance = $balance + $depositedAmount;

$updateStmt = $con->prepare("UPDATE accounts SET balance = ? WHERE id = ?");
$updateStmt->bind_param('di', $newBalance, $_SESSION['id']);
$updateStmt->execute();
$updateStmt->close();


// Insert a new deposit transaction into the "transactions" table with a default description
// Insert a new deposit transaction into the "transactions" table with a default description
$transactionType = "Deposit";
$transactionDescription = "Deposit"; // Default description
$userId = $_SESSION['id'];

$insertStmt = $con->prepare("INSERT INTO transactions (account_id, transaction_type, amount, transaction_description) VALUES (?, ?, ?, ?)");

if (!$insertStmt) {
    // Handle the SQL error
    exit('Prepare failed: ' . $con->error);
}

// Bind parameters with the correct data types
$insertStmt->bind_param('isds', $userId, $transactionType, $depositedAmount, $transactionDescription);

if (!$insertStmt->execute()) {
    // Handle the SQL error
    exit('Execute failed: ' . $insertStmt->error);
}

$insertStmt->close();

// Redirect or perform other actions here




header("Location: deposited.php");
exit();
?>
