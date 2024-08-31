<?php
require_once "config/database.php";

header('Content-Type: application/json');

$response = ['success' => false];

$mysqli->begin_transaction();

try {
    // Hapus semua data dari tabel app_userid
    $query1 = "DELETE FROM app_userid";
    if ($stmt1 = $mysqli->prepare($query1)) {
        if (!$stmt1->execute()) {
            throw new Exception("Gagal menghapus data dari tabel app_userid: " . $stmt1->error);
        }
        $stmt1->close();
    }

    // Hapus semua data dari tabel MASTER_PETUGAS_SURVEY
    $query2 = "DELETE FROM MASTER_PETUGAS_SURVEY";
    if ($stmt2 = $mysqli->prepare($query2)) {
        if (!$stmt2->execute()) {
            throw new Exception("Gagal menghapus data dari tabel MASTER_PETUGAS_SURVEY: " . $stmt2->error);
        }
        $stmt2->close();
    }

    // Commit transaksi jika semua operasi berhasil
    $mysqli->commit();
    $response['success'] = true;

} catch (Exception $e) {
    // Rollback transaksi jika terjadi kesalahan
    $mysqli->rollback();
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
$mysqli->close();
