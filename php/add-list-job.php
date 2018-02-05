<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 03/06/2017
 * Time: 15:15
 */
$kode = $_GET['name'];

//cek data mPO

$mpo = "SELECT * FROM tb_kerjasama_perusahan WHERE nomor_kontrak = :kontrak";
$cek = $config->runQuery($mpo);
$cek->execute(array(
    ':kontrak' => $kode
));

$typeProject = $cek->fetch(PDO::FETCH_LAZY);

$typeRequest = substr($typeProject['kode_request'], 0, 3);


$id = "kode_detail_job";
$tbName = "tb_job";
$kode2 = "DTL";
$sql = "SELECT MAX(RIGHT(" . $id . ", 4)) AS max_id FROM " . $tbName . " ORDER BY " . $id . " ";
$stmt = $config->runQuery($sql);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_LAZY);
$id = $row['max_id'];
$sort_num = (int)substr($id, 1, 6);
$sort_num++;
$new_code = sprintf("$kode2%04s", $sort_num);

$query = "SELECT tb_job.nomor_kontrak, tb_job.id, tb_job.kode_detail_job, tb_job.title, tb_job.type, tb_job.status, tb_jenis_pekerjaan.nama_pekerjaan
FROM tb_job 
LEFT JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan=tb_job.title
WHERE tb_job.nomor_kontrak = :kode ";
$done = $config->runQuery($query);
$done->execute(array(':kode' => $kode));


