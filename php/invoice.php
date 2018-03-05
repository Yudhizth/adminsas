<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 27/02/2018
 * Time: 12.10
 */
require '../config/api.php';
$config = new Admin();
date_default_timezone_set('Asia/Jakarta');
$now = date("d-m-Y");


$dueDate= date('d-m-Y', strtotime($now. ' + 7 days'));

$spk = $_GET['kode'];

$IDSpk = substr($spk, 4, 5);

    $data = "SELECT tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.kode_perusahaan, tb_kerjasama_perusahan.kode_request, tb_kerjasama_perusahan.kode_plan, tb_kerjasama_perusahan.kode_list_karyawan, tb_kerjasama_perusahan.total_karyawan, tb_kerjasama_perusahan.type_time, tb_kerjasama_perusahan.deskripsi, tb_kerjasama_perusahan.tugas, tb_kerjasama_perusahan.tanggung_jwb, tb_kerjasama_perusahan.penempatan, tb_kerjasama_perusahan.kontrak_start, tb_kerjasama_perusahan.kontrak_end, tb_kerjasama_perusahan.nilai_kontrak, tb_perusahaan.nama_perusahaan, tb_perusahaan.bidang_perusahaan, tb_perusahaan.nomor_telp, tb_perusahaan.nomor_hp, tb_perusahaan.nomor_fax, tb_perusahaan.email, tb_perusahaan.website, tb_perusahaan.contact_person, tb_perusahaan.alamat, tb_perusahaan.kelurahan, tb_perusahaan.kecamatan, tb_perusahaan.kota FROM tb_kerjasama_perusahan
    INNER JOIN tb_perusahaan ON tb_perusahaan.kode_perusahaan = tb_kerjasama_perusahan.kode_perusahaan
  WHERE tb_kerjasama_perusahan.nomor_kontrak = :nomorKontrak";
    $data = $config->runQuery($data);
    $data->execute(array(':nomorKontrak'   => $spk));

    $info = $data->fetch(PDO::FETCH_LAZY);


    $kodeRequest = substr($info['kode_request'], 0, 3);


    if($kodeRequest == 'MPO'){
        $sql = "SELECT tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.kode_perusahaan, tb_kerjasama_perusahan.kode_request, tb_kerjasama_perusahan.kode_plan,  tb_kerjasama_perusahan.total_karyawan, tb_kerjasama_perusahan.type_time, tb_kerjasama_perusahan.tugas, tb_kerjasama_perusahan.tanggung_jwb, tb_kerjasama_perusahan.deskripsi, tb_kerjasama_perusahan.penempatan, tb_temporary_perusahaan.kebutuhan, tb_temporary_perusahaan.nama_project FROM tb_kerjasama_perusahan
INNER JOIN tb_temporary_perusahaan ON tb_temporary_perusahaan.no_pendaftaran = tb_kerjasama_perusahan.kode_request
WHERE tb_kerjasama_perusahan.nomor_kontrak = :kode";
        $BPO = $config->runQuery($sql);
        $BPO->execute(array(':kode' => $spk));
    }else{
        $sql = "SELECT tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.kode_perusahaan, tb_kerjasama_perusahan.kode_request, tb_kerjasama_perusahan.total_karyawan, tb_kerjasama_perusahan.type_time, tb_kerjasama_perusahan.tugas, tb_kerjasama_perusahan.tanggung_jwb, tb_kerjasama_perusahan.deskripsi, tb_kerjasama_perusahan.penempatan, tb_temporary_perusahaan.kebutuhan, tb_temporary_perusahaan.nama_project FROM tb_kerjasama_perusahan
INNER JOIN tb_temporary_perusahaan ON tb_temporary_perusahaan.no_pendaftaran = tb_kerjasama_perusahan.kode_request
WHERE tb_kerjasama_perusahan.nomor_kontrak = :kode";
        $BPO = $config->runQuery($sql);
        $BPO->execute(array(':kode' => $spk));
    }


//onload="window.print()"

?>

<link href="../build/css/custom.css" rel="stylesheet">
<link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<style>
    .invoice-info{
        padding-top: 2%;
    }
</style>


