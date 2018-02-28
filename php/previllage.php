<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 06/02/2018
 * Time: 14.36
 */

$id = $_GET['user'];

if(isset($_POST['addSubcategori'])){
    $admin = $_POST['id_admin'];
    $sub = $_POST['listSubcategori'];

    $inputData = "INSERT INTO tb_previllage ( id_subcategory, id_admin ) VALUE (:a, :b)";
    $input = $config->runQuery($inputData);
    $input->execute(array(
            ':a' =>$sub,
            ':b' =>$admin
    ));

    if($input){
        echo "<script>
            alert('Berhasil ditambahkan!');
            window.location.href='?p=previllage&user=".$admin."';
            </script>";
    }else{
        echo "gagal tambah";
    }
}




if(@$_GET['type'] == 'show'){
    $username = $_GET['username'];
    $roles    = $_GET['roles'];

    echo $username . ' : ' .$roles;
}else{

$sql = "SELECT tb_admin.id, tb_admin.username, tb_admin.nama_admin, tb_admin.jabatan, tb_admin.id_role, roles.name, roles.description FROM tb_admin
        INNER JOIN roles ON roles.id = tb_admin.id_role WHERE tb_admin.id = :admin";
$stmt = $config->runQuery($sql);
$stmt->execute(array(
        'admin'    => $id
));

    $stmt2 = $config->runQuery($sql);
    $stmt2->execute(array('admin'   => $id));

    $data = $stmt2->fetch(PDO::FETCH_LAZY);

    $a = "SELECT * FROM tb_category INNER JOIN tb_staff ON tb_staff.id_category = tb_category.id_category
          WHERE tb_staff.id_roles = :id";
    $a = $config->runQuery($a);
    $a->execute(array( 'id' => $data['id_role']));

    $query = "SELECT tb_subcategory.id_category, tb_subcategory.id_subcategory, tb_subcategory.name_sub, tb_category.name, tb_staff.id_category, tb_staff.id_roles, tb_admin.id_role FROM tb_subcategory
INNER JOIN tb_category ON tb_category.id_category = tb_subcategory.id_category
INNER JOIN tb_staff ON tb_staff.id_category=tb_category.id_category
INNER JOIN tb_admin ON tb_admin.id_role=tb_staff.id_roles

WHERE tb_staff.id_roles = :roless
GROUP BY tb_subcategory.id_subcategory
";

    $list = $config->runQuery($query);
    $list->execute(array('roless' => $data['id_role']));


    ?>
    <style type="text/css">
        .panel-primary{
            border-color: rgba(52,152,219,.88)!important;
        }

        .panel-primary>.panel-heading{
            background-color: rgba(52,152,219,.88) !important;
            color: #fff !important;
            border-color: rgba(52,152,219,.88) !important;
        }

        .panel-warning{
            border-color: rgba(243,156,18,.88) !important;
        }

        .panel-warning>.panel-heading{
            background-color: rgba(243,156,18,.88) !important;
            color: #fff !important;
            border-color: rgba(243,156,18,.88) !important;
        }
        .panel-danger{
            border-color: rgba(231,76,60,.88) !important;
        }

        .panel-danger>.panel-heading{
            background-color: rgba(231,76,60,.88) !important;
            color: #fff !important;
            border-color: rgba(231,76,60,.88) !important;
        }
        ul.to_do p{
            color: #fff;
            text-transform: capitalize;
            font-size: 14px;
            padding: 0.1% 4% !important;
        }
    </style>

<div class="x_panel" id="contentPrevillage">
    <div class="x_title">
        <h2>Previllage USER <small><?=$data['nama_admin']?></small></h2>
        <ul class="nav navbar-right panel_toolbox">
            <li >
                <button type="button" class="btn btn-xs btn-default" data-toggle="modal" data-target=".addPrevillage"><span class="fa fa-fw fa-plus"></span> add</button>
            </li>

        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content" id="previllage">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="contentISI">

                <div class="x_content" id="previllage">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <?php while ($category = $a->fetch(PDO::FETCH_LAZY)){


                                if($category['id_category'] == '1'){
                                    $panel = "primary";
                                    $label = "background: #4ca4df; !imporant";
                                }elseif($category['id_category'] == '2'){
                                    $panel = "warning";
                                    $label = "background: #f4a82e; !imporant";
                                }else{
                                    $panel = "danger";
                                    $label = "background: #ea6153; !imporant";
                                }
                                $b = "SELECT tb_category.id_category, tb_category.name, tb_subcategory.id_subcategory, tb_subcategory.name_sub, tb_subcategory.link, tb_subcategory.icon, tb_previllage.id_admin FROM tb_subcategory
INNER JOIN tb_category ON tb_category.id_category = tb_subcategory.id_category
INNER JOIN tb_previllage ON tb_previllage.id_subcategory = tb_subcategory.id_subcategory
WHERE tb_category.id_category = :id AND tb_previllage.id_admin = :admin";
                                $stmt = $config->runQuery($b);

                                $stmt->execute(array(
                                    ':id'   => $category['id_category'],
                                    ':admin'=>$id
                                ));
                                ?>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="panel panel-<?=$panel?>">
                                        <div class="panel-heading">
                                            <h3 style="text-transform: capitalize;"><?=$category['name']?></h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="x_content">

                                                <div class="">
                                                    <ul class="to_do">
                                                        <?php while ($sub = $stmt->fetch(PDO::FETCH_LAZY)){ ?>
                                                            <li style="<?=$label?> color: #fff!important;">
                                                                <p>
                                                                    <?=$sub['name_sub']?>
                                                                </p>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
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
</div>
<?php
} ?>


<div class="modal fade addPrevillage" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-body">

                <form class="form-horizontal" method="post">
                    <div class="form-group">
                        <input type="hidden" value="<?=$data['id']?>" name="id_admin">
                        <select name="listSubcategori" class="form-control">
                            <?php while ($col = $list->fetch(PDO::FETCH_LAZY)){ ?>
                            <option value="<?=$col['id_subcategory']?>"><?=$col['name_sub']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button class="btn btn-block btn-success" name="addSubcategori">simpan</button>
                </form>
            </div>

        </div>
    </div>
</div>
