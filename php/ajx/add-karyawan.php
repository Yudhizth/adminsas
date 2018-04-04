<?php

$id = $_GET['id'];
$kode = $_GET['kode'];
$total = $_GET['jml'];

include_once '../../config/api.php';
$config = new Admin();

$data = $config->runQuery("SELECT * FROM tb_kerjasama_perusahan WHERE nomor_kontrak = :nomor");
$data->execute(array(
    ':nomor' => $kode
));

$row = $data->fetch(PDO::FETCH_LAZY);
$nomor_pendaftaran = $row['kode_perusahaan'];

    if (empty($id)){
        echo "<script>
            alert('Nomor NIP belum ada!');
            window.location.href='../../index.php?p=select-karyawan&id=".$kode."';
            </script>";
    }else{

            $sql = "INSERT INTO tb_list_karyawan (kode_list_karyawan, no_nip) VALUES (:kode, :id)";
            $stmt = $config->runQuery($sql);

            $stmt->execute(array(
                ':kode'		=> $kode,
                ':id'   => $id));

            if (!$stmt) {
                # code...
                echo "gagal";
            } else {
                $id_reff = $config->lastInsertID();

                $log = "INSERT INTO tb_log_event (id_reff, types, tables, ket, admin_id) VALUES (:a, :b, :c, :d, :e)";
                $log = $config->runQuery($log);
                $log->execute(array(
                    ':a'    => $id,
                    ':b'    => '2',
                    ':c'    => 'tb_loker',
                    ':d'    => 'update data loker',
                    ':e'    =>  $admin_id
                ));

                $query = "UPDATE tb_karyawan SET status = '1' WHERE no_ktp = :data";
                $stmt = $config->runQuery($query);
                $stmt->execute(array(
                    ':data' => $id));

                //cek ke tb_job jika total karyawan terpenuhi
                $cek = "SELECT kode_list_karyawan FROM tb_list_karyawan WHERE kode_list_karyawan = :kode";
                $dt = $config->runQuery($cek);
                $dt->execute(array(
                    ':kode' =>$kode
                ));
                if ($dt->rowCount() == $total){
                    $in = "UPDATE tb_temporary_perusahaan SET status = '4' WHERE no_pendaftaran = :pendaftaran";
                    $input = $config->runQuery($in);
                    $input->execute(array(
                        ':pendaftaran' => $nomor_pendaftaran
                    ));
                    echo "<script>
                        alert('Karyawan Berhasil ditambahkan!');
                        window.location.href='../../index.php?p=select-karyawan&id=".$kode."';
                    </script>";
                }else{
                    echo "<script>
                        alert('Karyawan Berhasil ditambahkan!');
                        window.location.href='../../index.php?p=select-karyawan&id=".$kode."';
                    </script>";
                }
            }
        }
?>

