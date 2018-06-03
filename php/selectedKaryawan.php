<?php

    if($typeKebutuhan == 'MPO01'){
?>
        <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                <tr class="headings">
                    <th class="column-title">Nama Lengkap</th>
                    <th class="column-title">Posisi</th>
                    <th class="column-title">Lokasi</th>
                    <th class="column-title no-link last"><span class="nobr">Konfirmasi</span>
                    </th>
                    <th class="column-title no-link last"><span class="nobr">#</span>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;

                if($selectedKaryawan->rowCount() > 0){
                    while ($data = $selectedKaryawan->fetch(PDO::FETCH_LAZY))
                    {
                        $st = $data['status_karyawan'];

                        if ($st == '2') {
                            $status = '<label class="label label-lg label-success">Approved!</label>';
                        } elseif ($st == '3') {
                            $status = '<label class="label label-lg label-danger">Decline!</label>';
                        } else {
                            $status = '<label class="label label-lg label-info">Suggested</label>';
                        } ?>
                        <tr class="even pointer">
                            <td class=" ">
                                <a href="?p=detail-karyawan&id=<?= $data['no_nip']; ?>"
                                   data-toggle="tooltip" data-placement="right" title="Detail!">
                                    <?= $data['nama_depan']; ?> <?= $data['nama_belakang'] ?>
                                </a>
                            </td>
                            <td class=" "><?= $data['nama_pekerjaan']; ?></td>
                            <td class=" "><?= $data['Lokasi']; ?></td>

                            <td><?=$status?></td>
                            <td>
                                <?php if($st != 1) { ?>
                                    <button class="btn btn-xs btn-primary removeKaryawanProject" data-ktp="<?=$data['no_nip']?>" data-kd="<?=$kodeListKaryawan?>"  data-toggle="tooltip" data-placement="top" title="Remove Karyawan"><span class="fa fa-fw fa-times-circle"></span></button>
                                <?php }else{echo "-";} ?>
                            </td>
                        </tr>
                        <?php
                    }

                }else{
                    echo "<td colspan='7' style='font-size=18px; font-wight=500;'>Karyawan Belum Dipilih!</td>";
                }
                ?>

                </tbody>
            </table>
            <button class="btn btn-sm btn-success pull-right finishAddKaryawan" data-request="<?=$dataSPK['nomor_kontrak']?>">Finish Add Karyawan <span class="glyphicon glyphicon-thumbs-up"></span></button>
        </div>

<?php }else{ ?>

        <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                <tr class="headings">
                    <th class="column-title">Nama Lengkap</th>
                    <th class="column-title">Jenis Kelamin</th>
                    <th class="column-title">Lokasi</th>
                    <th class="column-title no-link last"><span class="nobr">Konfirmasi</span>
                    </th>
                    <th class="column-title no-link last"><span class="nobr">#</span>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;

                if($selectedKaryawan->rowCount() > 0){
                    while ($data = $selectedKaryawan->fetch(PDO::FETCH_LAZY))
                    {
                        $st = $data['status_karyawan'];

                        if ($st == '2') {
                            $status = '<label class="label label-lg label-success">Approved!</label>';
                        } elseif ($st == '3') {
                            $status = '<label class="label label-lg label-danger">Decline!</label>';
                        } else {
                            $status = '<label class="label label-lg label-info">Suggested</label>';
                        } ?>
                        <tr class="even pointer">
                            <td class=" ">
                                <a href="?p=detail-karyawan&id=<?= $data['no_nip']; ?>"
                                   data-toggle="tooltip" data-placement="right" title="Detail!">
                                    <?= $data['nama_depan']; ?> <?= $data['nama_belakang'] ?>
                                </a>
                            </td>
                            <td class=" "><?= $data['jenis_kelamin']; ?></td>
                            <td class=" "><?= $data['Lokasi']; ?></td>

                            <td><?=$status?></td>
                            <td>
                                <?php if($st != 1) { ?>
                                    <button class="btn btn-xs btn-primary removeKaryawanProject" data-ktp="<?=$data['no_nip']?>" data-kd="<?=$kodeListKaryawan?>"  data-toggle="tooltip" data-placement="top" title="Remove Karyawan"><span class="fa fa-fw fa-times-circle"></span></button>
                                <?php }else{echo "-";} ?>
                            </td>
                        </tr>
                        <?php
                    }

                }else{
                    echo "<td colspan='7' style='font-size=18px; font-wight=500;'>Karyawan Belum Dipilih!</td>";
                }
                ?>

                </tbody>
            </table>
            <button class="btn btn-sm btn-success pull-right finishAddKaryawan" data-request="<?=$dataSPK['nomor_kontrak']?>">Finish Add Karyawan <span class="glyphicon glyphicon-thumbs-up"></span></button>
        </div>
<?php } ?>

