<?php
require '../../config/api.php';
$admin = new Admin();

if(@$_GET['type'] == 'addJudul'){
    $spk = $_POST['spk'];
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $type = $_POST['type'];
    

    $sql = "INSERT INTO tb_job (nomor_kontrak, kode_detail_job, title, type) VALUES (:spk, :id, :title, :type)";

    $stmt = $admin->runQuery($sql);
    $stmt->execute(array(
        ':spk'  => $spk,
        ':id'   => $id,
        ':title'=> $judul,
        ':type' => $type
    ));
    if(!$stmt){
        echo "Gagal di simpan.";
    }else{
        echo "Berhasil di simpan.";
    }


}

if(@$_GET['type'] == 'addDetail'){
    $kodeDetail = $_POST['kode'];
    $kodeAdmin = $_POST['admin'];
    $judulDetail = $_POST['kegiatan'];
    $deskripsi = $_POST['deskripsi'];
    $keterangan = $_POST['keterangan'];

    $sql = "INSERT INTO tb_list_job (kode_detail_job, nama_job, deskripsi_job, keterangan, kode_admin) VALUES (:kode, :nama, :deskripsi, :keterangan, :admin)";

    $stmt = $admin->runQuery($sql);
    $stmt->execute(array(
        ':kode'     => $kodeDetail,
        ':nama'     => $judulDetail,
        ':deskripsi'=> $deskripsi,
        ':keterangan' => $keterangan,
        ':admin'    => $kodeAdmin
    ));

    if(!$stmt){
        echo "Detail gagal di simpan.";
    }else{
        echo "Detail berhasil di simpan.";
    }
}

if(@$_GET['type'] == 'deleteDetail'){
    $id = $_POST['id'];

    $sql = 'DELETE FROM tb_list_job WHERE id = :id';
    $stmt = $admin->runQuery($sql);
    $stmt->execute(array(':id' => $id));

    if(!$stmt){
        echo"Gagal Hapus Kegiatan.";
    }else{
        echo"Kegiatan di Hapus.";
    }
}

if(@$_GET['type'] == 'deleteTitle'){
    $id = $_POST['id'];

    $cek = 'SELECT * FROM tb_job WHERE id = :id';
    $stmt = $admin->runQuery($cek);
    $stmt->execute(array(':id' => $id));

    if(!$stmt){
        echo "Gagal Menampilkan data.";
    }else{
        $data = $stmt->fetch(PDO::FETCH_LAZY);

        $detailJob = $data['kode_detail_job'];

        $sql = 'DELETE FROM tb_job WHERE id = :id';
        $stmt1 = $admin->runQuery($sql);
        $stmt1->execute(array(':id' => $id));

        if(!$stmt1){
            echo"Gagal Hapus Title.";
        }else{
            $sql = 'DELETE FROM tb_list_job WHERE kode_detail_job = :id';
            $stmt2 = $admin->runQuery($sql);
            $stmt2->execute(array(':id' => $detailJob));

            if(!$stmt2){
                echo"Gagal Hapus Kegiatan.";
            }else{
                echo"Data Berhasil Dihapus.";
            }
        }

    }

}
elseif (@$_GET['type'] == 'finishJobs'){

    $kode = $_POST['id'];

    //cek data jika kurang/lebih karyawan

    $cek = "SELECT tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.kode_perusahaan, tb_kerjasama_perusahan.kode_request, tb_kerjasama_perusahan.kode_list_karyawan, tb_kerjasama_perusahan.total_karyawan
            FROM tb_kerjasama_perusahan WHERE tb_kerjasama_perusahan.nomor_kontrak = :spk";
    $cekdata = $admin->runQuery($cek);
    $cekdata->execute(array(
        ':spk'  => $kode
    ));

    $data = $cekdata->fetch(PDO::FETCH_LAZY);

    $nomorReq = $data['kode_request'];

    $ubah = "UPDATE tb_temporary_perusahaan SET status = :a WHERE no_pendaftaran = :req";
    $change = $admin->runQuery($ubah);
    $change->execute(array(
        ':a' => '5',
        ':req' => $nomorReq
    ));

    if($change){
        echo "berhasil";
    }else{
        echo "gagal";
    }


}
