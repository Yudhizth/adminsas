<?php
$records_per_page = 10;
$sql = "SELECT tb_lembur.id, tb_lembur.kode_lembur, tb_lembur.no_ktp, tb_lembur.tanggal, tb_lembur.jam, tb_lembur.keterangan, tb_lembur.status, tb_lembur.admin, tb_karyawan.nama_depan, tb_karyawan.nama_belakang
 FROM tb_lembur 
 INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_lembur.no_ktp
 ORDER BY tanggal DESC";
$dt = $config->paging($sql, $records_per_page);
$stmt = $config->runQuery($dt);
$stmt->execute();


?>
<div class="x_panel" id="contentLembur">
    <div class="x_title">
        <h2>Data Lembur </h2>
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
    <div class="x_content" id="listLembur">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th width="2%">#</th>
                <th width="23%">Nama Karyawan</th>
                <th width="15%">Tanggal Lembur</th>
                <th width="10%">Total Jam</th>
                <th width="30%">Keterangan</th>
                <th width="10%">Status</th>
                <th width="10%">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if($stmt->rowCount() > 0){
                $i = 1;
                while ($row = $stmt->fetch(PDO::FETCH_LAZY)){

                    if($row['status'] == '1'){
                        $status = "<span class='label label-success'>Approve</span>";
                    }elseif($row['status'] == '2'){
                        $status = "<span class='label label-danger'>Decline</span>";
                    }else{
                        $status = "<span class='label label-default'>unset</span>";
                    }
                    ?>
                    <tr>
                        <th scope="row"><?=$i++?></th>
                        <td><?=$row['nama_depan']?> <?=$row['nama_belakang']?></td>
                        <td><?=$row['tanggal']?> </td>
                        <td><?=$row['jam']?> jam</td>
                        <td><?=$row['keterangan']?></td>
                        <td><?=$status?></td>
                        <td>
                           <?php
                           if(empty($row['status'])){ ?>
                               <button type="button" data-toggle="tooltip"
                                       data-kode="<?= $row['id'] ?>" data-ktp="<?=$row['no_ktp']?>" data-admin="<?=$kd_admin?>" data-placement="right"
                                       title="Approve"
                                       class="btn btn-success btn-xs approveLembur"
                                       onclick="return confirm('Are you sure you want to Approve?');">
                                   <i class="fa fa-fw fa-check-square-o"> </i>
                               </button>
                               <button type="button" data-toggle="tooltip"
                                       data-kode="<?= $row['id'] ?>" data-ktp="<?=$row['no_ktp']?>" data-admin="<?=$kd_admin?>" data-placement="right"
                                       title="Decline"
                                       class="btn btn-danger btn-xs declineLembur"
                                       onclick="return confirm('Are you sure you want to Decline?');">
                                   <i class="fa fa-fw fa-times-circle"> </i>
                               </button>
                           <?php } else { echo "Action by: <span class='label label-primary'>".$row['admin'] . "</span>" ; }
                           ?>
                        </td>
                    </tr>

                <?php  }
            }else{ ?>
                <tr>
                    <td colspan="7">Belum ada lemburan.</td>
                </tr>
            <?php }
            ?>

            </tbody>
        </table>

        <?php
        $stmt = $config->paginglink($sql, $records_per_page);
        ?>

    </div>
</div>