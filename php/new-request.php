<?php

    $sql = "SELECT * FROM tb_kategori_pekerjaan";
    $stmt = $config->runQuery($sql);
    $stmt->execute();

    $query = "SELECT tb_perusahaan.kode_perusahaan, tb_perusahaan.nama_perusahaan FROM tb_perusahaan";
    $perusahaan = $config->runQuery($query);
$perusahaan->execute();

    $sq = "SELECT * FROM tb_jenis_pekerjaan";
    $jenis = $config->runQuery($sq);
    $jenis->execute();

    $kodeMPO = $config->generateRandomString(24);

?>
<div class="col-md-5 col-sm-5 col-md-offset-4 col-sm-offset-4 col-xs-12">
    <div class="" id="requestKebutuhanPerusahaan">
        <div class="x_panel">
            <div class="x_title">
                <h2>Add New Request</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="formRequestKebutuhan" data-parsley-validate="" >
                    <div class="form-group">
                        <label for="fullname" >List Perusahaan * :</label>
                        <select class="form-control" id="listPerusahaan" required>
                            <option value="">Choose option</option>
                            <?php if($perusahaan->rowCount() > 0){
                                while ($col = $perusahaan->fetch(PDO::FETCH_LAZY)){
                                ?>
                            <option value="<?=$col['kode_perusahaan']?>"><?=$col['nama_perusahaan']?></option>
                            <?php }}else{} ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fullname" >List Kebutuhan * :</label>
                        <select class="form-control" id="listKebutuhan" required>
                            <option value="">Choose option</option>
                            <?php while ($row = $stmt->fetch(PDO::FETCH_LAZY)){ ?>
                            <option value="<?=$row['kode_kategori']?>"><?=$row['nama_kategori']?></option>
                                <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-block btn-primary buttooom" style="text-transform: uppercase; font-size: 12px; font-weight: 600;">add request</button>
                    </div>


                </form>
            </div>
        </div>
    </div>

    <div class="" id="requestKebutuhanPerusahaanMPO">
        <div class="x_panel">
            <div class="x_title">
                <h2>Request MPO</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="formRequestKebutuhanMPO" data-parsley-validate="" >
                    <div class="form-group">
                        <label for="fullname" >Kode Perusahaan :</label>
                        <input type="text" id="txtPerusahaan" class="form-control" name="fullname" value="" readonly>
                        <input type="text" id="txtMPO" class="form-control" name="fullname" value="<?=$kodeMPO?>" readonly>

                    </div>

                    <div class="form-group">
                        <label for="fullname" >List Posisi * :</label>
                        <select class="form-control" id="listJenis" required>
                            <option value="">Choose option</option>
                            <?php while ($ls = $jenis->fetch(PDO::FETCH_LAZY)){ ?>
                                <option value="<?=$ls['kd_pekerjaan']?>"><?=$ls['nama_pekerjaan']?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-block btn-primary buttooom" style="text-transform: uppercase; font-size: 12px; font-weight: 600;">add request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="" id="listKebutuhanPerusahaanMPO">
        <div class="x_panel">
            <div class="x_title">
                <h2>List MPO</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="formRequestKebutuhan" data-parsley-validate="" >
                    <div class="form-group">
                        <label for="fullname" >List Perusahaan * :</label>
                        <select class="form-control" id="listPerusahaan" required>
                            <option value="">Choose option</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fullname" >List Kebutuhan * :</label>
                        <select class="form-control" id="listKebutuhan" required>
                            <option value="">Choose option</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-block btn-primary buttooom" style="text-transform: uppercase; font-size: 12px; font-weight: 600;">add request</button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>

<!--<div class="clearfix"></div>-->
<!---->
<!--<div class="col-md-12 col-sm-12 col-xs-12">-->
<!--  <div class="x_panel">-->
<!--    <div class="x_title">-->
<!--      <h2>List Permintaan Karyawan <small>Baru</small></h2>-->
<!--      -->
<!--      <div class="clearfix"></div>-->
<!--    </div>-->
<!---->
<!--    <div class="x_content">-->
<!---->
<!--      -->
<!---->
<!--      <div class="table-responsive">-->
<!--        <table class="table table-striped jambo_table bulk_action table-responsive">-->
<!--          <thead>-->
<!--            <tr class="headings">-->
<!--              -->
<!--              <th class="column-title">Nama Perusahaan </th>-->
<!--              <th class="column-title">Kebutuhan </th>-->
<!--              <th class="column-title">Jenis Pekerjaan </th>-->
<!--              <th class="column-title">Contact Person </th>-->
<!--              <th class="column-title">Status </th>-->
<!--              <th class="column-title">Tanggal Update </th>-->
<!--              <th class="column-title no-link last"><span class="nobr">Action</span>-->
<!--              </th>-->
<!--              <th class="bulk-actions" colspan="7">-->
<!--                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>-->
<!--              </th>-->
<!--            </tr>-->
<!--          </thead>-->
<!---->
<!--          <tbody>-->
<!--          --><?php //
//          $list = new Admin();
//          $records_per_page = 10;
//          $query = "SELECT tb_temporary_perusahaan.no_pendaftaran, tb_temporary_perusahaan.kode_perusahaan, tb_temporary_perusahaan.nama_perusahaan, tb_temporary_perusahaan.cp, tb_temporary_perusahaan.phone, tb_temporary_perusahaan.email, tb_temporary_perusahaan.create_date, tb_temporary_perusahaan.kd_status, tb_temporary_perusahaan.tanggal, tb_temporary_perusahaan.status, tb_jenis_pekerjaan.nama_pekerjaan, tb_kategori_pekerjaan.nama_kategori, tb_status_request.nama_status FROM tb_temporary_perusahaan
//            LEFT JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan=tb_temporary_perusahaan.kode_pekerjaan
//            LEFT JOIN tb_kategori_pekerjaan ON tb_kategori_pekerjaan.kode_kategori=tb_temporary_perusahaan.kebutuhan
//            LEFT JOIN tb_status_request ON tb_status_request.kd_stat=tb_temporary_perusahaan.kd_status
//            ORDER BY tb_temporary_perusahaan.create_date DESC";
//          $sql = $list->paging($query, $records_per_page);
//          $stmt = $list->runQuery($sql);
//          $stmt->execute();
//
//
//
//          if ($stmt->rowCount() == "") {
//            # code...
//            ?>
<!--            <tr>-->
<!--              <td colspan="8">-->
<!--                <center><span class="text-danger"> Data Tidak ada.</span></center>-->
<!--              </td>-->
<!--            </tr>-->
<!--            --><?php
//          } else {
//          while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
//            # code..
//
//          ?>
<!--            <tr class="even pointer">-->
<!--              -->
<!--              <td class="col-md-2">--><?php //echo $row['nama_perusahaan']; ?><!-- </td>-->
<!--              <td class="col-md-2">--><?php //echo $row['nama_kategori']; ?><!-- </td>-->
<!--              <td class="col-md-2">--><?php //echo $row['nama_pekerjaan']; ?><!-- </td>-->
<!--              <td class="col-md-3"><strong><span class="text-danger">--><?php //echo $row['cp']; ?><!-- | --><?php //echo $row['phone']; ?><!--</span></strong></td>-->
<!--              <td class="col-md-1 a-right a-right ">-->
<!--                <label class="label label-lg label-success">--><?php //echo $row['nama_status']; ?><!--</label>-->
<!--              <td class="col-md-2">--><?php //echo $row['tanggal']; ?><!-- </td>-->
<!--              </td>-->
<!--              <td class=" col-md-2">-->
<!--              <a href="?p=detail-request&name=--><?php //echo $row['no_pendaftaran']; ?><!--">-->
<!--                <button type="button" class="btn btn-success btn-xs"> <i class="fa fa-plus">-->
<!--                  </i>  Views </button>-->
<!--                  </a>-->
<!--                -->
<!--              </td>-->
<!--            </tr>-->
<!--            --><?php //}
//
//
//          }
//          ?>
<!--          </tbody>-->
<!--        </table>-->
<!---->
<!--        --><?php
//
//        $stmt = $list->paginglink($query, $records_per_page);
//
//
//        ?>
<!---->
<!--      </div>-->
<!--</div>-->
<!--    </div>-->
<!--    </div>-->
<!--    -->