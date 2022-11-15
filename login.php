<?php
session_start();
if (isset($_SESSION['logadmin'])) {
    header("location: admin/admin.php");
    exit;
}
if (isset($_SESSION['logkasir'])) {
    header("location: kasir/kasir.php");
    exit;
}

include "db.php";
include "filelog.php";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = "SELECT * FROM tb_user WHERE username = '$username'";
    $execresult = mysqli_query($conn, $result);

    // cek username
    if (mysqli_num_rows($execresult) === 1) {
        $resultUser = mysqli_fetch_assoc($execresult);
        if ($password == $resultUser['password'] && $resultUser['role'] == "admin") {
            $login = $resultUser['nama'] . " (" . $resultUser['role'] . ") " . "Melakukan Login";
            logger($login, "../../");
            $_SESSION['role'] = $resultUser['role'];
            $_SESSION['nama'] = $resultUser['nama'];
            $_SESSION['id'] = $resultUser['id'];
            $_SESSION['logadmin'] = true;
            header("location: admin/admin.php");
            exit;
        }
        if ($password == $resultUser['password'] && $resultUser['role'] == "kasir") {
            $login = $resultUser['nama'] . " (" . $resultUser['role'] . ") " . "Melakukan Login";
            logger($login, "../../");
            $_SESSION['role'] = $resultUser['role'];
            $_SESSION['nama'] = $resultUser['nama'];
            $_SESSION['id'] = $resultUser['id'];
            $_SESSION['logkasir'] = true;
            header("location: kasir/kasir.php");
            exit;
        }
    }
    $error = true;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login laundry</title>
    <link rel="stylesheet" href="dist/assets/css/main/app.css">
    <link rel="shortcut icon" href="dist/assets/images/logo/favicon.png" type="image/png">
    <link rel="stylesheet" href="dist/assets/css/pages/auth.css">

</head>

<body>

    <div id="auth">
        <form action="" method="POST">
            <div class="row h-100">
                <div class="col-lg-5 col-12">
                    <div id="auth-left">
                        <div class="auth-logo">
                            <a href="index.html"><img src="assets/images/logo/logo.svg" alt="Logo"></a>
                        </div>
                        <h1 class="auth-title">Log in.</h1>
                        <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>

                        <?php if (isset($error)) {  ?>
                            <p style="color: red;">username / password salah</p>
                        <?php } ?>

                        <form action="index.html">
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="text" class="form-control form-control-xl" id="username" placeholder="Username" name="username" autofocus>
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="password" class="form-control form-control-xl" id="password" placeholder="Password" name="password">
                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" name="login" type="submit">Log in</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-7 d-none d-lg-block">
                    <div id="auth-right" style="padding-left: 15px; font-style: italic; color: #9F73AB; font-family: verdera;" class="text-center">
                        <p style="font-size: 150px; padding-top: 105px;">Laundry</p>
                        <p style="font-size: 150px; margin-bottom: 45px;">Suci</p>
                        <p style="font-size: 18px;">Hubungi : +62123456789   </p>
                        <p style="font-size: 18px;">Email : cisucicuci@gmail.com</p>
                    </div>
                </div>
            </div>
    </div>
    </form>
    <?php
    if (isset($_POST['submit'])) {
    }
    ?>
    </div>
</body>

</html>