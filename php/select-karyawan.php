<?php
$id = $_GET['id'];
$data = new Admin();



if (isset($_POST['addGenerate'])) {
    # code...
    $kode = $_POST['txt_id'];

    $query = "SELECT * FROM tb_kerjasama_perusahan WHERE tb_kerjasama_perusahan.nomor_kontrak = :nomor_kontrak";
    $stmt = $config->runQuery($query);
    $stmt->execute(array(
        ':nomor_kontrak' => $kode
    ));
    $row = $stmt->fetch(PDO::FETCH_LAZY);
    $kd_list_karyawan = $row['kode_list_karyawan'];
    if ($kd_list_karyawan == "") {

        $field = "kode_list_karyawan";
        $inisial = "KRYLS";
        $tbName = "tb_kerjasama_perusahan";

        $generate = $data->Generate($field, $inisial, $tbName);

        $sql = "UPDATE tb_kerjasama_perusahan SET kode_list_karyawan = :kode WHERE nomor_kontrak = :nomor ";
        $stmt = $config->runQuery($sql);
        $stmt->execute(array(
            ":kode" => $generate,
            ":nomor" => $kode
        ));

        if ($stmt) {
            # code...
            echo "<script>
        alert('Input Data Success!');
        window.location.href='?p=select-karyawan&id=" . $id . "';
        </script>";
            // echo "data berhasil masuk";
            // echo "<script>
            //         alert('CODE Berhasil di Generate!');
            //         window.location.href='?p=select-karyawan&id=".$kode."';
            //         </script>";

        } else {
            echo "Data Tidak Masuk";
        }
    } else {
        echo "halaman input";
    }


}

