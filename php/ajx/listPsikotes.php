<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 11/02/2018
 * Time: 12.35
 */
include_once '../../config/api.php';

$config = new Admin();

if(@$_GET['type'] == 'psikotes'){
    $filter = $_GET['filter'];
    $type = $_GET['tipe'];

    $records_per_page = 20;
    $query = "SELECT tb_karyawan.no_ktp, tb_karyawan.no_NIK, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_info_test.kode_test, tb_info_test.date_test, tb_info_test.nilai, tb_info_test.kode_admin, tb_info_test.status FROM tb_karyawan
            LEFT OUTER JOIN tb_info_test ON tb_info_test.no_ktp=tb_karyawan.no_ktp 
            WHERE tb_karyawan.no_NIK ='' AND tb_karyawan.".$type." LIKE '%".$filter."%' ORDER BY tb_karyawan.no_ktp ASC";

    $sql = $config->paging($query, $records_per_page);
    $stmt = $config->runQuery($sql);
    $stmt->execute();

    ?>
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
            <tr class="headings">
                <th class="column-title">Nomor KTP </th>
                <th class="column-title">Nama Lengkap </th>
                <th class="column-title">Kode Test</th>
                <th class="column-title">Tanggal Ujian </th>
                <th class="column-title">Status </th>
                <th class="column-title">Kode Admin </th>
                <th class="column-title no-link last"><span class="nobr">Action</span>
                </th>
                <th class="bulk-actions" colspan="7">
                    <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            if($stmt->rowCount() > 0){
                while ( $row = $stmt->fetch(PDO::FETCH_LAZY)) {
                    # code...
                    $tgl = $row['date_test'];

                    if ($tgl == '') {
                        # code...
                        $button = '<button type="button" class="btn btn-primary btn-xs">
                    <i class="fa fa-plus-square"> </i> Add Jadwal
                  </button>';
                    }else{
                        $button = '<button type="button" class="btn btn-danger btn-xs">
                    <i class="fa fa-plus-square"> </i> Re-Schedule
                  </button>';

                    }
                    ?>
                    <tr class="even pointer">
                        <td class=" ">
                            <a href="?p=detail-karyawan&id=<?=$row['no_ktp']; ?>" data-toggle="tooltip" data-placement="left" title="Views Profile">
                                <button type="button" class="btn btn-primary btn-xs">
                                    <?=$row['no_ktp']?> <i class="fa fa-chevron-circle-right"></i>
                                </button>
                            </a>
                        </td>
                        <td class=" "><?php echo $row['nama_depan']; ?> <?php echo $row['nama_belakang']; ?></td>
                        <td class=" "><?php echo $row['kode_test']; ?></td>
                        <td class=" "><?php echo $row['date_test']; ?></td>


                        <td class=" "><span class="label label-success"><?php echo $row['status']; ?></span></td>
                        <td class=" "><?php echo $row['kode_admin']; ?></td>


                        <td>
                            <a href="?p=add-jadwal-test&id=<?php echo $row['no_ktp']; ?>">
                                <?php echo $button; ?>
                            </a>
                        </td>
                        </td>
                    </tr>
                <?php } }else{ ?>
                <tr>
                    <td class=" " colspan="7">Data Karyawan Tidak Ditemukan!.</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php

        $stmt = $config->paginglink($query, $records_per_page);


        ?>
    </div>


<?php }

?>

