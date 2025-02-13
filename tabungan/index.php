<?php
session_start();
ob_start();
include "../config/app.php";
if (!$_SESSION['login']) {
    header('Location:'.BASE_URL.'/auth/login.php?pesan=belum_login');
    exit;
}
$judul = "Lihat Data Tabungan";
include "../templates/header.php";

// ambil data siswa dari database untuk data select
$query = "SELECT * FROM siswa JOIN rekening_tabungan ON rekening_tabungan.id_siswa = siswa.id_siswa";
$result =$conn->query($query);

?>
<!-- layout header -->
<?php ?>

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
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Tabungan</h5>
                </div>
                <div class="card-body">
                    <form action="<?=BASE_URL?>/tabungan/view_tabungan.php" method="POST">
                        <div class="row mb-3">

                            <label class="col-sm-2 col-form-label" for="siswa">Pilih Siswa</label>
                            <div class="col-sm-10">
                                <select class="form-select js-example-basic-single" name="id_siswa" id="siswa">
                                    <option selected>-- Pilih Siswa --</option>
                                    <?php while ($row = $result->fetch_assoc()) :?>
                                    <option value="<?=$row['id_siswa'] ?>"><?= $row['nis']?> - <?=$row['nama'] ?>
                                    </option>
                                    <?php endwhile;?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="saldo">Saldo Tabungan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="saldo" id="saldo" readonly />
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" name="cari" class="btn btn-primary">Lihat</button>
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
<script>
$(document).ready(function() {
    $("#siswa").change(function() {
        var id_siswa = $(this).val();

        if (id_siswa !== "") {
            $.ajax({
                url: "https://localhost/tabungan_siswa/ajax/get_siswa.php",
                type: "POST",
                data: {
                    id_siswa: id_siswa
                },
                success: function(response) {
                    $("#saldo").val(response);
                }
            });
        } else {
            $("#saldo").val("");
        }
    });
});
</script>
<?php include "../templates/footer.php"?>
