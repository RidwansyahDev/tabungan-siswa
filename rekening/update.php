<?php
session_start();

include "../config/app.php";

if (!$_SESSION['login']) {
    header('Location: '.BASE_URL.'/auth/login.php');
}

$judul = "Data Kelas";
include "../templates/header.php";

$id=$_GET['id'];
// Ambil Data dari tabel rekening_tabungan
$query = mysqli_query($conn, "SELECT * FROM rekening_tabungan JOIN siswa ON rekening_tabungan.id_siswa=siswa.id_siswa WHERE id='$id'");
while ($row = mysqli_fetch_assoc($query)){
    $id_rekening = $row['id_rekening'];
    $id_siswa = $row['id_siswa'];
    $nama_siswa = $row['nama'];
    $saldo = $row['saldo'];
}

if (isset($_POST['update'])) {
    $id_rekening = $row['id_rekening'];
    $id_siswa = $_POST['id_siswa'];
    $saldo = $_POST['saldo'];

    // query update
    $query ="UPDATE rekening_tabungan SET id_siswa = '$id_siswa',saldo = '$saldo' WHERE id_rekening = '$id_rekening";
    if (mysqli_query($conn,$query)) {
        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['berhasil'] = "Data rekening berhasil diubah";
        } else {
            $_SESSION['validasi'] = "Tidak ada perubahan data";
        }
    }else{
        $_SESSION['validasi'] = "Query error: " . mysqli_error($conn);
    }


        // Redirect ke halaman data siswa
        header('Location: ' . BASE_URL . '/rekening/index.php');
        exit();

}

?>
<!-- layout header -->


<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo BASE_URL ?>/index.php">Home</a>
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
                    <form action="<?=BASE_URL?>/siswa/update.php" method="POST">
                        <input type="hidden" name="id_rekening" value="<?=$id_rekening?>">
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
                                <input type="text" class="form-control" name="saldo" id="saldo" value="<?=$saldo?>" />
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