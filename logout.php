<?php

session_start();
include "filelog.php";
if (isset($_SESSION['logadmin'])) {
    $nama = $_SESSION['nama'];
    $role = $_SESSION['role'];
    $login = $nama . " (" . $role . ") Telah melakukan Logout";
    logger($login, "../../");
    session_destroy();
}
if (isset($_SESSION['logkasir'])) {
    $nama = $_SESSION['nama'];
    $role = $_SESSION['role'];
    $login = $nama . " (" . $role . ") Telah melakukan Logout";
    logger($login, "../../");
    session_destroy();
}

header("location: login.php");
exit;
