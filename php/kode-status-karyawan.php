<?php

if (isset($_POST['addKodeKaryawan'])) {
  # code...
  $kode = $_POST['txt_kode'];
  $nama = $_POST['txt_nama'];

  $query="INSERT INTO tb_kode_status_karyawan (kd_id, nama_kode) VALUES (:id, :nama)";
  $stmt = $config->runQuery($query);
  $stmt->execute(array(
    ':id' => $kode,
    ':nama' => $nama
  ));

  if ($stmt) {
    # code...
    echo "<script>
    alert('Input Kode Berhasil!');
    window.location.href='?p=kode-status-karyawan';
    </script>";
  }
  else{
    echo "<script>
    alert('Input Kode Gagal!');
    window.location.href='?p=kode-status-karyawan';
    </script>";
  }

}

$id = "kd_id";
$kode = "KDKRY";
$tbName = "tb_kode_status_karyawan";
$kode_id = $config->Generate($id, $kode, $tbName);

$list_per_page = "28" ;

 $query = "SELECT * FROM tb_kode_status_karyawan ";
$sql = $config->paging($query, $list_per_page);
$stmt = $config->runQuery($sql);
$stmt->execute();
?>
<div class="x_panel">
    <div class="x_title">
      <h2><span class="fa fa-fw fa-list"></span> List Kode Karyawan</h2>
      <ul class="nav navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Settings 1</a>
            </li>
            <li><a href="#">Settings 2</a>
            </li>
          </ul>
        </li>
        <li><a class="close-link"><i class="fa fa-close"></i></a>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="col-md-12 col-sm-12 col-xs-12 text-center">
            <ul class="pagination pagination-split">
              <li><a href="#" data-toggle="modal" data-target="#addKodeKaryawan" >Add Kode Karyawan</a></li>
            </ul>
          </div>

          <div class="clearfix"></div>

      <div class="row">
        <?php while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
            ?>
        <div class="col-md-3 col-sm-3 col-xs-6" style="margin-bottom: 1%;"> 
          <div class="btn-group btn-block">
            <button type="button" class="btn btn-default" style="text-transform: capitalize;"><?=$row['nama_kode']?></button>
            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a><?=$row['kd_id']?></a>
                </li>
              <li>
                <a onClick="return confirm('Yakin Kode akan dihapus?')" href="php/delete-kode-status-karyawan.php?id=<?=$row['kd_id']?>">Delete</a>
              </li>
            </ul>
          </div>
        </div>
        <?php } ?>
      </div>

      
      
      <?php
        
        $stmt = $config->paginglink($query, $list_per_page);

        
        ?>
      <!-- end project list -->

    </div>
  </div>

  <!-- Modal -->
<div class="modal fade" id="addKodeKaryawan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
<div class="modal-content">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title" id="myModalLabel"><span class="fa fa-users"></span> Add Kode Karyawan Baru</h4>
  </div>
  <div class="modal-body">

    <form method="post" action="">
      <div class="form-group">
        <label for="exampleInputPassword1">Nama Kode Karyawan</label>
        <input name="txt_kode" type="hidden" class="form-control" value="<?=$kode_id?>">
        <input name="txt_nama" type="text" class="form-control" minlength="3" id="exampleInputPassword1" placeholder=". . . . . . . ." required>
      </div>

      <button type="submit" name="addKodeKaryawan" class="btn btn-default">Submit</button>
    </form>

  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">Close</button>
  </div>

</div>    
  </div>
</div>