<?php
session_start();
require '../config/api.php';

if(isset($_GET['id'])){
	$no_ktp = $_GET['id'];

	
}else{

	$no_ktp = "";
}



$sql = "SELECT year(curdate()) - year(str_to_date(tgl_lahir,'%d-%m-%Y')) as age, no_ktp, no_NIK, nama_depan, nama_belakang, jenis_kelamin, email, nomor_hp, nomor_telp, tempat_lahir, tgl_lahir, nama_suku, agama, tinggi_badan, berat_badan, no_NPWP, no_BPJS, nomor_sim, jenis_sim, status_perkawinan, status_tempat_tinggal, foto, hobi, alamat, kelurahan, kecamatan, kota, keperibadian, menghire, status, nilai FROM tb_karyawan WHERE no_ktp = :ktp";
$config = new Admin();

$stmt = $config->runQuery($sql);
$stmt->execute(array(':ktp' => $no_ktp));

$info = $stmt->fetch(PDO::FETCH_LAZY);
$admin_id = $config->adminID();
$admin_id = $admin_id['id'];
$log = "INSERT INTO tb_log_event (id_reff, types, tables, ket, admin_id) VALUES (:a, :b, :c, :d, :e)";
                        $log = $config->runQuery($log);
                        $log->execute(array(
                            ':a'    => $no_ktp,
                            ':b'    => '2',
                            ':c'    => 'unset',
                            ':d'    => 'export data karyawan',
                            ':e'    =>  $admin_id
                        ));

