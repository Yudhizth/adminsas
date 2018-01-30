<?php
date_default_timezone_set('Asia/Jakarta');
$id = $_GET['name'];

$id = "nomor_kontrak";
$kode = "SPK-";
$tbName = "tb_kerjasama_perusahan";

$nomor = $config->Generate($id, $kode, $tbName);

//inisial data
    $sql = "SELECT tb_temporary_perusahaan.no_pendaftaran, tb_temporary_perusahaan.kebutuhan, tb_temporary_perusahaan.kode_pekerjaan, tb_temporary_perusahaan.nama_project, tb_perusahaan.kode_perusahaan, tb_perusahaan.nama_perusahaan, tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.total_karyawan, tb_kerjasama_perusahan.deskripsi, tb_kerjasama_perusahan.tugas, tb_kerjasama_perusahan.tanggung_jwb, tb_kerjasama_perusahan.penempatan, tb_kerjasama_perusahan.kontrak_start, tb_kerjasama_perusahan.kontrak_end, tb_kerjasama_perusahan.nilai_kontrak, tb_kerjasama_perusahan.tgl_input, tb_kerjasama_perusahan.kode_admin 
    FROM tb_temporary_perusahaan 
    LEFT JOIN tb_perusahaan ON tb_perusahaan.kode_perusahaan = tb_temporary_perusahaan.kode_perusahaan 
    LEFT JOIN tb_kerjasama_perusahan ON tb_kerjasama_perusahan.kode_request=tb_temporary_perusahaan.no_pendaftaran 
    WHERE tb_temporary_perusahaan.no_pendaftaran = 'SYGREQ0007'";

    $data = $config->runQuery($sql);
    $data->execute(array(':kode' => $id));

    $row = $data->fetch(PDO::FETCH_LAZY);

    if(empty($row['kode_admin'] && $row['nomor_kontrak'])){
        $adminId = $kd_admin;
        $nomorKontrak = $nomor;
    }else{
        $adminId = $row['kode_admin'];
        $nomorKontrak = $row['nomor_kontrak'];
    }

?>

