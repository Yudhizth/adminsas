<?php

$kode = $_POST['id'];
$lulus = $_POST['st'];
$kd_status = $_POST['kode'];
$status = "1";
include_once '../../config/api.php';

$kelas = new Admin();
$sql = "UPDATE tb_karyawan SET nilai = :lulus, status = :status WHERE no_KTP = :ktp";
$stmt = $kelas->runQuery($sql);

$stmt->execute(array(
    ':lulus'	=> $lulus,
    ':status'   => $status,
    ':ktp'		=> $kode));

if (!$stmt) {
    # code...
    echo "gagal";
} else {

	$sql2 = "UPDATE tb_karyawan SET kd_status_karyawan = :kd_karyawan WHERE no_ktp = :ktp";
    $update = $kelas->runQuery($sql2);
    $update->execute(array(
      ':kd_karyawan' => $kd_status,
      ':ktp'  => $kode
    ));
    echo "Berhasil Simpan";
}

?>