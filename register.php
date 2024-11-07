<?php
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit(); 
    }

    $hash_pass = password_hash($password, PASSWORD_DEFAULT);

    $query = $connection->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

    $query->bind_param("sss", $username, $email, $hash_pass); // prevent injection

    if ($query->execute()) {
        header("Location: login.html"); 
        exit();
    } else {
        echo "Error: " . $query->error; 
    }

    $query->close();
}
?>
