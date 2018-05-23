<?php
$id = $_SESSION['kode'];
$pwd = $_SESSION['pwd'];
?>
<br/>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-info">
			<div class="panel-body">
				<h4>USERNAME dan PASSWORD login CORPORATE <i><?=$id?></i></h4>
				<hr>
				<br>
				<form class="form-horizontal form-label-left" method="post">
					<div class="form-group row">
						<label class="control-lable col-md-4">USERNAME</label>
						<div class="col-md-8">
							<input type="text" class="form-control" value="<?=$id?>" readonly="readonly">
						</div>
					</div>
					<div class="form-group row">
						<label class="control-lable col-md-4">PASSWORD</label>
						<div class="col-md-8">
							<textarea class="form-control" rows="3" readonly="readonly"><?=$pwd?></textarea>
						</div>
					</div>
				</form>
				<hr>
				<button class="btn btn-sm btn-info pull-right" onclick="myFunction()"  tooltip="print halaman"><span class="fa fa-fw fa-print"></span></button>
				<a href="?p=entry-data">
					<button class="btn btn-success"><span class="fa fa-fw fa-arrow-left"></span> Pull Back</button>
				</a>
			</div>
		</div>
	</div>
</div>

<script>
function myFunction() {
    window.print();
}
</script>
