<?php
session_start();
require_once "config/app.php";

//Cek login
if ($_SESSION['login']==0) {
    header('Location:'.BASE_URL.'/auth/login.php');
}


$judul = "Dashboard";


//ambil data jumlah siswa
$query_siswa = mysqli_query($conn, "SELECT COUNT(*) as jumlah_siswa FROM siswa");
$data_siswa = mysqli_fetch_assoc($query_siswa);

//ambil jumlah setoran
$query_setor = mysqli_query($conn, "SELECT SUM(jumlah) as jumlah_setoran FROM transaksi_tabungan WHERE jenis_transaksi='Setor'");
$data_setor = mysqli_fetch_assoc($query_setor);

//ambil jumlah penarikan
$query_tarik = mysqli_query($conn, "SELECT SUM(jumlah) as jumlah_tarik FROM transaksi_tabungan WHERE jenis_transaksi='Tarik'");
$data_tarik = mysqli_fetch_assoc($query_tarik);

//ambil data saldo
$query_saldo = mysqli_query($conn, "SELECT SUM(saldo) as jumlah_saldo FROM rekening_tabungan");
$data_saldo = mysqli_fetch_assoc($query_saldo);


?>
<!-- layout header -->
<?php include "templates/header.php"?>

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-4">
                        <div class="d-flex flex-sm-column  align-items-start justify-content-between">
                            <div class="card-title">
                                <h4 class="mb-0">
                                    <span class="badge bg-label-primary">
                                        <?= isset($data_siswa['jumlah_siswa']) ? $data_siswa['jumlah_siswa'] : 'Data tidak tersedia'; ?>
                                    </span>
                                </h4>
                            </div>
                            <div class="mt-sm-auto">
                                <h4>Total Siswa</h4>
                            </div>
                        </div>
                        <div>
                            <h5 class="text-nowrap"><i class='bx bx-user' style='color:#696cff; font-size:70px'></i>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-4">
                        <div class="d-flex flex-sm-column  align-items-start justify-content-between">
                            <div class="card-title">
                                <h4 class="mb-0">
                                    <span class="badge bg-label-info ">
                                        <?= isset($data_setor['jumlah_setoran']) ? rupiah($data_setor['jumlah_setoran']) : 'Data tidak tersedia'; ?>
                                    </span>
                                </h4>
                            </div>
                            <div class="mt-sm-auto">
                                <h4 class="text-info">Total Setoran</h4>
                            </div>
                        </div>
                        <div>
                            <h5 class="text-nowrap"><i class='bx bxs-credit-card text-info' style=' font-size:70px'></i>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-4">
                        <div class="d-flex flex-sm-column  align-items-start justify-content-between">
                            <div class="card-title">
                                <h4 class="mb-0">
                                    <span class="badge bg-label-danger ">
                                        <?= isset($data_tarik['jumlah_tarik']) ? rupiah($data_tarik['jumlah_tarik']) : 'Data tidak tersedia'; ?>
                                    </span>
                                </h4>
                            </div>
                            <div class="mt-sm-auto">
                                <h4 class="text-danger">Total Tarik</h4>
                            </div>
                        </div>
                        <div>
                            <h5 class="text-nowrap"><i class='bx bx-credit-card text-danger'
                                    style=' font-size:70px'></i>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-sm-row flex-column gap-4">
                        <div class="d-flex flex-sm-column  align-items-start justify-content-between">
                            <div class="card-title">
                                <h4 class="mb-0">
                                    <span class="badge bg-label-success ">
                                        <?= isset($data_saldo['jumlah_saldo']) ? rupiah($data_saldo['jumlah_saldo']) : 'Data tidak tersedia'; ?>
                                    </span>
                                </h4>
                            </div>
                            <div class="mt-sm-auto">
                                <h4 class="text-success">Total Saldo</h4>
                            </div>
                        </div>
                        <div>
                            <h5 class="text-nowrap"><i class='bx bx-money text-success' style=' font-size:70px'></i>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
<!-- footer -->
<?php include "templates/footer.php"?>
