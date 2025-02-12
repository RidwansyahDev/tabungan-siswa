<?php
session_start();

include "../config/app.php";

if (!$_SESSION['login']) {
    header('Location: '.BASE_URL.'/auth/login.php');
}

$judul = "Data Tabungan Siswa";
include "../templates/header.php";


$id_siswa = $_POST['id_siswa'];
// die();

// Ambil Data dari tabel rekening
$query = mysqli_query($conn, "SELECT * FROM rekening_tabungan JOIN transaksi_tabungan ON transaksi_tabungan.id_rekening = rekening_tabungan.id_rekening JOIN siswa ON siswa.id_siswa=rekening_tabungan.id_siswa WHERE transaksi_tabungan.id_siswa=$id_siswa");



?>
<!-- layout header -->


<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo BASE_URL ?>/index.php">Home</a>
            </li>
            <li class="breadcrumb-item active">Data Tabungan</li>
        </ol>
    </nav>
    <div class="row mb-3">
        <div class="col-lg-12">

            <!-- card -->
            <div class="row gy-4">
                <div class="col-md">
                    <div class="card shadow-none">
                        <div class="card-body text-primary">
                            <h5 class="card-title text-primary">Total Semua Setoran</h5>
                            <p class="card-text">
                                <?php
                                $query_setor = "SELECT sum(jumlah) as total FROM transaksi_tabungan WHERE jenis_transaksi='Setor' AND id_siswa ='$id_siswa'";
                                $result_setor = mysqli_query($conn, $query_setor);
                                $row_setor = mysqli_fetch_assoc($result_setor);
                            ?>
                                <?php if ($row_setor['total'] == 0): ?>
                            <h4>Rp.0</h4>
                            <?php else: ?>
                            <h4>Rp.<?= number_format($row_setor['total'],0,',','.').",00"?></h4>
                            <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="card shadow-none">
                        <div class="card-body text-secondary">
                            <h5 class="card-title text-secondary">Total Semua Penarikan</h5>
                            <p class="card-text">
                                <?php
                    $query_setor = "SELECT sum(jumlah) as total FROM transaksi_tabungan WHERE jenis_transaksi='Tarik' AND id_siswa= '$id_siswa'";
                    $result_setor = mysqli_query($conn, $query_setor);
                    $row_setor = mysqli_fetch_assoc($result_setor);
                ?>
                                <?php if ($row_setor['total'] == 0): ?>
                            <h4>Rp.0</h4>
                            <?php else: ?>
                            <h4>Rp.<?= number_format($row_setor['total'],0,',','.').",00"?></h4>
                            <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="card shadow-none">
                        <div class="card-body text-success">
                            <h5 class="card-title text-success">Total Saldo</h5>
                            <p class="card-text">
                                <?php $query_saldo ="SELECT saldo FROM rekening_tabungan WHERE id_siswa= '$id_siswa'";
                        $result_saldo =$conn->query($query_saldo);
                        $data=$result_saldo->fetch_assoc();
                ?>
                            <h4>Rp.<?= number_format($data['saldo'],0,',','.').",00"?></h4>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card end -->

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="table-responsive p-3">
                    <a href="index.php" class="btn btn-sm btn-info mb-2">
                        <i class='bx bx-arrow-back'></i> Kembali</a>
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Rekening</th>
                                <th>Nama Siswa</th>
                                <th>Tanggal Transaksi</th>
                                <th>Jenis Transaksi</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($query) === 0) : ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                            <?php else :?>
                            <?php $no = 1;?>
                            <?php while ($row = mysqli_fetch_assoc($query)) :?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?= $row['id_rekening']?></td>
                                <td><?= $row['nama']?></td>
                                <td><?= $row['tanggal_transaksi']?></td>
                                <td><?= $row['jenis_transaksi']?></td>
                                <td><?= $row['jumlah']?></td>
                                <td>
                                    <a href="update.php?id=<?= $row['id']?>" class="btn btn-sm btn-primary me-1"
                                        title="Edit"><i class='bx bxs-edit'></i></a>
                                    <a href="delete.php?id=<?= $row['id']?>"
                                        class="btn btn-sm btn-danger me-1 tombolHapus" title="Delete"><i
                                            class='bx bxs-trash'></i></a>
                                </td>
                            </tr>
                            <?php endwhile;?>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
<!-- footer -->
<?php include "../templates/footer.php"?>
