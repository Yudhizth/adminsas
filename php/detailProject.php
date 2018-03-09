<?php

$id = $_GET['id'];

    $query = 'SELECT tb_kerjasama_perusahan.id, tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.kode_perusahaan, tb_kerjasama_perusahan.kode_request, tb_kerjasama_perusahan.kode_plan, tb_kerjasama_perusahan.kode_list_karyawan, tb_kerjasama_perusahan.total_karyawan, tb_kerjasama_perusahan.type_time, tb_kerjasama_perusahan.deskripsi, tb_kerjasama_perusahan.tugas, tb_kerjasama_perusahan.tanggung_jwb, tb_kerjasama_perusahan.penempatan, tb_kerjasama_perusahan.kontrak_start, tb_kerjasama_perusahan.kontrak_end, tb_kerjasama_perusahan.nilai_kontrak, tb_kerjasama_perusahan.tgl_input, tb_perusahaan.nama_perusahaan, tb_perusahaan.bidang_perusahaan, tb_kategori_pekerjaan.nama_kategori, tb_temporary_perusahaan.kebutuhan, tb_temporary_perusahaan.kode_pekerjaan, tb_temporary_perusahaan.nama_project FROM tb_kerjasama_perusahan
    
    LEFT JOIN tb_perusahaan ON tb_perusahaan.kode_perusahaan = tb_kerjasama_perusahan.kode_perusahaan
    LEFT JOIN tb_temporary_perusahaan ON tb_temporary_perusahaan.no_pendaftaran=tb_kerjasama_perusahan.kode_request
    LEFT JOIN tb_kategori_pekerjaan ON tb_kategori_pekerjaan.kode_kategori=tb_temporary_perusahaan.kebutuhan
    
    WHERE tb_kerjasama_perusahan.nomor_kontrak = :nomor ';

    $stmt = $config->runQuery($query);
    $stmt->execute(array(':nomor' => $id));

    $data = $stmt->fetch(PDO::FETCH_LAZY);

    $typeRequest = substr($data['kode_request'], 0, 3);
    //echo "<pre>";
    //print_r($data);
    //echo "</pre>";

    $nilai = number_format($data['nilai_kontrak'], 0, ',', '.');

    $tglStart0 = strtotime($data['kontrak_start']);
    $tglStart = date("d/m/Y", $tglStart0);
    $countStart = date("Ymd", $tglStart0);

    $tglEnd0 = strtotime($data['kontrak_end']);
    $tglEnd = date("d/m/Y", $tglEnd0);
    $countEnd = date("Ymd", $tglEnd0);

    $total = $countEnd - $countStart;

    $days = floor($total / (60 * 60 * 24));

    //show karyawan

    $kodeListKaryawan = $data['kode_list_karyawan'];

//    form addJabatn karyawan

//list jabatan

    $bb = "SELECT * FROM tb_list_jabatan";
    $jb = $config->runQuery($bb);
    $jb->execute();


    //maps

    $maps = "SELECT * FROM tb_koordinat_perusahaan WHERE nomor_kontrak = :nomorKontrak";
    $maps = $config->runQuery($maps);
    $maps->execute(array(':nomorKontrak' => $id));

//list kayrawan project
    $kk = "SELECT tb_list_karyawan.id, tb_list_karyawan.kode_list_karyawan, tb_list_karyawan.no_nip, tb_karyawan.nama_depan, tb_karyawan.nama_belakang FROM tb_list_karyawan
