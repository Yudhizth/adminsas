<div class="clearfix"></div>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>List Karyawan <span class="small">yang telah mengikuti UJIAN TES & INTERVIEW</span></h2>

            <div class="clearfix"></div>
        </div>

        <div class="x_content">


            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                    <tr class="headings">

                        <th class="column-title">Nomor KTP </th>
                        <th class="column-title">Nama Lengkap </th>
                        <th class="column-title">Kode Ujian</th>
                        <th class="column-title">Kode Interview </th>
                        <th class="column-title">HASIL </th>
                        <th class="column-title no-link last"><span class="nobr">Action</span>
                        </th>
                        <th class="bulk-actions" colspan="7">
                            <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                        </th>
                    </tr>
                    </thead>
                    <?php
                    $calon = new Karyawan();
                    $stmt = $calon->runQuery("SELECT tb_karyawan.no_ktp, tb_karyawan.kd_status_karyawan, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.nilai, tb_info_test.kode_test, tb_info_test.status,
tb_info_interview.kd_interview, tb_info_interview.status, tb_kode_status_karyawan.kd_id,tb_kode_status_karyawan.nama_kode FROM tb_karyawan
LEFT JOIN tb_info_test ON tb_info_test.no_ktp = tb_karyawan.no_ktp
LEFT JOIN tb_info_interview ON tb_info_interview.no_ktp = tb_karyawan.no_ktp
INNER JOIN tb_kode_status_karyawan ON tb_kode_status_karyawan.kd_id = tb_karyawan.kd_status_karyawan

WHERE tb_karyawan.kd_status_karyawan IN ('KDKRY0004', 'KDKRY0003', 'KDKRY0005', 'KDKRY0006', 'KDKRY0013', 'KDKRY0014', 'KDKRY0016')");
                    $stmt->execute();
                    ?>
                    <tbody>
                    <?php
                    if($stmt->rowCount() == 0 ){
                        ?>
                        <tr>
                            <td colspan="6">Data belum ada!</td>
                        </tr>
                        <?php
                    }
                    while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
                        # code...
                        $tgl = $row['date_test'];
                        if($row['nilai'] == "0"){
                            $status_karyawan = "<span class='label label-danger'>Tidak Lulus</span>";
                        }elseif($row['nilai'] == "1"){
                            $status_karyawan = "<span class='label label-success'>Lulus</span>";
                        }else{
                            $status_karyawan = "<span class='label label-success'>not set</span>";
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
                            <td class=" "><?php echo $row['kd_interview']; ?></td>
                            <td class=" "><?php echo $status_karyawan; ?></td>
                            <td>
                                <a href="?p=input-nilai&id=<?php echo $row['no_ktp']; ?>">
                                    <button class="btn btn-sm btn-primary">- INPUT -</button>
                                </a>
                            </td>

                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
