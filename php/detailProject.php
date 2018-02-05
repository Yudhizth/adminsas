<?php
$id = $_GET['id'];

$query = 'SELECT tb_kerjasama_perusahan.id, tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.kode_perusahaan, tb_kerjasama_perusahan.kode_request, tb_kerjasama_perusahan.kode_plan, tb_kerjasama_perusahan.kode_list_karyawan, tb_kerjasama_perusahan.total_karyawan, tb_kerjasama_perusahan.deskripsi, tb_kerjasama_perusahan.tugas, tb_kerjasama_perusahan.tanggung_jwb, tb_kerjasama_perusahan.penempatan, tb_kerjasama_perusahan.kontrak_start, tb_kerjasama_perusahan.kontrak_end, tb_kerjasama_perusahan.nilai_kontrak, tb_kerjasama_perusahan.tgl_input, tb_perusahaan.nama_perusahaan, tb_perusahaan.bidang_perusahaan, tb_kategori_pekerjaan.nama_kategori, tb_temporary_perusahaan.kebutuhan, tb_temporary_perusahaan.kode_pekerjaan, tb_temporary_perusahaan.nama_project FROM tb_kerjasama_perusahan

LEFT JOIN tb_perusahaan ON tb_perusahaan.kode_perusahaan = tb_kerjasama_perusahan.kode_perusahaan
LEFT JOIN tb_temporary_perusahaan ON tb_temporary_perusahaan.no_pendaftaran=tb_kerjasama_perusahan.kode_request
LEFT JOIN tb_kategori_pekerjaan ON tb_kategori_pekerjaan.kode_kategori=tb_temporary_perusahaan.kebutuhan

WHERE tb_kerjasama_perusahan.nomor_kontrak = :nomor ';

$stmt = $config->runQuery($query);
$stmt->execute(array(':nomor' => $id));

$data = $stmt->fetch(PDO::FETCH_LAZY);
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

$sql = "SELECT tb_list_karyawan.no_nip, tb_karyawan.nama_depan, tb_karyawan.nama_belakang FROM tb_list_karyawan 
INNER JOIN tb_karyawan ON tb_karyawan.no_ktp=tb_list_karyawan.no_nip WHERE tb_list_karyawan.kode_list_karyawan = :kode ";
$cek = $config->runQuery($sql);
$cek->execute(array(
        ':kode' => $kodeListKaryawan
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
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2><i class="fa fa-align-left"></i> List Jobs Project</h2>
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

                                    <!-- start accordion -->
                                    <div class="accordion" id="accordion1" role="tablist" aria-multiselectable="true">
                                        <div class="panel">
                                            <a class="panel-heading collapsed" role="tab" id="headingOne1" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" aria-expanded="false" aria-controls="collapseOne">
                                                <h4 class="panel-title">Collapsible Group Item #1</h4>
                                            </a>
                                            <div id="collapseOne1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                                <div class="panel-body">
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                            <th>Username</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row">1</th>
                                                            <td>Mark</td>
                                                            <td>Otto</td>
                                                            <td>@mdo</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">2</th>
                                                            <td>Jacob</td>
                                                            <td>Thornton</td>
                                                            <td>@fat</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">3</th>
                                                            <td>Larry</td>
                                                            <td>the Bird</td>
                                                            <td>@twitter</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel">
                                            <a class="panel-heading" role="tab" id="headingTwo1" data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo1" aria-expanded="true" aria-controls="collapseTwo">
                                                <h4 class="panel-title">Collapsible Group Item #2</h4>
                                            </a>
                                            <div id="collapseTwo1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="true" style="">
                                                <div class="panel-body">
                                                    <p><strong>Collapsible Item 2 data</strong>
                                                    </p>
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel">
                                            <a class="panel-heading collapsed" role="tab" id="headingThree1" data-toggle="collapse" data-parent="#accordion1" href="#collapseThree1" aria-expanded="false" aria-controls="collapseThree">
                                                <h4 class="panel-title">Collapsible Group Item #3</h4>
                                            </a>
                                            <div id="collapseThree1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
                                                <div class="panel-body">
                                                    <p><strong>Collapsible Item 3 data</strong>
                                                    </p>
                                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end of accordion -->


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

                            </div>

                            <br>
                            <div class="project_detail">
                                <p class="title">Karyawan Project</p>
                                <ul class="list-unstyled project_files">
                                    <?php
                                    if($cek->rowCount() > 0){
                                        while ($col = $cek->fetch(PDO::FETCH_LAZY)){ ?>
                                            <li><a href="?p=detail-karyawan&id=<?=$col['no_nip']?>"><i class="fa fa-user"></i> <?=$col['nama_depan']?> <?=$col['nama_belakang']?></a>
                                            </li>
                                        <?php } }else{ ?>
                                        <li><label class="label label-danger">Karyawan Belum dipilih.</label>
                                        </li>
                                    <?php } ?>

                                </ul>
                            </div>

                            <br>

                            <div class="text-center mtop20">
                                <a href="#" class="btn btn-sm btn-primary">Add files</a>
                                <a href="#" class="btn btn-sm btn-warning">Report contact</a>
                            </div>
                        </div>

                    </section>

                </div>
                <!-- end project-detail sidebar -->

            </div>
        </div>
    </div>
</div>
