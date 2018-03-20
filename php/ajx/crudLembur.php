<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 05/02/2018
 * Time: 15.59
 */

require '../../config/api.php';
$config = new Admin();

if(@$_GET['type'] == 'approve'){
    $ktp = $_POST['ktp'];
    $kode = $_POST['kode'];
    $admin = $_POST['admin'];
    $status = "1";

    $sql = "UPDATE tb_lembur SET status = :status, admin = :admin WHERE id = :kode AND no_ktp = :ktp";
    $stmt = $config->runQuery($sql);
    $stmt->execute(array(
        ':status' => $status,
        ':admin'  => $admin,
        ':kode'   => $kode,
        ':ktp'    => $ktp
    ));

    if($stmt){
        echo "Berhasil di Approve!";
    }else{
        echo "failed";
    }
}

elseif(@$_GET['type'] == 'decline'){
    $ktp = $_POST['ktp'];
    $kode = $_POST['kode'];
    $admin = $_POST['admin'];
    $status = "2";

    $sql = "UPDATE tb_lembur SET status = :status, admin = :admin WHERE id = :kode AND no_ktp = :ktp";
    $stmt = $config->runQuery($sql);
    $stmt->execute(array(
        ':status' => $status,
        ':admin'  => $admin,
        ':kode'   => $kode,
        ':ktp'    => $ktp
    ));

    if($stmt){
        echo "Berhasil di Decline!";
    }else{
        echo "failed";
    }
}