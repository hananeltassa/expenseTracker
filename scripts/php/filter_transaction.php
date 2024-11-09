<?php
include 'connection.php'; 

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$types = $_GET['type'] ?? '';
$min_amount = $_GET['min_amount'] ?? '';
$max_amount = $_GET['max_amount'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

if (isset($_POST['delete'])) {
    $delete_query = "DELETE FROM transactions WHERE user_id = ?";

    $delete_params = array('i', $user_id);

    if ($types) {
        $delete_query .= " AND type = ?";
        $delete_params[0] .= 's'; 
        $delete_params[] = $types;
    }

    if ($min_amount !== '') {
        $delete_query .= " AND amount >= ?";
        $delete_params[0] .= 'd';  
        $delete_params[] = (float)$min_amount;
    }

    if ($max_amount !== '') {
        $delete_query .= " AND amount <= ?";
        $delete_params[0] .= 'd'; 
        $delete_params[] = (float)$max_amount;
    }

    if ($start_date) {
        $delete_query .= " AND date >= ?";
        $delete_params[0] .= 's'; 
        $delete_params[] = $start_date;
    }

    if ($end_date) {
        $delete_query .= " AND date <= ?";
        $delete_params[0] .= 's';
        $delete_params[] = $end_date;
    }

    $delete_stmt = $connection->prepare($delete_query);
    $delete_stmt->bind_param(...$delete_params);

    if ($delete_stmt->execute()) {
        echo "Transactions deleted successfully.";
    } else {
        echo "Error deleting transactions: " . $delete_stmt->error;
    }

    $delete_stmt->close();
}

$query = "SELECT * FROM transactions WHERE user_id = ?";
$params = array('i', $user_id); 


if ($types) {
    $query .= " AND type = ?";
    $params[0] .= 's';  
    $params[] = $types;
}

if ($min_amount !== '') {
    $query .= " AND amount >= ?";
    $params[0] .= 'd';  
    $params[] = (float)$min_amount;
}

if ($max_amount !== '') {
    $query .= " AND amount <= ?";
    $params[0] .= 'd';  
    $params[] = (float)$max_amount;
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
echo "<tr><th>Description</th><th>Amount</th><th>Date</th><th>Type</th><th>Action</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['description']}</td>";
    echo "<td>{$row['amount']}</td>";
    echo "<td>{$row['date']}</td>";
    echo "<td>{$row['type']}</td>";
    echo "<td>
        <form method='POST' action=''>
            <input type='hidden' name='transaction_id' value='{$row['id']}'>
            <button type='submit' name='delete_single'>Delete</button>
        </form>
    </td>";
    echo "</tr>";
}
echo "</table>";

$q->close();

if (isset($_POST['delete_single'])) {
    $transaction_id = $_POST['transaction_id'];

    $delete_single_query = "DELETE FROM transactions WHERE id = ? AND user_id = ?";
    $delete_single_stmt = $connection->prepare($delete_single_query);
    $delete_single_stmt->bind_param('ii', $transaction_id, $user_id);

    if ($delete_single_stmt->execute()) {
        echo "Transaction deleted successfully.";
    } else {
        echo "Error deleting transaction: " . $delete_single_stmt->error;
    }

    $delete_single_stmt->close();
}
?>
