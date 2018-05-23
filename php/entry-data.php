    <?php

    $st = $config->runQuery("SELECT id FROM tb_temporary_perusahaan WHERE kode_perusahaan = ''");
    $st->execute();

    $data  = $st->rowCount();

    $stmt = $config->runQuery("SELECT tb_temporary_perusahaan.no_pendaftaran, tb_temporary_perusahaan.kode_perusahaan, tb_temporary_perusahaan.kebutuhan, tb_temporary_perusahaan.nama_project, tb_temporary_perusahaan.status,tb_kategori_pekerjaan.nama_kategori, tb_perusahaan.nama_perusahaan, tb_kerjasama_perusahan.nomor_kontrak 
    FROM tb_temporary_perusahaan
    INNER JOIN tb_kategori_pekerjaan ON tb_kategori_pekerjaan.kode_kategori = tb_temporary_perusahaan.kebutuhan
    INNER JOIN tb_perusahaan ON tb_perusahaan.kode_perusahaan = tb_temporary_perusahaan.kode_perusahaan
    LEFT JOIN tb_kerjasama_perusahan ON tb_kerjasama_perusahan.kode_request = tb_temporary_perusahaan.no_pendaftaran
    ORDER BY tb_temporary_perusahaan.tanggal DESC");
    $stmt->execute(array());
?>

<div class="x_panel">
    <div class="x_title">
        <h2>Data Perusahaan</h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">

            <div class="col-md-12">


                <br/>

                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Perusahaan Lama</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Perusahaan <small>Baru</small> <span class="label label-success"><?php echo $data; ?></span></a>
                        </li>
                    </ul>

                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane active fade in" id="tab_content1" aria-labelledby="home-tab">

                            <!-- start recent activity -->
                            <ul class="messages">
                                <div class="table-responsive">
                                    <table class="table table-striped jambo_table bulk_action">
                                        <thead>
                                            <tr class="headings">
                                                <th class="column-title">Nama Perusahaan </th>
                                                <th class="column-title">Kebutuhan </th>
                                                <th class="column-title">Detail Request </th>
                                                <th class="column-title">Add Karyawan </th>
                                                <th class="column-title">List Pekerjaan </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($stmt->rowCount() == '') {
                                            # code...
                                            ?>
                                            <tr>
                                                <td colspan="8">Data Tidak Ada</td>
                                            </tr>
                                            <?php
                                        } else{
                                        while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
                                            # code...
                                            // jika detail-request
                                            if ($row['status'] == 3){
                                                $st = '<i class="text-success"><span class="fa fa-fw fa-check-square-o"></span></i>';
                                                $st2 = '<a href="?p=karyawan-project&id='.$row['nomor_kontrak'].'"><button type="button" class="btn btn-success btn-xs"> <i class="fa fa-user"></i>  Add Karyawan </button></a>';
                                                $st3 = '<span class="label label-default">not sett</span>';
                                            }elseif ($row['status'] == 4){
                                                $st = '<i class="text-success"><span class="fa fa-fw fa-check-square-o"></span></i>';
                                                $st2 = '<i class="text-success"><span class="fa fa-fw fa-check-square-o"></span></i>';
                                                $st3 = '<a href="?p=add-list-job&name='.$row['nomor_kontrak'].'"><button type="button" class="btn btn-success btn-xs"> <i class="fa fa-edit"></i>  List Pekerjaan</button></a>';
                                            }
                                            elseif ($row['status'] == 5){
                                                $st = '<i class="text-success"><span class="fa fa-fw fa-check-square-o"></span></i>';
                                                $st2 = '<i class="text-success"><span class="fa fa-fw fa-check-square-o"></span></i>';
                                                $st3 = '<i class="text-success"><span class="fa fa-fw fa-check-square-o"></span></i>';                                         }
                                            else{
                                                $st = '<a href="?p=data-entry&name='.$row['kode_kategori'].''.$row['no_pendaftaran'].'"><button type="button" class="btn btn-success btn-xs"> <i class="fa fa-edit"></i>  Detail Request </button></a>';
                                                $st2 = '<span class="label label-default">not sett</span>';
                                                $st3 = '<span class="label label-default">not sett</span>';
                                            }
                                            ?>
                                                <tr class="even pointer">


                                                    <td  style="text-transform: uppercase;"><?php echo $row['nama_perusahaan']; ?></td>
                                                    <td ><?php echo $row['nama_kategori']; ?> / <?=$row['nama_project']?></td>
                                                    <td ><?php echo $st; ?></td>
                                                    <td ><?php echo $st2; ?></td>
                                                    <td ><?php echo $st3; ?></td>

                                                </tr>
                                    <?php } }?>
                                        </tbody>
                                    </table>
                                </div>
                            </ul>
                            <!-- end recent activity -->

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                            <!-- start user projects -->

                            <ul class="messages">
                                <div class="table-responsive">
                                    <table class="table table-striped jambo_table bulk_action">
                                        <thead>
                                            <tr class="headings">
                                                <th class="column-title">Nama Perusahaan </th>
                                                <th class="column-title">CP </th>
                                                <th class="column-title">Handphone </th>
                                                <th class="column-title">Email </th>
                                                <th class="column-title">Kebutuhan </th>
                                                <th class="column-title">Bergabung Sejak </th>
                                                <th class="column-title">Action </th>
                                            </tr>
                                        </thead>
                                    <?php
                                    $stmt2 = $config->runQuery("SELECT tb_temporary_perusahaan.no_pendaftaran, tb_temporary_perusahaan.kode_perusahaan, tb_temporary_perusahaan.nama_perusahaan, tb_temporary_perusahaan.cp, tb_temporary_perusahaan.phone, tb_temporary_perusahaan.email, tb_temporary_perusahaan.create_date, tb_temporary_perusahaan.status, tb_jenis_pekerjaan.nama_pekerjaan, tb_kategori_pekerjaan.nama_kategori
                                        FROM tb_temporary_perusahaan
                                        LEFT JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan=tb_temporary_perusahaan.kode_pekerjaan
                                        LEFT JOIN tb_kategori_pekerjaan ON tb_kategori_pekerjaan.kode_kategori=tb_temporary_perusahaan.kebutuhan
                                        WHERE tb_temporary_perusahaan.kode_perusahaan = ''
                                        ORDER BY tb_temporary_perusahaan.create_date DESC");
                                    $stmt2->execute(array());
                                    ?>
                                        <tbody>
                                        <?php
                                        if ($stmt2->rowCount() == '') {
                                            # code...
                                            ?>
                                            <tr>
                                                <td colspan="7">Data Tidak Ada</td>
                                            </tr>
                                            <?php
                                        } else{
                                        while ($col = $stmt2->fetch(PDO::FETCH_LAZY)) {
                                            # code...
                                            ?>
                                                <tr class="even pointer">


                                                    <td class="col-md-2"><?php echo $col['nama_perusahaan']; ?></td>
                                                    <td class="col-md-2"><?php echo $col['cp']; ?></td>
                                                    <td class="col-md-2"><?php echo $col['phone']; ?></td>
                                                    <td class="col-md-2"><?php echo $col['email']; ?></td>
                                                    <td class="col-md-1"><?php echo $col['nama_kategori']; ?></td>
                                                    <td class="col-md-2"><?php echo $col['create_date']; ?></td>
                                                    <td class="col-md-2">
                                                        <a href="?p=detail-entry&name=<?php echo $col['no_pendaftaran']; ?>">
                                                        <button type="button" class="btn btn-success btn-xs"> <i class="fa fa-edit">
                                                          </i>  Entry </button>
                                                          </a>
                                                          <a href="php/delete-request.php?id=<?php echo $col['no_pendaftaran']; ?>" onClick="return confirm('Yakin data akan dihapus?')" >
                                                          <button type="button" class="btn btn-danger btn-xs">
                                                          <i class="fa fa-remove">  </i>  Delete
                                                        </button>
                                                      </a>

                                                    </td>

                                                </tr>
                                    <?php } }?>
                                        </tbody>
                                    </table>
                                </div>
                            </ul>


                            <!-- end user projects -->

                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
