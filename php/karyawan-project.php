<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 31/01/2018
 * Time: 14.42
 */
$id = $_GET['id'];
$nomorSPK = $_GET['id'];
$cekdata = 'SELECT * FROM tb_kerjasama_perusahan WHERE nomor_kontrak = :kodekontrak';
$show = $config->runQuery($cekdata);
$show->execute(array(':kodekontrak' => $id));

$dataSPK = $show->fetch(PDO::FETCH_LAZY);
$type = $dataSPK['kode_request'];
$kebutuhan = substr($type, 0, 3);

$kodeListKaryawan = $dataSPK['kode_list_karyawan'];
echo $kodeListKaryawan;

$totKar = "SELECT tb_list_karyawan.id, tb_karyawan.nama_depan, tb_karyawan.nama_belakang 
FROM tb_list_karyawan 
INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_list_karyawan.no_nip
WHERE kode_list_karyawan = :kode";
$totalKary = $config->runQuery($totKar);
$totalKary->execute(array(
    ':kode' => $kodeListKaryawan
));

$totalKaryawanSelected = $totalKary->rowCount();

//list karyawan _remove this project

$sql2 = "SELECT tb_temp_remove_karyawan.no_ktp, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.jenis_kelamin FROM tb_temp_remove_karyawan
INNER JOIN tb_karyawan ON tb_karyawan.no_ktp=tb_temp_remove_karyawan.no_ktp
WHERE tb_temp_remove_karyawan.kode_list_karyawan = :kodenya";

$listRemove = $config->runQuery($sql2);
$listRemove->execute(array(':kodenya' => $kodeListKaryawan));

