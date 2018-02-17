<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 06/02/2018
 * Time: 02.54
 */

require '../../config/api.php';
$config = new Admin();

$ktp = $_GET['ktp'];
$dari = $_GET['dari'];
$sampai = $_GET['sampai'];

$start = explode('/', $dari);

$start = $start[1]. '-' .$start[0]. '-'.$start[2];

$end = explode('/', $sampai);
$end = $end[1]. '-' .$end[0]. '-'.$end[2];



$sql = "SELECT tb_absen.no_NIP, tb_absen.start_at, tb_absen.break_at, tb_absen.start_again_at, tb_absen.finish_at, tb_absen.create_date, tb_absen.keterangan, tb_karyawan.nama_depan, tb_karyawan.nama_belakang FROM tb_absen
LEFT JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_absen.no_NIP
WHERE tb_absen.no_NIP = :ktp 
AND tb_absen.create_date >= :start AND tb_absen.create_date <= :ends
ORDER BY tb_absen.create_date ASC";
$stmt = $config->runQuery($sql);
$stmt->execute(array(
    ':ktp'  => $ktp,
    ':start'=> $start,
    ':ends' => $end
));

?>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Rekap Karyawan</small></h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-bordered table-hover">
                <thead>
                <th>Tanggal</th>
                <th>Nama Karyawan</th>
                <th>Clock IN</th>
                <th>Clock Break</th>
                <th>Clock Continue</th>
                <th>Clock OUT</th>
                <th>Keterangan</th>
                </thead>
                <tbody>
                <?php if($stmt->rowCount() > 0 ){ while ($row = $stmt->fetch(PDO::FETCH_LAZY)){
                    ?>
                    <tr>
                        <td><?=$row['create_date']?></td>
                        <td><?=$row['nama_depan']?> <?=$row['nama_belakang']?></td>
                        <td><?=$row['start_at']?></td>
                        <td><?=$row['break_at']?></td>
                        <td><?=$row['start_again_at']?></td>
                        <td><?=$row['finish_at']?></td>
                        <td><?=$row['keterangan']?></td>
                    </tr>
                <?php } }else{ ?>
                    <tr>
                        <td colspan="7">Range Absen Belum Tersedia!</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>