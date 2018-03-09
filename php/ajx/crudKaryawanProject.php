<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 31/01/2018
 * Time: 15.20
 */

require '../../config/api.php';
$admin = new Admin();

if(@$_GET['type'] == 'generate'){

    $kode = $_POST['kodeGenerate'];
    $spk = $_POST['spk'];
    $sql = "UPDATE tb_kerjasama_perusahan SET kode_list_karyawan = :kode WHERE nomor_kontrak = :nomor ";
    $stmt = $admin->runQuery($sql);
    $stmt->execute(array(
        ":kode" => $kode,
        ":nomor" => $spk
    ));

    if ($stmt){
        echo "Generate Kode Berhasil!";
    }else{
        echo "Generate tidak Berhasil.";
    }
}

elseif(@$_GET['type'] == 'addKaryawan'){

    $kdList = $_POST['spk'];
    $ktp = $_POST['ktp'];
    $status = '1';
    $karyawanStatus="KDKRY0002";

    $sql = "INSERT INTO tb_list_karyawan (kode_list_karyawan, no_nip, status_karyawan) VALUES (:kode, :id, :status)";
    $stmt = $admin->runQuery($sql);
    $stmt->execute(array(
        ':kode' => $kdList,
        ':id'   => $ktp,
        ':status' => $status
    ));


        if($stmt){
            echo "Karyawan Berhasil Ditambahkan.";
            $query = "UPDATE tb_karyawan SET kd_status_karyawan = :status WHERE no_ktp = :data";

            $update = $admin->runQuery($query);
            $update->execute(array(
                ':status'   => $karyawanStatus,
                ':data'     => $ktp
            ));

        }else{
            echo "Gagal ditambahkan";
        }

//    statuskaryawan = suggest_karyawan : 1
}
elseif(@$_GET['type'] == 'addKaryawanMPO'){

    $kdList = $_POST['spk'];
    $ktp = $_POST['ktp'];
    $posisi = $_POST['posisi'];
    $status = '1';
    $karyawanStatus="KDKRY0002";

    $sql = "INSERT INTO tb_list_karyawan (kode_list_karyawan, no_nip, kode_pekerjaan, status_karyawan) VALUES (:kode, :id, :pekerjaan, :status)";
    $stmt = $admin->runQuery($sql);
    $stmt->execute(array(
        ':kode' => $kdList,
        ':id'   => $ktp,
        ':pekerjaan' => $posisi,
        ':status' => $status
    ));


    if($stmt){
        echo "Karyawan Berhasil Ditambahkan.";
        $query = "UPDATE tb_karyawan SET kd_status_karyawan = :status WHERE no_ktp = :data";

        $update = $admin->runQuery($query);
        $update->execute(array(
            ':status'   => $karyawanStatus,
            ':data'     => $ktp
        ));

    }else{
        echo "Gagal ditambahkan";
    }

//    statuskaryawan = suggest_karyawan : 1
}
elseif (@$_GET['type'] == 'removeKaryawan'){
    $kode = $_POST['kode'];
    $ktp = $_POST['ktp'];
    $karyawanStatus = "KDKRY0008";

    $sql = "DELETE FROM tb_list_karyawan WHERE no_nip=:id AND kode_list_karyawan=:kode";
    $stmt = $admin->runQuery($sql);
    $stmt->execute(array(
        ':id'	=>$ktp,
        ':kode' =>$kode
    ));
    if (!$stmt) {
        # code...
        echo "Data Tidak berhasil di hapus.";
    }else{
        echo "Karyawan Berhasil di Hapus!";

        $query = "UPDATE tb_karyawan SET kd_status_karyawan = :status WHERE no_ktp = :data";

        $update = $admin->runQuery($query);
        $update->execute(array(
            ':status'   => $karyawanStatus,
            ':data'     => $ktp
        ));


        //insert into tb_temp_remove karyawan
        $sql = "INSERT INTO tb_temp_remove_karyawan (kode_list_karyawan, no_ktp) VALUES (:kode, :ktp)";

        $insert = $admin->runQuery($sql);
        $insert->execute(array(
            ':kode'   => $kode,
            ':ktp'     => $ktp
        ));
    }
}
elseif (@$_GET['type'] == 'finishAdd'){

    $kode = $_POST['kode'];

    //cek data jika kurang/lebih karyawan

    $cek = "SELECT tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.kode_perusahaan, tb_kerjasama_perusahan.kode_request, tb_kerjasama_perusahan.kode_list_karyawan, tb_kerjasama_perusahan.total_karyawan
            FROM tb_kerjasama_perusahan WHERE tb_kerjasama_perusahan.nomor_kontrak = :spk";
    $cekdata = $admin->runQuery($cek);
    $cekdata->execute(array(
        ':spk'  => $kode
    ));

    $data = $cekdata->fetch(PDO::FETCH_LAZY);

    $nomorReq = $data['kode_request'];

    $totalKaryawan = $data['total_karyawan'];
        $sql = "SELECT id FROM tb_list_karyawan WHERE kode_list_karyawan = :kode";
        $stmt = $admin->runQuery($sql);
        $stmt->execute(array(
            ':kode' => $data['kode_list_karyawan']
        ));

        $totalList = $stmt->rowCount();

        $row = $stmt->fetch(PDO::FETCH_LAZY);

    if($totalList > $totalKaryawan OR $totalList < $totalKaryawan ){
        echo "0";
    }else{
        $ubah = "UPDATE tb_temporary_perusahaan SET status = :a WHERE no_pendaftaran = :req";
        $change = $admin->runQuery($ubah);
        $change->execute(array(
            ':a' => '4',
            ':req' => $nomorReq
        ));
        echo "1";
    }



}
elseif(@$_GET['type'] == 'addRating'){
    $id = $_POST['id'];
    $star = $_POST['star'];
    $spv = $_POST['admin'];

    $sql = "UPDATE tb_report_job SET rating = :rating, spv_id = :admin WHERE id = :id";
    $stmt = $admin->runQuery($sql);
    $stmt->execute(array(
        ':rating' => $star,
        ':admin'  => $spv,
        ':id'     => $id
    ));

    if($stmt){
        echo "Jobs Telah di update";
    }else{
        echo "Gagal!";
    }
}
elseif(@$_GET['type'] == 'changeStatus'){
    $ktp = $_POST['ktp'];
    $status = $_POST['st'];

    $query = "UPDATE tb_list_karyawan SET status_karyawan = :status WHERE no_nip = :data";

    $update = $admin->runQuery($query);
    $update->execute(array(
        ':status'   => $status,
        ':data'     => $ktp
    ));

    if($update){

        if($status == '2'){
            $kd = "KDKRY0011"; //approve to project
            $sql = "UPDATE tb_karyawan SET kd_status_karyawan = :status WHERE no_ktp = :st";
            $stmt = $admin->runQuery($sql);
            $stmt->execute(array(
                ':status' => $kd,
                ':st'     => $ktp
            ));
            if($stmt){
                echo "Success";
            }else{
                echo "Gagal";
            }
        }elseif( $status == '3'){
            $kd = "KDKRY0012"; //decline to project
            $sql = "UPDATE tb_karyawan SET kd_status_karyawan = :status WHERE no_ktp = :st";
            $stmt = $admin->runQuery($sql);
            $stmt->execute(array(
                ':status' => $kd,
                ':st'     => $ktp
            ));
            if($stmt){
                echo "Success";
            }else{
                echo "Gagal";
            }
        }else{

            $kd = "KDKRY0002"; //assign to project
            $sql = "UPDATE tb_karyawan SET kd_status_karyawan = :status WHERE no_ktp = :st";
            $stmt = $admin->runQuery($sql);
            $stmt->execute(array(
                ':status' => $kd,
                ':st'     => $ktp
            ));
            if($stmt){
                echo "Success";
            }else{
                echo "Gagal";
            }

        }


    }else{
        echo "Failed";
    }


}
else{
    echo "none";
}