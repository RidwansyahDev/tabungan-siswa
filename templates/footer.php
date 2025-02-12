<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">
            ©
            <script>
            document.write(new Date().getFullYear());
            </script>
            <a>Aplikasi Tabungan Yayasan Mathlaul Huda Al-Muhyi</a>
        </div>
    </div>
</footer>
<!-- / Footer -->

<div class="content-backdrop fade">
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<!-- build:js assets/vendor/js/core.js -->
<script src="<?=BASE_URL?>/assets/vendor/libs/jquery/jquery.js"></script>
<script src="<?=BASE_URL?>/assets/vendor/libs/popper/popper.js"></script>
<script src="<?=BASE_URL?>/assets/vendor/js/bootstrap.js"></script>
<script src="<?=BASE_URL?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="<?=BASE_URL?>/assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="<?=BASE_URL?>/assets/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="<?=BASE_URL?>/assets/js/main.js"></script>

<!-- Page JS -->
<script src="<?=BASE_URL?>/assets/js/dashboards-analytics.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Datatable -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- select2 -->
<script src="<?=BASE_URL?>/assets/select2/dist/js/select2.min.js"></script>

<!-- data table -->
<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});


new DataTable('#example');
</script>
<!-- alert validas success -->
<?php if (isset($_SESSION['berhasil'])) : ?>
<script>
const Toast = Swal.mixin({
    toast: true,
    position: "bottom-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});
Toast.fire({
    icon: "success",
    title: "<?=$_SESSION['berhasil']?>"
});
</script>
<?php unset($_SESSION['berhasil'])?>
<?php endif?>


<!-- alert validas gagal -->
<?php if (isset($_SESSION['validasi']) ): ?>
<script>
const Toast = Swal.mixin({
    toast: true,
    position: "bottom-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});
Toast.fire({
    icon: "error",
    title: "<?=$_SESSION['validasi']?>"
});
</script>
<?php unset($_SESSION['validasi'])?>
<?php endif?>

<!-- Alert konfirmasi hapus -->
<script>
$('.tombolHapus').on('click', function() {
    var getLink = $(this).attr('href');
    Swal.fire({
        title: "Yakin hapus?",
        text: "Data yang sudah dihapus tidak bisa kembali",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = getLink;
        }
    })
    return false;

});
</script>
<script>
$(document).ready(function() {
    // Ambil URL saat ini
    var currentUrl = window.location.href;

    // Loop melalui semua elemen <a> dengan class 'menu-link'
    $('a.menu-link').each(function() {
        // Cek apakah href dari elemen <a> sama dengan URL saat ini
        if ($(this).attr('href') === currentUrl) {
            // Tambahkan class 'active' pada elemen <a> yang sesuai
            $(this).addClass('active');

            // Tambahkan class 'open' pada elemen <li> parent yang memiliki class 'menu-item'
            $(this).closest('li.menu-item').addClass('active');


            // Tambahkan class 'open' pada elemen <li> parent yang memiliki class 'menu-item' dan merupakan parent dari submenu
            $(this).closest('ul.menu-sub').prev('a.menu-toggle').closest('li.menu-item').addClass(
                'open active');
        }
    });
});
</script>
</body>

</html>
