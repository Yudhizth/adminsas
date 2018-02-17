<?php
$id = $_GET['id'];
$data = new Admin();


    if (isset($_POST['addTest']))
    {
        $kode = $_POST['txt_kode'];
        $admin = $_POST['txt_admin'];
        $nama = $_POST['txt_nama'];
        $n = $_POST['txt_nilai'];
        if ($n == "0")
        {
            echo "<script>
            alert('GRADE is not NULL');
            window.location.href='?p=input-nilai&id=".$id."';
            </script>";
        } else
        {
            $query = "INSERT INTO tb_hasil_test (kd_test, nama_penilaian, nilai, kd_admin) VALUES (:kd, :nama, :nilai, :admin)";
            $sys = $data->runQuery($query);
            $sys->execute(array(
                ':kd'   => $kode,
                ':nama' => $nama,
                ':nilai'=> $n,
                ':admin'=> $admin
            ));
            if (!$sys){
                echo "data tidak masuk";
            } else {

            }
        }
    }elseif (isset($_POST['addInterview'])){
        $kode = $_POST['txt_kode'];
        $admin = $_POST['txt_admin'];
        $nama = $_POST['txt_nama'];
        $n = $_POST['txt_nilai'];
        if ($n == "0")
        {
            echo "<script>
            alert('GRADE is not NULL');
            window.location.href='?p=input-nilai&id=".$id."';
            </script>";
        } else
        {
            $query = "INSERT INTO tb_hasil_interview (kd_interview, nama_penilaian, nilai, kd_admin) VALUES (:kd, :nama, :nilai, :admin)";
            $sys = $data->runQuery($query);
            $sys->execute(array(
                ':kd'   => $kode,
                ':nama' => $nama,
                ':nilai'=> $n,
                ':admin'=> $admin
            ));
            if (!$sys){
                echo "data tidak masuk";
            } else {

            }
        }
    }elseif (isset($_POST['addNilai'])){
        $ktp = $_POST['txt_ktp'];
        $nil = $_POST['txt_nilai'];

        $ql = "UPDATE tb_karyawan SET nilai = :nilai WHERE no_ktp = :ktp";
        $ttm = $data->runQuery($ql);
        $ttm->execute(array(
                ':nilai' => $nil,
                ":ktp"   => $ktp
        ));
        if ($ttm){
            echo "<script>
        alert('Input Data Success!');
        window.location.href='?p=schedule-test';
        </script>";
        }
    }

    $sql ="SELECT tb_info_test.no_ktp, tb_info_test.kode_test, tb_info_interview.kd_interview FROM tb_info_test
            INNER JOIN tb_info_interview ON tb_info_interview.no_ktp = tb_info_test.no_ktp WHERE tb_info_test.no_ktp = :id";
    $stmt = $data->runQuery($sql);
    $stmt->execute(array(
        ':id'   => $id
    ));

    $info = $stmt->fetch(PDO::FETCH_LAZY);
    $test = $info['kode_test'];
    $interview = $info['kd_interview'];
?>

