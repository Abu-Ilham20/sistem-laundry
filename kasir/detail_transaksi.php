<?php
$page = "transaksi";

session_start();
include "../filelog.php";
include "../db.php";
if (!isset($_SESSION['logkasir'])) {
    header("location: ../login.php");
    exit;
}

//ambil data dari tb pelanggan transaksi paket
$queryTransaksi = "SELECT * FROM tb_transaksi";
$execTransaksi = mysqli_query($conn, $queryTransaksi);
$dataTransaksi = mysqli_fetch_all($execTransaksi, MYSQLI_ASSOC);

$queryPelanggan = "SELECT * FROM tb_member";
$execPelanggan = mysqli_query($conn, $queryPelanggan);
$dataPelanggan = mysqli_fetch_all($execPelanggan, MYSQLI_ASSOC);

$queryUser = "SELECT * FROM tb_paket";
$execUser = mysqli_query($conn, $queryUser);
$dataUser = mysqli_fetch_all($execUser, MYSQLI_ASSOC);

$semuaHarga = [];
foreach ($dataUser as $paket) {
    $semuaHarga[] += $paket['harga'];
}

$semuaId = [];
foreach ($dataUser as $paket) {
    $semuaId[] += $paket['id'];
}

//invoice kode
$kode = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$outkode = "INV-" . substr(str_shuffle($kode), 0, 7);

