<?php
require_once "config/database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_POST['userid'];
    $fullname = $_POST['fullname'];
    $role_code = $_POST['role_code'];

    // Prepare an update statement
    $stmt = $mysqli->prepare("UPDATE app_userid SET fullname = ?    , role_code = ? WHERE userid = ?");
    $stmt->bind_param('ssi', $fullname, $role_code, $userid);

    if ($stmt->execute()) {
        echo "User updated successfully!";
    } else {
        echo "Error updating user: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

