<?php 

    $sql = "SELECT tb_perusahaan.kode_perusahaan, tb_perusahaan.nama_perusahaan, tb_temporary_perusahaan.no_pendaftaran, tb_temporary_perusahaan.kebutuhan, tb_temporary_perusahaan.create_date, tb_temporary_perusahaan.kode_pekerjaan, tb_temporary_perusahaan.nama_project, tb_temporary_perusahaan.kd_status, tb_temporary_perusahaan.tanggal, tb_temporary_perusahaan.status, tb_kategori_pekerjaan.nama_kategori, tb_kerjasama_perusahan.total_karyawan, tb_kerjasama_perusahan.nomor_kontrak
    FROM tb_perusahaan
    
    LEFT JOIN tb_temporary_perusahaan ON tb_temporary_perusahaan.kode_perusahaan=tb_perusahaan.kode_perusahaan
    LEFT JOIN tb_kategori_pekerjaan ON tb_kategori_pekerjaan.kode_kategori =tb_temporary_perusahaan.kebutuhan
    LEFT JOIN tb_kerjasama_perusahan ON tb_kerjasama_perusahan.kode_request = tb_temporary_perusahaan.no_pendaftaran WHERE tb_temporary_perusahaan.status = '5'";
    $stmt = $config->runQuery($sql);
    $stmt->execute();
?>

<div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Projects</h2>
                    
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <!-- start project list -->
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 1%">#</th>
                            <th style="width: 20%">Project Name</th>
                            <th>Team Members</th>
                            <th style="width: 20%">Project Progress</th>
                            <th>Status</th>
                            <th style="width: 20%">#Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if($stmt->rowCount() > 0 )
                        {
                            while( $col = $stmt->fetch(PDO::FETCH_LAZY))
                            {
                                $progress = $col['status'];

                                switch ($progress){
                                    case '2':
                                        $param = 25;
                                        $bg ='<button type="button" class="btn btn-info btn-xs">Entry Detail</button>';
                                        break;
                                    case '3':
                                        $param = 55;
                                        $bg ='<button type="button" class="btn btn-primary btn-xs">Entry Karyawan</button>';
                                        break;
                                    case '4':
                                        $param = 75;
                                        $bg ='<button type="button" class="btn btn-primary btn-xs">Entry Jobs</button>';
                                        break;
                                    case '5':
                                        $param = 100;
                                        $bg ='<button type="button" class="btn btn-success btn-xs">Success</button>';
                                        break;
                                    default:
                                        $param = 0;
                                        $bg ='<button type="button" class="btn btn-default btn-xs">Unset</button>';
                                        break;
                                }
                                ?>
                        <tr>

                            <td>#</td>
                            <td>
                                <a><?=$col['nama_kategori']?>/ <small><?=$col['nama_project']?></small></a>
                                <br>
                                <small>Created <?=$col['tanggal']?></small>
                                <br>
                                <p>Base On <span class="label label-primary"><?=$col['nama_perusahaan']?></span> </p>
                            </td>
                            <td>
                                <ul class="list-inline">
                                    <?php
                                    for($i = 0; $i < $col['total_karyawan']; $i++){
                                    ?>
                                    <li>
                                        <img src="images/user.png" class="avatar" alt="Avatar">
                                    </li>

                                    <?php }?>
                                </ul>
                            </td>
                            <td class="project_progress">
                                <div class="progress progress_sm">
                                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?=$param?>" aria-valuenow="<?=$param?>" style="width: 0%;"></div>
                                </div>
                                <small><?=$param?>% Complete</small>
                            </td>
                            <td>
                                <?=$bg?>
                            </td>
                            <td>
                                <?php
                                if(empty($col['nomor_kontrak'])){

                                }else{
                                ?>
                                <a href="?p=detailProject&id=<?=$col['nomor_kontrak']?>" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View </a>
                                <?php } ?>
                                <a href="#" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                                <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                            </td>
                        </tr>
                        <?php } } else{ ?>
                            <tr>
                                <td colspan="6">Perusahaan belum mempunyai Project!</td>
                            </tr>
                        <?php } ?>
                        </tbody>

                    </table>
                    <!-- end project list -->

                </div>
            </div>
        </div>
    </div>