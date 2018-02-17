<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 06/02/2018
 * Time: 14.36
 */

if(@$_GET['type'] == 'show'){
    $username = $_GET['username'];
    $roles    = $_GET['roles'];

    echo $username . ' : ' .$roles;
}else{

$sql = "SELECT tb_admin.id, tb_admin.username, tb_admin.nama_admin, tb_admin.jabatan, tb_admin.id_role, roles.name, roles.description FROM tb_admin
        INNER JOIN roles ON roles.id = tb_admin.id_role";
$stmt = $config->runQuery($sql);
$stmt->execute();

?>

<div class="x_panel" id="contentPrevillage">
    <div class="x_title">
        <h2>Previllage USER </h2>
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
    <div class="x_content" id="previllage">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="listPrevillage">
                <table class="table table-bordered table-hover">
                    <thead>
                    <th>Nama USER</th>
                    <th>Nama USER</th>
                    <th>Title USER</th>
                    <th>USER Roles</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                    <?php while ($row = $stmt->fetch(PDO::FETCH_LAZY)){ ?>
                        <tr>
                            <td><?=$row['username']?></td>
                            <td><?=$row['nama_admin']?></td>
                            <td><?=$row['jabatan']?></td>
                            <td><?=$row['name']?></td>
                            <td>
                                <button type="button" data-toggle="tooltip"
                                        data-roles="<?=$row['id_role']?>"
                                        data-username="<?= $row['id'] ?>" data-placement="right"
                                        title="Show Previllage"
                                        class="btn btn-info btn-xs showUserPrevillage">
                                    <i class="fa fa-fw fa-search"> </i>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
} ?>



<div class="x_panel" id="showPrevillage">

</div>
