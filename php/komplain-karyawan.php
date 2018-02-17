<?php


$sql = "SELECT tb_complain_karyawan.id, tb_complain_karyawan.kode_komplain, tb_complain_karyawan.id_reff, tb_complain_karyawan.no_ktp, tb_complain_karyawan.judul, tb_complain_karyawan.keterangan, tb_complain_karyawan.create_date, tb_complain_karyawan.update, tb_complain_karyawan.admin, tb_complain_karyawan.status, tb_karyawan.nama_depan, tb_karyawan.nama_belakang
  FROM tb_complain_karyawan INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_complain_karyawan.no_ktp WHERE tb_complain_karyawan.kode_komplain != '' ORDER BY tb_complain_karyawan.update DESC";
$stmt = $config->runQuery($sql);
$stmt->execute();

?>
<div class="x_panel" id="listComplainKaryawan">

    <div class="x_title">
        <h2>List Komplain Karyawan</h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="table-responsive">
            <table id="list_complain_karyawan" class="display" cellspacing="0" width="100%">
                <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Nomor Kupon</th>
                    <th class="column-title">Nama Karyawan</th>
                    <th class="column-title">Create Date</th>
                    <th class="column-title">Status</th>
                    <!-- <th class="column-title">Posisi Lamaran </th> -->

                    <th class="column-title no-link last"><span class="nobr">Action</span>
                    </th>
                    <th class="bulk-actions" colspan="7">
                        <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span
                                class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($stmt->rowCount() == 0) {
                    # code...
                    ?>
                    <tr>
                        <td colspan="7">Data tidak ada</td>
                    </tr>
                    <?php
                } else {
                    $i = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
                        # code...
                        if ($row['status'] == "1") {
                            $status = "<span class='label label-primary'>Process</span>";
                        } elseif ($row['status'] == "2") {
                            $status = "<span class='label label-success'>Done</span>";
                        } else {
                            $status = "<span class='label label-default'>unset</span>";
                        }
                        ?>
                        <tr class="even pointer">
                            <td class=" "><?= $i++ ?></td>
                            <td class=" "><?= $row['kode_komplain'] ?></td>
                            <td class=" "><?= $row['nama_depan'] ?> <?=$row['nama_belakang']?></td>
                            <td class=" "><?= $row['create_date'] ?></td>
                            <td class=" "><?= $status ?></td>
                            <td>
                                <button type="button" data-toggle="tooltip"
                                        data-kupon="<?= $row['kode_komplain'] ?>"
                                        data-admin="<?=$admin_id?>"
                                        data-placement="right"
                                        title="Detail Komplain"
                                        class="btn btn-info btn-xs detailComplainKaryawan">
                                    <i class="fa fa-fw fa-plus-square"> </i>
                                </button>
                            </td>
                        </tr>
                    <?php }
                } ?>

                </tbody>
            </table>
        </div>

    </div>

</div>

<div id="detailKomplainKaryawan"></div>