$query = "SELECT * FROM tb_kerjasama_perusahan WHERE tb_kerjasama_perusahan.nomor_kontrak = :nomor_kontrak";
$stmt = $config->runQuery($query);
$stmt->execute(array(
    ':nomor_kontrak' => $id
));

    $row = $stmt->fetch(PDO::FETCH_LAZY);
    $kd_list_karyawan = $row['kode_list_karyawan'];
    if ($kd_list_karyawan == "")
    {
        //Generate Kode Karyawan
        ?>
        <div class="col-md-6 col-lg-offset-3">
            <div class="well">
                <p>
                <form class="" action="" method="post">
                    <input type="hidden" name="txt_id" value="<?= $id ?>">
                    <input type="hidden" name="txt_id" value="<?= $id ?>">
                    <button type="submit" class="btn btn-block btn-info" name="addGenerate">Generate Code Karyawan</button>
                </form>
                </p>
            </div>
        </div>
        <?php
    }
    else
        {
                $records_per_page = 10;
                $dt = "SELECT tb_karyawan.no_ktp, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.email, tb_kode_status_karyawan.nama_kode FROM `database`.tb_karyawan INNER JOIN tb_kode_status_karyawan ON tb_kode_status_karyawan.kd_id = tb_karyawan.kd_status_karyawan where kd_status_karyawan IN ('KDKRY0006', 'KDKRY0008', 'KDKRY0009', 'KDKRY0010', 'KDKRY0015') AND tb_karyawan.no_ktp NOT IN (SELECT tb_list_karyawan.no_nip FROM tb_list_karyawan INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_list_karyawan.no_nip)";
                $sql = $data->paging($dt, $records_per_page);
                $stmt = $data->runQuery($sql);
                $stmt->execute();
    //Tampilkan List Calon Karyawan Project
            ?>
            <div class="x_content">
                <h3>Select List Karyawan</h3>
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                        <tr class="headings">
                            <th class="column-title">#</th>
                            <th class="column-title">NIK</th>
                            <th class="column-title">Nama Lengkap</th>
                            <th class="column-title">Email</th>
                            <th class="column-title">Status</th>
                            <th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        while ($row = $stmt->fetch(PDO::FETCH_LAZY))
                        {
                        ?>
                        <tr class="even pointer">
                            <td class=" "><?= $i++; ?></td>
                            <td class=" "><?= $row['no_ktp']; ?></td>
                            <td class=" "><?= $row['nama_depan']; ?> <?= $row['nama_belakang'] ?></td>
                            <td class=" "><?= $row['email']; ?></td>
                            <td class=" "><label class="label label-success" style="font-size: 11px;">
                                <?= $row['nama_kode']; ?>
                            </label></td>
                            <td>
                                <a href="?p=addKaryawan&id=<?= $row['no_ktp']; ?>&kode=<?= $kd_list_karyawan ?>">
                                    <button type="button" data-toggle="tooltip" data-placement="right" title="Add"
                                            class="btn btn-info btn-xs" onclick="return confirm('Are you sure you want to add?');">
                                        <i class="fa fa-fw fa-plus-square"> </i>
                                    </button>
                                </a>
                            </td>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                    $url = "id=" . $id . "&";
                    $stmt = $data->paginglinkURL($dt, $url, $records_per_page);
                    ?>
                </div>
            </div>
            <?php
                $dt = "SELECT tb_list_karyawan.kode_list_karyawan, tb_list_karyawan.no_nip, tb_list_karyawan.kode_jabatan, tb_list_karyawan.status_karyawan, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.jenis_kelamin, tb_karyawan.email, tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.kode_list_karyawan FROM tb_list_karyawan INNER JOIN tb_karyawan ON tb_karyawan.no_ktp = tb_list_karyawan.no_nip INNER JOIN tb_kerjasama_perusahan ON tb_kerjasama_perusahan.kode_list_karyawan = tb_list_karyawan.kode_list_karyawan WHERE tb_kerjasama_perusahan.nomor_kontrak = :nomor";
                $stmt = $data->runQuery($dt);
                $stmt->execute(array(':nomor' => $id));
                  //List Karyawan Selected To Project
            ?>
            <div class="x_content">
                <h3>Selected List Karyawan</h3>
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                        <tr class="headings">
                            <th class="column-title">#</th>
                            <th class="column-title">NIK</th>
                            <th class="column-title">Nama Lengkap</th>
                            <th class="column-title">Jenis Kelamin</th>
                            <th class="column-title no-link last"><span class="nobr">Email</span>
                            </th>
                            <th class="column-title no-link last"><span class="nobr">Status</span>
                            </th>
                            <th class="column-title no-link last"><span class="nobr">#</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        if($stmt->rowCount() > 0){
                        while ($row = $stmt->fetch(PDO::FETCH_LAZY))
                        {
                            $st = $row['status_karyawan'];
                            if ($st == '1') {
                                $status = '<label class="label label-lg label-success">Approved!</label>';
                            } elseif ($st == '2') {
                                $status = '<label class="label label-lg label-danger">Decline!</label>';
                            } else {
                                $status = '<label class="label label-lg label-default">Not Set</label>';
                            } ?>
                            <tr class="even pointer">
                                <td class=" "><?= $i++; ?></td>
                                <td class=" "><?= $row['no_nip']; ?></td>
                                <td class=" "><?= $row['nama_depan']; ?> <?= $row['nama_belakang'] ?></td>
                                <td class=" "><?= $row['email']; ?></td>
                                <td><?=$row['jenis_kelamin']?></td>
                                <td><?=$status?></td>
                                <td>
                                <a href="php/deleteKaryawanSuggest.php?id=<?=$row['no_nip']?>&kode=<?=$row['kode_list_karyawan']?>&spk=<?=$id?>">
                                    <button class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="Remove Karyawan"><span class="fa fa-fw fa-times-circle"></span></button>
                                </a>
                                </td>
                            </tr>
                            <?php
                        }

                    }else{
                        echo "<td colspan='7' style='font-size=18px; font-wight=500;'>Karyawan Belum Dipilih!</td>";
                    }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
                    <?php
        }

$cekdata = 'SELECT * FROM tb_kerjasama_perusahan WHERE nomor_kontrak = :kodekontrak';
$show = $data->runQuery($cekdata);
$show->execute(array(':kodekontrak' => $id));

$dataSPK = $show->fetch(PDO::FETCH_LAZY);
$type = $dataSPK['kode_request'];
$dataSPK = substr($type, 0, 3);

switch ($dataSPK){
    case "BPO":
        $typeKebutuhan = "BPO01";
        break;
    case "MPO":
        $typeKebutuhan = "MPO01";
        break;
    case "KST":
        $typeKebutuhan = "KST01";
        break;
    case "SYG":
        $typeKebutuhan = "SYG01";
        break;

        defaul:
        $typeKebutuhan = "";

}

