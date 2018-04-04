<?php

if (isset($_POST['addList'])) {
  # code...
  date_default_timezone_set('Asia/Jakarta');
  $kode_kontrak = $_POST['txt_kontrak'];
  $tugas = $_POST['txt_tugas'];
  $deks = $_POST['txt_deskripi'];
  $keterangan = $_POST['txt_jwb'];
  $admin = $_POST['txt_admin'];
  $tgl = date('d-m-Y');

  $list_tugas = explode('#', $tugas);

  $data = new Admin();

  $id = "kode_detail_job";
  $kode = "LISTJB";
  $tbName = "tb_list_job";

  $kode = $data->Generate($id, $kode, $tbName);

  $sql = "UPDATE tb_job SET kode_detail_job = :kode2 WHERE nomor_kontrak = :kontrak";
  $stmt = $data->runQuery($sql);
  $stmt->execute(array(
    ':kode2' => $kode,
    ':kontrak' =>$kode_kontrak));
  if ($stmt) {
    # code...
    $sql2 = "SELECT * FROM tb_job WHERE nomor_kontrak = :nomor ";
    $stmt = $data->runQuery($sql2);
    $stmt->execute(array(
      ':nomor'  => $kode_kontrak));
  } else {
    echo "data tidak masuk";
  }

  $col = $stmt->fetch(PDO::FETCH_LAZY);

  $kode_list = $col['kode_detail_job'];

  foreach ($list_tugas as $key) {
    # code...
    $sql3 = "INSERT INTO tb_list_job (kode_detail_job, nama_job, deskripsi_job, keterangan, kode_admin) VALUES (:kode, :nama, :desk, :ket, :admin)";
    $stmt = $data->runQuery($sql3);
    $stmt->execute(array(
      ':kode' => $kode_list,
      ':nama' => $key,
      ':desk' => $deks,
      ':ket'  => $keterangan,
      ':admin' => $admin));
  }
  if (!$stmt) {
    
    # code..
    echo "Data Tidak masuk";
  }else{
    $id_reff = $config->lastInsertID();
  }
}
?>
<div class="clearfix">
  <div class="page-title">
    <div class="title_left">
      <h3 class="page-header">Tambah Pekerjaan</h3>
    </div>

    <div class="title_right">
      <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search for...">
          <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-6">
    <table class="table table-bordered">
        <thead>
          <tr>
            <th>Jenis Kerjasama</th>
            <th>Kategori</th>
            <th>Perusahaan</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          
          
        
      <?php 

        $dt = new Admin();
        $sql = "SELECT tb_temporary_perusahaan.no_pendaftaran, tb_temporary_perusahaan.kode_perusahaan, tb_temporary_perusahaan.nama_perusahaan, tb_temporary_perusahaan.cp, tb_temporary_perusahaan.phone, tb_temporary_perusahaan.email, tb_temporary_perusahaan.create_date, tb_temporary_perusahaan.kd_status, tb_temporary_perusahaan.tanggal, tb_temporary_perusahaan.status, tb_jenis_pekerjaan.nama_pekerjaan, tb_kategori_pekerjaan.nama_kategori, tb_status_request.nama_status FROM tb_temporary_perusahaan
            LEFT JOIN tb_jenis_pekerjaan ON tb_jenis_pekerjaan.kd_pekerjaan=tb_temporary_perusahaan.kode_pekerjaan
            LEFT JOIN tb_kategori_pekerjaan ON tb_kategori_pekerjaan.kode_kategori=tb_temporary_perusahaan.kebutuhan
            LEFT JOIN tb_status_request ON tb_status_request.kd_stat=tb_temporary_perusahaan.kd_status
            ORDER BY tb_temporary_perusahaan.create_date DESC";
        $stmt = $dt->runQuery($sql);
        $stmt->execute();

        while ( $row = $stmt->fetch(PDO::FETCH_LAZY)) {
          # code...
          ?>
          <tr>
            <td><?php echo $row['nama_kategori']; ?></td>
            <td><?php echo $row['nama_pekerjaan']; ?></td>
            <td><?php echo $row['nama_perusahaan']; ?></td>
            <td>
              <button class="btn btn-sm btn-danger"><span class="fa fa-fw fa-plus"></span></button>
            </td>
          </tr>
          <?php
        }
      ?>
      </tbody>
      </table>
    </div>
    <div class="col-md-6">
      <div class="panel">
        <div class="panel-body">
            <?php
              $data  = new Admin();
              $sql = "SELECT * FROM tb_karyawan";
              $stmt = $data->runQuery($sql);
              $stmt->execute();

              while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
                 # code...
                ?>
            <div class="col-md-6">
                <li class="media event">
                  <a class="pull-left border-green profile_thumb">
                    <i class="fa fa-user green"></i>
                  </a>
                  <div class="media-body">
                    <a class="title" href="#"><?php echo $row['nama_depan']; ?> <?php echo $row['nama_belakang']; ?></a>
                    <p><strong><?php echo $row['no_NIK']; ?> </strong> Agent Avarage Sales </p>
                    <p> <small>12 Sales Today</small>
                    </p>
                  </div>
                </li>
              </div>
                <?php
               } 
            ?>

        </div>
      </div>
    </div>
  </div>
            
