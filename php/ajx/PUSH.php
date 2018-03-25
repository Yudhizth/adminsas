<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 23/03/2018
 * Time: 14.14
 */

include_once '../../config/api.php';
$config = new Admin();

date_default_timezone_set("Asia/Jakarta");
$tgl = date('Y-m-d H:m:s');

if($_GET['type'] == 'insert'){

    $a = $_POST['kepada'];
    $a = explode(',', $a);

    $b = $_POST['admin'];
    $c = $_POST['subject'];
    $d = $_POST['isi'];

    foreach ($a as $key => $value){
        //kode push

        $id = "kode_compos";
        $kode = "PUSH";
        $tbName = "tb_compos";
        $code_push = $config->Generate($id, $kode, $tbName);

        //ends
        $name = explode('_', $value);
        $name = $name[1];

        $sql = "INSERT INTO tb_compos (kode_compos, no_ktp, judul, isi, create_date, admin) VALUES (:a, :b, :c, :d, :e, :f)";
        $stmt = $config->runQuery($sql);
        $stmt->execute(array(
            ':a'    => $code_push,
            ':b'    => $name,
            ':c'    => $c,
            ':d'    => $d,
            ':e'    => $tgl,
            ':f'    => $b
        ));

        if($stmt){
            echo "Push has been Send!";
        }else{
            echo "Failed!";
        }
    }
}elseif($_GET['type'] == 'replay'){

    $a = $_POST['admin'];
    $b = $_POST['id_reff'];
    $c = $_POST['isi'];

    $sql = "INSERT INTO tb_compos (id_reff, isi, create_date, admin) VALUES (:b, :c, :admin, :a)";
    $stmt = $config->runQuery($sql);
    $stmt->execute(array(
        ':b'    => $b,
        ':c'    => $c,
        ':admin'=>$tgl,
        ':a'    => $a
    ));

    if($stmt){
        echo "Replay has been Send!";

        $query = "UPDATE tb_compos SET status = '' WHERE tb_compos.kode_compos = :kode ";
        $send = $config->runQuery($query);
        $send->execute(array(':kode' => $b));

    }else{
        echo "Failed!";
    }
}