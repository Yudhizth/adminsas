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
elseif (@$_GET['type'] == 'addAbsen'){
    $ktp = $_POST['ktp'];
    $start = $_POST['start'];
    $break = $_POST['break'];
    $cont = $_POST['continue'];
    $finish = $_POST['finish'];
    $tgl = $_POST['tgl'];
    $ket = $_POST['ket'];

    $sql = "INSERT INTO tb_absen (no_NIP, start_at, break_at, start_again_at, finish_at, create_date, keterangan) VALUES (:nip, :a, :b, :c, :d, :e, :f)";

    $stmt = $config->runQuery($sql);
    $stmt->execute(array(
        ':nip'  => $ktp,
        ':a'    => $start,
        ':b'    => $break,
        ':c'    => $cont,
        ':d'    => $finish,
        ':e'    => $tgl,
        ':f'    => $ket
    ));

    if ($stmt){
        echo "Success!";
    }else{
        echo "Failed!";
    }
}

elseif (@$_GET['type'] == 'replayCP'){

    $a = $_POST['kupon'];
    $b = $_POST['title'];
    $c = $_POST['isi'];
    $d = $_POST['admin'];
    $e = '1';

    $sql = "SELECT * FROM tb_complain_perusahaan WHERE id_reff = :id";
    $cek = $config->runQuery($sql);
    $cek->execute(array(
        ':id'   => $a
    ));

    if($cek->rowCount() > 0){
        //case kalau sudah ada balesan dari admin
        $query = "INSERT INTO tb_complain_perusahaan (id_reff, judul, isi, admin) VALUES (:a, :b, :c, :d)";
        $stmt = $config->runQuery($query);
        $stmt->execute(array(
            ':a'    => $a,
            ':b'    => $b,
            ':c'    => $c,
            ':d'    => $d
        ));
        if ($stmt){
            echo "1";
        }else{
            echo "0";
        }
    }else{
        //case kalau belum ada balesan dari admin

        $sq = "UPDATE tb_complain_perusahaan SET status = :status WHERE kode_komplain = :kode";
        $update = $config->runQuery($sq);
        $update->execute(array(
            ':status'   => $e,
            ':kode'     => $a
        ));

        if($update){
            $query = "INSERT INTO tb_complain_perusahaan (id_reff, judul, isi, admin) VALUES (:a, :b, :c, :d)";
            $stmt = $config->runQuery($query);
            $stmt->execute(array(
                ':a'    => $a,
                ':b'    => $b,
                ':c'    => $c,
                ':d'    => $d
            ));
            if ($stmt){
                echo "1";
            }else{
                echo "0";
            }
        }else{
            echo "0";
        }
    }

}
elseif (@$_GET['type'] == 'replayKaryawan'){

    $a = $_POST['kupon'];
    $b = $_POST['title'];
    $c = $_POST['isi'];
    $d = $_POST['admin'];
    $e = '1';

    $sql = "SELECT * FROM tb_complain_karyawan WHERE id_reff = :id";
    $cek = $config->runQuery($sql);
    $cek->execute(array(
        ':id'   => $a
    ));

    if($cek->rowCount() > 0){
        //case kalau sudah ada balesan dari admin
        $query = "INSERT INTO tb_complain_karyawan (id_reff, judul, keterangan, admin) VALUES (:a, :b, :c, :d)";
        $stmt = $config->runQuery($query);
        $stmt->execute(array(
            ':a'    => $a,
            ':b'    => $b,
            ':c'    => $c,
            ':d'    => $d
        ));
        if ($stmt){
            echo "1";
        }else{
            echo "0";
        }
    }else{
        //case kalau belum ada balesan dari admin

        $sq = "UPDATE tb_complain_karyawan SET status = :status WHERE kode_komplain = :kode";
        $update = $config->runQuery($sq);
        $update->execute(array(
            ':status'   => $e,
            ':kode'     => $a
        ));

        if($update){
            $query = "INSERT INTO tb_complain_karyawan (id_reff, judul, keterangan, admin) VALUES (:a, :b, :c, :d)";
            $stmt = $config->runQuery($query);
            $stmt->execute(array(
                ':a'    => $a,
                ':b'    => $b,
                ':c'    => $c,
                ':d'    => $d
            ));
            if ($stmt){
                echo "1";
            }else{
                echo "0";
            }
        }else{
            echo "0";
        }
    }

}

