<?php 
require_once "config/database.php";

// Query to get UPI options
$queryUpi = "SELECT DISTINCT kd_dist AS unitupi, nama_dist AS namaupi FROM master_unit_ap2t ORDER BY unitupi";
$resultUpi = $mysqli->query($queryUpi);
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="d-flex flex-column flex-lg-row mt-5 mb-4">
    <!-- judul halaman -->
    <div class="flex-grow-1 d-flex align-items-center">
        <i class="fa-regular fa-user icon-title"></i>
        <h3>Entri User</h3>
    </div>
    <!-- breadcrumbs -->
    <div class="ms-5 ms-lg-0 pt-lg-2">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="https://pustakakoding.com/" class="text-dark text-decoration-none">
                        <i class="fa-solid fa-house"></i>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="?halaman=data" class="text-dark text-decoration-none">Permohonan</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Entri User</li>
            </ol>
        </nav>
    </div>
</div>

<div class="bg-white rounded-4 shadow-sm p-4 mb-5">
    <!-- judul form -->
    <div class="alert alert-primary rounded-4 mb-5" role="alert">
        <i class="fa-solid fa-pen-to-square me-2"></i> Entri User Permohonan
    </div>

    <!-- form entri data -->
    <form action="proses_simpan.php" method="POST" class="needs-validation" novalidate>
        <div class="row">
            <!-- User ID -->
            <div class="col-xl-6">
                <div class="mb-3 pe-xl-3">
                    <label class="form-label">User ID<span class="text-danger">*</span></label>
                    <input type="text" name="userid" class="form-control" autocomplete="off" >
                    <div class="invalid-feedback">User ID Tidak Boleh Kosong.</div>
                </div>
            </div>

            <!-- Nama Lengkap -->
            <div class="col-xl-6">
                <div class="mb-3 ps-xl-3">
                    <label class="form-label">Nama Lengkap<span class="text-danger">*</span></label>
                    <input type="text" name="fullname" class="form-control" autocomplete="off" >
                    <div class="invalid-feedback">Nama Lengkap Tidak Boleh Kosong.</div>
                </div>
            </div>
        </div>

        <hr class="mb-4-2">

        <div class="row">
            <!-- Role User -->
            <div class="col-xl-6">
                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Role User<span class="text-danger">*</span></label>
                    <select name="role_code" class="form-control" autocomplete="off" >
                        <option selected disabled value="">Pilih Role Code</option>
                        <option value="UPI">PLN UPI</option>
                        <option value="PLN">PLN PUSAT</option>
                        <option value="SUM">Survey Mobile</option>
                        <option value="ADM">Administrator</option>
                        <option value="WIN">Instalatir Web</option>
                        <option value="LIT">LIT</option>
                        <option value="INS">Petugas Instalatir</option>
                        <option value="GM">GM PLN</option>
                        <option value="ULP">PLN ULP</option>
                        <option value="UP3">PLN UP3</option>
                        <option value="DJK">DJK</option>
                    </select>
                    <div class="invalid-feedback">Role User Wajib Dipilih</div>
                </div>
            </div>

            <!-- Kd Lit -->
            <?php
            $sqlLit = "SELECT uid_badan_usaha, nama_badan_usaha FROM master_lit";
            $resultLit = $mysqli->query($sqlLit);
            ?>
            <div class="col-xl-6">
                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Kd Lit<span class="text-danger">*</span></label>
                    <select name="kd_lit" class="form-select" autocomplete="off" >
                        <option selected disabled value="">Pilih Kd Lit</option>
                        <?php
                        if ($resultLit->num_rows > 0) {
                            while ($rowLit = $resultLit->fetch_assoc()) {
                                $optionText = htmlspecialchars($rowLit["uid_badan_usaha"]) . " - " . htmlspecialchars($rowLit["nama_badan_usaha"]);
                                echo "<option value='" . htmlspecialchars($rowLit["uid_badan_usaha"]) . "'>" . $optionText . "</option>";
                            }
                        } else {
                            echo "<option disabled>No data available</option>";
                        }
                        ?>
                    </select>
                    <div class="invalid-feedback">Kd Lit Tidak Boleh Kosong.</div>
                </div>
            </div>

            <!-- Kd Instalatir -->
            <div class="col-xl-6">
                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Kd Instalatir<span class="text-danger">*</span></label>
                    <input type="text" name="kd_instalatir" class="form-control" autocomplete="off" >
                    <div class="invalid-feedback">Kd Instalatir Tidak Boleh Kosong.</div>
                </div>
            </div>

            <!-- Kd Upi -->
            <?php
            $sqlUpi = "SELECT DISTINCT kd_dist, nama_dist FROM master_unit_ap2t ORDER BY kd_dist";
            $resultUpi = $mysqli->query($sqlUpi);
            ?>
            <div class="col-xl-6">
                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Kd Upi<span class="text-danger">*</span></label>
                    <select name="kd_upi" id="kd_upi" class="form-select" autocomplete="off" >
                        <option selected disabled value="">Pilih Kd Upi</option>
                        <?php
                        if ($resultUpi->num_rows > 0) {
                            while ($rowUpi = $resultUpi->fetch_assoc()) {
                                $optionText = htmlspecialchars($rowUpi["kd_dist"]) . " - " . htmlspecialchars($rowUpi["nama_dist"]);
                                echo "<option value='" . htmlspecialchars($rowUpi["kd_dist"]) . "'>" . $optionText . "</option>";
                            }
                        } else {
                            echo "<option disabled>No data available</option>";
                        }
                        ?>
                    </select>
                    <div class="invalid-feedback">Kd Upi Tidak Boleh Kosong.</div>
                </div>
            </div>

            <!-- Kd Area -->
            <div class="col-xl-6">
                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Kd Area<span class="text-danger">*</span></label>
                    <select name="kd_area" id="kd_area" class="form-select" autocomplete="off" >
                        <option selected disabled value="">Pilih Kd Area</option>
                    </select>
                    <div class="invalid-feedback">Kd Area Tidak Boleh Kosong.</div>
                </div>
            </div>

            <!-- Kd Ulp -->
            <div class="col-xl-6">
                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Kd Ulp<span class="text-danger">*</span></label>
                    <select name="kd_ulp" class="form-select" id="kd_ulp" autocomplete="off" >
                         <option selected disabled value="">Pilih Kd Ulp</option>
                    </select>
                    <div class="invalid-feedback">Kd Ulp Tidak Boleh Kosong.</div>
                </div>
            </div>
        </div>

        <div class="pt-4 pb-2 mt-5 border-top">
            <div class="d-grid gap-3 d-sm-flex justify-content-md-start pt-1">
                <!-- Button Kembali -->
                <a href="javascript:void(0);" class="btn btn-danger rounded-pill py-2 px-4" onclick="history.back();">Kembali</a>
                <!-- Button Simpan Data -->
                <input type="submit" name="simpan" value="Simpan" class="btn btn-primary rounded-pill py-2 px-4">
                <!-- Button Batal -->
                <a href="?halaman=data" class="btn btn-secondary rounded-pill py-2 px-4" onclick="return confirmBatal()">Batal</a>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('kd_upi').addEventListener('change', function() {
    var selectedUpi = this.value;
    
    // Fetch and populate the KD_AREA dropdown
    fetch('get_area.php?kd_upi=' + encodeURIComponent(selectedUpi))
        .then(response => response.json())
        .then(data => {
            var kdAreaSelect = document.getElementById('kd_area');
            kdAreaSelect.innerHTML = '<option selected disabled value="">Pilih Kd Area</option>'; // Reset options

            if (data.length > 0) {
                data.forEach(area => {
                    var option = document.createElement('option');
                    option.value = area.unitap_ap2t;
                    option.textContent = area.unitap_ap2t + ' - ' + area.nama_area;
                    kdAreaSelect.appendChild(option);
                });
            } else {
                var option = document.createElement('option');
                option.textContent = 'Tidak ada data';
                kdAreaSelect.appendChild(option);
            }
        })
        .catch(error => console.error('Error fetching area data:', error));
});

document.getElementById('kd_area').addEventListener('change', function() {
    var selectedArea = this.value;
    
    // Fetch and populate the KD_ULP dropdown
    fetch('get_ulp.php?kd_area=' + encodeURIComponent(selectedArea))
        .then(response => response.json())
        .then(data => {
            var kdUlpSelect = document.getElementById('kd_ulp');
            kdUlpSelect.innerHTML = '<option selected disabled value="">Pilih Kd Ulp</option>'; // Reset options

            if (data.length > 0) {
                data.forEach(ulp => {
                    var option = document.createElement('option');
                    option.value = ulp.unitup;
                    option.textContent = ulp.unitup + ' - ' + ulp.nama_unit;
                    kdUlpSelect.appendChild(option);
                });
            } else {
                var option = document.createElement('option');
                option.textContent = 'Tidak ada data';
                kdUlpSelect.appendChild(option);
            }
        })
        .catch(error => console.error('Error fetching ulp data:', error));
});


function confirmBatal() {
    Swal.fire({
        title: 'Apakah Anda yakin ingin membatalkan?',
        text: "Data Yang Sudah Di isi Akan Di Reset",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, batalkan!',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "?halaman=entri";
        }
    });
    return false; 
}
</script>
