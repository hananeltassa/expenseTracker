<?php

require_once 'connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    if (empty($username) || empty($password)) {
        echo "Username and Password are required!";
        exit();
    }

    $query = $connection->prepare("SELECT id, username, email, password FROM users WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: ../../transaction.html");
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
