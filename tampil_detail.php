<?php
require_once "config/database.php";

// Jalankan query untuk mengambil semua data dari tabel app_userid
$query = "SELECT USERID, ROLE_CODE, FULLNAME, KD_LIT, KD_INSTALATIR, KD_UPI, KD_AREA, KD_ULP FROM app_userid";
$result = $mysqli->query($query);

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
                <li class="breadcrumb-item"><a href="https://pustakakoding.com/" class="text-dark text-decoration-none"><i class="fa-solid fa-house"></i></a></li>
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

<div class="row flex-lg-row-reverse align-items-center mb-5">
    <!-- Button untuk kembali dan masuk ke halaman entri -->
    <div class="col-lg-4 col-xl-3">
        <a href="<?php echo $back_url; ?>" class="btn btn-primary rounded-pill px-4">&lt; Kembali</a>
        <a href="?halaman=entri" class="btn btn-primary rounded-pill float-lg-end py-2 px-4 mb-4 mb-lg-0">+ Entri User</a>
    </div>
    <div class="col-lg-8 col-xl-9">
        <!-- Form pencarian -->
        <form action="?halaman=pencarian" method="post" class="form-search needs-validation" novalidate>
            <input type="text" name="kata_kunci" class="form-control rounded-pill" placeholder="Cari User..." autocomplete="off" required>
            <div class="invalid-feedback">Masukkan ID atau Nama User yang ingin Anda cari.</div>
        </form>
    </div>
</div>

<div class="row mb-5">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
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
                    $no = 1;
                    while ($data = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<th scope="row">' . $no++ . '</th>';
                        echo '<td>' . htmlspecialchars($data['USERID']) . '</td>';
                        echo '<td>' . htmlspecialchars($data['ROLE_CODE']) . '</td>';
                        echo '<td>' . htmlspecialchars($data['FULLNAME']) . '</td>';
                        echo '<td>' . htmlspecialchars($data['KD_LIT']) . '</td>';
                        echo '<td>' . htmlspecialchars($data['KD_INSTALATIR']) . '</td>';
                        echo '<td>' . htmlspecialchars($data['KD_UPI']) . '</td>';
                        echo '<td>' . htmlspecialchars($data['KD_AREA']) . '</td>';
                        echo '<td>' . htmlspecialchars($data['KD_ULP']) . '</td>';
                        echo '<td>';
                        echo '<a href="proses_ubah.php?id=' . urlencode($data['USERID']) . '" class="btn btn-success btn-sm rounded-pill px-3 me-2 mb-2 mb-lg-0">Ubah</a>';
                        echo '<button type="button" class="btn btn-danger btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalHapus' . htmlspecialchars($data['USERID']) . '">Hapus</button>';
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
</div>

<?php
// Tutup koneksi
$mysqli->close();
?>
