<?php 
$nomorKTP = $_GET['ktp'];

$dataKaryawan = "SELECT * FROM tb_karyawan WHERE no_ktp = :ktp";
$stmt = $config->runQuery($dataKaryawan);
$stmt->execute(array(
  ':ktp'  => $nomorKTP
  ));



$query = "SELECT tb_push.kd_push, tb_push.subject, tb_push.dari, tb_push.kepada, tb_push.create_date,
tb_subject_push.kd_subject, tb_subject_push.nama_subject, tb_subject_push.isi, tb_subject_push.create_date,
tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.foto
FROM tb_push
INNER JOIN tb_subject_push ON tb_subject_push.kd_subject = tb_push.subject
INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_push.kepada WHERE tb_push.kepada = :ktp ORDER BY tb_push.create_date DESC";
$dataPush = $config->runQuery($query);
$dataPush->execute(array(
  ':ktp'  => $nomorKTP
  ));

$row = $stmt->fetch(PDO::FETCH_LAZY);

if (isset($_POST['addNewPush'])) {
  
  $noKtp = $_POST['txt_kepada'];
  $admin = $_POST['txt_admin'];
  $subject = $_POST['txt_subject'];
  $pesan = $_POST['txt_isi'];

  // $dt = array($noKtp, $admin, $subject, $pesan);
  // echo "<pre>";
  // print_r($dt);
  // echo "</pre>";


      $id3 = "kd_subject";
      $kode3 = "DTSBJPS";
      $tbName3 = "tb_subject_push";

      $kd = $config->Generate($id3, $kode3, $tbName3);

      $sql = "INSERT INTO tb_subject_push (kd_subject, nama_subject, isi) VALUES (:kd, :nama, :isi)";
      $stmt = $config->runQuery($sql);
      $stmt->execute(array(
        ':kd' =>$kd,
        ':nama' =>$subject,
        ':isi'  =>$pesan));

      if (!$stmt) {
        # code...
        echo "<script>
        alert('Push Fail Send!');
        window.location.href='index.php?p=calon-karyawan';
        </script>";
      }
      else{
        $sql = "INSERT INTO tb_push (kd_push, subject, dari, kepada) VALUES (:kode, :aa, :bb, :cc)";

        $stmt = $config->runQuery($sql);

        $id = "kd_push";
        $kode = "PUSH";
        $tbName = "tb_push";
        $new_kode = $config->Generate($id, $kode, $tbName);

        $stmt->execute(array(
          ':kode'=>$new_kode,
          ':aa' =>$kd,
          ':bb' =>$admin,
          ':cc' =>$noKtp));

        $id2 = "kd_detail";
        $kode2 = "PUSHDT";
        $tbName2 = "tb_detail_push";
        $kdDetail = $config->Generate($id2, $kode2, $tbName2);
        $sql = "INSERT INTO tb_detail_push (kd_detail, kd_push, inisial, pesan) VALUES (:kd, :push, :inisial, :isi)";
        $stmt = $config->runQuery($sql);
        $stmt->execute(array(
          ':kd'   =>$kdDetail,
          ':push' =>$new_kode,
          ':inisial' =>$admin,
          ':isi'  =>$pesan));

        if (!$stmt) {
          echo "<script>
        alert('Push Fail Send!');
        window.location.href='index.php?p=calon-karyawan';
        </script>";
        } else{
          $id_reff = $config->lastInsertID();

              echo "<script>
                      alert('Push Has Send!');
                      window.location.href='index.php?p=calon-karyawan';
                      </script>";
        }
      }
}

?>
<div class="row">
  <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2 col-sm-offset-2 well">
    <div class="panel panel-primary">
      <div class="panel-heading">
      </div>
      <div class="panel-body">
        <form method="post" action="" class="form-horizontal form-label-left">
          <div class="form-group">
            <label for="kepada" class="control-label col-md-3 col-sm-3 col-xs-12">Kepada</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input  type="text" name="txt_test" class="form-control col-md-7 col-xs-12 ui-autocomplete-input" value="<?=$row['nama_depan']?> <?=$row['nama_belakang']?> (<?=$nomorKTP?>)" readonly>
              <input  type="hidden" name="txt_kepada" class="form-control col-md-7 col-xs-12 ui-autocomplete-input" value="<?=$nomorKTP?>" readonly>
              <input id="admin" type="hidden" name="txt_admin" class="form-control col-md-7 col-xs-12" value="<?php echo $admin_id;?>">
            </div>
          </div>
          <div class="form-group">
            <label for="kepada" class="control-label col-md-3 col-sm-3 col-xs-12">Subject</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="subject" type="text" name="txt_subject" class="form-control col-md-7 col-xs-12" placeholder="" required="">
            </div>
          </div>
          
          <hr>
          <div class="form-group">
            <label for="kepada" class="control-label col-md-3 col-sm-3 col-xs-12">Isi Pesan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea name="txt_isi" rows="9" class="form-control col-md-7 col-xs-12"> 

              </textarea>
            </div>
          </div>


          <div class="">
            <button class="btn btn-sm btn-block btn-primary" type="submit" name="addNewPush">
              <span class="fa fa-send"></span> Kirim
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2 col-sm-offset-2 well">
    <?php
    if ($dataPush->rowCount() > 0) {
      while ($data = $dataPush->fetch(PDO::FETCH_LAZY)) {
        $date = $data['create_date'];
        $date = explode(' ', $date);
        $date = $date[0];
        $date = explode('-', $date);
      ?>
      <ul class="messages">
        <li>
          <img src="<?=$data['foto']?>" class="avatar" alt="Avatar">
          <div class="message_date">
            <h4 class="date text-info">Date</h4>
            <p class="month"><?=$date[2]?>/<?=$date[1]?>/<?=$date[0]?></p>
          </div>
          <div class="message_wrapper">
            <h4 class="heading"><?=$data['nama_subject']?></h4>
            <blockquote class="message">
              <?=$data['isi']?>
            </blockquote>
          <br><!-- 
          <p class="url">
            <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
            <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
          </p> -->
        </div>
      </li>
    </ul>
    <?php
  }
}
else { ?>
  <div class="jumbotron h3" style="text-align: center;">Data Push Belum ada!</div>
<?php
}

?>
  </div>
</div>