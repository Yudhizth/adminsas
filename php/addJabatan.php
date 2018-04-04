<?php

$sql = "SELECT * FROM `tb_list_jabatan` ORDER BY tb_list_jabatan.nama_jabatan ASC";
$stmt = $config->runQuery($sql);
$stmt->execute();

if (isset($_POST['addJabatan'])) {
  $admin_id = $config->adminID();
  $admin_id = $admin_id['id'];
    # code...
    $kd = $_POST['txt_kode'];
    $nm = $_POST['txt_nama'];
    $ket = $_POST['txt_ket'];

    $query = "INSERT INTO tb_list_jabatan (kode_jabatan, nama_jabatan, keterangan) VALUES (:kd, :nm, :ket)";
    $set = $config->runQuery($query);
    $set->execute(array(
        ':kd' => $kd,
        ':nm' => $nm,
        ':ket'=> $ket
    ));

    if(!$set){
        echo "<script>
        alert('Input Data Gagal!');
        window.location.href='?p=addJabatan';
        </script>";
    }else{
      $id_reff = $config->lastInsertID();
      $log = "INSERT INTO tb_log_event (id_reff, types, tables, ket, admin_id) VALUES (:a, :b, :c, :d, :e)";
      $log = $config->runQuery($log);
      $log->execute(array(
          ':a'    => $id_reff,
          ':b'    => '1',
          ':c'    => 'tb_list_jabatan',
          ':d'    => 'insert jabatan',
          ':e'    =>  $admin_id
      ));
        echo "<script>
        alert('Input Data Success!');
        window.location.href='?p=addJabatan';
        </script>";
    }
} else {




?>


<div class="clearfix"></div>

<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Daftar List Jabatan Project </h2>

      <div class="clearfix"></div>
    </div>

    <div class="x_content">
    <p><a class="text-danger" href="" data-toggle="modal" data-target="#addJabatan">Add Jabatan</a></p>
      <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
          <thead>
            <tr class="headings">
              <th class="column-title">#</th>
              <th class="column-title">Kode Jabatan </th>
              <th class="column-title">Nama Jabatan</th>
              <th class="column-title">Keterangan</th>
              <th class="column-title no-link last"><span class="nobr">Action</span>
              </th>
            </tr>
          </thead>
          <tbody>
          <?php
          $i = 1;
          while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
              ?>
            <tr class="even pointer">
              <td class=" "><?= $i++; ?></td>
              <td class=" "><?= $row['kode_jabatan']; ?></td>
              <td class=" "><?= $row['nama_jabatan']; ?></td>
              <td class=" "><?= $row['keterangan']; ?></td>
              <td>
                <a href="?p=setting-jabatan&del=<?= $row['kode_jabatan']; ?>">
                <button type="button" data-toggle="tooltip" data-placement="right" title="Remove" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this item?');">
                    <i class="fa fa-fw fa-minus-square"> </i>
                  </button>
                </a>
              </td>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      </div>
      </div>
      </div>



<!-- Modal -->
<div class="modal fade" id="addJabatan" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modal Header</h4>
         </div>
         <div class="modal-body">
            <form class="form-horizontal" action="" method="post">
               <div class="form-group">
                  <label class="control-label col-sm-4" for="email">Kode Jabatan:</label>
                  <div class="col-sm-8">
                     <input type="text" maxlength="5" class="form-control" id="email" placeholder="max 5digit random" name="txt_kode" required>
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-sm-4" for="pwd">Nama Jabatan</label>
                  <div class="col-sm-8">
                     <input type="text" class="form-control" id="pwd" placeholder="nama untuk jabatan" name="txt_nama" required>
                  </div>
               </div>
               <div class="form-group">
                  <label class="control-label col-sm-4" for="ket">Keterangan</label>
                  <div class="col-sm-8">
                    <textarea name="txt_ket" rows="8" id="ket" class="form-control" placeholder="keterangan jabatan"></textarea>
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-8">
                     <button type="submit" name="addJabatan" class="btn btn-default">Submit</button>
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>

          <?php } ?>
