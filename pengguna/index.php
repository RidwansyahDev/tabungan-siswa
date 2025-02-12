<?php
session_start();

include "../config/app.php";

if (!$_SESSION['login']) {
    header('Location: '.BASE_URL.'/auth/login.php');
}

$judul = "Data Petugas";
include "../templates/header.php";
// Ambil Data dari tabel kelas
$query = mysqli_query($conn, "SELECT * FROM petugas");


?>
<!-- layout header -->


<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo BASE_URL ?>/index.php">Home</a>
            </li>
            <li class="breadcrumb-item active">Data Petugas</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="table-responsive p-3">
                    <a href="<?=BASE_URL?>/pengguna/add.php" class="btn btn-sm btn-success mb-2">
                        <i class='bx bx-plus'></i> Tambah</a>
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Petugas</th>
                                <th>Username</th>
                                <th>Role</th>
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
                                <td><?= $row['nama_petugas']?></td>
                                <td><?= $row['username']?></td>
                                <td><?= $row['role']?></td>
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
