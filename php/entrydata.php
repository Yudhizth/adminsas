<?php
include_once '../config/api.php';
$cek = new Admin();
    date_default_timezone_set('Asia/Jakarta');

    if(isset($_POST['addData'])){
        $no_kontrak = $_POST['txt_kontrak'];
        $jmlh = $_POST['txt_total'];
        $kd_perusahaan = $_POST['txt_kode'];
        $kodeMPO = $_POST['txt_pekerjaan'];
        $deskripsi = $_POST['txt_deskripsi'];
        $tugas = $_POST['txt_tugas'];
        $tanggung = $_POST['txt_tanggung'];
        $penempatan = $_POST['txt_penempatan'];
        $total = $_POST['txt_nilai'];
        $req = $_POST['txt_req'];
        $admin = $_POST['txt_admin'];
        $start = $_POST['txt_start'];
        $ends = $_POST['txt_ends'];
        $time_select = $_POST['typeTime'];
        $sun1 = $_POST['txt_minggu_start'];
        $sun2 = $_POST['txt_minggu_end'];
        $mon1 = $_POST['txt_senin_start'];
        $mon2 = $_POST['txt_senin_end'];
        $tue1 = $_POST['txt_selasa_start'];
        $tue2 = $_POST['txt_selasa_end'];
        $wen1 = $_POST['txt_rabu_start'];
        $wen2 = $_POST['txt_rabu_end'];
        $thu1 = $_POST['txt_kamis_start'];
        $thu2 = $_POST['txt_kamis_end'];
        $fri1 = $_POST['txt_jumat_start'];
        $fri2 = $_POST['txt_jumat_end'];
        $sat1 = $_POST['txt_sabtu_start'];
        $sat2 = $_POST['txt_sabtu_end'];
        $minggu = $_POST['txt_minggu'];
        $senin = $_POST['txt_senin'];
        $selasa = $_POST['txt_selasa'];
        $rabu = $_POST['txt_rabu'];
        $kamis = $_POST['txt_kamis'];
        $jumat = $_POST['txt_jumat'];
        $sabtu = $_POST['txt_sabtu'];
        $sun = $sun1 . "/" . $sun2;
        $mon = $mon1 . "/" . $mon2;
        $tue = $tue1 . "/" . $tue2;
        $wen = $wen1 . "/" . $wen2;
        $thu = $thu1 . "/" . $thu2;
        $fri = $fri1 . "/" . $fri2;
        $sat = $sat1 . "/" . $sat2;

         $o = array($no_kontrak, $kd_perusahaan, $req, $kodeMPO, $jmlh, $deskripsi, $tugas, $tanggung, $penempatan, $total, $admin, $time_select);
         $days = array($minggu, $senin, $selasa, $rabu, $kamis, $jumat, $sabtu);

         $day = array($sun1, $sun2, $mon1, $mon2, $tue1, $tue2, $wen1, $wen2, $thu1, $thu2, $fri1, $fri2, $sat1, $sat2);
//         echo "<pre>";
//          print_r($o);
//         print_r($days);
//         print_r($day);
//         echo "</pre>";

        if ($time_select == "1") {
            # code...
            $query = "INSERT INTO tb_time_fix (nomor_spk, minggu, senin, selasa, rabu, kamis, jumat, sabtu) VALUES (:nomor, :minggu, :senin, :selasa, :rabu, :kamis, :jumat, :sabtu)";
            $fix = $cek->runQuery($query);
            $fix->execute(array(
                ':nomor' => $no_kontrak,
                ':minggu'=> $sun,
                ':senin' => $mon,
                ':selasa'=> $tue,
                ':rabu'  => $wen,
                ':kamis' => $thu,
                ':jumat' => $fri,
                ':sabtu' => $sat
            ));
        }elseif ($time_select == "2") {
            $query = "INSERT INTO tb_time_fleksible (nomor_spk, minggu, senin, selasa, rabu, kamis, jumat, sabtu) VALUES (:nomor, :minggu, :senin, :selasa, :rabu, :kamis, :jumat, :sabtu)";
            $flex = $cek->runQuery($query);
            $flex->execute(array(
                ':nomor' => $no_kontrak,
                ':minggu' => $minggu,
                ':senin' => $senin,
                ':selasa' => $selasa,
                ':rabu' => $rabu,
                ':kamis' => $kamis,
                ':jumat' => $jumat,
                ':sabtu' => $sabtu
            ));
        }else{}

        $query = "INSERT INTO tb_kerjasama_perusahan (nomor_kontrak, kode_perusahaan, kode_request, kode_plan, total_karyawan, deskripsi, tugas, tanggung_jwb, penempatan, kontrak_start, kontrak_end, nilai_kontrak, kode_admin) VALUES (:kontrak, :kode, :plan, :req, :total, :deskripsi, :tgs, :tgjwb, :tmpt, :start, :ends, :nilai, :admin)";

        $stmt = $cek->runQuery($query);
        $stmt->execute(array(
          ':kontrak'  =>$no_kontrak,
          ':kode'     =>$kd_perusahaan,
          ':plan'     =>$req,
          ':req'      =>$kodeMPO,
          ':total'    =>$jmlh,
          ':deskripsi'=>$deskripsi,
          ':tgs'      =>$tugas,
          ':tgjwb'    =>$tanggung,
          ':tmpt'     =>$penempatan,
          ':start'    =>$start,
          ':ends'     =>$ends,
          ':nilai'    =>$total,
          ':admin'    =>$admin));
        if (!$stmt) {
          # code...
          echo "data tidak masuk";
        } else{
            //bahwa nama perusahaan dengan request tersebut telah melalui tahap "entry detail Project"
          $sql = "UPDATE tb_temporary_perusahaan SET status = '3' WHERE tb_temporary_perusahaan.no_pendaftaran = :id";
          $stmt = $cek->runQuery($sql);
            $stmt->execute(array(
                ':id'   =>$req));
                if (!$stmt) {
                  # code...
                  echo "data tidak update di tb_temporary_perusahaan";
                }else{
                    echo "<script>
                          alert('DATA Berhasil di Input!');
                          window.location.href='../index.php?p=entry-data';
                          </script>";
                }
        }
    }
