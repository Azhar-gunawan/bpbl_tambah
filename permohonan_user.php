<?php
require_once "config/database.php";

$judul = $_POST['judul'];
$usulan = $_POST['usulan'];
$unit = $_POST['unit'];

// Validasi data untuk keamanan
$judul = $mysqli->real_escape_string($judul);
$usulan = $mysqli->real_escape_string($usulan);
$unit = $mysqli->real_escape_string($unit);

// Query untuk menyimpan data ke tabel permohonan_user
$sql = "INSERT INTO permohonan_user (judul_permohonan, usulanby, unit_pemohon) VALUES ('$judul', '$usulan', '$unit')";

$response = [];

if ($mysqli->query($sql) === TRUE) {
    $response['status'] = 'success';
    $response['message'] = 'Data Permohonan Berhasil Ditambahkan!';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error: ' . $mysqli->error;
}

$mysqli->close();

// Set header JSON dan encode respons
header('Content-Type: application/json');
echo json_encode($response);
