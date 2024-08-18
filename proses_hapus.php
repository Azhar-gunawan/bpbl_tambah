<?php
// panggil file "database.php" untuk koneksi ke database
require_once "config/database.php";

// mengecek data GET "id_siswa"
if (isset($_GET['id'])) {
    // ambil data GET dari tombol hapus
    $id_permohonan = $mysqli->real_escape_string(trim($_GET['id']));

    // mengecek data foto profil
    // sql statement untuk menampilkan data "foto_profil" dari tabel "tbl_siswa" berdasarkan "id_siswa"
    $query = $mysqli->query("SELECT id_permohonan FROM permohonan_user WHERE id_permohonan='$id_permohonan'")
                             or die('Ada kesalahan pada query tampil data : ' . $mysqli->error);
    // ambil data hasil query
    $data = $query->fetch_assoc();

    // sql statement untuk delete data dari tabel "tbl_siswa" berdasarkan "id_siswa"
    $delete = $mysqli->query("DELETE FROM permohonan_user WHERE id_permohonan='$id_permohonan'")
                              or die('Ada kesalahan pada query delete : ' . $mysqli->error);
    // cek query
    // jika proses delete berhasil
    if ($delete) {
        // alihkan ke halaman data siswa dan tampilkan pesan berhasil hapus data
        header('location: index.php?halaman=data&pesan=3');
    }
}
