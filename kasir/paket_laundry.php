<?php
$page = "paket";

session_start();

include "../db.php";
include "../filelog.php";

//search
// if (isset($_POST['serch']) ) {
//     $queryUser = search($_POST['keyword']);
// }

$queryUser = "SELECT * FROM tb_paket";
$execUser = mysqli_query($conn, $queryUser);
$dataUser = mysqli_fetch_all($execUser, MYSQLI_ASSOC);

//tambah-edit
if (isset($_POST['tambah'])) {
    $jenis = $_POST['jenis'];
    $nama_paket = $_POST['paket'];
    $harga = $_POST['harga'];
    $queryTambah = "INSERT INTO `tb_paket` (`id`, `jenis`, `nama_paket`, `harga`) VALUES (NULL, '$jenis', '$nama_paket', '$harga');";
    $execTambah = mysqli_query($conn, $queryTambah);
    if ($execTambah) {
        $login = $_SESSION['nama'] . " (" . $_SESSION['role'] . ") " . "Telah menambahkan paket laundry dengan nama paket($nama_paket) pada daftar paket";
        logger($login, "../../../");
        header("location: paket_laundry.php");
    }
}
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $jenis = $_POST['editjenis'];
    $nama_paket = $_POST['editpaket'];
    $harga = $_POST['editharga'];
    $queryEdit = "UPDATE `tb_paket` SET `jenis` = '$jenis', `nama_paket` = '$nama_paket', `harga` = '$harga' WHERE id = $id";
    $execEdit = mysqli_query($conn, $queryEdit);
    if ($execEdit) {
        $login = $_SESSION['nama'] . " (" . $_SESSION['role'] . ") " . "Telah mengubah paket dengan id($id) dengan jenis($jenis) pada daftar paket";
        logger($login, "../../../");
        header("location: paket_laundry.php");
    }
}
if (isset($_POST['delete'])) {
    $id = $_POST['idhapus'];
    $queryDeleteUser = "DELETE FROM tb_paket WHERE id = $id";
    $execDeleteUser = mysqli_query($conn, $queryDeleteUser);
    if ($execDeleteUser) {
        $login = $_SESSION['nama'] . " (" . $_SESSION['role'] . ") " . "Telah menghapus paket dengan id($id) pada daftar paket";
        logger($login, "../../../");
        header("location: paket_laundry.php");
    }
}
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
    <!-- sidebar -->
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
            <h3 style="color: #A8E890; font-style: italic;">List Paket Laundry Suci</h3>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="fs-5" style="color: #FF2E63; padding-left: 15px;">Daftar Paket</h4>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered border-primary" id="table1">
                                    <thead>
                                        <tr style="color: #30E3CA;">
                                            <th scope="col">No</th>
                                            <th scope="col">ID paket</th>
                                            <th scope="col">Jenis Paket</th>
                                            <th scope="col">Nama Paket</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0 ?>
                                        <?php foreach ($dataUser as $paket) { ?>
                                            <?php $no++ ?>
                                            <tr>
                                                <td scope="row"><?= $no; ?></td>
                                                <td><?= $paket['id']; ?></td>
                                                <td><?= $paket['jenis']; ?></td>
                                                <td><?= $paket['nama_paket']; ?></td>
                                                <td><?= $paket['harga']; ?></td>
                                                <td>
                                                    <?php include "modal_edit_paket.php"; ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <h4 style="color: #4649FF;">Tambah Paket</h4>
                        <hr>
                        <?php include "modal_tambah_paket.php"; ?>
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