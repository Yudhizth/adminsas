<?php

    $record_lokers = '5';
    $query = "SELECT * FROM tb_artikel ORDER BY modif_artikel DESC";
    $lokers = $config->paging($query, $record_lokers);
    $lokers = $config->runQuery($lokers);
    $lokers->execute();
?>
<div class="x_panel">
    <div class="x_content hidden" id="artikel-form">
        <div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2 col-xs-12" style="padding: 1%; border: 2px solid #ebebeb; border-radius: 1%;">

            <div class="x_title">
                <h2>Form Artikel</h2>

                <div class="clearfix"></div>
            </div>
            <!-- start form for validation -->
            <form id="form-loker" data-parsley-validate="" action="php/ajx/actArtikel.php" method="post" enctype="multipart/form-data">
                <label for="fullname">Judul Artikel * :</label>
                <input type="text" id="txtJudul" class="form-control" name="txtJudul" required="">
                <input type="hidden" id="txtKategori" class="form-control" name="txtKategori" value="1">
                <br>
                <label for="requirement">Kategori Artikel *</label>
                <input type="text" id="kategoriArtikel" class="form-control" name="kategoriArtikel" required="">
                <br>
                <label for="requirement">Isi Artikel *</label>
                <textarea id="isiArtikel" name="isiArtikel" class="form-control" required></textarea>
                <br>
                <label for="salary">Images</label>
                <input type="file" id="imagesArtikel" name="txtImages" class="form-control" required="">

                <br>

                <button class="btn btn-block btn-primary" name="saveArtikel" type="submit">Submit</button>
            </form>
            <!-- end form for validations -->
        </div>

    </div>

    <div id="conten-artikel">
        <div class="x_title">
            <h2>List Posting Artikel</h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content" >
            <button class="btn btn-primary btn-sm" onclick="formArtikel()"><span class="fa fa-fw fa-plus"></span> Add Artikel</button>

            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action" id="listLoker">
                    <thead>
                    <tr class="headings">
                        <th class="column-title" style="display: table-cell;">Artikel </th>
                        <th class="column-title" style="display: table-cell;">Kategori </th>
                        <th class="column-title" style="display: table-cell;">Isi Artikel </th>
                        <th class="column-title" style="display: table-cell;">Images </th>
                        <th class="column-title" style="display: table-cell;">Status </th>
                        <th class="column-title" style="display: table-cell;">Created_at </th>
                        <th class="column-title" style="display: table-cell;">Modif_at </th>
                        <th class="column-title" style="display: table-cell;">Created_by</th>
                        <th class="column-title no-link last" style="display: table-cell;"><span class="nobr">Action</span>
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php if($lokers->rowCount() > 0 ){
                        while ($loker = $lokers->fetch(PDO::FETCH_LAZY)){
                            $artikel = $loker['isi_artikel'];
                            ?>
                            <tr class="even pointer" style="text-transform: capitalize;">

                                <td width="8%"><?=$loker['nama_artikel']?></td>
                                <td width="8%"><?=$loker['slug']?></td>
                                <td width="16%"><?=$loker['isi_artikel']?></td>
                                <td width="20%">
                                    <img src="http://db.sinergiadhikarya.co.id/artikel/<?=$loker['images_artikel']?>" width="50%">
                                </td>
                                <td width="8%"><?=$loker['active_artikel']?></td>
                                <td width="10%"><?=$loker['create_artikel']?></td>
                                <td width="8%"><?=$loker['modif_artikel']?></td>
                                <td width="10%" style="font-style: italic; font-size: 12px; font-weight: 600;"><?=$loker['nama_user']?></td>
                                <td width="8%">
<!--                                    <button class="btn btn-xs btn-primary editLoker"-->
<!--                                            data-id="--><?//=$loker['id_loker']?><!--"-->
<!--                                            data-judul="--><?//=$loker['judul_loker']?><!--"-->
<!--                                            data-desc="--><?//=$loker['job_description']?><!--"-->
<!--                                            data-req="--><?//=$loker['requirements']?><!--"-->
<!--                                            data-salary="--><?//=$loker['salary_loker']?><!--"-->
<!--                                            data-area="--><?//=$loker['area_loker']?><!--"-->
<!--                                            data-pengalaman="--><?//=$loker['minpengalaman_loker']?><!--"-->
<!--                                    ><span class="fa fa-pencil-square-o"></span>  Edit</button>-->
                                    <button class="btn btn-xs btn-danger" onclick= "delArtikel(<?=$loker['id_artikel']?>)"><span class="fa fa-trash"></span>  Delete</button>
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
