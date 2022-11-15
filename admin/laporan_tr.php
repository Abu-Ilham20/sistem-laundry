<?php
session_start();

if (!isset($_SESSION['logadmin'])) {
    header("location: ../login.php");
    exit;
}

$page = "laporan";

include "../filelog.php";
include "../db.php";
//search tr

if (isset($_POST['search'])) {
    $first = date("Y-m-d H:i:s", strtotime($_POST["first"]));
    $last = date("Y-m-d H:i:s", strtotime($_POST["last"]));
    $Transaksi = "SELECT id,id_member FROM tb_transaksi WHERE tgl BETWEEN '$first' AND '$last'";
    $execTransaksi = mysqli_query($conn, $Transaksi);
    $dataTransaksi = mysqli_fetch_all($execTransaksi, MYSQLI_ASSOC);

    $semuaID = [];
    $semuaMember = [];
    foreach ($dataTransaksi as $transaksi) {
        $semuaID[] += $transaksi['id'];
        $semuaMember[] += $transaksi['id_member'];
    }
    $listQuery = [];
    $i = 0;
    foreach ($semuaID as $id) {
        $listQuery[$i] = "SELECT * FROM tb_detail_transaksi WHERE id_transaksi = $id";
        $i++;
    }
    $coba = true;
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

<body>
    <div id="app">
        <?php include "sidebar.php";
        ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <p class="fs-4" style="font-family:verdana; color: #59C1BD;">Laporan Transaksi</p>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <form action="" method="post">
                            <div class="card-content">
                                <div class="col-12">
                                    <div class="row p-4">
                                        <div class="col-4">
                                            <input type="datetime-local" class="form-control" name="first" id="" value="<?= @$first ?>">
                                        </div>
                                        <div class="col-4">
                                            <input type="datetime-local" class="form-control" name="last" id="" value="<?= @$last ?>">
                                        </div>
                                        <div class="col-3">
                                            <button type="submit" class="btn btn-secondary" name="search">search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php if (@$coba) {  ?>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card p-4">
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table class="table table-bordered border-primary" id="">
                                        <tr>
                                            <th class="col-1" style="font-family: times new roman; color: #11999E; font-style: italic;">No</th>
                                            <th class="col-2" style="font-family: times new roman; color: #11999E; font-style: italic;">Tanggal</th>
                                            <th class="col-1" style="font-family: times new roman; color: #11999E; font-style: italic;">Kode Invoice</th>
                                            <th class="col-2" style="font-family: times new roman; color: #11999E; font-style: italic;">Pelanggan</th>
                                            <th class="col-5" style="font-family: times new roman; color: #11999E; font-style: italic;">Layanan</th>
                                            <th class="col-1" style="font-family: times new roman; color: #11999E; font-style: italic;">Total Biaya</th>
                                        </tr>
                                        <?php $no = 1; ?>
                                        <?php $i = 0; ?>
                                        <?php $b = 0; ?>
                                        <?php $bayar = []; ?>
                                        <?php $totalHarga = [] ?>
                                        <?php foreach ($listQuery as $query) {
                                            // Detail Transaksi
                                            $execQuery = mysqli_query($conn, $query);
                                            $dataQuery = mysqli_fetch_assoc($execQuery);
                                            // Transaksi
                                            $idTransaksi = $semuaID[$i];
                                            $queryTransaksiSatu = "SELECT * FROM tb_transaksi WHERE id = $idTransaksi";
                                            $execTransaksiSatu = mysqli_query($conn, $queryTransaksiSatu);
                                            $dataTransaksiSatu = mysqli_fetch_assoc($execTransaksiSatu);
                                            // Pelanggan
                                            $idPelanggan = $semuaMember[$i];
                                            $queryPelanggan = "SELECT * FROM tb_member WHERE id = $idPelanggan";
                                            $execPelanggan = mysqli_query($conn, $queryPelanggan);
                                            $dataPelanggan = mysqli_fetch_assoc($execPelanggan);
                                            // Paket
                                            $queryPaket = "SELECT * FROM tb_detail_transaksi WHERE id_transaksi = $idTransaksi";
                                            $execPaket = mysqli_query($conn, $queryPaket);
                                            $dataPaket = mysqli_fetch_all($execPaket, MYSQLI_ASSOC);
                                            $beratPaket = [];
                                            $semuaPaket = [];
                                            foreach ($dataPaket as $paket) {
                                                $beratPaket[] += $paket['qty'];
                                                $semuaPaket[] += $paket['id_paket'];
                                            }
                                            // var_dump($semuaPaket, $beratPaket);
                                            $c = 0;
                                            foreach ($dataPaket as $hrg) {
                                                if ($hrg['id_paket'] == $semuaPaket[$c] && $hrg['id_transaksi'] == $idTransaksi) {
                                                    $idPaket = $hrg['id_paket'];
                                                    $queryHargaPaket = "SELECT * FROM tb_paket WHERE id = $idPaket";
                                                    $execHargaPaket = mysqli_query($conn, $queryHargaPaket);
                                                    $dataHargaPaket = mysqli_fetch_assoc($execHargaPaket);
                                                    $hargaPaket = $dataHargaPaket['harga'];
                                                    @$bayar[$i] += $beratPaket[$c] * $hargaPaket;
                                                    $c++;
                                                }
                                            }
                                        ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $dataTransaksiSatu['tgl'] ?></td>
                                                <td><?= $dataTransaksiSatu['kode_invoice'] ?></td>
                                                <td><?= $dataPelanggan['nama'] ?></td>
                                                <td>
                                                    <ul class="list-group">
                                                        <?php $a = 0;
                                                        foreach ($semuaPaket as $pkt) :
                                                            $idAmbilPaket = $semuaPaket[$a];
                                                            $queryAmbilPaket = "SELECT * FROM tb_paket WHERE id = $idAmbilPaket";
                                                            $execAmbilPaket = mysqli_query($conn, $queryAmbilPaket);
                                                            $dataAmbilPaket = mysqli_fetch_assoc($execAmbilPaket);
                                                        ?>
                                                            <li class="list-group-item"><?= $dataAmbilPaket['nama_paket'] ?> (<?= $beratPaket[$a] ?> Kg)</li>
                                                            <?php $a++ ?>
                                                        <?php endforeach ?>
                                                    </ul>
                                                </td>
                                                <td>Rp. <?= $bayar[$i]; ?></td>
                                            </tr>
                                            <?php $i++ ?>
                                            <?php $no++ ?>
                                        <?php } ?>


                                    </table>
                                </div>
                            </div>
                            <div class="mt-5 p-0">
                                <a href="cetak.php?tglawl=<?= $first ?>&tglakhir=<?= $last ?>" target="_blank">
                                    <button type="button  b " class="btn btn-danger">Print</button>
                                </a>
                            </div>
                        <?php } ?>
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