<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 05/02/2018
 * Time: 23.49
 */

require '../../config/api.php';
$config = new Admin();

if(@$_GET['type'] == 'addNIP'){
    $ktp = $_POST['ktp'];

    $sql = "UPDATE tb_karyawan SET no_NIK = :nip WHERE no_ktp = :ktp";
    $stmt = $config->runQuery($sql);
    $stmt->execute(array(
        ':nip'  => $ktp,
        ':ktp'  => $ktp
    ));

    if($stmt){
        echo 'NIP berhasil ditambahkan.';
    }else{
        echo 'failed';
    }
}