//    $kd = $_GET['name'];
//    $kd = explode('/', $kd);
//
//    $type = $kd[0];
//    $noReg = $kd[0];
//
//    $cek = new Admin();
//
//    $id = "nomor_kontrak";
//    $kode = "SPK-";
//    $tbName = "tb_kerjasama_perusahan";
//
//    $nomor = $cek->Generate($id, $kode, $tbName);
//
//    if ($type == 'MPO01') #MPO
//    {
//      # code...
//      $sql = "SELECT * FROM tb_temporary_perusahaan WHERE tb_temporary_perusahaan.no_pendaftaran = :id";
//      $stmt = $cek->runQuery($sql);
//      $stmt->execute(array(
//          ':id'   =>$noReg));
//
//      $row = $stmt->fetch(PDO::FETCH_LAZY);
//
//      $n = array($row);
//      // echo "<pre>";
//      // print_r($n);
//      // echo "</pre>";
//      include 'inputMPO.php';
//    }
//    elseif ($type == 'BPO01') #BPO
//    {
//      # code...
//      $sql = "SELECT * FROM tb_temporary_perusahaan WHERE tb_temporary_perusahaan.no_pendaftaran = :id";
//      $stmt = $cek->runQuery($sql);
//      $stmt->execute(array(
//          ':id'   =>$noReg));
//
//      $row = $stmt->fetch(PDO::FETCH_LAZY);
//
//      $n = array($row);
//      // echo "<pre>";
//      // print_r($n);
//      // echo "</pre>";
//      include 'inputBPO.php';
//
//    }
//    else  #system integrator, konsultan
//    {
//      # code...
//      $sql = "SELECT * FROM tb_temporary_perusahaan WHERE tb_temporary_perusahaan.no_pendaftaran = :id";
//      $stmt = $cek->runQuery($sql);
//      $stmt->execute(array(
//          ':id'   =>$noReg));
//
//      $row = $stmt->fetch(PDO::FETCH_LAZY);
//
//      $n = array($row);
//      // echo "<pre>";
//      // print_r($n);
//      // echo "</pre>";
//      include 'inputDefault.php';
//    }

