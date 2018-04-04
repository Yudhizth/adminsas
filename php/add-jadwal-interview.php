<?php

$admin_id = $config->adminID();
$admin_id = $admin_id['id'];

$id = $_GET['id'];

    if (isset($_POST['addJadwal'])) {
        # code...

        $kodeTest = strip_tags($_POST['kode_test']);
        $ktp = strip_tags($_POST['no_ktp']);
        $kdAdmin = strip_tags($_POST['kode_admin']);
        $tanggalTest = strip_tags($_POST['tanggal']);
        $detail = strip_tags($_POST['detail']);
        $kd_status = "KDKRY0005";

        $stmt = $config->runQuery("INSERT INTO tb_info_interview (kd_interview, no_ktp, date_interview, detail, kd_admin) VALUES (:kd, :ktp, :tgl, :detail, :admin)");
        $stmt->execute(array(
            ':kd'   => $kodeTest,
            ':ktp'  => $ktp,
            ':tgl'  => $tanggalTest,
            ':detail' => $detail,
            ':admin' => $kdAdmin));

        if (!$stmt) {
            # code...
            echo "data tidak masuk";
        }else{
            $id_reff = $config->lastInsertID();
            $log = "INSERT INTO tb_log_event (id_reff, types, tables, ket, admin_id) VALUES (:a, :b, :c, :d, :e)";
            $log = $config->runQuery($log);
            $log->execute(array(
                ':a'    => $id_reff,
                ':b'    => '1',
                ':c'    => 'tb_info_interview',
                ':d'    => 'insert interview',
                ':e'    =>  $admin_id
            ));
          $sql2 = "UPDATE tb_karyawan SET kd_status_karyawan = :kd_karyawan WHERE no_ktp = :ktp";
          $update = $config->runQuery($sql2);
          $update->execute(array(
            ':kd_karyawan' => $kd_status,
            ':ktp'  => $id
          ));
            echo "<script>
            alert('Input Data Success!');
            window.location.href='?p=schedule-interview';
            </script>";

        }


    }

    $stmt  = $config->runQuery("SELECT no_ktp FROM tb_info_interview WHERE no_ktp = :id");
    $stmt->execute(array(
      ':id' => $id));

      if ($stmt->rowCount() == 0) {
          $dt = $config->runQuery("SELECT * FROM tb_karyawan WHERE no_ktp = :id");
            $dt->bindParam(':id', $id);
            $dt->execute();
        while($col = $dt->fetch(PDO::FETCH_LAZY)) {
            $id = "kd_interview";
            $kode = "ITRV";
            $tbName = "tb_info_interview";
            $kd = $config->Generate($id, $kode, $tbName);
            // ===========================================//

            $row = $stmt->fetch(PDO::FETCH_LAZY);
            ?>

    <div class="x_panel">
        <div class="x_title">
            <h2>Input Mask</h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <br>
            <form method="post" action="" class="form-horizontal form-label-left">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Kode Interviews</label>
                    <div class="col-md-5 col-sm-5 col-xs-9">
                        <input name="kode_test" type="text" class="form-control" value="<?php echo $kd; ?>" readonly>
                        <input name="kode_admin" type="hidden" class="form-control" value="<?php echo $admin_id; ?>">
                        <input name="no_ktp" type="hidden" class="form-control" value="<?php echo $col['no_ktp']; ?>">

                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Calon Karyawan</label>
                    <div class="col-md-5 col-sm-5 col-xs-9">
                        <input name="nama_karyawan" type="text" class="form-control"
                               value="<?php echo $col['nama_depan']; ?> <?php echo $col['nama_belakang']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Tanggal Interviews</label>
                    <div class="col-md-5 col-sm-5 col-xs-9">
                        <div class="control-group">
                            <input type="text" class="form-control has-feedback-left" name="tanggal" id="datepsikotes"
                                   aria-describedby="inputSuccess2Status4">
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Details</label>
                    <div class="col-md-5 col-sm-5 col-xs-9">
                        <textarea name="detail" rows="3" class="form-control has-feedback-left"></textarea>

                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                        <button type="submit" name="addJadwal" class="btn btn-success">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    </div>

    </div>
    </div>
    </div>
    <?php
}
  } else {
    
    $stmt = $config->runQuery("SELECT tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_info_interview.kd_interview, tb_info_interview.no_ktp, tb_info_interview.date_interview, tb_info_interview.detail, tb_info_interview.kd_admin FROM tb_info_interview
LEFT JOIN tb_karyawan ON tb_karyawan.no_ktp=tb_info_interview.no_ktp
WHERE tb_info_interview.no_ktp = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();



$row = $stmt->fetch(PDO::FETCH_LAZY);



if (isset($_POST['addData'])) {
  # code...

  $kodeTest = strip_tags($_POST['kode_test']);
  $ktp = strip_tags($_POST['no_ktp']);
  $detail = strip_tags($_POST['detail']);
  $kdAdmin = strip_tags($_POST['kode_admin']);
  $tanggalTest = strip_tags($_POST['tanggal']);
  $st = "";
  $kd_status = "KDKRY0014";

  $config = new Karyawan();
  $stmt = $config->runQuery("UPDATE tb_info_interview SET kd_interview = :kode, date_interview = :tanggal, detail = :detail, kd_admin = :admin, status = :st WHERE no_ktp = :id");
  $stmt->execute(array(
    ':kode'   => $kodeTest,
    ':tanggal'=> $tanggalTest,
    ':detail' => $detail,
    ':admin'  => $kdAdmin,
    ':st'       => $st,
    ':id'     => $ktp));
  if (!$stmt) {
    # code...
    echo "data tidak masuk";
  }else{
            $log = "INSERT INTO tb_log_event (id_reff, types, tables, ket, admin_id) VALUES (:a, :b, :c, :d, :e)";
            $log = $config->runQuery($log);
            $log->execute(array(
                ':a'    => $kodeTest,
                ':b'    => '3',
                ':c'    => 'tb_info_interview',
                ':d'    => 'update interview',
                ':e'    =>  $admin_id
            ));
    $sql2 = "UPDATE tb_karyawan SET kd_status_karyawan = :kd_karyawan WHERE no_ktp = :ktp";
      $update = $config->runQuery($sql2);
      $update->execute(array(
        ':kd_karyawan' => $kd_status,
        ':ktp'  => $id
      ));

      echo "<script>
            alert('Input Data Success!');
            window.location.href='?p=schedule-interview';
            </script>";
  }


}



?>

<div class="x_panel">
    <div class="x_title">
      <h2>Update Schedule</h2>
      
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <br>
      <form method="post" action="" class="form-horizontal form-label-left">
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-3">Kode Interviews</label>
              <div class="col-md-5 col-sm-5 col-xs-9">
                <input name="kode_test" type="text" class="form-control" value="<?php echo $row['kd_interview']; ?>" readonly>
                <input name="kode_admin" type="hidden" class="form-control" value="<?php echo $admin_id; ?>">
                <input name="no_ktp" type="hidden" class="form-control" value="<?php echo $row['no_ktp']; ?>">

              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-3">Calon Karyawan</label>
              <div class="col-md-5 col-sm-5 col-xs-9">
                <input name="nama_karyawan" type="text" class="form-control" value="<?php echo $row['nama_depan']; ?> <?php echo $row['nama_belakang']; ?>" readonly>
              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-3">Tanggal Interviews</label>
              <div class="col-md-5 col-sm-5 col-xs-9">
                <div class="control-group">
                    <input type="text" class="form-control has-feedback-left" name="tanggal" id="datepsikotes"  aria-describedby="inputSuccess2Status4" value="<?php echo $row['date_test']; ?>">
                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                    <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                  </div>
              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-3">Details</label>
              <div class="col-md-5 col-sm-5 col-xs-9">
                <textarea name="detail" rows="3" class="form-control has-feedback-left"><?php echo $row['detail']; ?></textarea>

              </div>
          </div>

          <div class="form-group">
            <div class="col-md-9 col-md-offset-3">
              <button type="submit" name="addData" class="btn btn-success">Submit</button>
            </div>
          </div>

      </form>
    </div>
</div>






                </div>
              
  </div>
  </div>
  </div>
<?php
  } ?>

