<div class="x_panel">
    <div class="x_title">
      <h2><span class="fa fa-fw fa-list"></span> Perusahaan</h2>

      <div class="clearfix"></div>
    </div>
    <div class="x_content">

      <p>Perusahaan yang telah bergabung dengan SAS</p>

      <!-- start project list -->
      <table class="table table-striped projects">
        <thead>
          <tr>
            <th style="width: 1%">#</th>
            <th style="width: 20%">Nama Perusahaan</th>
            <th style="width: 20%">Bidang Usaha</th>
            <th style="width: 30%">Contact Person</th>
            <th style="width: 20%">Bergabung Sejak</th>
            <th style="width: 20%">#Action</th>
          </tr>
        </thead>
        <tbody>
        <?php
         $calon = new Karyawan();
$stmt = $calon->runQuery("SELECT * FROM tb_perusahaan ");
$stmt->execute();
?>
<tbody>
<?php
if ($stmt->rowCount() == '') {
  # code...
  ?>
  <tr>
      <td colspan="6">Data Tidak Ada</td>
  </tr>
  <?php
} else{
while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
  # code...
  ?>
      <tr class="even pointer">

          <td>#</td>
          <td class=" "><?php echo $row['nama_perusahaan']; ?></td>
          <td class=" "><?php echo $row['bidang_perusahaan']; ?></td>
          <td class=" "><?php echo $row['contact_person']; ?> | <?php echo $row['email']; ?></td>
          <td class=" "><?php echo $row['create_date']; ?></td>
          <td>
              <a href="?p=detail-perusahaan&name=<?php echo $row['kode_perusahaan']; ?>">
              <button type="button" class="btn btn-success btn-xs"> <i class="fa fa-eye">
              </i>  Info </button>
                </a>
                <a href="?p=list-project&id=<?php echo $row['kode_perusahaan']; ?>">
                <button type="button" class="btn btn-success btn-xs"> <i class="fa fa-eye">
                </i>  List Project</button>
                  </a>
          </td>

      </tr>
<?php } }?>
        </tbody>
      </table>
      <!-- end project list -->

    </div>
  </div>


