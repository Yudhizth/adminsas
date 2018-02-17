<?php
$sql = "SELECT tb_karyawan.id FROM tb_karyawan";
$stmt = $config->runQuery($sql);
$stmt->execute();

$sql2 = "SELECT tb_karyawan.kd_status_karyawan FROM tb_karyawan WHERE tb_karyawan.kd_status_karyawan IN ('KDKRY0003', 'KDKRY0013')";
$stmt2 = $config->runQuery($sql2);
$stmt2->execute();

$sql3 = "SELECT tb_karyawan.kd_status_karyawan FROM tb_karyawan WHERE tb_karyawan.kd_status_karyawan IN ('KDKRY0005', 'KDKRY0014')";
$stmt3 = $config->runQuery($sql3);
$stmt3->execute();

$sql4 = "SELECT tb_karyawan.kd_status_karyawan FROM tb_karyawan WHERE tb_karyawan.kd_status_karyawan IN ('KDKRY0008', 'KDKRY0009', 'KDKRY0010', 'KDKRY0012','KDKRY0015','KDKRY0011','KDKRY0002')";
$stmt4 = $config->runQuery($sql4);
$stmt4->execute();

$sql5 = "SELECT tb_karyawan.jenis_kelamin FROM tb_karyawan WHERE tb_karyawan.jenis_kelamin = 'L'";
$stmt5 = $config->runQuery($sql5);
$stmt5->execute();

$sql6 = "SELECT tb_karyawan.jenis_kelamin FROM tb_karyawan WHERE tb_karyawan.jenis_kelamin = 'P'";
$stmt6 = $config->runQuery($sql6);
$stmt6->execute();

$totalKaryawan = $stmt->rowCount();
$totalPsikotes = $stmt2->rowCount();
$totalInterview = $stmt3->rowCount();
$totalK = $stmt4->rowCount();

$totalPria = $stmt5->rowCount();
$totalWanita = $stmt6->rowCount();
?>
<!-- top tiles -->
<div class="row tile_count">
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
    <div class="count"><?=$totalKaryawan?></div>
<!--    <span class="count_bottom"><i class="green">4% </i> From last Week</span>-->
  </div>
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-clock-o"></i> Total Karyawan</span>
    <div class="count"><?=$totalK?></div>
<!--    <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>-->
  </div>
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-user"></i> Total Males</span>
    <div class="count green"><?=$totalPria?></div>
<!--    <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>-->
  </div>
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-user"></i> Total Females</span>
    <div class="count"><?=$totalWanita?></div>
<!--    <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>-->
  </div>
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-user"></i> Total Psikotes</span>
    <div class="count"><?=$totalPsikotes?></div>
<!--    <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>-->
  </div>
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-user"></i> Total Interview</span>
    <div class="count"><?=$totalInterview?></div>
<!--    <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>-->
  </div>
</div>