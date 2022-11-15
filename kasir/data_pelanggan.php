<?php
$page = "pelanggan";

session_start();

include "../filelog.php";
include "../db.php";
$queryUser = "SELECT * FROM tb_member";
$execUser = mysqli_query($conn, $queryUser);
$dataUser = mysqli_fetch_all($execUser, MYSQLI_ASSOC);

//tambah-edit
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jenkel = $_POST['jenkel'];
    $tlp = $_POST['telepon'];

    $queryTambah = "INSERT INTO `tb_member` (`id`, `nama`, `alamat`, `jenis_kelamin`, `tlp`) VALUES (NULL, '$nama', '$alamat', '$jenkel', '$tlp');";
    $execTambah = mysqli_query($conn, $queryTambah);
    if ($execTambah) {
        $login = $_SESSION['nama'] . " (" . $_SESSION['role'] . ") " . "Telah menambahkan data member dengan nama($nama) pada daftar member";
        logger($login, "../../../");
        header("location: data_pelanggan.php");
        var_dump($alamat);
    }
}
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['editnama'];
    $alamat = $_POST['editalamat'];
    $jenkel = $_POST['editjenkel'];
    $tlp = $_POST['edittlp'];
    $queryEdit = "UPDATE `tb_member` SET `nama` = '$nama', `alamat` = '$alamat', `jenis_kelamin` = '$jenkel', `tlp` = '$tlp' WHERE id = $id";
    $execEdit = mysqli_query($conn, $queryEdit);
    if ($execEdit) {
        $login = $_SESSION['nama'] . " (" . $_SESSION['role'] . ") " . "Telah mengubah data member dengan id($id) dengan nama($nama) pada daftar member";
        logger($login, "../../../");
        header("location: data_pelanggan.php");
    }
}
if (isset($_POST['delete'])) {
    $id = $_POST['idhapus'];
    $querydel = "SELECT * FROM tb_transaksi WHERE id_member = $id ";
    $execdel = mysqli_query($conn, $querydel);
    $datadel = mysqli_fetch_all($execdel, MYSQLI_ASSOC);
    $idTransaksi = [];
    foreach ($datadel as $del) {
        $idTransaksi[] += $del['id'];
    }
    foreach ($idTransaksi as $delete) {
        $idTransaksi = $delete;
        $queryhapusdetail = "DELETE FROM tb_detail_transaksi WHERE id = $id";
        $exechapusdetail = mysqli_query($conn, $queryhapusdetail);
    }
    $queryhapustr = "DELETE FROM tb_transaksi WHERE id_member = $id";
    $exechapustr = mysqli_query($conn, $queryhapustr);
    if ($exechapusdetail && $exechapustr) {
        $queryDeleteUser = "DELETE FROM tb_member WHERE id = $id";
        $execDeleteUser = mysqli_query($conn, $queryDeleteUser);
        if ($execDeleteUser) {
            $login = $_SESSION['nama'] . " (" . $_SESSION['role'] . ") " . "Telah menghapus data dengan id($id) dengan pada daftar member";
            logger($login, "../../../");
            header("location: data_pelanggan.php");
        }
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
    <link rel="shortcut icon" href="../dist/assets/images/logo/favicon.svg" type="../dist/assets/image/x-icon">
    <link rel="shortcut icon" href="../dist/assets/images/logo/favicon.png" type="../dist/assets/image/png">
    <link rel="stylesheet" href="../dist/assets/css/shared/iconly.css">
    <link rel="stylesheet" href="../dist/assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="../dist/assets/css/pages/simple-datatables.css">


</head>

<body>
    <?php include "sidebar.php"
    ?>

    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3 style="color: #A8E890; font-style: italic;">List Member Laundry Suci</h3>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="fs-5" style="color: #FF2E63; padding-left: 15px;">Daftar Member</h4>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered border-primary">
                                    <thead>
                                        <tr style="color: #30E3CA;">
                                            <th scope="col">No</th>
                                            <th scope="col">ID Member</th>
                                            <th scope="col">Nama Member</th>
                                            <th scope="col">Alamat</th>
                                            <th scope="col">Jenis Kelamin</th>
                                            <th scope="col">No TLP</th>
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
                                                <td><?= $paket['nama']; ?></td>
                                                <td><?= $paket['alamat']; ?></td>
                                                <td><?= $paket['jenis_kelamin']; ?></td>
                                                <td><?= $paket['tlp']; ?></td>
                                                <td>
                                                    <?php include "modal_edit_pelanggan.php"; ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <h4 style="color: #4649FF;">Tambah Member</h4>
                        <hr>
                        <?php include "modal_tambah_pelanggan.php"; ?>
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