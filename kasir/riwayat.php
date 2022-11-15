<?php
$page = "detail";

session_start();
if (!isset($_SESSION['logkasir'])) {
    header("location: ../login.php");
    exit;
}
include "../db.php";

$querydetail = "SELECT * FROM tb_detail_transaksi";
$execdetail = mysqli_query($conn, $querydetail);
$datadetail = mysqli_fetch_all($execdetail, MYSQLI_ASSOC);

$querytrans = "SELECT * FROM tb_transaksi";
$exectrans = mysqli_query($conn, $querytrans);
$datatrans = mysqli_fetch_all($exectrans, MYSQLI_ASSOC);

$querypaket = "SELECT * FROM tb_paket";
$execpaket = mysqli_query($conn, $querypaket);
$datapaket = mysqli_fetch_all($execpaket, MYSQLI_ASSOC);

if (isset($_POST['hps'])) {
    $id = $_POST['idhapus'];
    $queryHapusData = "DELETE FROM tb_detail_transaksi WHERE id_transaksi = $id";
    $execHapusData = mysqli_query($conn, $queryHapusData);
    $queryHapusTransaksi = "DELETE FROM tb_transaksi WHERE id = $id";
    $execHapusTransaksi = mysqli_query($conn, $queryHapusTransaksi);
    if ($execHapusData && $execHapusTransaksi) {
        header("location: riwayat.php");
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
    <?php include "sidebar.php"
    ?>
    <div id="main">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="fs-5" style="color: #FF2E63; padding-left: 15px;">Detail Transaksi</h4>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered border-primary">
                                    <thead>
                                        <tr style="color: #30E3CA;">
                                            <th scope="col">No</th>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Kode Invoice</th>
                                            <th scope="col">Nama Pelanggan</th>
                                            <th scope="col">Total Bayar</th>
                                            <th scope="col">Status Proses</th>
                                            <th scope="col">Pembayaran</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <?php $i = 1; ?>
                                    <?php foreach ($datatrans as $trans) : ?>
                                        <?php if ($trans['dibayar'] == 'belum_dibayar') {
                                            $status = "Belum Dibayar";
                                        }
                                        if ($trans['dibayar'] == 'dibayar') {
                                            $status = "Dibayar";
                                        }
                                        if ($trans['status'] == 'baru') {
                                            $alur = "Baru";
                                        }
                                        if ($trans['status'] == 'proses') {
                                            $alur = "Proses";
                                        }
                                        if ($trans['status'] == 'selesai') {
                                            $alur = "Selesai";
                                        }
                                        if ($trans['status'] == 'diambil') {
                                            $alur = "Diambil";
                                        } ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $trans['tgl'] ?></td>
                                            <td><?= $trans['kode_invoice'] ?></td>
                                            <td>
                                                <?php $idPelanggan = $trans['id_member'];
                                                $queryNama = "SELECT * FROM tb_member WHERE id = $idPelanggan";
                                                $execPelanggan = mysqli_query($conn, @$queryNama);
                                                $dataPelanggan = mysqli_fetch_assoc(@$execPelanggan);
                                                $nama = @$dataPelanggan['nama']; ?>
                                                <?= @$nama ?>
                                            </td>
                                            <td>
                                                <?php
                                                $transaksi = $trans['id'];
                                                $queryinclude = "SELECT * FROM tb_detail_transaksi WHERE id_transaksi = $transaksi";
                                                $execinclude = mysqli_query($conn, $queryinclude);
                                                $datainclude = mysqli_fetch_all($execinclude, MYSQLI_ASSOC);
                                                $total = [];
                                                foreach ($datainclude as $include) {
                                                    $quantity = $include['qty'];
                                                    $idpaket = $include['id_paket'];
                                                    $querytotal = "SELECT * FROM tb_paket WHERE id = $idpaket";
                                                    $exectotal = mysqli_query($conn, $querytotal);
                                                    $datatotal = mysqli_fetch_assoc($exectotal);
                                                    $total[] += $datatotal['harga'] * $quantity;
                                                }
                                                $hasil = count($total);
                                                $jumlahA = "0";
                                                $jumlahA;
                                                for ($i = 0; $i < $hasil; $i++) {
                                                    $jumlahA += $total[$i];
                                                }
                                                ?>
                                                <?= $jumlahA; ?>
                                            </td>
                                            <td><?= $status ?></td>
                                            <td><?= $alur ?></td>
                                            <td><a href="detail.php?idTransaksi=<?= $transaksi ?>&kode=<?= $trans['kode_invoice'] ?>">
                                                    <button class="btn btn-info" type="button"><i class=" bi bi-eraser"> detail</i></button>
                                                </a>
                                                <?php @include "hapus_riwayat.php"; ?></td>
                                        </tr>
                                        <?php $i++ ?>
                                    <?php endforeach; ?>
                                </table>
                            </div>
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