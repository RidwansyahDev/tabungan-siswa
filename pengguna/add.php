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

// Ambil data siswa


if (isset($_POST['add'])) {
    $nama = htmlspecialchars($_POST['nama_petugas']);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    $role =htmlspecialchars($_POST['role']);

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Validasi input
        if (empty($nama) || empty($username) || empty($password) || empty($role)){
            $pesan = "Data harus diisi.";
        }

        if (!empty($pesan)) {
            $_SESSION['validasi'] = $pesan;
            exit;
        }else{
            // Insert data ke tabel rekening
            $query_insert = mysqli_query($conn, "INSERT INTO petugas (nama_petugas, username, password, role) VALUES ('$nama', '$username', '$password','$role')");
            $_SESSION['berhasil'] = "Data berhasil disimpan";
            header("Location: index.php");
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
                    <h5 class="mb-0">Tambah Data Petugas</h5>
                </div>
                <div class="card-body">
                    <form action="<?=BASE_URL?>/pengguna/add.php" method="POST">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nama_petugas">Nama Petugas</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama_petugas" id="nama_petugas"
                                    placeholder="Masukan Nama Petugas" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="username">Username Petugas</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" id="username"
                                    placeholder="Masukan username" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="password">Password </label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Masukan password" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="role">Role</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="role" id="role">
                                    <option selected>-- Pilih Role --</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Operator">Operator</option>
                                </select>
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
