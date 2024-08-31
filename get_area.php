<?php
require_once "config/database.php";

if (isset($_GET['kd_upi'])) {
    $kd_upi = $mysqli->real_escape_string($_GET['kd_upi']);

    // Query to get areas based on the selected UPI
    $queryArea = "SELECT DISTINCT unitap_ap2t, nama_area FROM master_unit_ap2t WHERE kd_dist = '$kd_upi'";
    $resultArea = $mysqli->query($queryArea);

    $areas = [];
    if ($resultArea->num_rows > 0) {
        while ($rowArea = $resultArea->fetch_assoc()) {
            $areas[] = $rowArea;
        }
    }

    // Return the data as JSON
    echo json_encode($areas);
}

$mysqli->close();