INNER  JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_list_karyawan.no_nip
WHERE tb_list_karyawan.kode_list_karyawan = :kodelist";
    $ls = $config->runQuery($kk);
    $ls->execute(array(
            ':kodelist' => $kodeListKaryawan
    ));
    //list jabatan karyawan project
    $km = "SELECT tb_list_karyawan.kode_list_karyawan, tb_list_karyawan.no_nip, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_list_jabatan.id, tb_list_jabatan.nama_jabatan
    FROM tb_list_karyawan
    INNER JOIN tb_karyawan ON tb_karyawan.no_ktp=tb_list_karyawan.no_nip
    INNER JOIn tb_list_jabatan ON tb_list_jabatan.id = tb_list_karyawan.kode_jabatan
    WHERE tb_list_karyawan.kode_list_karyawan = :kode";
    $ky = $config->runQuery($km);
    $ky->execute(array(
            ':kode' => $kodeListKaryawan
    ));


    if($typeRequest == 'MPO'){
        $sql = "SELECT tb_list_karyawan.kode_list_karyawan, tb_list_karyawan.no_nip, tb_list_karyawan.kode_jabatan, tb_list_karyawan.status_karyawan, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.jenis_kelamin, tb_karyawan.email, tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.kode_list_karyawan, tb_list_karyawan.kode_pekerjaan, tb_jenis_pekerjaan.nama_pekerjaan
FROM tb_list_karyawan INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_list_karyawan.no_nip
LEFT JOIN tb_kerjasama_perusahan ON tb_kerjasama_perusahan.kode_list_karyawan = tb_list_karyawan.kode_list_karyawan
LEFT JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan = tb_list_karyawan.kode_pekerjaan
WHERE tb_kerjasama_perusahan.kode_list_karyawan = :kode";
    }else{
        $sql = "SELECT tb_list_karyawan.id, tb_list_karyawan.kode_list_karyawan, tb_list_karyawan.no_nip, tb_list_karyawan.kode_jabatan, tb_list_jabatan.nama_jabatan, tb_list_karyawan.status_karyawan, 
tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_kerjasama_perusahan.nomor_kontrak 
    FROM tb_list_karyawan 
    LEFT JOIN tb_list_jabatan ON tb_list_jabatan.id = tb_list_karyawan.kode_jabatan
    INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_list_karyawan.no_nip 
    INNER JOIN tb_kerjasama_perusahan ON tb_kerjasama_perusahan.kode_list_karyawan = tb_list_karyawan.kode_list_karyawan 
    WHERE tb_list_karyawan.kode_list_karyawan = :kode ";
    }

    $cek = $config->runQuery($sql);
    $cek->execute(array(
            ':kode' => $kodeListKaryawan
    ));
    $aa = "SELECT tb_job.nomor_kontrak, tb_job.id, tb_job.kode_detail_job, tb_job.title, tb_job.type, tb_job.status, tb_jenis_pekerjaan.nama_pekerjaan
    FROM tb_job 
    LEFT JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan=tb_job.title
    WHERE tb_job.nomor_kontrak = :kode ";
    $jobs = $config->runQuery($aa);
    $jobs->execute(array(
        ':kode' => $id
    ));

    if($data['type_time'] == 'fix'){
        $typeTime = "SELECT * FROM tb_time_fix WHERE nomor_spk = :spknomor";
        $typeTime = $config->runQuery($typeTime);
        $typeTime->execute(array(':spknomor'  => $id));
    }else{
        $typeTime = "SELECT * FROM tb_time_fleksible WHERE nomor_spk = :spknomor";
        $typeTime = $config->runQuery($typeTime);
        $typeTime->execute(array(':spknomor'  => $id));
    }

    // report jobs

    $o = "SELECT tb_report_job.id, tb_report_job.no_NIP, tb_report_job.kode_report, tb_report_job.report, tb_report_job.report_date, tb_report_job.rating, tb_list_job.kode_detail_job, tb_list_job.nama_job, tb_job.title, tb_job.status, tb_job.nomor_kontrak, tb_karyawan.nama_depan, tb_karyawan.nama_belakang
    FROM tb_report_job 
    INNER JOIN tb_list_job ON tb_list_job.id = tb_report_job.kode_detail_job
    INNER JOIN tb_job ON tb_job.kode_detail_job = tb_list_job.kode_detail_job
    INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_report_job.no_NIP
    WHERE tb_job.nomor_kontrak = :nomor 
    ";

    $report = $config->runQuery($o);
    $report->execute(array(
            ':nomor'    => $id
    ));



