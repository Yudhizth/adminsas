<!-- top navigation -->
<?php

//notifikasi pembalasan complain perusahaan
    $cp = "SELECT tb_complain_perusahaan.id, tb_complain_perusahaan.id_reff, tb_complain_perusahaan.admin, tb_complain_perusahaan.update_on, tb_complain_perusahaan.status, tb_perusahaan.nama_perusahaan FROM tb_complain_perusahaan
    INNER JOIN tb_perusahaan ON tb_perusahaan.kode_perusahaan = tb_complain_perusahaan.admin
    WHERE tb_complain_perusahaan.admin NOT IN (SELECT tb_admin.username FROM tb_admin)
    AND tb_complain_perusahaan.admin !='' AND tb_complain_perusahaan.status = '' ";
    $cp = $config->runQuery($cp);
    $cp->execute();

    if($cp->rowCount() > 0){
        $totalComplainPerusahaan = $cp->rowCount();
//        while ($row = $cp->fetch(PDO::FETCH_LAZY)){
//            $replayCP = '<li><a>
//                            <span>
//                              <span style="color: #4BB926; font-weight: bold">'.$row['nama_perusahaan'].'</span>
//                              <span class="time" style="color: #26b99a;">' .$row['update_on'].'</span>
//                            </span>
//                            <span class="message">
//                              Replay Complain <b>Kupon: '.$row['id_reff'].'</b>
//                            </span>
//                        </a></li>';
//        };
    }else{
        $totalComplainPerusahaan = '0';
//        $replayCP = '';
    }
    //notifikasi new complain
    $cp2 = "SELECT tb_complain_perusahaan.id, tb_complain_perusahaan.kode_komplain, tb_complain_perusahaan.kode_perusahaan, tb_complain_perusahaan.update_on, tb_complain_perusahaan.status, tb_perusahaan.nama_perusahaan
    FROM tb_complain_perusahaan
    INNER JOIN tb_perusahaan ON tb_perusahaan.kode_perusahaan = tb_complain_perusahaan.kode_perusahaan
    WHERE tb_complain_perusahaan.status = ''";
    $cp2 = $config->runQuery($cp2);
    $cp2->execute();

    if($cp2->rowCount() > 0){
        $newComplain = $cp2->rowCount();
//        while ($row = $cp2->fetch(PDO::FETCH_LAZY)){
//            $newComplainCP = '<li><a>
//                            <span>
//                              <span style="color: #4BB926; font-weight: bold">'.$row['nama_perusahaan'].'</span>
//                              <span class="time" style="color: #26b99a;">' .$row['update_on'].'</span>
//                            </span>
//                            <span class="message">
//                              New Complain <b>Kupon: '.$row['kode_komplain'].'</b>
//                            </span>
//                        </a></li>';
//        };
    }else{
        $newComplain = '0';
//        $newComplainCP = '';
    }

    //notifikasi new komplain karyawan
    $cpK = "SELECT tb_complain_karyawan.id, tb_complain_karyawan.kode_komplain, tb_complain_karyawan.no_ktp, tb_complain_karyawan.status, tb_complain_karyawan.update, tb_karyawan.nama_depan, tb_karyawan.nama_belakang
        FROM tb_complain_karyawan
        INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_complain_karyawan.no_ktp
        WHERE tb_complain_karyawan.status = ''";
        $cpK = $config->runQuery($cpK);
        $cpK->execute();

    if($cpK->rowCount() > 0){
        $newComplainK = $cpK->rowCount();
//        while ($row = $cpK->fetch(PDO::FETCH_LAZY)){
//            $newComplainKar = '<li><a>
//                                <span>
//                                  <span style="color: #4BB926; font-weight: bold">'.$row['nama_depan'].' '.$row['nama_belakang'].'</span>
//                                  <span class="time" style="color: #26b99a;">' .$row['update'].'</span>
//                                </span>
//                                <span class="message">
//                                  New Complain <b>Kupon: '.$row['kode_komplain'].'</b>
//                                </span>
//                            </a></li>';
//        };
    }else{
        $newComplainK = '0';
//        $newComplainKar = '';
    }

    //notifikasi pembalasan complain karyawan
    $rep = "SELECT tb_complain_karyawan.id, tb_complain_karyawan.id_reff, tb_complain_karyawan.no_ktp, tb_complain_karyawan.admin, tb_complain_karyawan.update, tb_complain_karyawan.status, tb_karyawan.nama_depan, tb_karyawan.nama_belakang FROM tb_complain_karyawan
    INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_complain_karyawan.admin
    WHERE tb_complain_karyawan.admin NOT IN (SELECT tb_admin.username FROM tb_admin)
    AND tb_complain_karyawan.admin !='' AND tb_complain_karyawan.status = '' ";
    $replayKaryawan = $config->runQuery($rep);
