<?php


$sql1 = "SELECT tb_karyawan.no_ktp, tb_karyawan.no_NIK, tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.jenis_kelamin, tb_kode_status_karyawan.nama_kode FROM tb_karyawan 
INNER JOIN tb_kode_status_karyawan ON tb_kode_status_karyawan.kd_id = tb_karyawan.kd_status_karyawan
WHERE tb_karyawan.kd_status_karyawan IN ('KDKRY0006', 'KDKRY0008', 'KDKRY0009', 'KDKRY0010', 'KDKRY0015')";
// $sql1 = 'SELECT * FROM tb_karyawan WHERE no_NIK !="" AND kd_status_karyawan LIKE :arrayData';


$karyawanAvailable = $config->runQuery($sql1);
$karyawanAvailable->execute();

$stmt = $config->runQuery("SELECT tb_list_karyawan.kode_list_karyawan, tb_list_karyawan.no_nip, tb_list_karyawan.kode_pekerjaan, tb_list_karyawan.status_karyawan, tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.kode_perusahaan, tb_kerjasama_perusahan.kontrak_start, tb_kerjasama_perusahan.kontrak_end, tb_perusahaan.nama_perusahaan, tb_perusahaan.bidang_perusahaan, tb_temporary_perusahaan.kebutuhan, tb_kategori_pekerjaan.nama_kategori,
tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_karyawan.jenis_kelamin
FROM tb_list_karyawan INNER JOIN tb_kerjasama_perusahan ON tb_kerjasama_perusahan.kode_list_karyawan = tb_list_karyawan.kode_list_karyawan
INNER JOIN tb_perusahaan ON tb_perusahaan.kode_perusahaan = tb_kerjasama_perusahan.kode_perusahaan
INNER JOIN tb_temporary_perusahaan ON tb_temporary_perusahaan.no_pendaftaran = tb_kerjasama_perusahan.kode_request
INNER JOIN tb_karyawan ON tb_list_karyawan.no_nip = tb_karyawan.no_ktp
LEFT JOIN tb_kategori_pekerjaan ON tb_kategori_pekerjaan.kode_kategori = tb_temporary_perusahaan.kebutuhan WHERE tb_list_karyawan.status_karyawan = '2'");
$stmt->execute();

?>

<div class="x_panel">
    <div class="x_title">
        <h2>Data Perusahaan</h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="col-md-12">


            <br/>

            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab"
                                                              data-toggle="tab" aria-expanded="true">Karyawan
                            Available</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab"
                                                        data-toggle="tab" aria-expanded="false">Karyawan Dalam
                            Project</span></a>
                    </li>
                </ul>

                <div id="daftarKaryawan">
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane active fade in" id="tab_content1" aria-labelledby="home-tab">

                            <!-- start recent activity -->
                            <ul class="messages">
                                <div class="table-responsive">
                                    <table class="table table-striped jambo_table bulk_action">
                                        <thead>
                                        <tr class="headings">
                                            <th class="column-title" width="20%">Nomor NIP</th>
                                            <th class="column-title" width="30%">Nama Karyawan</th>
                                            <th class="column-title" width="30%">Jenis Kelamin</th>
                                            <th class="column-title" width="30%">Status Karyawan</th>
                                            <th class="column-title" width="20%">Action</th>
                                        </tr>
                                        </thead>
                                        <?php while ($data = $karyawanAvailable->fetch(PDO::FETCH_LAZY)) { ?>
                                        <tbody>
                                        <tr class="even pointer">


                                            <td class="col-md-2"
                                                style="text-transform: uppercase;"><?= $data['no_ktp'] ?></td>
                                            <td class="col-md-2"><?= $data['nama_depan'] ?> <?= $data['nama_belakang'] ?></td>
                                            <td><?= $data['jenis_kelamin'] ?></td>
                                            <td class="col-md-2">
                                            <span class="label label-success"
                                                  style="font-size: 12px; text-transform: capitalize;"><?= $data['nama_kode'] ?></span>
                                            </td>
                                            <td class="col-md-2">
                                                <a href="?p=detail-karyawan&id=<?= $data['no_ktp']; ?>">
                                                    <button type="button" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-user"> </i> View Profile
                                                    </button>
                                                </a>
                                                <button type="button" data-toggle="tooltip"
                                                        data-ktp="<?= $data['no_ktp'] ?>" data-placement="right"
                                                        title="Add NIP"
                                                        class="btn btn-info btn-xs tambahNIP"
                                                        onclick="return confirm('Are you sure you want to add?');">
                                                    <i class="fa fa-fw fa-plus-square"> </i>
                                                </button>
                                            </td>

                                        </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </ul>
                            <!-- end recent activity -->

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                            <!-- start user projects -->

                            <ul class="messages">
                                <div class="table-responsive">
                                    <table class="table table-striped jambo_table bulk_action">
                                        <thead>
                                        <tr class="headings">
                                            <th class="column-title" width="10%">Nama Karyawan</th>
                                            <th class="column-title" width="5%">JK</th>
                                            <th class="column-title" width="15%">Nama Perusahaan</th>
                                            <th class="column-title" width="10%">Bidang Usaha</th>
                                            <th class="column-title" width="10%">Nama Project</th>
                                            <th class="column-title" width="10%">Nomor Kontrak</th>
                                            <th class="column-title" width="10%">Timeplan</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($stmt->rowCount() == '') {
                                            # code...
                                            ?>
                                            <tr>
                                                <td colspan="7">Data Tidak Ada</td>
                                            </tr>
                                            <?php
                                        } else {
                                            while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
                                                # code...
                                                ?>
                                                <tr class="even pointer">


                                                    <td class="col-md-2"><a target="_blank" href="?p=detail-karyawan&id=<?=$row['no_nip']?>"><?php echo $row['nama_depan']; ?> <?= $row['nama_belakang'] ?></a></td>
                                                    <td class="col-md-1"><?php echo $row['jenis_kelamin']; ?></td>
                                                    <td class="col-md-2"><?php echo $row['nama_perusahaan']; ?></td>
                                                    <td class="col-md-2"><?php echo $row['bidang_perusahaan']; ?></td>
                                                    <td class="col-md-2"><?php echo $row['nama_kategori']; ?></td>
                                                    <td class="col-md-1"><?php echo $row['nomor_kontrak']; ?></td>
                                                    <td class="col-md-2"><?php echo $row['kontrak_start']; ?>
                                                        ~ <?= $row['kontrak_end'] ?></td>

                                                </tr>
                                            <?php }
                                        } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </ul>


                            <!-- end user projects -->

                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</div>
