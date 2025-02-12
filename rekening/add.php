<?php
session_start();
ob_start();
include "../config/app.php";
if (!$_SESSION['login']) {
    header('Location:'.BASE_URL.'/auth/login.php?pesan=belum_login');
    exit;
}
$judul = "Data Siswa";
include "../templates/header.php";

// Ambil data siswa


if (isset($_POST['add'])) {
    $id_rekening = htmlspecialchars($_POST['id_rekening']);
    $id_siswa = htmlspecialchars($_POST['id_siswa']);

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Validasi input
        if (empty($id_rekening) || empty($id_siswa)) {
            $pesan = "Data harus diisi.";
        }

        if (!empty($pesan)) {
            $_SESSION['validasi'] = $pesan;
            exit;
        }else{
            // Insert data ke tabel rekening
            $query_insert = mysqli_query($conn, "INSERT INTO rekening_tabungan (id_rekening, id_siswa, saldo, status) VALUES ('$id_rekening', '$id_siswa', 0,'Aktif')");
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
            <li class="breadcrumb-item active">Daftar Rekening Siswa</li>
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
                    <form action="<?=BASE_URL?>/rekening/add.php" method="POST">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="id_rekening">ID Rekening</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="id_rekening" id="id_rekening"
                                    value="<?=$idRekening?>" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="id_siswa" id="nama">
                                    <option selected>-- Pilih Siswa --</option>
                                    <?php
                                        $query = "SELECT * FROM siswa";
                                        $result = mysqli_query($conn, $query);
                                        ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)) :?>
                                    <option value="<?=$row['id_siswa'] ?>"><?=$row['nama'] ?></option>
                                    <?php endwhile;?>
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
