<?php

    $record_lokers = '5';

    $sql = "SELECT tb_compos.id, tb_compos.kode_compos, tb_compos.id_reff, tb_compos.no_ktp, tb_compos.judul,
            tb_compos.isi, tb_compos.create_date, tb_compos.admin, tb_compos.status, tb_karyawan.nama_depan, tb_karyawan.nama_belakang
            FROM tb_compos 
            INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_compos.no_ktp
            WHERE tb_compos.kode_compos !='' ORDER BY tb_compos.create_date DESC  ";

    $listPUsh = $config->paging($sql, $record_lokers);
    $list = $config->runQuery($listPUsh);
    $list->execute();
?>

<div class="x_panel" id="isiPush" style="padding: 3% 2%;"></div>



<div class="row" id="push-content" >
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Push Pages<small>Admin Mail</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" >
                <div class="row">
                    <div  id="content-push">
                        <div class="col-sm-10 col-md-10 col-sm-offset-1 col-md-offset-1 col-xs-12 mail_list_column" id="showPush">
                            <button id="compose" class="btn btn-sm btn-success btn-block newCompos" type="button">COMPOSE</button>
                            <br>
                            <?php
                            if($list->rowCount() > 0){
                                while ($row = $list->fetch(PDO::FETCH_LAZY)){
                                    $date = date('d/m/y H:m', strtotime($row['create_date']));
                                    if($row['status'] == '1'){
                                        $status = '<i class="fa fa-circle-o"></i>';
                                        $title = "<label class='badge bg-green'>Replayed</label>";
                                    }elseif($row['status'] == '2'){
                                        $status = '<i class="fa fa-circle"></i>';
                                        $title = "<label class='label label-sm label-success'>replay</label>";

                                    }else{
                                        $status = '<i class="fa fa-circle"></i>';
                                        $title = "<label class='badge bg-green'>new</label>";

                                    }

                                    ?>
                                    <a href="#" class="showMore" data-id="<?=$row['kode_compos']?>">
                                        <div class="mail_list">
                                            <div class="left">
                                                <?=$status?>
                                            </div>
                                            <div class="right">
                                                <h3><span style="text-transform: capitalize;"><?=$row['judul']?> <?=$title?></span> <small><?=$date?></small></h3>
                                                <br>
                                                <p>Push dikirim ke Karyawan : <?=$row['nama_depan']?> <?=$row['nama_belakang']?>
                                                    <br>
                                                    Create by Admin: <?=$row['admin']?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                <?php   }
                            }else{ echo '<div class="jumbotron">
<h1>Nothing here!</h1> 
<p>Just Click Button Compose and start chat with your "Karyawan".</p> 
</div>' ;}
                            ?>

                            <?php $pages = $config->paginglink($sql, $record_lokers); ?>

                        </div>
                    </div>
                    <!-- /MAIL LIST -->

                    <!-- CONTENT MAIL -->
<!--                    <div class="col-sm-9 mail_view" id="isiPush">-->
<!---->
<!---->
<!--                    </div>-->
                    <!-- /CONTENT MAIL -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="replyPush" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-reply"></i> Replay Push</h4>
            </div>
            <div class="modal-body">

                <form  method="post" action="" class="form-horizontal form-label-left" id="replay-push" data-parsley-validate="">
                    <div class="form-group">
                        <label for="kepada" class="control-label col-md-3 col-sm-3 col-xs-12">Kepada</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="replayKepada" type="text" name="txt_kepada" class="form-control col-md-7 col-xs-12" placeholder="nama karyawan" readonly>
                            <input id="replayadmin" type="hidden" name="txt_admin" class="form-control col-md-7 col-xs-12" value="<?=$admin_id;?>" >
                            <input id="replayidReff" type="hidden" name="txt_idReff" class="form-control col-md-7 col-xs-12" value="" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="kepada" class="control-label col-md-3 col-sm-3 col-xs-12">Replay Message</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea name="txt_isi" class="form-control" id="replayPushISI" required></textarea>
                            <br>
                        </div>
                    </div>


                    <button class="btn btn-lg btn-block btn-success" type="submit">
                        <span class="fa fa-send"></span> Send Push
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>

<div id="form-push">
    <?php include 'php/ajx/compose_new_push.php';?>
</div>

