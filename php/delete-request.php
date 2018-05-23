<?php
include_once '../config/api.php';
$delete = new Perusahaan();
	$id = $_GET['id'];
	$sql = "DELETE FROM tb_temporary_perusahaan WHERE no_pendaftaran=:id";
	$stmt = $delete->runQuery($sql);
	$stmt->execute(array(
		':id'	=>$id));
	if (!$stmt) {
		# code...
		echo "Data Tidak berhasil di hapus.";
	}else{
		$query ="DELETE FROM tb_list_perkerjaan_perusahaan WHERE code = :id";
		$stmt = $delete->runQuery($query);
		$stmt->execute(array(':id' => $id));
		if (!$stmt) {
			# code...
			echo " Data list tidak terhapuskan!";
		}else{
			header('Location: ../index.php?p=entry-data');
		}

	}


?>
