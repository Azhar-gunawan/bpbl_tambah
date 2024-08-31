<?php
require_once "config/database.php";

if (isset($_GET['kd_area'])) {
    $kd_area = $mysqli->real_escape_string($_GET['kd_area']);
    
    // Debugging SQL query
    $sql = "SELECT unitup, nama_unit FROM master_unit_ap2t WHERE unitap_ap2t = '$kd_area'";
    $result = $mysqli->query($sql);

    if (!$result) {
        // Output SQL error
        echo json_encode(['error' => $mysqli->error]);
        exit;
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode([]);
}

