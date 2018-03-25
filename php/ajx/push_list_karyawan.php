<?php
    include_once '../../config/api.php';

    $kelas = new Admin();

    $searchTerm = $_GET['term'];

    
    //get matched data from skills table
    $query ="SELECT nama_depan, nama_belakang, no_ktp FROM tb_karyawan WHERE nama_depan LIKE '%".$searchTerm."%' ORDER BY nama_depan ASC";
    $stmt = $kelas->runQuery($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
        $data[] = $row['nama_depan']. ' ' .$row['nama_belakang']. '_' .$row['no_ktp'] ;
    }
    
    //return json data
    echo json_encode($data);
?>