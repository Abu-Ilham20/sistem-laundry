<?php
include "../db.php";
include "../filelog.php";

session_start();
if (!isset($_SESSION['logkasir'])) {
    header("location: ../login.php");
    exit;
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
        header("location: profile_kasir.php");
    }
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../dist/assets/css/main/app.css">
    <link rel="stylesheet" href="../dist/assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="../dist/assets/images/logo/favicon.svg" type="../dist/image/x-icon">
    <link rel="shortcut icon" href="../dist/assets/images/logo/favicon.png" type="../dist/image/png">
    <link rel="stylesheet" href="../dist/assets/css/shared/iconly.css">
    <link rel="stylesheet" href="../dist/assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="../dist/assets/css/pages/simple-datatables.css">

</head>

<body>weid
    <?php include "sidebar.php"  ?>
    <div id="main">
        <div class="card-body">
            <img class="card-img-top" src="../ani.jpg" style="width: 110px; height: 130px;" alt="Card image">
            <h2 class="text-center" style="font-family: times new roman; font-style: italic;">Data Pofile Kasir</h2>
            <table class="table" style="font-size: 25px;">
                <tbody>
                    
                    <tr>
                        <td>Id</td>
                        <td width="80%">: <?= $datapenguna['id'] ?></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td width="80%">: <?= $datapenguna['nama'] ?></td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td width="80%">: <?= $datapenguna['username'] ?></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td width="80%">: <?= $datapenguna['password'] ?></td>
                    </tr>
                    <tr>
                        <td>Role</td>
                        <td width="80%">: <?= $datapenguna['role'] ?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td width="80%">: Active</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <a href="" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#normal<?= $datapenguna['id']; ?>">
            <i></i>
            <i class="bi bi-repeat"></i>
            <span>Edit</span>
        </a>
        <div class="modal fade text-left" id="normal<?= $datapenguna['id']; ?>" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Edit Anggota</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control" placeholder="Masukkan Nama User" name="editnama" value="<?= $datapenguna['nama']; ?>">
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                            <div class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control" placeholder="Masukkan Username" name="editusername" value="<?= $datapenguna['username']; ?>">
                                <div class="form-control-icon">
                                    <i class="bi bi-bookmark"></i>
                                </div>
                            </div>
                            <div class="form-group position-relative has-icon-left">
                                <input type="password" class="form-control" placeholder="Masukkan Password" name="editpassword" value="<?= $datapenguna['password']; ?>">
                                <div class="form-control-icon">
                                    <i class="bi bi-key"></i>
                                </div>
                            </div>
                            <div class="col-sm">
                                <h6>Masukkan Role</h6>
                                <fieldset class="form-group">
                                    <select class="form-select" id="basicSelect" name="editrole">
                                        <option value="kasir">Kasir</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal" name="edit">
                                    <input type="text" class="visually-hidden" value="<?= $datapenguna['id']; ?>" name="id">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Simpan</span>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- ubah mode -->
    <script src="../dist/assets/js/app.js"></script>
    <script src="../dist/assets/js/bootstrap.js"></script>
</body>

</html>