if ($info['foto'] != "") {
  # code...
  $dataFoto = $info['foto'];
}else{
  $dataFoto = "https://renderman.pixar.com/assets/camaleon_cms/image-not-found-4a963b95bf081c3ea02923dceaeb3f8085e1a654fc54840aac61a57a60903fef.png";
}
?>
<link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
body{
	text-transform: capitalize;
}
</style>
<!-- onload="window.print()" -->
<body onload="window.print()">

	<div class="panel panel-body">
		<div class="table-responsive">
			<table class="table">
				<tr style="background-color: #ebebeb">
					<td colspan="4">data informasi primer</td>
				</tr>
				<tr>
					<td width="30%" rowspan="6">
						<img class="img-responsive img-rounded" width="40%" style="margin-left: 50%;" src="<?=$dataFoto?>">
					</td>
				</tr>
				<tr width="70%">
					<td width="20%">nomor NIP</td>
					<td width="10%">:</td>
					<td width="70%"><?=$info['no_ktp']?></td>
				</tr>
				<tr width="70%">
					<td width="20%">Nama Lengkap</td>
					<td width="10%">:</td>
					<td width="70%"><?=$info['nama_depan']?> <?=$info['nama_belakang']?></td>
				</tr>
				<tr width="70%" >
					<td width="20%">TTL</td>
					<td width="10%">:</td>
					<td width="70%"><?=$info['tempat_lahir']?>, <?=$info['tgl_lahir']?> <b>(<?=$info['age']?>)</b></td>
				</tr>
				<tr width="70%">
					<td width="20%">Jenis Kelamin</td>
					<td width="10%">:</td>
					<td width="70%"><?=$info['jenis_kelamin']?></td>
				</tr>
				<tr width="70%">
					<td width="20%">Alamat</td>
					<td width="10%">:</td>
					<td width="70%"><?=$info['alamat']?>, <?=$info['kelurahan']?>, <?=$info['kecamatan']?>, <?=$info['kota']?></td>
				</tr>

			</table>
			<br>
			<table class="table">
				<tr>
					<td>
						<table class="table">
							<tr width="100%">
								<td width="50%">Nomor HP</td>
								<td width="50%">: <?=$info['nomor_hp']?></td>
							</tr>
							<tr width="100%">
								<td width="50%">Nomor Telp</td>
								<td width="50%">: <?=$info['nomor_telp']?></td>
							</tr>
							<tr width="100%">
								<td width="50%">Email</td>
								<td width="50%">: <?=$info['email']?></td>
							</tr>
							<tr width="100%">
								<td width="50%">Nomor SIM</td>
								<td width="50%">: <?=$info['nomor_sim']?> <b>(<?=$info['jenis_sim']?>)</b></td>
							</tr>
						</table>
					</td>
					<td>
						<table class="table">
							<tr width="100%">
								<td width="50%">Status Perkawinan</td>
								<td width="50%">: <?=$info['status_perkawinan']?></td>
							</tr>
							<tr width="100%">
								<td width="50%">Nama Suku</td>
								<td width="50%">: <?=$info['nama_suku']?></td>
							</tr>
							<tr width="100%">
								<td width="50%">Tinggi Badan</td>
								<td width="50%">: <?=$info['tinggi_badan']?></td>
							</tr>
							<tr width="100%">
								<td width="50%">Berat Badan</td>
								<td width="50%">: <?=$info['berat_badan']?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table class="table">
				<tr>
					<td>
						<table class="table">
							<tr width="100%">
								<td width="50%">Nomor NPWP</td>
								<td width="50%">: <?=$info['no_NPWP']?></td>
							</tr>
							<tr width="100%">
								<td width="50%">Nomor BPJS</td>
								<td width="50%">: <?=$info['no_BPJS']?></td>
							</tr>
							<tr width="100%">
								<td width="50%">Status Tempat Tinggal</td>
								<td width="50%">: <?=$info['status_tempat_tinggal']?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table class="table">
				<tr>
					<td width="30%">Hobi</td>
					<td width="70">: <?=$info['hobi']?></td>
				</tr>
				<tr>
					<td width="30%">Kepribadian</td>
					<td width="70">: <?=$info['keperibadian']?></td>
				</tr>
				<tr>
					<td width="30%">Alasan Menghire</td>
					<td width="70">: <?=$info['menghire']?></td>
				</tr>
			</table>
			<br>
			<?php 
			$query = "SELECT * FROM tb_info_keluarga WHERE no_ktp = :ktp";
			$stmt = $config->runQuery($query);
			$stmt->execute(array(':ktp' => $no_ktp));

			$countKeluarga = $stmt->rowCount();

			if ($countKeluarga > 0) {


			?>
			<table class="table table-bordered" style="margin-top: 25px;">
				<tr class="info">
					<td colspan="6"><b>data informasi sekunder</b></td>
				</tr>
				<tr style="background-color: #000; color: #fff;">
					<td colspan="6">Informasi Keluarga</td>
				</tr>
				<tr style="background-color: #ebebeb; color: #000;">
					<td><b>Nama Lengkap</b></td>
					<td><b>Hubungan</b></td>
					<td><b>L / P</b></td>
					<td><b>Pendidikan</b></td>
					<td><b>Pekerjaan</b></td>
					<td><b>Nomor Telp</b></td>
				</tr>
				<?php while ($pendidikan = $stmt->fetch(PDO::FETCH_LAZY) ) { ?>
					<tr>

						<td><?=$pendidikan['nama_lengkap']?></td>
						<td><?=$pendidikan['status_keluarga']?></td>
						<td><?=$pendidikan['jenis_kelamin']?></td>
						<td><?=$pendidikan['pendidikan']?></td>
						<td><?=$pendidikan['pekerjaan']?></td>
						<td><?=$pendidikan['nomor_handphone']?></td>

					</tr>
					<?php } }else {} ?>
				</table>

				<?php 
				$query = "SELECT * FROM tb_info_pendidikan WHERE no_ktp = :ktp";
				$stmt = $config->runQuery($query);
				$stmt->execute(array(':ktp' => $no_ktp));
				$countPendidikan = $stmt->rowCount();

				if ($countPendidikan > 0) {
				?>
				<table class="table table-bordered" style="margin-top: 25px;">
					<tr style="background-color: #000; color: #fff;">
						<td colspan="6">Informasi Pendidikan</td>
					</tr>
					<tr style="background-color: #ebebeb; color: #000;">
						<td><b>Tingkat</b></td>
						<td><b>Nama Badan</b></td>
						<td><b>Jurusan</b></td>
						<td><b>Tahun Masuk</b></td>
						<td><b>Tahun Lulus</b></td>
						<td><b>Nilai</b></td>
					</tr>
					<?php while ($pendidikan = $stmt->fetch(PDO::FETCH_LAZY) ) { ?>
						<tr>

							<td><?=$pendidikan['tingkat']?></td>
							<td><?=$pendidikan['nama_bapen']?></td>
							<td><?=$pendidikan['jurusan']?></td>
							<td><?=$pendidikan['tahun_masuk']?></td>
							<td><?=$pendidikan['tahun_lulus']?></td>
							<td><?=$pendidikan['nilai']?></td>

						</tr>
						<?php } } else {} ?>
					</table>

					<?php 
					$query = "SELECT * FROM tb_info_pekerjaan WHERE no_ktp = :ktp";
					$stmt = $config->runQuery($query);
					$stmt->execute(array(':ktp' => $no_ktp));
					if ($stmt->rowCount() < 1) {
			# code...
					}else{

						?>
						<table class="table table-bordered" style="margin-top: 25px;">
							<tr style="background-color: #000; color: #fff;">
								<td colspan="6">Informasi Pekerjaan</td>
							</tr>
							<tr style="background-color: #ebebeb; color: #000;">
								<td><b>Nama Perusahaan</b></td>
								<td><b>Tahun Masuk</b></td>
								<td><b>Tahun Keluar</b></td>
								<td><b>Jabatan</b></td>
								<td><b>Gaji</b></td>
								<td><b>Alasan Berhenti</b></td>
							</tr>
							<?php while ($pendidikan = $stmt->fetch(PDO::FETCH_LAZY) ) { ?>
								<tr>

									<td><?=$pendidikan['nama_perusahaan']?></td>
									<td><?=$pendidikan['tahun_masuk']?></td>
									<td><?=$pendidikan['tahun_keluar']?></td>
									<td><?=$pendidikan['jabatan']?></td>
									<td><?=$pendidikan['gaji']?></td>
									<td><?=$pendidikan['alasan_berhenti']?></td>

								</tr>
								<?php }
							} ?>
						</table>

						<?php 
						$query = "SELECT * FROM tb_info_referensi WHERE no_ktp = :ktp";
						$stmt = $config->runQuery($query);
						$stmt->execute(array(':ktp' => $no_ktp));
						if ($stmt->rowCount() < 1) {
			# code...
						}else{
							?>
							<table class="table table-bordered" style="margin-top: 25px;">
								<tr style="background-color: #000; color: #fff;">
									<td colspan="4">Informasi Referensi</td>
								</tr>
								<tr style="background-color: #ebebeb; color: #000;">
									<td><b>Nama Lengkap</b></td>
									<td><b>Jabatan</b></td>
									<td><b>Nomor HP</b></td>
									<td><b>Hubungan</b></td>
								</tr>
								<?php while ($pendidikan = $stmt->fetch(PDO::FETCH_LAZY) ) { ?>
									<tr>

										<td><?=$pendidikan['nama_lengkap']?></td>
										<td><?=$pendidikan['jabatan']?></td>
										<td><?=$pendidikan['nomor_hp']?></td>
										<td><?=$pendidikan['hubungan']?></td>

									</tr>
									<?php } } ?>
								</table>

								<?php 
								$query = "SELECT * FROM tb_info_bahasa WHERE no_ktp = :ktp";
								$stmt = $config->runQuery($query);
								$stmt->execute(array(':ktp' => $no_ktp));
								if ($stmt->rowCount() < 1) {
			# code...
								}else{

									?>
									<table class="table table-bordered" style="margin-top: 25px;">
										<tr style="background-color: #000; color: #fff;">
											<td colspan="6">Informasi Pengusaan Bahasa</td>
										</tr>
										<tr style="background-color: #ebebeb; color: #000;">
											<td><b>Nama Bahasa</b></td>
											<td><b>Writing</b></td>
											<td><b>Listening</b></td>
											<td><b>Speaking</b></td>
										</tr>
										<?php while ($pendidikan = $stmt->fetch(PDO::FETCH_LAZY) ) { ?>
											<tr>

												<td><?=$pendidikan['nama_bahasa']?></td>
												<td><?=$pendidikan['writing']?></td>
												<td><?=$pendidikan['listening']?></td>
												<td><?=$pendidikan['speaking']?></td>

											</tr>
											<?php }
										} ?>
									</table>

									<?php 
									$query = "SELECT * FROM tb_info_keahlian WHERE no_ktp = :ktp";
									$stmt = $config->runQuery($query);
									$stmt->execute(array(':ktp' => $no_ktp));
									if ($stmt->rowCount() < 1) {
			# code...
									}else{

										?>
										<table class="table table-bordered" style="margin-top: 25px;">
											<tr style="background-color: #000; color: #fff;">
												<td colspan="6"><b>Informasi Keahlian</b></td>
											</tr>
											<tr style="background-color: #ebebeb; color: #000;">
												<td><b>Nama Keahilan yang di Kuasai</b></td>
												<td><b>Nilai</b></td>
											</tr>
											<?php while ($pendidikan = $stmt->fetch(PDO::FETCH_LAZY) ) { ?>
												<tr>

													<td><?=$pendidikan['nama_keahlian']?></td>
													<td><?=$pendidikan['nilai']?></td>

												</tr>
												<?php }
											} ?>
										</table>

										<?php 
										$query = "SELECT * FROM tb_info_penghargaan WHERE no_ktp = :ktp";
										$stmt = $config->runQuery($query);
										$stmt->execute(array(':ktp' => $no_ktp));
										if ($stmt->rowCount() < 1) {
			# code...
										}else{

											?>
											<table class="table table-bordered" style="margin-top: 25px;">
												<tr style="background-color: #000; color: #fff;">
													<td colspan="6"><b>Informasi Penghargaan</b></td>
												</tr>
												<tr style="background-color: #ebebeb; color: #000;">
													<td><b>Nama Penghargaan</b></td>
													<td><b>Tingkat</b></td>
													<td><b>Keterangan</b></td>
												</tr>
												<?php while ($pendidikan = $stmt->fetch(PDO::FETCH_LAZY) ) { ?>
													<tr>

														<td><?=$pendidikan['nama_penghargaan']?></td>
														<td><?=$pendidikan['tingkat']?></td>
														<td><?=$pendidikan['keterangan']?></td>

													</tr>
													<?php }
												} ?>
											</table>

											<?php 
											$query = "SELECT * FROM tb_info_kursus WHERE no_ktp = :ktp";
											$stmt = $config->runQuery($query);
											$stmt->execute(array(':ktp' => $no_ktp));
											if ($stmt->rowCount() < 1) {
			# code...
											}else{

												?>
												<table class="table table-bordered" style="margin-top: 25px;">
													<tr style="background-color: #000; color: #fff;">
														<td colspan="6">Informasi Kursus</td>
													</tr>
													<tr style="background-color: #ebebeb; color: #000;">
														<td><b>Bidang Kursus</b></td>
														<td><b>Penyelenggara</b></td>
														<td><b>Tahun Masuk</b></td>
														<td><b>Tahun Lulus</b></td>
													</tr>
													<?php while ($pendidikan = $stmt->fetch(PDO::FETCH_LAZY) ) { ?>
														<tr>

															<td><?=$pendidikan['nama_bidang']?></td>
															<td><?=$pendidikan['nama_penyelenggara']?></td>
															<td><?=$pendidikan['tahun_masuk']?></td>
															<td><?=$pendidikan['tahun_lulus']?></td>

														</tr>
														<?php }
													} ?>
												</table>

											</div>
										</div>

									</body>