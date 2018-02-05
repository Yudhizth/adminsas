<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 04/02/2018
 * Time: 13.39
 */
include_once '../../config/api.php';
$config = new Admin();

$kode = $_GET['kode'];
$id = $_GET['id'];
$kodeListKaryawan = $_GET['generate'];

$records_per_page = 10;

    $query = "SELECT tb_apply_pekerjaan.no_ktp, tb_apply_pekerjaan.kd_pekerjaan, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.jenis_kelamin, tb_karyawan.kd_status_karyawan, tb_kode_status_karyawan.nama_kode
    FROM tb_apply_pekerjaan INNER JOIN tb_karyawan ON tb_karyawan.no_ktp=tb_apply_pekerjaan.no_ktp
    LEFT JOIN tb_kode_status_karyawan ON tb_kode_status_karyawan.kd_id=tb_karyawan.kd_status_karyawan
    WHERE tb_apply_pekerjaan.kd_pekerjaan = '".$kode."' AND tb_karyawan.no_ktp
    NOT IN (SELECT tb_list_karyawan.no_nip FROM tb_list_karyawan INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_list_karyawan.no_nip)
    AND tb_karyawan.kd_status_karyawan IN ('KDKRY0006', 'KDKRY0008', 'KDKRY0009', 'KDKRY0010', 'KDKRY0015')";

    $sql = $config->paging($query, $records_per_page);
    $stmt = $config->runQuery($sql);
    $stmt->execute();


?>

<div class="table-responsive" id="daftarMPO">
    <table class="table table-striped jambo_table bulk_action">
        <thead>
        <tr class="headings">
            <th class="column-title">#</th>
            <th class="column-title">Nama Lengkap</th>
            <th class="column-title">Jenis Kelamin</th>
            <th class="column-title no-link last"><span class="nobr">Status Karyawan</span>
            </th>
            <th class="column-title no-link last"><span class="nobr">#</span>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php

        if($stmt->rowCount() < 1){
            ?>
            <tr>
                <td colspan="5">
                    Karyawan Belum Ada!
                </td>
            </tr>
        <?php }else{
            $i = 1;
        while ($row = $stmt->fetch(PDO::FETCH_LAZY)){ ?>
            <tr>
                <td><?=$i++?></td>
                <td>
                    <a href="?p=detail-karyawan&id=<?= $row['no_ktp']; ?>"
                       data-toggle="tooltip" data-placement="right" title="Detail!">
                        <?= $row['nama_depan']; ?> <?= $row['nama_belakang'] ?>
                    </a></td>
                <td><?=$row['jenis_kelamin']?></td>
                <td><label class="label label-lg label-success"><?=$row['nama_kode']?></label></td>
                <td>
                    <button type="button" data-toggle="tooltip"
                            data-kode="<?= $kodeListKaryawan ?>"
                            data-posisi="<?= $kode ?>"
                            data-ktp="<?= $row['no_ktp'] ?>" data-placement="right"
                            title="Add"
                            class="btn btn-info btn-xs tambahMPO"
                            onclick="return confirm('Are you sure you want to add?');">
                        <i class="fa fa-fw fa-plus-square"> </i>
                    </button>
                </td>
            </tr>
        <?php } } ?>
        </tbody>
    </table>
    <?php
    $self = "$_SERVER[REQUEST_URI]";
    $self = explode('&', $self);

    $url = "index.php?p=karyawan-project&id=" . $id . "&";

    $stmt = $config->paginglinkURLJquery($query, $url, $records_per_page);
    ?>
</div>
