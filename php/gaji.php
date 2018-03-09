<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 06/03/2018
 * Time: 12.52
 */
$sql = "SELECT * FROM tb_kode_bank";

$stmt = $config->runQuery($sql);
$stmt->execute();

?>


<div id="list-gaji"></div>
<div id="list-bank">
    <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-4 col-sm-offset-4">
        <div class="x_panel">
            <div class="x_title">
                <h2 style="text-align: center; float: unset!important;">==SELECT BANK==</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="formSelectBank" data-parsley-validate="" novalidate="">
                    <div class="form-group">

                        <select class="form-control" id="listBank" required="">
                            <option value="">Choose option</option>
                            <?php while ($row = $stmt->fetch(PDO::FETCH_LAZY)){ ?>
                                <option value="<?=$row['kd_bank']?>"><?=$row['nama_bank']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-block btn-primary buttooom" style="text-transform: uppercase; font-size: 12px; font-weight: 600;">add request</button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
