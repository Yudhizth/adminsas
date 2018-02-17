<?php


    $sql = "SELECT tb_complain_perusahaan.id, tb_complain_perusahaan.kode_komplain, tb_complain_perusahaan.id_reff, tb_complain_perusahaan.kode_perusahaan, tb_complain_perusahaan.email, tb_complain_perusahaan.create_date, tb_complain_perusahaan.status, tb_perusahaan.kode_perusahaan AS kodePerusahaan, tb_perusahaan.nama_perusahaan FROM tb_complain_perusahaan LEFT JOIN tb_perusahaan ON tb_perusahaan.email = tb_complain_perusahaan.email WHERE tb_complain_perusahaan.kode_komplain != '' ORDER BY tb_complain_perusahaan.update_on DESC";

    $stmt = $config->runQuery($sql);
    $stmt->execute();

    ?>
    <div class="x_panel" id="listComplain">

        <div class="x_title">
            <h2>List Komplain Perusahaan</h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <div class="table-responsive">
                <table id="list_complain" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr class="headings">
                        <th class="column-title">#</th>
                        <th class="column-title">Nomor Kupon</th>
                        <th class="column-title">Kode Perusahaan</th>
                        <th class="column-title">Nama Perusahaan</th>
                        <th class="column-title">Email</th>
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
                                <td class=" "><?= $row['kodePerusahaan'] ?></td>
                                <td class=" "><?= $row['nama_perusahaan'] ?></td>
                                <td class=" "><?= $row['email'] ?></td>
                                <td class=" "><?= $row['create_date'] ?></td>
                                <td class=" "><?= $status ?></td>
                                <td>
                                    <button type="button" data-toggle="tooltip"
                                            data-kupon="<?= $row['kode_komplain'] ?>"
                                            data-admin="<?=$admin_id?>"
                                            data-placement="right"
                                            title="Detail Komplain"
                                            class="btn btn-info btn-xs detailComplain">
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


<div class="x_panel" id="showDetailComplain">

</div>

<div id="formBalasComplainPerusahaan"></div>


</div>