<?php
include 'connection.php'; // Adjust the path if needed

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: loginpage.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $type = $_POST['type'];

    // Prepare and bind the SQL statement
    $query = $connection->prepare("INSERT INTO transactions (description, amount, date, type, user_id) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("ssssi", $description, $amount, $date, $type, $user_id);

    // Execute the query
    if ($query->execute()) {
        // Redirect back to the main page (or wherever you want)
        header("Location: ../../transaction.html"); // Redirect to the page that displays transactions
        exit(); // Ensure the script stops here
    } else {
        echo "Error: " . $query->error;
    }

    // Close the query
    $query->close();
}
?>