//    if (isset($_POST['addDataMPO'])) { #for case MPO
//      #for case MPO
//      $no_kontrak = $_POST['txt_kontrak'];
//      $plan = $_POST['txt_plan'];
//      $jmlh = $_POST['txt_total'];
//      $kd_perusahaan = $_POST['txt_kode'];
//      $deskripsi = $_POST['txt_deskripsi'];
//      $tugas = $_POST['txt_tugas'];
//      $tanggung = $_POST['txt_tanggung'];
//      $penempatan = $_POST['txt_penempatan'];
//      $total = $_POST['txt_nilai'];
//      $req = $_POST['txt_req'];
//      $admin = $_POST['txt_admin'];
//      $start = $_POST['txt_start'];
//      $ends = $_POST['txt_ends'];
//      $time_select = $_POST['txt_inisialisasi'];
//      $sun1 = $_POST['txt_minggu_start'];
//      $sun2 = $_POST['txt_minggu_end'];
//      $mon1 = $_POST['txt_senin_start'];
//      $mon2 = $_POST['txt_senin_end'];
//      $tue1 = $_POST['txt_selasa_start'];
//      $tue2 = $_POST['txt_selasa_end'];
//      $wen1 = $_POST['txt_rabu_start'];
//      $wen2 = $_POST['txt_rabu_end'];
//      $thu1 = $_POST['txt_kamis_start'];
//      $thu2 = $_POST['txt_kamis_end'];
//      $fri1 = $_POST['txt_jumat_start'];
//      $fri2 = $_POST['txt_jumat_end'];
//      $sat1 = $_POST['txt_sabtu_start'];
//      $sat2 = $_POST['txt_sabtu_end'];
//      $minggu = $_POST['txt_minggu'];
//      $senin = $_POST['txt_senin'];
//      $selasa = $_POST['txt_selasa'];
//      $rabu = $_POST['txt_rabu'];
//      $kamis = $_POST['txt_kamis'];
//      $jumat = $_POST['txt_jumat'];
//      $sabtu = $_POST['txt_sabtu'];
//      $sun = $sun1 . "/" . $sun2;
//      $mon = $mon1 . "/" . $mon2;
//      $tue = $tue1 . "/" . $tue2;
//      $wen = $wen1 . "/" . $wen2;
//      $thu = $thu1 . "/" . $thu2;
//      $fri = $fri1 . "/" . $fri2;
//      $sat = $sat1 . "/" . $sat2;
      // $o = array($no_kontrak, $kd_perusahaan, $req, $plan, $jmlh, $deskripsi, $tugas, $tanggung, $penempatan, $total, $admin);
      // $days = array($minggu, $senin, $selasa, $rabu, $kamis, $jumat, $sabtu);
      //
      // $day = array($sun1, $sun2, $mon1, $mon2, $tue1, $tue2, $wen1, $wen2, $thu1, $thu2, $fri1, $fri2, $sat1, $sat2);
      // echo "<pre>";
      //  print_r($o);
      // print_r($days);
      // print_r($day);
      // echo "</pre>";
      //
