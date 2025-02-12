<?php
session_start();
ob_start();
include "../config/app.php";
if (!$_SESSION['login']) {
    header('Location:'.BASE_URL.'/auth/login.php?pesan=belum_login');
    exit;
}
$judul = "Edit Data Kelas";
include "../templates/header.php";


// Ambil data kelas berdasarkan id
    $id = $_GET["id"];

    $sql = "SELECT * FROM kelas WHERE id='$id'";
    $data = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($data)) {
        $id = $row['id'];
        $nama_kelas = $row['nama_kelas'];
    }



// Proses update data kelas
if (isset($_POST['update'])) {
    // Ambil data yang dikirim dari form
    $id = $_POST['id'];
    $nama_kelas = htmlspecialchars($_POST['nama_kelas']);


    //query update data
    $query = "UPDATE kelas SET nama_kelas='$nama_kelas' WHERE id='$id'";

      // Eksekusi query
      if (mysqli_query($conn, $query)) {
        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['berhasil'] = "Data siswa berhasil diubah";
        } else {
            $_SESSION['validasi'] = "Tidak ada perubahan data";
        }
    } else {
        $_SESSION['validasi'] = "Query error: " . mysqli_error($conn);
    }
    header('Location: '.BASE_URL.'/kelas/index.php');
    exit();
}
?>
<!-- layout header -->
<?php ?>

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo BASE_URL ?>/admin/home/index.php">Home</a>
            </li>
            <li class="breadcrumb-item active">Data Kelas</li>
        </ol>
    </nav>
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit Kelas</h5>
                </div>
                <div class="card-body">
                    <form action="<?=BASE_URL?>/kelas/update.php" method="POST">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nama_kelas">Nama Kelas</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="id" value="<?=$id?>" />
                                <input type="text" class="form-control" name="nama_kelas" id="nama_kelas"
                                    value="<?=$nama_kelas?>" />
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