$replayKaryawan->execute();

    if($replayKaryawan->rowCount() > 0){
        $totalReplayK = $replayKaryawan->rowCount();
//        while ($row = $replayKaryawan->fetch(PDO::FETCH_LAZY)){
//            $repK = '<li><a>
//                                <span>
//                                  <span style="color: #4BB926; font-weight: bold">'.$row['nama_depan'].' '.$row['nama_belakang'].'</span>
//                                  <span class="time" style="color: #26b99a;">' .$row['update'].'</span>
//                                </span>
//                                <span class="message">
//                                  Replay Complain <b>Kupon: '.$row['id_reff'].'</b>
//                                </span>
//                            </a></li>';
//        };
    }else{
        $totalReplayK = '0';
//        $repK = '';
    }

    //notifikasi new Perusahaan
    $newCP = "SELECT tb_temporary_perusahaan.no_pendaftaran,tb_temporary_perusahaan.no_pendaftaran, tb_temporary_perusahaan.nama_perusahaan, tb_temporary_perusahaan.cp, tb_temporary_perusahaan.create_date, tb_temporary_perusahaan.status
                                        FROM tb_temporary_perusahaan
                                        WHERE tb_temporary_perusahaan.kode_perusahaan = ''
                                        ORDER BY tb_temporary_perusahaan.create_date DESC";
    $newCP = $config->runQuery($newCP);
    $newCP->execute();

    if($newCP->rowCount() > 0){
        $totalNewCP = $newCP->rowCount();
//        while ($row = $newCP->fetch(PDO::FETCH_LAZY)){
//
//            $notNewCP = '<li><a>
//                                    <span>
//                                      <span style="color: #4BB926; font-weight: bold">New Customer</span>
//                                      <span class="time" style="color: #26b99a;">' .$row['create_date'].'</span>
//                                    </span>
//                                    <span class="message">
//                                      Perusahaan <b>'.$row['nama_perusahaan'].'</b> bergabung!
//                                    </span>
//                                </a></li>';
//        };
    }else{
        $totalNewCP = '0';
//        $notNewCP = '';
    }

    //notifikasi new request
    $newReq = "SELECT tb_temporary_perusahaan.no_pendaftaran, tb_temporary_perusahaan.kode_perusahaan, tb_temporary_perusahaan.kebutuhan, tb_temporary_perusahaan.nama_project, tb_temporary_perusahaan.status, tb_temporary_perusahaan.create_date, tb_kategori_pekerjaan.nama_kategori, tb_perusahaan.nama_perusahaan, tb_kerjasama_perusahan.nomor_kontrak 
    FROM tb_temporary_perusahaan
    INNER JOIN tb_kategori_pekerjaan ON tb_kategori_pekerjaan.kode_kategori = tb_temporary_perusahaan.kebutuhan
    INNER JOIN tb_perusahaan ON tb_perusahaan.kode_perusahaan = tb_temporary_perusahaan.kode_perusahaan
    LEFT JOIN tb_kerjasama_perusahan ON tb_kerjasama_perusahan.kode_request = tb_temporary_perusahaan.no_pendaftaran
    WHERE tb_kerjasama_perusahan.nomor_kontrak IS NULL";
$newReq = $config->runQuery($newReq);
$newReq->execute();

    if($newCP->rowCount() > 0){
        $totalNewReq = $newReq->rowCount();
//        while ($row = $newReq->fetch(PDO::FETCH_LAZY)){
//
//            $notNewReq = '<li><a>
//                                        <span>
//                                          <span style="color: #4BB926; font-weight: bold">New Request</span>
//                                          <span class="time" style="color: #26b99a;">' .$row['create_date'].'</span>
//                                        </span>
//                                        <span class="message">
//                                          Perusahaan <b>'.$row['nama_perusahaan'].'</b> request <b>'.$row['nama_kategori'].'</b>
//                                        </span>
//                                    </a></li>';
//        };
    }else{
        $totalNewReq = '0';
//        $notNewReq = '';
    }

    $totalNotifikasi = $totalComplainPerusahaan + $newComplain + $newComplainK + $totalReplayK + $totalNewCP + $totalNewReq;


