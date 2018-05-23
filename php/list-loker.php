<?php

    $record_lokers = '2';
    $query = "SELECT * FROM tb_loker ORDER BY create_loker DESC";
    $lokers = $config->paging($query, $record_lokers);
    $lokers = $config->runQuery($lokers);
    $lokers->execute();
?>
<div class="x_panel">
    <div class="x_content " id="form-loker">
        <div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2 col-xs-12" style="padding: 1%; border: 2px solid #ebebeb; border-radius: 1%;">

            <div class="x_title">
                <h2>Form Loker</h2>

                <div class="clearfix"></div>
            </div>
            <!-- start form for validation -->
            <form id="form-loker" data-parsley-validate="" method="post" action="php/ajx/actLoker.php">
                <label for="fullname">Judul Loker * :</label>
                <input type="text" id="txtJudul" class="form-control" name="txtJudul" required="">
                <input type="hidden" id="txtKategori" class="form-control" name="txtKategori" value="1">
                <input type="hidden" id="txtID" class="form-control" name="txtID" >
                <br>
                <label for="requirement">Jobs Desc *</label>
                <textarea id="jobsDesc" name="jobsDesc" class="form-control" required></textarea>
                <br>
                <label for="requirement">Requirement *</label>
                <textarea id="reqLoker" name="reqLoker" class="form-control" required></textarea>
                <br>
                <label for="salary">Salary</label>
                <input type="text" id="txtSalary" name="txtSalary" class="form-control" required="">
                <br>
                <label for="salary">Area Jobs</label>
                <input type="text" id="txtArea" name="txtArea" class="form-control" required="">
                <br>
                <label for="salary">Pengalaman Min.</label>
                <select name="txtPengalaman" id="txtPengalaman" class="form-control" required>
                    <option value="">--pengalaman--</option>
                    <option value="0">Fresh Graduate</option>
                    <option value="1">1 Tahun</option>
                    <option value="2">2 Tahun</option>
                    <option value="3">3 Tahun</option>
                    <option value="4">4 Tahun</option>
                    <option value="5">5 Tahun</option>
                </select>

                <br>

                <button class="btn btn-block btn-primary" name="saveLoker" type="submit">Submit</button>
            </form>
            <!-- end form for validations -->
        </div>

    </div>

    <div id="conten-loker">
        <div class="x_title">
            <h2>List Posting Lowongan Kerja</h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content" >
            <button class="btn btn-primary btn-sm addLoker"><span class="fa fa-fw fa-plus"></span> Add Loker</button>

            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action" id="listLoker">
                    <thead>
                    <tr class="headings">
                        <th class="column-title" style="display: table-cell;">Loker </th>
                        <th class="column-title" style="display: table-cell;">Kategori </th>
                        <th class="column-title" style="display: table-cell;">Jobs Desc </th>
                        <th class="column-title" style="display: table-cell;">Requirement </th>
                        <th class="column-title" style="display: table-cell;">Salary </th>
                        <th class="column-title" style="display: table-cell;">Area </th>
                        <th class="column-title" style="display: table-cell;">Min. </th>
                        <th class="column-title" style="display: table-cell;">Posted</th>
                        <th class="column-title no-link last" style="display: table-cell;"><span class="nobr">Action</span>
                        </th>
                        <th class="bulk-actions" colspan="7" style="display: none;">
                            <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt">1 Records Selected</span> ) <i class="fa fa-chevron-down"></i></a>
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php if($lokers->rowCount() > 0 ){
                        while ($loker = $lokers->fetch(PDO::FETCH_LAZY)){
                            if($loker['minpengalaman_loker'] == 0){
                                $pengalaman = "<span class='label label-warning'>Fresh Graduate</span>";
                            }
                            else{
                                $pengalaman = "<span class='label label-success'>". $loker['minpengalaman_loker'] ." tahun </span>";
                            }
                            if(strlen($loker['requirements'] ) > 550 ){
                                $req = substr($loker['requirements'], 0, 550) . '.....';
                            }else{
                                $req = $loker['requirements'];
                            }
                            ?>
                            <tr class="even pointer" style="text-transform: capitalize;">

                                <td width="8%"><?=$loker['judul_loker']?></td>
                                <td width="8%"><?=$loker['id_kategori']?></td>
                                <td width="16%"><?=$loker['job_description']?></td>
                                <td width="20%"><?=$req?></td>
                                <td width="8%"><?=$loker['salary_loker']?></td>
                                <td width="10%"><?=$loker['area_loker']?></td>
                                <td width="8%"><?=$pengalaman?></td>
                                <td width="10%" style="font-style: italic; font-size: 12px; font-weight: 600;"><?=date('d M Y H:m', strtotime($loker['create_loker']))?></td>
                                <td width="8%">
                                    <button class="btn btn-xs btn-primary editLoker"
                                            data-id="<?=$loker['id_loker']?>"
                                            data-judul="<?=$loker['judul_loker']?>"
                                            data-desc="<?=$loker['job_description']?>"
                                            data-req="<?=$loker['requirements']?>"
                                            data-salary="<?=$loker['salary_loker']?>"
                                            data-area="<?=$loker['area_loker']?>"
                                            data-pengalaman="<?=$loker['minpengalaman_loker']?>"
                                    ><span class="fa fa-pencil-square-o"></span>  Edit</button>
                                    <button class="btn btn-xs btn-danger removeLoker" data-id="<?=$loker['id_loker']?>"><span class="fa fa-trash"></span>  Delete</button>
                                </td>

                            </tr>
                        <?php  }
                    }else{} ?>
                    </tbody>
                </table>

                <?php $pages = $config->paginglink($query, $record_lokers); ?>
            </div>
        </div>
    </div>
</div>
