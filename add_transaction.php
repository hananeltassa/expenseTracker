<?php
include 'connection.php';

//check if the form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $type = $_POST['type'];
}
