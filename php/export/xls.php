<?php
session_start();

require '../../config/api.php';
$config = new Admin();

$ktp = $_GET['ktp'];
$dari = $_GET['dari'];
$sampai = $_GET['sampai'];

$admin_id = $config->adminID();
$admin_id = $admin_id['id'];
$log = "INSERT INTO tb_log_event (id_reff, types, tables, ket, admin_id) VALUES (:a, :b, :c, :d, :e)";
                        $log = $config->runQuery($log);
                        $log->execute(array(
                            ':a'    => $ktp,
                            ':b'    => '2',
                            ':c'    => 'unset',
                            ':d'    => 'export absen karyawan',
                            ':e'    =>  $admin_id
                        ));

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

$stmt1 = $config->runQuery($sql);
$stmt1->execute(array(
    ':ktp'  => $ktp,
    ':start'=> $start,
    ':ends' => $end
));

$row = $stmt1->fetch(PDO::FETCH_LAZY);


header("Content-type: application/octet-stream");
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$row['nama_depan']."_".$row['nama_belakang'].".xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<h3>Data Siswa <?=$row['nama_depan']?> <?=$row['nama_belakang']?></h3>

<table border="1" cellpadding="5">
    <tr>
        <th>Tanggal</th>
        <th>Start</th>
        <th>Break</th>
        <th>Continue</th>
        <th>Finish</th>
        <th>Keterangan</th>
    </tr>
    <?php

    while($data = $stmt->fetch(PDO::FETCH_LAZY)){ // Ambil semua data dari hasil eksekusi $sql
        echo "<tr>";
        echo "<td>".$data['create_date']."</td>";
        echo "<td>".$data['start_at']."</td>";
        echo "<td>".$data['break_at']."</td>";
        echo "<td>".$data['start_again_at']."</td>";
        echo "<td>".$data['finish_at']."</td>";
        echo "<td>".$data['keterangan']."</td>";
        echo "</tr>";

    }
    ?>
</table>