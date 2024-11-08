<?php
include 'connection.php'; 

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $type = $_POST['type'];

    $query = $connection->prepare("INSERT INTO transactions (description, amount, date, type, user_id) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("sdssi", $description, $amount, $date, $type, $user_id);

    if ($query->execute()) {
        header("Location: ../../transaction.html"); 
        exit(); 
    } else {
        echo "Error: " . $query->error;
    }

    $query->close();
}
?>
