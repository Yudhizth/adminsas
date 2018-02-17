<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 07/02/2018
 * Time: 03.03
 */

include_once '../../config/api.php';

$config = new Admin();

$kupon = $_GET['kupon'];
$admin_id = $_GET['admin'];

$query = "SELECT * FROM tb_complain_perusahaan WHERE kode_komplain = :kode ORDER BY update_on DESC";
$cek = $config->runQuery($query);
$cek->execute(array(
    ':kode' => $kupon
));

$row = $cek->fetch(PDO::FETCH_LAZY);
?>

<div class="x_panel">
    <div class="x_content">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">

                    <h4 class="modal-title" id="myModalLabel2">Kupon : <span class="label label-sm label-primary"><?=$kupon?></span></h4>
                </div>
                <div class="modal-body">
                    <form id="replayComplain" method="post" data-parsley-validate="">
                        <label for="fullname">Judul Balasan Komplain :</label>
                        <input type="text" id="titleComplain" class="form-control" data-parsley-minlength="10" name="fullname" value="<?=$row['judul']?>" required="">
                        <input type="hidden" id="reffComplain" class="form-control" name="fullname" value="<?=$kupon?>">
                        <input type="hidden" id="adminComplainID" class="form-control" name="fullname" value="<?=$admin_id?>">
                        <label for="message">Isi Balasan Complain :</label>
                        <textarea id="isiComplainPerusahaan" required="required" rows="6" class="form-control" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>

                        <br>
                        <button type="submit" class="btn btn-primary">Replay <span class="fa fa-paper-plane"></span></button>
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
