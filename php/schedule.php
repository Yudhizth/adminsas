<?php
$sql = "SELECT id, nomor_kontrak, kode_perusahaan, kode_request, kode_plan, type_time, shift_times, penempatan FROM tb_kerjasama_perusahan WHERE nomor_kontrak = :nomorKontrak";
$stmt = $config->runQuery($sql);
$stmt->execute(array(':nomorKontrak' => $_GET['id']));
$info = $stmt->fetch(PDO::FETCH_LAZY);

//show jam kerja berdasarkan wilayah kerja
$lokasi = $info['penempatan'];

$style = '';
if($info['type_time'] == 'shift' && empty($info['shift_times'])) {$style = 'hidden';}

$sql2 = "SELECT id, province_id, name FROM regencies WHERE id IN (". $lokasi .") ";
$stmt2 = $config->runQuery($sql2);
$stmt2->execute();

//jamasuk

$jam = $config->runQuery("SELECT lokasi, jamKerja FROM tb_time WHERE nomor_kontrak = :nomor");
$jam->execute(array(':nomor' => $_GET['id']));

?>
<style>
    .col-lg-2{
        width: 13.8% !important;
    }
</style>
<div class="x_panel">
    <div class="x_title">
        <h2><span class="fa fa-fw fa-list"></span> Schedule Jam Kerja </h2>

        <div class="clearfix"></div>
    </div>
    <div class="x_content">
    <p style="font-weight: 600;" class="text-center h3">Type : <?=$info['type_time']?></p>

        <div class="x_panel" id="scheduleList">
            <div class="x_title">
                <h2><i class="fa fa-map-pin"></i> Penempatan Kerja</h2>
                <button class="btn btn-xs btn-success pull-right doneSchedule" type="button" data-type = "<?=$info['nomor_kontrak']?>">finish!</button>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="x_content">

                    <p class="small">*) give 0 for holiday</p>
                    <?php if($info['type_time'] == 'shift'){  ?>
                        <div class="row <?=empty($info['shift_times'] ) ? '' : 'hidden' ?>">
                            <div class="col-xs-12 col-sm-6 col-lg-6 col-sm-offset-3 col-lg-offset-3">
                                <div class="panel panel-success panel-body">
                                    <form id="formShiftTimes" data-parsley-validate="" novalidate="">
                                        <div class="form-group">
                                            <label for="fullname">Total Shift :</label>
                                            <input type="text" id="countShift" class="form-control"  data-parsley-type="number">
                                            <input type="hidden" id="nomorKontrak" value="<?=$info['nomor_kontrak']?>">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-block btn-primary" style="text-transform: uppercase; font-size: 12px; font-weight: 600;">submit shift</button>
                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="accordion <?=$style?>" id="accordion" role="tablist" aria-multiselectable="true">
                        <?php while ($rows = $stmt2->fetch(PDO::FETCH_LAZY)){ ?>
                        <div class="panel">
                            <a class="panel-heading collapsed" role="tab" id="heading<?=$rows['id']?>" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$rows['id']?>" aria-expanded="false" aria-controls="collapse<?=$rows['id']?>">
                                <h4 class="panel-title"><?=$rows['name']?></h4>
                            </a>
                            <div id="collapse<?=$rows['id']?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$rows['id']?>" aria-expanded="false" style="height: 0px;">
                                <div class="panel-body">
                                    <?php if($info['type_time'] == 'freelance'){
                                        $cols = $jam->fetch(PDO::FETCH_LAZY);
                                        $data = json_decode($cols['jamKerja'], true);
                                        ?>
                                        <small>*) kosongkan apabila libur.</small>
                                        <form method="post" name="formFreelance" data-parsley-validate="" id="formFreelance">
                                            <input type="hidden" value="<?=$rows['id']?>" name="idForm" id="idForm<?=$rows['id']?>">
                                            <input type="hidden" value="<?=$info['type_time']?>" name="typeTimes" id="typeTimes">
                                            <input type="hidden" value="<?=$info['nomor_kontrak']?>" name="nomorKontrak" id="nomorKontrak">
                                            <table class="table table-hover table-resposive">
                                                <thead>
                                                <tr><th>MINGGU</th>
                                                    <th>SENIN</th>
                                                    <th>SELASA</th>
                                                    <th>RABU</th>
                                                    <th>KAMIS</th>
                                                    <th>JUMAT</th>
                                                    <th>SABTU</th>
                                                </tr></thead>
                                                <tbody>
                                                <tr>
                                                    <td width="14.2%">
                                                        <input type="number" class="form-control" name="minggu" placeholder="HH" id="minggu<?=$rows['id']?>" required="">
                                                    </td>
                                                    <td width="14.2%">
                                                        <input type="number" class="form-control" name="senin" placeholder="HH" id="senin<?=$rows['id']?>" required="">
                                                    </td>
                                                    <td width="14.2%">
                                                        <input type="number" class="form-control" name="selasa" placeholder="HH" id="selasa<?=$rows['id']?>" required="">
                                                    </td>
                                                    <td width="14.2%">
                                                        <input type="number" class="form-control" name="rabu" placeholder="HH" id="rabu<?=$rows['id']?>" required="">
                                                    </td>
                                                    <td width="14.2%">
                                                        <input type="number" class="form-control" name="kamis" placeholder="HH" id="kamis<?=$rows['id']?>" required="">
                                                    </td>
                                                    <td width="14.2%">
                                                        <input type="number" class="form-control" name="jumat" placeholder="HH" id="jumat<?=$rows['id']?>" required="">
                                                    </td>
                                                    <td width="14.2%">
                                                        <input type="number" class="form-control" name="sabtu" placeholder="HH" id="sabtu<?=$rows['id']?>" required="">
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <button class="btn btn-block btn-success" type="submit">submit</button>
                                        </form>
                                    <?php } elseif($info['type_time'] == 'shift'){
                                        $shift = $info['shift_times'];
                                        echo '<form id="timeShift" data-parsley-validate="" novalidate="" autocomplete="off">';
                                        for ($i = 1; $i <= $shift; $i++){
                                        ?>
                                            <div class="panel panel-info" style="padding-bottom: 1%;">
                                                <div class="panel-heading">
                                                    <div class="panel-title">Shift <?=$i?></div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row ">

                                                            <input type="hidden" id="noLokasi" value="<?=$rows['id']?>">
                                                            <input type="hidden" value="<?=$info['nomor_kontrak']?>" name="nomorKontrak" id="nomorKontrak">
                                                            <input type="hidden" value="shift_<?=$i?>" name="shiftCode" id="shiftCode">
                                                            <input type="hidden" value="<?=$info['shift_times']?>" name="totalShift" id="totalShift">
                                                            <div class="col-md-1 col-sm-1 col-lg-2 col-xs-6 panel panel-success " >
                                                                <div class="panel-heading">
                                                                    <div class="panel-title">sunday</div>
                                                                </div>
                                                                <div class="panel-body text-center" style="padding: 1px !important;">

                                                                    <div class="form-group">
                                                                        <label for="fullname">IN</label>
                                                                        <input type="text" id="suIn<?=$rows['id']?>_<?=$i?>" class="form-control timepicker"  required="">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="fullname">OUT</label>
                                                                        <input type="text" id="suOut<?=$rows['id']?>_<?=$i?>" class="form-control timepicker"  required="">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 col-sm-1 col-lg-2 col-xs-6 panel panel-success " >
                                                                <div class="panel-heading">
                                                                    <div class="panel-title">monday</div>
                                                                </div>
                                                                <div class="panel-body text-center" style="padding: 1px !important;">

                                                                    <div class="form-group">
                                                                        <label for="fullname">IN</label>
                                                                        <input type="text" id="moIn<?=$rows['id']?>_<?=$i?>" class="form-control timepicker"  required="">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="fullname">OUT</label>
                                                                        <input type="text" id="moOut<?=$rows['id']?>_<?=$i?>" class="form-control timepicker"  required="">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 col-sm-1 col-lg-2 col-xs-6 panel panel-success " >
                                                                <div class="panel-heading">
                                                                    <div class="panel-title">tuesday </div>
                                                                </div>
                                                                <div class="panel-body text-center" style="padding: 1px !important;">

                                                                    <div class="form-group">
                                                                        <label for="fullname">IN</label>
                                                                        <input type="text" id="tuIn<?=$rows['id']?>_<?=$i?>" class="form-control timepicker"  required="">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="fullname">OUT</label>
                                                                        <input type="text" id="tuOut<?=$rows['id']?>_<?=$i?>" class="form-control timepicker"  required="">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 col-sm-1 col-lg-2 col-xs-6 panel panel-success " >
                                                                <div class="panel-heading">
                                                                    <div class="panel-title">wednesday </div>
                                                                </div>
                                                                <div class="panel-body text-center" style="padding: 1px !important;">

                                                                    <div class="form-group">
                                                                        <label for="fullname">IN</label>
                                                                        <input type="text" id="weIn<?=$rows['id']?>_<?=$i?>" class="form-control timepicker"  required="">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="fullname">OUT</label>
                                                                        <input type="text" id="weOut<?=$rows['id']?>_<?=$i?>" class="form-control timepicker"  required="">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 col-sm-1 col-lg-2 col-xs-6 panel panel-success " >
                                                                <div class="panel-heading">
                                                                    <div class="panel-title">thursday </div>
                                                                </div>
                                                                <div class="panel-body text-center" style="padding: 1px !important;">

                                                                    <div class="form-group">
                                                                        <label for="fullname">IN</label>
                                                                        <input type="text" id="thIn<?=$rows['id']?>_<?=$i?>" class="form-control timepicker"  required="">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="fullname">OUT</label>
                                                                        <input type="text" id="thOut<?=$rows['id']?>_<?=$i?>" class="form-control timepicker"  required="">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 col-sm-1 col-lg-2 col-xs-6 panel panel-success " >
                                                                <div class="panel-heading">
                                                                    <div class="panel-title">friday</div>
                                                                </div>
                                                                <div class="panel-body text-center" style="padding: 1px !important;">

                                                                    <div class="form-group">
                                                                        <label for="fullname">IN</label>
                                                                        <input type="text" id="frIn<?=$rows['id']?>_<?=$i?>" class="form-control timepicker"  required="">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="fullname">OUT</label>
                                                                        <input type="text" id="frOut<?=$rows['id']?>_<?=$i?>" class="form-control timepicker"  required="">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 col-sm-1 col-lg-2 col-xs-6 panel panel-success " >
                                                                <div class="panel-heading">
                                                                    <div class="panel-title">saturday</div>
                                                                </div>
                                                                <div class="panel-body text-center" style="padding: 1px !important;">

                                                                    <div class="form-group">
                                                                        <label for="fullname">IN</label>
                                                                        <input type="text" id="saIn<?=$rows['id']?>_<?=$i?>" class="form-control timepicker"  required="">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="fullname">OUT</label>
                                                                        <input type="text" id="saOut<?=$rows['id']?>_<?=$i?>" class="form-control timepicker"  required="">
                                                                    </div>

                                                                </div>
                                                            </div>


                                                    </div>
                                                </div>

                                            </div>
                                    <?php }
                                        echo '<div class="form-group">
                                                                <button class="btn btn-block btn-primary" style="text-transform: uppercase; font-size: 12px; font-weight: 600;">submit shift</button>
                                                            </div>


                                                        </form>';
                                    }else{ ?>
                                            <form id="formKontrak" data-parsley-validate="" autocomplete="off">
                                                <div class="row ">

                                                    <input type="hidden" id="noLokasi" value="<?=$rows['id']?>">
                                                    <input type="hidden" value="<?=$info['nomor_kontrak']?>" name="nomorKontrak" id="nomorKontrak">

                                                    <div class="col-md-1 col-sm-1 col-lg-2 col-xs-6 panel panel-success " >
                                                        <div class="panel-heading">
                                                            <div class="panel-title">sunday</div>
                                                        </div>
                                                        <div class="panel-body text-center" style="padding: 1px !important;">

                                                            <div class="form-group">
                                                                <label for="fullname">IN</label>
                                                                <input type="text" id="suIn<?=$rows['id']?>" class="form-control timepicker" required="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="fullname">OUT</label>
                                                                <input type="text" id="suOut<?=$rows['id']?>" class="form-control timepicker" required="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 col-sm-1 col-lg-2 col-xs-6 panel panel-success " >
                                                        <div class="panel-heading">
                                                            <div class="panel-title">monday</div>
                                                        </div>
                                                        <div class="panel-body text-center" style="padding: 1px !important;">

                                                            <div class="form-group">
                                                                <label for="fullname">IN</label>
                                                                <input type="text" id="moIn<?=$rows['id']?>" class="form-control timepicker" required="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="fullname">OUT</label>
                                                                <input type="text" id="moOut<?=$rows['id']?>" class="form-control timepicker" required="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 col-sm-1 col-lg-2 col-xs-6 panel panel-success " >
                                                        <div class="panel-heading">
                                                            <div class="panel-title">tuesday </div>
                                                        </div>
                                                        <div class="panel-body text-center" style="padding: 1px !important;">

                                                            <div class="form-group">
                                                                <label for="fullname">IN</label>
                                                                <input type="text" id="tuIn<?=$rows['id']?>" class="form-control timepicker" required="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="fullname">OUT</label>
                                                                <input type="text" id="tuOut<?=$rows['id']?>" class="form-control timepicker" required="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 col-sm-1 col-lg-2 col-xs-6 panel panel-success " >
                                                        <div class="panel-heading">
                                                            <div class="panel-title">wednesday </div>
                                                        </div>
                                                        <div class="panel-body text-center" style="padding: 1px !important;">

                                                            <div class="form-group">
                                                                <label for="fullname">IN</label>
                                                                <input type="text" id="weIn<?=$rows['id']?>" class="form-control timepicker" required="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="fullname">OUT</label>
                                                                <input type="text" id="weOut<?=$rows['id']?>" class="form-control timepicker" required="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 col-sm-1 col-lg-2 col-xs-6 panel panel-success " >
                                                        <div class="panel-heading">
                                                            <div class="panel-title">thursday </div>
                                                        </div>
                                                        <div class="panel-body text-center" style="padding: 1px !important;">

                                                            <div class="form-group">
                                                                <label for="fullname">IN</label>
                                                                <input type="text" id="thIn<?=$rows['id']?>" class="form-control timepicker" required="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="fullname">OUT</label>
                                                                <input type="text" id="thOut<?=$rows['id']?>" class="form-control timepicker" required="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 col-sm-1 col-lg-2 col-xs-6 panel panel-success " >
                                                        <div class="panel-heading">
                                                            <div class="panel-title">friday</div>
                                                        </div>
                                                        <div class="panel-body text-center" style="padding: 1px !important;">

                                                            <div class="form-group">
                                                                <label for="fullname">IN</label>
                                                                <input type="text" id="frIn<?=$rows['id']?>" class="form-control timepicker" required="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="fullname">OUT</label>
                                                                <input type="text" id="frOut<?=$rows['id']?>" class="form-control timepicker" required="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 col-sm-1 col-lg-2 col-xs-6 panel panel-success " >
                                                        <div class="panel-heading">
                                                            <div class="panel-title">saturday</div>
                                                        </div>
                                                        <div class="panel-body text-center" style="padding: 1px !important;">

                                                            <div class="form-group">
                                                                <label for="fullname">IN</label>
                                                                <input type="text" id="saIn<?=$rows['id']?>" class="form-control timepicker" required="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="fullname">OUT</label>
                                                                <input type="text" id="saOut<?=$rows['id']?>" class="form-control timepicker" required="">
                                                            </div>

                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn-block btn-primary">submit</button>
                                                </div>
                                            </form>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                </div>


            </div>
        </div>

    </div>
</div>