if (isset($_POST['kirim'])) {
    $invoice = $_POST['random'];
    $id_pelanggan = $_POST['pelanggan'];
    $tanggal = $_POST['tgl'];
    $batasTanggal = $_POST['batastgl'];
    $tanggalBayar = $_POST['tglbayar'];
    $status = $_POST['status'];
    $statusBayar = $_POST['status_bayar'];
    $id_kasir = $_SESSION['id'];
    $queryTambah = "INSERT INTO `tb_transaksi` (`id`, `kode_invoice`, `id_member`, `tgl`, `batas_waktu`, `tgl_bayar`, `diskon`, `status`, `dibayar`, `id_user`) VALUES (NULL, '$invoice', '$id_pelanggan', '$tanggal', '$batasTanggal', '$tanggalBayar', '', '$status', '$statusBayar', '$id_kasir');";
    $execTambah = mysqli_query($conn, $queryTambah);

    $kode = $_POST['random'];
    $queryCek = "SELECT * FROM tb_transaksi WHERE kode_invoice = '$kode'";
    $execCek = mysqli_query($conn, $queryCek);
    if (mysqli_num_rows($execCek) == 1) {
        $dataTransaksi = mysqli_fetch_assoc($execCek);
        $idTransaksi = $dataTransaksi['id'];
        foreach ($dataUser as $nama_paket) {
            $namaPaket = $nama_paket['nama_paket'];
            $idPaket = $nama_paket['id'];
            $qty = $_POST["qty" . "$idPaket"];
            $keterangan = @$_POST["ket" . "$idPaket"];
            if ($qty > 0) {
                $queryTambahTransaksi = "INSERT INTO `tb_detail_transaksi` (`id`, `id_transaksi`, `id_paket`, `qty`, `keterangan`) VALUES (NULL, '$idTransaksi', '$idPaket', '$qty', '$keterangan');";
                $execTambah = mysqli_query($conn, $queryTambahTransaksi);
            }
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
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div class="card-header">
            <h2 style="color: #4649FF; font-family: perpetua; font-style: italic;">Halaman Transaksi pemesanan Laundry</h2>
        </div>
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header mb-0 pb-0">
                            <h4 class="card-title">Detail Transaksi</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" method="post">
                                    <div class="row">
                                        <div class="container mb-3">
                                            <div class="row">
                                                <div class="col mb-3">
                                                    <h6 class="text-center">Kode Invoice</h6>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center fs-5 text-center">
                                                <div class="col-6">
                                                    <input type="text" name="" id="" disabled value="<?= $outkode; ?>" class="text-center form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="">
                                                    <h6>Nama Pelanggan</h6>
                                                </label>
                                                <fieldset class="form-group">
                                                    <select class="form-select" id="basicSelect" name="pelanggan">
                                                        <?php foreach ($dataPelanggan as $pelanggan) : ?>
                                                            <option value="<?= $pelanggan['id']; ?>"><?= $pelanggan['nama']; ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="">
                                                    <h6>Masukkan Tanggal</h6>
                                                </label>
                                                <div>
                                                    <input type="datetime-local" class="form-control" name="tgl">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="">
                                                    <h6>Batas Waktu Pembayaran</h6>
                                                </label>
                                                <div>
                                                    <input type="datetime-local" class="form-control" name="batastgl">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="">
                                                    <h6>Tanggal Pembayaran</h6>
                                                </label>
                                                <div>
                                                    <input type="datetime-local" class="form-control" name="tglbayar">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="">
                                                    <h6>Status</h6>
                                                </label>
                                                <fieldset class="form-group">
                                                    <select class="form-select" id="basicSelect" name="status">
                                                        <option value="baru">Baru</option>
                                                        <option value="proses">Proses</option>
                                                        <option value="selesai">Selesai</option>
                                                        <option value="diambil">Diambil</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="">
                                                    <h6>Status Bayar</h6>
                                                </label>
                                                <fieldset class="form-group">
                                                    <select class="form-select" id="basicSelect" name="status_bayar">
                                                        <option value="dibayar">Dibayar</option>
                                                        <option value="belum_dibayar">Belum Dibayar</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="table-responsive"><br>
                                            <table class="table table-bordered border-info mb-0">
                                                <thead>
                                                    <tr style="font-family: didot; color: #A8E890;" class="fs-5">
                                                        <th>No</th>
                                                        <th>Nama Paket</th>
                                                        <th>Jenis</th>
                                                        <th>Harga (Rp)</th>
                                                        <th>Berat (Kg)</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 0; ?>
                                                    <?php foreach ($dataUser as $nama_paket) : ?>
                                                        <?php $no++; ?>
                                                        <tr>
                                                            <td><?= $no; ?></td>
                                                            <td><?= $nama_paket['nama_paket']; ?></td>
                                                            <td><?= $nama_paket['jenis']; ?></td>
                                                            <td>Rp. <?= $nama_paket['harga']; ?></td>
                                                            <td>
                                                                <input type="number" name="qty<?= $nama_paket['id']; ?>" id="qty<?= $nama_paket['id']; ?>" class="form-control" value="0" onkeyup="cekcek()">
                                                            </td>
                                                            <td><input type="text" name="ket<?= $nama_paket['id'] ?>" id="" class="form-control"></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row mt-lg-3 col-12">
                                            <div class="form-group col-5">
                                                <label for="">
                                                    <h6>Nama Kasir</h6>
                                                </label>
                                                <div>
                                                    <label for="" class="form-control" disabled><?= $_SESSION['nama'] ?></label>
                                                </div>
                                            </div>
                                            <div class="form-group col">
                                                <div class="float-end">
                                                    <h6>Total Harga :</h6>
                                                    <div class="mt-3">
                                                        <label class="form-control">Rp. <label id="tampil">0</label> </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="text" name="random" id="" class="visually-hidden" value="<?= $outkode; ?>">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" name="kirim" class="btn btn-primary mt-lg-3">Kirim</button>
                                        </div>
                                        <div class="form-check">
                                            <div class="checkbox">
                                                <input type="checkbox" id="checkbox5" class="form-check-input" checked="">
                                                <label for="checkbox5">Remember Me</label>
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
        <!-- ubah mode -->
        <script src="../dist/assets/js/app.js"></script>
        <script src="../dist/assets/js/bootstrap.js"></script>
        <script src="../dist/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
        <script src="../dist/assets/js/pages/simple-datatables.js"></script>
        <!--cek total-->
        <script>
            function cekcek() {
                var tampil = document.getElementById('tampil');
                <?php $no = 0 ?>
                var harga = [];
                <?php foreach ($semuaHarga as $harga) { ?>
                    harga[<?= $no ?>] = <?= $harga ?>;
                    <?php $no++ ?>
                <?php } ?>
                var idPaket = [];
                <?php $v = 0 ?>
                <?php foreach ($semuaId as $paketId) { ?>
                    idPaket[<?= $v ?>] = <?= $paketId ?>;
                    <?php $v++ ?>
                <?php } ?>
                <?php $s = 0 ?>
                var totalHarga = 0;
                <?php foreach ($dataUser as $nama_paket) : ?>
                    <?php $idKetPa = $nama_paket['id'] ?>
                    var inputan = document.getElementById('qty' + '<?= $idKetPa ?>').value
                    if (inputan > 0) {
                        totalHarga += (parseInt(inputan) * parseInt(harga[<?= $s ?>]));
                    }
                    <?php $s++ ?>
                <?php endforeach ?>
                tampil.innerHTML = totalHarga;
                console.log(totalHarga);
            }
        </script>
</body>

</html>