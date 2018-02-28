<?php
$kd = $_GET['name'];

    $cek = new Perusahaan();
    $sql = "SELECT * FROM tb_temporary_perusahaan WHERE no_pendaftaran = :id";
    $stmt = $cek->runQuery($sql);
    $stmt->execute(array(
        ':id'   =>$kd));

    $row = $stmt->fetch(PDO::FETCH_LAZY);

    $status = $row['status'];

    if ($status == '1')
    {
        print "<script>window.location='index.php?p=entrydata&name=".$row['kebutuhan']."/".$row['no_pendaftaran']."';</script>";

        $_SESSION['kodePendaftaran'] = $row['no_pendaftaran'];
    }
    elseif ($status == '0')
    {
        $id = "kode_perusahaan";
        $tbName = 'tb_perusahaan';
        $kode = "CUS-$kd-";


        $gen = new Perusahaan();
        $new = $gen->Generate($id, $kode, $tbName);


        if (isset($_POST['newCompany'])) {
            # code...
            $kodePerusahaan = $_POST['txt_kode'];
            $nama = $_POST['txt_nama'];
            $bidang = $_POST['txt_bidang'];
            $npwp = $_POST['txt_npwp'];
            $siup = $_POST['txt_siup'];
            $telp = $_POST['txt_telp'];
            $hp = $_POST['txt_hp'];
            $fax = $_POST['txt_fax'];
            $email = $_POST['txt_email'];
            $web = $_POST['txt_website'];
            $cp = $_POST['txt_cp'];
            $alamat = $_POST['txt_alamat'];
            $kel = $_POST['txt_kelurahan'];
            $kec = $_POST['txt_kecamatan'];
            $kota = $_POST['txt_kota'];

            $a = array($kodePerusahaan, $nama, $bidang, $npwp, $siup, $telp, $hp, $fax, $email, $web, $cp, $alamat, $kel, $kec, $kota);
            // echo "<pre>";
            // print_r($a);
            // echo "</pre>";
            $new_kode = explode('-', $kodePerusahaan);
            $new_kode = implode($new_kode);

            $query = "INSERT INTO tb_perusahaan (kode_perusahaan, nama_perusahaan, bidang_perusahaan, nomor_NPWP, nomor_SIUP, nomor_telp, nomor_hp, nomor_fax, email, website, contact_person, alamat, kelurahan, kecamatan, kota) VALUES (:kode, :nama, :bidang, :npwp, :siup, :telp, :hp, :fax, :email, :web, :cp, :alamat, :kel, :kec, :kota)";
            $input = $cek->runQuery($query);
            $input->execute(array(
                ':kode'     => $kodePerusahaan,
                ':nama'     => $nama,
                ':bidang'   => $bidang,
                ':npwp'     => $npwp,
                ':siup'     => $siup,
                ':telp'     => $telp,
                ':hp'       => $hp,
                ':fax'      => $fax,
                ':email'    => $email,
                ':web'      => $web,
                ':cp'       => $cp,
                ':alamat'   => $alamat,
                ':kel'      => $kel,
                ':kec'      => $kec,
                ':kota'     => $kota
            ));
            if (!$input) {
                # code...
                echo "DATA TIDAK MASUK KE DB.";
            }else{
                //will be generate password and usualy like 'admin123'
                $new_pass = password_hash($new_kode, PASSWORD_DEFAULT);

                $key = "INSERT INTO tb_login_perusahaan (kd_perusahaan, password, kode_password) VALUES (:idPerusahaan, :pwd, :kode)";
                $pwd = $cek->runQuery($key);
                $pwd->execute(array(
                    ':idPerusahaan' => $kodePerusahaan,
                    ':pwd'          => $new_pass,
                    ':kode'         => $new_kode
                    ));
                if (!$pwd) {
                    # code...
                    echo "TIDAK BERHASIL GENERATE CODE PASSWD";
                }else{

                        $statuss = "0";
                        $sql = "UPDATE tb_temporary_perusahaan SET kode_perusahaan = :id, status = :st WHERE no_pendaftaran = :kode";
                        $stmt = $cek->runQuery($sql);
                        $stmt->execute(array(
                            ':id'   => $kodePerusahaan,
                            ':st'   => $statuss,
                            ':kode' => $kd
                            ));
                        if (!$stmt) {
                               # code...
                            echo "tidak berhasil update tb_temporary_perusahaan";
                           }else{
                            //kirim id perusahaan dan password
                            print "<script>window.location='index.php?p=password';</script>";
                            session_start();
                            $_SESSION['kode'] = $kodePerusahaan;
                            $_SESSION['pwd']  = $new_kode;
                           }
                }

            }

        }
        ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Entry Data Perusahaan <small>New Company</small></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <form class="form-horizontal form-label-left" method="post" action="">

                    <br/>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Kode Perusahaan <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="txt_kode" value="<?php echo $new; ?>" type="text" readonly>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama Perusahaan <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="txt_nama" value="<?php echo $row['nama_perusahaan']; ?>" type="text">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Bidang Usaha <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="txt_bidang" placeholder="example: perbankan, jasa pelayanan, pengadaan barang, EO, .." type="text" required >
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Nomor NPWP Perusahan <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" id="number" name="txt_npwp" data-validate-length-range="15" class="form-control col-md-7 col-xs-12" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Nomor SIUP Perusahan <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" id="number" name="txt_siup" data-validate-length-range="15" class="form-control col-md-7 col-xs-12" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Telephone <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="tel" id="telephone" name="txt_telp" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Handphone">Handphone <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="tel" id="Handphone" name="txt_hp" value="<?php echo $row['phone']; ?>" class="form-control col-md-7 col-xs-12" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="FAX">FAX <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="tel" id="FAX" name="txt_fax" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="email" id="email" name="txt_email" class="form-control col-md-7 col-xs-12"  value="<?php echo $row['email']; ?>" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Website URL <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="website" name="txt_website" placeholder="www.website.com" class="form-control col-md-7 col-xs-12" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Contact Person <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="txt_cp" value="<?php echo $row['cp']; ?>" type="text" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Alamat Perusahaan <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea id="textarea" name="txt_alamat" class="form-control col-md-7 col-xs-12" required></textarea>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Kelurahan <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="txt_kelurahan" type="text" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Kecamatan <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="txt_kecamatan" type="text" required>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Kota <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="txt_kota" type="text" required>
                        </div>
                    </div>


                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">Cancel</button>
                            <button id="send" type="submit" name="newCompany" class="btn btn-success">Submit</button>
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
?>
