modify this to send the passward reset email without token <?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'capitalg'; 
$DATABASE_PASS = 'Edwards12345@';
$DATABASE_NAME = 'capitalg_capitalguard';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$transferredAmount = $_POST['amount'];
$accountNumber = $_POST['acc_number'];
$AccountName = $_POST['AccountName'];
$description = $_POST['description']; // Get the transaction description from the form

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


header("Location: dashboard3.php");
exit();
?>