$data = new Admin();
$sql = "SELECT tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.kode_list_karyawan, tb_kerjasama_perusahan.total_karyawan, tb_temporary_perusahaan.nama_perusahaan, tb_temporary_perusahaan.kode_perusahaan, tb_temporary_perusahaan.nama_perusahaan, tb_temporary_perusahaan.kebutuhan, tb_temporary_perusahaan.kode_pekerjaan, tb_jenis_pekerjaan.nama_pekerjaan, tb_kategori_pekerjaan.nama_kategori
FROM tb_kerjasama_perusahan
LEFT JOIN tb_temporary_perusahaan ON tb_temporary_perusahaan.kode_perusahaan=tb_kerjasama_perusahan.kode_perusahaan
LEFT JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan=tb_temporary_perusahaan.kode_pekerjaan
LEFT JOIN tb_kategori_pekerjaan ON tb_kategori_pekerjaan.kode_kategori=tb_temporary_perusahaan.kebutuhan
WHERE tb_kerjasama_perusahan.nomor_kontrak = :kode AND tb_kategori_pekerjaan.kode_kategori = :kebutuhan";
$stmt = $data->runQuery($sql);
$stmt->execute(array(
    ':kode' => $id,
    ':kebutuhan' => $typeKebutuhan
));
    while ($row = $stmt->fetch(PDO::FETCH_LAZY))
                {
            # code...

            $noKontrak = $row['nomor_kontrak'];
            $jmlh_karyawan = $row['total_karyawan'];
            $kodeList = $row['kode_list_karyawan'];

            $cek = "SELECT kode_list_karyawan FROM tb_list_karyawan WHERE kode_list_karyawan = :kode";
            $tes = $data->runQuery($cek);
            $tes->execute(array(
                ':kode' => $kodeList
            ));

            //cek jika jumlah nilai spk sudah ada
            if ($tes->rowCount() == $jmlh_karyawan) {
            ?>
                <div class="col-md-6 col-lg-offset-3">
                    <div class="well">
                        <h4 class="text-danger">INFORMATION</h4>
                        <p>Total Jumlah Karyawan yang dibutuhkan untuk Nomor SPK <span class="label label-primary"><?php
                                echo $id;
                                ?></span> sudah terpenuhi!</p>
                        <hr>
                        <p>Silahkan untuk menginput <a href="?p=add-list-job&name=<?php
                            echo $id;
                            ?>"><span class="label label-danger"><strong>LIST PEKERJAAN</strong></span></a> Karyawan.</p>
                    </div>
                </div>
            <?php
            } else {
            if (!empty($row['kode_pekerjaan'])) {
            # code...
            //cek untuk available calon karyawan

            $kodePekerjaan = $row['kode_pekerjaan'];
            $dt = "SELECT tb_karyawan.no_ktp, tb_karyawan.no_NIK, tb_karyawan.nama_depan, tb_karyawan.nama_belakang,tb_karyawan.status, tb_apply_pekerjaan.kd_pekerjaan, tb_jenis_pekerjaan.nama_pekerjaan, tb_info_test.kode_test, tb_info_interview.kd_interview, tb_karyawan.nilai FROM tb_karyawan
               LEFT JOIN tb_apply_pekerjaan ON tb_apply_pekerjaan.no_ktp=tb_karyawan.no_ktp
               LEFT JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan=tb_apply_pekerjaan.kd_pekerjaan
               LEFT JOIN tb_info_test ON tb_info_test.no_ktp = tb_karyawan.no_ktp
               LEFT JOIN tb_info_interview ON tb_info_interview.no_ktp = tb_karyawan.no_ktp WHERE tb_karyawan.status = '' AND tb_apply_pekerjaan.kd_pekerjaan = :data ";
            $stmt = $data->runQuery($dt);
            $stmt->execute(array(
                ':data' => $row['kode_pekerjaan']
            ));
            if ($stmt->rowCount() == 0) {
            //jika hasil tidak ada untuk kategori pekerjaan
            ?>
            <div class="col-md-6 col-lg-offset-3">
                <div class="well">
                    <h4 class="text-danger"><strong>INFORMATION</strong></h4>
                    <p>Karyawan yang sesuai dengan posisi <span class="label label-primary"><?php
                            echo $row['nama_pekerjaan'];
                            ?></span> belum tersedia!</p>
                    <hr>
                    <p>Silahkan untuk membuat pengajuan request <a href=""><span
                                    class="label label-danger"><strong>LIST LOKER</strong></span></a> untuk posisi <span
                                class="label label-danger"><?php
                            echo $row['nama_pekerjaan'];
                            ?></span>.</p>
                </div>
            </div>
            <?php
            } else {
            ?>
            <h2>Pilih Karyawan</h2>
            <hr>
            <p>Select Karyawan untuk bekerja pada Perusahaan <strong><?php
                    echo $row['nama_perusahaan'];
                    ?></strong>
                dengan NOMOR KONTRAK <strong><?php
                    echo $row['nomor_kontrak'];
                    ?></strong>.
            </p>
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                    <tr class="headings">
                        <th class="column-title">Nomor KTP</th>
                        <th class="column-title">Nomor NIP</th>
                        <th class="column-title">Nama Karyawan</th>
                        <th class="column-title">Pekerjaan</th>
                        <th class="column-title">Hasil Ujian</th>
                        <th class="column-title">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = "SELECT tb_karyawan.no_ktp, tb_karyawan.no_NIK, tb_karyawan.nama_depan, tb_karyawan.nama_belakang,tb_karyawan.status, tb_apply_pekerjaan.kd_pekerjaan, tb_jenis_pekerjaan.nama_pekerjaan, tb_info_test.kode_test, tb_info_interview.kd_interview, tb_karyawan.nilai FROM tb_karyawan
                        LEFT JOIN tb_apply_pekerjaan ON tb_apply_pekerjaan.no_ktp=tb_karyawan.no_ktp
                        LEFT JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan=tb_apply_pekerjaan.kd_pekerjaan
                        LEFT JOIN tb_info_test ON tb_info_test.no_ktp = tb_karyawan.no_ktp
                        LEFT JOIN tb_info_interview ON tb_info_interview.no_ktp = tb_karyawan.no_ktp WHERE tb_karyawan.status = '' AND tb_apply_pekerjaan.kd_pekerjaan = :data ";
                    $stmt = $data->runQuery($query);
                    $stmt->execute(array(
                        ':data' => $row['kode_pekerjaan']
                    ));
                    if ($stmt->rowCount() == '0') {
                    # code...
                    ?>
                    <tr>
                        <td colspan="5">Data tidak ada</td>
                    </tr>
                    <?php
                    } else {
                    while ($col = $stmt->fetch(PDO::FETCH_LAZY)) {
                    # code...
                    if ($col['nilai'] == '1') {
                        $hasil = '<span class="label label-success">Lulus</span>';
                    } elseif ($col['nilai'] == '0') {
                        $hasil = '<span class="label label-danger">Gagal</span>';
                    } else {
                        $hasil = '<span class="label label-default">belum ujian</span>';
                    }

                    ?>
                    <tr class="even pointer">
                        <td><?php
                            echo $col['no_ktp'];
                            ?></td>
                        <td><?php
                            echo $col['no_NIK'];
                            ?></td>
                        <td>
                            <a href="?p=detail-karyawan&id=<?php
                            echo $col['no_ktp'];
                            ?>"><?php
                                echo $col['nama_depan'];
                                ?><?php
                                echo $col['nama_belakang'];
                                ?></a>
                        </td>
                        <td><?php
                            echo $col['nama_pekerjaan'];
                            ?></td>
                        <td><?php
                            echo $hasil;
                            ?></td>
                        <td>
                            <a href="php/ajx/add-karyawan.php?id=<?php
                            echo $col['no_NIK'];
                            ?>&kode=<?php
                            echo $row['nomor_kontrak'];
                            ?>&jml=<?php
                            echo $jmlh_karyawan;
                            ?>">
                                <button class="btn btn-xs btn-primary"><span class="fa fa-fw fa-plus"></span>
                                    Add
                                </button>
                            </a>
                        </td>
                    </tr>
                    <?php
                    }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
            }
            } else {

            $query = "SELECT tb_karyawan.no_ktp, tb_karyawan.no_NIK, tb_karyawan.nama_depan, tb_karyawan.nama_belakang,tb_karyawan.status, tb_apply_pekerjaan.kd_pekerjaan FROM tb_karyawan
               LEFT JOIN tb_apply_pekerjaan ON tb_apply_pekerjaan.no_ktp=tb_karyawan.no_ktp WHERE tb_karyawan.status = '' AND tb_apply_pekerjaan.kd_pekerjaan = :data";
            $stmt = $data->runQuery($query);
            $stmt->execute(array(
                ':data' => $row['kode_pekerjaan']
            ));

            ?>
            <div class="col-md-6 col-lg-offset-3">
                <div class="well">
                    <h4 class="text-danger" style="font-weight: bold;">INFORMATION</h4>
                    <p>Total Jumlah Karyawan yang dibutuhkan adalah <span
                                class="label label-primary"><?php
                            echo $row['total_karyawan'];
                            ?></span> belum terpenuhi!
                    </p>
                    <hr>
                    <p>Dikarenakan Calon Karyawan untuk posisi <span
                                class="label label-danger"><?php
                            echo $row['nama_kategori'];
                            ?></span> belum tersedia!</p>
                </div>
            </div>
            <?php
            }
            }
    }
?>