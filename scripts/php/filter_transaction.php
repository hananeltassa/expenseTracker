<?php
include 'connection.php'; 

session_start();

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM transactions WHERE user_id = ?";

$params = array('i', $user_id);  

$types = $_GET['type'] ?? '';
$min_amount = $_GET['min_amount'] ?? '';
$max_amount = $_GET['max_amount'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

if ($types) {
    $query .= " AND type = ?";
    $params[0] .= 's';  
    $params[] = $types;
}

if ($min_amount) {
    $query .= " AND amount >= ?";
    $params[0] .= 'd';  
    $params[] = $min_amount;
}

if ($max_amount) {
    $query .= " AND amount <= ?";
    $params[0] .= 'd';  
    $params[] = $max_amount;
}

if ($start_date) {
    $query .= " AND date >= ?";
    $params[0] .= 's';  
    $params[] = $start_date;
}

if ($end_date) {
    $query .= " AND date <= ?";
    $params[0] .= 's';  
    $params[] = $end_date;
}


$q = $connection->prepare($query);

$q->bind_param(...$params);

$q->execute();
$result = $q->get_result();

echo "<table>";
echo "<tr><th>Description</th><th>Amount</th><th>Date</th><th>Type</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['description']}</td>";
    echo "<td>{$row['amount']}</td>";
    echo "<td>{$row['date']}</td>";
    echo "<td>{$row['type']}</td>";
    echo "</tr>";
}
echo "</table>";

$q->close();
?>
