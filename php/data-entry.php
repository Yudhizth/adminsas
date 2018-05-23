<?php
$provinsi = $config->Products('id, name', 'provinces');
date_default_timezone_set('Asia/Jakarta');
$id = $_GET['name'];

$split = substr($id, 0,3);

$field = "nomor_kontrak";
$kode = "SPK-";
$tbName = "tb_kerjasama_perusahan";

$nomor = $config->Generate($field, $kode, $tbName);

//inisial data
    $sql ="SELECT tb_temporary_perusahaan.no_pendaftaran, tb_temporary_perusahaan.kebutuhan, tb_temporary_perusahaan.kode_pekerjaan, tb_temporary_perusahaan.nama_project, tb_perusahaan.kode_perusahaan, tb_perusahaan.nama_perusahaan, tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.total_karyawan, tb_kerjasama_perusahan.deskripsi, tb_kerjasama_perusahan.tugas, tb_kerjasama_perusahan.tanggung_jwb, tb_kerjasama_perusahan.penempatan, tb_kerjasama_perusahan.kontrak_start, tb_kerjasama_perusahan.kontrak_end, tb_kerjasama_perusahan.nilai_kontrak, tb_kerjasama_perusahan.tgl_input, tb_kerjasama_perusahan.total, tb_kerjasama_perusahan.lembur, tb_kerjasama_perusahan.kode_admin,
	SUM(tb_list_perkerjaan_perusahaan.total) as totalkaryawan
FROM tb_temporary_perusahaan 
    LEFT JOIN tb_perusahaan ON tb_perusahaan.kode_perusahaan = tb_temporary_perusahaan.kode_perusahaan 
    LEFT JOIN tb_kerjasama_perusahan ON tb_kerjasama_perusahan.kode_request=tb_temporary_perusahaan.no_pendaftaran
    LEFT JOIN tb_list_perkerjaan_perusahaan ON tb_list_perkerjaan_perusahaan.code = tb_temporary_perusahaan.kode_pekerjaan
    WHERE tb_temporary_perusahaan.no_pendaftaran = :kode";

    $data = $config->runQuery($sql);
    $data->execute(array(':kode' => $id));

    $row = $data->fetch(PDO::FETCH_LAZY);


        if(empty($row['kode_admin'] && $row['nomor_kontrak'])){
            $adminId = $kd_admin;
            $nomorKontrak = $nomor;

            $namaProject = $row['nama_project'];
        }else{
            $adminId = $row['kode_admin'];
            $nomorKontrak = $row['nomor_kontrak'];
        }

    if($split == "MPO"){
        $listDetail = 'style="display: block;"';


        //tampil data MPO yaa
        $query = "SELECT tb_list_perkerjaan_perusahaan.id, tb_list_perkerjaan_perusahaan.total, tb_list_perkerjaan_perusahaan.gaji, tb_jenis_pekerjaan.nama_pekerjaan FROM tb_list_perkerjaan_perusahaan 
        INNER JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan = tb_list_perkerjaan_perusahaan.name_list WHERE tb_list_perkerjaan_perusahaan.code = :detailMPO";
        $stmt = $config->runQuery($query);
        $stmt->execute(array(':detailMPO' => $row['kode_pekerjaan']));
        $totalPekerja = $row['totalkaryawan'];
        $styleField = "readonly";

    }else{
        $listDetail = 'style="display: none;"';
        $totalPekerja = "";
        $styleField = "";
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
                    <li role="presentation" class="active"><a href="#tab_content1" id="detail-tab" role="tab" data-toggle="tab" aria-expanded="false">Detail Project <?=strtoupper($namaProject)?></a>
                    </li>
                    <li role="presentation" class="" <?=$listDetail?>><a href="#tab_content2" role="tab" id="time-tab" data-toggle="tab" aria-expanded="true">List MPO</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content ">
                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="detail-tab">
                        <form class="form-horizontal form-label-left" method="post" action="php/entrydata.php" id="detailProject" data-parsley-validate="">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Total Karyawan <span class="required">*</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" data-parsley-type="number" name="txt_total" id="totalKaryawan" value="<?=$totalPekerja?>" class="form-control" placeholder="total karyawan" required="" <?=$styleField?>  >
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pilih Provinsi Penempatan</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select name="txt_provinsi" id="txt_provinsi" class="form-control"  required="">
                                    <option value="">:: choose ::</option>
                                        <?php while($col = $provinsi->fetch(PDO::FETCH_LAZY)){ ?>

                                            <option value="<?=$col['id']?>"><?=$col['name']?></option>
                                        <?php } ?>                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Penempatan Kerja</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <!-- <input type="text" name="txt_penempatan" id="tempat" class="form-control" value="<?=$row['penempatan'];?>" placeholder="nama kota penempatan" required=""> -->
                                    <select name="txt_penempatan[]" id="tempatKerja" class="js-example-basic-multiple form-control" multiple="multiple" required="" disabled>
                                        
                                            <option value="<?=$col['id']?>"><?=$col['name']?></option>
                                       
                                    </select>
                                </div>
                            </div>
                            <?php if($split == "MPO"){ ?>
                                <div class="form-group hidden">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nilai Pekerjaan</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" data-parsley-type="number" id="nilaiPekerjaan" name="txt_nilai" value="0" class="form-control" placeholder="" readonly>
                                    </div>
                                </div>

                            <?php }else{ ?>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nilai Pekerjaan</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" data-parsley-type="number" id="nilaiPekerjaan" name="txt_nilai" value="<?=$row['nilai_kontrak'];?>" class="form-control" placeholder="" required="">
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Kontrak Start</label>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="text" name="txt_start" class="form-control has-feedback-left" id="kontrakStart" aria-describedby="inputSuccess2Status4">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Total Hari</label>
                                <div class="col-md-2 col-sm-2 col-xs-12">


                                    <input class="form-control has-feedback-left" placeholder="Total Hari" name="txt_ends" value="<?=$row['total'];?>" data-parsley-type="number" aria-describedby="inputSuccess2Status" type="text" required>
                                    <span class="fa fa-plus form-control-feedback left" aria-hidden="true"></span>
                                    <span id="inputSuccess2Status" class="sr-only">(success)</span>


                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nilai Per-Jam Lembur</label>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <input type="text" name="txt_lembur" class="form-control" value="<?=$row['lembur'];?>" id="txtLembur" placeholder="Rp. ........" required data-parsley-type="number" >
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                    <button type="reset" class="btn btn-primary">Reset</button>
                                    <button type="submit" name="addData" class="btn btn-success">Submit</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane fade " id="tab_content2" aria-labelledby="time-tab">
                            <div class="row" id="detailMPO">
                                <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2 col-sm-offset-2">
                                    <table class="table table-bordered">
                                        <thead>
                                        <th>List Posisi</th>
                                        <th>Gaji</th>
                                        <th>Total</th>
                                        </thead>
                                        <tbody>
                                            <?php while($MPO = $stmt->fetch(PDO::FETCH_LAZY)){
                                                ?>
                                        <tr>
                                            <td><?=$MPO['nama_pekerjaan']?></td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" value="<?=$MPO['gaji']?>" name="gajiMPO" id="<?=$MPO['id']?>">
                                                    <span class="input-group-btn">
                                                      <button type="button" class="btn btn-default saveGaji" data-id="<?=$MPO['id']?>">Save</button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td><b><i><?=$MPO['total']?></i></b> karyawan</td>
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

</div>