//      if ($time_select == "1") {
//        # code...
//        $query = "INSERT INTO tb_time_fix (nomor_spk, minggu, senin, selasa, rabu, kamis, jumat, sabtu) VALUES (:nomor, :minggu, :senin, :selasa, :rabu, :kamis, :jumat, :sabtu)";
//        $stmt = $cek->runQuery($query);
//        $stmt->execute(array(
//          ':nomor' => $no_kontrak,
//          ':minggu'=> $sun,
//          ':senin' => $mon,
//          ':selasa'=> $tue,
//          ':rabu'  => $wen,
//          ':kamis' => $thu,
//          ':jumat' => $fri,
//          ':sabtu' => $sat
//        ));
//      }elseif ($time_select == "2"){
//        $query = "INSERT INTO tb_time_fleksible (nomor_spk, minggu, senin, selasa, rabu, kamis, jumat, sabtu) VALUES (:nomor, :minggu, :senin, :selasa, :rabu, :kamis, :jumat, :sabtu)";
//        $stmt = $cek->runQuery($query);
//        $stmt->execute(array(
//          ':nomor' => $no_kontrak,
//          ':minggu'=> $minggu,
//          ':senin' => $senin,
//          ':selasa'=> $selasa,
//          ':rabu'  => $rabu,
//          ':kamis' => $kamis,
//          ':jumat' => $jumat,
//          ':sabtu' => $sabtu
//        ));
//      }else{
//        echo "you should better select one of them.";
//      }
//
//      if (!empty($time_select)) {
//        # code...
//        $query = "INSERT INTO tb_kerjasama_perusahan (nomor_kontrak, kode_perusahaan, kode_plan, deskripsi, tugas, tanggung_jwb, penempatan, kontrak_start, kontrak_end, nilai_kontrak, kode_admin) VALUES (:kontrak, :kode, :plan, :deskripsi, :tgs, :tgjwb, :tmpt, :start, :ends, :nilai, :admin)";
//
//        $stmt = $cek->runQuery($query);
//        $stmt->execute(array(
//          ':kontrak'  =>$no_kontrak,
//          ':kode'     =>$kd_perusahaan,
//          ':plan'     =>$plan,
//          ':deskripsi'=>$deskripsi,
//          ':tgs'      =>$tugas,
//          ':tgjwb'    =>$tanggung,
//          ':tmpt'     =>$penempatan,
//          ':start'    =>$start,
//          ':ends'     =>$ends,
//          ':nilai'    =>$total,
//          ':admin'    =>$admin));
//        if (!$stmt) {
//          # code...
//          echo "data tidak masuk";
//        } else{
//            //bahwa nama perusahaan dengan request tersebut telah melalui tahap "entry detail Project"
//          $sql = "UPDATE tb_temporary_perusahaan SET status = '3' WHERE tb_temporary_perusahaan.no_pendaftaran = :id";
//          $stmt = $cek->runQuery($sql);
//            $stmt->execute(array(
//                ':id'   =>$noReg));
//                if (!$stmt) {
//                  # code...
//                  echo "data tidak update di tb_temporary_perusahaan";
//                }else{
//                  echo "<script>
//                          alert('DATA Berhasil di Input!');
//                          window.location.href='index.php?p=entry-data';
//                          </script>";
//                }
//        }
//      }
//
//    }elseif (isset($_POST['addDataBPO'])) { #for case BPO
//      # code...
//      $no_kontrak = $_POST['txt_kontrak'];
//      $plan = $_POST['txt_plan'];
//      $jmlh = $_POST['txt_total'];
//      $kd_perusahaan = $_POST['txt_kode'];
//      $deskripsi = $_POST['txt_deskripsi'];
//      $tugas = $_POST['txt_tugas'];
//      $tanggung = $_POST['txt_tanggung'];
//      $penempatan = $_POST['txt_penempatan'];
//      $total = $_POST['txt_nilai'];
//      $req = $_POST['txt_req'];
//      $admin = $_POST['txt_admin'];
//      $start = $_POST['txt_start'];
//      $ends = $_POST['txt_ends'];
//      $time_select = $_POST['txt_inisialisasi'];
//      $sun1 = $_POST['txt_minggu_start'];
//      $sun2 = $_POST['txt_minggu_end'];
//      $mon1 = $_POST['txt_senin_start'];
//      $mon2 = $_POST['txt_senin_end'];
//      $tue1 = $_POST['txt_selasa_start'];
//      $tue2 = $_POST['txt_selasa_end'];
//      $wen1 = $_POST['txt_rabu_start'];
//      $wen2 = $_POST['txt_rabu_end'];
//      $thu1 = $_POST['txt_kamis_start'];
//      $thu2 = $_POST['txt_kamis_end'];
//      $fri1 = $_POST['txt_jumat_start'];
//      $fri2 = $_POST['txt_jumat_end'];
//      $sat1 = $_POST['txt_sabtu_start'];
//      $sat2 = $_POST['txt_sabtu_end'];
//      $minggu = $_POST['txt_minggu'];
//      $senin = $_POST['txt_senin'];
//      $selasa = $_POST['txt_selasa'];
//      $rabu = $_POST['txt_rabu'];
//      $kamis = $_POST['txt_kamis'];
//      $jumat = $_POST['txt_jumat'];
//      $sabtu = $_POST['txt_sabtu'];
//      $sun = $sun1 . "/" . $sun2;
//      $mon = $mon1 . "/" . $mon2;
//      $tue = $tue1 . "/" . $tue2;
//      $wen = $wen1 . "/" . $wen2;
//      $thu = $thu1 . "/" . $thu2;
//      $fri = $fri1 . "/" . $fri2;
//      $sat = $sat1 . "/" . $sat2;
//      // $o = array($no_kontrak, $kd_perusahaan, $req, $plan, $jmlh, $deskripsi, $tugas, $tanggung, $penempatan, $total, $admin);
//      // $days = array($minggu, $senin, $selasa, $rabu, $kamis, $jumat, $sabtu);
//      //
//      // $day = array($sun1, $sun2, $mon1, $mon2, $tue1, $tue2, $wen1, $wen2, $thu1, $thu2, $fri1, $fri2, $sat1, $sat2);
//      // echo "<pre>";
//      //  print_r($o);
//      // print_r($days);
//      // print_r($day);
//      // echo "</pre>";
//      //
//      if ($time_select == "1") {
//        # code...
//        $query = "INSERT INTO tb_time_fix (nomor_spk, minggu, senin, selasa, rabu, kamis, jumat, sabtu) VALUES (:nomor, :minggu, :senin, :selasa, :rabu, :kamis, :jumat, :sabtu)";
//        $stmt = $cek->runQuery($query);
//        $stmt->execute(array(
//          ':nomor' => $no_kontrak,
//          ':minggu'=> $sun,
//          ':senin' => $mon,
//          ':selasa'=> $tue,
//          ':rabu'  => $wen,
//          ':kamis' => $thu,
//          ':jumat' => $fri,
//          ':sabtu' => $sat
//        ));
//      }elseif ($time_select == "2"){
//        $query = "INSERT INTO tb_time_fleksible (nomor_spk, minggu, senin, selasa, rabu, kamis, jumat, sabtu) VALUES (:nomor, :minggu, :senin, :selasa, :rabu, :kamis, :jumat, :sabtu)";
//        $stmt = $cek->runQuery($query);
//        $stmt->execute(array(
//          ':nomor' => $no_kontrak,
//          ':minggu'=> $minggu,
//          ':senin' => $senin,
//          ':selasa'=> $selasa,
//          ':rabu'  => $rabu,
//          ':kamis' => $kamis,
//          ':jumat' => $jumat,
//          ':sabtu' => $sabtu
//        ));
//      }else{
//        echo "you should better select one of them.";
//      }
//
//      if (!empty($time_select)) {
//        # code...
//        $query = "INSERT INTO tb_kerjasama_perusahan (nomor_kontrak, kode_perusahaan, kode_plan, total_karyawan, deskripsi, tugas, tanggung_jwb, penempatan, kontrak_start, kontrak_end, nilai_kontrak, kode_admin) VALUES (:kontrak, :kode, :plan, :jmlh, :deskripsi, :tgs, :tgjwb, :tmpt, :start, :ends, :nilai, :admin)";
//
//        $stmt = $cek->runQuery($query);
//        $stmt->execute(array(
//          ':kontrak'  =>$no_kontrak,
//          ':kode'     =>$kd_perusahaan,
//          ':plan'     =>$plan,
//          ':jmlh'     =>$jmlh,
//          ':deskripsi'=>$deskripsi,
//          ':tgs'      =>$tugas,
//          ':tgjwb'    =>$tanggung,
//          ':tmpt'     =>$penempatan,
//          ':start'    =>$start,
//          ':ends'     =>$ends,
//          ':nilai'    =>$total,
//          ':admin'    =>$admin));
//        if (!$stmt) {
//          # code...
//          echo "data tidak masuk";
//        } else{
//            //bahwa nama perusahaan dengan request tersebut telah melalui tahap "entry detail Project"
//          $sql = "UPDATE tb_temporary_perusahaan SET status = '3' WHERE tb_temporary_perusahaan.no_pendaftaran = :id";
//          $stmt = $cek->runQuery($sql);
//            $stmt->execute(array(
//                ':id'   =>$noReg));
//                if (!$stmt) {
//                  # code...
//                  echo "data tidak update di tb_temporary_perusahaan";
//                }else{
//
//                  echo "<script>
//                          alert('DATA Berhasil di Input!');
//                          window.location.href='index.php?p=entry-data';
//                          </script>";
//
//
//                }
//        }
//      }
//    } elseif (isset($_POST['addDataDefault'])) { #for case Default
//      # code...
//      $no_kontrak = $_POST['txt_kontrak'];
//      $plan = $_POST['txt_plan'];
//      $jmlh = $_POST['txt_total'];
//      $kd_perusahaan = $_POST['txt_kode'];
//      $deskripsi = $_POST['txt_deskripsi'];
//      $tugas = $_POST['txt_tugas'];
//      $tanggung = $_POST['txt_tanggung'];
//      $penempatan = $_POST['txt_penempatan'];
//      $total = $_POST['txt_nilai'];
//      $req = $_POST['txt_req'];
//      $admin = $_POST['txt_admin'];
//      $start = $_POST['txt_start'];
//      $ends = $_POST['txt_ends'];
//      $time_select = $_POST['txt_inisialisasi'];
//      $sun1 = $_POST['txt_minggu_start'];
//      $sun2 = $_POST['txt_minggu_end'];
//      $mon1 = $_POST['txt_senin_start'];
//      $mon2 = $_POST['txt_senin_end'];
//      $tue1 = $_POST['txt_selasa_start'];
//      $tue2 = $_POST['txt_selasa_end'];
//      $wen1 = $_POST['txt_rabu_start'];
//      $wen2 = $_POST['txt_rabu_end'];
//      $thu1 = $_POST['txt_kamis_start'];
//      $thu2 = $_POST['txt_kamis_end'];
//      $fri1 = $_POST['txt_jumat_start'];
//      $fri2 = $_POST['txt_jumat_end'];
//      $sat1 = $_POST['txt_sabtu_start'];
//      $sat2 = $_POST['txt_sabtu_end'];
//      $minggu = $_POST['txt_minggu'];
//      $senin = $_POST['txt_senin'];
//      $selasa = $_POST['txt_selasa'];
//      $rabu = $_POST['txt_rabu'];
//      $kamis = $_POST['txt_kamis'];
//      $jumat = $_POST['txt_jumat'];
//      $sabtu = $_POST['txt_sabtu'];
//      $sun = $sun1 . "/" . $sun2;
//      $mon = $mon1 . "/" . $mon2;
//      $tue = $tue1 . "/" . $tue2;
//      $wen = $wen1 . "/" . $wen2;
//      $thu = $thu1 . "/" . $thu2;
//      $fri = $fri1 . "/" . $fri2;
//      $sat = $sat1 . "/" . $sat2;
//      // $o = array($no_kontrak, $kd_perusahaan, $req, $plan, $jmlh, $deskripsi, $tugas, $tanggung, $penempatan, $total, $admin);
//      // $days = array($minggu, $senin, $selasa, $rabu, $kamis, $jumat, $sabtu);
//      //
//      // $day = array($sun1, $sun2, $mon1, $mon2, $tue1, $tue2, $wen1, $wen2, $thu1, $thu2, $fri1, $fri2, $sat1, $sat2);
//      // echo "<pre>";
//      //  print_r($o);
//      // print_r($days);
//      // print_r($day);
//      // echo "</pre>";
//      //
//      if ($time_select == "1") {
//        # code...
//        $query = "INSERT INTO tb_time_fix (nomor_spk, minggu, senin, selasa, rabu, kamis, jumat, sabtu) VALUES (:nomor, :minggu, :senin, :selasa, :rabu, :kamis, :jumat, :sabtu)";
//        $stmt = $cek->runQuery($query);
//        $stmt->execute(array(
//          ':nomor' => $no_kontrak,
//          ':minggu'=> $sun,
//          ':senin' => $mon,
//          ':selasa'=> $tue,
//          ':rabu'  => $wen,
//          ':kamis' => $thu,
//          ':jumat' => $fri,
//          ':sabtu' => $sat
//        ));
//      }elseif ($time_select == "2"){
//        $query = "INSERT INTO tb_time_fleksible (nomor_spk, minggu, senin, selasa, rabu, kamis, jumat, sabtu) VALUES (:nomor, :minggu, :senin, :selasa, :rabu, :kamis, :jumat, :sabtu)";
//        $stmt = $cek->runQuery($query);
//        $stmt->execute(array(
//          ':nomor' => $no_kontrak,
//          ':minggu'=> $minggu,
//          ':senin' => $senin,
//          ':selasa'=> $selasa,
//          ':rabu'  => $rabu,
//          ':kamis' => $kamis,
//          ':jumat' => $jumat,
//          ':sabtu' => $sabtu
//        ));
//      }else{
//        echo "you should better select one of them.";
//      }
//
//      if (!empty($time_select)) {
//        # code...
//        $query = "INSERT INTO tb_kerjasama_perusahan (nomor_kontrak, kode_perusahaan, kode_plan, total_karyawan, deskripsi, tugas, tanggung_jwb, penempatan, kontrak_start, kontrak_end, nilai_kontrak, kode_admin) VALUES (:kontrak, :kode, :plan, :jmlh, :deskripsi, :tgs, :tgjwb, :tmpt, :start, :ends, :nilai, :admin)";
//
//        $stmt = $cek->runQuery($query);
//        $stmt->execute(array(
//          ':kontrak'  =>$no_kontrak,
//          ':kode'     =>$kd_perusahaan,
//          ':plan'     =>$plan,
//          ':jmlh'     =>$jmlh,
//          ':deskripsi'=>$deskripsi,
//          ':tgs'      =>$tugas,
//          ':tgjwb'    =>$tanggung,
//          ':tmpt'     =>$penempatan,
//          ':start'    =>$start,
//          ':ends'     =>$ends,
//          ':nilai'    =>$total,
//          ':admin'    =>$admin));
//        if (!$stmt) {
//          # code...
//          echo "data tidak masuk";
//        } else{
//            //bahwa nama perusahaan dengan request tersebut telah melalui tahap "entry detail Project"
//          $sql = "UPDATE tb_temporary_perusahaan SET status = '3' WHERE tb_temporary_perusahaan.no_pendaftaran = :id";
//          $stmt = $cek->runQuery($sql);
//            $stmt->execute(array(
//                ':id'   =>$noReg));
//                if (!$stmt) {
//                  # code...
//                  echo "data tidak update di tb_temporary_perusahaan";
//                }else{
//                  echo "<script>
//                          alert('DATA Berhasil di Input!');
//                          window.location.href='index.php?p=entry-data';
//                          </script>";
//                }
//        }
//      }
//
//    }else{
//      // echo "you should better select one of them.";
//    }




?>
