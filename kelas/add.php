<?php
session_start();
ob_start();
include "../config/app.php";
if (!$_SESSION['login']) {
    header('Location:'.BASE_URL.'/auth/login.php?pesan=belum_login');
    exit;
}
$judul = "Tambah Data Kelas";
include "../templates/header.php";


if (isset($_POST['add'])) {
    $nama_kelas = htmlspecialchars($_POST['nama_kelas']);


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validasi input
        if (empty($nama_kelas) ) {
            $pesan = "Data harus diisi.";
        }
        if (!empty($pesan)) {
            $_SESSION['validasi'] =$pesan;
        } else {
            // Insert data ke tabel kelas
            $query_insert = mysqli_query($conn, "INSERT INTO kelas (nama_kelas) VALUES ('$nama_kelas')");
            $_SESSION['berhasil'] ="Data berhasil disimpan";
            header('Location:'.BASE_URL.'/kelas/index.php');
            exit;
        }
    }
}
?>
<!-- layout header -->
<?php ?>

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo BASE_URL ?>/index.php">Home</a>
            </li>
            <li class="breadcrumb-item active">Data Kelas</li>
        </ol>
    </nav>
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Tambah Kelas</h5>
                </div>
                <div class="card-body">
                    <form action="<?=BASE_URL?>/kelas/add.php" method="POST">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nama_kelas">Nama Kelas</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_kelas" id="nama_kelas"
                                    placeholder="Masukan Nama Kelas" />
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" name="add" class="btn btn-primary">Simpan</button>
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
