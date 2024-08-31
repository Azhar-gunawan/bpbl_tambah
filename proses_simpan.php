<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
// panggil file "database.php" untuk koneksi ke database
require_once "config/database.php";

// mengecek data hasil submit dari form
if (isset($_POST['simpan'])) {
    // ambil data hasil submit dari form
    $userid             = $mysqli->real_escape_string($_POST['userid']);
    $rolecode           = $mysqli->real_escape_string($_POST['role_code']);
    $fullname           = $mysqli->real_escape_string($_POST['fullname']);
    $password           = 'S79zVhAaYdV0bnTMuwu4Dw';
    $active             = '1';
    $date_active        = '23/01/2024  00:00:00';
    $date_deactive      = '28/12/2024  00:00:00';
    $date_expire        = '28/12/2024  00:00:00';
    $kd_lit             = $mysqli->real_escape_string($_POST['kd_lit']);
    $kd_instalatir      = $mysqli->real_escape_string($_POST['kd_instalatir']);
    $kd_upi             = $mysqli->real_escape_string($_POST['kd_upi']);
    $kd_area            = $mysqli->real_escape_string($_POST['kd_area']);
    $kd_ulp             = $mysqli->real_escape_string($_POST['kd_ulp']);

    // sql statement untuk insert data ke tabel "app_userid"
    $insert = $mysqli->query("INSERT INTO app_userid(userid, role_code, fullname, 
                                  password, active, date_active, date_deactive, date_expire,kd_lit,kd_instalatir,kd_upi,kd_area,kd_ulp) 
                                  VALUES('$userid','$rolecode', '$fullname', '$password', '$active', '$date_active', 
                                  '$date_deactive', '$date_expire', '$kd_lit','$kd_instalatir','$kd_upi','$kd_area','$kd_ulp')")
                                  or die('Ada kesalahan pada query insert : ' . $mysqli->error);
    
    // cek query
    // jika proses insert berhasil
    if ($insert==1) {
        echo "
        <script>
            Swal.fire({
                title: 'Success!',
                text: 'Data berhasil ditambahkan.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php?halaman=data';
                }
            });
        </script>";
    } elseif($insert==2){
        echo "
        <script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Data Gagal ditambahkan.',
                icon: 'failed',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php?halaman=data';
                }
            });
        </script>";
    }
}
?>