<body onload="window.print()">
<div class="row" id="printArea" >
    <div class="col-md-12">
        <div class="x_panel">

            <div class="x_content">

                <section class="content invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12 invoice-header">
                            <h1>
                                <i class="fa fa-building"></i> INVOICE.
                                <small class="pull-right">Date: <?=$now?></small>
                            </h1>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-5 invoice-col">
                            From
                            <address>
                                <strong>PT. SINERGIADHIKARYA</strong>
                                <br>Jl. Brigjen Katamso No. 07
                                <br>Slipi - Jakarta Barat 11420
                                <br>Phone: 021-56969777 Ext:232
                                <br>Email: crm@sinergiadhikarya.co.id
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-5 invoice-col" style="text-transform: capitalize;">
                            To
                            <address>
                                <strong><?=$info['nama_perusahaan']?></strong>
                                <br><?=$info['alamat']?>
                                <br><?=$info['kelurahan']?>-<?=$info['kota']?>
                                <br>Phone: <?=$info['nomor_telp']?>
                                <br>Email: <?=$info['email']?>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-2 invoice-col">
                            <b>Invoice #<?=$IDSpk?></b>
                            <br>
                            <br>
                            <b>Order ID:</b> <?=$spk?>
                            <br>
                            <b>Payment Due:</b> <?=$dueDate?>
                            <br>
                            <b>Account:</b> <?=$info['kode_perusahaan']?>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <?php if($kodeRequest == 'MPO'){ ?>
                        <div class="row">
                            <div class="col-xs-12 table">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="20%">List Kebutuhan</th>
                                        <th width="20%">Description</th>
                                        <th width="20%">Tugas</th>
                                        <th width="20%">Tanggung Jawab</th>
                                        <th width="20%">Penempatan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php while ($row = $BPO->fetch(PDO::FETCH_LAZY)){

                                        $list = $row['kode_plan'];
                                        $query = "SELECT tb_list_perkerjaan_perusahaan.code, tb_list_perkerjaan_perusahaan.name_list, tb_list_perkerjaan_perusahaan.total, tb_jenis_pekerjaan.nama_pekerjaan FROM tb_list_perkerjaan_perusahaan
                                                  INNER JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan = tb_list_perkerjaan_perusahaan.name_list 
                                                  WHERE tb_list_perkerjaan_perusahaan.code = :kode";
                                        $stmt = $config->runQuery($query);
                                        $stmt->execute(array(':kode' => $list));
                                        ?>
                                        <tr>
                                            <td>
                                               <table class="table table-striped">
                                                   <tbody>
                                                   <?php while($col = $stmt->fetch(PDO::FETCH_LAZY)){ ?>
                                                   <tr>
                                                       <td><?=$col['nama_pekerjaan']?></td>
                                                   </tr>
                                                    <?php } ?>
                                                   </tbody>
                                               </table>
                                            </td>
                                            <td><?=$row['deskripsi']?></td>
                                            <td><?=$row['tugas']?></td>
                                            <td><?=$row['tanggung_jwb']?></td>
                                            <td><?=$row['penempatan']?></td>
                                        </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                    <?php }else{ ?>

                        <div class="row">
                            <div class="col-xs-12 table">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="20%">Nama Project</th>
                                        <th width="20%">Description</th>
                                        <th width="20%">Tugas</th>
                                        <th width="20%">Tanggung Jawab</th>
                                        <th width="20%">Penempatan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php while ($row = $BPO->fetch(PDO::FETCH_LAZY)){ ?>
                                        <tr>
                                            <td><?=$row['kebutuhan']?> ~ <?=$row['nama_project']?></td>
                                            <td><?=$row['deskripsi']?></td>
                                            <td><?=$row['tugas']?></td>
                                            <td><?=$row['tanggung_jwb']?></td>
                                            <td><?=$row['penempatan']?></td>
                                        </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>

                    <?php } ?>
                    <!-- /.row -->

                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-xs-6">
                            <p class="lead">Payment Methods: <small style="font-size: 14px; color: #3238b9;"><b>TRANSFER</b></small></p>
<!--                            <img src="images/visa.png" alt="Visa">-->
<!--                            <img src="images/mastercard.png" alt="Mastercard">-->
<!--                            <img src="images/american-express.png" alt="American Express">-->
<!--                            <img src="images/paypal.png" alt="Paypal">-->
                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                               <span style="font-weight: 600; color: #4c1710;">Bank CIMB Niaga 8000-7359-8700 a.n PT. SINERGI ADHIKARYA SEMESTA</span>
                                <br>
                                <span style="font-weight: 600; color: #4c0f1b;">Bank Mandiri 1030-0067-11846 a.n SINERGI ADHIKARYA SEMESTA</span>

                            </p>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-6">
                            <p class="lead">Amount Due <?=$now?></p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td><?=number_format($info['nilai_kontrak'], 2, ",", ".")?></td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td><?=number_format($info['nilai_kontrak'], 2, ",", ".")?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- this row will not appear when printing -->

                </section>
            </div>
        </div>
    </div>
</div>
</body>
