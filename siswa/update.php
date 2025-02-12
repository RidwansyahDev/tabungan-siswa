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

$id=$_GET['id'];
 // Ambil data siswa berdasarkan id_siswa  dan tampilkan ke form update
$query = "SELECT * FROM siswa WHERE id_siswa = '$id'";
$result =mysqli_query($conn,$query);

while ($row=mysqli_fetch_assoc($result)) {
    $nis = $row['nis'];
    $nama = $row['nama'];
    $jenis_kelamin = $row['jenis_kelamin'];
    $kelas = $row['id_kelas'];
    $alamat = $row['alamat'];
    $no_telp = $row['no_telp'];
    $th_masuk =$row['th_masuk'];

}

    // Proses update data siswa

    if (isset($_POST['update'])) {
        // Pastikan semua field yang diperlukan ada di $_POST

            // Ambil data dari $_POST
            $id = $_POST['id_siswa'];
            $nis = htmlspecialchars($_POST['nis']);
            $nama = htmlspecialchars($_POST['nama']);
            $kelas = htmlspecialchars($_POST['kelas']);
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $alamat = htmlspecialchars($_POST['alamat']);
            $no_telp = htmlspecialchars($_POST['no_telp']);
            $th_masuk = htmlspecialchars($_POST['th_masuk']);

            // Query untuk update data
            $query = "UPDATE siswa SET
                      nis='$nis',
                      nama='$nama',
                      id_kelas='$kelas',
                      jenis_kelamin='$jenis_kelamin',
                      alamat='$alamat',
                      no_telp='$no_telp',
                      th_masuk='$th_masuk'
                      WHERE id_siswa='$id'";

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


        // Redirect ke halaman data siswa
        header('Location: ' . BASE_URL . '/siswa/index.php');
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
                    <form action="<?=BASE_URL?>/siswa/update.php" method="POST">
                        <input type="hidden" name="id_siswa" value="<?=$id?>">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nis">NIS</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nis" id="nis" value="<?=$nis?>" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama" id="nama" value="<?=$nama?>" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="jenis_kelamin">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="jenis_kelamin" id="jenis_kelamin">
                                    <option selected>-- Pilih --</option>
                                    <option value="L" <?= ($jenis_kelamin == 'L') ? 'selected' : '' ?>>Laki-laki
                                    </option>
                                    <option value="P" <?= ($jenis_kelamin == 'P') ? 'selected' : '' ?>>Perempuan
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="kelas">Kelas</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="kelas" id="kelas">
                                    <option selected>-- Pilih Kelas --</option>
                                    <?php
                                        $sql = "SELECT * FROM kelas";
                                        $result = mysqli_query($conn, $sql);
                                        while ($data = mysqli_fetch_assoc($result)) :
                                            // Pastikan 'id_kelas' ada di array sebelum digunakan
                                        ?>
                                    <option value="<?= $data['id'] ?>" <?= ($kelas == $data['id']) ? "selected" : "" ?>>
                                        <?= htmlspecialchars($data['nama_kelas']) ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="th_masuk">Tahun Masuk</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="th_masuk" id="th_masuk"
                                    value="<?=$th_masuk?>" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="alamat">Alamat</label>
                            <div class="col-sm-10">
                                <textarea id="alamat" name="alamat" class="form-control"><?= $alamat?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="no_telp">No telpon</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="no_telp" id="no_telp"
                                    value="<?=$no_telp?>" />
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
