<?php
 $admin_id = $_SESSION['user_session'];
?>
<div class="row">
  <div class="col-md-2 col-sm-3 col-xs-12"></div>
  <div class="col-md-8 col-sm-6 col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading">
          <h2>New Push !</h2>
        </div>
        <div class="panel-body">
          <form  method="post" action="" class="form-horizontal form-label-left" id="form-push" data-parsley-validate="">
            <div class="form-group">
                <label for="kepada" class="control-label col-md-3 col-sm-3 col-xs-12">Kepada</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="kepada" type="text" name="txt_kepada" class="form-control col-md-7 col-xs-12" placeholder="nama karyawan" id="kepada" required autofocus>
                    <input id="admin" type="hidden" name="txt_admin" class="form-control col-md-7 col-xs-12" value="<?=$admin_id;?>" >
                    <input id="idReff" type="hidden" name="txt_idReff" class="form-control col-md-7 col-xs-12" value="" >
                    <small style="color: #b9161d;"><b>*) Tambahkan tanda 'koma' lebih dari satu kepada.</b></small>
                </div>
            </div>

<!--        <div class="ui-widget">-->
<!--            <label for="skills">Tag your nama Karyawan: </label>-->
<!--            <input id="skills" name="txt_nama" size="50" required>-->
<!--        </div>-->
            <div class="form-group">
                <label for="kepada" class="control-label col-md-3 col-sm-3 col-xs-12">Subject</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="subject" type="text" name="txt_subject" class="form-control col-md-7 col-xs-12" placeholder="" required >
                </div>
            </div>
          
          <hr>

       
          <textarea name="txt_isi" class="form-control" id="contentPush" ></textarea>
            <br>
              <button class="btn btn-lg btn-block btn-success" type="submit" id="kirim" name="addPush">
                  <span class="fa fa-send"></span> Send Push
              </button>
        </form>
      </div>
  </div>
  <div class="col-md-2 col-sm-3 col-xs-12"></div>
</div>

<hr>