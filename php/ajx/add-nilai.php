<?php

$kode = $_POST['id'];
$lulus = $_POST['st'];
$kd_status = $_POST['kode'];
$status = "1";
include_once '../../config/api.php';

$config = new Admin();
$sql = "UPDATE tb_karyawan SET nilai = :lulus, status = :status WHERE no_KTP = :ktp";
$stmt = $config->runQuery($sql);

$stmt->execute(array(
    ':lulus'	=> $lulus,
    ':status'   => $status,
    ':ktp'		=> $kode));

if (!$stmt) {
    # code...
    echo "gagal";
} else {

	$sql2 = "UPDATE tb_karyawan SET kd_status_karyawan = :kd_karyawan WHERE no_ktp = :ktp";
    $update = $config->runQuery($sql2);
    $update->execute(array(
      ':kd_karyawan' => $kd_status,
      ':ktp'  => $kode
    ));
    echo "Berhasil Simpan";
    $log = "INSERT INTO tb_log_event (id_reff, types, tables, ket, admin_id) VALUES (:a, :b, :c, :d, :e)";
            $log = $config->runQuery($log);
            $log->execute(array(
                ':a'    => $id_reff,
                ':b'    => '1',
                ':c'    => 'tb_loker',
                ':d'    => 'menambah data loker',
                ':e'    =>  $admin_id
            ));
}

?>