<?php 

  $sql = "SELECT tb_karyawan.id FROM tb_karyawan";
  $stmt = $config->runQuery($sql);
  $stmt->execute();

  $sql2 = "SELECT tb_karyawan.id FROM tb_karyawan WHERE tb_karyawan.kd_status_karyawan IN ('KDKRY0003', 'KDKRY0013')";
  $stmt2 = $config->runQuery($sql2);
  $stmt2->execute();

  $sql3 = "SELECT tb_karyawan.id FROM tb_karyawan WHERE tb_karyawan.kd_status_karyawan IN ('KDKRY0005', 'KDKRY0014')";
  $stmt3 = $config->runQuery($sql3);
  $stmt3->execute();

  $sql4 = "SELECT tb_karyawan.id FROM tb_karyawan WHERE tb_karyawan.kd_status_karyawan IN ('KDKRY0008', 'KDKRY0009', 'KDKRY0010', 'KDKRY0012','KDKRY0015')";
  $stmt4 = $config->runQuery($sql4);
  $stmt4->execute();

  $totalKaryawan = $stmt->rowCount();
  $totalPsikotes = $stmt2->rowCount();
  $totalInterview = $stmt3->rowCount();
  $totalK = $stmt4->rowCount();

  $records_per_page = 10;
?>
<div class="clearfix"></div>
<div class="col-md-12 col-sm-12 col-xs-12">
   <div class="x_panel">
      <div class="row top_tiles">
         <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
               <div class="icon"><i class="fa fa-users"></i></div>
               <div class="count"><?=$totalKaryawan?></div>
               <h3>Total Karyawan</h3>
            </div>
         </div>
         <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
               <div class="icon"><i class="fa fa-pencil-square-o"></i></div>
               <div class="count"><?=$totalPsikotes?></div>
               <h3>Psikotes</h3>
            </div>
         </div>
         <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
               <div class="icon"><i class="fa fa-comments"></i></div>
               <div class="count"><?=$totalInterview?></div>
               <h3>Interviews</h3>
            </div>
         </div>
         <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
               <div class="icon"><i class="fa fa-user"></i></div>
               <div class="count"><?=$totalK?></div>
               <h3>Karyawan</h3>
            </div>
         </div>
      </div>
      <div class="x_content">
        <button id="btnFilter" class="btn btn-block btn-sm btn-primary"  onclick = "showFilter()"><span class="fa fa-fw fa-binoculars"></span> filter</button>
         <div class="x_panel hidden" id="form_filter">
            <div class="x_content " >
               <form id="filterForm" data-parsley-validate="" novalidate="">
                  <div class="form-group">
                     <select class="form-control" id="optionFilter" required="">
                        <option value="">Choose option</option>
                        <option value="locations">available locations</option>
                        <option value="pendidikan">pendidikan</option>
                        <option value="posisi">apply jobs</option>
                    
                     </select>
                  </div>
                  <div class="form-group hidden" id="shcListFilter">
                     
                     <select class="form-control" id="shcList" required="required">
                        <option value="">:: choose ::</option>
                        <option value="s3">strata 3</option>
                        <option value="s2">strata 2</option>
                        <option value="s1">strata 1</option>
                        <option value="d3">diploma 3</option>
                        <option value="sma">sma</option>
                        <option value="smk">smk</option>
                     </select>
                  </div>
                  <div class="form-group hidden" id="jobsListFilter">
                     
                     <select class="form-control js-example-basic-single" id="jobsList" required="">
                        <option value="">jobs list</option>
                     </select>
                  </div>
                  <div class="form-group hidden" id="locationListFilter">
                     
                     <select class="form-control js-example-basic-single" id="provinsiList" required="">
                        <option value="">provinsi</option>
                     </select>
                  </div>
                  <div class="form-group hidden" id="kotaListFilter">
                     
                     <select class="form-control js-example-basic-single" id="kotaList" required="">
                        <option value="">provinsi</option>
                     </select>
                  </div>
                  <div class="form-group">
                     <button class="btn btn-block btn-success" style="text-transform: uppercase; font-size: 12px; font-weight: 600;">filter</button>
                  </div>
               </form>
            </div>
         </div>
         <div class="table-responsive">
            <?php if(isset($_GET['locations'])){ 
              $id = $_GET['locations'];

              $sql = "SELECT tb_karyawan.no_ktp, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.jenis_kelamin, tb_karyawan.nomor_hp, tb_karyawan.email, year(curdate()) - year(str_to_date(tb_karyawan.tgl_lahir,'%d-%m-%Y')) as usia, tb_login_karyawan.joining_date, 
            (SELECT name FROM regencies  WHERE regencies.id IN(".$id.") ) AS lokasi 
            FROM tb_karyawan 
            LEFT JOIN tb_login_karyawan ON tb_login_karyawan.no_ktp = tb_karyawan.no_ktp 
            LEFT JOIN regencies ON regencies.id = tb_karyawan.location 
            WHERE tb_karyawan.location IN (".$id.")
            ORDER BY tb_login_karyawan.joining_date DESC";
              
               $query = $config->paging($sql, $records_per_page);
               $stmt = $config->runQuery($query);
               $stmt->execute();
              ?>
            <table class="table table-striped jambo_table bulk_action">
               <thead>
                  <tr class="headings">
                     <th class="column-title" width="20%">Nama Lengkap </th>
                     <th class="column-title" width="5%">L / P </th>
                     <th class="column-title" width="5%">Usia</th>
                     <th class="column-title" width="15%">Available Location </th>
                     <th class="column-title" width="20%">Join At </th>
                     <th class="column-title no-link last" width="10%"><span class="nobr">Action</span>
                     </th>
                  </tr>
               </thead>
               <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
                  ?>
                  <tr class="even pointer">
                     <td class=" "><?=$row['nama_depan']?> <?=$row['nama_belakang']?></td>
                     <td class=" "><?=$row['jenis_kelamin']?></td>
                     <td class=" "><?=$row['usia']?></td>
                     <td class=" "><?=$row['lokasi']?></td> 
                     <td class="a-right a-right "><?=Date('d M Y', strtotime($row['joining_date']))?></td>
                     <td class=" last">
                        <a href="?p=detail-karyawan&id=<?=$row['no_ktp']?>" target="_blank" >
                        <span class="label label-primary" style="font-size: 80% !important;">Details</span>
                        </a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="add schedule Psikotes?">
                        <span class="label label-success" style="font-size: 80% !important;"><span class="fa fa-fw fa-plus"></span></span>
                        </a>
                     </td>
                  </tr>
                  <?php } ?>
               </tbody>
            </table>
            <?php 
               $url = "locations=" . $id . "&";
               $stmt = $config->paginglinkURL($sql, $url, $records_per_page);
               ?>
            <?php } elseif(isset($_GET['pendidikan'])){ 
              $id = $_GET['pendidikan'];

              $sql = "SELECT tb_info_pendidikan.tingkat, tb_info_pendidikan.nama_bapen, tb_info_pendidikan.jurusan, tb_info_pendidikan.tahun_masuk,  tb_info_pendidikan.tahun_lulus, tb_info_pendidikan.nilai, tb_karyawan.no_ktp, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.jenis_kelamin, tb_login_karyawan.joining_date FROM tb_info_pendidikan
INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_info_pendidikan.no_ktp
INNER JOIN tb_login_karyawan ON tb_login_karyawan.no_ktp = tb_karyawan.no_ktp
WHERE tb_info_pendidikan.tingkat LIKE '%".$id. "%'
ORDER BY tb_login_karyawan.joining_date DESC";
              
               $query = $config->paging($sql, $records_per_page);
               $stmt = $config->runQuery($query);
               $stmt->execute();
              ?>
            <table class="table table-striped jambo_table bulk_action">
               <thead>
                  <tr class="headings">
                     <th class="column-title" width="20%">Nama Lengkap </th>
                     <th class="column-title" width="5%">L / P </th>
                     <th class="column-title" width="15%">Badan Perguruan </th>
                     <th class="column-title" width="20%">Jurusan </th>
                     <th class="column-title" width="5%">Join </th>
                     <th class="column-title" width="5%">Pass </th>
                     <th class="column-title no-link last" width="10%"><span class="nobr">Action</span>
                     </th>
                  </tr>
               </thead>
               <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
                  ?>
                  <tr class="even pointer">
                     <td class=" "><?=$row['nama_depan']?> <?=$row['nama_belakang']?></td>
                     <td class=" "><?=$row['jenis_kelamin']?></td>
                     <td class=" " style="text-transform: uppercase;"><?=$row['nama_bapen']?></td>
                     <td class=" " style="text-transform: uppercase;"><?=$row['jurusan']?></td>
                     <td class=" "><?=$row['tahun_masuk']?></td> 
                     <td class=" "><?=$row['tahun_lulus']?></td> 
                     <td class=" last">
                        <a href="?p=detail-karyawan&id=<?=$row['no_ktp']?>" target="_blank" >
                        <span class="label label-primary" style="font-size: 80% !important;">Details</span>
                        </a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="add schedule Psikotes?">
                        <span class="label label-success" style="font-size: 80% !important;"><span class="fa fa-fw fa-plus"></span></span>
                        </a>
                     </td>
                  </tr>
                  <?php } ?>
               </tbody>
            </table>
            <?php 
               $url = "pendidikan=" . $id . "&";
               $stmt = $config->paginglinkURL($sql, $url, $records_per_page);
               ?>
            <?php } elseif(isset($_GET['posisi'])){ 
          $id = $_GET['posisi'];

              $sql = "SELECT tb_apply_pekerjaan.kd_pekerjaan, tb_apply_pekerjaan.status, tb_jenis_pekerjaan.nama_pekerjaan, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.jenis_kelamin, tb_karyawan.no_ktp, tb_login_karyawan.joining_date FROM tb_apply_pekerjaan
                INNER JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan = tb_apply_pekerjaan.kd_pekerjaan
                INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_apply_pekerjaan.no_ktp
                INNER JOIN tb_login_karyawan ON tb_login_karyawan.no_ktp = tb_karyawan.no_ktp
                WHERE tb_apply_pekerjaan.kd_pekerjaan = '". $id ."'
                ORDER BY tb_login_karyawan.joining_date DESC";
              
               $query = $config->paging($sql, $records_per_page);
               $stmt = $config->runQuery($query);
               $stmt->execute();
              ?>
            <table class="table table-striped jambo_table bulk_action">
               <thead>
                  <tr class="headings">
                     <th class="column-title" width="20%">Nama Lengkap </th>
                     <th class="column-title" width="5%">L / P </th>
                     <th class="column-title" width="15%">Applied For </th>
                     <th class="column-title" width="15%">Join At </th>
                     <th class="column-title no-link last" width="10%"><span class="nobr">Action</span>
                     </th>
                  </tr>
               </thead>
               <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
                  ?>
                  <tr class="even pointer">
                     <td class=" "><?=$row['nama_depan']?> <?=$row['nama_belakang']?></td>
                     <td class=" "><?=$row['jenis_kelamin']?></td>
                     <td class=" "><?=$row['nama_pekerjaan']?></td>
                     <td class="a-right a-right "><?=Date('d M Y', strtotime($row['joining_date']))?></td>
                     <td class=" last">
                        <a href="?p=detail-karyawan&id=<?=$row['no_ktp']?>" target="_blank" >
                        <span class="label label-primary" style="font-size: 80% !important;">Details</span>
                        </a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="add schedule Psikotes?">
                        <span class="label label-success" style="font-size: 80% !important;"><span class="fa fa-fw fa-plus"></span></span>
                        </a>
                     </td>
                  </tr>
                  <?php } ?>
               </tbody>
            </table>
            <?php 
               $url = "posisi=" . $id . "&";
               $stmt = $config->paginglinkURL($sql, $url, $records_per_page);
               ?>
            <?php } else{ 
               $sql = "SELECT tb_karyawan.no_ktp, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.jenis_kelamin, tb_karyawan.nomor_hp, tb_karyawan.email, year(curdate()) - year(str_to_date(tb_karyawan.tgl_lahir,'%d-%m-%Y')) as usia, tb_login_karyawan.joining_date FROM tb_karyawan 
               LEFT JOIN tb_login_karyawan ON tb_login_karyawan.no_ktp = tb_karyawan.no_ktp ORDER BY tb_login_karyawan.joining_date DESC";
               $query = $config->paging($sql, $records_per_page);
               $stmt = $config->runQuery($query);
               $stmt->execute();
               ?>
            <table class="table table-striped jambo_table bulk_action">
               <thead>
                  <tr class="headings">
                     <th class="column-title" width="20%">Nama Lengkap </th>
                     <th class="column-title" width="5%">L / P </th>
                     <th class="column-title" width="15%">Handphone </th>
                     <th class="column-title" width="20%">Email </th>
                     <th class="column-title" width="5%">Ages </th>
                     <th class="column-title" width="15%">Join At </th>
                     <th class="column-title no-link last" width="10%"><span class="nobr">Action</span>
                     </th>
                  </tr>
               </thead>
               <tbody>
                  <?php while ( $row = $stmt->fetch(PDO::FETCH_LAZY)) {
                     ?>
                  <tr class="even pointer">
                     <td class=" "><?=$row['nama_depan']?> <?=$row['nama_belakang']?></td>
                     <td class=" "><?=$row['jenis_kelamin']?></td>
                     <td class=" "><?=$row['nomor_hp']?></td>
                     <td class=" "><?=$row['email']?></td>
                     <td class=" "><?=$row['usia']?><small>th</small></td>
                     <td class="a-right a-right "><?=Date('d M Y', strtotime($row['joining_date']))?></td>
                     <td class=" last">
                        <a href="?p=detail-karyawan&id=<?=$row['no_ktp']?>" target="_blank" >
                        <span class="label label-primary" style="font-size: 80% !important;">Details</span>
                        </a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="add schedule Psikotes?">
                        <span class="label label-success" style="font-size: 80% !important;"><span class="fa fa-fw fa-plus"></span></span>
                        </a>
                     </td>
                  </tr>
                  <?php } ?>
               </tbody>
            </table>
            <?php 
               $url = "" ;
               $stmt = $config->paginglinkURL($sql, $url, $records_per_page);
               ?>
            <?php } ?>
         </div>
      </div>
   </div>
</div>