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
$now = date("Y-m-d");


$dueDate= date('Y-m-d', strtotime($now. ' + 7 days'));

$spk = $_GET['kode'];
$termID = $_GET['id'];

$IDSpk = substr($spk, 4, 5);

    $data = "SELECT tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.kode_perusahaan, tb_kerjasama_perusahan.kode_request, tb_kerjasama_perusahan.kode_plan, tb_kerjasama_perusahan.kode_list_karyawan, tb_kerjasama_perusahan.total_karyawan, tb_kerjasama_perusahan.type_time, tb_kerjasama_perusahan.deskripsi, tb_kerjasama_perusahan.tugas, tb_kerjasama_perusahan.tanggung_jwb, tb_kerjasama_perusahan.penempatan, tb_kerjasama_perusahan.kontrak_start, tb_kerjasama_perusahan.kontrak_end, tb_kerjasama_perusahan.nilai_kontrak, tb_kerjasama_perusahan.lembur, tb_perusahaan.nama_perusahaan, tb_perusahaan.bidang_perusahaan, tb_perusahaan.nomor_telp, tb_perusahaan.nomor_hp, tb_perusahaan.nomor_fax, tb_perusahaan.email, tb_perusahaan.website, tb_perusahaan.contact_person, tb_perusahaan.alamat, tb_perusahaan.kelurahan, tb_perusahaan.kecamatan, tb_perusahaan.kota, tb_term_pembayaran.nama_term, tb_term_pembayaran.due_date, tb_term_pembayaran.keterangan FROM tb_kerjasama_perusahan
    INNER JOIN tb_perusahaan ON tb_perusahaan.kode_perusahaan = tb_kerjasama_perusahan.kode_perusahaan
    INNER JOIN tb_term_pembayaran ON tb_term_pembayaran.kode_term=tb_kerjasama_perusahan.nomor_kontrak
  WHERE tb_kerjasama_perusahan.nomor_kontrak = :nomorKontrak AND tb_term_pembayaran.id = :idTerm ";
    $data = $config->runQuery($data);
    $data->execute(array(':nomorKontrak'   => $spk, ':idTerm'   => $termID));

    $info = $data->fetch(PDO::FETCH_LAZY);


    $kodeRequest = substr($info['kode_request'], 0, 3); //cek type MPO,BPO, dll

    $termKe = explode('-',$info['nama_term']);

    if($termKe[1] == '1'){
        $starLembur = $info['kontrak_start'];
        $endLembur = $info['due_date'];

        //echo 'start: '.$starLembur. ' ends: '.$endLembur;
    }else{
        $termKe = $termKe[1] - 1;
        $termKe = 'Pembayaran Ke-'.$termKe;

        $sql = "SELECT * FROM tb_term_pembayaran WHERE nama_term LIKE :termKe";
        $cek = $config->runQuery($sql);
        $cek->execute(array(':termKe'   => $termKe));

        $hasil = $cek->fetch(PDO::FETCH_LAZY);

        $starLembur = $hasil['due_date'];
        $endLembur = $info['due_date'];

        //echo 'start: '.$starLembur. ' ends: '.$endLembur;
    }


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

    //term pembayaran
    $tt = "SELECT * FROM tb_term_pembayaran WHERE id = :id";
    $term = $config->runQuery($tt);
    $term->execute(array(':id'  => $termID));

    //cek lembur

    $qq = "SELECT tb_lembur.kode_lembur, tb_lembur.no_ktp, tb_lembur.keterangan, tb_lembur.tanggal, tb_lembur.status, tb_lembur.jam, tb_lembur.admin,
  tb_karyawan.nama_depan, tb_karyawan.nama_belakang
  FROM tb_lembur 
    INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_lembur.no_ktp
    WHERE tb_lembur.tanggal BETWEEN :start AND :ends AND tb_lembur.kode_lembur = :kode AND tb_lembur.status = '1'
    ORDER BY tb_lembur.tanggal ASC
    ";
    $lembur = $config->runQuery($qq);
    $lembur->execute(array(
            ':start'    =>$starLembur,
            ':ends'     =>$endLembur,
            ':kode'     => $spk
    ));

    $qq2 = "SELECT SUM(tb_lembur.jam) AS totalJam
  FROM tb_lembur WHERE tb_lembur.tanggal BETWEEN :start AND :ends AND tb_lembur.kode_lembur = :kode AND tb_lembur.status = '1'";

    $lembur2 = $config->runQuery($qq2);
    $lembur2->execute(array(
        ':start'    =>$starLembur,
        ':ends'     =>$endLembur,
        ':kode'     => $spk
    ));

    $infoLembur = $lembur2->fetch(PDO::FETCH_LAZY);

    $totalLembur = $infoLembur['totalJam'] * $info['lembur'];

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
    .main-payment{
        padding-top: -20px;
    }
    .lampiran{
        margin-top: 60%;
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
                    <div class="main-payment">
                        <h4><b>Main Payment</b></h4>
                        <div class="row">
                            <div class="col-xs-12 table" style="margin-bottom: unset !important;">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="10%">#</th>
                                        <th width="20%">Name Item</th>
                                        <th width="20%">Due Date</th>
                                        <th width="20%">Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; while ($row = $term->fetch(PDO::FETCH_LAZY)){ ?>
                                        <tr>
                                            <td><?=$i++?></td>
                                            <td><?=$row['nama_term']?></td>
                                            <td><?=date('d M Y', strtotime($row['due_date']))?></td>
                                            <td style="text-align: right"><?=number_format($row['keterangan'], 0, ',', '.')?></td>
                                        </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="lembur-payment">
                        <h4><b>Lembur Payment Periode: <?=date('d M  Y', strtotime($starLembur)) ?> ~ <?=date('d M Y', strtotime($endLembur))?></b></h4>
                        <div class="row">
                            <div class="col-xs-12 table">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="20%">Karyawan</th>
                                        <th width="20%">Tanggal</th>
                                        <th width="20%">Keterangan</th>
                                        <th width="20%">Total Jam</th>
                                        <th width="20%">Satuan</th>
                                        <th width="20%">Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($lembur->rowCount() > 0) { $i = 1; while ($row = $lembur->fetch(PDO::FETCH_LAZY)){
                                        ?>
                                        <tr>
                                            <td><?=$row['nama_depan']?> <?=$row['nama_belakang']?></td>
                                            <td><?=date('d M Y H:s', strtotime($row['tanggal']))?></td>
                                            <td><?=$row['keterangan']?></td>
                                            <td><?=$row['jam']?> jam</td>
                                            <td><?=number_format($info['lembur'], 0, ',', '.')?> /jam</td>
                                            <td style="text-align: right">
                                                <?php

                                                $subtotal = $row['jam'] * $info['lembur'];
                                                echo number_format($subtotal, 0, ',', '.')
                                                ?>

                                            </td>
                                        </tr>

                                    <?php } ?>
                                        <tr>
                                            <td colspan="5" style="text-align: center; font-weight: 600;">Total Lembur :</td>
                                            <td style="text-align: right; font-weight: 600;"><?=number_format($totalLembur, 0, ',','.')?></td>
                                        </tr>
                                    <?php }else{ ?>
                                        <td colspan="7" style="text-align: center; font-size: 14px; font-weight: 600;">Tidak Ada Lembur</td>
                                    <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->

                    <div class="row" >
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
                                        <th style="width:50%; "><?=$info['nama_term']?> :</th>
                                        <td style="text-align: right; font-weight: 600"><?=number_format($info['keterangan'], 2, ",", ".")?></td>
                                    </tr>
                                    <tr>
                                        <th style="width:50%;">Subtotal Lembur :</th>
                                        <td style="text-align: right; font-weight: 600"><?=number_format($totalLembur, 2, ",", ".")?></td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td style="text-align: right; font-weight: 600">
                                            <?php

                                        $total = $info['keterangan'] + $totalLembur;

                                        echo number_format($total, 2, ",", ".");
                                        ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="lampiran" style="display: none;">
                        <h4><b>Lampiran</b></h4>
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
                        <?php }
                        else{ ?>
                            <div class="row">
                                <div class="col-xs-12 table" style="margin-bottom: unset !important;">
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
                    </div>
                    <!-- this row will not appear when printing -->

                </section>
            </div>
        </div>
    </div>
</div>
</body>
