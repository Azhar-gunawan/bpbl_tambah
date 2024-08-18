<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="d-flex flex-column flex-lg-row mt-5 mb-4">
    <!-- judul halaman -->
    <div class="flex-grow-1 d-flex align-items-center">
        <i class="fa-regular fa-user icon-title"></i>
        <h3>Permohonan</h3>
    </div>
    <!-- breadcrumbs -->
    <div class="ms-5 ms-lg-0 pt-lg-2">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="https://pustakakoding.com/" class="text-dark text-decoration-none"><i class="fa-solid fa-house"></i></a></li>
                <li class="breadcrumb-item"><a href="?halaman=data" class="text-dark text-decoration-none">Permohonan</a></li>
                <li class="breadcrumb-item" aria-current="page">Data</li>
            </ol>
        </nav>
    </div>
</div>

<?php 

if (isset($_GET['pesan'])) {
    if ($_GET['pesan'] == 1) {
        // tampilkan pesan sukses simpan data
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Permohonan Berhasil Ditambahkan!",
                    showConfirmButton: true,
                    confirmButtonText: "OK"
                }).then(function() {
                    window.location.href = "index.php?halaman=data";
                });
              </script>';
    } elseif ($_GET['pesan'] == 2) {
        // tampilkan pesan sukses simpan data
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Permohonan Berhasil Diubah!",
                    showConfirmButton: true,
                    confirmButtonText: "OK"
                }).then(function() {
                    window.location.href = "index.php?halaman=data";
                });
              </script>';
    } elseif ($_GET['pesan'] == 3) {
        // tampilkan pesan sukses simpan data
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Permohonan Berhasil Dihapus!",
                    showConfirmButton: true,
                    confirmButtonText: "OK"
                }).then(function() {
                    window.location.href = "index.php?halaman=data";
                });
              </script>';
    }
}
?>
<div class="row flex-lg-row-reverse align-items-center mb-5">
    <!-- button entri data -->
     
    <div class="col-lg-4 col-xl-3">
        <!-- <a href="?halaman=entri" class="btn btn-primary rounded-pill float-lg-end py-2 px-4 mb-4 mb-lg-0">
            <i class="fa-solid fa-plus me-2"></i> Entri Permohonan -->
            <!-- HTML Button to trigger the form -->
            <button id="openFormBtn" class="btn btn-primary">+ Tambah Permohonan Baru</button>
        </a>
    </div>
    <!-- form pencarian -->
    <div class="col-lg-8 col-xl-9">
        <form action="?halaman=pencarian" method="post" class="form-search needs-validation" novalidate>
            <input type="text" name="kata_kunci" class="form-control rounded-pill" placeholder="Cari Permohonan..." autocomplete="off" required>
            <div class="invalid-feedback">Masukan ID atau Nama User yang ingin Anda cari.</div>
        </form>
    </div>
</div>

