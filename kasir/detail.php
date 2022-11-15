<?php
session_start();
if (!isset($_SESSION['logkasir'])) {
    header("location: ../login.php");
    exit;
}

include "../db.php";
include "../filelog.php";

$querySemuaPelanggan = "SELECT * FROM tb_member";
$execSemuaPelanggan = mysqli_query($conn, $querySemuaPelanggan);
$dataSemuaPelanggan = mysqli_fetch_all($execSemuaPelanggan, MYSQLI_ASSOC);
// var_dump($dataSemuaPelanggan);


$kode = $_GET['kode'];
$idTransaksi = $_GET['idTransaksi'];
$queryTransaksi = "SELECT * FROM tb_transaksi WHERE id = $idTransaksi";
$execTransaksi = mysqli_query($conn, $queryTransaksi);
$dataTransaksi = mysqli_fetch_assoc($execTransaksi);
// var_dump($dataTransaksi);

$idPelanggan = $dataTransaksi['id_member'];
$queryPelanggan = "SELECT * FROM tb_member WHERE id = $idPelanggan";
$execPelanggan = mysqli_query($conn, $queryPelanggan);
$dataPelanggan = mysqli_fetch_assoc($execPelanggan);



$queryDetail = "SELECT * FROM tb_detail_transaksi WHERE id_transaksi = $idTransaksi";
$execDetail = mysqli_query($conn, $queryDetail);
$dataDetail = mysqli_fetch_all($execDetail, MYSQLI_ASSOC);
// var_dump($dataDetail);


$querryPaket = "SELECT * FROM tb_paket";
$execPaket = mysqli_query($conn, $querryPaket);
$dataPaket = mysqli_fetch_all($execPaket, MYSQLI_ASSOC);




if ((!isset($_GET['idTransaksi']) || !isset($_GET['kode'])) || ($kode !== $dataTransaksi['kode_invoice'] || $idTransaksi !== $dataTransaksi['id'])) {
    header("location: riwayat.php");
    exit;
}

//badge
if ($dataTransaksi['dibayar'] == 'dibayar') {
    $bayarwarna = "badge bg-success";
}
if ($dataTransaksi['dibayar'] == 'belum_dibayar') {
    $bayarwarna = "badge bg-danger";
}
if ($dataTransaksi['status'] == 'baru') {
    $sttwarna = "badge bg-info";
}
if ($dataTransaksi['status'] == 'proses') {
    $sttwarna = "badge bg-info";
}
if ($dataTransaksi['status'] == 'selesai') {
    $sttwarna = "badge bg-info";
}
if ($dataTransaksi['status'] == 'diambil') {
    $sttwarna = "badge bg-info";
}
//akhir

//badge
if ($dataTransaksi['dibayar'] == 'belum_dibayar') {
    $bayar = "Belum Dibayar";
}
if ($dataTransaksi['dibayar'] == 'dibayar') {
    $bayar = "Dibayar";
}
if ($dataTransaksi['status'] == 'baru') {
    $status = "Baru";
}
if ($dataTransaksi['status'] == 'proses') {
    $status = "Sedang Proses";
}
if ($dataTransaksi['status'] == 'selesai') {
    $status = "Sudah Selesai";
}
if ($dataTransaksi['status'] == 'diambil') {
    $status = "Sudah Diambil";
}

