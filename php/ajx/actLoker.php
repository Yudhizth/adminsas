<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 22/03/2018
 * Time: 19.32
 */
include_once '../../config/session.php';
include_once '../../config/api.php';

if(isset($_SESSION['user_session'])){
    $admin_id = $_SESSION['admin_id'];
}else{
    $admin_id = false;
}

$config = new Admin();


if(isset($_POST['saveLoker'])){

    $id = $_POST['txtID'];

    $a = $_POST['txtKategori'];
    $b = $_POST['txtJudul'];
    $c = $_POST['jobsDesc'];
    $d = $_POST['reqLoker'];
    $e = $_POST['txtSalary'];
    $f = $_POST['txtArea'];
    $g = $_POST['txtPengalaman'];

    $date = $config->getDate('Y-m-d');
    $time = $config->getTime('H:m:s');
    $h = $date . ' ' . $time;
    $i = 'Admin';

    $o = array($a, $b, $c, $d, $e, $f, $g);
    if(empty($id)){
//        echo 'input data';
//        echo '<br> <pre>';
//        print_r($o);
//        echo '</pre>';
        $sql = "INSERT INTO tb_loker (id_kategori, judul_loker, job_description, requirements, salary_loker, area_loker, minpengalaman_loker, create_loker, nama_user)
        VALUES (:a, :b, :c, :d, :e, :f, :g, :h, :i)";
        $stmt = $config->runQuery($sql);
        $stmt->execute(array(
            ':a' => $a,
            ':b' => $b,
            ':c' => $c,
            ':d' => $d,
            ':e' => $e,
            ':f' => $f,
            ':g' => $g,
            ':h' => $h,
            ':i' => $i
        ));
        $id_reff = $config->lastInsertID();

        if($stmt){
            

            $log = "INSERT INTO tb_log_event (id_reff, types, tables, ket, admin_id) VALUES (:a, :b, :c, :d, :e)";
            $log = $config->runQuery($log);
            $log->execute(array(
                ':a'    => $id_reff,
                ':b'    => '1',
                ':c'    => 'tb_loker',
                ':d'    => 'menambah data loker',
                ':e'    =>  $admin_id
            ));

            echo "<script>
                        alert('Berhasil ditambahkan!');
                        window.location.href='../../index.php?p=list-loker';
                    </script>";
        }else{
            echo "<script>
                        alert('Gagal ditambahkan!');
                        window.location.href='../../index.php?p=list-loker';
                    </script>";
        }
    }else{

        $sql = "UPDATE tb_loker SET id_kategori = :a, judul_loker = :b, job_description = :c, 
        requirements = :d, salary_loker = :e, area_loker = :f, minpengalaman_loker = :g, create_loker = :h, nama_user = :i
        WHERE id_loker = :id ";
        $stmt = $config->runQuery($sql);
        $stmt->execute(array(
            ':a' => $a,
            ':b' => $b,
            ':c' => $c,
            ':d' => $d,
            ':e' => $e,
            ':f' => $f,
            ':g' => $g,
            ':h' => $h,
            ':i' => $i,
            ':id'  => $id
        ));

        if($stmt){
            $log = "INSERT INTO tb_log_event (id_reff, types, tables, ket, admin_id) VALUES (:a, :b, :c, :d, :e)";
            $log = $config->runQuery($log);
            $log->execute(array(
                ':a'    => $id,
                ':b'    => '2',
                ':c'    => 'tb_loker',
                ':d'    => 'update data loker',
                ':e'    =>  $admin_id
            ));
            echo "<script>
                        alert('Berhasil diUpdate!');
                        window.location.href='../../index.php?p=list-loker';
                    </script>";
        }else{
            echo "<script>
                        alert('Gagal diUpdate!');
                        window.location.href='../../index.php?p=list-loker';
                    </script>";
        }
    }
}