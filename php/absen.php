<?php
    $sql = "SELECT tb_karyawan.no_ktp, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.jenis_kelamin FROM tb_karyawan WHERE tb_karyawan.no_ktp IN (SELECT tb_absen.no_NIP FROM tb_absen)";
    $stmt = $config->runQuery($sql);
    $stmt->execute();

    $formate = "d-m-Y";
    $tanggal = $config->getDate($formate);

    $waktu = "h:i:s a";
    $waktu = $config->getTime($waktu);

    echo $waktu. '<br/>';
    echo $tanggal;
?>
<div class="row" id="absen">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Absen Karyawan</small></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div id="listAbsen">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <th>#</th>
                                <th>Nama Karyawan</th>
                                <th>Jenis Kelamin</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                <?php if($stmt->rowCount() > 0 ){
                                    $i = 1;
                                    while ($row = $stmt->fetch(PDO::FETCH_LAZY)){ ?>
                                        <tr>
                                            <td><?=$i++?></td>
                                            <td><?=$row['nama_depan']?> <?=$row['nama_belakang']?></td>
                                            <td><?=$row['jenis_kelamin']?></td>
                                            <td>
                                                <button type="button" data-toggle="tooltip"
                                                        data-ktp="<?= $row['no_ktp'] ?>"
                                                        data-depan="<?= $row['nama_depan'] ?>"
                                                        data-belakang="<?= $row['nama_belakang'] ?>"
                                                        data-placement="right"
                                                        title="get range"
                                                        class="btn btn-primary btn-xs viewRange">
                                                    <i class="fa fa-fw fa-bar-chart"> </i>
                                                </button>
                                            </td>
                                        </tr>
                                  <?php  }
                                }else{ ?>
                                    <tr>
                                        <td colspan="4">Data absen belum ada!</td>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="detailAbsen">
                        <div class="col-md-6 col-sm-6 col-xs-12 well">
                            <h4 class="title">Range Absen</h4>
                            <div class="x_content" data-parsley-validate="" id="fetchAbsen">
                                <div class="form-horizontal form-label-left input_mask" id="fetchAbsen" data-parsley-validate="">

                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" id="namaDepan" value="" readonly>
                                        <input type="hidden" class="form-control has-feedback-left" id="txtKtp" value="" readonly>
                                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="text" class="form-control" id="namaBelakang" value="" readonly>
                                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="text" name="txt_start" class="form-control has-feedback-left" id="single_cal1" aria-describedby="inputSuccess2Status4">
                                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                        <input type="text" name="txt_start" class="form-control has-feedback-left" id="single_cal2" aria-describedby="inputSuccess2Status4">
                                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                    </div>





                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <button type="button" class="btn btn-success showAbsen" id="fetchAbsen">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="hasilAbsen">

</div>