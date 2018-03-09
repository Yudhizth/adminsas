<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 01/03/2018
 * Time: 15.10
 */

$sql = "SELECT tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.kode_perusahaan, tb_kerjasama_perusahan.kode_list_karyawan, tb_list_karyawan.no_nip, tb_perusahaan.nama_perusahaan, tb_list_karyawan.kode_jabatan, tb_list_karyawan.kode_pekerjaan, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_jenis_pekerjaan.nama_pekerjaan, tb_list_jabatan.nama_jabatan
FROM tb_kerjasama_perusahan
INNER JOIN tb_perusahaan ON tb_perusahaan.kode_perusahaan=tb_kerjasama_perusahan.kode_perusahaan
INNER JOIN tb_list_karyawan ON tb_list_karyawan.kode_list_karyawan = tb_kerjasama_perusahan.kode_list_karyawan
LEFT JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan=tb_list_karyawan.kode_pekerjaan
LEFT JOIN tb_list_jabatan ON tb_list_jabatan.id=tb_list_karyawan.kode_jabatan
INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_list_karyawan.no_nip";

$stmt = $config->runQuery($sql);
$stmt->execute();
?>

<div class="x_panel">
    <div class="x_title">
        <h2>Report Karyawan Project</h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="col-md-12">


            <br>

            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Daily Activity</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">By Complain Custome</a>
                    </li>
                </ul>

                <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane active fade in" id="tab_content1" aria-labelledby="home-tab">

                        <!-- start recent activity -->
                        <ul class="messages">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">Nama Karyawan </th>
                                        <th class="column-title">Project On </th>
                                        <th class="column-title">Type Jobs </th>
                                        <th class="column-title">Jabatan </th>
                                        <th class="column-title">Action </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php while ($row = $stmt->fetch(PDO::FETCH_LAZY)){
                                        if(empty($row['nama_pekerjaan'])){
                                            $pekerjaan = "<span class='label label-primary'>General</span>";
                                        }else{
                                            $pekerjaan = "<span class='label label-primary'>".$row['nama_pekerjaan']."</span>";
                                        }
                                        if(empty($row['nama_jabatan'])){
                                            $jabatan = "<span class='label label-primary'>General</span>";
                                        }else{
                                            $jabatan = "<span class='label label-primary'>".$row['nama_jabatan']."</span>";
                                        }
                                        ?>
                                    <tr class="even pointer">
                                        <td><?=$row['nama_depan']?> <?=$row['nama_depan']?></td>
                                        <td><?=$row['nama_perusahaan']?>//<?=$row['nomor_kontrak']?></td>
                                        <td><?=$pekerjaan?></td>
                                        <td><?=$jabatan?></td>
                                        <td>
                                            <a href="">
                                                <button class="btn btn-xs btn-primary">report jobs</button>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </ul>
                        <!-- end recent activity -->

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                        <!-- start user projects -->

                        <ul class="messages">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">Nama Karyawan </th>
                                        <th class="column-title">Project On </th>
                                        <th class="column-title">Rating </th>
                                        <th class="column-title">Cupon Complain </th>
                                        <th class="column-title">Keterangan </th>
                                        <th class="column-title">Create Date </th>
                                        <th class="column-title">SPv </th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </ul>


                        <!-- end user projects -->

                    </div>


                </div>
            </div>

        </div>
    </div>
</div>
