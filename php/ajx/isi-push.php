<?php
include_once '../../config/api.php';

$config = new Admin();
    $push = $_GET['kode_push'];
    $sql = "SELECT tb_compos.id, tb_compos.kode_compos, tb_compos.id_reff, tb_compos.no_ktp, tb_compos.judul,
            tb_compos.isi, tb_compos.create_date, tb_compos.admin, tb_karyawan.nama_depan, tb_karyawan.nama_belakang
            FROM tb_compos 
            INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_compos.no_ktp
            WHERE tb_compos.kode_compos = :kode";
    $dd = $config->runQuery($sql);
    $dd->execute(array(':kode' => $push));

    $info = $dd->fetch(PDO::FETCH_LAZY);

    $tanggal = date('d M Y H:m:s', strtotime($info['create_date']));

    $query = "SELECT * FROM tb_compos WHERE tb_compos.id_reff = :idReff ";
    $stmt = $config->runQuery($query);
    $stmt->execute(array(':idReff' => $info['kode_compos']));
?>

<div class="col-sm-12 mail_view" style="border-top: 2px dashed #DBDBDB; border-left: unset; padding: 2%;">
    <div class="inbox-body">
        <div class="mail-head" style="border-bottom: 2px dashed #9c9292;">
            <div class="mail_heading row">
                <div class="col-md-8">
                    <h4> <?=$info['judul']?></h4>
                </div>
                <div class="col-md-4 text-right">
                    <p class="date"> <?=$tanggal?></p>
                </div>
            </div>
            <div class="sender-info">
                <div class="row">
                    <div class="col-md-12">
                        <strong>Admin</strong>
                        <span>(<?=$info['admin']?>)</span> to
                        <strong><?=$info['nama_depan']?> <?=$info['nama_belakang']?></strong>
                        <a class="sender-dropdown"><i class="fa fa-chevron-down"></i></a>
                    </div>
                </div>
            </div>
            <div class="view-mail">
                <br>
                <p><?=$info['isi']?></p>
            </div>
        </div>
        <div class="mail-content">

        </div>
        <ul class="list-unstyled msg_list" style="margin-top: 1%;">
            <?php if($stmt->rowCount() > 0 ){
                while ($row = $stmt->fetch(PDO::FETCH_LAZY)){
                    $date = date('Y/m/d H:m:s', strtotime($row['create_date']));

                    $find = '@';
                    if(strpos($row['admin'], $find) !== false ){
                        $userame = $row['admin'];
                        $foto = 'images/user.png';
                    }else{
                        $karyawan = "SELECT tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.foto FROM tb_karyawan WHERE tb_karyawan.no_ktp = :ktp";
                        $stmt2 = $config->runQuery($karyawan);
                        $stmt2->execute(array(':ktp' => $row['admin']));

                        $data = $stmt2->fetch(PDO::FETCH_LAZY);

                        $userame = $data['nama_depan'] . ' ' . $data['nama_belakang'];
                        if(empty($data['foto'])){
                            $foto = 'images/img.jpg';
                        }else{
                            $foto = $data['foto'];
                        }
                    }


                    ?>
                    <li>
                        <a style="padding: 1% 1% !important; width: 100%;">
                        <span class="image">
                          <img src="<?=$foto?>" alt="img">
                        </span>
                            <span>
                          <span style="font-size: 20px;"><?=$userame?></span>
                          <span class="time" style="right: 8%;"><?=$date?></span>
                        </span>
                            <span class="message" style="font-size: 14px;">
                          <?=$row['isi']?>
                        </span>
                        </a>
                    </li>
             <?php   }
            } ?>

        </ul>
        <br>
        <div class="btn-group">
            <button class="btn btn-sm btn-primary replayPush" data-kode="<?=$push?>" data-nama="<?=$info['nama_depan']?> <?=$info['nama_belakang']?>" data-title="<?=$info['judul']?>" type="button"><i class="fa fa-reply"></i> Reply</button>

        </div>
    </div>
</div>
