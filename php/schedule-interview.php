<?php

$sql = "SELECT tb_info_interview.kd_interview, tb_info_interview.no_ktp, tb_info_interview.date_interview, tb_info_interview.detail, tb_info_interview.create_date, tb_info_interview.kd_admin, tb_info_interview.status AS statusKaryawan, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.foto, tb_karyawan.nilai, tb_karyawan.status FROM tb_info_interview
INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_info_interview.no_ktp
WHERE  tb_karyawan.nilai = ''";
$stmt = $config->runQuery($sql);
$stmt->execute();
?>
<div class="clearfix"></div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>List Karyawan Interview </h2>

            <div class="clearfix"></div>
        </div>

        <div class="x_content" id="contentInterview">
            <div id="formListInterview">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <form class="form-horizontal form-label-left" id="searchInterviewList" data-parsley-validate="">
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <select class="form-control" id="typeFilterInterview" required>
                                        <option value="">Choose option</option>
                                        <option value="no_ktp">Nomor KTP</option>
                                        <option value="nama_depan">Nama Depan</option>
                                        <option value="nama_belakang">Nama Belakang</option>
                                        <option value="email">Email</option>
                                    </select>
                                </div>

                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="txtInterviewFilter" required>
                                        <span class="input-group-btn">
                                              <button type="submit" class="btn btn-primary">Search..</button>
                                          </span>
                                    </div>
                                </div>
                            </div>
                            <div class="divider-dashed"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="listInterview">

            </div>
            <div class="row" id="listUjianInterview">
                <h3>List Interview Karyawan</h3>
                <div class="divider-dashed"></div>
                <?php if($stmt->rowCount() > 0){
                    while ($row = $stmt->fetch(PDO::FETCH_LAZY)){
                        if(empty($row['foto'])){
                            $foto = "images/user.png";
                        }else{
                            $foto = $row['foto'];
                        }
                        if(empty($row['statusKaryawan'])){
                            $status = "Calon Karyawan Belum Menentukan Pilihan untuk datang pada waktu yang telah ditentukan atau meminta schedule ulang.";
                        }else{
                            $status = "Calon Karyawan telah menentukan Pilihan. Yaitu: <br> <span class='label label-success' style='font-size: 14px;'>".$row['statusKaryawan']."</span>";
                        }
                        $tgl = explode('-', $row['date_interview']);
                        ?>
                        <div class="col-md-3 col-sm-3 col-xs-6 widget widget_tally_box">
                            <div class="panel panel-default panel-body">
                                <div class="x_content">

                                    <div class="flex">
                                        <ul class="list-inline widget_profile_box">
                                            <li>
                                                <a>
                                                    <i class="fa fa-shield"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <img src="<?=$foto?>" alt="..." class="img-circle profile_img">
                                            </li>
                                            <li>
                                                <a>
                                                    <i class="fa fa-sun-o"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <h3 class="name" style="text-transform: capitalize; margin: 12% 10% !important;height: 40px !important;"><?=$row['nama_depan']?> <?=$row['nama_belakang']?></h3>

                                    <div class="flex">
                                        <ul class="list-inline count2">
                                            <li>
                                                <h3><?=$tgl[0]?></h3>
                                                <span>Tanggal</span>
                                            </li>
                                            <li>
                                                <h3><?=$tgl[1]?></h3>
                                                <span>Bulan</span>
                                            </li>
                                            <li>
                                                <h3><?=$tgl[2]?></h3>
                                                <span>Tahun</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="jumbotron" style="padding-left: 4% !important; padding-right: 4% !important; padding-top: 4%!important; padding-bottom: 4%!important;">
                                        <b>Detail:</b> <?=$row['detail']?>
                                    </div>
                                    <div class="divider-dashed">

                                    </div>
                                    <p style="height: 60px;">
                                        <?=$status?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php  }
                }else{} ?>

            </div>
        </div>
    </div>
</div>
</div>