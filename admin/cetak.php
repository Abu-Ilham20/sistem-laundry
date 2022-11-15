<?php session_start();
if (!isset($_SESSION['logadmin'])) {
    header("location: ../login.php");
    exit;
}



include "../db.php";


$first = $_GET['tglawl'];
$last = $_GET['tglakhir'];
// var_dump($first, $last);
$queryTransaksi = "SELECT id,id_member FROM tb_transaksi WHERE tgl BETWEEN '$first' AND '$last'";
$execTransaksi = mysqli_query($conn, $queryTransaksi);
$dataTransaksi = mysqli_fetch_all($execTransaksi, MYSQLI_ASSOC);
// var_dump($dataTransaksi);
$semuaId = [];
$semuaPelanggan = [];
foreach ($dataTransaksi as $transaksi) {
    $semuaId[] += $transaksi['id'];
    $semuaPelanggan[] += $transaksi['id_member'];
}
// var_dump($semuaId);
$listQuery = [];
$i = 0;
foreach ($semuaId as $id) {
    $listQuery[$i] = "SELECT * FROM tb_detail_transaksi WHERE id_transaksi = $id";
    $i++;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak</title>
    <link rel="stylesheet" href="../assets/css/main/app.css">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.png" type="image/png">
    <link rel="stylesheet" href="../assets/css/shared/iconly.css">
</head>

<body onload="window.print();">
    <div class="container">
        <div class="card">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-sm-2 float-left">
                        <img src="../OIP.jpeg" width="95px" alt="brand">
                    </div>
                    <div class="col-sm-10 float-left">
                        <h3>SUCI LAUNDRY</h3>
                        <h6>Jl. SetiaBudi, Kab. Karanganyar, Kec. MojoSongo, Tlp 081297645627</h6>
                        <h6>@cisucicuci</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!--rows -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card p-4">
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0 p-0">
                                        <tr>
                                            <th class="col-1">No</th>
                                            <th class="col-2">Tanggal</th>
                                            <th class="col-1">Kode Invoice</th>
                                            <th class="col-2">Pelanggan</th>
                                            <th class="col-5 ">Layanan</th>
                                            <th class="col-1">Total Biyaya</th>
                                        </tr>
                                        <?php $no = 1; ?>
                                        <?php $i = 0; ?>
                                        <?php $b = 0; ?>
                                        <?php $bayar = []; ?>

                                        <?php foreach ($listQuery as $query) {
                                            // Detail Transaksi
                                            $execQuery = mysqli_query($conn, $query);
                                            $dataQuery = mysqli_fetch_assoc($execQuery);
                                            // Transaksi
                                            $idTransaksi = $semuaId[$i];
                                            $queryTransaksiSatu = "SELECT * FROM tb_transaksi WHERE id = $idTransaksi";
                                            $execTransaksiSatu = mysqli_query($conn, $queryTransaksiSatu);
                                            $dataTransaksiSatu = mysqli_fetch_assoc($execTransaksiSatu);
                                            // Pelanggan
                                            $idPelanggan = $semuaPelanggan[$i];
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
                                        <?php $totalHarga ?>
                                        <?php foreach ($bayar as $test) {
                                            @$totalHarga += $test;
                                        } ?>
                                        <tr>
                                            <td colspan="5">Total</td>
                                            <td>Rp. <?= $totalHarga ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="../assets/js/bootstrap.js"></script>
<script src="../assets/js/app.js"></script>
</body>

</html>