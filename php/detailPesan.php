<style type="text/css">
   blockquote p{
   font-size: 14px;
   }
   blockquote .small, blockquote footer, blockquote small {
   display: block;
   font-size: 80%;
   line-height: 1.42857143;
   color: #777;
   margin-left: 0;
   }
</style>
<?php

if (isset($_POST['addReply'])) {
	# code...
	$kdPush = $_POST['txt_kodePush'];
	$inisial = $_POST['txt_admin'];
	$isi = $_POST['txt_isi'];

		$id3 = "kd_subject";
      $kode3 = "DTSBJPS";
      $tbName3 = "tb_subject_push";

      $kd = $config->Generate($id3, $kode3, $tbName3);

      $dd = "INSERT INTO tb_detail_push (kd_detail, kd_push, inisial, pesan) VALUES (:kd, :push, :dari, :isi)";
      $set = $config->runQuery($dd);

      $set->execute(array(
      	':kd' => $kd,
      	':push' => $kdPush,
      	':dari' => $inisial,
      	':isi' => $isi
      	));
      if ($set) {
            $id_reff = $config->lastInsertID();
      	# code...
      	header('Location: ?p=push');
      }else{
      	echo "DATA TIDAK MASUK";
      }
}

   $kd = $_GET['pesan'];
   $sql = "SELECT tb_push.kd_push, tb_push.subject, tb_push.dari, tb_push.kepada, tb_push.create_date, tb_subject_push.nama_subject, tb_subject_push.isi, tb_subject_push.create_date, tb_admin.nama_admin, tb_karyawan.no_ktp, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_detail_push.inisial, tb_detail_push.pesan, tb_detail_push.create_date, tb_detail_push.read_date FROM tb_push INNER JOIN tb_subject_push ON tb_subject_push.kd_subject=tb_push.subject INNER JOIN tb_admin ON tb_admin.username = tb_push.dari INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_push.kepada INNER JOIN tb_detail_push ON tb_detail_push.kd_push = tb_push.kd_push WHERE tb_push.kd_push = :kd";
   $stmt = $config->runQuery($sql);
   $stmt->execute(array(':kd' => $kd));
   
   $col = $stmt->fetch(PDO::FETCH_LAZY);
   ?>
<div class="page-title">
   <div class="title_left">
      <h3>Make a Push! <span class="text-danger"><span class="fa fa-bullseye"></span></span></h3>
      <hr>
   </div>
</div>
<div class="clearfix"></div>
<div class="row">
   <div class="col-md-12">
      <div class="x_panel">
         <div class="x_title">
            <h2>Inbox</h2>
            <div class="clearfix"></div>
         </div>
         <div class="x_content">
            <div id="composeNew" style="display: none;">
               <?php
                  include_once "ajx/compose_new_push.php";
                  ?>
            </div>
         </div>
         <div class="x_content">
            <div class="row">
               <div id="listKiri" class="col-sm-12">
                  <div class="col-sm-12 mail_view">
                     <div class="inbox-body">
                        <div class="mail_heading row">
                           <div class="col-md-8">
                              <div class="btn-group">
                                 <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target=".bs-example-modal-lg"	><i class="fa fa-reply"></i> Reply</button>
                                 <button class="btn btn-sm btn-default" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Print"><i class="fa fa-print"></i></button>
                                 <button class="btn btn-sm btn-default" type="button" data-placement="top" data-toggle="tooltip" data-original-title="Trash"><i class="fa fa-trash-o"></i></button>
                              </div>
                           </div>
                           <div class="col-md-4 text-right">
                              <p class="date"> <?=$col['create_date']?></p>
                           </div>
                           <div class="col-md-12">
                              <h4> <?=$col['nama_subject']?></h4>
                           </div>
                        </div>
                        <?php 
                           $query = "SELECT * FROM tb_detail_push WHERE kd_push = :kd";
                           $dt = $config->runQuery($query);
                           $dt->execute(array(':kd' => $kd));
                           while ($row = $dt->fetch(PDO::FETCH_LAZY)) {
                           
                           if ($row['inisial'] == $admin_id) {
                           ?>
                        <blockquote>
                           <div class="sender-info">
                              <div class="row">
                                 <div class="col-md-12">
                                    <span>Dari</span>
                                    <strong><?=$row['inisial']?></strong>
                                    <a class="sender-dropdown"><i class="fa fa-chevron-down"></i></a>
                                 </div>
                              </div>
                           </div>
                           <div class="view-mail">
                              <p><?=$row['pesan']?></p>
                              <footer>Dibaca pada <?=$row['read_date']?></footer>
                           </div>
                        </blockquote>
                        <?php }else{?>
                        <blockquote class="blockquote-reverse">
                           <div class="sender-info">
                              <div class="row">
                                 <div class="col-md-12">
                                    <span>Dari</span>
                                    <strong><?=$row['inisial']?></strong>
                                    <a class="sender-dropdown"><i class="fa fa-chevron-down"></i></a>
                                 </div>
                              </div>
                           </div>
                           <div class="view-mail">
                              <p><?=$row['pesan']?></p>
                              <footer>Dibaca pada <?=$row['read_date']?></footer>
                           </div>
                        </blockquote>
                        <?php } } ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
   <div class="modal-dialog modal-lg">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title" id="myModalLabel">Reply</h4>
            </div>
            <div class="modal-body">
               <form  method="post" action="" class="form-horizontal form-label-left">
                  <div class="form-group">
                     <label for="kepada" class="control-label col-md-3 col-sm-3 col-xs-12">Kepada</label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="kepada" type="text" name="txt_kepada" class="form-control col-md-7 col-xs-12" value="<?=$col['kepada']?>" readonly="readonly">
                        <input id="admin" type="hidden" name="txt_admin" class="form-control col-md-7 col-xs-12" value="<?php echo $admin_id;?>" >
                        <input id="admin" type="hidden" name="txt_kodePush" class="form-control col-md-7 col-xs-12" value="<?=$col['kd_push']?>" >
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="kepada" class="control-label col-md-3 col-sm-3 col-xs-12">Subject</label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="subject" type="text" name="txt_subject" class="form-control col-md-7 col-xs-12" value="<?=$col['nama_subject']?>" readonly="readonly">
                     </div>
                  </div>
                  <hr>
                  <div class="form-group">
                     <label for="kepada" class="control-label col-md-3 col-sm-3 col-xs-12">Isi Pesan</label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea name="txt_isi" rows="9" class="form-control col-md-7 col-xs-12"> 
                        isi pesan
                        </textarea>
                     </div>
                  </div>
            </div>
            <div class="panel-footer">
            <button class="btn btn-lg btn-primary" type="submit" name="addReply" id="kirim">
            <span class="fa fa-send"></span> Kirim
            </button>
            </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>