elseif (@$_GET['type'] == 'replayCustomer'){

    $a = $_POST['kupon'];
    $b = $_POST['title'];
    $c = $_POST['isi'];
    $d = $_POST['admin'];

    $query = "INSERT INTO tb_complain_perusahaan (id_reff, judul, isi, admin) VALUES (:a, :b, :c, :d)";
    $stmt = $config->runQuery($query);
    $stmt->execute(array(
        ':a'    => $a,
        ':b'    => $b,
        ':c'    => $c,
        ':d'    => $d
    ));
    if ($stmt){
        echo "1";
    }else{
        echo "0";
    }

}

elseif (@$_GET['type'] == 'replayKaryawan'){

    $a = $_POST['kupon'];
    $b = $_POST['title'];
    $c = $_POST['isi'];
    $d = $_POST['admin'];

    $query = "INSERT INTO tb_complain_karyawan (id_reff, judul, keterangan, admin) VALUES (:a, :b, :c, :d)";
    $stmt = $config->runQuery($query);
    $stmt->execute(array(
        ':a'    => $a,
        ':b'    => $b,
        ':c'    => $c,
        ':d'    => $d
    ));
    if ($stmt){
        echo "1";
    }else{
        echo "0";
    }

}

elseif (@$_GET['type'] == 'actCuti'){

    $a = $_POST['idKtp'];
    $b = $_POST['admin'];
    $c = $_POST['type'];
//cek data


    if($c == '1'){
        $query = "UPDATE tb_cuti SET tb_cuti.status = :status, tb_cuti.admin = :admin WHERE tb_cuti.id = :id";
        $stmt = $config->runQuery($query);
        $stmt->execute(array(
            ':status'   => '1',
            ':admin'    => $b,
            ':id'       => $a
        ));

        if($stmt){
            echo "Cuti Berhasil di Approve!";
        }else{
            echo "Error";
        }
    }else{
        $query = "UPDATE tb_cuti SET tb_cuti.status = :status, tb_cuti.admin = :admin WHERE tb_cuti.id = :id";
        $stmt = $config->runQuery($query);
        $stmt->execute(array(
            ':status'   => '2',
            ':admin'    => $b,
            ':id'       => $a
        ));

        if($stmt){
            echo "Cuti Berhasil di Decline!";
        }else{
            echo "Error";
        }
    }



}
elseif (@$_GET['type'] == 'addPrevillage'){
    $a = $_POST['subcategory'];
    $b = $_POST['admin'];

    $sql = "INSERT INTO tb_previllage (id_subcategory, id_admin) VALUES (:a, :b)";

    $stmt = $config->runQuery($sql);
    $stmt->execute(array(
        ':a'    => $a,
        ':b'    => $b
    ));

    if ($stmt){
        echo "Success!";
    }else{
        echo "Failed!";
    }
}

elseif (@$_GET['type'] == 'addJabatan'){
    $a = $_POST['kode'];
    $b = $_POST['ktp'];
    $c = $_POST['jabatan'];

    $sql = "UPDATE tb_list_karyawan SET kode_jabatan = :a WHERE id = :b";

    $stmt = $config->runQuery($sql);
    $stmt->execute(array(
        ':a'    => $c,
        ':b'    => $b
    ));

    if ($stmt){
        echo "Success Tambah Jabatan!";
    }else{
        echo "Gagal Tambah Jabatan!";
    }
}






