?>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Detail Project</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <div class="col-md-9 col-sm-9 col-xs-12">

                    <ul class="stats-overview">
                        <li>
                            <span class="name"> Total budget </span>
                            <span class="value text-success"> Rp. <?=$nilai?> </span>
                        </li>
                        <li>
                            <span class="name"> Total Karyawan </span>
                            <span class="value text-success"> <?=$data['total_karyawan']?> </span>
                        </li>
                        <li class="hidden-phone">
                            <span class="name"> Project duration </span>
                            <span class="value text-success"> <?=$tglStart?> ~ <?=$tglEnd?></span>
                        </li>
                    </ul>
                    <br>

                    <div id="mainb"
                         style="height: 350px; -webkit-tap-highlight-color: transparent; user-select: none; position: relative; background-color: transparent;"
                         _echarts_instance_="ec_1517751564586">
                        <div style="position: relative; overflow: hidden; width: 930px; height: 350px; cursor: default;">
                            <canvas width="930" height="350" data-zr-dom-id="zr_0"
                                    style="position: absolute; left: 0px; top: 0px; width: 930px; height: 350px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></canvas>
                        </div>
                        <div style="position: absolute; display: none; border-style: solid; white-space: nowrap; z-index: 9999999; transition: left 0.4s cubic-bezier(0.23, 1, 0.32, 1), top 0.4s cubic-bezier(0.23, 1, 0.32, 1); background-color: rgba(0, 0, 0, 0.5); border-width: 0px; border-color: rgb(51, 51, 51); border-radius: 4px; color: rgb(255, 255, 255); font-style: normal; font-variant: normal; font-weight: normal; font-stretch: normal; font-size: 14px; font-family: Arial, Verdana, sans-serif; line-height: 21px; padding: 5px; left: 516px; top: 93px;">
                            7?<br><span
                                    style="display:inline-block;margin-right:5px;border-radius:10px;width:9px;height:9px;background-color:#26B99A"></span>sales
                            : 135.6<br><span
                                    style="display:inline-block;margin-right:5px;border-radius:10px;width:9px;height:9px;background-color:#34495E"></span>purchases
                            : 175.6
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" id="componenProject">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2><i class="fa fa-align-left"></i> Componen Project</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Settings 1</a>
                                                </li>
                                                <li><a href="#">Settings 2</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <div class="x_content">


                                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                                <li role="presentation" class=""><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">List Karyawan</a>
                                                </li>
                                                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">List Jobs</a>
                                                </li>
                                                <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Jabatan</a>
                                                </li>
                                                <li role="presentation" class=""><a href="#tab_content4" role="tab" id="absen-tab2" data-toggle="tab" aria-expanded="false">Waktu Absen</a>
                                                </li>
                                                <li role="presentation" class=""><a href="#tab_content5" role="tab" id="report-tab2" data-toggle="tab" aria-expanded="false">Report Jobs</a>
                                                </li>
                                            </ul>
                                            <div id="myTabContent" class="tab-content">
                                                <div role="tabpanel" class="tab-pane fade" id="tab_content1" aria-labelledby="home-tab">
                                                    <a href="?p=karyawan-project&id=<?=$id?>" class="btn btn-sm btn-primary" style="text-transform: capitalize;">add and remove karyawan</a>
                                                    <br>
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nomor NIP</th>
                                                            <th>Nama Lengkap</th>
                                                            <th>Jabatan</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php if($typeRequest == 'MPO'){
                                                            $i = 1;
                                                            while($col = $cek->fetch(PDO::FETCH_LAZY)){ ?>
                                                                <tr>
                                                                    <th scope="row"><?=$i++?></th>
                                                                    <td><?=$col['no_nip']?></td>
                                                                    <td><?=$col['nama_depan']?> <?=$col['nama_belakang']?></td>
                                                                    <td><?=$col['nama_pekerjaan']?></td>
                                                                </tr>
                                                            <?php }
                                                        }else{ if($cek->rowCount() > 0){
                                                            $i = 1;
                                                        while ($col = $cek->fetch(PDO::FETCH_LAZY)){
                                                            if(empty($col['nama_jabatan'])){
                                                                $jabatan = '<span class="label label-default">unset</span>';
                                                            }else{
                                                                $jabatan = "";
                                                            }
                                                            ?>
                                                        <tr>
                                                            <th scope="row"><?=$i++?></th>
                                                            <td><?=$col['no_nip']?></td>
                                                            <td><?=$col['nama_depan']?> <?=$col['nama_belakang']?></td>
                                                            <td><?=$jabatan?></td>
                                                        </tr>
                                                       <?php } } else { ?>
                                                            <tr>
                                                                <td colspan="">

                                                                </td>
                                                            </tr>
                                                        <?php }}?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                                    <?php if ($typeRequest == 'MPO') { ?>
                                                        <a href="?p=add-list-job&name=<?=$id?>" class="btn btn-sm btn-primary" style="text-transform: capitalize;">add and remove Jobs</a>
                                                        <br>
                                                        <?php while ($job = $jobs->fetch(PDO::FETCH_LAZY)) {
                                                            if ($job['type'] == 'main') {
                                                                $panel = "panel-success";
                                                            } else {
                                                                $panel = "panel-info";
                                                            }
                                                            ?>

                                                            <div class="panel-group" role="tablist" id="listDetail">
                                                                <div class="panel <?= $panel ?> ">

                                                                    <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
                                                                        <a href="#<?= $job['kode_detail_job'] ?>" class="" role="button" data-toggle="collapse"
                                                                           aria-expanded="true" aria-controls="collapseListGroup1">
                                                                            <h4 class="panel-title">
                                                                                <?= $job['nama_pekerjaan'] ?>
                                                                            </h4>
                                                                        </a>
                                                                    </div>

                                                                    <div class="panel-collapse collapse" role="tabpanel" id="<?= $job['kode_detail_job'] ?>"
                                                                         aria-labelledby="collapseListGroupHeading1" aria-expanded="false" style="">
                                                                        <br/>
                                                                        <div class="x_content">
                                                                        </div>

                                                                        <br/>
                                                                        <div class="x_content" style="padding-bottom: 2%; padding-left: 1%; padding-right: 1%;"
                                                                             id="tableDetail">
                                                                            <table class="table">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th width="30%">Kegiatan</th>
                                                                                    <th width="40%">Deskripsi</th>
                                                                                    <th width="40%">Keterangan</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php
                                                                                $detail = $job['kode_detail_job'];

                                                                                $detaildata = "SELECT * FROM tb_list_job where kode_detail_job = :dd";
                                                                                $sys = $config->runQuery($detaildata);
                                                                                $sys->execute(array(':dd' => $detail));

                                                                                $total = $sys->rowCount();
                                                                                if ($total > 0) {
                                                                                    while ($detailJobs = $sys->fetch(PDO::FETCH_LAZY)) {
                                                                                        ?>
                                                                                        <tr style="text-transform: capitalize;">
                                                                                            <td><?= $detailJobs['nama_job'] ?></td>
                                                                                            <td><?= $detailJobs['deskripsi_job'] ?></td>
                                                                                            <td><?= $detailJobs['keterangan'] ?></td>

                                                                                        </tr>
                                                                                        <?php
                                                                                    }
                                                                                } else {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td colspan="4">Kegiatan belum ada.</td>
                                                                                    </tr>

                                                                                <?php } ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        <div class="clearfix"></div>

                                                                        <div class="panel-footer">Footer</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>

                                                    <?php } else {  ?>
                                                        <a href="?p=add-list-job&name=<?=$id?>" class="btn btn-sm btn-primary" style="text-transform: capitalize;">add and remove jobs</a>
                                                        <br>
                                                        <?php  while ($job = $jobs->fetch(PDO::FETCH_LAZY)) {
                                                            if ($job['type'] == 'main') {
                                                                $panel = "panel-success";
                                                            } else {
                                                                $panel = "panel-info";
                                                            }
                                                            ?>


                                                            <div class="panel-group" role="tablist" id="listDetail">
                                                                <div class="panel <?= $panel ?> ">

                                                                    <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
                                                                        <a href="#<?= $job['kode_detail_job'] ?>" class="" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapseListGroup1">
                                                                            <h4 class="panel-title">
                                                                                <?= $job['title'] ?>
                                                                            </h4>
                                                                        </a>

                                                                    </div>

                                                                    <div class="panel-collapse collapse" role="tabpanel" id="<?= $job['kode_detail_job'] ?>"
                                                                         aria-labelledby="collapseListGroupHeading1" aria-expanded="false" style="">
                                                                        <br/>
                                                                        <div class="x_content">
                                                                        </div>
                                                                        <br/>
                                                                        <div class="x_content" style="padding-bottom: 2%; padding-left: 1%; padding-right: 1%;"
                                                                             id="tableDetail">
                                                                            <table class="table">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th width="30%">Kegiatan</th>
                                                                                    <th width="40%">Deskripsi</th>
                                                                                    <th width="40%">Keterangan</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php
                                                                                $detail = $job['kode_detail_job'];

                                                                                $detaildata = "SELECT * FROM tb_list_job where kode_detail_job = :dd";
                                                                                $sys = $config->runQuery($detaildata);
                                                                                $sys->execute(array(':dd' => $detail));

                                                                                $total = $sys->rowCount();
                                                                                if ($total > 0) {
                                                                                    while ($detailJob = $sys->fetch(PDO::FETCH_LAZY)) {
                                                                                        ?>
                                                                                        <tr style="text-transform: capitalize;">
                                                                                            <td><?= $detailJob['nama_job'] ?></td>
                                                                                            <td><?= $detailJob['deskripsi_job'] ?></td>
                                                                                            <td><?= $detailJob['keterangan'] ?></td>
                                                                                            <td>
                                                                                        </tr>
                                                                                        <?php
                                                                                    }
                                                                                } else {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td colspan="4">Kegiatan belum ada.</td>
                                                                                    </tr>

                                                                                <?php } ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        <div class="clearfix"></div>

                                                                        <div class="panel-footer">Footer</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>

                                                    <?php } ?>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".tambahJabatanKaryawan">Assign Jabatan</button>
                                                    <table class="table table-bordered tabel-hover">
                                                        <thead>
                                                        <th>NOMOR NIP</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Jabatan</th>
                                                        <th>#</th>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        if($ky->rowCount() > 0){
                                                        while ($mm = $ky->fetch(PDO::FETCH_LAZY)){ ?>
                                                        <tr>
                                                            <td><?=$mm['no_nip']?></td>
                                                            <td><?=$mm['nama_depan']?> <?=$mm['nama_belakang']?></td>
                                                            <td><?=$mm['nama_jabatan']?></td>
                                                            <td>action</td>
                                                        </tr>
                                                        <?php }}else{ ?>
                                                        <tr>
                                                            <td colspan="4">Jabatan Karyawan belum di tambah!</td>
                                                        </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="absen-tab">
                                                    Waktu Absen : <?=$data['type_time']?>
                                                    <table class="table table-bordered tabel-hover">
                                                        <thead>
                                                        <th>Minggu</th>
                                                        <th>Senin</th>
                                                        <th>Selasa</th>
                                                        <th>Rabu</th>
                                                        <th>Kamis</th>
                                                        <th>Jumat</th>
                                                        <th>Sabtu</th>
                                                        <th>#</th>
                                                        </thead>
                                                        <tbody>
                                                        <?php while ($row = $typeTime->fetch(PDO::FETCH_LAZY)){ ?>
                                                            <tr>
                                                                <td><?=$row['minggu']?></td>
                                                                <td><?=$row['senin']?></td>
                                                                <td><?=$row['selasa']?></td>
                                                                <td><?=$row['rabu']?></td>
                                                                <td><?=$row['kamis']?></td>
                                                                <td><?=$row['jumat']?></td>
                                                                <td><?=$row['sabtu']?></td>
                                                                <td></td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="report-tab">
                                                    <a href="?p=karyawan-project&id=<?=$id?>" class="btn btn-sm btn-primary" style="text-transform: capitalize;">Views Report</a>
                                                    <br>
                                                    <table class="table table-bordered tabel-hover">
                                                        <thead>
                                                        <th>Nama Karyawan</th>
                                                        <th>Jobs</th>
                                                        <th>Report</th>
                                                        <th>Rating</th>
                                                        <th>Report Date</th>
                                                        <th>Action</th>
                                                        </thead>
                                                        <tbody style="text-transform: capitalize;">
                                                        <?php while ($row = $report->fetch(PDO::FETCH_LAZY)){
                                                            if(!empty($row['rating'])){
                                                                switch ($row['rating']){
                                                                    case "5":
                                                                    $rating = "<span class='fa fa-star'></span> <span class='fa fa-star'></span> <span class='fa fa-star'></span>
                                                                                <span class='fa fa-star'></span> <span class='fa fa-star'></span>";
                                                                    break;
                                                                    case "4":
                                                                        $rating = "<span class='fa fa-star'></span> <span class='fa fa-star'></span> <span class='fa fa-star'></span>
                                                                                <span class='fa fa-star'></span> ";
                                                                        break;
                                                                    case "3":
                                                                        $rating = "<span class='fa fa-star'></span> <span class='fa fa-star'></span> <span class='fa fa-star'></span>
                                                                                ";
                                                                        break;
                                                                    case "2":
                                                                        $rating = "<span class='fa fa-star'></span> <span class='fa fa-star'></span>";
                                                                        break;
                                                                    default:
                                                                        $rating = "<span class='fa fa-star'></span>";
                                                                        break;
                                                                }

                                                            }else{
                                                                $rating = '<label class="label label-default">unset</label>';
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td><?=$row['nama_depan']?> <?=$row['nama_belakang']?></td>
                                                                <td><?=$row['nama_job']?></td>
                                                                <td><?=$row['report']?></td>
                                                                <td <?= $row['rating'] > 0 ? "style='color: #ea8d15;'" : "";?>><?=$rating?></td>
                                                                <td><?=$row['report_date']?></td>
                                                                <td>
                                                                    <button class="btn btn-xs btn-primary addRating" data-toggle="modal" data-target=".tambahRatingJobs" data-kode="<?=$row['id']?>"><span class="fa fa-plus"> </span> Add Rating</button>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div>



                        <h4>Recent Activity</h4>

                        <!-- end of user messages -->
                        <ul class="messages">
                            <li>
                                <img src="images/img.jpg" class="avatar" alt="Avatar">
                                <div class="message_date">
                                    <h3 class="date text-info">24</h3>
                                    <p class="month">May</p>
                                </div>
                                <div class="message_wrapper">
                                    <h4 class="heading">Desmond Davison</h4>
                                    <blockquote class="message">Raw denim you probably haven't heard of them jean shorts
                                        Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher
                                        synth.
                                    </blockquote>
                                    <br>
                                    <p class="url">
                                        <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                        <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                    </p>
                                </div>
                            </li>
                            <li>
                                <img src="images/img.jpg" class="avatar" alt="Avatar">
                                <div class="message_date">
                                    <h3 class="date text-error">21</h3>
                                    <p class="month">May</p>
                                </div>
                                <div class="message_wrapper">
                                    <h4 class="heading">Brian Michaels</h4>
                                    <blockquote class="message">Raw denim you probably haven't heard of them jean shorts
                                        Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher
                                        synth.
                                    </blockquote>
                                    <br>
                                    <p class="url">
                                        <span class="fs1" aria-hidden="true" data-icon=""></span>
                                        <a href="#" data-original-title="">Download</a>
                                    </p>
                                </div>
                            </li>
                            <li>
                                <img src="images/img.jpg" class="avatar" alt="Avatar">
                                <div class="message_date">
                                    <h3 class="date text-info">24</h3>
                                    <p class="month">May</p>
                                </div>
                                <div class="message_wrapper">
                                    <h4 class="heading">Desmond Davison</h4>
                                    <blockquote class="message">Raw denim you probably haven't heard of them jean shorts
                                        Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher
                                        synth.
                                    </blockquote>
                                    <br>
                                    <p class="url">
                                        <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                        <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                    </p>
                                </div>
                            </li>
                        </ul>
                        <!-- end of user messages -->


                    </div>


                </div>

                <!-- start project-detail sidebar -->
                <div class="col-md-3 col-sm-3 col-xs-12">

                    <section class="panel">

                        <div class="x_title">
                            <h2>Project Description</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <h3 class="green"><i class="fa fa-building"></i> Gentelella</h3>

                            <div class="project_detail">
                                <p class="title">Client Company</p>
                                <p><?=$data['nama_perusahaan']?></p>
                                <p class="title">Project Leader</p>
                                <p>Tony Chicken</p>
                            </div>

                            <p><?=$data['deskripsi']?></p>
                            <hr>
                            <div class="project_detail">
                                <p class="title">Tugas</p>
                                <p><?=$data['tugas']?></p>
                                <hr>
                                <p class="title">Tanggung Jawab</p>
                                <p><?=$data['tanggung_jwb']?></p>
                                <hr>
                                <p>
                                    <a href="php/invoice.php?kode=<?=$id?>" target="_blank">
                                        <button class="btn btn-xs btn-primary">GENERATE INVOICE</button>
                                    </a>
                                </p>
                                <?php if($maps->rowCount() > 0){
                                    while ($map = $maps->fetch(PDO::FETCH_LAZY)){
                                    ?>
                                  <br>
                                    <h5>Koordinat</h5>
                                    <ul class="list-unstyled project_files">
                                        <li><i class="fa fa-tags"></i> <?=$map['label']?>
                                        </li>
                                        <li><i class="fa fa-map"></i> <?=$map['lat']?> || <?=$map['lng']?>
                                        </li>
                                        <li><i class="fa fa-map-marker"></i> <?=$map['location']?>
                                        </li>

                                    </ul>
                                    <br>
                                <?php } } else { ?>
                                    <p>
                                        <a href="php/new_map.php?spk=<?=$id?>" target="_blank">
                                            <button class="btn btn-xs btn-success">ADD MAP</button>
                                        </a>
                                    </p>
                                <?php } ?>
                            </div>
                        </div>

                    </section>

                </div>
                <!-- end project-detail sidebar -->

            </div>
        </div>
    </div>
</div>

<div class="modal fade tambahJabatanKaryawan"  tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Assign Jabatan</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left" id="tambahJabatanKaryawan" method="post" action="" data-parsley-validate="">

            <input type="hidden" id="kodeListKaryawan" name="kodeListKaryawan" value="<?=$kodeListKaryawan?>">
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="form-control" name="listJabatan" id="listJabatan" required>
                                <option value="">Choose Jabatan</option>
                                <?php while ($listJabatan = $jb->fetch(PDO::FETCH_LAZY)){ ?>
                                <option value="<?=$listJabatan['id']?>" style="text-transform: capitalize;"><?=$listJabatan['nama_jabatan']?></option>
                                <?php } ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="form-control" name="namaKaryawanPR" id="namaKaryawanPR" required>
                                <option value="">Choose Karyawan</option>
                                <?php while ($listKaryawan = $ls->fetch(PDO::FETCH_LAZY)){ ?>
                                    <option value="<?=$listKaryawan['id']?>" style="text-transform: capitalize;"><?=$listKaryawan['nama_depan']?> <?=$listKaryawan['nama_belakang']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <button type="submit" class="btn btn-block btn-success tambahJabatan" name="tambahJabatan">Submit</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>


<div class="modal fade tambahRatingJobs"  tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">Add Rating Jobs</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left" id="tambahRatingKaryawan" method="post" action="" data-parsley-validate="">

                    <input type="hidden" id="idReportJobs" name="kodeListKaryawan" value="">
                    <input type="hidden" id="idAdminJobs" name="kodeListKaryawan" value="<?=$admin_id?>">

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select class="form-control" name="namaKaryawanPR" id="starJobs" required>
                                <option value="">RATING</option>
                                <option value="1">&#xf015; </option>
                                <option value="2">&#xf015; &#xf015; </option>
                                <option value="3">&#xf015; &#xf015; &#xf015;</option>
                                <option value="4">&#xf015; &#xf015; &#xf015; &#xf015;</option>
                                <option value="5">&#xf015; &#xf015; &#xf015; &#xf015; &#xf015;</option>

                            </select>
                        </div>
                    </div>


                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <button type="submit" class="btn btn-block btn-success tambahJabatan" name="tambahJabatan">Submit</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
