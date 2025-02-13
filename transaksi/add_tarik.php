<?php
session_start();
ob_start();
include "../config/app.php";
if (!$_SESSION['login']) {
    header('Location:'.BASE_URL.'/auth/login.php?pesan=belum_login');
    exit;
}
$judul = "Transaksi Tarik";
include "../templates/header.php";

//ambil id petugas
$id_petugas = $_SESSION['id'];

// ambil data siswa dari database untuk data select
$query = "SELECT id_siswa,nis, nama FROM siswa";
$result =$conn->query($query);

if (isset($_POST['add'])) {
    $id_siswa = $_POST['id_siswa'];
    $jumlah = $_POST['jumlah'];
    $jumlah = str_replace(["Rp","."," "],"",$_POST['jumlah']);
    $jumlah_tarik =intval($jumlah);

    // ambil id_rekening dan saldo saat ini
    $query_data = "SELECT id_rekening, saldo FROM rekening_tabungan WHERE id_siswa=$id_siswa";
    $result_data = $conn->query($query_data);
    $row = $result_data->fetch_assoc();
    $id_rekening = $row['id_rekening'];
    $saldo_akhir = $row['saldo'] - $jumlah_tarik;

    // update saldo rekening tabungan
    $query_update_rekening = "UPDATE rekening_tabungan SET saldo=$saldo_akhir WHERE id_siswa=$id_siswa";
    $conn->query($query_update_rekening);

    // insert transaksi tarik
    $query_insert_transaksi = "INSERT INTO transaksi_tabungan (id_rekening,id_siswa,id_petugas, tanggal_transaksi, jenis_transaksi, jumlah, keterangan) VALUES ('$id_rekening','$id_siswa','$id_petugas', CURRENT_TIMESTAMP(), 'Tarik','$jumlah', 'Tarik Uang')";
    $conn->query($query_insert_transaksi);

    $_SESSION['berhasil'] = "Transaksi tarik berhasil";
    header("Location: ".BASE_URL."/transaksi/tarik.php");
    exit;
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
            <li class="breadcrumb-item active">Transaksi Tarik</li>
        </ol>
    </nav>
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Tambah</h5>
                </div>
                <div class="card-body">
                    <form action="<?=BASE_URL?>/transaksi/add_tarik.php" method="POST">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="siswa">Siswa</label>
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
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="jumlah">Jumlah Tarik</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="jumlah" id="tarik"
                                    placeholder="Masukan Jumlah Tarikan" />
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

<script type="text/javascript">
var tarik = document.getElementById('tarik');
tarik.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formattarik() untuk mengubah angka yang di ketik menjadi format angka
    tarik.value = formattarik(this.value, 'Rp ');
});

/* Fungsi formattarik */
function formattarik(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        tarik = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        tarik += separator + ribuan.join('.');
    }

    tarik = split[1] != undefined ? tarik + ',' + split[1] : tarik;
    return prefix == undefined ? tarik : (tarik ? 'Rp ' + tarik : '');
}
</script>
<?php include "../templates/footer.php"?>
