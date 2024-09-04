<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
<!-- Bootstrap Table CSS -->
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Table JS -->
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
<!-- TableExport and Bootstrap Table Export extensions -->
<script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/export/bootstrap-table-export.min.js"></script>

<?php
require_once "config/database.php";

// Define the number of items per page
$items_per_page = 10;

// Get the current page number from the query string, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Ensure page is at least 1

// Calculate the starting record
$start = ($page - 1) * $items_per_page;

// Get total number of records
$total_query = "SELECT COUNT(*) as total FROM app_userid";
$total_result = $mysqli->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $items_per_page);

// Fetch data for the current page
$query = "SELECT ID, USERID, ROLE_CODE, FULLNAME, KD_LIT, KD_INSTALATIR, KD_UPI, KD_AREA, KD_ULP 
          FROM app_userid 
          LIMIT $start, $items_per_page";
$result = $mysqli->query($query);

if ($result === false) {
    die('Query Error: ' . $mysqli->error); // Debugging line for query errors
}
?>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<div class="d-flex flex-column flex-lg-row mt-5 mb-4">
    <!-- Judul halaman -->
    <div class="flex-grow-1 d-flex align-items-center">
        <i class="fa-regular fa-user icon-title"></i>
        <h3>User</h3>
    </div>
    <div class="ms-5 ms-lg-0 pt-lg-2">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="text-dark text-decoration-none"><i class="fa-solid fa-house"></i></a></li>
                <li class="breadcrumb-item"><a href="?halaman=data" class="text-dark text-decoration-none">Permohonan</a></li>
                <li class="breadcrumb-item active" aria-current="page">User</li>
            </ol>
        </nav>
    </div>
</div>

<?php
// Menangani URL untuk tombol kembali
if (isset($previous_page) && !empty($previous_page)) {
    $back_url = htmlspecialchars($previous_page);
} else {
    $back_url = 'index.php'; // URL default jika $previous_page tidak diset
}
?>

<script>
$(document).ready(function() {
    $('#deleteAllUsers').on('click', function() {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Anda yakin ingin menghapus semua data pengguna?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus Semua',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete_all_users.php',
                    method: 'POST',
                    success: function(response) {
                        const data = JSON.parse(response);
                        if (data.success) {
                            Swal.fire(
                                'Terhapus!',
                                'Semua data pengguna telah dihapus.',
                                'success'
                            ).then(() => {
                                location.reload(); // Refresh the page after deletion
                            });
                        } else {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan: ' + data.error,
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus data.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>

<script>
$(document).ready(function() {
    $('#exportToExcel').on('click', function() {
        window.location.href = 'export_excel.php';
    });
});
</script>



<div class="row align-items-center mb-5">
    <!-- Button for exporting to Excel, deleting all users, and entering a new user -->
    <div class="col-lg-4 col-xl-4 mb-3 mb-lg-0 text-lg-start text-center">
        <button id="exportToExcel" class="btn btn-success btn-sm rounded-pill py-2 px-4 mb-2">
            Export to Excel
        </button>
        <button type="button" class="btn btn-danger btn-sm rounded-pill py-2 px-4 mb-2" data-bs-toggle="modal" data-bs-target="#modalHapusUser" data-userid="' . htmlspecialchars($data['ID']) . '">
            Hapus Semua User
        </button>
    </div>
    <div class="col-lg-8 col-xl-8 text-lg-end text-center">
        <a href="?halaman=entri" class="btn btn-primary rounded-pill py-2 px-4">
            + Entri User
        </a>
    </div>
</div>




<div class="table-responsive">
    <table id="" class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">User ID</th>
                <th scope="col">Role</th>
                <th scope="col">Fullname</th>
                <th scope="col">kd_lit</th>
                <th scope="col">kd_instalatir</th>
                <th scope="col">kd_upi</th>
                <th scope="col">kd_area</th>
                <th scope="col">kd_ulp</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                $no = 0;
                while ($data = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<th scope="row">' . ++$no . '</th>';
                    echo '<td>' . htmlspecialchars($data['USERID']) . '</td>';
                    echo '<td>' . htmlspecialchars($data['ROLE_CODE']) . '</td>';
                    echo '<td>' . htmlspecialchars($data['FULLNAME']) . '</td>';
                    echo '<td>' . htmlspecialchars($data['KD_LIT']) . '</td>';
                    echo '<td>' . htmlspecialchars($data['KD_INSTALATIR']) . '</td>';
                    echo '<td>' . htmlspecialchars($data['KD_UPI']) . '</td>';
                    echo '<td>' . htmlspecialchars($data['KD_AREA']) . '</td>';
                    echo '<td>' . htmlspecialchars($data['KD_ULP']) . '</td>';
                    echo '<td>';
                    echo '<a href="?halaman=ubah&id=' . urlencode($data['ID']) . '" class="btn btn-success btn-sm rounded-pill px-3 me-2 mb-2 mb-lg-0"> Ubah </a>';
                    echo '<button type="button" class="btn btn-danger btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalHapus" data-userid="' . htmlspecialchars($data['ID']) . '">Hapus</button>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="10" class="text-center">Tidak ada data yang tersedia.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>




<!-- Your existing table code -->

<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?halaman=data&page=<?php echo $page - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link">&laquo;</span>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                <a class="page-link" href="?halaman=data&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?halaman=data&page=<?php echo $page + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link">&raquo;</span>
            </li>
        <?php endif; ?>
    </ul>
</nav>



<script>
$(document).ready(function() {
    let deleteUrl = '';

    // Tangani klik tombol hapus
    $('button[data-bs-target^="#modalHapus"]').on('click', function() {
        const userId = $(this).data('userid');
        deleteUrl = 'proses_hapus.php?id=' + userId; // URL untuk menghapus data
        
        // Tampilkan modal konfirmasi
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Anda yakin ingin menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim permintaan penghapusan ke server
                $.ajax({
                    url: deleteUrl,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Terhapus!',
                                'Data telah dihapus.',
                                'success'
                            ).then(() => {
                                location.reload(); // Segarkan halaman setelah penghapusan
                            });
                        } else {
                            Swal.fire(
                                'Gagal!',
                                'Data gagal dihapus.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus data.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>

<script>
$(document).ready(function() {
    let deleteUrl = '';

    // Tangani klik tombol hapus
    $('button[data-bs-target^="#modalHapusUser"]').on('click', function() {
        const userId = $(this).data('userid');
        deleteUrl = 'delete_semua_user.php?id=' + userId; // URL untuk menghapus data
        
        // Tampilkan modal konfirmasi
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Anda yakin ingin menghapus Semua Data User?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim permintaan penghapusan ke server
                $.ajax({
                    url: deleteUrl,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Terhapus!',
                                'Data telah dihapus.',
                                'success'
                            ).then(() => {
                                location.reload(); // Segarkan halaman setelah penghapusan
                            });
                        } else {
                            Swal.fire(
                                'Gagal!',
                                'Data gagal dihapus.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus data.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>

