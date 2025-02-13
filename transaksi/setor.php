<?php
session_start();

include "../config/app.php";

if (!$_SESSION['login']) {
    header('Location: '.BASE_URL.'/auth/login.php');
}

$judul = "Transaksi Setoran";
include "../templates/header.php";
// Ambil Data dari tabel transaksi tabungan
$query = mysqli_query($conn, "SELECT * FROM transaksi_tabungan JOIN siswa ON siswa.id_siswa=transaksi_tabungan.id_siswa JOIN petugas ON petugas.id=transaksi_tabungan.id_petugas WHERE jenis_transaksi='Setor' ORDER BY tanggal_transaksi DESC");


?>
<!-- layout header -->


<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo BASE_URL ?>/index.php">Home</a>
            </li>
            <li class="breadcrumb-item active">Transaksi Setoran</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-info alert-dismissible" role="alert">
                <?php
                    $query_setor = "SELECT sum(jumlah) as total FROM transaksi_tabungan WHERE jenis_transaksi='Setor'";
                    $result_setor = mysqli_query($conn, $query_setor);
                    $row_setor = mysqli_fetch_assoc($result_setor);
                ?>
                <?php if ($row_setor['total'] == 0): ?>
                <h5>Total Setoran</h5>
                <h4>Rp.0</h4>
                <?php else: ?>
                <h5>Total Setoran</h5>
                <h4>Rp.<?= number_format($row_setor['total'],0,',','.').",00"?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="table-responsive p-3">
                    <a href="add_setor.php" class="btn btn-sm btn-success mb-2"><i class='bx bx-plus'></i>
                        Tambah</a>
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Rekening</th>
                                <th>Nama</th>
                                <th>Tanggal Transaksi</th>
                                <th>Jenis Transaksi</th>
                                <th>Jumlah</th>
                                <th>Petugas</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
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
                                <td><?= rupiah($row['jumlah'])?></td>
                                <td><?= $row['username']?></td>
                                <td><?= $row['keterangan']?></td>
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
