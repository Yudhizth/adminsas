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
?>
<div class="clearfix"></div>

<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>List Pelamar </h2>

      <div class="clearfix"></div>
    </div>
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

         <div>
         <span style=font-size:18px;><strong> Hide Column : </strong></span>
                <a class="toggle-vis" data-column="1">Nomor KTP</a> -
                <a class="toggle-vis" data-column="2">Nama Lengkap</a> -
                <a class="toggle-vis" data-column="3">L/P</a> -
                <a class="toggle-vis" data-column="4">Posisi</a> -
                <a class="toggle-vis" data-column="5">Nomor Telphone</a> -
                <a class="toggle-vis" data-column="6">Age</a> -
                <a class="toggle-vis" data-column="7">Tanggal Daftar</a>
		</div>

        <tr>
            <td>Minimum age:</td>
            <td><input id="min" name="min" type="text"></td>
        </tr>
        <tr>
            <td>Maximum age:</td>
            <td><input id="max" name="max" type="text"></td>
            </br></br>
        </tr>

        <div class="col-md-2">
          <select id="selectKaryawan" class="form-control">
          <option>Choose Search</option>
          <option>Nomor KTP</option>
          <option>Nama Lengkap</option>
          <option>L/P</option>
          <option>Posisi</option>
          <option>Pendidikan</option>
          <option>Age</option>
          <option>Tanggal Daftar</option>
          </select>
        </div>
        </br></br>

      <div class="table-responsive">
        <table id="list_pelamar" class="display" cellspacing="0" width="100%">
          <thead>
            <tr class="headings">
              <th>
                <input type="checkbox" id="check-all" class="flat">
              </th>
              <th class="column-title">Nomor KTP </th>
              <th class="column-title">Nama Lengkap </th>
              <th class="column-title">L/P</th>
              <th class="column-title">Posisi </th>
              <th class="column-title">Pendidikan </th>
              <th class="column-title">Age</th>
              <th class="column-title">Tanggal Daftar </th>
              <!-- <th class="column-title">Posisi Lamaran </th> -->

              <th class="column-title no-link last"><span class="nobr">Action</span>
              </th>
              <th class="bulk-actions" colspan="7">
                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
              </th>
            </tr>
          </thead>
          <?php

            $calon = new Karyawan();
            $stmt = $calon->runQuery("SELECT year(curdate()) - year(str_to_date(tb_karyawan.tgl_lahir,'%d-%m-%Y')) as Age, tb_karyawan.no_ktp, no_NIK, nama_depan, nama_belakang, jenis_kelamin, tb_karyawan.email, tb_karyawan.nomor_hp, pendidikan, posisi, nama_pekerjaan  ,tb_login_karyawan.joining_date FROM tb_karyawan
LEFT JOIN tb_login_karyawan ON tb_login_karyawan.no_ktp = tb_karyawan.no_ktp
LEFT JOIN (SELECT no_ktp, max(tingkat) as pendidikan FROM tb_info_pendidikan GROUP BY no_ktp ORDER BY pendidikan DESC) b ON tb_karyawan.no_ktp=b.no_ktp
LEFT JOIN (SELECT no_ktp, max(tb_apply_pekerjaan.kd_pekerjaan) AS posisi, tb_jenis_pekerjaan.nama_pekerjaan FROM tb_apply_pekerjaan INNER JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan=tb_apply_pekerjaan.kd_pekerjaan GROUP BY no_ktp ORDER BY posisi DESC) c ON tb_karyawan.no_ktp=c.no_ktp
WHERE no_NIK = '' order by tb_login_karyawan.joining_date DESC");
            $stmt->execute();
          ?>
          <tbody>
          <?php
            if ($stmt->rowCount() == 0 ) {
              # code...
              ?>
              <tr>
                <td colspan="9">Data tidak ada</td>
              </tr>
              <?php
            } else {
              while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
              # code...
             ?>
            <tr class="even pointer">
              <td class="a-center ">
                <input type="checkbox" class="flat" name="table_records">
              </td>
              <td class=" "><?php echo $row['no_ktp']; ?></td>
              <td class=" "><?php echo $row['nama_depan']; ?> <?php echo $row['nama_belakang']; ?></td>
              <td class=" "><?php echo $row['jenis_kelamin']; ?></td>
              <td class=" "><?php echo $row['nama_pekerjaan']; ?></td>
              <td class=" "><?php echo $row['pendidikan']; ?></td>
              <td class=" "><?php echo $row['Age']; ?></td>
              <td class=" "><?php echo $row['joining_date']; ?></td>
              <!-- <td class=" "><span class="label label-success"><?php echo $row['nama_pekerjaan']; ?></span></td> -->
              <td>
                <a href="?p=detail-karyawan&id=<?php echo $row['no_ktp']; ?>">
                  <button type="button" class="btn btn-primary btn-xs">
                    <i class="fa fa-user"> </i> View Profile
                  </button>
                </a>
              </td>
              </td>
            </tr>
            <?php } } ?>

          </tbody>
        </table>
      </div>

</div>
    </div>
    </div>