<div class="col-md-10 col-sm-10 col-md-offset-1 col-sm-offset-1 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-bars"></i> Data Project <small><?=$row['nama_perusahaan']?></small></h2>
<!--            <ul class="nav navbar-right panel_toolbox">-->
<!--                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>-->
<!--                </li>-->
<!--                <li class="dropdown">-->
<!--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>-->
<!--                    <ul class="dropdown-menu" role="menu">-->
<!--                        <li><a href="#">Settings 1</a>-->
<!--                        </li>-->
<!--                        <li><a href="#">Settings 2</a>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </li>-->
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
<!--                </li>-->
<!--            </ul>-->
            <div class="clearfix"></div>
        </div>
        <div class="x_content">


            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab_content1" id="detail-tab" role="tab" data-toggle="tab" aria-expanded="false">Detail Project</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="time-tab" data-toggle="tab" aria-expanded="true">Detail Waktu Kerja</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content3" role="tab" id="approved-tab2" data-toggle="tab" aria-expanded="false">Approved</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content ">
                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="detail-tab">
                        <form class="form-horizontal form-label-left" method="post" action="" id="detailProject" data-parsley-validate="">

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Total Karyawan <span class="required">*</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" data-parsley-type="number" name="txt_total" id="totalKaryawan" value="<?=$row['total_karyawan']?>" class="form-control" placeholder="total karyawan" required="">
                                    <input type="hidden" name="txt_kode" id="kodePerusahaan" class="form-control" value="<?=$row['kode_perusahaan']?>">
                                    <input type="hidden" name="txt_kontrak" id="nomorKontrak" class="form-control" value="<?=$nomorKontrak?>">
                                    <input type="hidden" name="txt_req" id="nomorRequest" class="form-control" value="<?=$row['no_pendaftaran']?>">
                                    <input type="hidden" name="txt_pekerjaan" id="nomorMPO" class="form-control" value="<?=$row['kode_pekerjaan']?>">
                                    <input type="hidden" name="txt_admin" id="kodeAdmin" class="form-control" value="<?=$adminId?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Deskripsi Pekerjaan <span class="required">*</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea name="txt_deskripsi" class="form-control" rows="3" id="deskripsi" data-parsley-minlength="10" data-parsley-minlength-message="You need enter at least 10 charater.." placeholder="gambaran luas tentang deskripsi pekerjaan" required=""><?=$row['deskripsi'];?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tugas<span class="required">*</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea class="form-control" name="txt_tugas" rows="3" id="tugas" data-parsley-minlength="10" data-parsley-minlength-message="You need enter at least 10 charater.." placeholder="gambaran luar tentang tugas pekerjaan" required=""><?=$row['tugas'];?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggung Jawab<span class="required">*</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea class="form-control" name="txt_tanggung" rows="3" id="tanggunJawab" data-parsley-minlength="10" data-parsley-minlength-message="You need enter at least 10 charater.." placeholder="gambaran luas tentang tanggung jawab pekerjaan" required=""><?=$row['tanggung_jwb'];?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Penempatan Kerja</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="txt_penempatan" id="tempat" class="form-control" placeholder="nama kota penempatan" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nilai Pekerjaan</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" data-parsley-type="number" id="nilaiPekerjaan" name="txt_nilai" class="form-control" placeholder="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Kontrak Start</label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" name="txt_start" class="form-control has-feedback-left" id="single_cal1" aria-describedby="inputSuccess2Status4">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Kontrak Ends</label>
                                <div class="col-md-4 col-sm-3 col-xs-12">


                                    <input class="form-control has-feedback-left" id="single_cal2" placeholder="First Name" name="txt_ends" aria-describedby="inputSuccess2Status" type="text">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                    <span id="inputSuccess2Status" class="sr-only">(success)</span>


                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4 col-xs-12 col-md-offset-4">
                                    <div class="form-group">
                                        <select id="timeType" class="form-control" required>
                                            <option value="">Pilih Waktu Kerja</option>
                                            <option value="1">Waktu Fixed</option>
                                            <option value="2">Waktu Flexsible</option>
                                        </select>
                                    </div>
                                </div>

                                <table class="table table-hover table-resposive">
                                    <thead>
                                    <tr><th>MINGGU</th>
                                        <th>SENIN</th>
                                        <th>SELASA</th>
                                        <th>RABU</th>
                                        <th>KAMIS</th>
                                        <th>JUMAT</th>
                                        <th>SABTU</th>
                                    </tr></thead>
                                    <tbody><tr>
                                        <td width="14.2%">
                                            <input type="number" class="form-control" name="txt_minggu" placeholder="HH">
                                        </td>
                                        <td width="14.2%">
                                            <input type="number" class="form-control" name="txt_senin" placeholder="HH">
                                        </td>
                                        <td width="14.2%">
                                            <input type="number" class="form-control" name="txt_selasa" placeholder="HH">
                                        </td>
                                        <td width="14.2%">
                                            <input type="number" class="form-control" name="txt_rabu" placeholder="HH">
                                        </td>
                                        <td width="14.2%">
                                            <input type="number" class="form-control" name="txt_kamis" placeholder="HH">
                                        </td>
                                        <td width="14.2%">
                                            <input type="number" class="form-control" name="txt_jumat" placeholder="HH">
                                        </td>
                                        <td width="14.2%">
                                            <input type="number" class="form-control" name="txt_sabtu" placeholder="HH">
                                        </td>
                                    </tr>
                                    </tbody></table>
                            </div>


                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                    <button type="reset" class="btn btn-primary">Reset</button>
                                    <button type="submit" name="addDataDefault" class="btn btn-success">Submit</button>
                                </div>
                            </div>


                    </div>
                    <div role="tabpanel" class="tab-pane fade " id="tab_content2" aria-labelledby="time-tab">

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="approved-tab">
                        <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                            booth letterpress, commodo enim craft beer mlkshk </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
