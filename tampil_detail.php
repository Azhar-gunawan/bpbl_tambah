<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="d-flex flex-column flex-lg-row mt-5 mb-4">
    <!-- judul halaman -->
    <div class="flex-grow-1 d-flex align-items-center">
        <i class="fa-regular fa-user icon-title"></i>
        <h3>User</h3>
    </div>
    <div class="ms-5 ms-lg-0 pt-lg-2">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="https://pustakakoding.com/" class="text-dark text-decoration-none"><i class="fa-solid fa-house"></i></a></li>
                <li class="breadcrumb-item"><a href="?halaman=data" class="text-dark text-decoration-none">Permohonan</a></li>
                <li class="breadcrumb-item" aria-current="page">User</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row flex-lg-row-reverse align-items-center mb-5">
    <!-- Button untuk masuk ke halaman entri -->
     <div class="col-lg-4 col-xl-3">
     <a href="javascript:history.back()" class="btn btn-primary rounded-pill px-4">< Kembali</a>
     <a href="?halaman=entri" class="btn btn-primary rounded-pill float-lg-end py-2 px-4 mb-4 mb-lg-0">+ Entri User</a>
     </div>
    <div class="col-lg-8 col-xl-9">
        <!-- Form pencarian -->
        <form action="?halaman=pencarian" method="post" class="form-search needs-validation" novalidate>
            <input type="text" name="kata_kunci" class="form-control rounded-pill" placeholder="Cari User..." autocomplete="off" required>
            <div class="invalid-feedback">Masukan ID atau Nama User yang ingin Anda cari.</div>
        </form>
    </div>
</div>

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
    // $query = $mysqli->query("SELECT userid, role_code, kd_lit, kd_instalatir,kd_upi,kd_area,kd_ulp FROM app_userid
    //                          ORDER BY userid DESC LIMIT $batas_awal, $batas")
    //                          or die('Ada kesalahan pada query tampil data : ' . $mysqli->error);
    $query = $mysqli->query("SELECT userid, role_code, kd_lit, kd_instalatir,kd_upi FROM app_userid
                            ORDER BY userid DESC LIMIT $batas_awal, $batas")
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
                        <h5><?php echo $data['userid']; ?> - <?php echo $data['role_code']; ?></h5>
                        <?php if (!empty($data['kd_lit'])) { ?>
                            <p class="text-muted"><?php echo $data['kd_lit']; ?></p>
                        <?php } ?>
                        <p class="text-muted"><?php echo $data['kd_instalatir']; ?></p>
                        <?php if (!empty($data['kd_upi'])) { ?>
                            <p class="text-muted"><?php echo $data['kd_upi']; ?></p>
                        <?php } ?>
                    </div>
                    <div class="p-4">
                        <div class="d-flex flex-column flex-lg-row">
                            <!-- button form ubah data -->
                            <a href="?halaman=ubah&id=<?php echo $data['userid']; ?>" class="btn btn-success btn-sm rounded-pill px-3 me-2 mb-2 mb-lg-0"> Ubah </a>
                            <!-- button modal hapus data -->
                            <button type="button" class="btn btn-danger btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalHapus<?php echo $data['userid']; ?>"> Hapus </button>
                        </div>
                    </div>
                </div>
    
                <!-- Modal hapus data -->
                <div class="modal fade" id="modalHapus<?php echo $data['userid']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
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
                                <p class="fw-bold mb-2"><?php echo $data['userid']; ?> <span class="fw-normal">-</span> <?php echo $data['judul_permohonan']; ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                                <!-- button proses hapus data -->
                                <a href="proses_hapus.php?id=<?php echo $data['userid']; ?>" class="btn btn-danger rounded-pill px-3">Ya, Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } // End of while loop ?>
        
        <!-- pagination and additional content here -->
    
    <?php } else { ?>
        <!-- tampilkan pesan data tidak tersedia -->
        <div>Tidak ada data yang tersedia.</div>
    <?php } ?>
    