<div class="x_panel">
    <div class="well">
        <h5 class="page-header">KETENTUAN NILAI</h5>
        <p>GRADE nilai A = 4, B = 3, C = 2, D = 1. Penilaian untuk masing-masing kategori yaitu "total kriteria / banyaknya kriteria".</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title">
                <h2>Data Test <span class="small">hasil psikotes</span></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"></a>
                    <li><a class="collapse-link"></a>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <form class="form-inline" method="post" action="">
                    <div class="form-group">
                        <label class="sr-only" for="exampleInputEmail3">Email address</label>
                        <input type="text" name="txt_nama" class="form-control" id="exampleInputEmail3" placeholder="nama kriteria penilaian" required>
                        <input type="hidden" name="txt_kode" class="form-control" id="exampleInputEmail3" value="<?php echo $info['kode_test'];?>">
                        <input type="hidden" name="txt_admin" class="form-control" id="exampleInputEmail3" value="<?php echo $admin_id?>">
                    </div>
                    <div class="form-group">
                    <select name="txt_nilai" class="form-control">
                        <option value="0" selected>GRADE</option>
                        <option value="4">=> A</option>
                        <option value="3">=> B</option>
                        <option value="2">=> C</option>
                        <option value="1">=> D</option>
                    </select>
            </div>
                    <button type="submit" name="addTest" class="btn btn-sm btn-danger"><span class="fa fa-fw fa-plus"></span></button>
                </form>
                <br>
                <table class="table table-striped">
                    <thead>
                    <th>nama kriteria</th>
                    <th>grade</th>
                    <th>#</th>
                    </thead>
                    <tbody>
                    <?php
                        $qr = "SELECT id, nama_penilaian, nilai FROM tb_hasil_test WHERE kd_test = :kd";
                        $soq = $data->runQuery($qr);
                        $soq->execute(array(
                            ':kd'   => $test
                        ));
                        $data = array();
                       $sum = 0;
                        while ($row = $soq->fetch(PDO::FETCH_LAZY)){
                            $n = $row['nilai'];
                            $sum +=$n;
                            $data[] = $row;
                         ?>
                    <tr>
                        <td width="60%"><?php echo $row['nama_penilaian'];?></td>
                        <td width="20%"><?php echo $row['nilai'];?></td>
                        <td width="20%">
                            <a href="php/delete-nilai-test.php?kode=<?php echo $row['id'];?>&id=<?php echo $id;?>" onclick="return confirm('Are you sure you want to delete this item?');">
                                <button class="btn btn-xs btn-danger"><span class="fa fa-fw fa-trash"></span></button>
                            </a>
                        </td>
                    </tr>
                        <?php
                        }
                        $total = count($data);
                        if($sum != "0" && $total != "0"){
                        $hasil_test = @($sum/$total);
                        $total = @($sum/$total);
                        if($total > 0 && $total < 2){
                            $grade = "D";
                        } elseif($total >= 2 && $total < 3 ){
                            $grade = "C";
                        } elseif($total >= 3 && $total < 4){
                            $grade = "B";
                        } elseif($total = 4){
                            $grade = "A";
                        }else{
                            $grade = "null";
                        }
                        ?>
                    <tr>
                        <td>Total Nilai:</td>
                        <td><?php echo $sum; ?></td>
                        <td>GRADE: <?php echo $grade; ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php if(!empty($interview)){ ?>
        <div class="col-md-6">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Data Interview <span class="small">hasil interviews</span></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"></a>
                        <li><a class="collapse-link"></a>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <form class="form-inline" method="post" action="">
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputEmail3">Email address</label>
                            <input type="text" name="txt_nama" class="form-control" id="exampleInputEmail3" placeholder="nama kriteria penilaian" required>
                            <input type="hidden" name="txt_kode" class="form-control" id="exampleInputEmail3" value="<?php echo $info['kd_interview'];?>">
                            <input type="hidden" name="txt_admin" class="form-control" id="exampleInputEmail3" value="<?php echo $admin_id?>">
                        </div>
                        <div class="form-group">
                            <select name="txt_nilai" class="form-control">
                                <option value="0" selected>GRADE</option>
                                <option value="4">=> A</option>
                                <option value="3">=> B</option>
                                <option value="2">=> C</option>
                                <option value="1">=> D</option>
                            </select>
                        </div>
                        <button type="submit" name="addInterview" class="btn btn-sm btn-danger"><span class="fa fa-fw fa-plus"></span></button>
                    </form>
                    <br>
                    <table class="table table-striped">
                        <thead>
                        <th>nama kriteria</th>
                        <th>grade</th>
                        <th>#</th>
                        </thead>
                        <tbody>
                        <?php
                        $data = new Perusahaan;
                        $qr = "SELECT * FROM tb_hasil_interview WHERE kd_interview = :kd";
                        $soq = $data->runQuery($qr);
                        $soq->execute(array(
                            ':kd'   => $interview
                        ));
                        $data = array();
                        $sum = 0;
                        while ($row = $soq->fetch(PDO::FETCH_LAZY)){
                            $n = $row['nilai'];
                            $sum +=$n;
                            $data[] = $row;
                            ?>
                            <tr>
                                <td width="60%"><?php echo $row['nama_penilaian'];?></td>
                                <td width="20%"><?php echo $row['nilai'];?></td>
                                <td width="20%">
                                    <a href="php/delete-nilai-interview.php?kode=<?php echo $row['id'];?>&id=<?php echo $id;?>" onclick="return confirm('Are you sure you want to delete this item?');">
                                        <button class="btn btn-xs btn-danger"><span class="fa fa-fw fa-trash"></span></button>
                                    </a>
                                </td>
                            </tr>
                        <?php }
                        $total = count($data);
                        if($sum != "0" && $total != "0"){
                            $hasil_interview = @($sum/$total);
                            $total = @($sum/$total);
                            if(empty($total)){$grade = "null";}
                            if($total > 0 && $total < 2){
                                $grade = "D";
                            } elseif($total = 2 && $total < 3 ){
                                $grade = "C";
                            } elseif($total = 3 && $total < 4){
                                $grade = "B";
                            } elseif($total = 4){
                                $grade = "A";
                            }else{
                                $grade = "null";
                            }
                            ?>
                            <tr>
                                <td>Total Nilai:</td>
                                <td><?php echo $sum; ?></td>
                                <td>GRADE: <?php echo $grade; ?></td>
                            </tr>
                        <?php  } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target=".modal-psikolog">simpan nilai</button>
        </div>
    <?php } ?>
</div>


<div class="modal fade modal-psikolog" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="text-transform: uppercase;">simpan nilai</h4>
            </div>
            <form class="modal-body">

                <table class="table table-bordered">
                    <thead>
                    <th>Total Nilai Psikotes</th>
                    <th>Total Nilai Interviews</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php if(!empty($hasil_test)){echo $hasil_test;} ?></td>
                        <td><?php if(!empty($hasil_interview)){echo $hasil_interview;} ?></td>
                    </tr>
                    <?php
                        if (!empty($hasil_test) && !empty($hasil_interview)){
                    ?>
                    <tr>
                        <td colspan="2">Total Nilai: <?php $subtotal = ($hasil_test+$hasil_interview)/2; echo $subtotal; ?></td>
                    </tr>
                    <?php
                        if($subtotal > 0 && $subtotal < 2){
                            $grade_total = "D";
                        }elseif($subtotal >= 2 && $subtotal < 3){
                            $grade_total = "C";
                        }elseif($subtotal >= 3 && $subtotal < 4) {
                            $grade_total = "B";
                        }elseif($subtotal >= 4 && $subtotal <5 ) {
                            $grade_total = "A";
                        }else{
                            $grade_total = "null";
                        }
                    ?>
                    <tr>
                        <td colspan="2">GRADE TOTAL: <?php echo $grade_total; ?></td>
                    </tr>
                    <?php }?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-success btn-xs lulus" data-id="<?php echo $id; ?>" data-st="1" data-kode="KDKRY0015" > <i class="fa fa-check">
                    </i> Lulus</button>
                <button type="button" class="btn btn-danger btn-xs gagal" data-id="<?php echo $id; ?>" data-st="0" data-kode="KDKRY0016"> <i class="fa fa-close">
                    </i> Tidak Lulus</button>
            </div>

        </div>
    </div>
</div>
