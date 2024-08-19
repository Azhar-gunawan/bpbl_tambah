<div class="d-flex flex-column flex-lg-row mt-5 mb-4">
    <!-- judul halaman -->
    <div class="flex-grow-1 d-flex align-items-center">
        <i class="fa-regular fa-user icon-title"></i>
        <h3>Ubah User</h3>
    </div>
    <!-- breadcrumbs -->
    <div class="ms-5 ms-lg-0 pt-lg-2">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="https://pustakakoding.com/" class="text-dark text-decoration-none"><i class="fa-solid fa-house"></i></a></li>
                <li class="breadcrumb-item"><a href="?halaman=data" class="text-dark text-decoration-none">User</a></li>
                <li class="breadcrumb-item" aria-current="page">Ubah</li>
            </ol>
        </nav>
    </div>
</div>

<?php
// mengecek data GET "id_siswa"
if (isset($_GET['id'])) {
    // ambil data GET dari tombol ubah
    $id_permohonan   = $_GET['id'];

    // sql statement untuk menampilkan data dari tabel "tbl_siswa" berdasarkan "id_siswa"
    $query = $mysqli->query("SELECT id_permohonan,judul_permohonan,usulanby,unit_pemohon FROM permohonan_user WHERE id_permohonan='$id_permohonan'")
                             or die('Ada kesalahan pada query tampil data : ' . $mysqli->error);
    // ambil data hasil query
    $data = $query->fetch_assoc();
}
?>

<div class="bg-white rounded-4 shadow-sm p-4 mb-5">
    <!-- judul form -->
    <div class="alert alert-primary rounded-4 mb-5" role="alert">
        <i class="fa-solid fa-pen-to-square me-2"></i> Ubah Data Permohonan
    </div>
    <!-- form ubah data -->
    <form action="proses_ubah.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-xl-6">
            <div class="col-xl-6">
                <div class="mb-3 ps-xl-3">
                <strong><label class="form-label">Id Permohonan <span class="text-danger"></span></label></strong>
                <input type="text" name="id_permohonan" class="form-control" value="<?php echo $data['id_permohonan'];?>"readonly>
                </div>
            </div>
            </div>

            <div class="col-xl-6">
                <div class="mb-3 ps-xl-3">
                <label class="form-label">Judul Permohonan <span class="text-danger">*</span></label>
                <input type="text" name="judul_permohonan" class="form-control" value="<?php echo $data['judul_permohonan']; ?>">
                </div>
            </div>

            <div class="col-xl-6">
                <div class="mb-3 ps-xl-3">
                <label class="form-label">Usulanby <span class="text-danger">*</span></label>
                <input type="text" name="usulanby" class="form-control" value="<?php echo $data['usulanby']; ?>">
                </div>
            </div>

            <div class="col-xl-6">
                <div class="mb-3 ps-xl-3">
                <label class="form-label">Unit Pemohon <span class="text-danger">*</span></label>
                <input type="text" name="unit_pemohon" class="form-control" value="<?php echo $data['unit_pemohon']; ?>">
                </div>
            </div>
            
        </div>
        <div class="pt-4 pb-2 mt-5 border-top">
            <div class="d-grid gap-3 d-sm-flex justify-content-md-start pt-1">
                <!-- button simpan data -->
                <input type="submit" name="simpan" value="Simpan" class="btn btn-primary rounded-pill py-2 px-4">
                <!-- button kembali ke halaman tampil data -->
                <a href="?halaman=data" class="btn btn-secondary rounded-pill py-2 px-4">Batal</a>
            </div>
        </div>
    </form>
</div>