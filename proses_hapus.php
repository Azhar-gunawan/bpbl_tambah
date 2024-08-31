<?php
require_once "config/database.php";

header('Content-Type: application/json');

$response = ['success' => false];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Hapus data dari database
    $query = "DELETE FROM app_userid WHERE ID = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $response['success'] = true;
        }
        $stmt->close();
    }
}

echo json_encode($response);
$mysqli->close();

