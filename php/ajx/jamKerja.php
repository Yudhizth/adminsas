<?php
/**
 * Created by PhpStorm.
 * User: Arfan Azhari
 * Date: 04/06/2017
 * Time: 10:57
 */
include_once '../../config/session.php';
include_once '../../config/api.php';

if (isset($_SESSION['user_session'])) {
    $admin_id = $_SESSION['admin_id'];
} else {
    $admin_id = false;
}

$config = new Admin();

if ($_GET['type'] == 'Shift') {
    $a = $_POST['nomor_kontrak'];
    $b = $_POST['shifts'];

    $sql = $config->runQuery("UPDATE tb_kerjasama_perusahan SET shift_times = :shift WHERE nomor_kontrak = :nomor ");
    $sql->execute(array(
        ':shift' => $b,
        ':nomor' => $a
    ));
    if ($sql) {
        echo 'ok';
    } else {
        echo 'Faield';
    }
}

if ($_GET['type'] == 'freelance') {
    $a = $_POST['kota'];
    $b = $_POST['type_time'];
    $c = $_POST['nomor_kontrak'];
    $d = $_POST['jamKerja'];


    $cek = $config->runQuery("SELECT id FROM tb_time WHERE nomor_kontrak = :kontrak AND lokasi = :lokasi");
    $cek->execute(array(':kontrak' => $c, ':lokasi' => $a));

    if ($cek->rowCount() > 0) {
        //echo 'update';
        $update = $config->runQuery("UPDATE tb_time SET jamKerja = '" . $d . "' WHERE nomor_kontrak = '" . $c . "' AND lokasi = " . $a . " ");
        $update->execute();
        if ($update) {
            echo 'Berhasil Update jam kerja!';
        } else {
            echo 'Failed!';
        }
    } else {
        $sql = $config->runQuery("INSERT INTO tb_time (nomor_kontrak, lokasi, jamKerja) VALUES (:a, :b, :c)");
        $sql->execute(array(
            ':a' => $c,
            ':b' => $a,
            ':c' => $d
        ));
        if ($sql) {
            echo 'Berhasil input jam kerja!';
        } else {
            echo 'Failed!';
        }
    }

}

