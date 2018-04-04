<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 05/02/2018
 * Time: 15.59
 */
session_start();
require '../../config/api.php';
$config = new Admin();
$admin_id = $config->adminID();
$admin_id = $admin_id['id'];

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
            $log = "INSERT INTO tb_log_event (id_reff, types, tables, ket, admin_id) VALUES (:a, :b, :c, :d, :e)";
            $log = $config->runQuery($log);
            $log->execute(array(
                ':a'    => $kode,
                ':b'    => '3',
                ':c'    => 'tb_lembur',
                ':d'    => 'update approved lembur',
                ':e'    =>  $admin_id
            ));
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
            $log = "INSERT INTO tb_log_event (id_reff, types, tables, ket, admin_id) VALUES (:a, :b, :c, :d, :e)";
            $log = $config->runQuery($log);
            $log->execute(array(
                ':a'    => $kode,
                ':b'    => '3',
                ':c'    => 'tb_lembur',
                ':d'    => 'update decline lembur',
                ':e'    =>  $admin_id
            ));
    }else{
        echo "failed";
    }
}