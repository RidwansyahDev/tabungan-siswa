<?php
session_start();
ob_start();
include "../config/app.php";

if (!$_SESSION['login']) {
    header('Location: '.BASE_URL.'/auth/login.php');
}

$judul = "Data Kelas";
include "../templates/header.php";

// Pastikan ID dalam bentuk integer untuk menghindari SQL Injection
$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

// Ambil Data dari tabel rekening_tabungan
$query = mysqli_query($conn, "SELECT * FROM rekening_tabungan JOIN siswa ON rekening_tabungan.id_siswa = siswa.id_siswa WHERE id=$id");

while ($row = mysqli_fetch_assoc($query)){
    $id_rek = $row['id'];
    $id_rekening = $row['id_rekening'];
    $nama_siswa = $row['nama'];
    $saldo = $row['saldo'];
}

// Proses update data
if (isset($_POST['update'])) {
    $idRek = mysqli_real_escape_string($conn, $_POST['id']); // Escape input
    $status = mysqli_real_escape_string($conn, $_POST['status']); // Escape input

    // Query update
    $query = "UPDATE rekening_tabungan SET status = '$status' WHERE id = '$idRek'";
    if (mysqli_query($conn, $query)) {
        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['berhasil'] = "Data rekening berhasil diubah";
        } else {
            $_SESSION['validasi'] = "Tidak ada perubahan data";
        }
    } else {
        $_SESSION['validasi'] = "Query error: " . mysqli_error($conn);
    }
    // Redirect ke halaman data rekening
    header('Location:'.BASE_URL.'/rekening/index.php');
    exit();
}

?>
<!-- layout header -->


<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?=BASE_URL?>/index.php">Home</a>
            </li>
            <li class="breadcrumb-item active">Data Rekening Tabungan</li>
        </ol>
    </nav>
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit Rekening</h5>
                </div>
                <div class="card-body">
                    <form action="<?=BASE_URL?>/rekening/update.php" method="POST">
                        <input type="hidden" name="id" value="<?=$_GET['id'];?>">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="id_rekening">ID Rekening</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="id_rekening" id="id_rekening"
                                    value="<?=$id_rekening?>" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="siswa">Siswa</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama" id="nama" value="<?=$nama_siswa?>"
                                    readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="saldo">Saldo</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="saldo" id="saldo"
                                    value="<?=rupiah($saldo)?>" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="status">Pilih status</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="status" id="status">
                                    <option selected>-- Pilih Status --</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" name="update" class="btn btn-primary">Simpan</button>
                                <a href="javascript:history.back(-1);" class="btn btn-warning">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- / Content -->
<!-- footer -->
<?php include "../templates/footer.php"?>
