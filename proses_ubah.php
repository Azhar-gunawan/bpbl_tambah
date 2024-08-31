<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<?php
require_once "config/database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture and sanitize form inputs
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $userid = isset($_POST['userid']) ? trim($_POST['userid']) : '';
    $nama_lengkap = isset($_POST['nama_lengkap']) ? trim($_POST['nama_lengkap']) : '';
    $role_user = isset($_POST['role_user']) ? trim($_POST['role_user']) : '';
    $kd_lit = isset($_POST['kd_lit']) ? trim($_POST['kd_lit']) : null;
    $kd_instalatir = isset($_POST['kd_instalatir']) ? trim($_POST['kd_instalatir']) : null;
    $kd_upi = isset($_POST['kd_upi']) ? trim($_POST['kd_upi']) : null;
    $kd_area = isset($_POST['kd_area']) ? trim($_POST['kd_area']) : null;
    $kd_ulp = isset($_POST['kd_ulp']) ? trim($_POST['kd_ulp']) : null;

    // Validate required fields
    if ($id && $nama_lengkap && $role_user) {
        $sqlUpdate = "UPDATE app_userid 
                      SET 
                          USERID = ?, 
                          FULLNAME = ?, 
                          ROLE_CODE = ?, 
                          KD_LIT = ?, 
                          KD_INSTALATIR = ?, 
                          KD_UPI = ?, 
                          KD_AREA = ?, 
                          KD_ULP = ? 
                      WHERE 
                          ID = ?";

        if ($stmt = $mysqli->prepare($sqlUpdate)) {
            // Bind parameters to the statement
            $stmt->bind_param('sssssssss', $userid, $nama_lengkap, $role_user, $kd_lit, $kd_instalatir, $kd_upi, $kd_area, $kd_ulp, $id);
            
            // Execute the query
            if ($stmt->execute()) {
                // Success message
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Data user berhasil diubah!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(function() {
                                window.location = 'index.php'; // Redirect to another page
                            });
                        });
                      </script>";
            } else {
                // Error message
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal mengubah data user: " . $stmt->error . "',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                      </script>";
            }
            
            // Close the statement
            $stmt->close();
        } else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal menyiapkan statement: " . $mysqli->error . "',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                  </script>";
        }
    }

    // Close the database connection
    $mysqli->close();
}
?>