<script>
document.getElementById('openFormBtn').addEventListener('click', function() {
    Swal.fire({
        title: 'Tambah Permohonan Baru',
        html: `
            <input type="text" id="judul" class="swal2-input" placeholder="Judul Permohonan">
            <input type="text" id="usulan" class="swal2-input" placeholder="Usulan By">
            <input type="text" id="unit" class="swal2-input" placeholder="Unit Pemohon">
        `,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        showCancelButton: true,
        focusConfirm: false,
        preConfirm: () => {
            const judul = document.getElementById('judul').value;
            const usulan = document.getElementById('usulan').value;
            const unit = document.getElementById('unit').value;
            
            if (!judul || !usulan || !unit) {
                Swal.showValidationMessage('Mohon Isi Semua Kolom!');
                return false;
            }

            return { judul: judul, usulan: usulan, unit: unit };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const { judul, usulan, unit } = result.value;

            // Kirim data ke server melalui AJAX
            $.ajax({
                url: 'permohonan_user.php', // File PHP untuk menangani data
                type: 'POST',
                data: {
                    judul: judul,
                    usulan: usulan,
                    unit: unit
                },
                dataType: 'json', // Respons diharapkan dalam bentuk JSON
                success: function(response) {
                    console.log('Server Response:', response);
                    
                    // Periksa status respons
                    if (response.status === 'success') {
                        Swal.fire('Saved!', response.message, 'success');
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    Swal.fire('Error!', 'Gagal menyimpan data.', 'error');
                }
            });
        }
    });
});
</script>

<div class="row mb-5">
    <?php
    /* 
        membatasi jumlah data yang ditampilkan dari database untuk membuat pagination/paginasi
    */
    // cek data "paginasi" pada URL untuk mengetahui paginasi halaman aktif
    // jika data "paginasi" ada, maka paginasi halaman = data "paginasi". jika data "paginasi" tidak ada, maka paginasi halaman = 1
    $paginasi_halaman = (isset($_GET['paginasi'])) ? (int) $_GET['paginasi'] : 1;
    // tentukan jumlah data yang ditampilkan per paginasi halaman
    $batas = 10;
    // tentukan dari data ke berapa yang akan ditampilkan pada paginasi halaman
    $batas_awal = ($paginasi_halaman - 1) * $batas;

    // sql statement untuk menampilkan data dari tabel "tbl_siswa"
    $query = $mysqli->query("SELECT id_permohonan, judul_permohonan, usulanby, unit_pemohon FROM permohonan_user
                             ORDER BY id_permohonan DESC LIMIT $batas_awal, $batas")
                             or die('Ada kesalahan pada query tampil data : ' . $mysqli->error);
    // ambil jumlah data hasil query
    $rows = $query->num_rows;

    // cek hasil query
    // jika data siswa ada
    if ($rows <> 0) {
        // ambil data hasil query
        while ($data = $query->fetch_assoc()) { ?>
            <!-- tampilkan data -->
            <div class="p-2">
                <div class="d-flex bg-white rounded-4 shadow-sm">
                    <div class="p-4 flex-grow-1">
                        <h5><?php echo $data['id_permohonan']; ?> - <?php echo $data['judul_permohonan']; ?></h5>
                        <p class="text-muted"><?php echo $data['unit_pemohon']; ?></p>
                    </div>
                    <div class="p-4">
                        <div class="d-flex flex-column flex-lg-row">
                            <!-- button form detail data -->
                            <a href="?halaman=detail&id=<?php echo $data['id_permohonan']; ?>" class="btn btn-primary btn-sm rounded-pill px-3 me-2 mb-2 mb-lg-0"> Detail </a>
                            <!-- button form ubah data -->
                            <a href="?halaman=ubah&id=<?php echo $data['id_permohonan']; ?>" class="btn btn-success btn-sm rounded-pill px-3 me-2 mb-2 mb-lg-0"> Ubah </a>
                            <!-- button modal hapus data -->
                            <button type="button" class="btn btn-danger btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalHapus<?php echo $data['id_permohonan']; ?>"> Hapus </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal hapus data -->
            <div class="modal fade" id="modalHapus<?php echo $data['id_permohonan']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                <i class="fa-regular fa-trash-can me-2"></i> Hapus Data Permohonan
                            </h1>
                        </div>
                        <div class="modal-body">
                            <p class="mb-2">Anda yakin ingin menghapus data Permohonan?</p>
                            <!-- informasi data yang akan dihapus -->
                            <p class="fw-bold mb-2"><?php echo $data['id_permohonan']; ?> <span class="fw-normal">-</span> <?php echo $data['judul_permohonan']; ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                            <!-- button proses hapus data -->
                            <a href="proses_hapus.php?id=<?php echo $data['id_permohonan']; ?>" class="btn btn-danger rounded-pill px-3">Ya, Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="d-flex flex-column flex-xl-row align-items-center mt-4">
            <!-- menampilkan informasi jumlah paginasi halaman dan jumlah data -->
            <div class="flex-grow-1 text-center text-xl-start text-muted mb-3">
                <?php
                // sql statement untuk menampilkan jumlah data pada tabel "tbl_siswa"
                $query = $mysqli->query("SELECT id_permohonan FROM permohonan_user")
                                         or die('Ada kesalahan pada query jumlah data : ' . mysqli_error($mysqli));
                // ambil jumlah data dari hasil query
                $jumlah_data = $query->num_rows;

                // hitung jumlah paginasi halaman yang tersedia
                $jumlah_paginasi_halaman = ceil($jumlah_data / $batas);

                // cek jumlah data
                // jika data ada
                if ($jumlah_data <> 0) {
                    // tampilkan informasi paginasi halaman aktif dan jumlah paginasi halaman
                    echo "Halaman $paginasi_halaman dari $jumlah_paginasi_halaman";
                }
                ?>

                <span class="mx-2">|</span>

                <?php
                // ambil data awal yang ditampilkan per paginasi halaman
                /* 
                    jika "jumlah_paginasi_halaman" <> "0", maka "data_awal" = "batas_awal" + 1.
                    jika "jumlah_paginasi_halaman" == "0", maka "data_awal" = "batas_awal". 
                */
                $data_awal = ($jumlah_paginasi_halaman <> 0) ? $batas_awal + 1 : $batas_awal;

                // sql statement untuk menampilkan jumlah data pada tabel "tbl_siswa" yang ditampilkan per halaman
                $query = $mysqli->query("SELECT id_permohonan FROM permohonan_user LIMIT $data_awal, $batas")
                                         or die('Ada kesalahan pada query jumlah data per halaman : ' . mysqli_error($mysqli));
                // ambil jumlah data dari hasil query
                $jumlah_data_per_paginasi_halaman = $query->num_rows;

                // ambil data akhir yang ditampilkan per paginasi halaman
                /* 
                    jika "jumlah_data_per_paginasi_halaman" < "batas", maka "data_akhir" = "data_awal" + "jumlah_data_per_paginasi_halaman".
                    jika "jumlah_data_per_paginasi_halaman" >= "batas", maka "data_akhir" = "batas_awal" + "jumlah_data_per_paginasi_halaman". 
                */
                $data_akhir = ($jumlah_data_per_paginasi_halaman < $batas) ? $data_awal + $jumlah_data_per_paginasi_halaman : $batas_awal + $jumlah_data_per_paginasi_halaman;
                ?>
                <!-- tampilkan informasi jumlah data -->
                Menampilkan <?php echo $data_awal; ?> sampai <?php echo $data_akhir; ?> dari <?php echo $jumlah_data; ?> data
            </div>

            <!-- membuat pagination -->
            <ul class="pagination justify-content-center">
                <!-- button link "<" -->
                <?php
                // jika paginasi halaman <= 1, maka button link "<" tidak aktif
                if ($paginasi_halaman <= '1') { ?>
                    <li class="page-item pagination-pill disabled">
                        <a class="page-link" aria-label="Previous">
                            <i class="fa-solid fa-angle-left"></i>
                        </a>
                    </li>
                <?php
                }
                // jika paginasi halaman > 1, maka button link "<" aktif
                else { ?>
                    <li class="page-item pagination-pill">
                        <a class="page-link" href="?paginasi=<?php echo $paginasi_halaman - 1; ?>" aria-label="Previous">
                            <i class="fa-solid fa-angle-left"></i>
                        </a>
                    </li>
                <?php } ?>

                <!-- button link nomor -->
                <?php
                // tentukan jumlah button link nomor yang ditampilkan sebelum dan sesudah link yang aktif
                $jumlah_button = 3;

                // tentukan nilai awal dan nilai akhir yang akan digunakan pada perulangan untuk menampilkan button link nomor
                /* 
                    jika "paginasi_halaman" > "jumlah_button", maka "nomor_awal" = "paginasi_halaman" - "jumlah_button".
                    jika "paginasi_halaman" <= "jumlah_button", maka "nomor_awal" = 1.
                */
                $nomor_awal = ($paginasi_halaman > $jumlah_button) ? $paginasi_halaman - $jumlah_button : 1;

                /* 
                    jika "paginasi_halaman" < ("jumlah_paginasi_halaman" - "jumlah_button"), maka "nomor_akhir" = "paginasi_halaman" + "jumlah_button".
                    jika "paginasi_halaman" >= ("jumlah_paginasi_halaman" - "jumlah_button"), maka "nomor_akhir" = "jumlah_paginasi_halaman". 
                */
                $nomor_akhir = ($paginasi_halaman < ($jumlah_paginasi_halaman - $jumlah_button)) ? $paginasi_halaman + $jumlah_button : $jumlah_paginasi_halaman;

                // lakukan perulangan untuk menampilkan button link nomor sesuai jumlah paginasi halaman
                for ($x = $nomor_awal; $x <= $nomor_akhir; $x++) {
                    // membuat link aktif
                    /* 
                        jika "halaman" sama dengan link aktif, maka tambahkan css class "active"
                        jika "halaman" tidak sama dengan link aktif, maka hilangkan css class "active" 
                    */
                    $link_active = ($paginasi_halaman == $x) ? 'active' : '';
                ?>
                    <li class="page-item pagination-pill <?php echo $link_active; ?>">
                        <a class="page-link" href="?paginasi=<?php echo $x; ?>"><?php echo $x; ?></a>
                    </li>
                <?php } ?>

                <!-- button link ">" -->
                <?php
                // jika "paginasi_halaman" >= "jumlah_paginasi_halaman", maka button link ">" tidak aktif 
                if ($paginasi_halaman >= $jumlah_paginasi_halaman) { ?>
                    <li class="page-item pagination-pill disabled">
                        <a class="page-link" aria-label="Next">
                            <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </li>
                <?php
                }
                // jika "paginasi_halaman" < "jumlah_paginasi_halaman", maka button link ">" aktif
                else { ?>
                    <li class="page-item pagination-pill">
                        <a class="page-link" href="?paginasi=<?php echo $paginasi_halaman + 1; ?>" aria-label="Next">
                            <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php
    }
    // jika data siswa tidak ada
    else { ?>
        <!-- tampilkan pesan data tidak tersedia -->
        <div>Tidak ada data yang tersedia.</div>
    <?php } ?>
</div>
