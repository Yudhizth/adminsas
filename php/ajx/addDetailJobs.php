<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 04/02/2018
 * Time: 19.11
 */
$kode = $_GET['id'];
$admin = $_GET['admin'];
?>

<div class="row">
    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2 col-sm-offset-2" id="formDetail">
        <form class="form-horizontal form-label-left input_mask" id="detailJob" data-parsley-validate="">
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" name="txtKodeDetail" id="txtKodeDetail" value="<?=$kode?>" readonly>
                    <input type="hidden" class="form-control" name="txtAdmin" id="txtAdmin" value="<?=$admin?>" readonly>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" name="txtKegiatan" id="txtKegiatan" placeholder="Nama Kegiatan" data-parsley-minlength="6" data-parsley-maxlength="100" data-parsley-required-message="This value is required" required autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <textarea id="txtDeskripsi" placeholder="Deskripsi Kegiatan/Job" required="required" class="form-control" name="txtDeskripsi" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <textarea id="txtKeterangan" placeholder="Keterangan Kegiatan" required="required" class="form-control" name="txtKeterangan" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 col-sm-offset-3 col-xs-offset-12">
                    <button type="submit" name="addDetail" class="btn btn-block btn-info"  id="addDetail">Tambah <span class="fa fa-fw fa-plus"></span></button>
                </div>
            </div>
        </form>
    </div>
</div>
