<?php
require_once "config/database.php";

$query = "SELECT uid_badan_usaha FROM master_lit"; // Adjust the query as per your database
$result = $conn->query($query);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row['uid_badan_usaha'];
}

echo json_encode($data);

$conn->close();
?>
