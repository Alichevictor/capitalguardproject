<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to the login page or handle unauthorized access as needed
    header("Location: sign-in.html"); // Replace with your login page URL
    exit();
}

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'capitalg';
$DATABASE_PASS = 'Edwards12345@';
$DATABASE_NAME = 'capitalg_capitalguard';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$amount = $_POST['amount'];
$accountNumber = $_POST['acc_number'];
$bankName = $_POST['bank_name'];
$accountName = $_POST['AccountName'];
$description = $_POST['description'];

// Get the current date
$currentDate = date("Y-m-d");

// Insert data into the storage table using the user's session ID
$insertStmt = $con->prepare("INSERT INTO storage (account_id, amount, accountNumber, bankName, accountName, description, currentDate) VALUES (?, ?, ?, ?, ?, ?, ?)");

if ($insertStmt) {
    $insertStmt->bind_param('dssssss', $_SESSION['id'], $amount, $accountNumber, $bankName, $accountName, $description, $currentDate);
    if ($insertStmt->execute()) {
        header('Location: transfer1.php');
        exit(); // Make sure to exit after the header redirect
    } else {
        // Display the error message
        echo "Execution Error: " . $insertStmt->error;
    }
    $insertStmt->close(); // Close the statement here
} else {
    // Display the prepare error message
    echo "Prepare Error: " . mysqli_error($con);
}

$con->close(); // Close the database connection here
?>