if($_GET['type'] == 'doneSchedule'){
    $a = $_POST['id'];

    //cek
    $cek = $config->runQuery("SELECT kode_request FROM tb_kerjasama_perusahan WHERE nomor_kontrak = '". $a ."'");
    $cek->execute();
    $info = $cek->fetch(PDO::FETCH_LAZY);

    //update
    $sql = "UPDATE tb_temporary_perusahaan SET status = '3' WHERE  no_pendaftaran = '". $info['kode_request'] ."' ";
    $stmt = $config->runQuery($sql);
    $stmt->execute();

    if($stmt){
        echo 'Ok';
    }else{
        echo 'No';
    }
}
if(@$_GET['type'] == 'shiftTime'){
    $a = $_POST['nomor_kontrak'];
    $b = $_POST['lokasi'];
    $c = $_POST['jamKerja'];
    $d = $_POST['total_shift'];
    $e = $_POST['shift_number'];

    $dd = json_decode($c, true);

    $jam = [];
    for ($i=1; $i <= $d ; $i++) { 
        # code...
        // $jam[$i] = $dd[$i];
        $jam['shift'][$i] = $dd[$i];
    }

   

    $jamFix = json_encode($jam, true);
    
    $cek = $config->runQuery("SELECT id FROM tb_time WHERE nomor_kontrak = :kontrak AND lokasi = :lokasi");
    $cek->execute(array(':kontrak' => $a, ':lokasi' => $b));

    if ($cek->rowCount() > 0) {

        $update = $config->runQuery("UPDATE tb_time SET jamKerja = '" . $jamFix . "' WHERE nomor_kontrak = '" . $a . "' AND lokasi = " . $b . " ");
        $update->execute();
        if ($update) {
            echo 'Berhasil Update jam kerja!';
            $dd = json_decode($c, true);
//            print_r($dd[2]) ;
        } else {
            echo 'Failed!';
        }
    } else {
        $sql = $config->runQuery("INSERT INTO tb_time (nomor_kontrak, lokasi, jamKerja) VALUES (:a, :b, :c)");
        $sql->execute(array(
            ':a' => $a,
            ':b' => $b,
            ':c' => $jamFix
        ));
        if ($sql) {
            echo 'Berhasil input jam kerja!';
        } else {
            echo 'Failed!';
        }

    }
}
if(@$_GET['type'] == 'kontrak'){
    $a = $_POST['spk'];
    $b = $_POST['lokasi'];
    $c = $_POST['jamKerja'];

    $cek = $config->runQuery("SELECT id FROM tb_time WHERE nomor_kontrak = :kontrak AND lokasi = :lokasi");
    $cek->execute(array(':kontrak' => $a, ':lokasi' => $b));

    if ($cek->rowCount() > 0) {
        //echo 'update';
        $update = $config->runQuery("UPDATE tb_time SET jamKerja = '" . $c . "' WHERE nomor_kontrak = '" . $a . "' AND lokasi = " . $b . " ");
        $update->execute();
        if ($update) {
            echo 'Berhasil Update jam kerja!';
        } else {
            echo 'Failed!';
        }
    } else {
        $sql = $config->runQuery("INSERT INTO tb_time (nomor_kontrak, lokasi, jamKerja) VALUES (:a, :b, :c)");
        $sql->execute(array(
            ':a' => $a,
            ':b' => $b,
            ':c' => $c
        ));
        if ($sql) {
            echo 'Berhasil input jam kerja!';
            
        } else {
            echo 'Failed!';
        }
    }
    //cek
//    $cek = $config->runQuery("SELECT kode_request FROM tb_kerjasama_perusahan WHERE nomor_kontrak = '". $a ."'");
//    $cek->execute();
//    $info = $cek->fetch(PDO::FETCH_LAZY);
//
//    //update
//    $sql = "UPDATE tb_temporary_perusahaan SET status = '3' WHERE  no_pendaftaran = '". $info['kode_request'] ."' ";
//    $stmt = $config->runQuery($sql);
//    $stmt->execute();
//
//    if($stmt){
//        echo 'Ok';
//    }else{
//        echo 'No';
//    }
}
// $jamKontrak = array(
//     'type_kontrak' => 'kontrak',
//     'hari_libur'   => 'su, sa',
//     'penempatan'   => '1123, 1143, 4423',
//     'jam_masuk'    => array(
//         '1123'             =>array(
//            'su'   => '08:00',
//            'mo'   => '08:00',
//            'tu'   => '08:00',
//            'we'   => '08:00',
//            'th'   => '08:00',
//            'th'   => '08:00',
//            'sa'   => '08:00'
//         ),
//         '1143'             =>array(
//            'su'   => '08:00',
//            'mo'   => '08:00',
//            'tu'   => '08:00',
//            'we'   => '08:00',
//            'th'   => '08:00',
//            'th'   => '08:00',
//            'sa'   => '08:00'
//         ),
//         '4423'             =>array(
//            'su'   => '08:00',
//            'mo'   => '08:00',
//            'tu'   => '08:00',
//            'we'   => '08:00',
//            'th'   => '08:00',
//            'th'   => '08:00',
//            'sa'   => '08:00'
//         ),
//                    ),
//     'jam_keluar'   => array(
//        '1123'             =>array(
//            'su'   => '18:00',
//            'mo'   => '18:00',
//            'tu'   => '18:00',
//            'we'   => '18:00',
//            'th'   => '18:00',
//            'th'   => '18:00',
//            'sa'   => '18:00'
//        ),
//        '1143'             =>[
//            'su'   => '18:00',
//            'mo'   => '18:00',
//            'tu'   => '18:00',
//            'we'   => '18:00',
//            'th'   => '18:00',
//            'th'   => '18:00',
//            'sa'   => '18:00'
//        ],
//        '4423'             =>array(
//            'su'   => '18:00',
//            'mo'   => '18:00',
//            'tu'   => '18:00',
//            'we'   => '18:00',
//            'th'   => '18:00',
//            'th'   => '18:00',
//            'sa'   => '18:00'
//        ),
//                    )
// );
////  echo '<pre>';
////  print_r($jamKontrak);
////  echo '</pre>';
//
//$kontrak =  json_encode($jamKontrak, true);
//$kontrak = json_decode($kontrak, TRUE);
//
////  echo '<pre>';
////  print_r($kontrak);
////  echo '</pre>';
//
//echo $kontrak->jam_masuk;
?>