?>
<div class="top_nav">
  <div class="nav_menu">
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <img src="images/<?php echo $rowAdmin['picture']; ?>" alt=""><?php echo $rowAdmin['nama_admin']; ?>
            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu dropdown-usermenu pull-right">
            <li><a href="javascript:;"> Profile</a></li>
            <li>
              <a href="javascript:;">
                <span class="badge bg-red pull-right">50%</span>
                <span>Settings</span>
              </a>
            </li>
            <li><a href="javascript:;">Help</a></li>
            <li><a href="logout.php?logout=true"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
          </ul>
        </li>

        <li role="presentation" class="dropdown">
          <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-envelope-o"></i>
            <span class="badge bg-green"><?=$totalNotifikasi?></span>
          </a>
            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">

                <?php
                if($cp->rowCount() > 0){
                    $totalComplainPerusahaan = $cp->rowCount();
                    while ($row = $cp->fetch(PDO::FETCH_LAZY)){
                        echo '<li><a>
                            <span>
                              <span style="color: #4BB926; font-weight: bold">'.$row['nama_perusahaan'].'</span>
                              <span class="time" style="color: #26b99a;">' .$row['update_on'].'</span>
                            </span>
                            <span class="message">
                              Replay Complain <b>Kupon: '.$row['id_reff'].'</b>
                            </span>
                        </a></li>';
                    };
                }
                if($cp2->rowCount() > 0){
                    $newComplain = $cp2->rowCount();
                    while ($row = $cp2->fetch(PDO::FETCH_LAZY)){
                        echo '<li><a>
                            <span>
                              <span style="color: #4BB926; font-weight: bold">'.$row['nama_perusahaan'].'</span>
                              <span class="time" style="color: #26b99a;">' .$row['update_on'].'</span>
                            </span>
                            <span class="message">
                              New Complain <b>Kupon: '.$row['kode_komplain'].'</b>
                            </span>
                        </a></li>';
                    };
                }
                if($cpK->rowCount() > 0){
                    $newComplainK = $cpK->rowCount();
                    while ($row = $cpK->fetch(PDO::FETCH_LAZY)){
                        echo '<li><a>
                                <span>
                                  <span style="color: #4BB926; font-weight: bold">'.$row['nama_depan'].' '.$row['nama_belakang'].'</span>
                                  <span class="time" style="color: #26b99a;">' .$row['update'].'</span>
                                </span>
                                <span class="message">
                                  New Complain <b>Kupon: '.$row['kode_komplain'].'</b>
                                </span>
                            </a></li>';
                    };
                }
                if($replayKaryawan->rowCount() > 0){
                    $totalReplayK = $replayKaryawan->rowCount();
                    while ($row = $replayKaryawan->fetch(PDO::FETCH_LAZY)){
                        echo '<li><a>
                                <span>
                                  <span style="color: #4BB926; font-weight: bold">'.$row['nama_depan'].' '.$row['nama_belakang'].'</span>
                                  <span class="time" style="color: #26b99a;">' .$row['update'].'</span>
                                </span>
                                <span class="message">
                                  Replay Complain <b>Kupon: '.$row['id_reff'].'</b>
                                </span>
                            </a></li>';
                    };
                }
                if($newCP->rowCount() > 0){
                    $totalNewCP = $newCP->rowCount();
                    while ($row = $newCP->fetch(PDO::FETCH_LAZY)){

                        echo '<li><a>
                                    <span>
                                      <span style="color: #4BB926; font-weight: bold">New Customer</span>
                                      <span class="time" style="color: #26b99a;">' .$row['create_date'].'</span>
                                    </span>
                                    <span class="message">
                                      Perusahaan <b>'.$row['nama_perusahaan'].'</b> bergabung!
                                    </span>
                                </a></li>';
                    };
                }
                if($newCP->rowCount() > 0){
                    $totalNewReq = $newReq->rowCount();
                    while ($row = $newReq->fetch(PDO::FETCH_LAZY)){

                        echo '<li><a>
                                        <span>
                                          <span style="color: #4BB926; font-weight: bold">New Request</span>
                                          <span class="time" style="color: #26b99a;">' .$row['create_date'].'</span>
                                        </span>
                                        <span class="message">
                                          Perusahaan <b>'.$row['nama_perusahaan'].'</b> request <b>'.$row['nama_kategori'].'</b>
                                        </span>
                                    </a></li>';
                    };
                }

                ?>
            </ul>

          </ul>
        </li>
      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->