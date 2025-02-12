<?php
session_start();
ob_start();
include "../config/app.php";
if (!$_SESSION['login']) {
    header('Location:'.BASE_URL.'/auth/login.php?pesan=belum_login');
    exit;
}
$judul = "Data Petugas";
include "../templates/header.php";


// Ambil data kelas berdasarkan id
$id = $_GET["id"];

$sql = "SELECT * FROM petugas WHERE id='$id'";
$data = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($data)) {
    $id = $row['id'];
    $nama_petugas = $row['nama_petugas'];
    $username = $row['username'];
    $role = $row['role'];
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = htmlspecialchars($_POST['nama_petugas']);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    $role =htmlspecialchars($_POST['role']);

    $query = "UPDATE petugas SET nama_petugas='$nama',username='$username',password='$password',role='$role' WHERE id='$id'";

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
    header('Location: '.BASE_URL.'/pengguna/index.php');
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
            <li class="breadcrumb-item active">Daftar Petugas</li>
        </ol>
    </nav>
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Tambah Data Rekening</h5>
                </div>
                <div class="card-body">
                    <form action="<?=BASE_URL?>/pengguna/update.php" method="POST">
                        <input type="hidden" name="id" value="<?=$id?>" />
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nama_petugas">Nama Petugas</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_petugas" id="nama_petugas" value="<?=$nama_petugas?>" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="username">Username Petugas</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" id="username"
                                    value="<?=$username?>" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="password">Password </label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Masukan password baru" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="role">Role</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="role" id="role">
                                    <option selected>-- Pilih Role --</option>
                                    <option value="admin" <?=($role =='admin') ? 'selected' :''?>>Admin</option>
                                    <option value="operator" <?=($role =='operator') ? 'selected' :''?>>Operator
                                    </option>
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
