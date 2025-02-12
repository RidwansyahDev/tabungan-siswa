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


if (isset($_POST['add'])) {
    $nis = htmlspecialchars($_POST['nis']);
    $nama = htmlspecialchars($_POST['nama']);
    $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
    $id_kelas = htmlspecialchars($_POST['id_kelas']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $no_telp = htmlspecialchars($_POST['no_telp']);
    $th_masuk = htmlspecialchars($_POST['th_masuk']);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validasi input
        if (empty($nis) || empty($nama) || empty($id_kelas) || empty($alamat) || empty($no_telp) || empty($th_masuk)) {
            $pesan = "Data harus diisi semua.";
        }
        if (!empty($pesan)) {
            $_SESSION['validasi'] =$pesan;
        } else {
            // Insert data ke tabel siswa
            $query_insert = mysqli_query($conn, "INSERT INTO siswa (nis, nama, jenis_kelamin, id_kelas, alamat, no_telp, th_masuk) VALUES ('$nis', '$nama', '$jenis_kelamin', '$id_kelas', '$alamat', '$no_telp', '$th_masuk')");
            $_SESSION['berhasil'] ="Data berhasil disimpan";
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
            <li class="breadcrumb-item active">Data Siswa</li>
        </ol>
    </nav>
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Tambah Siswa</h5>
                </div>
                <div class="card-body">
                    <form action="<?=BASE_URL?>/siswa/add.php" method="POST">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nis">NIS</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nis" id="nis" placeholder="Masukan NIS" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama" id="nama"
                                    placeholder="Masukan Nama" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="jenis_kelamin">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="jenis_kelamin" id="jenis_kelamin">
                                    <option selected>-- Pilih --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="kelas">Kelas</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="id_kelas" id="kelas">
                                    <option selected>-- Pilih Kelas --</option>
                                    <?php
                                        $query = "SELECT * FROM kelas";
                                        $result = mysqli_query($conn, $query);
                                        ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)) :?>
                                    <option value="<?=$row['id'] ?>"><?=$row['nama_kelas'] ?></option>
                                    <?php endwhile;?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="th_masuk">Tahun Masuk</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="th_masuk" id="th_masuk"
                                    placeholder="Masukan Tahun masuk,seperti '2024'" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="alamat">Alamat</label>
                            <div class="col-sm-10">
                                <textarea id="alamat" name="alamat" class="form-control"
                                    placeholder="Masukan Alamat"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="no_telp">No telpon</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="no_telp" id="no_telp"
                                    placeholder="Masukan No Telepon" />
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
