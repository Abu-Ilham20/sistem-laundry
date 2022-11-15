<?php
$page = "dashboard";

session_start();
if (!isset($_SESSION['logkasir'])) {
    header("location: ../login.php");
    exit;
}

include "../filelog.php";
// include "../db.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Suci</title>
    <link rel="stylesheet" href="../dist/assets/css/main/app.css">
    <link rel="stylesheet" href="../dist/assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="../dist/assets/images/logo/favicon.svg" type="../dist/image/x-icon">
    <link rel="shortcut icon" href="../dist/assets/images/logo/favicon.png" type="../dist/image/png">
    <link rel="stylesheet" href="../dist/assets/css/shared/iconly.css">
    <link rel="stylesheet" href="../dist/assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="../dist/assets/css/pages/simple-datatables.css">


</head>

<body>
    <?php
    include "sidebar.php";
    ?>


    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3>Sistem Informasi Manajemen Laundry</h3>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Halaman Hak Akses Kasir</h4>
                        <hr>
                        <h4 class="fs-5">Sistem Informasi Manajemen Laundry</h4>
                    </div>
                    <div class="card-body">
                        <div class="col-md-6">
                            <p class="fs-4">Merupakan sebuah sistem yang digunakan untuk mengelola data kebutuhan Laundry mulai dari pemesanan, status, data penjualan, data kasir, data pengguna, dan laporan transaksi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ubah mode -->
    <script src="../dist/assets/js/app.js"></script>
    <script src="../dist/assets/js/bootstrap.js"></script>
    <script src="../dist/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="../dist/assets/js/pages/simple-datatables.js"></script>
</body>

</html>