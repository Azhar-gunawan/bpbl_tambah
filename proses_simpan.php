<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
require_once "config/database.php";
    $userid             = $mysqli->real_escape_string($_POST['userid']);
    $rolecode           = $mysqli->real_escape_string($_POST['role_code']);
    $fullname           = $mysqli->real_escape_string($_POST['fullname']);
    $password           = 'S79zVhAaYdV0bnTMuwu4Dw';
    $active             = '1';
    $date_active        = '23/01/2024  00:00:00';
    $date_deactive      = '28/12/2024  00:00:00';
    $date_expire        = '28/12/2024  00:00:00';
    $kd_lit = isset($_POST['kd_lit']) ? $mysqli->real_escape_string($_POST['kd_lit']) : null;
    $kd_instalatir = isset($_POST['kd_instalatir']) ? $mysqli->real_escape_string($_POST['kd_instalatir']) : null;
    $kd_upi = isset($_POST['kd_upi']) ? $mysqli->real_escape_string($_POST['kd_upi']) : null;
    $kd_area = isset($_POST['kd_area']) ? $mysqli->real_escape_string($_POST['kd_area']) : null;
    $kd_ulp = isset($_POST['kd_ulp']) ? $mysqli->real_escape_string($_POST['kd_ulp']) : null;

    // Insert data into app_userid table
    $insert_user = $mysqli->query("INSERT INTO app_userid(userid, role_code, fullname, 
                                  password, active, date_active, date_deactive, date_expire, kd_lit, kd_instalatir, kd_upi, kd_area, kd_ulp) 
                                  VALUES('$userid', '$rolecode', '$fullname', '$password', '$active', '$date_active', 
                                  '$date_deactive', '$date_expire', '$kd_lit', '$kd_instalatir', '$kd_upi', '$kd_area', '$kd_ulp')");

    // Check if insert was successful
    $success = false;
    if ($insert_user) {
        // Check if role is "SUM" and perform additional insert into MASTER_PETUGAS_SURVEY
        if ($rolecode === 'SUM') {
            $insert_survey = $mysqli->query("INSERT INTO MASTER_PETUGAS_SURVEY(nip_petugas, nama_petugas, 
                                             unitupi, unitap, unitup) 
                                             VALUES('$kd_ulp', '$fullname', '$kd_upi', '$kd_area', '$kd_ulp')");
            
            if (!$insert_survey) {
                $error_message = "Error inserting into MASTER_PETUGAS_SURVEY: " . $mysqli->error;
            } else {
                $success = true;
            }
        } else {
            $success = true;
        }
    } else {
        $error_message = "Error inserting into app_userid: " . $mysqli->error;
    }

?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    <?php if (isset($success)): ?>
        var success = <?php echo json_encode($success); ?>;
        if (success) {
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
        } else {
            Swal.fire({
                title: 'Gagal!',
                text: 'Data gagal ditambahkan. Error: ' + <?php echo json_encode($error_message ?? ''); ?>,
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php?halaman=data';
                }
            });
        }
    <?php endif; ?>
});
</script>
