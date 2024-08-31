<?php 
require_once "config/database.php";

// Query to get UPI options
$queryUpi = "SELECT DISTINCT kd_dist AS unitupi, nama_dist AS namaupi FROM master_unit_ap2t ORDER BY unitupi";
$resultUpi = $mysqli->query($queryUpi);

if (isset($_GET['id'])) {
    $id_user = $mysqli->real_escape_string($_GET['id']);

    // Correct SQL query to use $id_user
    $query = $mysqli->query("SELECT * FROM app_userid WHERE id='$id_user'")
                     or die('Ada kesalahan pada query tampil data: ' . $mysqli->error);
    
    // Fetch data from query
    $data = $query->fetch_assoc();
} else {
    // Default value or error handling if 'id' is not set
    $data = [];
}

?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="d-flex flex-column flex-lg-row mt-5 mb-4">
    <!-- judul halaman -->
    <div class="flex-grow-1 d-flex align-items-center">
        <i class="fa-regular fa-user icon-title"></i>
        <h3>Ubah Data User</h3>
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
                <li class="breadcrumb-item" aria-current="page">Ubah Data User</li>
            </ol>
        </nav>
    </div>
</div>

<div class="bg-white rounded-4 shadow-sm p-4 mb-5">
    <!-- judul form -->
    <div class="alert alert-primary rounded-4 mb-5" role="alert">
        <i class="fa-solid fa-pen-to-square me-2"></i> Ubah Data User
    </div>

    <!-- form entri data -->
    <form action="proses_ubah.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="row">
            <!-- User ID -->

            <div class="col-xl-6">
                <div class="mb-3 pe-xl-3">
                    <label class="form-label">ID<span class="text-danger"></span></label>
                    <input type="text" value="<?php echo isset($data['ID']) ? htmlspecialchars($data['ID']) : ''; ?>" name="id" class="form-control" autocomplete="off" readonly>
                    <div class="invalid-feedback">User ID Tidak Boleh Kosong.</div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="mb-3 pe-xl-3">
                    <label class="form-label">User ID<span class="text-danger"></span></label>
                    <input type="text" value="<?php echo isset($data['USERID']) ? htmlspecialchars($data['USERID']) : ''; ?>" name="userid" class="form-control" autocomplete="off" >
                    <div class="invalid-feedback">User ID Tidak Boleh Kosong.</div>
                </div>
            </div>

            <!-- Nama Lengkap -->
            <div class="col-xl-6">
                <div class="mb-3 ps-xl-3">
                    <label class="form-label">Nama Lengkap<span class="text-danger"></span></label>
                    <input type="text" value="<?php echo isset($data['FULLNAME']) ? htmlspecialchars($data['FULLNAME']) : ''; ?>" name="nama_lengkap" class="form-control" autocomplete="off" >
                    <div class="invalid-feedback">Nama Lengkap Tidak Boleh Kosong.</div>
                </div>
            </div>
        </div>

        <hr class="mb-4-2">

        <div class="row">
            <!-- Role User -->
            <div class="col-xl-6">
                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Role User<span class="text-danger"></span></label>
                    <select name="role_user" class="form-select" autocomplete="off" >
                        <option selected disabled value="">Pilih Role User</option>
                        <?php 
                        $roles = ["UPI", "PLN", "SUM", "ADM", "WIN", "LIT", "INS", "GM", "ULP", "UP3", "DJK"];
                        foreach ($roles as $role) {
                            $selected = (isset($data['ROLE_CODE']) && $data['ROLE_CODE'] === $role) ? 'selected' : '';
                            echo "<option value='$role' $selected>$role</option>";
                        }
                        ?>
                    </select>
                    <div class="invalid-feedback">Role User Wajib Dipilih</div>
                </div>
            </div>

            <!-- Kd Lit -->
            <div class="col-xl-6">
                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Kd Lit<span class="text-danger"></span></label>
                    <select name="kd_lit" class="form-select" autocomplete="off" >
                        <option selected value="">Pilih Kd Lit</option>
                        <?php
                        $sqlLit = "SELECT uid_badan_usaha, nama_badan_usaha FROM master_lit";
                        $resultLit = $mysqli->query($sqlLit);
                        if ($resultLit->num_rows > 0) {
                            while ($rowLit = $resultLit->fetch_assoc()) {
                                $selected = (isset($data['KD_LIT']) && $data['KD_LIT'] == $rowLit["uid_badan_usaha"]) ? 'selected' : '';
                                echo "<option value='" . htmlspecialchars($rowLit["uid_badan_usaha"]) . "' $selected>" . htmlspecialchars($rowLit["uid_badan_usaha"]) . " - " . htmlspecialchars($rowLit["nama_badan_usaha"]) . "</option>";
                            }
                        } else {
                            echo "<option value=''>asdsd</option>";
                        }
                        ?>
                    </select>
                    <div class="invalid-feedback">Kd Lit Tidak Boleh Kosong.</div>
                </div>
            </div>

            <!-- Kd Instalatir -->
            <div class="col-xl-6">
                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Kd Instalatir<span class="text-danger"></span></label>
                    <input type="text" value="<?php echo isset($data['KD_INSTALATIR']) ? htmlspecialchars($data['KD_INSTALATIR']) : ''; ?>" name="kd_instalatir" class="form-control" autocomplete="off" >
                    <div class="invalid-feedback">Kd Instalatir Tidak Boleh Kosong.</div>
                </div>
            </div>

            <!-- Kd Upi -->
            <div class="col-xl-6">
    <div class="mb-3 pe-xl-3">
        <label class="form-label">Kd Upi<span class="text-danger"></span></label>
        <select name="kd_upi" id="kd_upi" class="form-select" autocomplete="off">
            <!-- Default Option -->
            <option value="" disabled <?php echo !isset($data['KD_UPI']) ? 'selected' : ''; ?>>Pilih Kd Upi</option>
            
            <?php
            $sqlUpi = "SELECT DISTINCT kd_dist, nama_dist FROM master_unit_ap2t ORDER BY kd_dist";
            $resultUpi = $mysqli->query($sqlUpi);
            
            if ($resultUpi->num_rows > 0) {
                while ($rowUpi = $resultUpi->fetch_assoc()) {
                    $selected = (isset($data['KD_UPI']) && $data['KD_UPI'] == $rowUpi["kd_dist"]) ? 'selected' : '';
                    $optionText = htmlspecialchars($rowUpi["kd_dist"]) . " - " . htmlspecialchars($rowUpi["nama_dist"]);
                    echo "<option value='" . htmlspecialchars($rowUpi["kd_dist"]) . "' $selected>" . $optionText . "</option>";
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
        <label class="form-label">Kd Area<span class="text-danger"></span></label>
        <select name="kd_area" id="kd_area" class="form-select" autocomplete="off">
            <!-- Default Option -->
            <option value="" disabled <?php echo !isset($data['KD_AREA']) ? 'selected' : ''; ?>>Pilih Kd Area</option>
            
            <!-- Options will be populated here via JavaScript -->
        </select>
        <div class="invalid-feedback">Kd Area Tidak Boleh Kosong.</div>
    </div>
</div>


           <!-- Kd Ulp -->
<div class="col-xl-6">
    <div class="mb-3 pe-xl-3">
        <label class="form-label">Kd Ulp<span class="text-danger"></span></label>
        <select name="kd_ulp" id="kd_ulp" class="form-select" autocomplete="off">
            <option value="" disabled <?php echo !isset($data['KD_ULP']) ? 'selected' : ''; ?>>Silahkan isi kd upi Baru terlebih dahulu untuk merubah ULP</option>
            <!-- Options will be populated here via JavaScript -->
        </select>
        <div class="invalid-feedback">Kd Ulp Tidak Boleh Kosong.</div>
    </div>
</div>


        <hr class="mb-4-2">
        
        <input type="hidden" name="id_user" value="<?php echo isset($data['USERID']) ? htmlspecialchars($data['USERID']) : ''; ?>">

        <div class="d-grid gap-2 d-md-block text-end">
            <button class="btn btn-primary me-2" type="submit">Simpan</button>
            <a href="javascript:void(0);" class="btn btn-danger me-2" onclick="history.back();">Kembali</a>
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
            kdAreaSelect.innerHTML = '<option value="" disabled>Pilih Kd Area</option>'; // Reset options

            if (data.length > 0) {
                data.forEach(area => {
                    var option = document.createElement('option');
                    option.value = area.unitap_ap2t;
                    option.textContent = area.unitap_ap2t + ' - ' + area.nama_area;
                    kdAreaSelect.appendChild(option);
                });

                // Set previously selected value if available
                var previousKdArea = "<?php echo isset($data['KD_AREA']) ? htmlspecialchars($data['KD_AREA']) : ''; ?>";
                if (previousKdArea) {
                    kdAreaSelect.value = previousKdArea;
                }
            } else {
                var option = document.createElement('option');
                option.textContent = 'Tidak ada data';
                kdAreaSelect.appendChild(option);
            }
        })
        .catch(error => console.error('Error fetching area data:', error));
});

// Optionally, trigger the change event if Kd Upi is already set on page load
document.addEventListener('DOMContentLoaded', function() {
    var initialUpi = document.getElementById('kd_upi').value;
    if (initialUpi) {
        document.getElementById('kd_upi').dispatchEvent(new Event('change'));
    }
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
</script>