?>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>List Job Project
                <small>Baru</small>
            </h2>

            <div class="clearfix"></div>
        </div>

        <?php if ($typeRequest == 'MPO') {

            $a = "SELECT tb_list_perkerjaan_perusahaan.name_list, tb_list_perkerjaan_perusahaan.total, tb_list_perkerjaan_perusahaan.status, tb_jenis_pekerjaan.nama_pekerjaan
            FROM tb_list_perkerjaan_perusahaan 
            INNER JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan=tb_list_perkerjaan_perusahaan.name_list
            WHERE code = :kodePlan";
            $bb = $config->runQuery($a);
            $bb->execute(array(
                ':kodePlan' => $typeProject['kode_plan']
            ));

            ?>

            <div class="x_content" id="formJudulMPO">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <form method="post" id="formJudulMPO" class="form-horizontal" data-parsley-validate="">

                        <div class="input-group col-md-12 col-xs-12">
                            <input type="hidden" class="form-control" name="txtSPK" id="txtSPK" value="<?= $kode ?>"
                                   readonly>
                        </div>

                        <div class="input-group col-md-12 col-xs-12">
                            <input type="hidden" class="form-control" name="txtID" id="txtID" value="<?= $new_code ?>"
                                   readonly>
                        </div>

                        <div class="input-group col-md-12 col-xs-12">
                            <select class="form-control" name="txtJudul" id="txtJudul" required>
                                <option value="">Jobs Posisi</option>
                                <?php while ($show = $bb->fetch(PDO::FETCH_LAZY)) { ?>
                                    <option value="<?= $show['name_list'] ?>"><?= $show['nama_pekerjaan'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="input-group col-md-12 col-xs-12">
                            <select class="form-control" name="txtType" id="txtType" required>
                                <option value="">Type Jobs</option>
                                <option value="main">Main Jobs</option>
                                <option value="additional">Additional Jobs</option>
                            </select>
                        </div>
                        <div class="from-group">
                            <button type="submit" id="addJudulMPO"
                                    class="addJudulMPO from-control btn-block btn btn-info">Add a
                                Job <span class="fa fa-fw fa-plus"></span></button>
                        </div>

                    </form>
                </div>
            </div>

        <?php } else { ?>

            <div class="x_content" id="formJudul1">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <form method="post" id="formJudul" class="form-horizontal" data-parsley-validate="">

                        <div class="input-group col-md-12 col-xs-12">
                            <input type="hidden" class="form-control" name="txtSPK" id="txtSPK" value="<?= $kode ?>"
                                   readonly>
                        </div>

                        <div class="input-group col-md-12 col-xs-12">
                            <input type="hidden" class="form-control" name="txtID" id="txtID" value="<?= $new_code ?>"
                                   readonly>
                        </div>
                        <div class="input-group col-md-12 col-xs-12">
                            <input type="text" class="form-control" name="txtJudul" id="txtJudul"
                                   placeholder="Title Jobs"
                                   data-parsley-minlength="6" data-parsley-maxlength="100"
                                   data-parsley-required-message="Title is required" required autocomplete="off">

                        </div>
                        <div class="input-group col-md-12 col-xs-12">
                            <select class="form-control" name="txtType" id="txtType" required>
                                <option value="">Type Jobs</option>
                                <option value="main">Main Jobs</option>
                                <option value="additional">Additional Jobs</option>
                            </select>
                        </div>
                        <div class="from-group">
                            <button type="submit" id="addJudul" class="addJudul from-control btn-block btn btn-info">Add
                                a
                                Job <span class="fa fa-fw fa-plus"></span></button>
                        </div>

                    </form>
                </div>
            </div>

        <?php } ?>


    </div>

    <?php if ($typeRequest == 'MPO') { ?>
        <div class="x_panel">
            <div class="x_title">
                <h2>Project</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content" id="inputDetail">

            </div>

            <div class="x_content" id="listPanel">
                <?php while ($row = $done->fetch(PDO::FETCH_LAZY)) {
                    if ($row['type'] == 'main') {
                        $panel = "panel-success";
                    } else {
                        $panel = "panel-info";
                    }
                    ?>

                    <div class="panel-group" role="tablist" id="listDetail">
                        <div class="panel <?= $panel ?> ">

                            <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
                                <a href="#<?= $row['kode_detail_job'] ?>" class="" role="button" data-toggle="collapse"
                                   aria-expanded="true" aria-controls="collapseListGroup1">
                                    <h4 class="panel-title">
                                        <?= $row['nama_pekerjaan'] ?>
                                    </h4>
                                </a>
                                <div class="pull-right" style="display: inline;">
                                    <button class="btn btn-xs btn-default removeTitle" data-id="<?= $row['id'] ?>"
                                            data-toggle="tooltip" data-placement="left" title="Remove Title"><span
                                                class="fa fa-fw fa-trash-o"></span></button>
                                </div>


                            </div>

                            <div class="panel-collapse collapse" role="tabpanel" id="<?= $row['kode_detail_job'] ?>"
                                 aria-labelledby="collapseListGroupHeading1" aria-expanded="false" style="">
                                <br/>
                                <div class="x_content">
                                    <button class="btn btn-sm btn-primary tambahDetailMPO"
                                            data-id="<?= $row['kode_detail_job'] ?>" data-admin="<?= $admin_id ?>">
                                        Tambah detail
                                    </button>
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
                                            <th width="10%">#</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $detail = $row['kode_detail_job'];

                                        $detaildata = "SELECT * FROM tb_list_job where kode_detail_job = :dd";
                                        $sys = $config->runQuery($detaildata);
                                        $sys->execute(array(':dd' => $detail));

                                        $total = $sys->rowCount();
                                        if ($total > 0) {
                                            while ($data = $sys->fetch(PDO::FETCH_LAZY)) {
                                                ?>
                                                <tr style="text-transform: capitalize;">
                                                    <td><?= $data['nama_job'] ?></td>
                                                    <td><?= $data['deskripsi_job'] ?></td>
                                                    <td><?= $data['keterangan'] ?></td>
                                                    <td>
                                                        <button type="button" id="" data-id="<?= $data['id'] ?>"
                                                                data-toggle="tooltip" data-placement="right"
                                                                title="Remove"
                                                                class="btn btn-danger btn-xs removeDetail"><span
                                                                    class="fa fa-fw fa-minus-square"></span></button>
                                                    </td>
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

                <button class="btn btn-sm btn-success pull-right finishJobs" data-spk="<?= $kode ?>">Finish Add Jobs
                </button>
            </div>
        </div>

    <?php } else { ?>
        <div class="x_panel">
            <div class="x_title">
                <h2>Project</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content" id="inputDetail">

            </div>

            <div class="x_content" id="listPanel">
                <?php while ($row = $done->fetch(PDO::FETCH_LAZY)) {
                    if ($row['type'] == 'main') {
                        $panel = "panel-success";
                    } else {
                        $panel = "panel-info";
                    }
                    ?>

                    <div class="panel-group" role="tablist" id="listDetail">
                        <div class="panel <?= $panel ?> ">

                            <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
                                <a href="#<?= $row['kode_detail_job'] ?>" class="" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="collapseListGroup1">
                                    <h4 class="panel-title">
                                        <?= $row['title'] ?>
                                    </h4>
                                </a>
                                <div class="pull-right" style="display: inline;">
                                    <button class="btn btn-xs btn-default removeTitle" id="" data-id="<?= $row['id'] ?>"
                                            data-toggle="tooltip" data-placement="left" title="Remove Title"><span
                                                class="fa fa-fw fa-trash-o"></span></button>
                                </div>


                            </div>

                            <div class="panel-collapse collapse" role="tabpanel" id="<?= $row['kode_detail_job'] ?>"
                                 aria-labelledby="collapseListGroupHeading1" aria-expanded="false" style="">
                                <br/>
                                <div class="x_content">
                                    <button class="btn btn-sm btn-primary tambahDetail"
                                            data-id="<?= $row['kode_detail_job'] ?>" data-admin="<?= $admin_id ?>">
                                        Tambah detail
                                    </button>
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
                                            <th width="10%">#</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $detail = $row['kode_detail_job'];

                                        $detaildata = "SELECT * FROM tb_list_job where kode_detail_job = :dd";
                                        $sys = $config->runQuery($detaildata);
                                        $sys->execute(array(':dd' => $detail));

                                        $total = $sys->rowCount();
                                        if ($total > 0) {
                                            while ($data = $sys->fetch(PDO::FETCH_LAZY)) {
                                                ?>
                                                <tr style="text-transform: capitalize;">
                                                    <td><?= $data['nama_job'] ?></td>
                                                    <td><?= $data['deskripsi_job'] ?></td>
                                                    <td><?= $data['keterangan'] ?></td>
                                                    <td>
                                                        <button type="button" id="" data-id="<?= $data['id'] ?>"
                                                                data-toggle="tooltip" data-placement="right"
                                                                title="Remove"
                                                                class="btn btn-danger btn-xs removeDetail"><span
                                                                    class="fa fa-fw fa-minus-square"></span></button>
                                                    </td>
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

                <button class="btn btn-sm btn-success pull-right finishJobs" data-spk="<?= $kode ?>">Finish Add Jobs
                </button>
            </div>
        </div>

    <?php } ?>

</div>