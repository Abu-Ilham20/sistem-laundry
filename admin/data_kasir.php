<?php
session_start();
include "../db.php";
include "../filelog.php";

$page = "datakasir";

$queryUser = "SELECT * FROM tb_user";
$execUser = mysqli_query($conn, $queryUser);
$dataUser = mysqli_fetch_all($execUser, MYSQLI_ASSOC);

//tambah-edit
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $queryDeleteUser = "DELETE FROM tb_user WHERE id = $id";
    $execDeleteUser = mysqli_query($conn, $queryDeleteUser);
    if ($execDeleteUser) {
        header("location: data_kasir.php");
    }
}

if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $queryTambah = "INSERT INTO `tb_user` (`id`, `nama`, `username`, `password`, `role`) VALUES (NULL, '$nama', '$username', '$password', '$role');";
    $execTambah = mysqli_query($conn, $queryTambah);
    if ($execTambah) {
        $login = $_SESSION['nama'] . " (" . $_SESSION['role'] . ") " . "Telah menambahkan data admin/kasir dengan nama($nama) pada data admin";
        logger($login, "../../../");
        header("location: data_kasir.php");
    }
}
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['editnama'];
    $username = $_POST['editusername'];
    $password = $_POST['editpassword'];
    $role = $_POST['editrole'];
    $queryEdit = "UPDATE tb_user SET nama = '$nama', username = '$username', password = '$password', role = '$role' WHERE id = $id";
    $execEdit = mysqli_query($conn, $queryEdit);
    if ($execEdit) {
        $login = $_SESSION['nama'] . " (" . $_SESSION['role'] . ") " . "Telah mengubah user dengan id($id) pada daftar anggota";
        logger($login, "../../../");
        header("location: data_kasir.php");
    }
}
if (isset($_POST['delete'])) {
    $id = $_POST['idhapus'];
    $querryDelete = "DELETE FROM tb_user WHERE id = $id";
    $execDelete = mysqli_query($conn, $querryDelete);
    if ($execDelete) {
        $login = $_SESSION['nama'] . " (" . $_SESSION['role'] . ") " . "Telah menghapus user dengan id($id) pada daftar anggota";
        logger($login, "../../../");
        header("location: data_kasir.php");
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
    <?php include "sidebar.php" ?>

    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="page-heading">
            <h3 style="color: #A8E890; font-style: italic;">Data Anggota Admin & Kasir</h3>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="fs-5" style="color: #FF2E63; padding-left: 15px;">Daftar Anggota</h4>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered border-primary" id="table1">
                                    <thead>
                                        <tr style="color: #4FA095; font-style: italic; font-family: monoscape;">
                                            <th scope="col">No</th>
                                            <th scope="col">ID anggota</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Password</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0 ?>
                                        <?php foreach ($dataUser as $user) { ?>
                                            <?php $no++ ?>
                                            <tr>
                                                <td scope="row"><?= $no; ?></td>
                                                <td><?= $user['id']; ?></td>
                                                <td><?= $user['nama']; ?></td>
                                                <td><?= $user['username']; ?></td>
                                                <td><?= $user['password']; ?></td>
                                                <td><?= $user['role']; ?></td>
                                                <td>
                                                    <?php include "modal_edit.php"; ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <h4 class="mt-4">Tambah Data</h4>
                        <hr>
                        <?php include "modal_tambah.php"; ?>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <<!-- ubah mode -->
    <script src="../dist/assets/js/app.js"></script>
    <script src="../dist/assets/js/bootstrap.js"></script>
    <script src="../dist/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="../dist/assets/js/pages/simple-datatables.js"></script>
</body>

</html>