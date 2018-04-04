<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 06/03/2018
 * Time: 12.56
 */
session_start();
include_once '../../config/api.php';

$config = new Admin();
$admin_id = $config->adminID();
$admin_id = $admin_id['id'];
?>
<?php if($_GET['type'] == 'views'){
    $sql = "SELECT tb_info_bank.no_ktp, tb_info_bank.kd_bank, tb_info_bank.cabang, tb_info_bank.nomor_rek, tb_kode_bank.nama_bank, tb_karyawan.kd_status_karyawan, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_info_gaji.status, MONTH(tb_info_gaji.create_date) as tanggal FROM tb_info_bank
INNER JOIN tb_kode_bank ON tb_kode_bank.kd_bank=tb_info_bank.kd_bank
LEFT JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_info_bank.no_ktp
LEFT JOIN tb_info_gaji ON tb_info_gaji.no_ktp = tb_info_bank.no_ktp
WHERE tb_karyawan.kd_status_karyawan IN ('KDKRY0011')
AND MONTH(tb_info_gaji.create_date) = MONTH(NOW())";

    $stmt = $config->runQuery($sql);
    $stmt->execute();

    ?>
    <div class="x_panel" id="listKaryawanGaji">
        <div class="x_title">
            <h2><span class="fa fa-fw fa-list"></span> List Karyawan</h2>

            <ul class="nav navbar-right panel_toolbox">
                <li>
                    <button type="button" id="selectBank" class="selectBank btn btn-sm btn-default">Search...</button>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">


            <!-- start project list -->
            <table class="table table-striped projects">
                <thead>
                <tr>
                    <th style="width: 1%">#</th>
                    <th style="width: 20%">Nama Karyawan</th>
                    <th style="width: 20%">Nama Bank</th>
                    <th style="width: 20%">Cabang</th>
                    <th style="width: 20%">Nomor Rek.</th>
                    <th style="width: 20%">Status</th>
                    <th style="width: 19%">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                <tbody style="text-transform: capitalize;">
                <?php if($stmt->rowCount() > 0 ){
                    $i = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_LAZY)){
                        if($row['status'] == '1'){
                            $text = "<label class='label label-success'>Notifikasi has been sent this month!</label>";
                        }else{
                            $text = "<label class='label label-default'>unset</label>";
                        }
                    ?>
                    <tr>
                        <td><?=$i++?></td>
                        <td><?=$row['nama_depan']?> <?=$row['nama_belakang']?></td>
                        <td><?=$row['nama_bank']?></td>
                        <td><?=$row['cabang']?></td>
                        <td><b><?=$row['nomor_rek']?></b></td>
                        <td><?=$text?></td>
                            <td>
                            <a href="">
                                <button class="btn btn-xs btn-primary">Views</button>
                            </a>
                        </td>
                    </tr>
                <?php } }else{ ?>
                    <tr>
                        <td colspan="6">Belum ada Data Notifikasi Gaji yang dikirim.</td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
            <!-- end project list -->

        </div>
    </div>
<?php } ?>

<?php if($_GET['type'] == 'selectedBank'){

    $kodeBank = $_GET['kd'];
    $sql = "SELECT tb_info_bank.no_ktp, tb_info_bank.kd_bank, tb_info_bank.cabang, tb_info_bank.nomor_rek, tb_kode_bank.kd_bank, tb_kode_bank.nama_bank, tb_karyawan.kd_status_karyawan, tb_karyawan.nama_depan, tb_karyawan.nama_belakang FROM tb_info_bank
INNER JOIN tb_kode_bank ON tb_kode_bank.kd_bank=tb_info_bank.kd_bank
LEFT JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_info_bank.no_ktp
WHERE tb_karyawan.kd_status_karyawan IN ('KDKRY0011') AND tb_kode_bank.kd_bank = :kode";

    $stmt = $config->runQuery($sql);
    $stmt->execute(array(':kode'    => $kodeBank));

    ?>
    <div class="x_panel" id="listGajiBank">
        <div class="x_title">
            <h2><span class="fa fa-fw fa-list"></span> List Karyawan</h2>

            <ul class="nav navbar-right panel_toolbox">
                <li>
                    <button type="button" id="selectBank" class="selectBank btn btn-sm btn-default">Search...</button>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">


            <!-- start project list -->
            <table class="table table-striped projects">
                <thead>
                <tr>
                    <th style="width: 1%">#</th>
                    <th style="width: 20%">Nama Karyawan</th>
                    <th style="width: 20%">Nama Bank</th>
                    <th style="width: 20%">Cabang</th>
                    <th style="width: 20%">Nomor Rek.</th>
                    <th style="width: 19%">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                <tbody>
                <?php if($stmt->rowCount() > 0 ){
                    $i = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_LAZY)){
                        ?>
                        <tr>
                            <td><?=$i++?></td>
                            <td><?=$row['nama_depan']?> <?=$row['nama_belakang']?></td>
                            <td><?=$row['nama_bank']?></td>
                            <td><?=$row['cabang']?></td>
                            <td><?=$row['nomor_rek']?></td>
                            <td>
                                <a href="">
                                    <button class="btn btn-xs btn-primary">Views</button>
                                </a>
                            </td>
                        </tr>
                    <?php } }else{ ?>
                    <tr>
                        <td colspan="6">Data Tidak Ada</td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
            <!-- end project list -->

        </div>
        <?php if($stmt->rowCount() > 0){ ?>
        <hr>
        <button class="btn btn-primary btn-sm sendGaji" data-type="<?=$kodeBank?>" >Send Notification</button>
        <?php } ?>
    </div>
<?php } ?>
<?php if($_GET['type'] == 'inputGaji'){

    $tanggal = $config->getDate("d-m-Y");
    $type = $_POST['data'];

    $sql = "SELECT tb_info_bank.no_ktp, tb_info_bank.kd_bank, tb_info_bank.cabang, tb_info_bank.nomor_rek, tb_kode_bank.kd_bank, tb_kode_bank.nama_bank, tb_karyawan.kd_status_karyawan, tb_karyawan.nama_depan, tb_karyawan.nama_belakang FROM tb_info_bank
    INNER JOIN tb_kode_bank ON tb_kode_bank.kd_bank=tb_info_bank.kd_bank
    LEFT JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_info_bank.no_ktp
    WHERE tb_karyawan.kd_status_karyawan IN ('KDKRY0011') AND tb_kode_bank.kd_bank = :kode";

    $stmt = $config->runQuery($sql);
    $stmt->execute(array(':kode'    => $type));

    $status = "1";

    while ($row = $stmt->fetch(PDO::FETCH_LAZY)){
        $query = "INSERT INTO tb_info_gaji (no_ktp, status, tanggal_gaji) VALUES (:a, :b, :c)";
        $input = $config->runQuery($query);
        $input->execute(array(
                ':a'    => $row['no_ktp'],
                ':b'    => $status,
                ':c'    => $tanggal
        ));
        $id_reff = $config->lastInsertID();
        $log = "INSERT INTO tb_log_event (id_reff, types, tables, ket, admin_id) VALUES (:a, :b, :c, :d, :e)";
        $log = $config->runQuery($log);
        $log->execute(array(
            ':a'    => $id_reff,
            ':b'    => '1',
            ':c'    => 'tb_info_gaji',
            ':d'    => 'insert notifikasi gaji',
            ':e'    =>  $admin_id
        ));
    }

    if($input){
        echo "Notifikasi Telah dikirim";
    }else{
        echo "Notifikasi belum terkirim";
    }
} ?>