</div>

<div class="row">
  <div class="col-md-12">
    <div class="col-md-6">
      
      <div class="x_content">

  <!-- start accordion -->
  <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">

  <?php 
    $sql = "SELECT tb_kerjasama_perusahan.nomor_kontrak, tb_kerjasama_perusahan.kode_perusahaan, tb_kerjasama_perusahan.kode_admin,  tb_kerjasama_perusahan.deskripsi, tb_kerjasama_perusahan.tugas, tb_kerjasama_perusahan.tanggung_jwb, tb_kerjasama_perusahan.penempatan, tb_kerjasama_perusahan.tgl_input, tb_perusahaan.nama_perusahaan FROM tb_kerjasama_perusahan
LEFT JOIN tb_perusahaan ON tb_perusahaan.kode_perusahaan=tb_kerjasama_perusahan.kode_perusahaan";
    $stmt = $dt->runQuery($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
      # code...
      $list = explode('#', $row['tugas']);


    
  ?>
    
    <div class="panel">
      <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $row['kode_perusahaan']; ?>" aria-expanded="false" aria-controls="<?php echo $row['kode_perusahaan']; ?>">
        <h4 class="panel-title"><?php echo $row['nama_perusahaan']; ?></h4>
      </a>
      <div id="<?php echo $row['kode_perusahaan']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
        <div class="panel-body">
          <p><strong><?php echo $row['nama_perusahaan']; ?> dan <?php echo $row['nomor_kontrak']; ?></strong>
          </p>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>List Pekerjaan</th>
                
              </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            foreach ($list as $key) {
              # code...
            $i++;
             ?>
              <tr>
                
                <td><?php echo $i; ?></td>
                <td><?php echo $key; ?> </td>
              </tr>
              <?php }?>
            </tbody>
          </table>
           <hr>
           <form method="post" action="">
              <input type="hidden" name="txt_kontrak" value="<?php echo $row['nomor_kontrak']; ?>">
              <input type="hidden" name="txt_tugas" value="<?php echo $row['tugas']; ?>">
              <input type="hidden" name="txt_deskripi" value="<?php echo $row['deskripsi']; ?>">
              <input type="hidden" name="txt_jwb" value="<?php echo $row['tanggung_jwb']; ?>">
              <input type="hidden" name="txt_admin" value="<?php echo $row['kode_admin']; ?>">
              <button class="btn btn-xs btn-primary" type="submit" name="addList">
      <span class="fa fa-fw fa-plus"></span> Add List
    </button>
           </form>
    
        </div>
      </div>

    </div>

    <?php } ?>
    

   

</div>


    </div>
  </div>
</div>
             



<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Penambahan List Pekerjaan</h4>
                        </div>
                        <div class="modal-body">
                          <form class="form form-horizontal">
                            
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>

                      </div>
  </div>
</div> 
          



