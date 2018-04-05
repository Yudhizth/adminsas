<?php

$record_log = '10';
$query = "SELECT tb_log_event.id, tb_log_event.id_reff,tb_log_event.types, tb_log_event.tables, tb_log_event.ket, tb_log_event.admin_id, tb_log_event.created_at, tb_admin.username, tb_admin.nama_admin FROM tb_log_event
INNER JOIN tb_admin ON tb_admin.id = tb_log_event.admin_id
ORDER BY tb_log_event.created_at DESC";
$lokers = $config->paging($query, $record_log);
$lokers = $config->runQuery($lokers);
$lokers->execute();
?>
<div class="x_panel">

    <div id="conten-loker">
        <div class="x_title">
            <h2>Log users</h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content" >
            <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action" id="listLoker">
                    <thead>
                    <tr class="headings">
                        <th class="column-title" style="display: table-cell;">Log user </th>
                        <th class="column-title" style="display: table-cell;">type </th>
                        <th class="column-title" style="display: table-cell;">Keterangan </th>
                        <th class="column-title" style="display: table-cell;">Users </th>
                        <th class="column-title" style="display: table-cell;">created_at </th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php if($lokers->rowCount() > 0 ){
                        while ($loker = $lokers->fetch(PDO::FETCH_LAZY)){
                            if($loker['types'] == '2'){
                                $title = "Akses Page";
                            }else{
                                $title = "Function";
                            }
                            switch ($loker['types']) {
                                case '1':
                                    $type = '<label class="label label-sm label-primary">Created</label>';
                                    break;
                                case '2':
                                    $type = '<label class="label label-sm label-info">Read</label>';
                                    break;
                                case '3':
                                    $type = '<label class="label label-sm label-success">Update</label>';
                                    break;
                                case '4':
                                    $type = '<label class="label label-sm label-danger">Deleted</label>';
                                    break;
                                default:
                                    $type = '<label class="label label-sm label-warning">unset</label>';
                                    break;
                                }
                            ?>
                            <tr class="even pointer" style="text-transform: capitalize;">

                                <td width="8%"><?=$title?></td>
                                <td width="8%"><?=$type?></td>
                                <td width="16%"><?=$loker['ket']?></td>
                                <td width="20%"><?=$loker['nama_admin']?></td>
                                <td width="8%"><?=date('d-m-Y H:m:s', strtotime($loker['created_at']))?></td>

                            </tr>
                        <?php  }
                    }else{} ?>
                    </tbody>
                </table>

                <?php $pages = $config->paginglink($query, $record_log); ?>
            </div>
        </div>
    </div>
</div>