if (isset($_POST['simpan'])) {
    // Ubah data tb transaksi
    $pelanggan = $_POST['pelanggan'];
    $tgl = $_POST['tgl'];
    $batastgl = $_POST['batastgl'];
    $tglbayar = $_POST['tglbayar'];
    $status = $_POST['status'];
    $status_bayar = $_POST['status_bayar'];
    if ($tgl == '0000-00-00 00:00:00') {
        exit;
    }
    $queryEditData = "UPDATE `tb_transaksi` SET `id_member` = '$pelanggan', `tgl` = '$tgl', `batas_waktu` = '$batastgl', `tgl_bayar` = '$tglbayar', `status` = '$status', `dibayar` = '$status_bayar' WHERE `tb_transaksi`.`id` = $idTransaksi;";
    $execEditData = mysqli_query($conn, $queryEditData);


    // Ubah data tb detail transaksi
    $jumlahPaketDipesan = [];
    $kuan = [];
    foreach ($dataDetail as $detail) {
        foreach ($dataPaket as $paket) {
            if ($detail['id_paket'] == $paket['id']) {
                $jumlahPaketDipesan[] += $paket['id'];
                $kuan[] += $detail['qty'];
            }
        }
    }

    // Query Edit data
    // Cek sudah ada isinya tau belum,
    $jumlahRow = mysqli_num_rows($execDetail);
    $jumlahPaket = mysqli_num_rows($execPaket);
    foreach ($dataDetail as $detail) {
        // Jika sudah, ganti isinya dengan yang baru
        foreach ($dataPaket as $paket) {
            if ($paket['id'] == $detail['id_paket']) {
                $idPaket = $paket['id'];
                $qty = $_POST['qty' . "$idPaket"];
                $keterangan = $_POST['ket' . "$idPaket"];
                if ($detail['qty'] !== $qty) {
                    $queryUpdate = "UPDATE `tb_detail_transaksi` SET `qty` = '$qty', `keterangan` = '$keterangan' WHERE id_paket = $idPaket AND id_transaksi = $idTransaksi";
                    $execUpdate = mysqli_query($conn, $queryUpdate);
                }
            } else {
                continue;
            }
        }
        // Jika belum ada, masukan data tersebut dgn insert

        foreach ($dataPaket as $paket) {
            $idPaket = $paket['id'];
            $queryPilih = "SELECT * FROM tb_detail_transaksi WHERE id_paket = $idPaket AND id_transaksi = $idTransaksi";
            $execPilih = mysqli_query($conn, $queryPilih);
            $jumlahPilih = mysqli_num_rows($execPilih);
            if ($paket['id'] !== $detail['id_paket']) {
                $idPaket = $paket['id'];
                $qty = $_POST['qty' . "$idPaket"];
                $keterangan = $_POST['ket' . "$idPaket"];
                if ($qty !== 0 && $jumlahPilih == 0) {
                    $queryTambahPesanan = "INSERT INTO `tb_detail_transaksi` (`id`, `id_transaksi`, `id_paket`, `qty`, `keterangan`) VALUES (NULL, '$idTransaksi', '$idPaket', '$qty', '$keterangan')";
                    $execTambahPesanan = mysqli_query($conn, $queryTambahPesanan);
                }
            }
        }
    }
    foreach ($dataPaket as $paket) {
        $idPaket = $paket['id'];
        $queryDeleteBug = "DELETE FROM tb_detail_transaksi WHERE id_transaksi = $idTransaksi AND qty = 0";
        $execDeleteBug = mysqli_query($conn, $queryDeleteBug);
    }
    if ($queryUpdate || $queryTambahPesanan) {
        header("location: detail.php?idTransaksi=$idTransaksi&kode=$kode");
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
    <link rel="shortcut icon" href="../dist/assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.png" type="image/png">
    <link rel="stylesheet" href="../dist/assets/css/shared/iconly.css">
    <link rel="stylesheet" href="../dist/assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="../dist/assets/css/pages/simple-datatables.css">

    <style>
        h5 {
            font-family: cursive;
        }
    </style>
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
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="card-header">
                    <h2 style="font-style: italic; color: #9ED5C5;">Detail Transaksi Laundry </h2>
                </div>
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-header mb-0 pb-0">
                            <div class="row">

                                <div class="col-9">
                                    <h4 class="card-title fs-4" style="font-style: italic; color: #9ED5C5;">Detail Transaksi</h4>
                                </div>
                                <div class="float-end col">
                                    <span class="<?= $bayarwarna ?>"><?= $bayar ?></span>
                                    <span class="<?= $sttwarna ?>"><?= $status ?></span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" method="post">
                                    <div class="row">
                                        <div class="container mb-3">
                                            <div class="row">
                                                <table class="table mb-5 table-lg">
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-3">
                                                                <h5 style="color: #7978FF;">No Invoice </h5>
                                                            </td>
                                                            <td class="text-bold-1000"> : <?= $kode = $dataTransaksi['kode_invoice']; ?></td>
                                                            <br>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5 style="color: #7978FF;">Waktu Transaksi</h5>
                                                            </td>
                                                            <td> : <?= $dataTransaksi['tgl']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5 style="color: #7978FF;">Nama Pelanggan </h5>
                                                            </td>
                                                            <td> : <?= $dataPelanggan['nama']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5 style="color: #7978FF;">No Telpon</h5>
                                                            </td>
                                                            <td> : <?= $dataPelanggan['tlp'];   ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h5 style="color: #7978FF;">Alamat</h5>
                                                            </td>
                                                            <td> : <?= $dataPelanggan['alamat']; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <table class="table table-bordered border-primary fs-5">
                                                    <thead>
                                                        <tr style="color: #9ED5C5; font-family: copperplate;">
                                                            <th>No</th>
                                                            <th>Nama Paket</th>
                                                            <th>Jenis Paket</th>
                                                            <th>Tarif</th>
                                                            <th>Berat</th>
                                                            <th>Total Bayar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        <?php foreach ($dataDetail as $detail) : ?>
                                                            <?php
                                                            $paket = $detail['id_paket'];
                                                            $queryAmbil = "SELECT * FROM tb_paket WHERE id=$paket";
                                                            $execAmbil = mysqli_query($conn, $queryAmbil);
                                                            $dataAmbil = mysqli_fetch_assoc($execAmbil);
                                                            $namapaket = $dataAmbil['nama_paket'];
                                                            $jenis = $dataAmbil['jenis'];
                                                            $harga = $dataAmbil['harga'];
                                                            $total = $detail['qty'] * $harga;
                                                            ?>
                                                            <tr>
                                                                <td><?= $i; ?></td>
                                                                <td><?= $namapaket; ?></td>
                                                                <td><?= $jenis; ?></td>
                                                                <td><?= $harga; ?></td>
                                                                <td><?= $detail['qty']; ?></td>
                                                                <td><?= $total; ?></td>
                                                            </tr>
                                                            <?php $i++ ?>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                                <div class="mt-5">
                                                    <?php include "edit_detail.php" ?>
                                                <a href="cetak_detail.php?idTransaksi=<?= $idTransaksi ?>&kode=<?= $kode ?>" target="_blank">
                                                <button type="button" class="btn btn-primary">Print</button>
                                            </a></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- ubah mode -->
    <script src="../dist/assets/js/app.js"></script>
    <script src="../dist/assets/js/bootstrap.js"></script>
    <!-- <script src="../dist/assets/extensions/simple-datatables/umd/simple-datatables.js"></script> -->
    <!-- <script src="../dist/assets/js/pages/simple-datatables.js"></script> -->
</body>

</html>