if (empty($dataSPK['kode_list_karyawan'])) {

    $field = "kode_list_karyawan";
    $inisial = "KRYLS";
    $tbName = "tb_kerjasama_perusahan";

    $generate = $config->Generate($field, $inisial, $tbName);

    echo '<div class="col-md-6 col-lg-offset-3">
            <div class="well">
                <p>
                <button id="GenerateListKaryawan" data-kode="' . $generate . '" data-spk="' . $id . '" class="btn btn-block btn-info" name="addGenerate">Generate Code Karyawan</button>
                </p>
            </div>
        </div> ';

} else {


    switch ($kebutuhan) {
        case "BPO":
            $typeKebutuhan = "BPO01";

            $records_per_page = 10;
            $dt = "SELECT tb_karyawan.no_ktp, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.jenis_kelamin, tb_kode_status_karyawan.nama_kode 
FROM tb_karyawan
INNER JOIN tb_kode_status_karyawan ON tb_kode_status_karyawan.kd_id = tb_karyawan.kd_status_karyawan
where kd_status_karyawan IN ('KDKRY0006', 'KDKRY0008', 'KDKRY0009', 'KDKRY0010', 'KDKRY0015')
AND tb_karyawan.no_ktp NOT IN (SELECT tb_list_karyawan.no_nip FROM tb_list_karyawan INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_list_karyawan.no_nip)
AND tb_karyawan.no_ktp NOT IN (SELECT tb_temp_remove_karyawan.no_ktp FROM tb_temp_remove_karyawan INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_temp_remove_karyawan.no_ktp
WHERE tb_temp_remove_karyawan.kode_list_karyawan = '".$kodeListKaryawan."')";
            $sql = $config->paging($dt, $records_per_page);
            $listKaryawan = $config->runQuery($sql);
            $listKaryawan->execute();
            break;
        case "MPO":
            $typeKebutuhan = "MPO01";

            $query = "SELECT tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.kode_perusahaan, tb_kerjasama_perusahan.kode_request, tb_kerjasama_perusahan.kode_plan, tb_kerjasama_perusahan.kode_list_karyawan, tb_list_perkerjaan_perusahaan.name_list, tb_list_perkerjaan_perusahaan.total, tb_jenis_pekerjaan.nama_pekerjaan
            FROM tb_kerjasama_perusahan
            INNER JOIN tb_list_perkerjaan_perusahaan ON tb_list_perkerjaan_perusahaan.code = tb_kerjasama_perusahan.kode_plan
            INNER JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan=tb_list_perkerjaan_perusahaan.name_list
            WHERE tb_kerjasama_perusahan.nomor_kontrak = :nomorKontrak";

            $listMPO = $config->runQuery($query);
            $listMPO->execute(array(
                ':nomorKontrak' => $nomorSPK
            ));

            $listMPO2 = $config->runQuery($query);
            $listMPO2->execute(array(
                ':nomorKontrak' => $nomorSPK
            ));

            break;
        case "KST":
            $typeKebutuhan = "KST01";

            $records_per_page = 10;
            $dt = "SELECT tb_karyawan.no_ktp, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.jenis_kelamin, tb_kode_status_karyawan.nama_kode 
FROM tb_karyawan
INNER JOIN tb_kode_status_karyawan ON tb_kode_status_karyawan.kd_id = tb_karyawan.kd_status_karyawan
where kd_status_karyawan IN ('KDKRY0006', 'KDKRY0008', 'KDKRY0009', 'KDKRY0010', 'KDKRY0015')
AND tb_karyawan.no_ktp NOT IN (SELECT tb_list_karyawan.no_nip FROM tb_list_karyawan INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_list_karyawan.no_nip)
AND tb_karyawan.no_ktp NOT IN (SELECT tb_temp_remove_karyawan.no_ktp FROM tb_temp_remove_karyawan INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_temp_remove_karyawan.no_ktp
WHERE tb_temp_remove_karyawan.kode_list_karyawan = '".$kodeListKaryawan."')";
            $sql = $config->paging($dt, $records_per_page);
            $listKaryawan = $config->runQuery($sql);
            $listKaryawan->execute();

            break;
        case "SYG":

            $records_per_page = 10;
            $dt = "SELECT tb_karyawan.no_ktp, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.jenis_kelamin, tb_kode_status_karyawan.nama_kode 
FROM tb_karyawan
INNER JOIN tb_kode_status_karyawan ON tb_kode_status_karyawan.kd_id = tb_karyawan.kd_status_karyawan
where tb_karyawan.kd_status_karyawan IN ('KDKRY0006', 'KDKRY0008', 'KDKRY0009', 'KDKRY0010', 'KDKRY0015')
AND tb_karyawan.no_ktp NOT IN (SELECT tb_list_karyawan.no_nip FROM tb_list_karyawan INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_list_karyawan.no_nip)
AND tb_karyawan.no_ktp NOT IN (SELECT tb_temp_remove_karyawan.no_ktp FROM tb_temp_remove_karyawan INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_temp_remove_karyawan.no_ktp
WHERE tb_temp_remove_karyawan.kode_list_karyawan = '".$kodeListKaryawan."')";
            $sql = $config->paging($dt, $records_per_page);
            $listKaryawan = $config->runQuery($sql);
            $listKaryawan->execute();


            $typeKebutuhan = "SYG01";
            break;

            defaul:
            $typeKebutuhan = "";
    }

//    tampilkaryawan terpilih


    $sm = "SELECT tb_list_karyawan.kode_list_karyawan, tb_list_karyawan.no_nip, tb_list_karyawan.kode_jabatan, tb_list_karyawan.status_karyawan, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.jenis_kelamin, tb_karyawan.email, tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.kode_list_karyawan, tb_list_karyawan.kode_pekerjaan, tb_jenis_pekerjaan.nama_pekerjaan
FROM tb_list_karyawan INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_list_karyawan.no_nip
LEFT JOIN tb_kerjasama_perusahan ON tb_kerjasama_perusahan.kode_list_karyawan = tb_list_karyawan.kode_list_karyawan
LEFT JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan = tb_list_karyawan.kode_pekerjaan
WHERE tb_kerjasama_perusahan.kode_list_karyawan = :nomor";
    $selectedKaryawan = $config->runQuery($sm);
    $selectedKaryawan->execute(array(':nomor' => $kodeListKaryawan));


    ?>
    <!--    content select Karyawan -->

    <?php if ($typeKebutuhan != 'MPO01') { ?>
        <div class="row">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-lg-offset-4 col-md-offset-4 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-users"></i></div>
                    <div class="count" style="padding-bottom: 4%; padding-left: 2%;"><?= $dataSPK['total_karyawan'] ?>/
                        <small style="color: #BAB8B8;"><?= $totalKaryawanSelected ?></small>
                    </div>
                    <h3>Total Karyawan Project</h3>
                    <p>Untuk NOMOR SPK <?= $dataSPK['nomor_kontrak'] ?></p>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <h3>List Karyawan Available</h3>
                        <hr>
                        <div class="table-responsive" id="listKaryawan">
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                <tr class="headings">
                                    <th class="column-title">#</th>
                                    <th class="column-title">Nama Lengkap</th>
                                    <th class="column-title">Jenis Kelamin</th>
                                    <th class="column-title no-link last"><span class="nobr">Status Karyawan</span>
                                    </th>
                                    <th class="column-title no-link last"><span class="nobr">#</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                if ($listKaryawan->rowCount() > 0) {
                                    while ($row = $listKaryawan->fetch(PDO::FETCH_LAZY)) { ?>
                                        <tr class="even pointer">
                                            <td class=" "><?= $i++; ?></td>
                                            <td class=" ">
                                                <a href="?p=detail-karyawan&id=<?= $row['no_ktp']; ?>"
                                                   data-toggle="tooltip" data-placement="right" title="Detail!">
                                                    <?= $row['nama_depan']; ?> <?= $row['nama_belakang'] ?>
                                                </a>
                                            </td>
                                            <td class=" "><?= $row['jenis_kelamin']; ?></td>
                                            <td class=" ">
                                    <span class="label label-success " style="font-size: 12px; letter-spacing: .1em">
                                        <?= $row['nama_kode']; ?>
                                    </span>
                                            </td>
                                            <td>
                                                <button type="button" data-toggle="tooltip"
                                                        data-kode="<?= $kodeListKaryawan ?>"
                                                        data-ktp="<?= $row['no_ktp'] ?>" data-placement="right"
                                                        title="Add"
                                                        class="btn btn-info btn-xs tambahKaryawan"
                                                        onclick="return confirm('Are you sure you want to add?');">
                                                    <i class="fa fa-fw fa-plus-square"> </i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                    }

                                } else {
                                    echo "<td colspan='7' style='font-size=18px; font-wight=500;'>Karyawan Belum Dipilih!</td>";
                                }
                                ?>
                                </tbody>
                            </table>
                            <?php
                            $url = "id=" . $id . "&";
                            $listKaryawan = $config->paginglinkURL($dt, $url, $records_per_page);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <h3>Selected Karyawan</h3>
                        <hr>
                        <div id="karyawanSelected">
                            <?php include 'php/selectedKaryawan.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-lg-offset-4 col-md-offset-4 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-users"></i></div>
                    <div class="count" style="">
                        <table class="table table-bordered" style="width: 70%; margin-top: 4%;">
                            <thead style="font-size: 12px;">
                            <th>Posisi</th>
                            <th>Total</th>
                            </thead>
                            <tbody style="font-size: 12px;">
                            <?php
                            while ($dataMPO = $listMPO->fetch(PDO::FETCH_LAZY)) {
                                ?>
                                <tr>
                                    <td><?= $dataMPO['nama_pekerjaan'] ?></td>
                                    <td><?= $dataMPO['total'] ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <h3>Total Karyawan Project</h3>
                    <p>Untuk NOMOR SPK <?= $dataSPK['nomor_kontrak'] ?></p>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <h3>List Karyawan Available</h3>
                        <hr>

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12" id="getMPO">
                                <select class="form-control" id="selectMPO">
                                    <option value="">List Posisi</option>
                                    <?php
                                    while ($data = $listMPO2->fetch(PDO::FETCH_LAZY)){
                                        ?>
                                        <option value="<?=$data['name_list']?>" data-id="<?=$id?>" data-karyawan="<?=$kodeListKaryawan?>"><?= $data['nama_pekerjaan'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br/>
                        <div class="row" id="listMPO">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <h3>Selected Karyawan</h3>
                        <hr>
                        <div id="karyawanSelected">
                            <?php include 'php/selectedKaryawan.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <?php } ?>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-6 col-sm-offset-6">
            <div class="x_panel">
                <div class="x_content">
                    <h3>List Karyawan Removed by Customer</h3>
                    <hr>

                    <div class="table-responsive">
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                            <tr class="headings">
                                <th class="column-title">#</th>
                                <th class="column-title">Nama Lengkap</th>
                                <th class="column-title">Jenis Kelamin</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            if ($listRemove->rowCount() > 0) {
                                while ($row = $listRemove->fetch(PDO::FETCH_LAZY)) { ?>
                                    <tr class="even pointer">
                                        <td class=" "><?= $i++; ?></td>
                                        <td class=" ">
                                            <a href="?p=detail-karyawan&id=<?= $row['no_ktp']; ?>"
                                               data-toggle="tooltip" data-placement="right" title="Detail!">
                                                <?= $row['nama_depan']; ?> <?= $row['nama_belakang'] ?>
                                            </a>
                                        </td>
                                        <td class=" "><?= $row['jenis_kelamin']; ?></td>
                                    </tr>
                                    <?php
                                }

                            } else {
                                echo "<td colspan='7' style='font-size=18px; font-wight=500;'>Karyawan Belum Ada!</td>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--    end content select karyawan-->
<?php } ?>
