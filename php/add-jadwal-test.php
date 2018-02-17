<?php
$id = $_GET['id'];
$jadwal = new Admin();
if (isset($_POST['addJadwal'])) {
    # code...
    $kodeTest = strip_tags($_POST['kode_test']);
    $ktp = strip_tags($_POST['no_ktp']);
    $kdAdmin = strip_tags($_POST['kode_admin']);
    $tanggalTest = strip_tags($_POST['tanggal']);
    $cv = strip_tags($_POST['txt_cv']);
    $kd_status = "KDKRY0003";

    $input = new Karyawan();
    $sql = "INSERT INTO tb_info_test (kode_test, no_ktp, date_test, kode_admin, keterangan) VALUES (:kode, :ktp, :tgl, :admin, :ket)";
    $stmt = $input->runQuery($sql);
    $stmt->execute(array(
        ':kode' => $kodeTest,
        ':ktp' => $ktp,
        ':tgl' => $tanggalTest,
        ':admin' => $kdAdmin,
        ':ket' => $cv
    ));
    if (!$stmt) {
        # code...
        echo "data tidak masuk";
    } else {

        $sql2 = "UPDATE tb_karyawan SET kd_status_karyawan = :kd_karyawan WHERE no_ktp = :ktp";
        $update = $config->runQuery($sql2);
        $update->execute(array(
            ':kd_karyawan' => $kd_status,
            ':ktp' => $ktp
        ));

        echo "<script>
    alert('Input Data Success!');
    window.location.href='?p=schedule-test';
    </script>";
    }
}
if (isset($_POST['addData'])) {
    # code...
    $kode_test = strip_tags($_POST['kode_test']);
    $kodeTest = strip_tags($_POST['no_id']);
    $kdAdmin = strip_tags($_POST['kode_admin']);
    $tanggalTest = strip_tags($_POST['tanggal']);
    $status = "";
    $cv = strip_tags($_POST['txt_cv']);
    $kd_status = "KDKRY0013";
    $input = new Karyawan();
    $stmt = $input->runQuery("UPDATE tb_info_test SET date_test = :tanggal, kode_admin = :admin, status = :st, keterangan = :ket WHERE id = :id");
    $stmt->execute(array(
        ':tanggal' => $tanggalTest,
        ':admin' => $kdAdmin,
        ':st' => $status,
        ':ket' => $cv,
        ':id' => $kodeTest));
    if (!$stmt) {
        # code...
        echo "data tidak masuk";
    } else {
        $sql2 = "UPDATE tb_karyawan SET kd_status_karyawan = :kd_karyawan WHERE no_ktp = :ktp";
        $update = $config->runQuery($sql2);
        $update->execute(array(
            ':kd_karyawan' => $kd_status,
            ':ktp' => $id
        ));
        echo "<script>
      alert('Update Success!');
      window.location.href='?p=schedule-test';
      </script>";
    }
}
$stmt = $jadwal->runQuery("SELECT * FROM tb_info_test WHERE no_ktp = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
if ($stmt->rowCount() == 0) {
    $sql = "SELECT * FROM tb_karyawan WHERE no_ktp = :id";
    $dt = $jadwal->runQuery($sql);
    $dt->execute(array(
        ':id' => $id
    ));
    while ($col = $dt->fetch(PDO::FETCH_LAZY)) {
        $id = "kode_test";
        $kode = "TESPSKT";
        $tbName = "tb_info_test";
        $kd = $jadwal->Generate($id, $kode, $tbName);
// ===========================================//
        ?>

        <div class="x_panel">
            <div class="x_title">
                <h2>Input Mask</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <form method="post" action="" class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Kode Test</label>
                        <div class="col-md-5 col-sm-5 col-xs-9">
                            <input name="kode_test" type="text" class="form-control" value="<?php echo $kd; ?>"
                                   readonly>
                            <input name="kode_admin" type="hidden" class="form-control"
                                   value="<?php echo $admin_id; ?>">
                            <input name="no_ktp" type="hidden" class="form-control"
                                   value="<?php echo $col['no_ktp']; ?>">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Calon Karyawan</label>
                        <div class="col-md-5 col-sm-5 col-xs-9">
                            <input name="nama_karyawan" type="text" class="form-control"
                                   value="<?php echo $col['nama_depan']; ?> <?php echo $col['nama_belakang']; ?>"
                                   readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Dokumen yang dibutuhkan</label>
                        <div class="col-md-5 col-sm-5 col-xs-9">
                            <div class="col-md-5 col-sm-5 col-xs-9">
                                <div class="checkbox">
                                    <label class="">
                                        <div class="icheckbox_flat-green" style="position: relative;">
                                            <input type="checkbox" name="txt_cv" value="cv" class="flat"
                                                   style="position: absolute; opacity: 0;">
                                            <ins class="iCheck-helper"
                                                 style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
                                            </ins>
                                        </div>
                                        CV Lengkap
                                    </label>
                                    <label class="">
                                        <div class="icheckbox_flat-green" style="position: relative;">
                                            <input type="checkbox" name="txt_kesehatan" value="surat kesehatan"
                                                   class="flat" style="position: absolute; opacity: 0;">
                                            <ins class="iCheck-helper"
                                                 style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
                                            </ins>
                                        </div>
                                        Surat Kesehatan
                                    </label>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Tanggal Test Psikolog</label>
                        <div class="col-md-5 col-sm-5 col-xs-9">
                            <div class="control-group">
                                <input type="text" class="form-control has-feedback-left" name="tanggal"
                                       id="datepsikotes" aria-describedby="inputSuccess2Status4">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="addJadwal" class="btn btn-success">Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>


        </div>

        </div>
        </div>
        </div>
        <?php
    }
} else {
    $stmt = $jadwal->runQuery("SELECT tb_karyawan.nama_depan, tb_karyawan.nama_belakang, tb_info_test.kode_test, tb_info_test.id, tb_info_test.date_test, tb_info_test.kode_admin FROM tb_info_test
    LEFT JOIN tb_karyawan ON tb_karyawan.no_ktp=tb_info_test.no_ktp
    WHERE tb_info_test.no_ktp = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_LAZY);

    ?>

    <div class="x_panel">
        <div class="x_title">
            <h2>Update Schedule</h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <br>
            <form method="post" action="" class="form-horizontal form-label-left">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Kode Test</label>
                    <div class="col-md-5 col-sm-5 col-xs-9">
                        <input name="kode_test" type="text" class="form-control"
                               value="<?php echo $row['kode_test']; ?>" readonly>
                        <input name="kode_admin" type="hidden" class="form-control" value="<?php echo $admin_id; ?>">
                        <input name="no_id" type="hidden" class="form-control" value="<?php echo $row['id']; ?>">

                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Calon Karyawan</label>
                    <div class="col-md-5 col-sm-5 col-xs-9">
                        <input name="nama_karyawan" type="text" class="form-control"
                               value="<?php echo $row['nama_depan']; ?> <?php echo $row['nama_belakang']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Dokumen yang dibutuhkan</label>
                    <div class="col-md-5 col-sm-5 col-xs-9">
                        <div class="checkbox">
                            <label class="">
                                <div class="icheckbox_flat-green" style="position: relative;">
                                    <input type="checkbox" name="txt_cv" value="cv" class="flat"
                                           style="position: absolute; opacity: 0;">
                                    <ins class="iCheck-helper"
                                         style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
                                    </ins>
                                </div>
                                CV Lengkap
                            </label>
                            <label class="">
                                <div class="icheckbox_flat-green" style="position: relative;">
                                    <input type="checkbox" name="txt_kesehatan" value="surat kesehatan" class="flat"
                                           style="position: absolute; opacity: 0;">
                                    <ins class="iCheck-helper"
                                         style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
                                    </ins>
                                </div>
                                Surat Kesehatan
                            </label>

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Tanggal Test Psikolog</label>
                    <div class="col-md-5 col-sm-5 col-xs-9">
                        <div class="control-group">
                            <input type="text" class="form-control has-feedback-left" name="tanggal" id="datepsikotes"
                                   aria-describedby="inputSuccess2Status4" value="<?php echo $row['date_test']; ?>">
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                        <button type="submit" name="addData" class="btn btn-success">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>


    </div>

    </div>
    </div>
    </div>
    <?php
} ?>
