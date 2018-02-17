<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 08/02/2018
 * Time: 12.13
 */
include_once '../../config/api.php';
$config = new Admin();

$admin_id = $_GET['admin'];

if(@$_GET['type'] == 'getRange'){

}else{
    $sql = "SELECT tb_cuti.id, tb_cuti.no_ktp, tb_cuti.dari, tb_cuti.sampai, tb_cuti.keterangan, tb_cuti.tanggal, tb_cuti.status, tb_cuti.admin, tb_karyawan.nama_depan, tb_karyawan.nama_belakang FROM tb_cuti
    INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_cuti.no_ktp";

    $stmt = $config->runQuery($sql);
    $stmt->execute();

   ?>
    <div class="x_panel">
        <div class="x_title">
            <h2><span class="fa fa-fw fa-list"></span> Cuti Karyawan</h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">


            <!-- start project list -->
            <table class="table table-striped projects">
                <thead>
                <tr>
                    <th style="width: 1%">#</th>
                    <th style="width: 20%">Nama Karyawan</th>
                    <th style="width: 10%">Tanggal <small>pengajuan</small></th>
                    <th style="width: 10%">Dari</th>
                    <th style="width: 10%">Sampai</th>
                    <th style="width: 29%">Alasan</th>
                    <th style="width: 10%">Status</th>
                    <th style="width: 10%">Action</th>
                </tr>
                </thead>
                <tbody>
                <tbody>
                <?php
                if ($stmt->rowCount() == '') {
                    # code...
                    ?>
                    <tr>
                        <td colspan="7">Data Tidak Ada</td>
                    </tr>
                    <?php
                } else{
                    $i = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
                        # code...
                        $tanggal = date("d-m-Y", strtotime($row['tanggal']));
                        $admin = $row['admin'];
                        if($row['status'] == '1'){
                            $status = '<span class="label label-success">Approve by: '.$admin.'</span>';
                        }elseif($row['status'] == '2'){
                            $status = '<span class="label label-danger">Decline by: '.$admin.'</span>';
                        }else{
                            $status = '<span class="label label-default">unset</span>';
                        }

                        ?>
                        <tr class="even pointer">

                            <td><?=$i++?></td>
                            <td class=" "><?=$row['nama_depan']; ?> <?=$row['nama_belakang']?></td>
                            <td class=" "><?=$tanggal?></td>
                            <td class=" "><?=$row['dari']; ?></td>
                            <td class=" "><?=$row['sampai']; ?></td>
                            <td class=" "><?=$row['keterangan']; ?></td>
                            <td class=" "><?=$status?></td>
                            <td>
                                <?php if($row['status'] == '2'){ ?>
                                <button type="button" data-toggle="tooltip"
                                        data-id="<?= $row['id'] ?>" data-admin="<?=$admin_id?>" data-type="1" data-placement="right"
                                        title="Approve Cuti"
                                        class="btn btn-info btn-xs actCuti"
                                    <i class="fa fa-fw fa-crosshairs"> </i> Approve
                                </button>
                            <?php }elseif($row['status'] == '1'){?>
                                    <button type="button" data-toggle="tooltip"
                                            data-id="<?= $row['id'] ?>" data-admin="<?=$admin_id?>" data-type="2" data-placement="right"
                                            title="Decline Cuti"
                                            class="btn btn-danger btn-xs actCuti"
                                    <i class="fa fa-fw fa-crosshairs"> </i> Decline
                                    </button>
                            <?php }else{ ?>
                                    <button type="button" data-toggle="tooltip"
                                            data-id="<?= $row['id'] ?>" data-admin="<?=$admin_id?>" data-type="1" data-placement="right"
                                            title="Approve Cuti"
                                            class="btn btn-info btn-xs actCuti"
                                    <i class="fa fa-fw fa-crosshairs"> </i> Approve
                                    </button>
                                    <button type="button" data-toggle="tooltip"
                                            data-id="<?= $row['id'] ?>" data-admin="<?=$admin_id?>" data-type="2" data-placement="right"
                                            title="Decline Cuti"
                                            class="btn btn-danger btn-xs actCuti"
                                    <i class="fa fa-fw fa-crosshairs"> </i> Decline
                                    </button>
                            <?php } ?>
                            </td>

                        </tr>
                    <?php } }?>
                </tbody>
            </table>
            <!-- end project list -->

        </div>
    </div>


<?php } ?>