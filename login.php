<?php

require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $connection->prepare("SELECT id, username, email, password FROM users WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            header("Location: index.html"); 
            exit();
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "Username not found!";
    }

    $query->close();
}
?>
