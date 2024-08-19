<?php
// panggil file "database.php" untuk koneksi ke database
require_once "config/database.php";

// mengecek data hasil submit dari form
if (isset($_POST['simpan'])) {
    // ambil data hasil submit dari form
    $id_permohonan      = $mysqli->real_escape_string($_POST['id_permohonan']);
    $judul_permohonan       = $mysqli->real_escape_string($_POST['judul_permohonan']);
    $usulanby         = $mysqli->real_escape_string($_POST['usulanby']);
    $unit_pemohon  = $mysqli->real_escape_string($_POST['unit_pemohon']);

    // mengecek data foto dari form ubah data
    // jika data foto tidak ada (foto tidak diubah)
    if (empty($nama_file)) {
        // sql statement untuk update data di tabel "tbl_siswa" berdasarkan "id_siswa"
        $update = $mysqli->query("UPDATE permohonan_user
                                  SET judul_permohonan='$judul_permohonan', usulanby='$usulanby', unit_pemohon='$unit_pemohon'
                                  WHERE id_permohonan='$id_permohonan'")
                                  or die('Ada kesalahan pada query update : ' . $mysqli->error);
        // cek query
        // jika proses update berhasil
        if ($update) {
            // alihkan ke halaman data siswa dan tampilkan pesan berhasil ubah data
            header('location: index.php?halaman=data&pesan=2');
        }
    }

}
